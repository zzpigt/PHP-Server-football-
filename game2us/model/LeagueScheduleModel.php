<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");

/**
 * @date: 2017年4月6日 下午3:10:08
 * @author: meishuijing
 * @desc: 联萌数据对象 联合组健的数据表
 */
define("LEAGUE_SCHEDULE_MODEL_DEFAULT", 1);


class LeagueScheduleModel extends MysqlDB
{
    private $_leagueId;
    private $_tableName;

    function init($primaryValue)
    {
        if (empty($primaryValue)) {
            printError("LeagueModel leagueId is " . $primaryValue);
            return false;
        }

        $_leagueIndex = LeagueLogic::getLeagueIndex();


        if(!parent::initDB($primaryValue, true, DB_LEAGUE))
        	return false;

        $this->_leagueId = $primaryValue;
        $this->_tableName = DATA_BASE_LEAGUE_SCHEDULE."_".$_leagueIndex;
        	
        $this->getModelData($this->_tableName, DATA_BASE_LEAGUE_SCHEDULE_PRI, $primaryValue);
        return true;
    }

    public function saveScheduleData($index = 0)
    {
        if(empty($value) || empty($this->data()[$index]))
            return false;

        $_fieldList=eval(DATA_BASE_LEAGUE_SCHEDULE_FIELD);

        if($this->DB_update($this->_tableName, $_fieldList, $this->data()[$index], $value))
        {
           	$_data = $this->data();
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE_SCHEDULE, $_data, $this->_leagueId, 0, "league"))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE_SCHEDULE, null, $this->_leagueId, 0, "league");
            }
            $this->data($_data);
            return true;
        }
        return false;
    }
    

    function insertScheduleData($data)
    {
        if(empty($data))
            return false;

        $_fieldList=eval(DATA_BASE_LEAGUE_SCHEDULE_FIELD);
        if($this->DB_multi_insert($this->_tableName, $_fieldList, $data))
        {
       	 	$_data = $this->data();
            foreach($data as $value)
            {
                $_data = $this->addModelData($_data, $value);
            }
            $this->data($_data);
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE_SCHEDULE, $_data, $this->_leagueId, 0, "league"))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE_SCHEDULE, null, $this->_leagueId, 0, "league");
            }
            return true;
        }
        return false;
    }

    
    static function updateStartTimeByRoom($roomId, $startTime, $leagueIndex)
    {
    	$mysql = new MysqlDB();
    	if(!$mysql)
    		return false;
    	 
    	global $LeagueDB;
    	if(!$mysql->initDB($LeagueDB, false))
    		return false;
    	
    	$table = DATA_BASE_LEAGUE_SCHEDULE."_".$leagueIndex;
    	
    	$res = $mysql->insert("update ".$table." set `starttime` = {$startTime} where roomid = ".$roomId.";");
    	return $res;
    }
    
    static function updateLockByRoom($roomId, $leagueIndex)
    {
    	$mysql = new MysqlDB();
    	if(!$mysql)
    		return false;
    
    	global $LeagueDB;
    	if(!$mysql->initDB($LeagueDB, false))
    		return false;
    	 
    	$table = DATA_BASE_LEAGUE_SCHEDULE."_".$leagueIndex;
    	 
    	$res = $mysql->insert("update ".$table." set `islocked` = 1 where roomid = ".$roomId." limit 1;");
    	return $res;
    }
    
    static function isLockedByRoom($roomId, $leagueIndex)
    {
    	$mysql = new MysqlDB();
    	if(!$mysql)
    		return false;
    
    	global $LeagueDB;
    	if(!$mysql->initDB($LeagueDB, false))
    		return false;
    
    	$table = DATA_BASE_LEAGUE_SCHEDULE."_".$leagueIndex;
    
    	$res = $mysql->query("select `islocked` from ".$table." where roomid = ".$roomId." limit 1;");
    	return $res;
    }
    
    static function updateStatusByRoom($leagueIndex, $roomId, $status, $score1 = null, $score2 = null)
    {
    	$mysql = new MysqlDB();
    	if(!$mysql)
    		return false;
    	
    	global $LeagueDB;
    	if(!$mysql->initDB($LeagueDB, false))
    		return false;
    	 
    	$table = DATA_BASE_LEAGUE_SCHEDULE."_".$leagueIndex;

        $res = null;
    	if($status == GAME_STATUS_TYPE_GAMEING)
    		$res = $mysql->insert("update ".$table." set `status` = {$status} where roomid = ".$roomId.";");
    	else if($status == GAME_STATUS_TYPE_FINISH)
    		$res = $mysql->insert("update ".$table." set `status` = {$status}, `score1` = {$score1}, `score2` = {$score2}  where roomid = ".$roomId.";");
    	return $res;
    }
    

    static function queryByRoom($roomId, $leagueIndex)
    {
    	$mysql = new MysqlDB();
    	if(!$mysql)
    		return false;
    
    	global $LeagueDB;
    	if(!$mysql->initDB($LeagueDB, false))
    		return false;
    	 
    	$table = DATA_BASE_LEAGUE_SCHEDULE."_".$leagueIndex;
    	 
    	$res = $mysql->query("select * from ".$table." where roomid = ".$roomId." limit 1;");
    	return $res;
    }

    function fillData(){
        $this->data($this->getModelData($this->_tableName, DATA_BASE_LEAGUE_SCHEDULE_PRI, $this->_leagueId));
    }
}

//    2017/5/16  新添加
class LeagueScheduleModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        LEAGUE_SCHEDULE_MODEL_DEFAULT => array('leagueId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new LeagueScheduleModelMgr();
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
            $_db->TableName(DATA_BASE_LEAGUE_SCHEDULE);
            $_db->PK(DATA_BASE_LEAGUE_SCHEDULE);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_LEAGUE_SCHEDULE_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_LEAGUE_SCHEDULE);

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

        $_model = new LeagueScheduleModel();
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
//        $_db->TableName(DATA_BASE_LEAGUE_SCHEDULE);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_LEAGUE_SCHEDULE);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI


        $_db = $this->_db;
        if(!$_db instanceof MysqlDB)
        {
            return null;
        }
        $_primaryList = $_db->startQuery($queryType, $fieldValueList);//queryType:LEAGUE_SCHEDULE_MODEL_DEFAULT => array('leagueId'),存储每条数据的主键
        if(empty($_primaryList))
        {
            return null;
        }

        $_backModelList = array();
        foreach($_primaryList as $key => $value)//$value为某数据的主键
        {
            if(empty(self::$_modelArr[$key]))
            {
                $_model = new LeagueScheduleModel();
                if($_model && $_model->init($key))
                {
                    self::$_modelArr[$key] = $_model;
                    $_backModelList[$key] = $_model;//$_backModelList存储着某条数据的主键 =》 model
                }
            }
            else
            {
                $_backModelList[$key] = self::$_modelArr[$key];
            }
        }
        return $_backModelList;//返回的是多个model
    }

    //插入单条数据
    function addSingleData($data)
    {
        if(empty(self::$_modelArr[$data[0]])) {
            $_model = new LeagueScheduleModel();
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
                $_model = new LeagueScheduleModel();
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
                $_model = new LeagueScheduleModel();
                $_model->DB_multi_insert1(array_slice($dataArr,$dataCount,$dataCount+$dataNum-1));
                $dataCount += $dataNum;
            }
        }
        return true;
    }
}