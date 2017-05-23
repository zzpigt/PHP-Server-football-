<?php
include_once(APP_MODEL_PATH."MemInfoModel.php");
include_once(APP_PROTO_PATH."proto.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/10
 * Time: 20:20
 */
//football数据库表
define("TABLE_CARD_RECOMMEND",1);
define("TABLE_CARD_STATISTICS",2);
define("TABLE_CARDS",3);
define("TABLE_CHAT",4);
define("TABLE_CLUB",5);
define("TABLE_CONFIG",6);
define("TABLE_FIGHT_DATA",7);
define("TABLE_FIGHT_ROOMS",8);
define("TABLE_FORMATION",9);
define("TABLE_FRIEND_LIST",10);
define("TABLE_GAME_STATISTICS",11);
define("TABLE_JERSEY",12);
define("TABLE_LEAGUE",13);
define("TABLE_LEAGUE_FB_RANK",14);
define("TABLE_LEAGUE_RANK",15);
define("TABLE_LEAGUE_SCHEDULE",16);
define("TABLE_MEMINFO",17);
define("TABLE_PLAYER",18);
define("TABLE_PROPERTIES",19);
define("TABLE_SCOUT",20);
define("TABLE_TACTICS",21);
define("TABLE_TEAM_SIGN",22);
define("TABLE_TROPHY",23);
define("TABLE_USER_PROFILE",24);
//config
define("CONFIG_COLOR_DATA",25);
define("CONFIG_CONST_DATA",26);
define("CONFIG_COUNTRY_DATA",27);
define("CONFIG_EVENT_DATA",28);
define("CONFIG_FIELDDISTANCE_DATA",29);
define("CONFIG_FIELDPOSITION_DATA",30);
define("CONFIG_FORMATIONCREATE_DATA",31);
define("CONFIG_LANGUAGE_DATA",32);
define("CONFIG_LEAGUECREATE_DATA",33);
define("CONFIG_LEAGUETIME_DATA",34);
define("CONFIG_NAME_DATA",35);
define("CONFIG_PLAYERCREATE_DATA",36);
define("CONFIG_PLAYER_DATA",37);
define("CONFIG_PLAYERPOSITION_DATA",38);
define("CONFIG_POSITIONCREATE_DATA",39);
define("CONFIG_SHIRTSET_DATA",40);
define("CONFIG_STATIC_DATA",41);
define("CONFIG_STRINGNAME_DATA",42);


class MemInfoLogic
{
    private static $_tableList;
    private static $_instance;
    private static $_memInfoList = array();
    private $_memInfoModel;

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new MemInfoLogic();
        }
        return self::$_instance;
    }

    function init($userId, $memKeyPrefix)
    {
        if(is_array($userId))
        {
            return false;
        }

        if(!empty(self::$_memInfoList[$userId]))
        {
            $this->_memInfoModel = self::$_memInfoList[$userId];
        }
        else
        {
            $this->_memInfoModel = new MemInfoModel();
            if(empty($this->_memInfoModel) || !$this->_memInfoModel->init($userId))
            {
                return false;
            }
            if(!$this->checkMemInfo())
            {
                if(!$this->addMemInfo($memKeyPrefix))
                {
                    return false;
                }
            }
            self::$_memInfoList[$userId] = $this->_memInfoModel;
        }

        return true;
    }

    private function _getMemInfoStrut($memKeyPrefix)
    {
        $_data = array();

        $_data[DATA_BASE_MEMINFO_MEMKEY] = $memKeyPrefix ."_".$this->_memInfoModel->userId();
        return $_data;
    }

    function addMemInfo($memKeyPrefix)
    {
        if(!isset($memKeyPrefix))
        {
            $memKeyPrefix = 'userId';
        }

        $_data = $this->_getMemInfoStrut($memKeyPrefix);
        return $this->_memInfoModel->insertMemInfoData($_data);
    }

    function updateMemInfo()
    {
        return $this->_memInfoModel->saveMemInfoData($this->_memInfoModel->userId());
    }

    function getMemInfoByField($field)
    {
        $_data = $this->_memInfoModel->data();
        if(isset($_data[0][$field]))
        {
            return $_data[0][$field];
        }
        return null;
    }

    function setMemInfoByField($field, $value)
    {
        return $this->_memInfoModel->setFieldByIndex($field, $value);
    }

    function getTableIndex()
    {
        if(empty(self::$_tableList))
        {
            $_fieldList=eval(DATA_BASE_MEMINFO_FIELD);
            if(is_array($_fieldList))
            {
                foreach($_fieldList as $key => $_tableName)
                {
                    self::$_tableList[$_tableName] = $key;
                }
            }
        }

        return self::$_tableList;
    }

    function checkMemInfo()
    {
        $_data = $this->_memInfoModel->data();
        if(!isset($_data))
        {
            return false;
        }
        return true;
    }

    function getMemData($tableName, $uid = null, $memKeyPrefix = 'userId')
    {
        if($this->isArrayTable($tableName))
        {
            $_maxMemCount = MemDB::getMemcacheCount();//get memcached host and port
            for($i = 0; $i< $_maxMemCount; $i++)
            {
                $_data = ST($i, $tableName.SEPARATOR.$uid);//get data
                if(isset($_data))
                {
                    if(true === $memKeyPrefix || !isset($_data[0]))
                    {
                        return $_data;
                    }
                    else
                    {
                        return $_data[0];
                    }

                }
            }
            return null;
        }else
            return null;
    }

    function setMemData($tableName, $data, $uid = null, $timeOut = 3600, $memKeyPrefix = 'userId')
    {
        $_maxMemCount = MemDB::getMemcacheCount();
        if($this->isArrayTable($tableName))
        {
            $_memKey = $tableName .SEPARATOR. $uid;

            $_saveData = $data;
//            if(true === $memKeyPrefix)//之后替换为数组
//            {
//                $_node = new Node();
//                $_node->setStartTime(time());
//                $_saveData = array($data, $_node);
//            }

            for($i = 0; $i< $_maxMemCount; $i++)
            {
                if(!ST($i, $_memKey, null))
                {
                    return false;
                }
                if(ST($i, $_memKey, $_saveData, $timeOut))
                {
                    return true;
                }
            }
            return false;
        }else
        {
            return false;
        }
    }

    function increment($tableName)
    {
        $_maxMemCount = MemDB::getMemcacheCount();

        for($i = 0; $i< $_maxMemCount; $i++)
        {
            $_data = increment($i, $tableName);
            if($_data)
            {
                return $_data;
            }
        }
        return false;
    }

    // 2017/5/16  判断表是否存在数组中
    private function isArrayTable($tableName){
        $_tables = array(
             TABLE_CARD_RECOMMEND => 1,
             TABLE_CARD_STATISTICS => 2,
             TABLE_CARDS => 3,
             TABLE_CHAT => 4,
             TABLE_CLUB => 5,
             TABLE_CONFIG => 6,
             TABLE_FIGHT_DATA => 7,
             TABLE_FIGHT_ROOMS => 8,
             TABLE_FORMATION => 9,
             TABLE_FRIEND_LIST => 10,
             TABLE_GAME_STATISTICS => 11,
             TABLE_JERSEY => 12,
             TABLE_LEAGUE => 13,
             TABLE_LEAGUE_FB_RANK => 14,
             TABLE_LEAGUE_RANK => 15,
             TABLE_LEAGUE_SCHEDULE => 16,
             TABLE_MEMINFO => 17,
             TABLE_PLAYER => 18,
             TABLE_PROPERTIES => 19,
             TABLE_SCOUT => 20,
             TABLE_TACTICS => 21,
             TABLE_TEAM_SIGN => 22,
             TABLE_TROPHY => 23,
             TABLE_USER_PROFILE => 24,
             CONFIG_COLOR_DATA => 25,
             CONFIG_CONST_DATA => 26,
             CONFIG_COUNTRY_DATA => 27,
             CONFIG_EVENT_DATA => 28,
             CONFIG_FIELDDISTANCE_DATA => 29,
             CONFIG_FIELDPOSITION_DATA => 30,
             CONFIG_FORMATIONCREATE_DATA => 31,
             CONFIG_LANGUAGE_DATA => 32,
             CONFIG_LEAGUECREATE_DATA => 33,
             CONFIG_LEAGUETIME_DATA => 34,
             CONFIG_NAME_DATA => 35,
             CONFIG_PLAYERCREATE_DATA => 36,
             CONFIG_PLAYER_DATA => 37,
             CONFIG_PLAYERPOSITION_DATA => 38,
             CONFIG_POSITIONCREATE_DATA => 39,
             CONFIG_SHIRTSET_DATA => 40,
             CONFIG_STATIC_DATA => 41,
             CONFIG_STRINGNAME_DATA => 42,
        );
        if (array_key_exists($tableName, $_tables))
        {
            return true;
        }
        else
            return false;
    }
}