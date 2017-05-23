<?php
include_once(getcwd()."/MyConstant.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/1/16
 * Time: 13:34
 */
define("FIGHT_DATA_MODEL_DEFAULT", 1);


class FightDataModel extends MysqlDB
{
    private $_primaryValue;
    function init($primaryValue)
    {
        if(empty($primaryValue))
        {
            printError("FightDataModel userId is " . $primaryValue);
            return false;
        }

        if(!parent::initDB($primaryValue))
        	return false;

        $this->_primaryValue = $primaryValue;
        $this->TableName(DATA_BASE_FIGHTDATA);
        $this->PK(DATA_BASE_FIGHTDATA_PRI);
        $this->FieldList(eval(DATA_BASE_FIGHTDATA_FIELD));//设置字段列表
        $this->TableEnum(TABLE_FIGHT_DATA);//设置表枚举

        $this->data($this->getModelData(DATA_BASE_FIGHTDATA, DATA_BASE_FIGHTDATA_PRI, $primaryValue));

        return true;
//        $this->data = $this->getModelData(DATA_BASE_FIGHTDATA, "roomid", $roomId);
//        $this->data($this->gzUnCompress($this->getModelData(DATA_BASE_FIGHTDATA, "userid", $primaryValue)));
//         $this->gzUnCompress($this->data());
//         printError($this->data(), "init FightDataModel data");
    }

    function insertRoomData($data)
    {
        if(empty($data))
        {
            return false;
        }
        $_data = $this->gzCompress($data);

        $_fieldList = eval(DATA_BASE_FIGHTDATA_FIELD);
        if($this->DB_multi_insert(DATA_BASE_FIGHTDATA, $_fieldList, $_data))
        {
            $_newData = $this->gzCompress($this->data());
            foreach($_data as $value)
            {
                $_newData = $this->addModelData($_newData, $value);
            }
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_FIGHTDATA, $_newData, $this->_roomId))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_FIGHTDATA, null, $this->_roomId);
            }
            $this->data($_newData);
            return true;
        }
        return false;
    }

    private function gzCompress($data)
    {
        if(is_array($data) && !empty($data))
        {
            foreach($data as $key => $value)
            {
                if(!is_numeric($key))
                {
                    continue;
                }
            	if(!isset($data[$key][DATA_BASE_FIGHTDATA_EVENTLINE]))
            		writeLog(LOG_LEVEL_ERROR, $data, "=========================");
            	
                $data[$key][DATA_BASE_FIGHTDATA_EVENTLINE] = base64_encode(gzcompress(json_encode($data[$key][DATA_BASE_FIGHTDATA_EVENTLINE])));
                $data[$key][DATA_BASE_FIGHTDATA_HOMEFORMATION] = base64_encode(gzcompress(json_encode($data[$key][DATA_BASE_FIGHTDATA_HOMEFORMATION])));
                $data[$key][DATA_BASE_FIGHTDATA_AWAYFORMATION] = base64_encode(gzcompress(json_encode($data[$key][DATA_BASE_FIGHTDATA_AWAYFORMATION])));
                if(!empty($data[$key][DATA_BASE_FIGHTDATA_SUMMARY]))
                {
                    $data[$key][DATA_BASE_FIGHTDATA_SUMMARY] = base64_encode(gzcompress(json_encode($data[$key][DATA_BASE_FIGHTDATA_SUMMARY])));
                }
            }
        }

        return $data;
    }

    private function gzUnCompress($data)
    {
        if(is_array($data)  && !empty($data))
        {
            foreach($data as $key => $value)
            {
                if(!is_numeric($key))
                {
                    continue;
                }
                $data[$key][DATA_BASE_FIGHTDATA_EVENTLINE] = json_decode(gzuncompress(base64_decode($data[$key][DATA_BASE_FIGHTDATA_EVENTLINE])), true);
                $data[$key][DATA_BASE_FIGHTDATA_HOMEFORMATION] = json_decode(gzuncompress(base64_decode($data[$key][DATA_BASE_FIGHTDATA_HOMEFORMATION])), true);
                $data[$key][DATA_BASE_FIGHTDATA_AWAYFORMATION] = json_decode(gzuncompress(base64_decode($data[$key][DATA_BASE_FIGHTDATA_AWAYFORMATION])), true);
                if(!empty($data[$key][DATA_BASE_FIGHTDATA_SUMMARY]))
                {
                    $data[$key][DATA_BASE_FIGHTDATA_SUMMARY] = json_decode(gzuncompress(base64_decode($data[$key][DATA_BASE_FIGHTDATA_SUMMARY])), true);
                }
            }
        }

        return $data;
    }

    function getMaxEventLineIndex()
    {
        $_data = $this->data();
        $_index = 0;
        foreach($_data as $key => $value)
        {
            if(is_numeric($key))
            {
                $_index += 1;
            }
        }
        return $_index;
    }

    function getLastEventLine()
    {
        $_data = $this->data();
        $_index = $this->getMaxEventLineIndex() - 1;
        if(empty($_data[$_index]))
        {
            return null;
        }
        return $_data[$_index];
    }

    function getFightSummary()
    {
        $_data = $this->data();
        if(is_array($_data))
        {
            $_backInfo = new SC_MATCH_SUMMARY_ACK();
            $_backInfo->__RoomId = $this->_roomId;
            foreach($_data as $key => $value)
            {
                if(!is_numeric($key) || !isset($value[DATA_BASE_FIGHTDATA_SUMMARY][FIGHT_SUMMARY_DATA_IS_HOME]))
                {
                    continue;
                }
                $value[DATA_BASE_FIGHTDATA_SUMMARY][FIGHT_SUMMARY_DATA_EVENT_POINT] = $value[DATA_BASE_FIGHTDATA_EVENTPOINT];
                $_summaryStrut = new SMatchSummaryInfo();
                $_summaryStrut->__IsHome = $value[DATA_BASE_FIGHTDATA_SUMMARY][FIGHT_SUMMARY_DATA_IS_HOME];
                $_summaryStrut->__EventPoint = $value[DATA_BASE_FIGHTDATA_SUMMARY][FIGHT_SUMMARY_DATA_EVENT_POINT];
                $_summaryStrut->__EventType = $value[DATA_BASE_FIGHTDATA_SUMMARY][FIGHT_SUMMARY_DATA_EVENT_TYPE];
                $_summaryStrut->__MainCardUid = $value[DATA_BASE_FIGHTDATA_SUMMARY][FIGHT_SUMMARY_DATA_MAIN_CARDUID];
                if(!empty($value[DATA_BASE_FIGHTDATA_SUMMARY][FIGHT_SUMMARY_DATA_CARDUID]))
                {
                    $_summaryStrut->__CardUid = $value[DATA_BASE_FIGHTDATA_SUMMARY][FIGHT_SUMMARY_DATA_CARDUID];
                }
                else
                {
                    $_summaryStrut->__CardUid = 0;
                }

                array_push($_backInfo->__SummaryInfo, $_summaryStrut);
            }
            return $_backInfo;
        }
        return null;
    }

