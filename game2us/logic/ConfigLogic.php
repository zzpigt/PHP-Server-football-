<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_MODEL_PATH."ConfigModel.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/6
 * Time: 16:33
 */
class ConfigLogic
{
    private static $_ConfigModel;
    private static $_instance;

    function init()
    {
        self::$_ConfigModel = new ConfigModel();
        if(empty(self::$_ConfigModel) ||!self::$_ConfigModel->init())
        {
            return false;
        }
        return true;
    }

    static function Instance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new ConfigLogic();
            if(!self::$_instance->init())
            {
                self::$_instance = null;
            }
        }
        return self::$_instance;
    }

    function updateConfig($field, $value)
    {
        self::$_ConfigModel->setFieldByIndex($field, $value);
        return self::$_ConfigModel->updateConfig();
    }

    function getConfigByField($field)
    {
        return self::$_ConfigModel->getFieldByIndex($field);
    }
    
    /**
     * @date : 2017年4月14日 下午6:11:43
     * @author : meishuijing
     * @param :
     * @return : 新的联赛id
     * @desc : 分配一个联赛id
     */
    function newUserId()
    {
    	$userNum = self::$_ConfigModel->getFieldByIndex(DATA_BASE_CONFIG_PLAYERNUM);
    	if(isset($userNum) && $this->updateConfig(DATA_BASE_CONFIG_PLAYERNUM, $userNum + 1))
    	{
//    		return $userNum + 1;
            return "dbKey1|".($userNum + 1);
    	}
    	return null;
    }

    /**
     * @date : 2017年4月14日 下午6:11:43
     * @author : meishuijing
     * @param : 
     * @return : 新的联赛id
     * @desc : 分配一个联赛id
     */
    function newLeagueId()
    {
    	$leagueNum = self::$_ConfigModel->getFieldByIndex(DATA_BASE_CONFIG_LEAGUENUM);
    	if(isset($leagueNum) && $this->updateConfig(DATA_BASE_CONFIG_LEAGUENUM, $leagueNum + 1))
    	{
    		return $leagueNum + 1;
    	}
    	return null;
    }
    
    /**
     * @date : 2017年4月14日 下午6:12:14
     * @author : meishuijing
     * @param : 
     * @return : 
     * @desc : 获取当前最大的联赛id
     */
    function getCurLeagueId()
    {
    	$leagueNum = self::$_ConfigModel->getFieldByIndex(DATA_BASE_CONFIG_LEAGUENUM);
    	if($leagueNum)
    		return $leagueNum;
    	return null;
    }

    /**
     * @date : 2017年5月13日 下午1:11:43
     * @author : tongjiwnen
     * @param : $dataBaseEnum 是传入需要统计数据总数的数据表在config表中对应的枚举值
     *          $shardingNum 分片，每个数据库的总存储量的枚举值
     * @return :
     * @desc : 统计更新某表数据总数
     */
    function upDataTableNum($dataBaseEnum, $dataNum = 1, $shardingEnum = NULL){
        $leagueNum = self::$_ConfigModel->getFieldByIndex($dataBaseEnum);
        if(isset($leagueNum) && $this->updateConfig($dataBaseEnum, $leagueNum + $dataNum))
        {
            global $DBConfig;
            $dataTableNum = array();
            if(is_null($shardingEnum))
                $shardingEnum = DB_DEFAULT;

            $shardingNum = 0;
            for($i=1;$i<$dataNum;$i++){
                foreach($DBConfig as $dbKey => $configValue){
                    //从第一个数据库开始判断
                    $shardingNum += intval($configValue[DB_SHARDING_LEVEL][$shardingEnum]);
                    if(($leagueNum + $i)<=$shardingNum){
                        $dataTableNum[$i] = $dbKey.(String)($leagueNum + $i);
                        break;
                    }
                }
            }
            return $dataTableNum;//返回一个数组，
        }
        return null;
    }
}