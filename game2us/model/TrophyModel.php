<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/5
 * Time: 11:23
 */
define("TROPHY_MODEL_DEFAULT", 1);


class TrophyModel extends MysqlDB
{
    private $_primaryValue;

    function init($primaryValue)
    {
        if (empty($primaryValue)) {
            printError("TrophyModel userId is " . $primaryValue);
            return false;
        }

        if(!parent::initDB($primaryValue))
        	return false;

        $this->_primaryValue = $primaryValue;
        $this->TableName(DATA_BASE_TROPHY);
        $this->PK(DATA_BASE_TROPHY_PRI);
        $this->FieldList(eval(DATA_BASE_TROPHY_FIELD));//设置字段列表
        $this->TableEnum(TABLE_TROPHY);//设置表枚举

        $this->data($this->getModelData($primaryValue));
        return true;
    }

    function getTrophyDataList()
    {
        return $this->data();
    }


    function fillData(){
        $this->data($this->getModelData($this->_primaryValue));
    }

}

//    2017/5/16  新添加
class TrophyModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        TROPHY_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new TrophyModelMgr();
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
            $_db->TableName(DATA_BASE_TROPHY);
            $_db->PK(DATA_BASE_TROPHY);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_TROPHY_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_TROPHY);

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

        $_model = new TrophyModel();
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
//        $_db->TableName(DATA_BASE_TROPHY);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_TROPHY);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI


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
                $_model = new TrophyModel();
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

    //插入单条数据
    function addSingleData($data)
    {
        if(empty(self::$_modelArr[$data[0]])) {
            $_model = new TrophyModel();
            if (!$_model || !$_model->init($data[0])) {
                return false;
            }
            if ($_model->DB_single_insert1($data)){
                $_model->fillData();
                self::$_modelArr[$data[0]] = $_model;
                return true;
            }
            else
                return false;
        }else
            return false;

    }

    //插入多条数据（判断数据所在的数据库）
    /*
     * 有多少条相同主键的数据，记下条数，然后多条一起插入
     */
    function addMultiData($dataArr){
        $count = 0;
        $primaryKeyArr = array();
        if(empty($dataArr) || !is_array($dataArr))
            return false;

        foreach($dataArr as $value)
        {
            $primaryKeyArr[$count++] = $value[0];
            if(empty(self::$_modelArr[$value[0]]))
            {
                $_model = new TrophyModel();
                if($_model && $_model->init($value[0]))
                {
                    $_model->fillData();
                    self::$_modelArr[$value[0]] = $_model;
                }
            }
            else
            {
                return false;
            }
        }
        //多条插入，就得把数组按主键不同分成多个数组 array_count_values($primaryKeyArr)
        if(!$primaryKeyArr){
            $dataCount = 0;
            $cutArr = array_count_values($primaryKeyArr);
            foreach ($cutArr as $primaryKey => $dataNum) {
                $_model = new TrophyModel();
                $_model->DB_multi_insert1(array_slice($dataArr,$dataCount,$dataCount+$dataNum-1));
                $dataCount += $dataNum;
            }
        }
        return true;
    }

}