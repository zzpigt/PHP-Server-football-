<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/2/15
 * Time: 15:52
 */
define("FRIEND_LIST_MODEL_DEFAULT", 1);


class FriendListModel extends MysqlDB
{
    private $_primaryValue;
    function init($primaryValue)
    {
        if(empty($primaryValue))
        {
            printError(__CLASS__ . ":" . $primaryValue);
            return false;
        }

        if(!parent::initDB($primaryValue))
			return false;

        $this->_primaryValue = $primaryValue;

        $_extra_sql = " or friendid = " . $primaryValue;
        //$this->data($this->getModelData(DATA_BASE_FRIENDLIST, "userid", $primaryValue, $_extra_sql));
        $this->fillData($_extra_sql);
        return true;
    }

//    function deleteFriend($friendId)
//    {
//        $_friendIndex = $this->getFriendIndex($friendId);
//        if(!isset($_friendIndex))
//        {
//            return false;
//        }
//        $_sqlValue = $friendId . "' and userid = '".$this->_primaryValue;
//        if($this->DB_delete(DATA_BASE_FRIENDLIST, "friendid", $_sqlValue))
//        {
//            $_data = $this->data();
//            unset($_data[$_friendIndex]);
//            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_FRIENDLIST, $_data, $this->_primaryValue))
//            {
//                MemInfoLogic::Instance()->setMemData(DATA_BASE_FRIENDLIST, null, $this->_primaryValue);
//            }
//            $this->data($_data);
//            return true;
//        }
//        return false;
//    }

    function getFriendIndex($friendId)
    {
        $_data = $this->data();
        foreach ($_data as $key => $value)
        {
            if($friendId == $value[DATA_BASE_FRIENDLIST_FRIENDID])
            {
                return $key;
            }
        }

        return null;
    }

    function getFriendList()
    {
        $_data = $this->data();
        $_friendList = new SC_Friend_ACK();
        foreach ($_data as $value)
        {
            $_friendInfo = $this->_getFriendInfo($value[DATA_BASE_FRIENDLIST_FRIENDID], $value[DATA_BASE_FRIENDLIST_NICK],$value[DATA_BASE_FRIENDLIST_CLUB]);
            array_push($_friendList->__FriendArr,$_friendInfo );
        }

        return $_friendList;
    }

    private function _getFriendInfo($userId, $name, $club)
    {
        $_friendInfo = new FriendInfo();
        $_friendInfo->__UserID = $userId;
        $_friendInfo->__Name = $name;
        $_friendInfo->__Club = $club;
        return $_friendInfo;
    }

    function getPrimaryValue()
    {
        return $this->_primaryValue;
    }

    function fillData($_extra_sql = null){
        $this->data($this->getModelData($this->_primaryValue, $_extra_sql));
    }
}

//    2017/5/16  新添加
class FriendListModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        FRIEND_LIST_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new FriendListModelMgr();
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
            $_db->TableName(DATA_BASE_FRIENDLIST);
            $_db->PK(DATA_BASE_FRIENDLIST);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_FRIENDLIST_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_FRIEND_LIST);

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

        $_model = new FriendListModel();
        if(!$_model || !$_model->init($primaryValue))
        {
            if($this->_db->dataIsEmpty())
            {
                self::$_modelArr[$primaryValue] = $_model;
                return $_model;
            }
        }
        return null;
    }

    function getModelList($queryType, $fieldValueList)
    {
//        $_db = new MysqlDB();
//        $_db->TableName(DATA_BASE_FRIENDLIST);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_FRIENDLIST);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI

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
                $_model = new FriendListModel();
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
            $_model = new FriendListModel();
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
                $_model = new FriendListModel();
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
                $_model = new FriendListModel();
                $_model->DB_multi_insert1(array_slice($dataArr,$dataCount,$dataCount+$dataNum-1));
                $dataCount += $dataNum;
            }
        }
        return true;
    }
}