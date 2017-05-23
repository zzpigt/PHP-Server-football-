<?php

/**
 * @date: 2017年3月30日 下午6:10:33
 * @author: meishuijing
 * @desc: 联赛逻辑
 */	
include_once(APP_LOGIC_PATH."PlayerLogic.php");
include_once(APP_MODEL_PATH."PlayerModel.php");
include_once(APP_MODEL_PATH."LeagueModel.php");
include_once(APP_MODEL_PATH."LeagueRankModel.php");
include_once(APP_MODEL_PATH."LeagueScheduleModel.php");
include_once(APP_MODEL_PATH."LeagueFootballerRankModel.php");
include_once(APP_LOGIC_PATH."RobotLogic.php");
include_once(APP_LOGIC_PATH."fightRoomsLogic.php");

define("LEAGUE_CALL_BACK_TYPE_SETTLE", 1);//结算的通知
define("LEAGUE_CALL_BACK_TYPE_BEGIN", 2);//比赛开始的通知
define("LEAGUE_CALL_BACK_TYPE_STATISTICS", 3);//比赛数据统计
define("LEAGUE_CALL_BACK_TYPE_END", 4);//比赛结束的通知

class LeagueLogic
{
	private $_userId;
	private $_leagueId;
	private $_leagueModel;
	
	private $_leaguer = Array();//创建时
	
	/**
	 * @date : 2017年4月17日 下午4:10:20
	 * @author : meishuijing
	 * @param : 
	 * @return : 
	 * @desc : 在玩家创建之后，每次调用此函数进行联赛拉取
	 */
	function init($userId)
	{
		
		if(!isset($userId))
			return false;
			
		$this->_userId = $userId;
		
		/**
		 * 找到玩家对应的联萌组，如果不存在，则需要分配到一个已创建的联萌组中
		 */
		$player = new PlayerModel();
		if(!$player || !$player->init($userId))
		{
			return false;
		}
		$this->_leagueId = $player->getFieldByIndex(DATA_BASE_PLAYER_LEAGUERID);
		if(!$this->_leagueId)
			return false;
			
		/*$this->_leagueModel = new LeagueModel();
		if(!$this->_leagueModel || !$this->_leagueModel->init($this->_leagueId))
			return false;*/
		$leagueModel = LeagueModelMgr::Instance()->getModelList( LEAGUE_MODEL_DEFAULT,array($this->_leagueId));
		if(empty($leagueModel))
		{
			return false;
		}

		return true;
	}
	
	/**
	 * @date : 2017年4月17日 下午3:06:22
	 * @author : meishuijing
	 * @param : 
	 * @return : 
	 * @desc : 特殊处理玩家注册时，分配机器人id给玩家，替换成真实玩家数据
	 */
	function robot2User()
	{
		/**
		 * 特殊处理，这边是用户注册时，开始分配机器人id
		 */
		if(!$this->allocLeague())
			return null;
		
		return $this->joinLeague();
	}
	
	/**
	 * @date : 2017年4月18日 下午6:15:13
	 * @author : meishuijing
	 * @param : 
	 * @return : 
	 * @desc : 大量生成
	 */
	function massGenerate($large)
	{
		for($i = 0; $i < $large; $i++)
			$this->createRobotLeague();
	}
	
	/**
	 * @date : 2017年4月17日 下午3:39:30
	 * @author : meishuijing
	 * @param : 
	 * @return : true 表示分配到了联赛id false 分配失败
	 * @desc : 获取某个可以分配的联赛组中
	 */
	private function allocLeague()
	{
		$this->_leagueId = MemInfoLogic::Instance()->getMemData(LEAGUE_CUR_GROUP);
		if($this->_leagueId)
		{
			/*$this->_leagueModel = new LeagueModel();
			if(!$this->_leagueModel  || !$this->_leagueModel->init($this->_leagueId))
				return false;*/
			$leagueModel = LeagueModelMgr::Instance()->getModelList( LEAGUE_MODEL_DEFAULT,array($this->_leagueId));
			if(empty($leagueModel))
				return false;

			$realNum = $this->_leagueModel->getFieldByIndex(DATA_BASE_LEAGUE_REALNUM);
			if($realNum >= LEAGUE_GROUP_REAL_USER)
			{
				$leagueId = LeagueModel::getAvailableLeague(LeagueLogic::getLeagueIndex());
				if(!empty($leagueId))
				{
					$this->_leagueId = $leagueId[0]["id"];
					
					if($this->_leagueId)
					{
						/*$this->_leagueModel = new LeagueModel();
						if(!$this->_leagueModel  || !$this->_leagueModel->init($this->_leagueId))*/
						$leagueModel = LeagueModelMgr::Instance()->getModelList( LEAGUE_MODEL_DEFAULT,array($this->_leagueId));
						if(empty($leagueModel))
							return false;
					}
				}
				else
				{
					/**
					 * 先创建14支队伍，并把玩家分配到其中
					 */
					if(!$this->createRobotLeague())
						return false;
				}
			}	
		}
		else
		{
			$leagueId = LeagueModel::getAvailableLeague(LeagueLogic::getLeagueIndex());
			if(!empty($leagueId))
			{
				$this->_leagueId = $leagueId[0]["id"];
					
				if($this->_leagueId)
				{
					/*$this->_leagueModel = new LeagueModel();
					if($this->_leagueModel  && $this->_leagueModel->init($this->_leagueId))*/
					$leagueModel = LeagueModelMgr::Instance()->getModelList( LEAGUE_MODEL_DEFAULT,array($this->_leagueId));
					if(!empty($leagueModel))
						return true;
				}
			}
			
			/**
			 * 先创建14支队伍，并把玩家分配到其中
			 */
			if(!$this->createRobotLeague())
				return false;
		}
		
		return true;
	}
	
	/**
	 * @date : 2017年4月12日 下午6:06:00
	 * @author : meishuijing
	 * @param : 
	 * @return : 
	 * @desc : 创建联赛，包含14支队伍，已经赛程，及已经比赛过几天，球员数据变化
	 */
	private function createRobotLeague()
	{
//		$leagueModel = new LeagueModel();
//		if(!$leagueModel)

		$newLeagueId = ConfigLogic::Instance()->newLeagueId();
		if(!$newLeagueId)
			return false;
		$newLeagueId = "dbKey1|".$newLeagueId;
		$leagueModel = LeagueModelMgr::Instance()->getModelByPrimary($newLeagueId);

		if(empty($leagueModel))
			return false;
		/*if(!$leagueModel->init($newLeagueId))
			return false;*/
		
		
		$data = Array();
		$data[DATA_BASE_LEAGUE_ID] = $newLeagueId;
		$data[DATA_BASE_LEAGUE_LEVEL] = 1;
		$data[DATA_BASE_LEAGUE_LEAGUER1] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER2] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER3] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER4] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER5] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER6] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER7] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER8] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER9] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER10] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER11] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER12] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER13] = 0;
		$data[DATA_BASE_LEAGUE_LEAGUER14] = 0;
		$data[DATA_BASE_LEAGUE_REALNUM] = 0;

