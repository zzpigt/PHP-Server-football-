<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/3/14
 * Time: 10:28
 */
define("TACTICS_MODEL_DEFAULT", 1);


class TacticsModel extends MysqlDB
{
    private $_primaryKey;

    public function init($primaryKey)
    {
        if(empty($primaryKey))
        {
            printError("TacticsModel userId is " . $primaryKey);
            return false;
        }

        if(!parent::initDB($primaryKey))
        	return false;

        $this->_primaryKey = $primaryKey;
        $this->TableName(DATA_BASE_TACTICS);
        $this->PK(DATA_BASE_TACTICS_PRI);
        $this->FieldList(eval(DATA_BASE_TACTICS_FIELD));//设置字段列表
        $this->TableEnum(TABLE_TACTICS);//设置表枚举

        $this->data($this->getModelData($primaryKey));
        return true;
//        $this->data = $this->getModelData(DATA_BASE_TACTICS, "userid", $userId);
    }

    /*public function saveTacticsData($value, $index = 0)
    {
        $_data = $this->data();
        if(empty($value) || empty($_data[$index]))
            return false;

        $_fieldList=eval(DATA_BASE_TACTICS_FIELD);

        if($this->DB_update(DATA_BASE_TACTICS, $_fieldList, $_data[$index], $value))
        {
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_TACTICS, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_TACTICS, null, $this->_userId);
            }
            return true;
        }
        return false;
    }*/

    /*function insertTacticsData($data)
    {
        if(empty($data))
            return false;

        $_fieldList=eval(DATA_BASE_TACTICS_FIELD);
        if($this->DB_single_insert(DATA_BASE_TACTICS, $_fieldList, $data))
        {
            $_data = $this->data();
            $_data = $this->addModelData($_data, $data);
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_TACTICS, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_TACTICS, null, $this->_userId);
            }
            $this->data($_data);
            return true;
        }
        return false;
    }*/


    function getTacticsData()
    {
        return $this->data();
    }
//    function setFieldByIndex($field, $uid)
//    {
//        if(empty($this->data))
//        {
//            $this->data = array();
//        }
//        $this->data[0][$field] = $uid;
//    }

    /*function _getTacticsStrut($primaryKey)
    {
        $_tacticsArr = array();
        $_tacticsArr[USER_DATA_FIRST_USERID] = $primaryKey;
        $_tacticsArr[TACTICS_TYPE_TEAMMEMTALITY] = 100001;
        $_tacticsArr[TACTICS_TYPE_PASSDIRECTION] = 100006;
        $_tacticsArr[TACTICS_TYPE_ATTACKDIRECTION] = 100011;
        $_tacticsArr[TACTICS_TYPE_DEFENSE] = 100014;
        $_tacticsArr[TACTICS_TYPE_COMPRESSION] = 100016;
        $_tacticsArr[TACTICS_TYPE_TACKLE] = 100018;
        $_tacticsArr[TACTICS_TYPE_OFFSIDE] = 100021;
        $_tacticsArr[TACTICS_TYPE_MARKING] = 100023;

        return $_tacticsArr;
    }*/

}

//    2017/5/16  新添加
class TacticsModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        TACTICS_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new TacticsModelMgr();
            if(!self::$_instance || !self::$_instance->init())
            {
                return null;
            }
        }
        return self::$_instance;
    }

    function getModelByPrimary($primaryValue)
    {
        if(!empty(self::$_modelArr[$primaryValue]))
        {
            return self::$_modelArr[$primaryValue];
        }

        $_model = new TacticsModel();
        if(!$_model || !$_model->init($primaryValue))
        {
            self::$_modelArr[$primaryValue] = $_model;
            return $_model;
        }
        return null;
    }

    private function init()
    {
        $_db = new MysqlDB();
        if($_db)
        {
            $_db->TableName(DATA_BASE_TACTICS);
            $_db->PK(DATA_BASE_TACTICS);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_TACTICS_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_TACTICS);

            $this->_db = $_db;
            return true;
        }
        return false;
    }

    function getModelList($queryType, $fieldValueList)
    {
//        $_db = new MysqlDB();
//        $_db->TableName(DATA_BASE_TACTICS);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_TACTICS);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI


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
                $_model = new TacticsModel();
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
            $_model = new TacticsModel();
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
                $_model = new TacticsModel();
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
                $_model = new TacticsModel();
                $_model->DB_multi_insert1(array_slice($dataArr,$dataCount,$dataCount+$dataNum-1));
                $dataCount += $dataNum;
            }
        }
        return true;
    }

}

