<?php

include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/25
 * Time: 10:37
 */
define("SCOUT_MODEL_DEFAULT", 1);


class ScoutModel extends MysqlDB
{
    private $_userId;
    public function init($userId)
    {
        if(empty($userId))
        {
            printError("ScoutModel userId is " . $userId);
            return false;
        }

        if(!parent::initDB($userId))
            return false;

        $this->_userId = $userId;
        $this->data($this->gzUnCompress($this->getModelData(DATA_BASE_SCOUT, "userid", $userId)));
        return true;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 10:55
     * Des: 数据压缩
     */
    private function gzCompress($data)
    {
        if(is_array($data))
        {
            foreach($data as $key => $value)
            {
                if(!empty($data[$key][DATA_BASE_SCOUT_CARDATTRIBUTE]))
                {
                    $data[$key][DATA_BASE_SCOUT_CARDATTRIBUTE] = base64_encode(gzcompress(json_encode($data[$key][DATA_BASE_SCOUT_CARDATTRIBUTE])));
                }
            }
        }

        return $data;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 10:55
     * Des: 数据解压缩
     */
    private function gzUnCompress($data)
    {
        if(is_array($data))
        {
            foreach($data as $key => $value)
            {
                if(!empty($data[$key][DATA_BASE_SCOUT_CARDATTRIBUTE]))
                {
                    $data[$key][DATA_BASE_SCOUT_CARDATTRIBUTE] = json_decode(gzuncompress(base64_decode($data[$key][DATA_BASE_SCOUT_CARDATTRIBUTE])), true);
                }
            }
        }

        return $data;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 10:58
     * Des: 球探数据组装
     */
    private function _getScoutStrut($cardDataArr)
    {
        $_data = array();
        $_data[DATA_BASE_SCOUT_USERID] = $this->_userId;
        $_data[DATA_BASE_SCOUT_CARDATTRIBUTE] = $cardDataArr;

        return $_data;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 11:43
     * Des: 插入球探数据
     */
    function insertScout($cardDataArr)
    {
        $_scoutArr = array();
        array_push($_scoutArr, $this->_getScoutStrut($cardDataArr));

        $_packScoutArr = $this->gzCompress($_scoutArr);

        $_fieldList=eval(DATA_BASE_SCOUT_FIELD);
        if($this->DB_single_insert(DATA_BASE_SCOUT, $_fieldList, $_packScoutArr[0]))
        {
//            $_data = $this->data();
            $_data = $_packScoutArr;
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_SCOUT, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_SCOUT, null, $this->_userId);
            }
            $this->data($_data);
            return true;
        }

        return false;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 11:43
     * Des: 更新球探数据
     */
    function updateScout()
    {
        $_data = $this->data();
        $_data = $this->gzCompress($_data);

        $_fieldList=eval(DATA_BASE_SCOUT_FIELD);
        if($this->DB_update(DATA_BASE_SCOUT, $_fieldList, $_data[0], $this->_userId))
        {
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_SCOUT, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_SCOUT, null, $this->_userId);
            }
            return true;
        }
        return false;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 11:45
     * Des: UserId属性
     */
    function UserId()
    {
        return $this->_userId;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 14:08
     * Des: 检测数据是否存在
     */
    function isHaveScoutData()
    {
        if(empty($this->data()))
        {
            return false;
        }
        return true;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 14:16
     * Des: 取得球探球员的数据
     */
    function getScoutCardData()
    {
        $_data = $this->data();
        if(!empty($_data[0][DATA_BASE_SCOUT_CARDATTRIBUTE]))
        {
            return $_data[0][DATA_BASE_SCOUT_CARDATTRIBUTE];
        }
        return null;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 17:38
     * Des: 设置球探球员数据
     */
    function setScoutCardData($index, $data)
    {
        $_data = $this->data();
        if(!empty($_data[0][DATA_BASE_SCOUT_CARDATTRIBUTE][$index]))
        {
            if(empty($data))
            {
                unset($_data[0][DATA_BASE_SCOUT_CARDATTRIBUTE][$index]);
            }
            else
            {
                $_data[0][DATA_BASE_SCOUT_CARDATTRIBUTE][$index] = $data;
            }
            $this->data($_data);
        }
    }
}

//    2017/5/16  新添加
class ScoutModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        SCOUT_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new ScoutModelMgr();
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
            $_db->TableName(DATA_BASE_SCOUT);
            $_db->PK(DATA_BASE_SCOUT);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_SCOUT_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_SCOUT);

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

        $_model = new ScoutModel();
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
//        $_db->TableName(DATA_BASE_SCOUT);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_SCOUT);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI


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
                $_model = new ScoutModel();
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