// 		foreach($leagueModel as $primaryKey => $model) {   //2017.05.19

// 			$data = $leagueModel->data();
//			if (!$leagueModel[$primaryKey]->insertLeagueData($data))
		if (!LeagueModelMgr::Instance()->addSingleData($data))
			return false;


		$leaguer = Array();

		for ($i = 0; $i < 14; $i++) {
			$RobotLogic = new RobotLogic();
			if (!$RobotLogic || !$RobotLogic->init(-1, $newLeagueId, 1)) {

				return false;
			}

			$leaguer[$i] = $RobotLogic->getUserId();
		}

		//预防生成失败，再次
		if (count($leaguer) < 14) {
			for ($i = count($leaguer) + 1; $i <= 14; $i++) {
				$RobotLogic = new RobotLogic();
				if (!$RobotLogic || !$RobotLogic->init(-1, $newLeagueId, 1)) {
					return false;
				}

				$leaguer[$i] = $RobotLogic->getUserId();
			}
		}
		if (count($leaguer) != 14)
			return false;


		shuffle($leaguer);
		MemInfoLogic::Instance()->setMemData(LEAGUE_CUR_GROUP, $newLeagueId);

		$this->makeSchedule($newLeagueId, $leaguer, LeagueLogic::getLeagueIndex());
		$this->initRank($newLeagueId, $leaguer);
		$this->initFootballerRank($newLeagueId, $leaguer);

		//保存到数据库中
		$data = Array();
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_ID, $newLeagueId);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEVEL, 1);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER1, $leaguer[0]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER2, $leaguer[1]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER3, $leaguer[2]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER4, $leaguer[3]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER5, $leaguer[4]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER6, $leaguer[5]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER7, $leaguer[6]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER8, $leaguer[7]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER9, $leaguer[8]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER10, $leaguer[9]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER11, $leaguer[10]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER12, $leaguer[11]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER13, $leaguer[12]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_LEAGUER14, $leaguer[13]);
		$leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_REALNUM, 0);
		if (!$leagueModel->DB_update1($leagueModel->data(), $newLeagueId))
			return false;

		$this->_leagueId = $newLeagueId;
		$this->_leagueModel = $leagueModel;

		return true;
	}
// 	}
	
	
	/**
	 * @date : 2017年4月17日 下午4:53:47
	 * @author : meishuijing
	 * @param : 
	 * @return : 
	 * @desc : 处理联赛创建的接口，主要用于重新分组进行联赛的时候
	 */
	private function  createLeague($level, $leaguer, $realNum = 0)
	{
		if(!$level || !is_int($level) || !($level >= 1 && $level <= 40))
			return false;
		
		if(!is_array($leaguer) || count($leaguer) != 14 || !isset($leaguer[0]) || !is_int($leaguer[0]))
			return false;
		
//		$leagueModel = new LeagueModel();
//		if(!$leagueModel)
//			return false;
		
		$newLeagueId = ConfigLogic::Instance()->newLeagueId();
		if(!$newLeagueId)
			return false;
		$leagueModel = LeagueModelMgr::Instance()->getModelList( LEAGUE_MODEL_DEFAULT,array($newLeagueId));

		if(empty($leagueModel))
			return false;
		
		shuffle($leaguer);
		
		
		$this->makeSchedule($newLeagueId, $leaguer, LeagueLogic::getLeagueIndex());
		$this->initRank($newLeagueId, $leaguer);
		$this->initFootballerRank($newLeagueId, $leaguer);
		
		//保存到数据库中
		$data = Array();
		$data[DATA_BASE_LEAGUE_ID] = $newLeagueId;
		$data[DATA_BASE_LEAGUE_LEVEL] = 1;
		$data[DATA_BASE_LEAGUE_LEAGUER1] = $leaguer[0];
		$data[DATA_BASE_LEAGUE_LEAGUER2] = $leaguer[1];
		$data[DATA_BASE_LEAGUE_LEAGUER3] = $leaguer[2];
		$data[DATA_BASE_LEAGUE_LEAGUER4] = $leaguer[3];
		$data[DATA_BASE_LEAGUE_LEAGUER5] = $leaguer[4];
		$data[DATA_BASE_LEAGUE_LEAGUER6] = $leaguer[5];
		$data[DATA_BASE_LEAGUE_LEAGUER7] = $leaguer[6];
		$data[DATA_BASE_LEAGUE_LEAGUER8] = $leaguer[7];
		$data[DATA_BASE_LEAGUE_LEAGUER9] = $leaguer[8];
		$data[DATA_BASE_LEAGUE_LEAGUER10] = $leaguer[9];
		$data[DATA_BASE_LEAGUE_LEAGUER11] = $leaguer[10];
		$data[DATA_BASE_LEAGUE_LEAGUER12] = $leaguer[11];
		$data[DATA_BASE_LEAGUE_LEAGUER13] = $leaguer[12];
		$data[DATA_BASE_LEAGUE_LEAGUER14] = $leaguer[13];
		$data[DATA_BASE_LEAGUE_REALNUM] = 0;

		foreach($leagueModel as $primaryKey => $model) {
			$data = $leagueModel[$primaryKey]->data();
			if (!$leagueModel[$primaryKey]->saveLeagueData($data))
				return false;

			$this->_leagueId = $newLeagueId;
			$this->_leagueModel = $leagueModel;

			return true;
		}
	}
	
	private function joinLeague()
	{
		$realNum = $this->_leagueModel->getFieldByIndex(DATA_BASE_LEAGUE_REALNUM);
		if(!isset($realNum))
			return null;
		
		$leaguer = $this->_leagueModel->getFieldByIndex(DATA_BASE_LEAGUE_LEAGUER1 + $realNum);
		$this->_leagueModel->setFieldByIndex(DATA_BASE_LEAGUE_REALNUM, $realNum + 1);
		$this->_leagueModel->saveLeagueData();
		
		return array($leaguer, $this->_leagueId);
	}
	
	/**
	 * @date : 2017年4月19日 下午6:30:40
	 * @author : meishuijing
	 * @param : 
	 * @return : 
	 * @desc : 初始化联赛排行榜
	 */
	private function initRank($leagueId, $leaguer)
	{
		$rank = Array();
		foreach($leaguer as $v)
		{
			$one = Array();
			$one[DATA_BASE_LEAGUE_RANK_LEAGUEID] = $leagueId;
			$one[DATA_BASE_LEAGUE_RANK_LEAGUER] = $v;
			$one[DATA_BASE_LEAGUE_RANK_LASTRANK] = 0;
			$one[DATA_BASE_LEAGUE_RANK_FINISH] = 0;
			$one[DATA_BASE_LEAGUE_RANK_SUCC] = 0;
			$one[DATA_BASE_LEAGUE_RANK_DRAW] = 0;
			$one[DATA_BASE_LEAGUE_RANK_FAIL] = 0;
			$one[DATA_BASE_LEAGUE_RANK_GOAL] = 0;
			$one[DATA_BASE_LEAGUE_RANK_FUMBLE] = 0;
			$one[DATA_BASE_LEAGUE_RANK_INTEGRAL] = 0;
			$one[DATA_BASE_LEAGUE_RANK_PERFORMANCE] = 0;
			
			$rank[] = $one;
		}
		
//		$rankModel = new LeagueRankModel();
		/*if($rankModel && $rankModel->init($leagueId))
		{
			$rankModel->insertRankData($rank);
		}*/
		$leagueModel = LeagueRankModelMgr::Instance()->getModelList( LEAGUE_RANK_MODEL_DEFAULT,array($leagueId));
		if(!empty($leagueModel))
		{
			LeagueRankModelMgr::Instance()->addMultiData($rank);
		}
	}
	
	private function initFootballerRank($leagueId, $leaguer)
	{
		$rank = Array();
		
		
		for($i = 0; $i < 5; $i++)
		{
			$userId = array_rand($leaguer, 1);
			$userId = $leaguer[$userId];
			
			$cardModel = new CardsModel();
			if(!$cardModel || !$cardModel->init($userId))
			{
				continue;
			}
			
			$rand = array_rand($cardModel->data(), 1);
			$rand = $cardModel->data()[$rand];
			
			$one = Array();
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] = $leagueId;
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] = $rand[DATA_BASE_CARDS_UID];
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_USERID] = $userId;
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] = LEAGUE_FB_RANK_TYPE_SHOOT;
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] = 0;
			$rank[] = $one;
			
			$one = Array();
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] = $leagueId;
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] = $rand[DATA_BASE_CARDS_UID];
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_USERID] = $userId;
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] = LEAGUE_FB_RANK_TYPE_MARK;
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] = 0;
			$rank[] = $one;
			
			$one = Array();
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] = $leagueId;
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] = $rand[DATA_BASE_CARDS_UID];
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_USERID] = $userId;
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] = LEAGUE_FB_RANK_TYPE_ASSISTS;
			$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] = 0;
			$rank[] = $one;
		}
		
