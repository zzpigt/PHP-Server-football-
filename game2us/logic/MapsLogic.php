<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_PROTO_PATH."proto.php");

class MapsLogic
{
	const MAP_HEIGHT = 13;
	const MAP_WIDTH = 20;

	const DRIBBLE_MAX_VALUE = 100;
	const DRIBBLE_NEAR_Y = 40;
	const DRIBBLE_UNCHANGED_Y = 40;
	const DRIBBLE_FAR_Y = 20;

	const DRIBBLE_NEAR_X = 90;
	const DRIBBLE_UNCHANGED_X = 5;
	const DRIBBLE_FAR_X = 5;

	const DISTANCE_NEAR_VALUE = -1;
	const DISTANCE_UNCHANGED_VALUE = 0;
	const DISTANCE_FAR_VALUE = 1;

	const COORDINATE_X = 0;
	const COORDINATE_Y = 1;

	private static $_instance = null;

	static function getInstance()
	{
		if (!self::$_instance instanceof self) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

//	function getMapInfo()
//	{
//		$_map = S("MAP");
//		if(empty($_map))
//		{
//			$_map = array();
//			for($row = 1;$row <= self::MAP_WIDTH; $row ++)
//			{
//				for($column = 1; $column <=self::MAP_HEIGHT;$column++)
//				{
//					$_map[$row][$column] = $column;
//				}
//			}
//
//			$_map = S("MAP", $_map);
//		}
//
//		return $_map;
//	}

	function isPenalty($position)
	{
		if($position[0]>=17 && $position[1]>=4 && $position[1]<=10)
		{
			return true;
		}

		if($position[0]<=4 && $position[1]>=4 && $position[1]<=10)
		{
			return true;
		}

		return false;
	}

	function regionOut($position)
	{
		$_tempCoordinate = [0, 0];

		if(empty($position))
		{
			return $_tempCoordinate;
		}
		$_tempCoordinate = $position;

		if($position[self::COORDINATE_X] > self::MAP_WIDTH)
		{
			$_tempCoordinate[self::COORDINATE_X] = self::MAP_WIDTH;
		}
		else if($position[self::COORDINATE_X] < 1)
		{
			$_tempCoordinate[self::COORDINATE_X] = 1;
		}

		if($position[self::COORDINATE_Y] > self::MAP_HEIGHT)
		{
			$_tempCoordinate[self::COORDINATE_Y] = self::MAP_HEIGHT;
		}
		else if($position[self::COORDINATE_Y] < 1)
		{
			$_tempCoordinate[self::COORDINATE_Y] = 1;
		}

		return $_tempCoordinate;
	}

	/*
	 * 取得带球的随机区域
	 * */
	function getRandRegion($isHome, $isHalf, $position)
	{
		$_distanceY = $this->_getDribbleDistanceY();
		if($position[self::COORDINATE_Y] - 7 > 0)
		{
			$position[self::COORDINATE_Y] += $_distanceY;
		}
		else
		{
			$position[self::COORDINATE_Y] -= $_distanceY;
		}

		$_distanceX = null;
		//如果Y轴未移动X轴必须移动
		if(empty($_distanceY))
		{
			$_distanceX = $this->_getDribbleDistanceX(true);
		}
		else
		{
			$_distanceX = $this->_getDribbleDistanceX(false);
		}

		if(($isHome && $isHalf) || (!$isHome && !$isHalf))
		{
			$position[self::COORDINATE_X] -= $_distanceX;//$_distanceX为相对距离（前进一格为-1）
		}
		else
		{
			$position[self::COORDINATE_X] += $_distanceX;
		}

		return $position;
	}

	/*
    * 两坐标相加
    * */
	function coordinateAdd($_coordinateA, $_coordinateB)
	{
		if(empty($_coordinateA) || empty($_coordinateB))
		{
			return null;
		}

		$_tempArr[self::COORDINATE_X] = $_coordinateA[self::COORDINATE_X] + $_coordinateB[self::COORDINATE_X];
		$_tempArr[self::COORDINATE_Y] = $_coordinateA[self::COORDINATE_Y] + $_coordinateB[self::COORDINATE_Y];
		return $_tempArr;
	}

	/*
    * 两坐标相减
    * */
	function coordinateSub($_coordinateA, $_coordinateB)
	{
		if(empty($_coordinateA) || empty($_coordinateB))
		{
			return null;
		}

		$_tempArr[self::COORDINATE_X] = $_coordinateA[self::COORDINATE_X] - $_coordinateB[self::COORDINATE_X];
		$_tempArr[self::COORDINATE_Y] = $_coordinateA[self::COORDINATE_Y] - $_coordinateB[self::COORDINATE_Y];
		return $_tempArr;
	}

	/*
	 * 取得带球Y轴相对距离
	 * */
	private function _getDribbleDistanceY()
	{
		$_moveWeightY = [self::DRIBBLE_NEAR_Y, self::DRIBBLE_NEAR_Y+self::DRIBBLE_UNCHANGED_Y];
		$_seed = rand(1, self::DRIBBLE_MAX_VALUE);
		$_moveRegionY = [self::DISTANCE_NEAR_VALUE, self::DISTANCE_UNCHANGED_VALUE];
		foreach($_moveWeightY as $key => $weight)
		{
			if($weight >= $_seed)
			{
				return $_moveRegionY[$key];
			}
		}
		return self::DISTANCE_FAR_VALUE;
	}

	/*
 	 * 取得带球X轴相对距离
 	 * */
	private function _getDribbleDistanceX($isChanged)
	{
		$_moveWeightY = [self::DRIBBLE_NEAR_X, self::DRIBBLE_NEAR_X+self::DRIBBLE_UNCHANGED_X];

		$_maxSeed = self::DRIBBLE_MAX_VALUE;
		if($isChanged)
		{
			$_maxSeed -= self::DRIBBLE_UNCHANGED_X;
		}
		$_seed = rand(1, $_maxSeed);
		$_moveRegionX = [self::DISTANCE_NEAR_VALUE, self::DISTANCE_FAR_VALUE];
		foreach($_moveWeightY as $key => $weight)
		{
			if($weight >= $_seed)
			{
				return $_moveRegionX[$key];
			}
		}

		return self::DISTANCE_UNCHANGED_VALUE;
	}

	/*
	 * 取得传球的相对位置
	 * 参数：
	 * 	$lineArr：对应球员可以传的线的集合
	 * */
	function getPassBallDistance($lineArr)
	{
		//相对位置权重
		$_weight = [
			10,
			10,
			10,
			10,
			460,
			2000,
			4000,
			2000,
			1000,
			450,
			50
		];
		//相对位置
		$_position = [
			-5,
			-4,
			-3,
			-2,
			-1,
			0,
			1,
			2,
			3,
			4,
			5
		];

		$_seedMaxValueArr = array();
		$_totalWeight = 0;
		foreach($lineArr as $key => $value)
		{
			$_positionIndex = $key + 5;//相对位置与数组索引相对

			//加上前一次的权重
			if(!isset($_seedMaxValueArr[$_positionIndex]))
			{
				$_seedMaxValueArr[$_positionIndex] = 0;
			}

			$_curSeed = $_weight[$_positionIndex];

			$_totalWeight += $_curSeed;
			$_seedMaxValueArr[$_positionIndex] += $_totalWeight;
		}

		$_seed = rand(1, $_totalWeight);
		foreach($_seedMaxValueArr as $key => $value)
		{
			if($value >= $_seed)
			{
				return $_position[$key];
			}
		}

		return 0;
	}

	/*
	 * 取得两点的距离
	 * 参数：
	 *  $positionA：坐标
	 *  $positionB：坐标
	 * */
	function getPointDistance($positionA, $positionB)
	{
		if(!is_array($positionA) && !is_array($positionB))
		{
			return 0;
		}

		$_positionX = $positionA[self::COORDINATE_X] - $positionB[self::COORDINATE_X];
		$_positionY = $positionA[self::COORDINATE_Y] - $positionB[self::COORDINATE_Y];
		return sqrt($_positionX*$_positionX + $_positionY*$_positionY);
    }

	public function getInfo()
	{
		$mapGather = new SMapGather();
		$mapMem = $this->__user->getOneUserData(USER_DATA_FIRST_MAPS);
		foreach($mapMem as $key=>$value)
		{
			$map = new SMap();
			$map->__MapType = $key;
			foreach($value as $mapId=>$mapInfo)
			{
				$mapInfo = new SMapInfo();
				$mapInfo->__MapId = $mapId;
				foreach($mapInfo as $childMapId=>$chidMapInfo)
				{
					$childMapInfo = new SChildMapInfo();
					$childMapInfo->__ChildMapId = $childMapId;
					
					$childMapConfig = XmlConfigMgr::getInstance()->getChildMapsConfig()->findChildMapConfig($childMapId);
					if($childMapConfig && $childMapConfig['type'] == CHILD_MAP_TYPE_LIMITNUMBER)
					{
						if($chidMapInfo[1] != getMyDayIndex())
						{
							$chidMapInfo[0] = 0;
						}
					}
					$childMapInfo->__State = $chidMapInfo[0];
					array_push($mapInfo->__ChildMapArr, $childMapInfo);
				}
				array_push($map->__MapArr, $mapInfo);
			}
			array_push($mapGather->__MapGahterArr, $map);
		}
		return $mapGather;
	}
	
	public function addMap($mapId)
	{
		$mapConfig = XmlConfigMgr::getInstance()->getMapsConfig()->findMapConfig($mapId);
		if($mapConfig)
		{
			$mapMem = $this->__user->getOneUserData(USER_DATA_FIRST_MAPS);
			
			$mapMem[MAP_TYPE_COMMON][$mapId][intval($mapConfig['firstchildmap'])] = array();
			
			$this->__user->setOneUserData($mapMem, USER_DATA_FIRST_MAPS);
		}
		
	}
	
	public function doPve($mapId, $childMapId, &$ack)
	{
		
		$mapConfig = XmlConfigMgr::getInstance()->getMapsConfig()->findMapConfig($mapId);
		$mapMem = $this->__user->getOneUserData(USER_DATA_FIRST_MAPS);
		if($mapConfig)
		{
			if($mapConfig['type'] == MAP_TYPE_ACTIVE)
			{
				$begin = explode('-', $mapConfig['begintime']);
				$end = explode('-', $mapConfig['endtime']);
			
				$beginUnix = mktime(0, 0, 0,$begin[1], $begin[2], $begin[0]);
				$endUnix = mktime(0, 0, 0,$end[1], $end[2], $end[0]);
			
				$now = time();
				if($beginUnix > $now && $now > $endUnix)
				{
					return ERROR_ACTIVE_MAP_TIME;
				}
			}
			
			if(!isset($mapMem[$mapConfig['type']][$mapId]))
			{
				return ERROR_OPEN_MAP;
			}
			if(!isset($mapMem[$mapConfig['type']][$mapId][$childMapId]))
			{
				return ERROR_OPEN_CHILD_MAP;
			}
			
			$childMapConfig = XmlConfigMgr::getInstance()->getChildMapsConfig()->findChildMapConfig($childMapId);
			if($childMapConfig)
			{
				if(!$this->__user->getPropertyLogic()->judgeOperation(USER_DATA_PROPERTY_POWERCUR, $childMapConfig['power']))
				{
					return ERROR_POWER_NOT_ENOUGH;
				}
				
				if($childMapConfig['type'] == CHILD_MAP_TYPE_LIMITNUMBER)
				{
					
					if($mapMem[$mapConfig['type'][$mapId][$childMapId][1]] != getMyDayIndex())
					{
						$mapMem[$mapConfig['type'][$mapId][$childMapId][0]] = 0;	
					}	
					
					if($mapMem[$mapConfig['type'][$mapId][$childMapId][0]] >= $childMapConfig['limit'])
					{
						return ERROR_CHILD_MAP_LIMIT_USED;
					}
				}
				
				
				$NPC = $this->createNPC($childMapConfig);
				$ack->__NPCCardBag = $NPC->getCardsLogic()->getInfo();
				
				$fight = new FightLogic();
				$fight->init($this->__user, $NPC);
				
				$result = $fight->playGame();
				$ack->__MyResult = $result[0];
				$ack->__NPCResult = $result[1];
				
				
				$dropArr = $this->__user->getDropLogic()->getMapDrop($childMapId);
				foreach($dropArr as $value)
				{
					$this->__user->getDropLogic()->dealDrop($value);
					$drop = new SDrop();
					if(!empty($value[0]))
					{
						$drop->__Id = $value[0];
					}
					if(!empty($value[1]))
					{
						$drop->__Param1 = $value[1];
					}
					if(!empty($value[2]))
					{
						$drop->__Param2 = $value[2];
					}
					if(!empty($value[3]))
					{
						$drop->__Param3 = $value[3];
					}
					array_push($ack->__Drop, $drop);
				}
				$this->__user->setOneUserData($mapMem, USER_DATA_FIRST_MAPS);
				return ERROR_OK;
			}
		}
		return ERROR_FIGHT;
	}
	
	public function testPVE(&$ack)
	{
		$npc1Config = array(
					'formation1' => '101,1,1|102,1,1',
					'formation2' => '103,1,1|104,1,1',
					'formation3' => '105,1,1|106,1,1',
					'formation4' => '107,1,1',
					'formation5' => '108,1,1|109,1,1|110,1,1|111,1,1',
					);
		$npc2Config = array(
					'formation1' => '112,1,1|113,1,1',
					'formation2' => '114,1,1|115,1,1',
					'formation3' => '116,1,1|117,1,1',
					'formation4' => '118,1,1',
					'formation5' => '119,1,1|120,1,1|121,1,1|122,1,1',
					);
		$NPC1 = $this->createNPC($npc1Config);
		$NPC2 = $this->createNPC($npc2Config);
		
		$ack->__NPC1CardBag = $NPC1->getCardsLogic()->getInfo();
		$ack->__NPC2CardBag = $NPC2->getCardsLogic()->getInfo();
				
		$fight = new FightLogic();
		$fight->init($NPC1, $NPC2);
				
		$result = $fight->playGame();
		$ack->__NPC1Result = $result[0];
		$ack->__NPC2Result = $result[1];
	}
	
	private function createNPC($childMapConfig)
	{
//		$NPC = new UserModel();
//		$NPC->initNPCData();
//		//ǰ��
//		$cardInfo1Arr = explode('|', $childMapConfig['formation1']);
//		$NPC->getFormationLogic()->initPosition(USER_DATA_FORMATION_FORWARD,count($cardInfo1Arr));
//		foreach($cardInfo1Arr as $key=>$value)
//		{
//			$cardInfo1 = explode(',', $value);
//			$cardUid1 = $NPC->getCardsLogic()->addNPCCard(intval($cardInfo1[0]),intval($cardInfo1[1]),intval($cardInfo1[2]));
//			$NPC->getFormationLogic()->changePosition(array(), array(USER_DATA_FORMATION_FORWARD, $key+1), $cardUid1);
//		}
//		//�з�
//		$cardInfo2Arr = explode('|', $childMapConfig['formation2']);
//		$NPC->getFormationLogic()->initPosition(USER_DATA_FORMATION_CENTERFORWARD,count($cardInfo2Arr));
//		foreach($cardInfo2Arr as $key=>$value)
//		{
//			$cardInfo2 = explode(',', $value);
//			$cardUid2 = $NPC->getCardsLogic()->addNPCCard(intval($cardInfo2[0]),intval($cardInfo2[1]),intval($cardInfo2[2]));
//			$NPC->getFormationLogic()->changePosition(array(), array(USER_DATA_FORMATION_CENTERFORWARD, $key+1), $cardUid2);
//		}
//		//����
//		$cardInfo3Arr = explode('|', $childMapConfig['formation3']);
//		$NPC->getFormationLogic()->initPosition(USER_DATA_FORMATION_GUARD,count($cardInfo3Arr));
//		foreach($cardInfo3Arr as $key=>$value)
//		{
//			$cardInfo3 = explode(',', $value);
//			$cardUid3 = $NPC->getCardsLogic()->addNPCCard(intval($cardInfo3[0]),intval($cardInfo3[1]),intval($cardInfo3[2]));
//			$NPC->getFormationLogic()->changePosition(array(), array(USER_DATA_FORMATION_GUARD, $key+1), $cardUid3);
//		}
//		//����Ա
//		$cardInfo4Arr = explode('|', $childMapConfig['formation4']);
//		$NPC->getFormationLogic()->initPosition(USER_DATA_FORMATION_GOALKEEPER,count($cardInfo4Arr));
//		foreach($cardInfo4Arr as $key=>$value)
//		{
//			$cardInfo4 = explode(',', $value);
//			$cardUid4 = $NPC->getCardsLogic()->addNPCCard(intval($cardInfo4[0]),intval($cardInfo4[1]),intval($cardInfo4[2]));
//			$NPC->getFormationLogic()->changePosition(array(), array(USER_DATA_FORMATION_GOALKEEPER, $key+1), $cardUid4);
//		}
//		//��
//		$cardInfo5Arr = explode('|', $childMapConfig['formation5']);
//		$NPC->getFormationLogic()->initPosition(USER_DATA_FORMATION_ALTERNATIVE,count($cardInfo5Arr));
//		foreach($cardInfo5Arr as $key=>$value)
//		{
//			$cardInfo5 = explode(',', $value);
//			$cardUid5 = $NPC->getCardsLogic()->addNPCCard(intval($cardInfo5[0]),intval($cardInfo5[1]),intval($cardInfo5[2]));
//			$NPC->getFormationLogic()->changePosition(array(), array(USER_DATA_FORMATION_ALTERNATIVE, $key+1), $cardUid5);
//		}
//		return $NPC;
	}
	
	
}