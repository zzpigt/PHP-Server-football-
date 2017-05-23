<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/3/18
 * Time: 13:34
 */
define("FIGHT_ROOMS_MODEL_DEFAULT", 1);


class FightRoomsModel extends MysqlDB
{
    private $_userId;
    function init($userId)
    {
        if(empty($userId))
        {
            printError("FightRoomsModel userId is " . $userId);
            return false;
        }

        if(!parent::initDB($userId))
			return false;
        	
        $this->_userId = $userId;
        $this->TableName(DATA_BASE_FIGHTROOMS);
        $this->PK(DATA_BASE_FIGHTROOMS_PRI);
        $this->FieldList(eval(DATA_BASE_FIGHTROOMS_FIELD));//设置字段列表
        $this->TableEnum(TABLE_FIGHT_ROOMS);//设置表枚举


        $_extra_sql = " or awayuserid = " . $userId;
//        $this->data = $this->getModelData(DATA_BASE_FIGHTROOMS, "homeuserid", $userId, $_extra_sql);
        $this->data($this->getModelData(DATA_BASE_FIGHTROOMS, DATA_BASE_FIGHTROOMS_PRI, $userId, $_extra_sql));
        return true;
    }

    private function gzCompress($data)
    {
        if(is_array($data) && !empty($data))
        {
            foreach($data as $key => $value)
            {
                if(!is_numeric($key))
                {
                    continue;
                }

                if(!empty($data[$key][DATA_BASE_FIGHTROOMS_EVENTTIMEARR]))
                {
                    $data[$key][DATA_BASE_FIGHTROOMS_EVENTTIMEARR] = base64_encode(gzcompress(json_encode($data[$key][DATA_BASE_FIGHTROOMS_EVENTTIMEARR])));
                }
            }
        }

        return $data;
    }

    private function gzUnCompress($data)
    {
        if(is_array($data)  && !empty($data))
        {
            foreach($data as $key => $value)
            {
                if(!is_numeric($key))
                {
                    continue;
                }
                if(!empty($data[$key][DATA_BASE_FIGHTROOMS_EVENTTIMEARR]))
                {
                    $data[$key][DATA_BASE_FIGHTROOMS_EVENTTIMEARR] = json_decode(gzuncompress(base64_decode($data[$key][DATA_BASE_FIGHTROOMS_EVENTTIMEARR])), true);
                }
            }
        }

        return $data;
    }

//    function getTheUserNick($userId)
//    {
//        if(empty($userId))
//        {
//            return false;
//        }
//
//        global $DBConfig;
//        parent::__construct($DBConfig[intval(getDataBaseIndex($userId))]);
//        return $this->DB_select(DATA_BASE_PROPERTIES, 'uid', $userId, 'nick');
//    }

    function insertRoomData($data)
    {
        if(empty($data))
        {
            return false;
        }
        $_packData[0] = $data;
        $_packData = $this->gzCompress($_packData);

        $_fieldList = eval(DATA_BASE_FIGHTROOMS_FIELD);
        if($this->DB_single_insert(DATA_BASE_FIGHTROOMS, $_fieldList, $_packData[0]))
        {
            $uId = $this->getInsertId();
            $data[DATA_BASE_FIGHTROOMS_UID] = $uId;

            $_data = $this->data();
            $_data = $this->addModelData($_data, $data);
            $this->data($_data);

            $_data = $this->gzCompress($_data);
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_FIGHTROOMS, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_FIGHTROOMS, null, $this->_userId);
            }
            return true;
        }
        return false;
    }

//    function cleanRoomMem()
//    {
//        MemInfoLogic::Instance()->setMemData(DATA_BASE_FIGHTROOMS, null, $this->_userId);
//    }

    function updateRoomData($roomId, $index)
    {
        $_data = $this->data();
        if(empty($roomId) || empty($_data[$index]))
        {
            return false;
        }
        $_data = $this->gzCompress($_data);
        $_fieldList = eval(DATA_BASE_FIGHTROOMS_FIELD);
        if($this->DB_update(DATA_BASE_FIGHTROOMS, $_fieldList, $_data[$index], $roomId))
        {
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_FIGHTROOMS, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_FIGHTROOMS, null, $this->_userId);
            }
            return true;
        }
        return false;
    }

    function updateRoomIsOperation($roomId, $index, $state)
    {
        if(empty($roomId) || empty($_data[$index]))
        {
            return false;
        }
        $this->setFieldByIndex(DATA_BASE_FIGHTROOMS_ISOPERATION, $state,$index);
        return $this->updateRoomData($roomId, $index);
    }

