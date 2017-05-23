<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/17
 * Time: 19:36
 */
define("GAME_STATISTICS_MODEL_DEFAULT", 1);


class GameStatisticsModel extends MysqlDB
{
    private $_tableName = null;
    private $_config = null;
    private $_addNum = 0;
    private $_dataNum = 0;
    public function init()
    {
        $_config = ConfigLogic::Instance();
        if(empty($_config))
        {
            return false;
        }
        $this->_config = $_config;
        //获取表的索引
        $_dataNum = $_config->getConfigByField(DATA_BASE_CONFIG_GAMESTATISTICSNUM);
        $this->_dataNum = $_dataNum;

        $_tableIndex = intval($_dataNum / STATISTICS_TABLE_DATA_COUNT) + 1;
        $this->_tableName = DATA_BASE_GAME_STATISTICS . "_" . $_tableIndex;
        //连接对应数据库
        global $StatisticsDB;
        if(!parent::initDB($StatisticsDB, false))
            return false;

        $_count = $this->DB_table_data_count($this->_tableName);
        if(!isset($_count))
        {
            $_count = 0;
        }
        //如果$_count达到阈值创建表

        return true;
    }

    private function _getStatisticsStrut($gameStrut)
    {
        if (!$gameStrut instanceof SGameStatisticsInfo)
        {
            return null ;
        }

        $_data = array();
        $_data[DATA_BASE_GAME_STATISTICS_ROOMID] = $gameStrut->__RoomId;
        $_data[DATA_BASE_GAME_STATISTICS_GAMETYPE] = $gameStrut->__GameType;
        $_data[DATA_BASE_GAME_STATISTICS_ISHOME] = $gameStrut->__IsHome;
        $_data[DATA_BASE_GAME_STATISTICS_BALLCONTROL] = $gameStrut->__BallControl;
        $_data[DATA_BASE_GAME_STATISTICS_SHOTNUM] = $gameStrut->__ShotNum;
        $_data[DATA_BASE_GAME_STATISTICS_PENALTYSHOT] = $gameStrut->__PenaltyShot;
        $_data[DATA_BASE_GAME_STATISTICS_SHOTSUCCESSRATE] = $gameStrut->__ShotSuccessRate;
        $_data[DATA_BASE_GAME_STATISTICS_PASSSUCCESSRATE] = $gameStrut->__PassSuccessRate;
        $_data[DATA_BASE_GAME_STATISTICS_FREEKICK] = $gameStrut->__FreeKick;
        $_data[DATA_BASE_GAME_STATISTICS_CORNER] = $gameStrut->__Corner;
        $_data[DATA_BASE_GAME_STATISTICS_SAVES] = $gameStrut->__Saves;
        $_data[DATA_BASE_GAME_STATISTICS_TACKLENUM] = $gameStrut->__TackleNum;
        $_data[DATA_BASE_GAME_STATISTICS_FOUL] = $gameStrut->__Foul;
        $_data[DATA_BASE_GAME_STATISTICS_YELLOWCARD] = $gameStrut->__YellowCard;
        $_data[DATA_BASE_GAME_STATISTICS_REDCARD] = $gameStrut->__RedCard;

        return $_data;
    }

    function getGameStatistics($gameStrutList)
    {
        $_gamesData = array();
        if(is_array($gameStrutList))
        {
            foreach($gameStrutList as $value)
            {
                if($value instanceof SGameStatisticsInfo)
                {
                    $_gameData = $this->_getStatisticsStrut($value);
                    array_push($_gamesData, $_gameData);

                    $this->_addNum += 1;
                }
            }
        }
        return $_gamesData;
    }

    function addStatisticsData($data)
    {
        if(empty($data))
            return false;

        $_fieldList=eval(DATA_BASE_GAME_STATISTICS_FIELD);
        $_isSuccess = $this->DB_multi_insert($this->_tableName, $_fieldList, $data);
        if($_isSuccess)
        {
            $_totalDataNum = $this->_dataNum + $this->_addNum;
            return $this->_config->updateConfig(DATA_BASE_CONFIG_GAMESTATISTICSNUM, $_totalDataNum);
        }
        return false;
    }

    function getGameStatisticsByRoomId($roomId)
    {
        $_data = $this->getModelData($this->_tableName, "roomid", $roomId);
        if(empty($_data))
        {
            return null;
        }

        $_backArr = array();
        foreach($_data as $key => $value)
        {
            $_statisticsArr = array();
            foreach($value as $field => $fieldValue)
            {
                if($field >= DATA_BASE_GAME_STATISTICS_BALLCONTROL)
                {
                    $_sInfo = new SInfo();
                    $_sInfo->__Type = $field;
                    $_sInfo->__Value = $this->getFieldByIndex($field, $key);

                    array_push($_statisticsArr, $_sInfo);
                }
            }

            if(!empty($this->getFieldByIndex(DATA_BASE_GAME_STATISTICS_ISHOME, $key)))
            {
                $_backArr[0] = $_statisticsArr;
            }
            else
            {
                $_backArr[1] = $_statisticsArr;
            }
        }
        return $_backArr;
    }
}

//    2017/5/16  新添加
class GameStatisticsModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        GAME_STATISTICS_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new GameStatisticsModelMgr();
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
            $_db->TableName(DATA_BASE_GAME_STATISTICS);
            $_db->PK(DATA_BASE_GAME_STATISTICS);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_GAME_STATISTICS_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_GAME_STATISTICS);

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

        $_model = new GameStatisticsModel();
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
//        $_db->TableName(DATA_BASE_GAME_STATISTICS);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_GAME_STATISTICS);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI

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
                $_model = new GameStatisticsModel();
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