//		$fbRankModel = new LeagueFBRankModel();
		/*if($fbRankModel && $fbRankModel->init($leagueId))
		{
			$fbRankModel->insertRankData($rank);
		}*/
		$leagueModel = LeagueFBRankModelMgr::Instance()->getModelList( LEAGUE_FB_RANK_MODEL_DEFAULT,array($leagueId));
		if(!empty($leagueModel))
		{
			LeagueFBRankModelMgr::Instance()->addMultiData($rank);
		}
	}
	
	/**
	 * @date : 2017年4月14日 下午12:23:14
	 * @author : meishuijing
	 * @param : 
	 * @return : 
	 * @desc : 制定赛程
	 */
	private function makeSchedule($leagueId, $leaguer, $leagueIndex)
	{
		$scheduleConfig = XmlConfigMgr::getInstance()->getLeagueTimeConfig()->getConfig();
		if(!empty($scheduleConfig))
		{
			$data = Array();
			$curIndex = 0;
			$leagueTurn = 0;
			$round = Array();
			foreach ($scheduleConfig as $v)
			{
				if($v["Leagueturn"] != $leagueTurn)
				{
					$curIndex = 0;
					
					$leagueTurn = $v["Leagueturn"];
				}
				$leaguer1 = $leaguer[$v["Home"] - 1];
				$leaguer2 = $leaguer[$v["Away"] - 1];
				$clubModel = new ClubModel();
				
				$start = self::getLeagueIndexStartDate($leagueIndex);
				$curDate = date("Y-m-d", strtotime("+".($leagueTurn + 1)." days", strtotime($start)));
				$startTime = strtotime($curDate." 15:".$curIndex);
				if($clubModel && $clubModel->init($leaguer1))
				{
					$country = $clubModel->getFieldByIndex(DATA_BASE_CLUB_COUNTRY);
					if($country)
					{
						$countryConfig = XmlConfigMgr::getInstance()->getCountryConfig()->findCountryConfig($country);
						if($countryConfig && isset($countryConfig["TimeDifference"]))
						{
							$diff = intval(TIME_ZONE_DEFAULT - $countryConfig["TimeDifference"]);
							$diff += 15;
							if($diff >= 24)
							{
								$date = date("Y-m-d", strtotime("-1 day", strtotime($curDate)));
								$startTime = strtotime($date." ".($diff - 24).":".$curIndex);
							}
							else
							{
								$date = $curDate;
								$startTime = strtotime($date." ".$diff.":".$curIndex);
							}
						}
					}
					$curIndex++;
				}
				$one = Array();
				$one[DATA_BASE_LEAGUE_SCHEDULE_LEAGUEID] = $leagueId;
				$one[DATA_BASE_LEAGUE_SCHEDULE_ROUND] = $v["Leagueturn"];
				$one[DATA_BASE_LEAGUE_SCHEDULE_NO] = $v["Order"];
				$one[DATA_BASE_LEAGUE_SCHEDULE_LEAGUER1] = $leaguer1;
				$one[DATA_BASE_LEAGUE_SCHEDULE_LEAGUER2] = $leaguer2;
				$one[DATA_BASE_LEAGUE_SCHEDULE_STARTTIME] = $startTime;
				$one[DATA_BASE_LEAGUE_SCHEDULE_STATUS] = GAME_STATUS_TYPE_WAITING;
				$one[DATA_BASE_LEAGUE_SCHEDULE_SCORE1] = 0;
				$one[DATA_BASE_LEAGUE_SCHEDULE_SCORE2] = 0;
				
				
				$roomId = 0;
				$fightRoomLogic = new FightRoomsLogic();
				if($fightRoomLogic)
				{
					if($fightRoomLogic->init($leaguer1, $leaguer2))
					{
						if($fightRoomLogic->addFightRoom($startTime, FIGHT_ROOMS_TYPE_LEAGUE, json_encode(array("leagueId"=>$leagueId, "leagueIndex"=>self::getLeagueIndex()))))
						{
							$roomId = $fightRoomLogic->getModel()->getFieldByIndex(DATA_BASE_FIGHTROOMS_UID, $fightRoomLogic->getMaxFightRoomIndex());
							
							$startTime = time() + 3600 * 24;
							$param["callBack"] = "LeagueLogic::callBack";
							$param["param"] = Array("data"=>array($leagueId,$v["Leagueturn"],$v["Order"], $leaguer1, self::getLeagueIndex()), "type"=>LEAGUE_CALL_BACK_TYPE_BEGIN);
							$fightRoomLogic->bespeakFight($roomId, $startTime, $param);
						}
					}
				}
				$one[DATA_BASE_LEAGUE_SCHEDULE_ROOMID] = $roomId;
				$one[DATA_BASE_LEAGUE_SCHEDULE_ISLOCKED] = 0;
				
				$round[] = $one;
			}
			
//			$scheduleModel = new LeagueScheduleModel;
			$leagueModel = LeagueScheduleModelMgr::Instance()->getModelList( LEAGUE_SCHEDULE_MODEL_DEFAULT,array($leagueId));
			if(!empty($leagueModel))
			{
				LeagueScheduleModelMgr::Instance()->addMultiData($round);
			}
		}
	}
	
	/**
	 * @date : 2017年4月14日 下午2:24:46
	 * @author : meishuijing
	 * @param : 
	 * @return : 
	 * @desc : 获取当前处于第几次联赛
	 */
	static function getLeagueIndex()
	{
		return 1;
		$leagueIndex = 0;
		
		$start = XmlConfigMgr::getInstance()->getStaticConfig()->getConfig("startgame");
		$leagueDays = XmlConfigMgr::getInstance()->getStaticConfig()->getConfig("leaguedays");
		if($start && $leagueDays)
		{
			$today = date("Y/m/d");
			$startList = explode("/", $start);
			$todayList = explode("/", $today);
		
			$startUnix = mktime(0,0,0,$startList[1],$startList[2],$startList[0]);
			$todayUnix = mktime(0,0,0,$todayList[1],$todayList[2],$todayList[0]);
			
			$diff = ($todayUnix - $startUnix) / (3600 * 24);
			
			
			if($leagueDays > 0)
				$leagueIndex = intval(floor($diff / $leagueDays));
			
		}
		
		//标号从1开始，算第一次赛季
		$leagueIndex++;
		return $leagueIndex;
	}
	
	
	
	/**
	 * @date : 2017年4月21日 下午6:15:00
	 * @author : meishuijing
	 * @param : 
	 * @return : 
	 * @desc : 获取某个赛季的开始时间和结束时间
	 */
	static function getLeagueIndexTime($index)
	{
		if($index >= 1)
		{
			$start = XmlConfigMgr::getInstance()->getStaticConfig()->getConfig("startgame");
			$leagueDays = XmlConfigMgr::getInstance()->getStaticConfig()->getConfig("leaguedays");
			if($start && $leagueDays)
			{
				$startUnix = strtotime($start) + ($index - 1) * $leagueDays * 24 * 3600;
				$endUnix = $startUnix + ($index) * $leagueDays * 24 * 3600;
				
				return array($startUnix, $endUnix);
			}
		}
		
		return null;
	}
	
	static function getLeagueIndexStartDate($index)
	{
		if($index >= 1)
		{
			$start = XmlConfigMgr::getInstance()->getStaticConfig()->getConfig("startgame");
			$leagueDays = XmlConfigMgr::getInstance()->getStaticConfig()->getConfig("leaguedays");
			if($start && $leagueDays)
			{
				$startDate = strtotime($start) + ($index - 1) * $leagueDays * 24 * 3600;
				$startDate = date("Y-m-d", $startDate);
				return $startDate;
			}
		}
		
		return null;
	}
	
	/**
	 * @date : 2017年4月14日 下午2:25:25
	 * @author : meishuijing
	 * @param : 
	 * @return : 
	 * @desc : 获取今天是当前联赛所处第几轮
	 */
	static function getLeagueRound()
	{
		$leagueRound = 0;
		
		$start = XmlConfigMgr::getInstance()->getStaticConfig()->getConfig("startgame");
		$leagueDays = XmlConfigMgr::getInstance()->getStaticConfig()->getConfig("leaguedays");
		if($start && $leagueDays)
		{
			$today = date("Y/m/d");
			$startList = explode("/", $start);
			$todayList = explode("/", $today);
				
			$startUnix = mktime(0,0,0,$startList[1],$startList[2],$startList[0]);
			$todayUnix = mktime(0,0,0,$todayList[1],$todayList[2],$todayList[0]);
				
			$diff = ($todayUnix - $startUnix) / (24 * 3600);
				
				
			if($leagueDays > 0)
				$leagueRound = intval($diff % $leagueDays);
				
		}
		
		//标号从1开始，算第一次赛季
		$leagueRound++;
		return $leagueRound;
	}
	
	//////////////////////////////////////////////////
	//以下为结算时函数
	//////////////////////////////////////////////////
	
	static function callBack($param)
	{
		if($param["type"] == LEAGUE_CALL_BACK_TYPE_SETTLE)
		{
			$leagueId = $param["data"][0];
			$userId = $param["data"][1];
			$leagueIndex = $param["data"][2];
			
			$leagueLogic = new LeagueLogic();
			if(!$leagueLogic || !$leagueLogic->init($userId))
			{
				return;
			}
			
			$leagueLogic->call_settle($leagueId, $leagueIndex);
		}
		else if($param["type"] == LEAGUE_CALL_BACK_TYPE_BEGIN)
		{
			$leagueId = $param["data"][0];
			$round = $param["data"][1];
			$no = $param["data"][2];
			$userId = $param["data"][3];
			$leagueIndex = $param["data"][4];
			
			$leagueLogic = new LeagueLogic();
			if(!$leagueLogic || !$leagueLogic->init($userId))
				return;
			
			$leagueLogic->call_Begin($leagueId, $round, $no, $userId, $leagueIndex);
		}
		else if($param["type"] == LEAGUE_CALL_BACK_TYPE_STATISTICS)
		{
			$leagueId = $param["data"][0];
			$userId = $param["data"][1];
			$leagueIndex = $param["data"][2];
			$statistics = $param["statistics"];
			
			$leagueLogic = new LeagueLogic();
			if(!$leagueLogic || !$leagueLogic->init($userId))
			{
				return;
			}
			$leagueLogic->call_statistics($leagueId, $leagueIndex, $statistics);
		}
	}
	
	private function call_statistics($leagueId, $leagueIndex, $statistics)
	{
		writeLog(LOG_LEVEL_ERROR, "call_statistics($leagueId, $leagueIndex)");
		$homeGameInfo = $statistics[HOME_GAME_DATA];
		$awayGameInfo = $statistics[AWAY_GAME_DATA];
		if($homeGameInfo && $homeGameInfo instanceof SGameStatisticsInfo && $awayGameInfo && $awayGameInfo instanceof SGameStatisticsInfo)
		{
//			$leagueRankModel = new LeagueRankModel();
			$leagueModel = LeagueRankModelMgr::Instance()->getModelList( LEAGUE_RANK_MODEL_DEFAULT,array($leagueId));
			if(empty($leagueModel))
				return;

			foreach($leagueModel as $primaryKey => $model) {
				$data = $leagueModel[$primaryKey]->data();

//			$data = $leagueRankModel->data();
				foreach ($data as $v) {
					if ($v[DATA_BASE_LEAGUE_RANK_LEAGUEID] == $leagueId && $v[DATA_BASE_LEAGUE_RANK_LEAGUER] == $homeGameInfo->__UserId) {
						$v[DATA_BASE_LEAGUE_RANK_GOAL] += $homeGameInfo->__TotalGoalNum;
						$v[DATA_BASE_LEAGUE_RANK_FUMBLE] += $awayGameInfo->__TotalGoalNum;

						$v[DATA_BASE_LEAGUE_RANK_FINISH] += 1;
						if ($homeGameInfo->__TotalGoalNum > $awayGameInfo->__TotalGoalNum) {
							$v[DATA_BASE_LEAGUE_RANK_SUCC] += 1;
							$v[DATA_BASE_LEAGUE_RANK_PERFORMANCE] = intval($v[DATA_BASE_LEAGUE_RANK_PERFORMANCE]) * 10 + GAME_RESULT_TYPE_SUCC;
						} else if ($homeGameInfo->__TotalGoalNum == $awayGameInfo->__TotalGoalNum) {
							$v[DATA_BASE_LEAGUE_RANK_DRAW] += 1;
							$v[DATA_BASE_LEAGUE_RANK_PERFORMANCE] = intval($v[DATA_BASE_LEAGUE_RANK_PERFORMANCE]) * 10 + GAME_RESULT_TYPE_DRAW;
						} else {
							$v[DATA_BASE_LEAGUE_RANK_FAIL] += 1;
							$v[DATA_BASE_LEAGUE_RANK_PERFORMANCE] = intval($v[DATA_BASE_LEAGUE_RANK_PERFORMANCE]) * 10 + GAME_RESULT_TYPE_FAIL;
						}

						$v[DATA_BASE_LEAGUE_RANK_INTEGRAL] = $v[DATA_BASE_LEAGUE_RANK_SUCC] * 3 + $v[DATA_BASE_LEAGUE_RANK_DRAW];

						$v[DATA_BASE_LEAGUE_RANK_PERFORMANCE] %= 100000;
						$v[DATA_BASE_LEAGUE_RANK_PERFORMANCE] = sprintf("%05d", $v[DATA_BASE_LEAGUE_RANK_PERFORMANCE]);

						$leagueModel[$primaryKey]->saveRankData($v);
					}
					if ($v[DATA_BASE_LEAGUE_RANK_LEAGUEID] == $leagueId && $v[DATA_BASE_LEAGUE_RANK_LEAGUER] == $awayGameInfo->__UserId) {
						$v[DATA_BASE_LEAGUE_RANK_GOAL] += $awayGameInfo->__TotalGoalNum;
						$v[DATA_BASE_LEAGUE_RANK_FUMBLE] += $homeGameInfo->__TotalGoalNum;

						$v[DATA_BASE_LEAGUE_RANK_FINISH] += 1;
						if ($awayGameInfo->__TotalGoalNum > $homeGameInfo->__TotalGoalNum) {
							$v[DATA_BASE_LEAGUE_RANK_SUCC] += 1;
							$v[DATA_BASE_LEAGUE_RANK_PERFORMANCE] = intval($v[DATA_BASE_LEAGUE_RANK_PERFORMANCE]) * 10 + GAME_RESULT_TYPE_SUCC;
						} else if ($awayGameInfo->__TotalGoalNum == $homeGameInfo->__TotalGoalNum) {
							$v[DATA_BASE_LEAGUE_RANK_DRAW] += 1;
							$v[DATA_BASE_LEAGUE_RANK_PERFORMANCE] = intval($v[DATA_BASE_LEAGUE_RANK_PERFORMANCE]) * 10 + GAME_RESULT_TYPE_DRAW;
						} else {
							$v[DATA_BASE_LEAGUE_RANK_FAIL] += 1;
							$v[DATA_BASE_LEAGUE_RANK_PERFORMANCE] = intval($v[DATA_BASE_LEAGUE_RANK_PERFORMANCE]) * 10 + GAME_RESULT_TYPE_FAIL;
						}

						$v[DATA_BASE_LEAGUE_RANK_INTEGRAL] = $v[DATA_BASE_LEAGUE_RANK_SUCC] * 3 + $v[DATA_BASE_LEAGUE_RANK_DRAW];

						$v[DATA_BASE_LEAGUE_RANK_PERFORMANCE] %= 100000;
						$v[DATA_BASE_LEAGUE_RANK_PERFORMANCE] = sprintf("%05d", $v[DATA_BASE_LEAGUE_RANK_PERFORMANCE]);

						$leagueModel[$primaryKey]->saveRankData($v);
					}
				}
			}
		}
		else
			return;
		
		$homeCardInfo = $statistics[HOME_CARD_DATA];
		$awayCardInfo = $statistics[AWAY_CARD_DATA];
		if($homeCardInfo && $awayCardInfo )
		{
			/*$leagueFBRankModel = new LeagueFBRankModel();

			if(!$leagueFBRankModel || !$leagueFBRankModel->init($leagueId))
			{
				return;
			}*/
			$leagueModel = LeagueFBRankModelMgr::Instance()->getModelList( LEAGUE_FB_RANK_MODEL_DEFAULT,array($leagueId));
			if(!empty($leagueModel))
				return;
			foreach($leagueModel as $primaryKey => $model) {
				$data = $leagueModel[$primaryKey]->data();

				$newRank = Array();
//			$data = $leagueFBRankModel->data();
				foreach ($homeCardInfo as $card) {
					if ($card instanceof SCardStatisticsInfo) {
						$bFind1 = false;
						$bFind2 = false;
						$bFind3 = false;
						foreach ($data as $v) {
							if ($v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] == $leagueId
								&& $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] == $card->__CardUid
								&& $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] == LEAGUE_FB_RANK_TYPE_SHOOT
							) {
								$v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] += $card->__GoalNum;
								$leagueModel[$primaryKey]->saveRankData($v);
								$bFind1 = true;
							}
							if ($v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] == $leagueId
								&& $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] == $card->__CardUid
								&& $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] == LEAGUE_FB_RANK_TYPE_MARK
							) {
								if (!isset($v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_SCORE]) || !isset($v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_SCORE])) {
									writeLog(LOG_LEVEL_ERROR, $v);
								}
								$v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_SCORE] += $card->__Score;
								$v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_JOINS] += 1;
								if ($v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_JOINS] != 0)
									$v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] = $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_SCORE] / $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_JOINS];
								$leagueModel[$primaryKey]->saveRankData($v);
								$bFind2 = true;
							}
							if ($v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] == $leagueId
								&& $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] == $card->__CardUid
								&& $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] == LEAGUE_FB_RANK_TYPE_ASSISTS
							) {
								$v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] += $card->__Assists;
								$leagueModel[$primaryKey]->saveRankData($v);
								$bFind3 = true;
							}
						}
						if (!$bFind1) {
							$one = Array();
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] = $leagueId;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] = $card->__CardUid;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_USERID] = $homeGameInfo->__UserId;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] = LEAGUE_FB_RANK_TYPE_SHOOT;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] = $card->__GoalNum;
							$newRank[] = $one;
						}
						if (!$bFind2) {
							$one = Array();
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] = $leagueId;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] = $card->__CardUid;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_USERID] = $homeGameInfo->__UserId;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] = LEAGUE_FB_RANK_TYPE_MARK;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_SCORE] = $card->__Score;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_JOINS] = 1;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] = $card->__Score;
							$newRank[] = $one;
						}
						if (!$bFind3) {
							$one = Array();
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] = $leagueId;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] = $card->__CardUid;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_USERID] = $homeGameInfo->__UserId;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] = LEAGUE_FB_RANK_TYPE_ASSISTS;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] = $card->__Assists;
							$newRank[] = $one;
						}
					}
				}
				foreach ($awayCardInfo as $card) {
					if ($card instanceof SCardStatisticsInfo) {
						$bFind1 = false;
						$bFind2 = false;
						$bFind3 = false;
						foreach ($data as $v) {
							if ($v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] == $leagueId
								&& $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] == $card->__CardUid
								&& $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] == LEAGUE_FB_RANK_TYPE_SHOOT
							) {
								$v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] += $card->__GoalNum;
								$leagueModel[$primaryKey]->saveRankData($v);
								$bFind1 = true;
							}
							if ($v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] == $leagueId
								&& $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] == $card->__CardUid
								&& $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] == LEAGUE_FB_RANK_TYPE_MARK
							) {
								$v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_SCORE] += $card->__Score;
								$v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_JOINS] += 1;
								if ($v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_JOINS] != 0)
									$v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] = $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_SCORE] / $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_JOINS];
								$leagueModel[$primaryKey]->saveRankData($v);
								$bFind2 = true;
							}
							if ($v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] == $leagueId
								&& $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] == $card->__CardUid
								&& $v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] == LEAGUE_FB_RANK_TYPE_ASSISTS
							) {
								$v[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] += $card->__Assists;
								$leagueModel[$primaryKey]->saveRankData($v);
								$bFind3 = true;
							}
						}
						if (!$bFind1) {
							$one = Array();
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] = $leagueId;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] = $card->__CardUid;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_USERID] = $awayGameInfo->__UserId;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] = LEAGUE_FB_RANK_TYPE_SHOOT;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] = $card->__GoalNum;
							$newRank[] = $one;
						}
						if (!$bFind2) {
							$one = Array();
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] = $leagueId;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] = $card->__CardUid;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_USERID] = $awayGameInfo->__UserId;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] = LEAGUE_FB_RANK_TYPE_MARK;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_SCORE] = $card->__Score;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_JOINS] = 1;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] = $card->__Score;
							$newRank[] = $one;
						}
						if (!$bFind3) {
							$one = Array();
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID] = $leagueId;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID] = $card->__CardUid;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_USERID] = $awayGameInfo->__UserId;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE] = LEAGUE_FB_RANK_TYPE_ASSISTS;
							$one[DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT] = $card->__Assists;
							$newRank[] = $one;
						}
					}
				}