//    function updateRoomData($roomId)
//    {
//        if(empty($roomId))
//        {
//            return;
//        }
//
//        $_fieldList = eval(DATA_BASE_FIGHTDATA_FIELD);
//        $this->DB_update(DATA_BASE_FIGHTDATA, $_fieldList, $this->data[0], $roomId);
//
//        $this->roomDataEncode();
//        $this->setMemData(DATA_BASE_FIGHTDATA, $this->roomId, $this->data);
//    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/9
     * Time: 14:31
     * Des: 取得已有的事件点之后的事件链
     */
    function getHadEventLines($point)
    {
        $_eventLineArr = array();
        if(!is_numeric($point))
        {
            return $_eventLineArr;
        }
        $_data = $this->data();
        $_dataCount = $this->getDataCount();
        for($i = 0; $i < $_dataCount; $i++)
        {
            $_hadEventPoint = $this->getFieldByIndex(DATA_BASE_FIGHTDATA_EVENTPOINT, $i);
            if(!empty($_hadEventPoint))
            {
                if($_hadEventPoint >= $point)
                {
                    array_push($_eventLineArr, $_data[$i]);
                }
            }
        }

        return $_eventLineArr;
    }

//    function getFightData($field, $index)
//    {
//        $_data = $this->data();
//        if(empty($_data[$index][$field]))
//        {
//            return null;
//        }
//
//        return $_data[$index][$field];
//    }

    function _getFightDataStrut($homeScore, $roomId, $fightMode, $awayScore, $stageDate, $eventPoint, $_result)
    {
        $_fightData = array();

        $_fightData[DATA_BASE_FIGHTDATA_ROOMID] = $roomId;
        $_fightData[DATA_BASE_FIGHTDATA_HOMESCORE] = $homeScore;
        $_fightData[DATA_BASE_FIGHTDATA_AWAYSCORE] = $awayScore;
        $_fightData[DATA_BASE_FIGHTDATA_EVENTDATE] = $_result[FIGHT_RESULT_TIME];
        $_fightData[DATA_BASE_FIGHTDATA_EVENTLINE] = $_result[FIGHT_RESULT_LINE];
        $_fightData[DATA_BASE_FIGHTDATA_STAGEDATE] = $stageDate;
        $_fightData[DATA_BASE_FIGHTDATA_EVENTPOINT] = $eventPoint;
        $_fightData[DATA_BASE_FIGHTDATA_BALLCONTROL] = $_result[FIGHT_RESULT_BALL_CONTROL];
        $_fightData[DATA_BASE_FIGHTDATA_FIGHTMODE] = $fightMode;
        $_fightData[DATA_BASE_FIGHTDATA_ISHOME] = $_result[FIGHT_RESULT_IS_HOME];
        if(!empty($_result[FIGHT_RESULT_SUMMARY]))
        {
            $_fightData[DATA_BASE_FIGHTDATA_SUMMARY] = $_result[FIGHT_RESULT_SUMMARY];
        }
        else
        {
            $_fightData[DATA_BASE_FIGHTDATA_SUMMARY] = '';
        }

        /*$_formationLogicA = new FormationLogic();
        if(empty($_formationLogicA))
        {
            return $_fightData;
        }
        if(!$_formationLogicA->init($this->_userAId))
        {
            return $_fightData;
        }
        $_fightData[DATA_BASE_FIGHTDATA_HOMEFORMATION] = $_formationLogicA->getFormationInfo($this->_formationDataA);
        $_formationLogicB = new FormationLogic();
        if(empty($_formationLogicB))
        {
            return $_fightData;
        }
        if(!$_formationLogicB->init($this->_userBId))
        {
            return $_fightData;
        }

        $_fightData[DATA_BASE_FIGHTDATA_AWAYFORMATION] = $_formationLogicB->getFormationInfo($this->_formationDataB);*/
        return $_fightData;
    }


}

//    2017/5/16  新添加
class FightDataModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        FIGHT_DATA_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new FightDataModelMgr();
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
            $_db->TableName(DATA_BASE_FIGHTDATA);
            $_db->PK(DATA_BASE_FIGHTDATA);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_FIGHTDATA_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_FIGHT_DATA);

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

        $_model = new FightDataModel();
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
//        $_db->TableName(DATA_BASE_FIGHTDATA);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_FIGHTDATA);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI

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
                $_model = new FightDataModel();
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