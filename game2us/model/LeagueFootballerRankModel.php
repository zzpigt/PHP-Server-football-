<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");

/**
 * @date: 2017年4月6日 下午3:10:08
 * @author: meishuijing
 * @desc: 联赛球员排行榜
 */

define("LEAGUE_FB_RANK_TYPE_SHOOT", 0);//射手榜
define("LEAGUE_FB_RANK_TYPE_MARK", 1);//积分榜
define("LEAGUE_FB_RANK_TYPE_ASSISTS", 2);//助攻榜

define("LEAGUE_FB_RANK_MODEL_DEFAULT", 1);


class LeagueFBRankModel extends MysqlDB
{
    private $_leagueId;
    private $_tableName;

    function init($primaryValue)
    {
        if (empty($primaryValue)) {
            printError("LeagueFBRankModel leagueId is " . $primaryValue);
            return false;
        }
        $_leagueIndex = LeagueLogic::getLeagueIndex();

        if(!parent::initDB($primaryValue, true, DB_LEAGUE))
        	return false;

        $this->_leagueId = $primaryValue;
        $this->_tableName = DATA_BASE_LEAGUE_FOOTBALLER_RANK."_".$_leagueIndex;
        	
        $this->getModelData($this->_tableName, DATA_BASE_LEAGUE_FOOTBALLER_RANK_PRI, $primaryValue);
        return true;
    }

    public function saveRankData($value)
    {
        if(empty($value))
            return false;
        
        $_fieldList=eval(DATA_BASE_LEAGUE_FOOTBALLER_RANK_FIELD);

        if($this->DB_update($this->_tableName, $_fieldList, $value, $value[DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID]." and `carduid` = ".$value[DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID]." and `type` = ".$value[DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE]))
        {
            $_data = $this->data();
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE_FOOTBALLER_RANK,$_data, $this->_leagueId, 0, "league"))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE_FOOTBALLER_RANK, null, $this->_leagueId, 0, "league");
            }
            $this->data($_data);
            return true;
        }
        return false;
    } 

    function insertRankData($data)
    {
        if(empty($data))
            return false;

        $_fieldList=eval(DATA_BASE_LEAGUE_FOOTBALLER_RANK_FIELD);
        if($this->DB_multi_insert($this->_tableName, $_fieldList, $data))
        {
        	$_data = $this->data();
            foreach($data as $value)
            {
                $_data = $this->addModelData($_data, $value);
            }
            $this->data($_data);
            if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE_FOOTBALLER_RANK, $_data, $this->_leagueId, 0, "league"))
            {
                MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE_FOOTBALLER_RANK, null, $this->_leagueId, 0, "league");
            }
            return true;
        }
        return false;
    }

    function getRankData()
    {
        if(empty($this->data()))
        {
            return null;
        }
        return $this->data();
    }
    
    static function getLeagueFrontFive($leagueId, $leagueIndex, $type)
    {
    	$mysql = new MysqlDB();
    	if(!$mysql)
    		return false;
    	 
    	global $LeagueDB;
    	if(!$mysql->initDB($LeagueDB, false))
    		return false;
    
    	$table = DATA_BASE_LEAGUE_FOOTBALLER_RANK."_".$leagueIndex;
    
    	$res = $mysql->query("select * from ".$table." where type = ".$type." and leagueid = ".$leagueId." order by `rankresult` limit 5;");
    	return $res;
    }

    function fillData(){
        $this->data($this->getModelData($this->_tableName, DATA_BASE_LEAGUE_FOOTBALLER_RANK_PRI, $this->_leagueId));
    }
}

//    2017/5/16  新添加
class LeagueFBRankModelMgr
{
    private static $_modelArr;
    private static $_instance;
    private $_db;


    private $_fieldList = array(
        LEAGUE_FB_RANK_MODEL_DEFAULT => array('userId'),
    );

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new LeagueFBRankModelMgr();
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
            $_db->TableName(DATA_BASE_LEAGUE_FOOTBALLER_RANK);
            $_db->PK(DATA_BASE_LEAGUE_FOOTBALLER_RANK);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI
            $_db->FieldList(eval(DATA_BASE_LEAGUE_FOOTBALLER_RANK_FIELD));//设置字段列表
            $_db->registerQueryField($this->_fieldList);//注册查询字段
            $_db->TableEnum(TABLE_LEAGUE_FB_RANK);

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

        $_model = new LeagueFBRankModel();
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
//        $_db->TableName(DATA_BASE_LEAGUE_FOOTBALLER_RANK);
//        $_db->registerQueryField($this->_fieldList);
//        $_db->PK(DATA_BASE_LEAGUE_FOOTBALLER_RANK);//设置主键(需要修改)DATA_BASE_CARD_RECOMMEND->DATA_BASE_CARD_RECOMMEND_PRI

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
                $_model = new LeagueFBRankModel();
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
            $_model = new LeagueFBRankModel();
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
                $_model = new LeagueFBRankModel();
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
                $_model = new LeagueFBRankModel();
                $_model->DB_multi_insert1(array_slice($dataArr,$dataCount,$dataCount+$dataNum-1));
                $dataCount += $dataNum;
            }
        }
        return true;
    }
}