<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_MODEL_PATH."CardsModel.php");
include_once(APP_LOGIC_PATH."ClubLogic.php");
include_once(APP_PROTO_PATH."proto.php");
include_once(APP_BASE_PATH."Formula.php");


define("CARD_CREATE_TYPE_BID", 1);//转会竞标
define("CARD_CREATE_TYPE_SCOUT", 2);//球探球员
define("CARD_CREATE_TYPE_RECOMMEND", 3);//推荐球员
define("CARD_CREATE_TYPE_CANTERA", 4);//青训球员
define("CARD_CREATE_TYPE_LEAGUE", 5);//联赛球员

class CardsLogic
{
    const CONST_PARA_STANDARDRATING = 37;

    private static $_cardsModelArr = Array();
    
    private $_cardsModel;
    private $_userId;
    
    private $_number = 0;
    function init($userId)
    {
    	$this->_userId = $userId;
        $this->_cardsModel = new CardsModel();
        if(empty($this->_cardsModel) || !$this->_cardsModel->init($userId))
        {
            return false;
        }
        return true;
    }
    
    function getModel()
    {
    	return $this->_cardsModel;
    }

	function _getCardsStrut($cardId, $matchLevel, $constant)
	{
		$cardList = array();
        $cardConfig = XmlConfigMgr::getInstance()->getPlayerDataConfig()->findPlayerDataConfig($cardId);
        $cardList[USER_DATA_CARDS_CID] = $cardId;
        //此处需要读表
        $cardList[USER_DATA_CARDS_USERID] = $this->_cardsModel->UserId();
        $cardList[USER_DATA_CARDS_NATIONALITY] = $cardConfig['Nationality'];
        $cardList[USER_DATA_CARDS_NAME] = $cardConfig['Name'];
        $cardList[USER_DATA_CARDS_FAMILYNAME] = $cardConfig['Familyname'];
        $cardList[USER_DATA_CARDS_HEIGHT] = $cardConfig['Height'];
        $cardList[USER_DATA_CARDS_WEIGHT] = $cardConfig['Weight'];
        $cardList[USER_DATA_CARDS_POSITION1] = $cardConfig['Position1'];
        $cardList[USER_DATA_CARDS_POSITION2] = $cardConfig['Position2'];
        $cardList[USER_DATA_CARDS_POSITION3] = $cardConfig['Position3'];//11
        $cardList[USER_DATA_CARDS_PREFERREDFOOT] = $cardConfig['Preferredfoot'];
        $cardList[USER_DATA_CARDS_FEILDPOSITION] = $cardConfig['Feildposition'];
        $cardList[USER_DATA_CARDS_AGE] = $cardConfig['Age'];
        $cardList[USER_DATA_CARDS_RETIREAGE] = $cardConfig['Retireage'];
        $cardList[USER_DATA_CARDS_CLUB] = $cardConfig['Club'];
        $cardList[USER_DATA_CARDS_VALUE] = $cardConfig['Value'];
        $cardList[USER_DATA_CARDS_WAGE] = $cardConfig['Wage'];
        $cardList[USER_DATA_CARDS_NUMBER] = $cardConfig['Number'];
        $cardList[USER_DATA_CARDS_CONTRATVALIDUNTIL] = $cardConfig['Contratvaliduntil'];//20
        $cardList[USER_DATA_CARDS_FINISHING] = $cardConfig['Finishing'];
        $cardList[USER_DATA_CARDS_CROSSING] = $cardConfig['Crossing'];
        $cardList[USER_DATA_CARDS_HEADING] = $cardConfig['Heading'];
        $cardList[USER_DATA_CARDS_LONGSHOTS] = $cardConfig['Longshots'];//30
        $cardList[USER_DATA_CARDS_FREEKICK] = $cardConfig['Freekick'];
        $cardList[USER_DATA_CARDS_DRIBBLING] = $cardConfig['Dribbling'];
        $cardList[USER_DATA_CARDS_LONGPASSING] = $cardConfig['Longpassing'];
        $cardList[USER_DATA_CARDS_BALLCONTROL] = $cardConfig['Ballcontrol'];
        $cardList[USER_DATA_CARDS_CURVE] = $cardConfig['Curve'];
        $cardList[USER_DATA_CARDS_SHORTPASSIG] = $cardConfig['Shortpassig'];
        $cardList[USER_DATA_CARDS_POWER] = $cardConfig['Power'];
        $cardList[USER_DATA_CARDS_STAMINA] = $cardConfig['Stamina'];
        $cardList[USER_DATA_CARDS_STRENGTH] = $cardConfig['Strength'];
        $cardList[USER_DATA_CARDS_REACTION] = $cardConfig['Reaction'];
        $cardList[USER_DATA_CARDS_SPEED] = $cardConfig['Speed'];//40
        $cardList[USER_DATA_CARDS_AGGRESSION] = $cardConfig['Aggression'];
        $cardList[USER_DATA_CARDS_MOVEMENT] = $cardConfig['Movement'];
        $cardList[USER_DATA_CARDS_VISION] = $cardConfig['Vision'];
        $cardList[USER_DATA_CARDS_COMPOSURE] = $cardConfig['Composure'];
        $cardList[USER_DATA_CARDS_PENALTIES] = $cardConfig['Penalties'];
        $cardList[USER_DATA_CARDS_MARKING] = $cardConfig['Marking'];
        $cardList[USER_DATA_CARDS_STANDINGTACKLE] = $cardConfig['Standingtackle'];
        $cardList[USER_DATA_CARDS_SLIDINGTACKLE] = $cardConfig['Slidingtackle'];
        $cardList[USER_DATA_CARDS_INTERCEPTIONS] = $cardConfig['Interceptions'];
        $cardList[USER_DATA_CARDS_POSTIONING] = $cardConfig['Postioning'];
        $cardList[USER_DATA_CARDS_GKDIVING] = $cardConfig['Gkdiving'];
        $cardList[USER_DATA_CARDS_GKHANDING] = $cardConfig['Gkhanding'];
        $cardList[USER_DATA_CARDS_GKPOSTIONING] = $cardConfig['Gkpostioning'];
        $cardList[USER_DATA_CARDS_GKREFLEXES] = $cardConfig['Gkreflexes'];
        $cardList[USER_DATA_CARDS_GKKICKING] = $cardConfig['Gkkicking'];

        $cardList[USER_DATA_CARDS_ATTACK] = $this->countAttackAttribute($constant, $matchLevel, $cardList, $cardList[USER_DATA_CARDS_POSITION1]);
        $cardList[USER_DATA_CARDS_SKILL] = $this->countSkillAttribute($constant, $matchLevel, $cardList, $cardList[USER_DATA_CARDS_POSITION1]);
        $cardList[USER_DATA_CARDS_PHYSICALITY] = $this->countPhysicalityAttribute($constant, $matchLevel, $cardList, $cardList[USER_DATA_CARDS_POSITION1]);
        $cardList[USER_DATA_CARDS_MENTALITY] = $this->countMentalityAttribute($constant, $matchLevel, $cardList, $cardList[USER_DATA_CARDS_POSITION1]);
        $cardList[USER_DATA_CARDS_DEFENCE] = $this->countDefenseAttribute($constant, $matchLevel, $cardList, $cardList[USER_DATA_CARDS_POSITION1]);
        $cardList[USER_DATA_CARDS_GAOLKEEPING] = $this->countGoalKeepAttribute($constant, $matchLevel, $cardList, $cardList[USER_DATA_CARDS_POSITION1]);
		return $cardList;	
	}

