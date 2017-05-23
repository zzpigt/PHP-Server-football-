<?php

include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/1/17
 * Time: 11:02
 */
define("CARDS_MODEL_DEFAULT", 1);

class CardsModel extends MysqlDB
{
    const CARD_OBSERVER = 'card_observer';

    private $_userId;
    private $_observer = Array(1=>14415151);

    public function init($userId)
    {
        if(empty($userId))
        {
            printError("CardsModel userId is " . $userId);
            return false;
        }

        if(!parent::initDB($userId))
        	return false;

        $this->_userId = $userId;
        $this->TableName(DATA_BASE_CARDS);
        $this->PK(DATA_BASE_CARDS_PRI);
        $this->FieldList(eval(DATA_BASE_CARDS_FIELD));//设置字段列表
        $this->TableEnum(TABLE_CARDS);//设置表枚举


        $_data = $this->getModelData(DATA_BASE_CARDS, DATA_BASE_CARDS_PRI, $userId);
        $_data = $this->_perfectData($_data);
        $this->data($_data);
//        $this->_observer = MemInfoLogic::Instance()->getMemData(DATA_BASE_CARDS, $this->_userId."_observer");
//        $this->data = $this->getModelData(DATA_BASE_CARDS, "userid", $userId);
		return true;
    }

    private function _initCardStatistics()
    {
        $_statisticsArr = array();
        $_statisticsArr[CARD_STATISTICS_MATCH_NUM] = 0;
        $_statisticsArr[CARD_STATISTICS_MVP] = 0;
        $_statisticsArr[CARD_STATISTICS_GOAL] = 0;
        $_statisticsArr[CARD_STATISTICS_ASSISTS] = 0;
        $_statisticsArr[CARD_STATISTICS_YELLOW_CARD] = 0;
        $_statisticsArr[CARD_STATISTICS_RED_CARD] = 0;
        $_statisticsArr[CARD_STATISTICS_SCORE] = array();
        return $_statisticsArr;
	}

    private function _perfectData($data)
    {
        if(is_array($data))
        {
            foreach($data as $index => $cardData)
            {
                if(empty($value[DATA_BASE_CARDS_LEAGUEDATA]))
                {
                    $data[$index][DATA_BASE_CARDS_LEAGUEDATA] = $this->_initCardStatistics();
                }
                else
                {
                    $data[$index][DATA_BASE_CARDS_LEAGUEDATA] = json_decode($data[$index][DATA_BASE_CARDS_LEAGUEDATA], true);
                }
                if(empty($value[DATA_BASE_CARDS_CUPDATA]))
                {
                    $data[$index][DATA_BASE_CARDS_CUPDATA] = $this->_initCardStatistics();
                }
                else
                {
                    $data[$index][DATA_BASE_CARDS_CUPDATA] = json_decode($data[$index][DATA_BASE_CARDS_CUPDATA], true);
                }
                if(empty($value[DATA_BASE_CARDS_CHAMPIONSLEAGEUEDATA]))
                {
                    $data[$index][DATA_BASE_CARDS_CHAMPIONSLEAGEUEDATA] = $this->_initCardStatistics();
                }
                else
                {
                    $data[$index][DATA_BASE_CARDS_CHAMPIONSLEAGEUEDATA] = json_decode($data[$index][DATA_BASE_CARDS_CHAMPIONSLEAGEUEDATA], true);
                }
            }
        }
        return $data;
    }