//    function deleteRoomData()
//    {
//        $this->DB_delete(DATA_BASE_FIGHTROOMS, 'roomid', $this->data[0][DATA_BASE_ROOMS_ROOMID]);
//        $this->cleanRoomMem();
//    }
//
    function getRoomIndex($roomId)
    {
        $_data = $this->data();
        foreach ($_data as $_key => $_value)
        {
            if($_value[DATA_BASE_FIGHTROOMS_UID] == $roomId)
            {
                return $_key;
            }
        }
        return null;
    }

    function getRoomIdByIndex($index)
    {
        $_data = $this->data();
        foreach ($_data as $_key => $_value)
        {
            if($_key == $index)
            {
                return $_value[DATA_BASE_FIGHTROOMS_UID];
            }
        }
        return null;
    }

    function getRoomData()
    {
        return $this->data();
    }

    static function updateScore($userId, $roomId, $score1, $score2)
    {
        $mysql = new MysqlDB();
        if(!$mysql)
            return false;

        if(!$mysql->initDB($userId))
            return false;

        $_sql = "update fightrooms set totalhomescore = totalhomescore + $score1, totalawayscore = totalawayscore + $score2 where uid = $roomId";
        $mysql->insert($_sql);
        return true;
    }

    static function getScore($userId, $roomId)
    {
        $mysql = new MysqlDB();
        if(!$mysql)
            return false;

        if(!$mysql->initDB($userId))
            return false;

        $_sql = "select `totalHomeScore`, `totalAwayScore` from fightrooms  where uId = $roomId limit 1";
        return $mysql->query($_sql);
    }
    
    static function getRoomStartTime($userId, $roomId)
    {
    	$mysql = new MysqlDB();
    	if(!$mysql)
    		return false;
    
    	if(!$mysql->initDB($userId))
    		return false;
    
    	$_sql = "select `startTime`, `homeUserId`, `awayUserId` from fightrooms  where uId = $roomId and (`homeUserId` = $userId or `awayUserId` = $userId) limit 1";
    	return $mysql->query($_sql);
    }
    
    static function getInvalidTimeList($userId, $startRang, $endRang, $homeUserId, $awayUserId)
    {
    	$mysql = new MysqlDB();
    	if(!$mysql)
    		return false;
    
    	if(!$mysql->initDB($userId))
    		return false;
    
    	$_sql = "select `startTime` from fightrooms  where (`homeUserId` = $homeUserId or `awayUserId` = $homeUserId or `homeUserId` = $awayUserId or `awayUserId` = $awayUserId) and `starttime` >= $startRang and `starttime` <= $endRang limit 1";
    	return $mysql->query($_sql);
    }

    function _getFightRoomStrut($startTime,$homeUserId,$awayUserId,$type = null, $param = null)
    {
        $_roomList = array();

        $_roomList[DATA_BASE_FIGHTROOMS_HOMEUSERID] = $homeUserId;
        $_roomList[DATA_BASE_FIGHTROOMS_AWAYUSERID] = $awayUserId;
        if($startTime)
            $_roomList[DATA_BASE_FIGHTROOMS_STARTTIME] = $startTime;
        else
            $_roomList[DATA_BASE_FIGHTROOMS_STARTTIME] = time();

        $_roomList[DATA_BASE_FIGHTROOMS_STATUE] = GAME_STATUS_TYPE_WAITING;
        $_roomList[DATA_BASE_FIGHTROOMS_TYPE] = $type;
        $_roomList[DATA_BASE_FIGHTROOMS_PARAM] = $param;

        return $_roomList;
    }

}

//    2017/5/16  新添加
class FightRoomsModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        FIGHT_ROOMS_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new FightRoomsModelMgr();
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
            $_db->TableName(DATA_BASE_FIGHTROOMS);
            $_db->PK(DATA_BASE_FIGHTROOMS);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_FIGHTROOMS_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_FIGHT_ROOMS);

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

        $_model = new FightRoomsModel();
        if(!$_model || !$_model->init($primaryValue))
        {
            self::$_modelArr[$primaryValue] = $_model;
            return $_model;
        }
        return null;
    }

    function getModelList($queryType, $fieldValueList)
    {
//        $_db = new MysqlDB();
//        $_db->TableName(DATA_BASE_FIGHTROOMS);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_FIGHTROOMS);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI

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
                $_model = new FightRoomsModel();
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