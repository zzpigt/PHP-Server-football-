<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/3/31
 * Time: 17:10
 */
define("CLUB_MODEL_DEFAULT", 1);


class ClubModel extends MysqlDB
{
    private $_userId;

    function init($userId)
    {
        if (empty($userId)) {
            printError("ClubModel userId is " . $userId);
            return false;
        }

        if(!parent::initDB($userId))
        	return false;

        $this->_userId = $userId;
        $this->TableName(DATA_BASE_CLUB);
        $this->PK(DATA_BASE_CLUB_PRI);
        $this->FieldList(eval(DATA_BASE_CLUB_FIELD));//设置字段列表
        $this->TableEnum(TABLE_CLUB);//设置表枚举



//        $this->data = $this->getModelData(DATA_BASE_CLUB, "userid", $userId);
        $this->data($this->getModelData(TABLE_CLUB, DATA_BASE_CLUB_PRI, $userId));
        return true;
    }


    public function saveClubData($value, $index = 0)
    {
        $_data = $this->data();
        if(empty($value) || empty($_data[$index]))
            return false;

        $_fieldList=eval(DATA_BASE_CLUB_FIELD);
        if($this->DB_update(DATA_BASE_CLUB, $_fieldList, $_data[$index], $value))
        {
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_CLUB, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_CLUB, null, $this->_userId);
            }
            return true;
        }
        return false;
    }

    function insertClubData($data)
    {
        if(empty($data))
            return false;

        $_fieldList=eval(DATA_BASE_CLUB_FIELD);
        if($this->DB_single_insert(DATA_BASE_CLUB, $_fieldList, $data))
        {
//            $_data = $this->data();
            $_data = array();
            $_data = $this->addModelData($_data, $data);
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_CLUB, $_data, $this->_userId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_CLUB, null, $this->_userId);
            }
            $this->data($_data);
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
//
//        $this->data[0][$field] = $uid;
//    }

    function getClubData()
    {
        return $this->data()[0];
    }

    function userId()
    {
        return $this->_userId;
    }

    function _getClubStrut($name, $clubName, $fansName, $city, $countryId, $createTime, $primaryKey)
    {
        $_data = array();

        $_data[DATA_BASE_CLUB_USERID] = $primaryKey;
        $_data[DATA_BASE_CLUB_LEVEL] = 1;

        if($createTime)
            $_data[DATA_BASE_CLUB_CREATEDATE] = $createTime;
        else
            $_data[DATA_BASE_CLUB_CREATEDATE] = time();

        $_data[DATA_BASE_CLUB_NAME] = $name;
        $_data[DATA_BASE_CLUB_CLUBNAME] = $clubName;
        $_data[DATA_BASE_CLUB_STADIUMNAME] = $clubName . "Stadium";
        $_data[DATA_BASE_CLUB_STADIUMSEATNUM] = 200;
        $_data[DATA_BASE_CLUB_FANS] = $fansName;
        $_data[DATA_BASE_CLUB_CITY] = $city;
        $_data[DATA_BASE_CLUB_COUNTRY] = $countryId;

        /*$_teamSignLogic = new TeamSignLogic();
        if(empty($_teamSignLogic))
        {
            return $_data;
        }
        if(!$_teamSignLogic->isCreate($this->_clubModel->userId()))
        {
            return $_data;
        }
        $_data[DATA_BASE_CLUB_TEAMSIGN] = $_teamSignLogic->getTeamSignData()[0][DATA_BASE_TEAMSIGN_SIGNID];

        $_jerseyLogic = new JerseyLogic();
        if(empty($_jerseyLogic))
        {
            return $_data;
        }
        if(!$_jerseyLogic->isCreate($this->_clubModel->userId()))
        {
            return $_data;
        }
        $_jerseyData = $_jerseyLogic->getJerseyData();
        $_data[DATA_BASE_CLUB_HOMEJERSEY] = $_jerseyData[0][DATA_BASE_JERSEY_JERSEYID];
        $_data[DATA_BASE_CLUB_AWAYJERSEY] = $_jerseyData[1][DATA_BASE_JERSEY_JERSEYID];*/

        return $_data;
    }

}

//    2017/5/16  新添加
class ClubModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;
    private $_clubModel;//2017.05.17


    private $_fieldList = array(
        CLUB_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new ClubModelMgr();
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
            $_db->TableName(DATA_BASE_CLUB);
            $_db->PK(DATA_BASE_CLUB);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_CLUB_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_CLUB);

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

        $_model = new ClubModel();
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
//        $_db->TableName(DATA_BASE_CLUB);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_CLUB);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI

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
                $_model = new ClubModel();
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