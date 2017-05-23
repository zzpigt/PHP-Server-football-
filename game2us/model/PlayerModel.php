<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
include_once(APP_LOGIC_PATH."ConfigLogic.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/5
 * Time: 16:43
 */
define("PLAYER_MODEL_DEFAULT", 1);


class PlayerModel extends MysqlDB
{
    private $_userId;
    
    private $_heartBeatCache = Array();

    function init($userId)//$userId 连接数据库
    {
        if (empty($userId)) {
            return false;
        }
//        $dbKey = "dbKey1|".$userId;//暂时加上去，方便调试
        if(!parent::initDB($userId))
            return false;

        $this->_userId = $userId;

        $this->getModelData(DATA_BASE_PLAYER, "userid", $userId);
        return true;
//        $this->data = $this->getModelData(DATA_BASE_PLAYER, "userid", $userId);
    }

    public function savePlayerData($index = 0)
    {
        $_data = $this->data();
        if(empty($_data[$index]))
            return false;

        $_fieldList=eval(DATA_BASE_PLAYER_FIELD);
        if($this->DB_update(DATA_BASE_PLAYER, $_fieldList, $_data[$index], $this->_userId))
        {
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_PLAYER, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_PLAYER, null, $this->_userId);
            }
            return true;
        }
        return false;
    }

    function insertPlayerData($data)
    {
        if(empty($data))
            return false;

        $_fieldList=eval(DATA_BASE_PLAYER_FIELD);
        if($this->DB_single_insert(DATA_BASE_PLAYER, $_fieldList, $data))
        {
            $_data = $this->data();
            $_data = $this->addModelData($_data, $data);
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_PLAYER, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_PLAYER, null, $this->_userId);
            }
            $this->data($_data);
            return true;
        }
        return false;
    }
    
    function addHeartBeatSync($proto = Array())
    {
    	array_push($this->_heartBeatCache, $proto);
    }
    
    function heartBeatCache()
    {
    	return $this->_heartBeatCache;
    }

    function userId()
    {
        return $this->_userId;
    }

    function _getPlayerStrut($userName, $userPwd, $mac, $leagueId, $isRobot = false, $primaryKey)
    {
        $_data = array();

        $_data[DATA_BASE_PLAYER_USERID] = $primaryKey;
        $_data[DATA_BASE_PLAYER_USERNAME] = $userName;
        $_data[DATA_BASE_PLAYER_USERPWD] = $userPwd;
        $_data[DATA_BASE_PLAYER_REGDATE] = time();
        $_data[DATA_BASE_PLAYER_MACADDRESS] = $mac;
        $_data[DATA_BASE_PLAYER_LEAGUERID] = $leagueId;
        $_data[DATA_BASE_PLAYER_ISROBOT] = ($isRobot ? 1 : 2);
        return $_data;
    }

}

//    2017/5/16  新添加
class PlayerModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        PLAYER_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new PlayerModelMgr();
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
            $_db->TableName(DATA_BASE_PLAYER);
            $_db->PK(DATA_BASE_PLAYER);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_PLAYER_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_PLAYER);

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

        $_model = new PlayerModel();
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
//        $_db->TableName(DATA_BASE_PLAYER);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_PLAYER);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI

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
                $_model = new PlayerModel();
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