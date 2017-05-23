<?php
include_once("base/db.php");
include_once("base/Config.php");

define("APP_PATH", "./");
define("APP_PROTO_PATH", "proto/");
define("APP_BASE_PATH", "base/");
define("APP_MODEL_PATH", "model/");
define("APP_LOGIC_PATH", "logic/");
define("APP_XMLCONFIG_PATH", "xmlconfig/");
define("APP_DATA_PATH", "data/");
define("APP_PROTOACTION_PATH", "protoaction/");

//configs
define("CONFIG_PLAYERDATA", APP_DATA_PATH.'/server/PlayerData.xml');
define("CONFIG_FIELDPOSITION", APP_DATA_PATH.'/server/FieldPosition.xml');
define("CONFIG_EVENTDATA", APP_DATA_PATH.'/server/EventData.xml');
define("CONFIG_CONSTDATA", APP_DATA_PATH.'/server/ConstData.xml');
define("CONFIG_FIELDDISTANCE", APP_DATA_PATH.'/server/FieldDistance.xml');
define("CONFIG_PLAYERPOSITION", APP_DATA_PATH.'/server/PlayerPosition.xml');
define("CONFIG_SHIRTSET", APP_DATA_PATH.'/server/ShirtSet.xml');
define("CONFIG_COLORDATA", APP_DATA_PATH.'/server/ColorData.xml');
define("CONFIG_COUNTRY", APP_DATA_PATH.'/server/country.xml');
define("CONFIG_STATIC", APP_DATA_PATH.'/server/static.xml');
define("CONFIG_LEAGUETIME", APP_DATA_PATH.'/server/LeagueTime.xml');
define("CONFIG_FORMATIONCREATE", APP_DATA_PATH.'/server/FormationCreate.xml');
define("CONFIG_LEAGUECREATE", APP_DATA_PATH.'/server/LeagueCreate.xml');
define("CONFIG_PLAYERCREATE", APP_DATA_PATH.'/server/PlayerCreate.xml');
define("CONFIG_POSITIONCREATE", APP_DATA_PATH.'/server/PositionCreate.xml');
define("CONFIG_NAME", APP_DATA_PATH.'/server/Name.xml');
define("CONFIG_LANGUAGE", APP_DATA_PATH.'/server/Language.xml');
define("CONFIG_STRINGNAME", APP_DATA_PATH.'/server/String_Name.xml');

//常量值
define("USERS_POOL_MAX", 2);//玩家池大小
define("POWER_RECOVER_TIME", 60);//体力回复时间
define("PVP_RECOVER_TIME", 60);//PVP回复时间
define("FVSUMMON_RECOVER_TIME", 60);//友情召唤回复时间
define("MONEYSUMMON_RECOVER_TIME", 60);//金币召唤回复时间
define("RMBSUMMON_RECOVER_TIME", 60);//钻石召唤回复时间
define("PROBABILITY_MAX",100000);
define("MAGNIFICATION",10000);
define("STATISTICS_TABLE_DATA_COUNT",50000000);//统计表的单张表数据量


//全局常量名称
define("CLIENT_ID",'client_id');
define("LAST_MEM_INDEX", 'last_mem_index');
define("GLOBAL_VARIABLE_MEM", 'global_variable');
define("GLOBAL_CONFIG", 'global_config');
define("LEAGUE_CUR_GROUP", "league_cur_group");
define("LEAGUE_GROUP_REAL_USER", 8);
define("LEAGUE_RECOMBINE_ARR", "leaguer_recombine_arr");
define("LEAGUE_LEVEL_MAX", 40);
define("LEAGUE_FOOTBALLER_FRONT", "league_footballer_front");
define("POLLING_MAR_ARR", "POLLING_MAR_ARR");
define("POLLING_PUSH_CUR", 'POLLING_PUSH_CUR');
define("POLLING_POP_CUR", 'POLLING_POP_CUR');
define("POLLING_LOCK", 'POLLING_LOCK');
define("HEART_BEAT_ATTACH_PACKAGE", 'HEART_BEAT_ATTACH_PACKAGE');

define("HOME_GAME_DATA", 'home_game');
define("AWAY_GAME_DATA", 'away_game');
define("HOME_CARD_DATA", 'home_card');
define("AWAY_CARD_DATA", 'away_card');

define("TOKEN", 'TOKEN');

define("SEPARATOR", '|');

