<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/3/7
 * Time: 18:55
 */
define("FORMATION_MODEL_DEFAULT", 1);


class FormationModel extends MysqlDB
{
    private $_userId;

    public function init($userId)
    {
        if(empty($userId))
        {
            printError("FormationModel userId is " . $userId);
            return false;
        }

        if(!parent::initDB($userId))
        	return false;

        $this->_userId = $userId;
        $this->TableName(DATA_BASE_FORMATION);
        $this->PK(DATA_BASE_FORMATION_PRI);
        $this->FieldList(eval(DATA_BASE_FORMATION_FIELD));//设置字段列表
        $this->TableEnum(TABLE_FORMATION);//设置表枚举

//        $this->data = $this->getModelData(DATA_BASE_FORMATION, "userid", $userId);
       	$this->data($this->getModelData(DATA_BASE_FORMATION, DATA_BASE_FORMATION_PRI, $userId));
        return true;
    }

    function insertFormationData($data)
    {
        if(empty($data))
            return false;

        $_fieldList=eval(DATA_BASE_FORMATION_FIELD);
        if($this->DB_single_insert(DATA_BASE_FORMATION, $_fieldList, $data))
        {
            $_data = $this->data();
            $_data = $this->addModelData($_data, $data);
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_FORMATION, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_FORMATION, null, $this->_userId);
            }
            $this->data($_data);
            return true;
        }
        return false;
    }

    function saveFormationData($value)
    {
        if(empty($value))
            return false;

        $_data = $this->data();
        $_fieldList=eval(DATA_BASE_FORMATION_FIELD);
        if($this->DB_update(DATA_BASE_FORMATION, $_fieldList, $_data[0], $value))
        {
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_FORMATION, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_FORMATION, null, $this->_userId);
            }
            return true;
        }
        return false;
    }

//    function setFieldByIndex($field, $uid)
//    {
//        if(empty($this->data))
//        {
//            $this->data = array();
//        }
//        $this->data[0][$field] = $uid;
//    }

    function userId()
    {
        return $this->_userId;
    }

    function getFormationData()
    {
        return $this->data();
    }
}

//    2017/5/16  新添加
class FormationModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        FORMATION_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new FormationModelMgr();
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
            $_db->TableName(DATA_BASE_FORMATION);
            $_db->PK(DATA_BASE_FORMATION);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_FORMATION_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_FORMATION);

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

        $_model = new FormationModel();
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
//        $_db->TableName(DATA_BASE_FORMATION);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_FORMATION);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI

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
                $_model = new FormationModel();
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