	static function countGeneral($cardData)
	{
		if(is_array($cardData))
		{
			$_general = 0;
			for($field = USER_DATA_CARDS_ATTACK; $field <= USER_DATA_CARDS_GAOLKEEPING; $field++ )
			{
				if(!empty($cardData[$field]))
				{
					$_general += $cardData[$field];
				}
			}
			return $_general / 6;
		}
		return 0;
	}

	function CardsModel()
	{
		if($this->_cardsModel instanceof CardsModel)
		{
			return $this->_cardsModel;
		}
		return null;
	}

	function getInfo()
	{
        printError($this->_cardsModel, __METHOD__);
	    $cards = $this->_cardsModel->getCardData();
        $bag = new SCardBag();
	    foreach ($cards as $key => $info)
        {
			array_push($bag->__CardArr, $this->_getSCardInfo($info, $key));
        }

		return $bag;
	}

	private function _getSCardInfo($data, $index)
    {
        $infos = new SCardInfos();
        $infos->__Uid = $data[DATA_BASE_CARDS_UID];
        $infos->__Cid = 0;
        $infos->__Index = $index;
        foreach($data as $type=>$value)
        {
            $info = new SInfo();
            $info->__Type = $type;
			if(is_array($value))
			{
				$_statisticsArr = array();
				foreach($value as $key => $val)
				{
					$_info = new SInfo();
					$_info->__Type = $key;
					if($key == CARD_STATISTICS_SCORE)
					{
						$_info->__Value = base64_encode(json_encode($val));
					}
					else
					{
						$_info->__Value = $val;
					}
					array_push($_statisticsArr, $_info);
				}
				$info->__Value = base64_encode(json_encode($_statisticsArr));
			}
			else
			{
				$info->__Value = $value;
			}
            array_push($infos->__InfoArr, $info);
        }

        return $infos;
    }

    function addCard($cardId, $first = true, $isCaptain = 0, $level = 1, $star = 1)
    {
        $_constant = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig(self::CONST_PARA_STANDARDRATING)['Value'];
        $newCard = $this->_getCardsStrut($cardId, $level, $_constant);
        if($this->_cardsModel->insertCardData($newCard))
        {
            if(!$first)
            {
                $uId = $this->_cardsModel->getInsertId();
                $newCard[DATA_BASE_CARDS_UID] = $uId;
                return $this->getSCardInfo($newCard, $this->_cardsModel->getMaxIndex());
            }
        }
        return null;
    }
    
