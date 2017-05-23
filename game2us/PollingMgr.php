<?php

define("POLLING_TYPE_TIMEING", 1);//定时调用的任务
define("POLLING_TYPE_ALWAYS", 2);//一直存在不删除的任务

define("POLLING_MAX", 10000);//环的大小
define("POLLING_PUSH_LOCK", "pollingPush.lock");



//事件环
class PollingMgr
{
	private $__Polling_Push_Cur = 1;//进的游标
	private $__Polling_Pop_Cur = 1;//出的游标
	
	
	
	private function init()
	{
		if(MemInfoLogic::Instance()->getMemData(POLLING_PUSH_CUR))
			$this->__Polling_Push_Cur = MemInfoLogic::Instance()->getMemData(POLLING_PUSH_CUR);
		
		if(MemInfoLogic::Instance()->getMemData(POLLING_POP_CUR))
			$this->__Polling_Pop_Cur = MemInfoLogic::Instance()->getMemData(POLLING_POP_CUR);
	}
	
	private function writeLog($data, $path = 'PollingDebug.txt')
	{
		return;
		$_txt = "[LOG]\t";
		$_txt .= "[".date('y-m-d h:i:s',time())."]\t";
		$_txt .= print_r($data, true);
		$_txt .= "\r\n";
		file_put_contents($path, $_txt, FILE_APPEND);
	}
	
	public function Clear()
	{
		MemInfoLogic::Instance()->setMemData(POLLING_PUSH_CUR, 1);
		MemInfoLogic::Instance()->setMemData(POLLING_POP_CUR, 1);
		MemInfoLogic::Instance()->setMemData("POLLING_1", null);
	}
	
	/**
	 * @date : 2017年5月2日 下午2:20:36
	 * @author : meishuijing
	 * @param :  type 表示轮询类型  callback 为回调的静态函数 param 为回调函数的参数  time 在type=1时表示触发时间, type=2时表示间隔时间
	 * @return : true or false 是否成功
	 * @desc : 轮询池的事件推入方法
	 */
	public function PollingPush($type, $callBack, $param, $time, $pollTime = null)
	{
		$f = fopen(POLLING_PUSH_LOCK, 'w+');
		if(!$f)
			return false;
		$lock = flock($f, LOCK_EX | LOCK_NB);
		
		$i = 0;
		while(!$lock)
		{
			$i++;
			if($i > 10000)
			{
				$this->writeLog("PollingPush lock");
				return false;
			}

			$lock = flock($f, LOCK_EX | LOCK_NB);
			usleep(1000);
		}
		
		//MemInfoLogic::Instance()->getMemData(POLLING_PUSH_CUR)
		$this->init();
		
		if($type != POLLING_TYPE_TIMEING && $type != POLLING_TYPE_ALWAYS)
		{
			fclose($f);
			return false;
		}
		
		if(!is_string($callBack) || !is_array($param) || !is_int($time))
		{
			fclose($f);
			$this->writeLog("PollingPush is_ error");
			return false;
		}
			
		if($this->__Polling_Push_Cur == $this->__Polling_Pop_Cur && !empty(MemInfoLogic::Instance()->getMemData("POLLING_".$this->__Polling_Push_Cur)))
		{
			//当前环已经满了，无法进
			fclose($f);
			$this->writeLog("PollingPush pool full");
			return false;
		}
			
		$event = array(
				"type" => $type,
				"callBack" => $callBack,
				"param" => $param,
				"time" => $time,
				"pollTime" => $pollTime,
		);
			
			
		if(!MemInfoLogic::Instance()->setMemData("POLLING_".$this->__Polling_Push_Cur, $event))
		{
			fclose($f);
			$this->writeLog("PollingPush setMemData failed");
			return false;
		}
			
		$this->__Polling_Push_Cur++;
		if($this->__Polling_Push_Cur > POLLING_MAX)
			$this->__Polling_Push_Cur = 1;
			
		MemInfoLogic::Instance()->setMemData(POLLING_PUSH_CUR, $this->__Polling_Push_Cur);
		fclose($f);
		return true;
	}
	
	private function PollingPop()
	{
		$f = fopen(POLLING_PUSH_LOCK, 'w+');
		if(!$f)
			return false;
		$lock = flock($f, LOCK_EX | LOCK_NB);
		
		$i = 0;
		while(!$lock)
		{
			$i++;
			if($i > 10000)
			{
				$this->writeLog("PollingPop lock");
				return null;
			}


			$lock = flock($f, LOCK_EX | LOCK_NB);
			usleep(1000);
		}
		
		$this->init();
		
		if($this->__Polling_Push_Cur == $this->__Polling_Pop_Cur && empty(MemInfoLogic::Instance()->getMemData("POLLING_".$this->__Polling_Push_Cur)))
		{
			//当前环已经空了，无法出
			fclose($f);
			$this->writeLog("PollingPush pool empty");
			return null;
		}
		
		$event = MemInfoLogic::Instance()->getMemData("POLLING_".$this->__Polling_Pop_Cur);
		
		if($event)
		{
			MemInfoLogic::Instance()->setMemData("POLLING_".$this->__Polling_Pop_Cur, null);
			
		}
		$this->__Polling_Pop_Cur++;
		if($this->__Polling_Pop_Cur > POLLING_MAX)
			$this->__Polling_Pop_Cur = 1;
			
		MemInfoLogic::Instance()->setMemData(POLLING_POP_CUR, $this->__Polling_Pop_Cur);

		fclose($f);
		$this->writeLog("PollingPop  success");
		return $event;
	}
	
	public function PollingRun()
	{
		while(1)
		{
			$this->writeLog("PollingRun is_ success");
			$i = 10;
			while( $i > 0)
			{
				$event = $this->PollingPop();
				if($event)
				{
					$this->writeLog($event);
					if($event["type"] == POLLING_TYPE_TIMEING)
					{
						if($event["time"] <= time() )
						{
							call_user_func($event["callBack"], $event["param"]);
						}
						else
						{
							$this->PollingPush($event["type"], $event["callBack"], $event["param"], $event["time"]);
						}
					}
					else if($event["type"] == POLLING_TYPE_ALWAYS)
					{
						if($event["pollTime"] + $event["time"] <= time() )
						{
							call_user_func($event["callBack"], $event["param"]);
							$this->PollingPush($event["type"], $event["callBack"], $event["param"], $event["time"]);
						}
						else
							$this->PollingPush($event["type"], $event["callBack"], $event["param"], $event["time"], $event["pollTime"]);
					}
				}
				
				$i--;
			}
			echo time()."\r\n";
			usleep(1000000);
		}
	}
}