define("TOTAL_SHOT_NUM",0);
define("SHOT_JUST_NUM", 1);
define("TOTAL_GOAL_NUM", 2);
define("TOTAL_PASS_NUM", 3);
define("PASS_SUCCESS_NUM", 4);
define("FREE_KICK_NUM", 5);
define("CORNER_NUM", 6);
define("SAVES_NUM", 7);
define("TACKLE_SUCCESS_NUM", 8);
define("TOTAL_FOUL_NUM", 9);
define("TOTAL_YELLOW_CARD_NUM", 10);
define("TOTAL_RED_CARD_NUM", 11);
define("GAME_DATA_USER_ID", 12);

define("IS_MVP", 0);
define("GOAL_NUM", 1);
define("ASSISTS_NUM", 2);
define("YELLOW_CARD_NUM", 3);
define("RED_CARD_NUM", 4);
define("SCORE_NUM", 5);

//配表常量
define("PVP_RESULT_CLASS", 3);
define("FUNC_OVER_TIME", 100);
//战斗相关常量
define("FIGHT_RESULT_TIME", 0);
define("FIGHT_RESULT_LINE", 1);
define("FIGHT_RESULT_HOME_SCORE", 2);
define("FIGHT_RESULT_AWAY_SCORE", 3);
define("FIGHT_RESULT_IS_HOME", 4);
define("FIGHT_RESULT_BALL_CONTROL", 5);
define("FIGHT_RESULT_SUMMARY", 6);
define("FIGHT_RESULT_SHOT_TYPE", 7);

define("FORMATION_DATA_LINE", 0);
define("FORMATION_DATA_INDEX", 1);

define("FORMATION_FORMAT_CARD_TYPE", 0);
define("FORMATION_FORMAT_CARD_UID", 1);
//mem相关
define("MEM_MAX_LENGTH", 2147483648);
define("MEM_FLUSH_TIME", 1800);
define("MEM_EFFECTIVE_TIME", 3600);

//时区
define("TIME_ZONE_DEFAULT", 8);

//日志
define("LOG_LEVEL_ERROR", 'LOG_ERROR');
define("LOG_LEVEL_DEBUG", 'LOG_DEBUG');
define("LOG_LEVEL_NORMAL", 'LOG_NORMAL');

define("LOG_OPEN_ERROR", true);
define("LOG_OPEN_DEBUG", true);
define("LOG_OPEN_NORMAL", true);
//缓存附加信息枚举
define("MEM_ADDITIONAL_TIME", 1);
define("MEM_ADDITIONAL_COUNT", 2);
define("MEM_ADDITIONAL_HIT", 3);

function getMyDayIndex()
{
	$now = time();
	$myStartDay = mktime(0, 0, 0, 1, 1, 2014);
	
	$differ = $now - $myStartDay;
	
	$differ /= (3600 * 24);
	
	return intval(floor($differ));
}

function my_xml_encode($data, $charset = 'utf-8', $root = 'root') {
	$xml = '<?xml version="1.0" encoding="' . $charset .'"?>';
	$xml .= "<{$root}>";
	$xml .= my_array_to_xml($data);
	$xml .= "</{$root}>";
	return $xml;
} 

function my_xml_decode($xml, $root = 'root') {
	$search = '/<(' . $root . ')>(.*)<\/\s*?\\1\s*?>/s';
	$array = array();
	if(preg_match($search, $xml, $matches)){
		$array = my_xml_to_array($matches[2]);
	}
	return $array;
}

function my_array_to_xml($array) {
	if(is_object($array)){
		$array = get_object_vars($array);
	}
	$xml = '';
	foreach($array as $key => $value){
		$_tag = $key;
		$_id = null;
		if(is_numeric($key)){
			$_tag = 'item';
			$_id = ' id="' . $key . '"';
		}
		$xml .= "<{$_tag}{$_id}>";
		$xml .= (is_array($value) || is_object($value)) ? my_array_to_xml($value) : htmlentities($value);
		$xml .= "</{$_tag}>";
	}
	return $xml;
}

function my_xml_to_array($xml) {
	$search = '/<(\w+)\s*?(?:[^\/>]*)\s*(?:\/>|>(.*?)<\/\s*?\\1\s*?>)/s';
	$array = array ();
	if(preg_match_all($search, $xml, $matches)){
		foreach ($matches[1] as $i => $key) {
			$value = $matches[2][$i];
			if(preg_match_all($search, $value, $_matches)){
				$array[$key] = my_xml_to_array($value);
			}else{
				if('ITEM' == strtoupper($key)){
					$array[] = html_entity_decode($value);
				}else{
					$array[$key] = html_entity_decode($value);
				}
			}
		}
	}
	return $array;
}

function HasState($val, $comp)
{
	if ($comp == (int)($val & $comp)) 
	{
		return true;
	}
	return false;
}
	