    private function _createCardByLeague($position, $leagueLevel, $playerConfig, $type)
    {
    	switch ($position)
    	{
    		case FOOTBALLER_POSITION_UNLIMITED:
    			{
    				$positionCreateConfig = XmlConfigMgr::getInstance()->getPositionCreateConfig()->getConfig();
    				if(!$positionCreateConfig)
    					return false;
    		
    				$rand = 0;
    				foreach ($positionCreateConfig as $v)
    				{
    					$rand += $v["Weight"];
    				}
    				$rand = mt_rand(0, $rand);
    				foreach ($positionCreateConfig as $k => $v)
    				{
    					if($rand <= $v["Weight"])
    					{
    						$position = $k;
    						break;
    					}
    					$rand -= $v["Weight"];
    				}
    			}
    			break;
    			
    		case FOOTBALLER_POSITION_RWLWCF:
    			{
    				$randArr = array(FOOTBALLER_POSITION_RW, FOOTBALLER_POSITION_LW, FOOTBALLER_POSITION_CF);
    				
    				$positionCreateConfig = XmlConfigMgr::getInstance()->getPositionCreateConfig()->getConfig();
    				if(!$positionCreateConfig)
    					return false;
    				
    				$rand = 0;
    				foreach ($positionCreateConfig as $k => $v)
    				{
    					if(in_array($k, $randArr))
    						$rand += $v["Weight"];
    				}
    				$rand = mt_rand(0, $rand);
    				foreach ($positionCreateConfig as $v)
    				{
    					if(!in_array($k, $randArr))
    						continue;
    					
    					if($rand <= $v["Weight"])
    					{
    						$position = $k;
    						break;
    					}
    						
    					$rand -= $v["Weight"];
    				}
    				
    				$index = array_rand($randArr, 1);
    				$position = $randArr[$index];
    			}
    			break;
    			
    		case FOOTBALLER_POSITION_AMFCMFLMRMDMF:
    			{
    				$randArr = array(FOOTBALLER_POSITION_AMF, FOOTBALLER_POSITION_CMF, FOOTBALLER_POSITION_LM, FOOTBALLER_POSITION_RM, FOOTBALLER_POSITION_DMF);
    				
    				$positionCreateConfig = XmlConfigMgr::getInstance()->getPositionCreateConfig()->getConfig();
    				if(!$positionCreateConfig)
    					return false;
    				
    				$rand = 0;
    				foreach ($positionCreateConfig as $k => $v)
    				{
    					if(in_array($k, $randArr))
    						$rand += $v["Weight"];
    				}
    				$rand = mt_rand(0, $rand);
    				foreach ($positionCreateConfig as $k => $v)
    				{
    					if(!in_array($k, $randArr))
    						continue;
    					
    					if($rand <= $v["Weight"])
    					{
    						$position = $k;
    						break;
    					}
    						
    					$rand -= $v["Weight"];
    				}
    				
    				$index = array_rand($randArr, 1);
    				$position = $randArr[$index];
    			}
    			break;
    			
    		case FOOTBALLER_POSITION_LBCBRB:
    			{
    				$randArr = array(FOOTBALLER_POSITION_LB, FOOTBALLER_POSITION_CB, FOOTBALLER_POSITION_RB);
    				
    				$positionCreateConfig = XmlConfigMgr::getInstance()->getPositionCreateConfig()->getConfig();
    				if(!$positionCreateConfig)
    					return false;
    				
    				$rand = 0;
    				foreach ($positionCreateConfig as $k => $v)
    				{
    					if(in_array($k, $randArr))
    						$rand += $v["Weight"];
    				}
    				$rand = mt_rand(0, $rand);
    				foreach ($positionCreateConfig as $k => $v)
    				{
    					if(!in_array($k, $randArr))
    						continue;
    					
    					if($rand <= $v["Weight"])
    					{
    						$position = $k;
    						break;
    					}
    						
    					$rand -= $v["Weight"];
    				}
    				
    				$index = array_rand($randArr, 1);
    				$position = $randArr[$index];
    			}
    			break;
    	}
    	
    	$positionCreateConfig = XmlConfigMgr::getInstance()->getPositionCreateConfig()->findConfig($position);
    	if(!$positionCreateConfig)
    		return false;
    	 
    	$playerPositionConfig = XmlConfigMgr::getInstance()->getPlayerPositionConfig()->findPlayerPositionConfig($position);
    	if(!$playerPositionConfig)
    		return false;
    	
    	
    	$data[DATA_BASE_CARDS_USERID] = $this->_userId;
    	
    	$clubLogic = new ClubLogic();
    	if(!$clubLogic || !$clubLogic->init($this->_userId))
    		return false;
    	
    	if($playerConfig["Nationality"] == 1)
    	{
    		$countryId = XmlConfigMgr::getInstance()->getCountryConfig()->RandCountryId();
    		if(!$countryId)
    			return false;
    		
    		$data[DATA_BASE_CARDS_NATIONALITY] = $countryId;
    	}
    	else {
//			$data[DATA_BASE_CARDS_NATIONALITY] = $clubLogic->getModel()->getFieldByIndex(DATA_BASE_CLUB_COUNTRY);
			$data[DATA_BASE_CARDS_NATIONALITY] = ClubModelMgr::Instance()->getModelByPrimary($this->_userId)->getFieldByIndex(DATA_BASE_CLUB_COUNTRY);
		}
    	
    	$countryConfig = XmlConfigMgr::getInstance()->getCountryConfig()->findCountryConfig($data[DATA_BASE_CARDS_NATIONALITY]);
    	if(!$countryConfig)
    		return false;
    	
    	$nameConfig = XmlConfigMgr::getInstance()->getNameConfig()->getConfig();
    	if(!$nameConfig)
    		return false;
    	
    	$languageConfig = XmlConfigMgr::getInstance()->getLanguageConfig()->findConfig($countryConfig["LanguageType"]);
    	if(!$languageConfig)
    		return false;
    	
    	
    	$name = "";
    	$rand = 0;
    	if(isset($languageConfig["GKey"]))
    	{
    		$rand += $languageConfig["GUpperLimit"];
    	}
    	if(isset($languageConfig["DKey"]))
    	{
    		$rand += $languageConfig["DUpperLimit"];
    	}
    	
    	if($rand == 0)
    		return false;
    	
    	$rand = mt_rand(1, $rand);
    	$rand = sprintf("%03d", $rand);
    	if(isset($languageConfig["GKey"]))
    	{
    		if($rand <= $languageConfig["GUpperLimit"])
    		{
    			$nameConfig = XmlConfigMgr::getInstance()->getNameConfig()->findConfig($languageConfig["GKey"].$rand);
    			if($nameConfig)
    			{
    				$data[DATA_BASE_CARDS_NAME] = $languageConfig["GKey"].$rand;
    			}
    		}
    		else
    			$rand -= $languageConfig["GUpperLimit"];
    	}
    	if(isset($languageConfig["DKey"]))
    	{
    		if($rand <= $languageConfig["DUpperLimit"])
    		{
    			$nameConfig = XmlConfigMgr::getInstance()->getNameConfig()->findConfig($languageConfig["DKey"].$rand);
    			if($nameConfig)
    			{
    				$data[DATA_BASE_CARDS_NAME] = $languageConfig["DKey"].$rand;
    			}
    		}
    	}
    	
    	$familyName = "";
    	$rand = 0;
    	if(isset($languageConfig["FKey"]))
    	{
    		$rand += $languageConfig["FUpperLimit"];
    	}
    	if(isset($languageConfig["DKey"]))
    	{
    		$rand += $languageConfig["DUpperLimit"];
    	}
    	 
    	if($rand == 0)
    		return false;
    	 
    	$rand = mt_rand(1, $rand);
    	$rand = sprintf("%03d", $rand);
    	if(isset($languageConfig["FKey"]))
    	{
    		if($rand <= $languageConfig["FUpperLimit"])
    		{
    			$nameConfig = XmlConfigMgr::getInstance()->getNameConfig()->findConfig($languageConfig["FKey"].$rand);
    			if($nameConfig)
    			{
    				$data[DATA_BASE_CARDS_FAMILYNAME] = $languageConfig["FKey"].$rand;
    			}
    		}
    		else
    			$rand -= $languageConfig["GUpperLimit"];
    	}
    	if(isset($languageConfig["DKey"]))
    	{
    		if($rand <= $languageConfig["DUpperLimit"])
    		{
    			$nameConfig = XmlConfigMgr::getInstance()->getNameConfig()->findConfig($languageConfig["DKey"].$rand);
    			if($nameConfig)
    			{
    				$data[DATA_BASE_CARDS_FAMILYNAME] = $languageConfig["DKey"].$rand;
    			}
    		}
    	}
    	 
    	
    	$data[DATA_BASE_CARDS_POSITION1] = $position;
    	
    	$rand = mt_rand(1, 100);
    	if($rand <= $playerConfig["Position2Chance"])
    	{
    		$randArrPosition2 = Array();
    		if(isset($playerPositionConfig["Extend1"]))
    		{
    			$randArrPosition2[] = $playerPositionConfig["Extend1"];
    		}
    		if(isset($playerPositionConfig["Extend2"]))
    		{
    			$randArrPosition2[] = $playerPositionConfig["Extend2"];
    		}
    		if(isset($playerPositionConfig["Extend3"]))
    		{
    			$randArrPosition2[] = $playerPositionConfig["Extend3"];
    		}
    		if(isset($playerPositionConfig["Extend4"]))
    		{
    			$randArrPosition2[] = $playerPositionConfig["Extend4"];
    		}
    		
    		$randIndex = array_rand($randArrPosition2, 1);
    		$data[DATA_BASE_CARDS_POSITION2] = $randArrPosition2[$randIndex];
    	}
    	
    	$rand = mt_rand(1, 100);
    	if($rand <= $playerConfig["Position3Chance"])
    	{
    		$randArrPosition3 = Array();
    		if(isset($playerPositionConfig["Extend1"]))
    		{
    			$randArrPosition3[] = $playerPositionConfig["Extend1"];
    		}
    		if(isset($playerPositionConfig["Extend2"]))
    		{
    			$randArrPosition3[] = $playerPositionConfig["Extend2"];
    		}
    		if(isset($playerPositionConfig["Extend3"]))
    		{
    			$randArrPosition3[] = $playerPositionConfig["Extend3"];
    		}
    		if(isset($playerPositionConfig["Extend4"]))
    		{
    			$randArrPosition3[] = $playerPositionConfig["Extend4"];
    		}
    	
    		$randIndex = array_rand($randArrPosition3, 1);
    		$data[DATA_BASE_CARDS_POSITION3] = $randArrPosition3[$randIndex];
    	}
    	
    	if(isset($playerConfig["AgeMin"]) && isset($playerConfig["AgeMax"]))
    	{
    		$age = mt_rand($playerConfig["AgeMin"], $playerConfig["AgeMax"]);
    		$data[USER_DATA_CARDS_AGE] = $age;
    	}
    	else
    	{
    		$data[USER_DATA_CARDS_AGE] = 18;
    	}
    	if(isset($playerConfig["RetireMin"]) && isset($playerConfig["RetireMax"]))
    	{
    		$ageRetire = mt_rand($playerConfig["RetireMin"], $playerConfig["RetireMax"]);
    		$data[DATA_BASE_CARDS_RETIREAGE] = $ageRetire;
    	}
    	else
    	{
    		$data[USER_DATA_CARDS_AGE] = 33;
    	}
    	if(isset($playerConfig["ContratMin"]) && isset($playerConfig["ContratMax"]))
    	{
    		$contrat = mt_rand($playerConfig["ContratMin"], $playerConfig["ContratMax"]);
    		$data[DATA_BASE_CARDS_CONTRATVALIDUNTIL] = $contrat;
    	}
    	else
    	{
    		$data[DATA_BASE_CARDS_CONTRATVALIDUNTIL] = 33;
    	}
    	
    	$trueability = 0;
    	$overall = 36;
    	if(isset($playerConfig["OverallMin"]) && isset($playerConfig["OverallMax"]))
    	{
    		$overall = mt_rand($playerConfig["OverallMin"], $playerConfig["OverallMax"]);
    	}
    	
    	
    	$unit = 0;
    	$attack = self::_randPositionCreate($positionCreateConfig["Attack"]);
    	$skill = self::_randPositionCreate($positionCreateConfig["Skill"]);
    	$Physicality = self::_randPositionCreate($positionCreateConfig["Physicality"]);
    	$Mentality = self::_randPositionCreate($positionCreateConfig["Mentality"]);
    	$Defence = self::_randPositionCreate($positionCreateConfig["Defence"]);
    	$Gaolkeeping = self::_randPositionCreate($positionCreateConfig["Gaolkeeping"]);
    	
    	$denominator = $playerPositionConfig["WeightAttack"] * $attack
    	+ $playerPositionConfig["WeightSkill"] * $skill
    	+ $playerPositionConfig["WeightPhysicality"] * $Physicality
    	+ $playerPositionConfig["WeightMentality"] * $Mentality
    	+ $playerPositionConfig["WeightDefence"] * $Defence
    	+ $playerPositionConfig["WeightGaolkeeping"] * $Gaolkeeping;
    	
    	$denominator = intval($denominator);
    	if($denominator > 0)
    	{
    		$unit = $overall / $denominator;
    	}
    	
    	$attack *= $unit;
    	$skill *= $unit;
    	$Physicality *= $unit;
    	$Mentality *= $unit;
    	$Defence *= $unit;
    	$Gaolkeeping *= $unit;
    	
    	$second = self::_calculateSecondAttr($attack, $positionCreateConfig["Finishing"], $positionCreateConfig["Crossing"], $positionCreateConfig["Heading"], $positionCreateConfig["Longshots"], $positionCreateConfig["Freekick"]);
    	$data[DATA_BASE_CARDS_FINISHING] = round(($second[0] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_CROSSING] = round(($second[1] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_HEADING] = round(($second[2] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_LONGSHOTS] = round(($second[3] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_FREEKICK] = round(($second[4] * 25 + ($leagueLevel - 1) * 5), 2);
    	
    	$second = self::_calculateSecondAttr($skill, $positionCreateConfig["Dribbling"], $positionCreateConfig["Longpassing"], $positionCreateConfig["Ballcontrol"], $positionCreateConfig["Curve"], $positionCreateConfig["Shortpassig"]);
    	$data[DATA_BASE_CARDS_DRIBBLING] = round(($second[0] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_LONGPASSING] = round(($second[1] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_BALLCONTROL] = round(($second[2] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_CURVE] = round(($second[3] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_SHORTPASSIG] = round(($second[4] * 25 + ($leagueLevel - 1) * 5), 2);
    	
    	$second = self::_calculateSecondAttr($Physicality, $positionCreateConfig["Power"], $positionCreateConfig["Stamina"], $positionCreateConfig["Strength"], $positionCreateConfig["Reaction"], $positionCreateConfig["Speed"]);
    	$data[DATA_BASE_CARDS_POWER] = round(($second[0] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_STAMINA] = round(($second[1] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_STRENGTH] = round(($second[2] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_REACTION] = round(($second[3] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_SPEED] = round(($second[4] * 25 + ($leagueLevel - 1) * 5), 2);
    	
    	$second = self::_calculateSecondAttr($Mentality, $positionCreateConfig["Aggression"], $positionCreateConfig["Movement"], $positionCreateConfig["Vision"], $positionCreateConfig["Composure"], $positionCreateConfig["Penalties"]);
    	$data[DATA_BASE_CARDS_AGGRESSION] = round(($second[0] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_MOVEMENT] = round(($second[1] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_VISION] = round(($second[2] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_COMPOSURE] = round(($second[3] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_PENALTIES] = round(($second[4] * 25 + ($leagueLevel - 1) * 5), 2);
    	
    	$second = self::_calculateSecondAttr($Defence, $positionCreateConfig["Marking"], $positionCreateConfig["Standingtackle"], $positionCreateConfig["Slidingtackle"], $positionCreateConfig["Interceptions"], $positionCreateConfig["Postioning"]);
    	$data[DATA_BASE_CARDS_MARKING] = round(($second[0] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_STANDINGTACKLE] = round(($second[1] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_SLIDINGTACKLE] = round(($second[2] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_INTERCEPTIONS] = round(($second[3] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_POSTIONING] = round(($second[4] * 25 + ($leagueLevel - 1) * 5), 2);
    	
    	$second = self::_calculateSecondAttr($Gaolkeeping, $positionCreateConfig["Gkdiving"], $positionCreateConfig["Gkhanding"], $positionCreateConfig["Gkpostioning"], $positionCreateConfig["Gkreflexes"], $positionCreateConfig["Gkkicking"]);
    	$data[DATA_BASE_CARDS_GKDIVING] = round(($second[0] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_GKHANDING] = round(($second[1] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_GKPOSTIONING] = round(($second[2] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_GKREFLEXES] = round(($second[3] * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_GKKICKING] = round(($second[4] * 25 + ($leagueLevel - 1) * 5), 2);
    	
    	$data[DATA_BASE_CARDS_ATTACK] = round(($attack * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_SKILL] = round(($skill * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_PHYSICALITY] = round(($Physicality * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_MENTALITY] = round(($Mentality * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_DEFENCE] = round(($attack * 25 + ($leagueLevel - 1) * 5), 2);
    	$data[DATA_BASE_CARDS_GAOLKEEPING] = round(($Gaolkeeping * 25 + ($leagueLevel - 1) * 5), 2);
    	
    	$potentia = 10;
    	if(isset($playerConfig["PotentialMin"]) && isset($playerConfig["PotentialMax"]))
    	{
    		$potentia = mt_rand($playerConfig["PotentialMin"], $playerConfig["PotentialMax"]);
    	}
    	
    	$trueability = round(($overall * 25 / 100 + ($leagueLevel - 1) * 5), 2);
    	
    	$data[DATA_BASE_CARDS_WAGE] =  intval(0.2 * pow($trueability, 3.7));
    	$data[DATA_BASE_CARDS_VALUE] = intval(3000 * pow($trueability, 2.3) * pow(0.82, $age - 18) * $potentia / 100);
    	
    	$data[DATA_BASE_CARDS_NUMBER] = ++$this->_number;
    	
    	$rand = mt_rand(0, $positionCreateConfig["Leftfoot"] + $positionCreateConfig["Rightfoot"] + $positionCreateConfig["LeftRight"]);
    	if($rand <= $positionCreateConfig["Leftfoot"])
    		$data[DATA_BASE_CARDS_PREFERREDFOOT] = 1;
    	else 
    		$rand -= $positionCreateConfig["Leftfoot"];
    	
    	if($rand <= $positionCreateConfig["Rightfoot"])
    		$data[DATA_BASE_CARDS_PREFERREDFOOT] = 2;
    	else
    		$rand -= $positionCreateConfig["Rightfoot"];
    	if($rand <= $positionCreateConfig["LeftRight"])
    		$data[DATA_BASE_CARDS_PREFERREDFOOT] = 0;
    	
    	$data[DATA_BASE_CARDS_HEIGHT] = mt_rand($positionCreateConfig["HeightMin"], $positionCreateConfig["HeightMax"]);
    	$data[DATA_BASE_CARDS_WEIGHT] = intval(pow($data[DATA_BASE_CARDS_HEIGHT] / 100, 2) * mt_rand($positionCreateConfig["BMIMin"], $positionCreateConfig["BMIMax"]));
    	
    	if($type == CARD_CREATE_TYPE_LEAGUE)
    		return $this->_cardsModel->insertCardData($data);
    	else if($type == CARD_CREATE_TYPE_SCOUT)
    		return $data;
		else if($type == CARD_CREATE_TYPE_RECOMMEND)
			return $data;
    	else
    		return true;
    }
    
    private static function _calculateSecondAttr($attr, $attr1, $attr2, $attr3, $attr4, $attr5)
    {
    	$attr1 = self::_randPositionCreate($attr1);
    	$attr2 = self::_randPositionCreate($attr2);
    	$attr3 = self::_randPositionCreate($attr3);
    	$attr4 = self::_randPositionCreate($attr4);
    	$attr5 = self::_randPositionCreate($attr5);
    	
    	$denominator = ($attr1 + $attr2 + $attr3 + $attr4 + $attr5) / (100 * 5);
    	
    	$unit = 0;
    	if($denominator > 0)
    		$unit = $attr / $denominator;
    	
    	return array($unit * $attr1 / 100, $unit * $attr2 / 100, $unit * $attr3 / 100, $unit * $attr4 / 100, $unit * $attr5 / 100);
    }
    
    private static function _randPositionCreate($param)
    {
    	$rand = mt_rand(0, 20);
    	
    	if(mt_rand(0, 1) == 0)
    		$param = $param * (100 - $rand) / 100;
    	else
    		$param = $param * (100 + $rand) / 100;
    	
    	return $param;
    }
    
    public function createUserCard($position, $leagueLevel, $type)
    {
    	
    	$data = Array();
    	$playerConfig = XmlConfigMgr::getInstance()->getPlayerCreateConfig()->getConfig();
    	if($playerConfig)
    	{
    		foreach ($playerConfig as $v)
    		{
    			if($v["Type"] == $type)
    			{
					return $this->_createCardByLeague($position, $leagueLevel, $v, $type);				
    			}
    		}
    	}
    	
    	return false;
    }
    
    public function initUserCards($leagueLevel)
    {
   		$playerConfig = XmlConfigMgr::getInstance()->getPlayerCreateConfig();
		if($playerConfig)
		{
			foreach ($playerConfig as $v)
			{
				switch ($v["Type"])
				{
					case 5:
						{
							
						}
						break;
				}
			}
		}

        return $this->_cardsModel->insertCardData($this->data);
    }

    function deleteCardData($cardId)
    {
        if(empty($cardId))
            return 0;

        if($this->_cardsModel->deleteCardData($cardId))
        {
            return 1;
        }
        return 0;
    }

    function haveTheCard($cardId)
    {
        $_cardIndex = $this->_cardsModel->getCardIndex($cardId);
        if(isset($_cardIndex))
        {
            return true;
        }
        return false;
    }

    function setFieldByIndex($field, $value, $index)
    {
        $this->_cardsModel->setFieldByIndex($field, $value, $index);
    }

    function getFieldByIndex($field, $index)
    {
        return $this->_cardsModel->getFieldByIndex($field, $index);
    }

    function getCardIndexById($cardId)
    {
        $_cardCount = $this->_cardsModel->getDataCount();
        for($i = 0; $i < $_cardCount; $i ++)
        {
            $_value = $this->getFieldByIndex(DATA_BASE_CARDS_UID, $i);
            if($cardId == $_value)
            {
                return $i;
            }
        }
        return null;
    }

    function saveCardData($cardId, $index)
    {
        return $this->_cardsModel->saveCardData($cardId, $index);
    }

    function updateCardsData()
    {
        $_cardCount = $this->_cardsModel->getDataCount();
        for($i = 0; $i < $_cardCount; $i ++)
        {
            $_redCard = $this->getFieldByIndex(DATA_BASE_CARDS_REDCARD, $i);
            if(!empty($_redCard))
            {
                $this->setFieldByIndex(DATA_BASE_CARDS_REDCARD, $_redCard + 1, $i);
                $this->setFieldByIndex(DATA_BASE_CARDS_YELLOWCARD, 0, $i);

                $_cardId = $this->getFieldByIndex(DATA_BASE_CARDS_UID, $i);
                if(!$this->saveCardData($_cardId, $i))
                {
                    return false;
                }
            }
        }
        return true;
    }

//    function updateFieldPosition($data)
//    {
//        if(is_array($data))
//        {
//            $_data = $this->_cardsModel->getCardData();
//            foreach($data as $_index => $_position)
//            {
//                if(!empty($_data[$_index]))
//                {
//                    $this->_cardsModel->setFieldByIndex($_index, $_position);
//                    $this->_cardsModel->saveCardData($_data[$_index][USER_DATA_CARDS_UID], $_index);
//                }
//            }
//            return true;
//        }
//
//        return false;
//    }

    function getAllCards()
    {
        return $this->_cardsModel->getCardData();
    }

    /*
     * 将玩家球员数据转换成对应格式
     * 格式：
     *  数组内部[UID] = [球员数据]
     * */
    function getFormatCards()
    {
        $_cards = $this->getAllCards();

        $_newCards = array();
        foreach($_cards as $value)
        {
            $_newCards[$value[DATA_BASE_CARDS_UID]] = $value;
        }
        return $_newCards;
    }

    function countAttackAttribute($constant, $matchLevel, $card, $position)
    {
        $_attributeArr = $this->getAttackAttribute();
        $_attribute = $this->countSingleAttribute($_attributeArr, $matchLevel, $card, $constant);
        $_weight = XmlConfigMgr::getInstance()->getPlayerPositionConfig()->findPlayerPositionConfig($position)['WeightAttack'];
        return round($_attribute * $_weight / 100, 2);
    }

    function countSkillAttribute($constant, $matchLevel, $card, $position)
    {
        $_attributeArr = $this->getSkillAttribute();
        $_attribute = $this->countSingleAttribute($_attributeArr, $matchLevel, $card, $constant);
        $_weight = XmlConfigMgr::getInstance()->getPlayerPositionConfig()->findPlayerPositionConfig($position)['WeightSkill'];
        return round($_attribute * $_weight / 100, 2);
    }

    function countPhysicalityAttribute($constant, $matchLevel, $card, $position)
    {
        $_attributeArr = $this->getPhysicalityAttribute();
        $_attribute = $this->countSingleAttribute($_attributeArr, $matchLevel, $card, $constant);
        $_weight = XmlConfigMgr::getInstance()->getPlayerPositionConfig()->findPlayerPositionConfig($position)['WeightPhysicality'];
        return round($_attribute * $_weight / 100, 2);
    }

    function countMentalityAttribute($constant, $matchLevel, $card, $position)
    {
        $_attributeArr = $this->getMentalityAttribute();
        $_attribute = $this->countSingleAttribute($_attributeArr, $matchLevel, $card, $constant);
        $_weight = XmlConfigMgr::getInstance()->getPlayerPositionConfig()->findPlayerPositionConfig($position)['WeightMentality'];
        return round($_attribute * $_weight / 100, 2);
    }

    function countDefenseAttribute($constant, $matchLevel, $card, $position)
    {
        $_attributeArr = $this->getDefenseAttribute();
        $_attribute = $this->countSingleAttribute($_attributeArr, $matchLevel, $card, $constant);
        $_weight = XmlConfigMgr::getInstance()->getPlayerPositionConfig()->findPlayerPositionConfig($position)['WeightDefence'];
        return round($_attribute * $_weight / 100, 2);
    }

    function countGoalKeepAttribute($constant, $matchLevel, $card, $position)
    {
        $_attributeArr = $this->getGoalKeepAttribute();
        $_attribute = $this->countSingleAttribute($_attributeArr, $matchLevel, $card, $constant);
        $_weight = XmlConfigMgr::getInstance()->getPlayerPositionConfig()->findPlayerPositionConfig($position)['WeightGaolkeeping'];
        return round($_attribute * $_weight / 100, 2);
    }

    /*
     * 计算大项属性平均值
     * 参数：
     *  $attributeArr：大项对象的属性集合
     *  $matchLevel：联赛等级
     *  $card：要计算的球员属性集合
     *  $constant：计算公式常量
     * */
    function countSingleAttribute($attributeArr, $matchLevel, $card, $constant)
    {
        if(!is_array($attributeArr))
        {
            return 0;
        }

        $_count = count($attributeArr);
        $_attack = 0;
        foreach($attributeArr as $value)
        {
            $_attack += getSingleAttributeFormula($constant, $card[$value], $matchLevel);
        }
        return $_attack / $_count;
    }

    /*
     * 取得大项属性
     * */
    function getLargeAttribute()
    {
        $_attackAttributeArr = [
            DATA_BASE_CARDS_ATTACK,
            DATA_BASE_CARDS_SKILL,
            DATA_BASE_CARDS_PHYSICALITY,
            DATA_BASE_CARDS_MENTALITY,
            DATA_BASE_CARDS_DEFENCE,
            DATA_BASE_CARDS_GAOLKEEPING
        ];

        return $_attackAttributeArr;
    }

    private function getAttackAttribute()
    {
        $_attackAttributeArr = [
            DATA_BASE_CARDS_FINISHING,
            DATA_BASE_CARDS_CROSSING,
            DATA_BASE_CARDS_HEADING,
            DATA_BASE_CARDS_LONGSHOTS,
            DATA_BASE_CARDS_FREEKICK,
        ];

        return $_attackAttributeArr;
    }

    private function getSkillAttribute()
    {
        $_skillAttributeArr = [
            DATA_BASE_CARDS_DRIBBLING,
            DATA_BASE_CARDS_LONGPASSING,
            DATA_BASE_CARDS_BALLCONTROL,
            DATA_BASE_CARDS_CURVE,
            DATA_BASE_CARDS_SHORTPASSIG,
        ];

        return $_skillAttributeArr;
    }

    private function getPhysicalityAttribute()
    {
        $_physicalityAttributeArr = [
            DATA_BASE_CARDS_POWER,
            DATA_BASE_CARDS_STAMINA,
            DATA_BASE_CARDS_STRENGTH,
            DATA_BASE_CARDS_REACTION,
            DATA_BASE_CARDS_SPEED,
        ];

        return $_physicalityAttributeArr;
    }

    private function getMentalityAttribute()
    {
        $_mentalityAttributeArr = [
            DATA_BASE_CARDS_AGGRESSION,
            DATA_BASE_CARDS_MOVEMENT,
            DATA_BASE_CARDS_VISION,
            DATA_BASE_CARDS_COMPOSURE,
            DATA_BASE_CARDS_PENALTIES,
        ];

        return $_mentalityAttributeArr;
    }

    private function getDefenseAttribute()
    {
        $_defenseAttributeArr = [
            DATA_BASE_CARDS_MARKING,
            DATA_BASE_CARDS_STANDINGTACKLE,
            DATA_BASE_CARDS_SLIDINGTACKLE,
            DATA_BASE_CARDS_INTERCEPTIONS,
            DATA_BASE_CARDS_POSTIONING,
        ];

        return $_defenseAttributeArr;
    }

    private function getGoalKeepAttribute()
    {
        $_goalKeepAttributeArr = [
            DATA_BASE_CARDS_GKDIVING,
            DATA_BASE_CARDS_GKHANDING,
            DATA_BASE_CARDS_GKPOSTIONING,
            DATA_BASE_CARDS_GKREFLEXES,
            DATA_BASE_CARDS_GKKICKING,
        ];

        return $_goalKeepAttributeArr;
    }
    
    //////////////////////////////////////////////////
    //球员
    //////////////////////////////////////////////////
}
