<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");

/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/22
 * Time: 16:45
 */

define("CARD_RECOMMEND_MODEL_DEFAULT", 1);
class CardRecommendModel extends MysqlDB
{
    private $_primaryValue;
    public function init($primaryValue)
    {
        if(empty($primaryValue))
        {
            printError("CardRecommendModel userId is " . $primaryValue);
            return false;
        }

        if(!parent::initDB($primaryValue))
            return false;

        $this->_primaryValue = $primaryValue;
//        $this->data($this->gzUnCompress($this->getModelData(DATA_BASE_CARD_RECOMMEND, "userid", $primaryValue)));
        $this->fillData();
        return true;
    }

    private function gzCompress($data)
    {
        if(is_array($data))
        {
            foreach($data as $key => $value)
            {
                if(!empty($data[$key][DATA_BASE_CARD_RECOMMEND_CARDATTRIBUTE]))
                {
                    $data[$key][DATA_BASE_CARD_RECOMMEND_CARDATTRIBUTE] = base64_encode(gzcompress(json_encode($data[$key][DATA_BASE_CARD_RECOMMEND_CARDATTRIBUTE])));
                }
            }
        }

        return $data;
    }

    private function gzUnCompress($data)
    {
        if(is_array($data))
        {
            foreach($data as $key => $value)
            {
                if(!empty($data[$key][DATA_BASE_CARD_RECOMMEND_CARDATTRIBUTE]))
                {
                    $data[$key][DATA_BASE_CARD_RECOMMEND_CARDATTRIBUTE] = json_decode(gzuncompress(base64_decode($data[$key][DATA_BASE_CARD_RECOMMEND_CARDATTRIBUTE])), true);
                }
            }
        }

        return $data;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/22
     * Time: 17:18
     * Des: 组装推荐球员结构
     */
    private function _getCardRecommendStrut($_cardData)
    {
        $_data = array();
        $_data[DATA_BASE_CARD_RECOMMEND_USERID] = $this->_primaryValue;
        $_data[DATA_BASE_CARD_RECOMMEND_CARDATTRIBUTE] = $_cardData;
        $_data[DATA_BASE_CARD_RECOMMEND_TOKEN] = 11;

        return $_data;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/22
     * Time: 17:12
     * Des: 插入多条推荐数据（压缩过）
     */
    function insertCardRecommend($_cardDataArr)
    {
        $_cardRecommendArr = array();
        foreach($_cardDataArr as $_cardData)
        {
            array_push($_cardRecommendArr, $this->_getCardRecommendStrut($_cardData));
        }

        $_packCardRecommendArr = $this->gzCompress($_cardRecommendArr);

        $_fieldList=eval(DATA_BASE_CARD_RECOMMEND_FIELD);
        if($this->DB_multi_insert(DATA_BASE_CARD_RECOMMEND, $_fieldList, $_packCardRecommendArr))
        {
            $_data = $this->data();
            foreach($_packCardRecommendArr as $value)
            {
                $_data = $this->addModelData($_data, $value);
            }
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_CARD_RECOMMEND, $_data, $this->_primaryValue))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_CARD_RECOMMEND, null, $this->_primaryValue);
            }
            $this->data($_cardRecommendArr);
            return true;
        }

        return false;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/22
     * Time: 17:23
     * Des: 删除推荐球员
     */
    function deleteCardRecommend()
    {
        if($this->DB_delete(DATA_BASE_CARD_RECOMMEND, 'userid', $this->_primaryValue))
        {
            MemInfoLogic::Instance()->setMemData(DATA_BASE_CARD_RECOMMEND, null, $this->_primaryValue);
            return true;
        }
        return false;
    }

    function UserId()
    {
        return $this->_primaryValue;
    }

    function fillData(){
        $this->data($this->gzUnCompress($this->getModelData($this->_primaryValue)));
    }
}
class CardRecommendModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;

    private $_fieldList = array(
        CARD_RECOMMEND_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new CardRecommendModelMgr();
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
            $_db->TableName(DATA_BASE_CARD_RECOMMEND);
            $_db->PK(DATA_BASE_CARD_RECOMMEND);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_CARD_RECOMMEND_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_CARD_RECOMMEND);

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

        $_model = new CardRecommendModel();
        if(!$_model || !$_model->init($primaryValue))
        {
            if(!$_model->dataIsEmpty())
            {
                self::$_modelArr[$primaryValue] = $_model;
                return $_model;
            }
        }
        return null;
    }

    function getModelList($queryType, $fieldValueList)
    {
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
                $_model = new CardRecommendModel();
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
            $_model = new CardRecommendModel();
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
                $_model = new CardRecommendModel();
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
                $_model = new CardRecommendModel();
                $_model->DB_multi_insert1(array_slice($dataArr,$dataCount,$dataCount+$dataNum-1));
                $dataCount += $dataNum;
            }
        }
        return true;
    }
}