function AddState($val1, $val2)
{
	return (int)($val1 | $val2);
}

function DelState($val1, $val2)
{
	return (int)($val1 & ~$val2);
}
function ST($index, $key, $value = '', $timeout = 3600)
{
    if(empty($key))
    {
        return false;
    }
    $mem = new MemDB();
	if(!$mem->init($index))
	{
		return false;
	}
    if('' === $value)
    {
		$_value = $mem->get($key);
		if(!isset($_value))
		{
			return false;
		}
		else
		{
			if(is_numeric($_value))
			{
				return $_value;
			}
			return unserialize($_value);
		}
    }
    else if(is_null($value))
    {
        $mem->clean($key);//没有该key，删除会失败
		return true;
    }
    else
    {
		$_data = $value;
		$_dataLen= null;
		if(is_numeric($_data))
		{
			$_dataLen = 8;
		}
		else
		{
			$_data = serialize($value);
			$_dataLen = strlen($_data);
		}

		$_memNowSize = $mem->getStats()['bytes'];
		if($_dataLen + intval($_memNowSize) >= MEM_MAX_LENGTH)
		{
			return false;
		}
		return $mem->set($key, $_data, $timeout);
    }
}

function increment($index, $key)
{
	if(empty($key))
	{
		return false;
	}
	$mem = new MemDB();
	if(!$mem->init($index))
	{
		return false;
	}
	return $mem->increment($key);
}

function printError($msg, $title = null )
{
    error_log("[$title]\t" . print_r($msg, true));
//    error_log(print_r($msg, true));
}

function writeLog($logLevel, $data, $sign = '')
{
	$_isWriteLog = false;

	$_path = null;
	if(LOG_OPEN_ERROR && $logLevel == LOG_LEVEL_ERROR)
	{
		$_path = "LOG_ERROR.TXT";
		$_isWriteLog = true;
	}
	elseif(LOG_OPEN_DEBUG && $logLevel == LOG_LEVEL_DEBUG)
	{
		$_path = "LOG_DEBUG.TXT";
		$_isWriteLog = true;
	}
	elseif(LOG_OPEN_NORMAL && $logLevel == LOG_LEVEL_NORMAL)
	{
		$_path = "LOG_NORMAL.TXT";
		$_isWriteLog = true;
	}

	if($_isWriteLog)
	{
		$_txt = "[LOG]\t";
		$_txt .= "[".date('y-m-d h:i:s',time())."]\t";
		$_txt .= "[".$sign."]\t";
		$_txt .= print_r($data, true);
		$_txt .= "\r\n";
		file_put_contents($_path, $_txt, FILE_APPEND);
	}
}

function funcStart($funcName)
{
	list($usec, $sec) = explode(' ', microtime());
    $_start = (float)$usec + (float)$sec;
	MemInfoLogic::Instance()->setMemData($funcName, $_start);
}

function funcEnd($funcName)
{
	list($usec, $sec) = explode(' ', microtime());
    $_stop = (float)$usec + (float)$sec;
    $_start = MemInfoLogic::Instance()->getMemData($funcName);
	MemInfoLogic::Instance()->setMemData($funcName, null);
	$_result = $_stop - $_start;
	$_result *= 1000;

	if($_result > FUNC_OVER_TIME)
	{
		writeLog($funcName, $_result, 'OVERTIME.TXT');
	}
	writeLog($funcName, debug_backtrace(), 'DEBUG.TXT');
    printError($_result."ms", $funcName."exec time");
}

function getTimeStamp($startData, $endData)
{
	$days=round(($endData-$startData)/(24 * 60 * 60)) ;
	return abs($days);
}

/**
 * Created by
 * User: Vincent
 * Date: 2017/5/11
 * Time: 11:33
 * Des: 连接key值
 *  参数$keyList为数组时，将key拼接
 *  参数$keyList不为数组时，直接返回
 */
function connectKey($keyList)
{
	if(is_array($keyList))
	{
		$_backKey = "";
		foreach($keyList as $key)
		{
			$_backKey .= SEPARATOR;
			$_backKey .= $key;
		}
		return $_backKey;
	}
	return $keyList;
}

function getMemAdditionalInfo()
{

}

class RateHelper
{
	private $m_fRand ;
	
	function __construct()
	{
		$nRand = mt_rand() % 10000;
		$this->m_fRand = floatval($nRand / 10000);
	}
	
	public function calcuate($fRate)
	{
		if($this->m_fRand <= $fRate)
		{
			return true;
		}
		else
		{
			$this->m_fRand -= $fRate;
			return false;
		}
	}
	
}


