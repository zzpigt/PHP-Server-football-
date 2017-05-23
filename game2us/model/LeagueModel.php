<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");

/**
 * @date: 2017年4月6日 下午3:10:0

 * @desc: 联萌数据对象
 */
define("LEAGUE_MODEL_DEFAULT", 1);


class LeagueModel extends MysqlDB
{
    private $_leagueId;
    private $_tableName;
    

    function init($primaryValue)
    {
        if (empty($primaryValue)) {
            printError("LeagueModel leagueIndex is " . $primaryValue);
            return false;
        }
        
        
        $_leagueIndex = LeagueLogic::getLeagueIndex();

        if(!parent::initDB($primaryValue, true, DB_LEAGUE))
        return false;


        $this->_leagueId = $primaryValue;
        $this->_tableName = DATA_BASE_LEAGUE."_".$_leagueIndex;

        $this->getModelData($this->_tableName, DATA_BASE_LEAGUE_PRI, $primaryValue);
        return true;
    }
    
    function isCreate()
    {
    	return !empty($this->data());
    }

    public function saveLeagueData($index = 0)
    {
    	$_data = $this->data();
        $_fieldList=eval(DATA_BASE_LEAGUE_FIELD);

        if($this->DB_update($this->_tableName, $_fieldList, $_data[$index], $this->_leagueId))
        {
        	if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE, $_data, $this->_leagueId, 0, "league"))
        	{
        		MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE, null, $this->_leagueId, 0, "league");
        	}
            return true;
        }
        return false;
    }

    function insertLeagueData($data)
    {
        if(empty($data))
            return false;

        $_fieldList=eval(DATA_BASE_LEAGUE_FIELD);
        if($this->DB_single_insert($this->_tableName, $_fieldList, $data))
        {
            $_data = $this->data();
            $_data = $this->addModelData($_data, $data);
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE, $_data, $this->_leagueId, 0, "league"))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE, null, $this->_leagueId, 0, "league");
            }
            $this->data($_data);
            return true;
        }
        return false;
    }

    function getLeagueData()
    {
        if(empty($this->data()))
        {
            return null;
        }
        return $this->data();
    }
    
    static function getAvailableLeague($leagueIndex)
    {
    	$mysql = new MysqlDB();
    	if(!$mysql)
    		return false;
    	
    	global $LeagueDB;
        if(!$mysql->initDB($LeagueDB, false))
        	return false;
        
        $table = DATA_BASE_LEAGUE."_".$leagueIndex;
        
		$res = $mysql->query("select `id` from ".$table." where level = 1  and realnum < ".LEAGUE_GROUP_REAL_USER." limit 1;"); 
		return $res;
    }
    
    static function createRobot($leagueIndex)
    {
    	$mysql = new MysqlDB();
    	if(!$mysql)
    		return false;
    	 
    	global $LeagueDB;
    	if(!$mysql->initDB($LeagueDB, false))
    		return false;
    	
    	$table = DATA_BASE_LEAGUE."_".$leagueIndex;
    	
    	$res = $mysql->query("select `id` from ".$table," where level = 1  and realnum < ".LEAGUE_GROUP_REAL_USER." limit 1;");
    	return $res;
    }

    function fillData(){
        $this->data($this->getModelData($this->_tableName, DATA_BASE_LEAGUE_PRI, $this->_leagueId));
    }
}

//    2017/5/16  新添加
class LeagueModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        LEAGUE_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new LeagueModelMgr();
            if(!self::$_instance || !self::$_instance->init())
            {
                return null;
            }
        }
        return self::$_instance;
    }

    private function _setDBData($_db)
    {
        if($_db instanceof  MysqlDB)
        {
            $_db->TableName(DATA_BASE_LEAGUE."_".LeagueLogic::getLeagueIndex());
            $_db->PK(DATA_BASE_LEAGUE);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_LEAGUE_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_LEAGUE);
            return true;
        }
        return false;
    }
    
    private function init()
    {
        $_db = new MysqlDB();
        if($_db)
        {
            $this->_setDBData($_db);
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

        $_model = new LeagueModel();
        if($_model && $_model->init($primaryValue))
        {
            self::$_modelArr[$primaryValue] = $_model;
            return $_model;
        }
        return null;
    }

    function getModelList($queryType, $fieldValueList)
    {
//        $_db = new MysqlDB();
//        $_db->TableName(DATA_BASE_LEAGUE);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_LEAGUE);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI


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
                $_model = new LeagueModel();
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
        if(!empty(self::$_modelArr[$data[0]])) {
            $_model = new LeagueModel();
            if (!$_model || !$_model->init($data[0])) {
                return false;
            }
            if(!$this->_setDBData($_model))
            {
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
                $_model = new LeagueModel();
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
                $_model = new LeagueModel();
                $_model->DB_multi_insert1(array_slice($dataArr,$dataCount,$dataCount+$dataNum-1));
                $dataCount += $dataNum;
            }
        }
        return true;
    }
}