//				$leagueModel[$primaryKey]->insertRankData($newRank);
				LeagueFBRankModelMgr::Instance()->addMultiData($newRank);

			}
		}
		else
			return;
	}
	
	private function call_Begin($leagueId, $round, $no, $userId, $leagueIndex)
	{
//		$leagueScheduleModel = new LeagueScheduleModel;
		$leagueModel = LeagueScheduleModelMgr::Instance()->getModelList( LEAGUE_SCHEDULE_MODEL_DEFAULT,array($leagueId));
		if(empty($leagueModel) || !is_array($leagueModel))
			return;
		foreach($leagueModel as $primaryKey => $model) {
			$data = $leagueModel[$primaryKey]->data();
//		$data = $leagueScheduleModel->data();
			foreach ($data as $v) {
				if ($v[DATA_BASE_LEAGUE_SCHEDULE_ROUND] == $round && $v[DATA_BASE_LEAGUE_SCHEDULE_NO] == $no) {
					$one = new SLeagueScheduleInfo;
					$one->__RoomId = $v[DATA_BASE_LEAGUE_SCHEDULE_ROOMID];
					$one->__Round = $v[DATA_BASE_LEAGUE_SCHEDULE_ROUND];
					$one->__NO = $v[DATA_BASE_LEAGUE_SCHEDULE_NO];
					$one->__UserId1 = $v[DATA_BASE_LEAGUE_SCHEDULE_LEAGUER1];
					$clubLogic1 = new ClubLogic();
					if ($clubLogic1 && $clubLogic1->init($one->__UserId1)) {
						$one->__ClubName1 = $clubLogic1->getModel()->getFieldByIndex(DATA_BASE_CLUB_CLUBNAME);
						$one->__TeamSign1 = $clubLogic1->getClubTeamSign();
					}

					$one->__UserId2 = $v[DATA_BASE_LEAGUE_SCHEDULE_LEAGUER2];
					$clubLogic2 = new ClubLogic();
					if ($clubLogic2 && $clubLogic2->init($one->__UserId2)) {
						$one->__ClubName2 = $clubLogic2->getModel()->getFieldByIndex(DATA_BASE_CLUB_CLUBNAME);
						$one->__TeamSign2 = $clubLogic2->getClubTeamSign();
					}

					$one->__StartTime = $v[DATA_BASE_LEAGUE_SCHEDULE_STARTTIME];
					$one->__Status = GAME_STATUS_TYPE_GAMEING;
					$one->__Score = array($v[DATA_BASE_LEAGUE_SCHEDULE_SCORE1], $v[DATA_BASE_LEAGUE_SCHEDULE_SCORE2]);
					$one->__IsLocked = $v[DATA_BASE_LEAGUE_SCHEDULE_ISLOCKED];

					$ntf = new SC_LEAGUE_SCHEDULE_NTF;
					$ntf->__Schedule[] = $one;


					LeagueScheduleModel::updateStatusByRoom($leagueIndex, $one->__RoomId, GAME_STATUS_TYPE_GAMEING);

					$attach1 = MemInfoLogic::Instance()->getMemData(HEART_BEAT_ATTACH_PACKAGE . "_" . $one->__UserId1);
					if (!$attach1)
						$attach1 = Array();
					$attach1[] = array(SCID_LEAGUE_SCHEDULE_NTF, $ntf);
					MemInfoLogic::Instance()->setMemData(HEART_BEAT_ATTACH_PACKAGE . "_" . $one->__UserId1, $attach1);

					$attach2 = MemInfoLogic::Instance()->getMemData(HEART_BEAT_ATTACH_PACKAGE . "_" . $one->__UserId2);
					if (!$attach2)
						$attach2 = Array();
					$attach2[] = array(SCID_LEAGUE_SCHEDULE_NTF, $ntf);
					MemInfoLogic::Instance()->setMemData(HEART_BEAT_ATTACH_PACKAGE . "_" . $one->__UserId2, $attach2);
					break;
				}
			}
		}
	}
	
	private function  call_settle($leagueId)
	{
//		$leagueRankModel = new LeagueRankModel();
		$leagueModel = LeagueRankModelMgr::Instance()->getModelList( LEAGUE_RANK_MODEL_DEFAULT,array($leagueId));
		if(empty($leagueModel))
			return;

		foreach($leagueModel as $primaryKey => $model) {
			$data = $leagueModel[$primaryKey]->data();

			if (count($data) != 14)
				return;

			$rank = Array();
			for ($i = 0; $i < count($data); $i++) {
				$index = $this->__compareRank($data);
				if ($index == -1)
					break;

				$rank[] = $data[$index];

				$data[$index] = null;
				unset($data[$index]);
			}

			//TODO:增加游戏联赛排行结算

			//TODO:增加游戏联赛排行结算

			//前8名晋级到下个等级的联赛
			for ($i = 1; $i <= 14; $i++) {
				$one = array_shift($data);
				$leaguer = $one["leaguer"];
				$level = $one["level"];

				if ($i <= 8 && $level < LEAGUE_LEVEL_MAX)
					$level++;
				else
					$level = LEAGUE_LEVEL_MAX;

				$this->__combineLeague($level, $leaguer);
			}
		}
	}
	
	private function __combineLeague($level, $leaguer)
	{
		$levelPool = MemInfoLogic::Instance()->getMemData(LEAGUE_LEVEL_MAX."_".$level);
		if(!$levelPool)
			$levelPool = Array();
			
		$levelPool[] = $leaguer;
		
		if(count($levelPool[$level]) >= 560)
		{
			shuffle($levelPool);
			for($i = 1; $i <=20; $i++)
			{
				$leaguer = array(
						$levelPool[0], $levelPool[1], $levelPool[2], $levelPool[3], $levelPool[4], 
						$levelPool[5], $levelPool[6], $levelPool[7], $levelPool[8], $levelPool[9], 
						$levelPool[10], $levelPool[11], $levelPool[12], $levelPool[13]
				);
				array_splice($level, 0, 14);
				$this->createLeague($level, $leaguer);
			}
				
		}
		else
		{
			//判定是否已经结算已经结束，如果结束，则把池中的玩家重组联赛，不够的用相对应的AI填充
			
			
		}
	}
	
	private function __compareRank($data)
	{
		//1。第一步找出积分最高的
		$bSame = false;
		$index = -1;
		$step1 = 0;
		foreach($data as $k=>$v)
		{
			if($index == -1)
				$index = $k;
			if($step1 < $v[DATA_BASE_LEAGUE_RANK_INTEGRAL])
			{
				$step1 = $v[DATA_BASE_LEAGUE_RANK_INTEGRAL];
				$bSame = false;
				$index = $k;
			}
			else if($step1 == $v[DATA_BASE_LEAGUE_RANK_INTEGRAL])
			{
				$bSame = true;
			}
		}
		if(!$bSame)
		{
			return $index;
		}
		
		//2。第二步，积分相同的项，判定净胜球
		$step2 = 0;
		foreach($data as $k=>$v)
		{
			if($step1 == $v[DATA_BASE_LEAGUE_RANK_INTEGRAL])
			{
				if($step2 < $v[DATA_BASE_LEAGUE_RANK_GOAL] - $v[DATA_BASE_LEAGUE_RANK_FUMBLE])
				{
					$step2 = $v[DATA_BASE_LEAGUE_RANK_GOAL] - $v[DATA_BASE_LEAGUE_RANK_FUMBLE];
					$bSame = false;
					$index = $k;
				}
				else if($step1 == $v[DATA_BASE_LEAGUE_RANK_GOAL] - $v[DATA_BASE_LEAGUE_RANK_FUMBLE])
				{
					$bSame = true;
				}
			}
		}
		if(!$bSame)
		{
			return $index;
		}
		
		//3。第三步，积分相同的项，净胜球相同，判定总进球数
		$step3 = 0;
		foreach($data as $k=>$v)
		{
			if($step1 == $v[DATA_BASE_LEAGUE_RANK_INTEGRAL] && $step2 == $v[DATA_BASE_LEAGUE_RANK_GOAL] - $v[DATA_BASE_LEAGUE_RANK_FUMBLE])
			{
				if($step3 < $v[DATA_BASE_LEAGUE_RANK_GOAL])
				{
					$step3 = $v[DATA_BASE_LEAGUE_RANK_GOAL];
					$bSame = false;
					$index = $k;
				}
				else if($step3 == $v[DATA_BASE_LEAGUE_RANK_GOAL])
				{
					$bSame = true;
				}
			}
		}
		
		//TODO:

		return $index;
	}
	
	//////////////////////////////////////////////////
	//协议层组装
	//////////////////////////////////////////////////
	
	function getLeagueRank($leagueId)
	{
//		$leagueRankModel = new LeagueRankModel();

	/*	if(!$leagueRankModel || !$leagueRankModel->init($this->_leagueId))
			return null;
		
		$data = $leagueRankModel->data();*/
		$leagueModel = LeagueRankModelMgr::Instance()->getModelList( LEAGUE_RANK_MODEL_DEFAULT,array($leagueId));
		if(!empty($leagueModel))
			return null;

		foreach($leagueModel as $primaryKey => $model) {
			$data = $leagueModel[$primaryKey]->data();

			if (count($data) != 14)
				return null;

			$rank = Array();
			while (count($data)) {
				$index = $this->__compareRank($data);
				if ($index == -1)
					break;

				$sLeagueRankInfo = new SLeagueRankInfo;
				if (!$sLeagueRankInfo)
					continue;

				$sLeagueRankInfo->__UserId = $data[$index][DATA_BASE_LEAGUE_RANK_LEAGUER];
				$sLeagueRankInfo->__LastRank = $data[$index][DATA_BASE_LEAGUE_RANK_LASTRANK];

				$sLeagueRankInfo->__ClubName = "";
				$clubLogic = new ClubLogic();
				if ($clubLogic && $clubLogic->init($sLeagueRankInfo->__UserId)) {
					$sLeagueRankInfo->__ClubName = $clubLogic->getModel()->getFieldByIndex(DATA_BASE_CLUB_CLUBNAME);
					$sLeagueRankInfo->__TeamSign = $clubLogic->getClubTeamSign();
				}

				$sLeagueRankInfo->__Finish = $data[$index][DATA_BASE_LEAGUE_RANK_FINISH];
				$sLeagueRankInfo->__Succ = $data[$index][DATA_BASE_LEAGUE_RANK_SUCC];
				$sLeagueRankInfo->__Draw = $data[$index][DATA_BASE_LEAGUE_RANK_DRAW];
				$sLeagueRankInfo->__Fail = $data[$index][DATA_BASE_LEAGUE_RANK_FAIL];
				$sLeagueRankInfo->__Goal = $data[$index][DATA_BASE_LEAGUE_RANK_GOAL];
				$sLeagueRankInfo->__Fumble = $data[$index][DATA_BASE_LEAGUE_RANK_FUMBLE];
				$sLeagueRankInfo->__Integral = $data[$index][DATA_BASE_LEAGUE_RANK_INTEGRAL];
				$sLeagueRankInfo->__Performance = $data[$index][DATA_BASE_LEAGUE_RANK_PERFORMANCE];

				$rank[] = $sLeagueRankInfo;

				$data[$index] = null;
				unset($data[$index]);
			}

			return $rank;
		}
	}
	
	function getLeagueSchedule($round, $my = null,$leagueId)
	{
//		$scheduleModel = new LeagueScheduleModel();
		$leagueModel = LeagueScheduleModelMgr::Instance()->getModelList( LEAGUE_SCHEDULE_MODEL_DEFAULT,array($leagueId));

		if(empty($leagueModel))
			return null;

		foreach($leagueModel as $primaryKey => $model) {
			$data = $leagueModel[$primaryKey]->data();
			if (!$data)
				return null;

			$schedule = Array();
			foreach ($data as $v) {
				if (in_array($v[DATA_BASE_LEAGUE_SCHEDULE_ROUND], $round)) {
					$one = new SLeagueScheduleInfo;
					if (!$one)
						continue;

					if ($my && ($my != $v[DATA_BASE_LEAGUE_SCHEDULE_LEAGUER1] && $my != $v[DATA_BASE_LEAGUE_SCHEDULE_LEAGUER2]))
						continue;

					$one->__RoomId = $v[DATA_BASE_LEAGUE_SCHEDULE_ROOMID];
					$one->__Round = $v[DATA_BASE_LEAGUE_SCHEDULE_ROUND];
					$one->__NO = $v[DATA_BASE_LEAGUE_SCHEDULE_NO];
					$one->__UserId1 = $v[DATA_BASE_LEAGUE_SCHEDULE_LEAGUER1];
					$clubLogic1 = new ClubLogic();
					if ($clubLogic1 && $clubLogic1->init($one->__UserId1)) {
						$one->__ClubName1 = $clubLogic1->getModel()->getFieldByIndex(DATA_BASE_CLUB_CLUBNAME);
						$one->__TeamSign1 = $clubLogic1->getClubTeamSign();
					}

					$one->__UserId2 = $v[DATA_BASE_LEAGUE_SCHEDULE_LEAGUER2];
					$clubLogic2 = new ClubLogic();
					if ($clubLogic2 && $clubLogic2->init($one->__UserId2)) {
						$one->__ClubName2 = $clubLogic2->getModel()->getFieldByIndex(DATA_BASE_CLUB_CLUBNAME);
						$one->__TeamSign2 = $clubLogic2->getClubTeamSign();
					}

					$one->__StartTime = $v[DATA_BASE_LEAGUE_SCHEDULE_STARTTIME];
					$one->__Status = $v[DATA_BASE_LEAGUE_SCHEDULE_STATUS];
					$one->__Score = array($v[DATA_BASE_LEAGUE_SCHEDULE_SCORE1], $v[DATA_BASE_LEAGUE_SCHEDULE_SCORE2]);
					$one->__IsLocked = $v[DATA_BASE_LEAGUE_SCHEDULE_ISLOCKED];

					$schedule[] = $one;
				}
			}

			return $schedule;
		}
	}

	function getLeagueFBRank()
	{
		MemInfoLogic::Instance()->setMemData(LEAGUE_FOOTBALLER_FRONT."_".$this->_leagueId, null);
		$front = MemInfoLogic::Instance()->getMemData(LEAGUE_FOOTBALLER_FRONT."_".$this->_leagueId);
		if(!$front)
		{
			$ids = LeagueFBRankModel::getLeagueFrontFive($this->_leagueId, LeagueLogic::getLeagueIndex(), LEAGUE_FB_RANK_TYPE_SHOOT);
			if($ids)
			{
				foreach ($ids as $v)
				{
					$front[LEAGUE_FB_RANK_TYPE_SHOOT][] = $v;
				}
			}
			$ids = LeagueFBRankModel::getLeagueFrontFive($this->_leagueId, LeagueLogic::getLeagueIndex(), LEAGUE_FB_RANK_TYPE_MARK);
			if($ids)
			{
				foreach ($ids as $v)
				{
					$front[LEAGUE_FB_RANK_TYPE_MARK][] = $v;
				}
			}
			$ids = LeagueFBRankModel::getLeagueFrontFive($this->_leagueId, LeagueLogic::getLeagueIndex(), LEAGUE_FB_RANK_TYPE_ASSISTS);
			if($ids)
			{
				foreach ($ids as $v)
				{
					$front[LEAGUE_FB_RANK_TYPE_ASSISTS][] = $v;
				}
			}
			
			MemInfoLogic::Instance()->setMemData(LEAGUE_FOOTBALLER_FRONT."_".$this->_leagueId, $front);
		}
		
		$rank = Array(LEAGUE_FB_RANK_TYPE_SHOOT=>array(), LEAGUE_FB_RANK_TYPE_MARK=>array(), LEAGUE_FB_RANK_TYPE_ASSISTS=>array());
		for($i = 0; $i < count($front[LEAGUE_FB_RANK_TYPE_SHOOT]); $i++)
		{
			$one = new SLeagueFootballerRank;
			if(!$one)
				continue;
			
			//射手榜
			$one->__UserId = $front[LEAGUE_FB_RANK_TYPE_SHOOT][$i]["userid"];
			$one->__CardId = $front[LEAGUE_FB_RANK_TYPE_SHOOT][$i]["carduid"];
			$clubLogic = new ClubLogic();
			if($clubLogic && $clubLogic->init($one->__UserId))
			{
				$one->__ClubName = $clubLogic->getModel()->getFieldByIndex(DATA_BASE_CLUB_CLUBNAME);
				$one->__TeamSign = $clubLogic->getClubTeamSign();
			}
			$one->__RankResult = $front[LEAGUE_FB_RANK_TYPE_SHOOT][$i]["rankresult"];
			$rank[LEAGUE_FB_RANK_TYPE_SHOOT][] = $one;
		}
		for($i = 0; $i < count($front[LEAGUE_FB_RANK_TYPE_MARK]); $i++)
		{
			$one = new SLeagueFootballerRank;
			if(!$one)
				continue;
			//积分榜
			$one->__UserId = $front[LEAGUE_FB_RANK_TYPE_MARK][$i]["userid"];
			$one->__CardId = $front[LEAGUE_FB_RANK_TYPE_MARK][$i]["carduid"];
			$clubLogic = new ClubLogic();
			if($clubLogic && $clubLogic->init($one->__UserId))
			{
				$one->__ClubName = $clubLogic->getModel()->getFieldByIndex(DATA_BASE_CLUB_CLUBNAME);
				$one->__TeamSign = $clubLogic->getClubTeamSign();
			}
			$one->__RankResult = $front[LEAGUE_FB_RANK_TYPE_MARK][$i]["rankresult"];
			$rank[LEAGUE_FB_RANK_TYPE_MARK][] = $one;
		}
		for($i = 0; $i < count($front[LEAGUE_FB_RANK_TYPE_ASSISTS]); $i++)
		{
			$one = new SLeagueFootballerRank;
			if(!$one)
				continue;
			//助攻榜
			$one->__UserId = $front[LEAGUE_FB_RANK_TYPE_ASSISTS][$i]["userid"];
			$one->__CardId = $front[LEAGUE_FB_RANK_TYPE_ASSISTS][$i]["carduid"];
			$clubLogic = new ClubLogic();
			if($clubLogic && $clubLogic->init($one->__UserId))
			{
				$one->__ClubName = $clubLogic->getModel()->getFieldByIndex(DATA_BASE_CLUB_CLUBNAME);
				$one->__TeamSign = $clubLogic->getClubTeamSign();
			}
			$one->__RankResult = $front[LEAGUE_FB_RANK_TYPE_ASSISTS][$i]["rankresult"];
			$rank[LEAGUE_FB_RANK_TYPE_ASSISTS][] = $one;
	
		}
	
		return $rank;
	}
	
	function lockGameTime()
	{
		
	}
	
	function modifyGameTime()
	{
		
	}
	
	function test()
	{
		$PlayerLogic = new PlayerLogic();
	}
}
