<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/17
 * Time: 16:29
 * Des: 卡牌数据统计
 */
define("CARD_STATISTICS_MODEL_DEFAULT", 1);

class CardStatisticsModel extends MysqlDB
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
        $_dataNum = $_config->getConfigByField(DATA_BASE_CONFIG_CARDSTATISTICSNUM);
        $this->_dataNum = $_dataNum;

        $_tableIndex = intval($_dataNum / STATISTICS_TABLE_DATA_COUNT) + 1;
        $this->_tableName = DATA_BASE_CARD_STATISTICS . "_" . $_tableIndex;
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

    private function _getStatisticsStrut($cardStrut)
    {
        if (!$cardStrut instanceof SCardStatisticsInfo)
        {
            return null ;
        }

        $_data = array();
        $_data[DATA_BASE_CARD_STATISTICS_CARDUID] = $cardStrut->__CardUid;
        $_data[DATA_BASE_CARD_STATISTICS_ISMVP] = $cardStrut->__IsMVP;
        $_data[DATA_BASE_CARD_STATISTICS_GOALNUM] = $cardStrut->__GoalNum;
        $_data[DATA_BASE_CARD_STATISTICS_ASSISTS] = $cardStrut->__Assists;
        $_data[DATA_BASE_CARD_STATISTICS_SCORE] = $cardStrut->__Score;
        $_data[DATA_BASE_CARD_STATISTICS_YELLOWCARD] = $cardStrut->__YellowCard;
        $_data[DATA_BASE_CARD_STATISTICS_REDCARD] = $cardStrut->__RedCard;
        $_data[DATA_BASE_CARD_STATISTICS_ROOMID] = $cardStrut->__RoomId;

        return $_data;
    }

    function getCardStatistics($cardStrutList)
    {
        $_cardsData = array();
        if(is_array($cardStrutList))
        {
            foreach($cardStrutList as $value)
            {
                if($value instanceof SCardStatisticsInfo)
                {
                    $_cardData = $this->_getStatisticsStrut($value);
                    array_push($_cardsData, $_cardData);

                    $this->_addNum += 1;
                }
            }
        }
        return $_cardsData;
    }

    function addStatisticsData($data)
    {
        if(empty($data))
            return false;

        $_fieldList=eval(DATA_BASE_CARD_STATISTICS_FIELD);
        $_isSuccess = $this->DB_multi_insert($this->_tableName, $_fieldList, $data);
        if($_isSuccess)
        {
            $_totalDataNum = $this->_dataNum + $this->_addNum;
            return $this->_config->updateConfig(DATA_BASE_CONFIG_CARDSTATISTICSNUM, $_totalDataNum);
        }
        return false;
    }
}

//    2017/5/16  新添加
class CardsStatisticsModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        CARD_STATISTICS_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new CardsStatisticsModelMgr();
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
            $_db->TableName(DATA_BASE_CARD_STATISTICS);
            $_db->PK(DATA_BASE_CARD_STATISTICS);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_CARD_STATISTICS_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_CARD_STATISTICS);

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

        $_model = new CardStatisticsModel();
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
//        $_db->TableName(DATA_BASE_CARD_STATISTICS);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_CARD_STATISTICS);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI

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
                $_model = new CardStatisticsModel();
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