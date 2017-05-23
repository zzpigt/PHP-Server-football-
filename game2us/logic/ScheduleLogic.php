<?php
include_once(APP_LOGIC_PATH."LeagueLogic.php");
include_once(APP_LOGIC_PATH."FightRoomsLogic.php");
include_once(APP_MODEL_PATH."LeagueScheduleModel.php");
/**
 * @date: 2017年4月25日 上午10:52:20
 * @author: meishuijing
 * @desc: 
 */
class ScheduleLogic
{
	private $_userId = 0;
	
	function init($userId)
	{
		$this->_userId = $userId;
		
		return true;
	}
	
	function getSchedule($week)
	{
		$leagueLogic = new LeagueLogic();
		if(!$leagueLogic || !$leagueLogic->init($this->_userId))
			return null;
		
		$weekInfo = self::getLeagueWeek();
		if($week == null)
		{
			$week = $weekInfo["curWeek"];
		}
		
		$round = Array();
		if(isset($weekInfo["weeks"][$week]))
		{
			foreach ($weekInfo["weeks"][$week] as $v)
				$round[] = $v;
		}
		
		$leagueSchedule = $leagueLogic->getLeagueSchedule($round, $this->_userId);
		
		
		return array("week"=>$week, "leagueSchedule"=>$leagueSchedule);
	}
	
	function isLocked($roomId)
	{
		$_leagueIndex = LeagueLogic::getLeagueIndex();
		$isLocked = LeagueScheduleModel::isLockedByRoom($roomId, $_leagueIndex);
		if($isLocked)
		{
			if($isLocked[0]["islocked"] == 1)
				return true;
		}
		return false;
	}
	
	function modifySchedule($roomId, $startTime)
	{
		$_leagueIndex = LeagueLogic::getLeagueIndex();
		$res = LeagueScheduleModel::updateStartTimeByRoom($roomId, $startTime, $_leagueIndex);
		if($res)
		{
			$res = LeagueScheduleModel::queryByRoom($roomId, $_leagueIndex);
			if($res)
			{
				$fightRoomLogic = new FightRoomsLogic();
				if($fightRoomLogic)
				{
					if($fightRoomLogic->init($res[0]["leaguer1"], $res[0]["leaguer2"]))
					{
						$index = $fightRoomLogic->getModel()->getRoomIndex($roomId);
						$fightRoomLogic->getModel()->setFieldByIndex(DATA_BASE_FIGHTROOMS_STARTTIME, $startTime, $index);
						$fightRoomLogic->updateFightRoomsData($roomId, $index);
						
						$param["callBack"] = "LeagueLogic::callBack";
						$param["param"] = Array("data"=>array($res[0]["leagueid"],$res[0]["round"],$res[0]["no"], $res[0]["leaguer1"], LeagueLogic::getLeagueIndex()), "type"=>LEAGUE_CALL_BACK_TYPE_BEGIN);
						$fightRoomLogic->bespeakFight($roomId, $startTime, $param);
					}
				}
			}
			else
			{
				$_info = array();
				$_info["roomid"] = $roomId;
				$_info["leagueIndex"] = $_leagueIndex;
				writeLog(LOG_LEVEL_DEBUG, $_info, __LINE__);
			}
		}
		else
		{
			$_info = array();
			$_info["roomid"] = $roomId;
			$_info["leagueIndex"] = $_leagueIndex;
			writeLog(LOG_LEVEL_DEBUG, $_info, __LINE__);
		}
		
	}
	
	function lockSchedule($roomId)
	{
		$_leagueIndex = LeagueLogic::getLeagueIndex();
		$res = LeagueScheduleModel::updateLockByRoom($roomId, $_leagueIndex);
	}
	
	function getTimeList($userId, $roomId, &$timeList)
	{
		$startTime = FightRoomsModel::getRoomStartTime($userId, $roomId);
		if(!$startTime)
		{
			return false;
		}
		
		$startTime = $startTime[0]["startTime"];
		$startRang = $startTime;
		$endRang = $startRang + 24 * 3600;
		$homeUserId = $startTime[0]["homeUserId"];
		$awayUserId = $startTime[0]["awayUserId"];
		
		if(time() < $startTime && time() + 1800 < $startTime)
		{
			$invalidTimeList = FightRoomsModel::getInvalidTimeList($userId, $startRang, $endRang, $homeUserId, $awayUserId);
			foreach ($invalidTimeList as $v)
			{
				$timeList[] = intval($v["startTime"]);
			}
		}
		else
		{
			return false;
		}
		
		return true;
	}
	
	/**
	 * @date : 2017年4月25日 下午1:51:47
	 * @author : meishuijing
	 * @param : 
	 * @return : 
	 * @desc : 获取联赛周划分的情况
	 */
	static function getLeagueWeek()
	{
		$weekArr = Array();
	
		$curWeek = 1;
		$start = XmlConfigMgr::getInstance()->getStaticConfig()->getConfig("startgame");
		$leagueDays = XmlConfigMgr::getInstance()->getStaticConfig()->getConfig("leaguedays");
		if($start && $leagueDays)
		{
			$week = 1;
			for($i = 0; $i < $leagueDays; $i++)
			{
				$oneDay = date("Y/m/d", strtotime("+".$i." day", strtotime($start)));
	
				if($oneDay == date("Y/m/d"))
					$curWeek = $week;
	
				$weekArr[$week][] = $i + 1;
				if($i % 7 == 6)
					$week++;
			}
		}
	
		return array("curWeek"=>$curWeek, "weeks"=>$weekArr);
	}
}