    public function saveCardData($value, $index)
    {
        $_data = $this->data();
        if(empty($value) || empty($_data[$index]))
            return false;

        $_fieldList=eval(DATA_BASE_CARDS_FIELD);
        if($this->DB_update(DATA_BASE_CARDS, $_fieldList, $_data[$index], $value))
        {
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_CARDS, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_CARDS, null, $this->_userId);
            }
            return true;
        }
        return false;
    }

    function insertCardData($data)
    {
        if(empty($data))
            return false;

        $_fieldList=eval(DATA_BASE_CARDS_FIELD);
        if($this->DB_single_insert(DATA_BASE_CARDS, $_fieldList, $data))
        {
        	$uid = $this->getInsertId();
        	$data[DATA_BASE_CARDS_UID] = $uid;
            $_data = $this->data();
            $_data = $this->addModelData($_data, $data);
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_CARDS, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_CARDS, null, $this->_userId);
            }
            $this->data($_data);
            return true;
        }
        return false;
    }

    function insertCardDatas($data)
    {
        if(!is_array($data))
            return false;

        $_fieldList=eval(DATA_BASE_CARDS_FIELD);
        if($this->DB_multi_insert(DATA_BASE_CARDS, $_fieldList, $data))
        {
            $_data = $this->data();
            foreach($data as $value)
            {
                $_data = $this->addModelData($_data, $value);
            }
            $this->data($_data);
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_CARDS, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_CARDS, null, $this->_userId);
            }
            return true;
        }
        return false;
    }

    function deleteCardData($cardId)
    {
        if(empty($cardId))
            return false;

        $_sqlValue = $cardId . "' and userid ='" .$this->_userId;
        if($this->DB_delete(DATA_BASE_CARDS, 'cid', $_sqlValue))
        {
            $_data = $this->data();
            $_cardIndex = $this->getCardIndex($cardId);
            unset($_data[$_cardIndex]);
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_CARDS, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_CARDS, null, $this->_userId);
            }
            return true;
        }
        return false;
    }

    function getCardIndex($cardId)
    {
        $_data = $this->data();
        foreach ($_data as $key => $value)
        {
            if($cardId == $value[DATA_BASE_CARDS_CID])
            {
                return $key;
            }
        }

        return null;
    }

    function getMaxIndex()
    {
        $_data = $this->data();
        $_dataNum = 0;
        foreach($_data as $key => $value)
        {
            if(is_numeric($key))
            {
                $_dataNum += 1;
            }
        }
        return $_dataNum - 1;
    }

    function getCardData()
    {
        return $this->data();
    }

    function UserId()
    {
        return $this->_userId;
    }
    
    function addObserver($userId)
    {
    	array_push($this->_observer, $userId);
        $this->setExtraCacheField(self::CARD_OBSERVER, $this->_observer);
    }
    
    function notifyObserver()
    {
    	
    }

    function _getCardsStrut($cardId,/* $matchLevel, $constant,*/ $primaryKey, $arrayCount)
    {
        $cardList = array();
        $cardConfig = XmlConfigMgr::getInstance()->getPlayerDataConfig()->findPlayerDataConfig($cardId);
        $cardList[USER_DATA_CARDS_CID] = $cardId;
        //此处需要读表
        $cardList[USER_DATA_CARDS_USERID] = $primaryKey;
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

//        $cardList[USER_DATA_CARDS_ATTACK] = $this->countAttackAttribute($constant, $matchLevel, $cardList, $cardList[USER_DATA_CARDS_POSITION1]);
        $cardList[USER_DATA_CARDS_ATTACK] = $arrayCount['countAttackAttribute'];
//        $cardList[USER_DATA_CARDS_SKILL] = $this->countSkillAttribute($constant, $matchLevel, $cardList, $cardList[USER_DATA_CARDS_POSITION1]);
        $cardList[USER_DATA_CARDS_SKILL] = $arrayCount['countSkillAttribute'];
//        $cardList[USER_DATA_CARDS_PHYSICALITY] = $this->countPhysicalityAttribute($constant, $matchLevel, $cardList, $cardList[USER_DATA_CARDS_POSITION1]);
        $cardList[USER_DATA_CARDS_PHYSICALITY] = $arrayCount['countPhysicalityAttribute'];
//        $cardList[USER_DATA_CARDS_MENTALITY] = $this->countMentalityAttribute($constant, $matchLevel, $cardList, $cardList[USER_DATA_CARDS_POSITION1]);
        $cardList[USER_DATA_CARDS_MENTALITY] = $arrayCount['countMentalityAttribute'];
//        $cardList[USER_DATA_CARDS_DEFENCE] = $this->countDefenseAttribute($constant, $matchLevel, $cardList, $cardList[USER_DATA_CARDS_POSITION1]);
        $cardList[USER_DATA_CARDS_DEFENCE] = $arrayCount['countDefenseAttribute'];
//        $cardList[USER_DATA_CARDS_GAOLKEEPING] = $this->countGoalKeepAttribute($constant, $matchLevel, $cardList, $cardList[USER_DATA_CARDS_POSITION1]);
        $cardList[USER_DATA_CARDS_GAOLKEEPING] = $arrayCount['countGoalKeepAttribute'];
        return $cardList;
    }

}
//    2017/5/16  新添加
class CardsModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        CARDS_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new CardsModelMgr();
            if(!self::$_instance || !self::$_instance->init())
            {
                return null;
            }
        }
        return self::$_instance;
    }

    private function init()
    {
        $_db = new MysqlDB();
        if($_db)
        {
            $_db->TableName(DATA_BASE_CARDS);
            $_db->PK(DATA_BASE_CARDS);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_CARDS_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_CARDS);

            $this->_db = $_db;
            return true;
        }
        return false;
    }

    function getModelByPrimary($primaryValue)
    {
        if(!empty(self::$_modelArr[$primaryValue]))
        {
            return self::$_modelArr[$primaryValue];
        }

        $_model = new CardsModel();
        if(!$_model || !$_model->init($primaryValue))
        {
            self::$_modelArr[$primaryValue] = $_model;
            return $_model;
        }
        return null;
    }



    function getModelList($queryType, $fieldValueList)
    {
        /*$_db = new MysqlDB();
        $_db->TableName(DATA_BASE_CARDS);
        $_db->registerQueryField($this->_fieldList);
        $_db->PK(DATA_BASE_CARDS);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI*/

        $_db = $this->_db;
        if(!$_db instanceof MysqlDB)
        {
            return null;
        }

        $_primaryList = $_db->startQuery($queryType, $fieldValueList);
        if(empty($_primaryList))
        {
            return null;
        }

        $_backModelList = array();
        foreach($_primaryList as $value)
        {
            if(empty(self::$_modelArr[$value]))
            {
                $_model = new CardsModel();
                if($_model && $_model->init($value))
                {
                    self::$_modelArr[$value] = $_model;
                    $_backModelList[$value] = $_model;
                }
            }
            else
            {
                $_backModelList[$value] = self::$_modelArr[$value];
            }
        }
        return $_backModelList;
    }


}