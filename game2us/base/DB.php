<?php
/**
 * 数据库封装类
 */

include_once ("Config.php");
include_once("Route.php");

define("QUERY_FIELD_LIST",1);
define("MAX_FIELD_VALUE_LIST",10000);
class MysqlDB
{
    private static $_dbConnectionList = array();
    private $_dbConnection = null;
	private $data = null;
    private $_fieldKeyList = null;//存储主键

	private $_pk = null;
	private $_tableName = null;
    private $_fieldList = null;//字段列表
    private $_tableEnum = null;//表名枚举

 	private $_queryFieldList = array();
    private $_dbType = null;
    function initDB($routeValue, $isUserId = true, $listKey = null)
    {
         if(!$this->_checkDbAttribute())
         {
             return false;
         }

        $config = null;
//        $routeValue = "dbKey1|".$routeValue;//暂时用一下
        global $DBConfig;
        if($isUserId)
        {
            if($str = strstr($routeValue,'|',true))
                $config = $DBConfig[$str];
            else
                return false;
        }
        else
        {
            if(is_array($routeValue))
            {
                $config = $routeValue;
            }
        }

        $_dbKey = getHash(json_encode($config).$listKey);
        if(!empty(self::$_dbConnectionList[$_dbKey]))
        {
            $this->_dbConnection = self::$_dbConnectionList[$_dbKey];
            return true;
        }

        $this->_dbConnection = mysqli_connect($config[DB_HOST], $config[DB_USER], $config[DB_PASSWORD]);
        if (null == $this->_dbConnection)
            return false;

        if (!mysqli_character_set_name($this->_dbConnection))
            return false;

        if (isset($listKey) && array_key_exists($listKey, $config[DB_NAME_LIST])){
            if(!mysqli_select_db($this->_dbConnection, $config[DB_NAME_LIST][$listKey]))
                return false;
        }else{
            if(!mysqli_select_db($this->_dbConnection, $config[DB_NAME_LIST][DB_DEFAULT]))
                return false;
        }
        //DB_SHARDING_LEVEL还没有做

        if(!mysqli_set_charset($this->_dbConnection, 'utf8'))
        	return false;
        
        if(!mysqli_query($this->_dbConnection, "SET NAMES UTF8"))
        	return false;

        self::$_dbConnectionList[$_dbKey] = $this->_dbConnection;

        return true;
    }

    private function _checkDbAttribute()
    {
        if(!isset($this->_tableName) || !isset($this->_pk) || !isset($this->_fieldList) || !isset($this->_tableEnum))
        {
            return false;
        }
        return true;
    }

    function escapeString($str)
    {
        return mysqli_real_escape_string($this->_dbConnection, $str);//转义字符串中特殊的字符
    }

    function error()
    {
        if (!$this->_dbConnection)
        {
            return "db connection is not connected!";
        }

        return mysqli_error($this->_dbConnection);
    }
	
	function query($sql)
    {
		$result = null;
        $res = mysqli_query($this->_dbConnection ,$sql);
        if (mysqli_errno($this->_dbConnection))
        {
            return $result;
        }

        //$rows = mysqli_num_rows($res);

        if(empty($res))
        {
            return $result;
        }
        $rows = $res->num_rows;
        if (0 < $rows)
        {
            $j = 0;
            while ($j < $rows)
            {
				$result[$j] = $res->fetch_assoc();
                $j++;
            }
            mysqli_free_result($res);
        }
        
        return $result;
    }

    function getInsertId()
    {
    	$id = mysqli_insert_id($this->_dbConnection);
        printError($id);
        return $id;
    }
	
	function PK($pk)
	{
		$this->_pk = $pk;
	}
	
	function TableName($name)
	{
		$this->_tableName = $name;
	}

    function FieldList($fieldList)
    {
        if(is_array($fieldList))
        {
            $this->_fieldList = $fieldList;
        }
    }

    function TableEnum($tableEnum)
    {
        $this->_tableEnum = $tableEnum;
    }

    function data($data = null)
    {
        if(!isset($data))
        {
            return $this->data;
        }
        $this->data = $data;
        return $data;
    }

    //修改的
    function getDataFromDB($tableName, $pk, $value, $extra = null)
    {
        $_sql = "select * from {$tableName} where {$pk} = " . "'".$value."'";
        if(!empty($extra))
        {
            //添加sql的额外条件
            $_sql .= $extra;
        }

        $data = $this->select($_sql);
        if(!empty($data))
        {
            $data = $data[0];
        }
        return $data;
    }

    function addModelData($data, $value)
    {
        if(is_array($data))
        {
            array_push($data, $value);
        }

        return $data;
    }

    function alertModelData($data, $value, $index)
    {
        if(is_array($data))
        {
            $data[$index] = $value;
        }

        return $data;
    }

    /*
     * 取出数据（如果缓存中没有，就从DB中取数据）
     * 参数：
     *  $value：主键的值
     * */
    function getModelData($value, $extra = null, $tableSuffix = null)
    {
        $_modelData = MemInfoLogic::Instance()->getMemData($this->_tableEnum, $value);//从缓存中取得数据
        $_data = $_modelData;

        if(empty($_data))
        {
            $_tableName = $this->_tableName;
            if(isset($tableSuffix))
            {
                $_tableName = $_tableName."_".$tableSuffix;
            }
            $_data = $this->getDataFromDB($_tableName, $this->_pk, $value, $extra);
        }

        MemInfoLogic::Instance()->setMemData($this->_tableEnum, $_data, $value);
        $this->data($_data);
        return $_data;
    }

    function DB_single_insert($tableName, $fieldList, $data)
    {
        funcStart(__METHOD__);
        if(empty($data))
            return false;

        $_count = 0;
        $_filedCount = count($data) - 1;

        $_sql = "insert into {$tableName}(";
        $_data = $data;
        foreach ($_data as $key => $value)
        {
            if(empty($fieldList[$key]))
            {
                if($_count == $_filedCount)
                {
                    $_sql = substr($_sql,0,strlen($_sql)-1);
                    $_sql .= ") values(";
                }

                $_count ++;
                unset($_data[$key]);
                continue;
            }
            if($_count == $_filedCount)
            {
                $_sql .= $fieldList[$key] . ") values(";
            }
            else
            {
                $_sql .= $fieldList[$key] . ",";
            }
            $_count ++;
        }

        $_filedCount = count($_data) - 1;
        $_count = 0;
        foreach ($_data as $key => $value)
        {
            $_value = $value;
            if(is_array($_value))
            {
                $_value = '"'.$this->escapeString(json_encode($_value)).'"';
            }
            else if(!is_numeric($_value) or is_string($_value))
            {
                $_value = '"'.$this->escapeString($_value).'"';
            }

            if($_count == $_filedCount)
            {
                $_sql .= $_value . ");";
            }
            else
            {
                $_sql .= $_value . ",";
            }
            $_count ++;
        }
        printError($_sql);
        funcEnd(__METHOD__);
        return $this->insert($_sql);
    }

    function DB_multi_insert($tableName, $fieldList, $data)
    {
        funcStart(__METHOD__);
        if(!is_array($data))
            return false;

        $_count = 0;
        $_filedCount = count($data[0]) - 1;

        $_sql = "insert into {$tableName}(";
        //拼接需要的字段
        foreach ($data[0] as $key => $attribute)
        {
            if(empty($fieldList[$key]))
                continue;
            if($_count == $_filedCount)
            {
                $_sql .= $fieldList[$key] . ") values(";
            }
            else
            {
                $_sql .= $fieldList[$key] . ",";
            }
            $_count ++;
        }

        $_indexCount = count($data) - 1;
        $_index = 0;
        foreach($data as $key => $row)
        {
            if(!is_array($row))
            {
                continue;
            }
            $_count = 0;
            foreach ($row as $value)
            {
                $_value = $value;
                if(is_array($_value))
                {
                    $_value = '"'.$this->escapeString(json_encode($_value)).'"';
                }
                else if(!is_numeric($_value) or is_string($_value))
                {
                    $_value = '"'.$this->escapeString($_value).'"';
                }

                if($_count == $_filedCount)
                {
                    if($_index == $_indexCount)
                    {
                        $_sql .= $_value . ");";
                    }
                    else
                        $_sql .= $_value . "),(";
                }
                else
                {
                    $_sql .= $_value . ",";
                }
                $_count ++;
            }

            $_index++;
        }
        printError($_sql);
        funcEnd(__METHOD__);
        return $this->insert($_sql);
    }

    function DB_delete($tableName, $pk, $sqlvalue)
    {
        if(!is_numeric($sqlvalue))
        {
            $sqlvalue = "".$sqlvalue."";
        }
        $_sql = "delete from {$tableName} where {$pk} =" . $sqlvalue;
        printError($_sql);
        return $this->insert($_sql);
    }


    function DB_update($tableName, $tableField, $data, $primaryValue)
    {
        $sql = "update {$tableName} set";
        $i = 0;
        foreach($data as $key=>$value)
        {
            if($key != $tableField[0])
            {
                if(!isset($value))
                {
                    continue;
                }
                if(is_array($value))
                {
                    $value = '"'.$this->escapeString(json_encode($value)).'"';
                }
                else if(!is_numeric($value) && $value != "NULL")
                {
                    $value = '"'.$this->escapeString($value).'"';
                }

                if(empty($tableField[$key]))//表中没有该字段
                {
                    continue;
                }

                if($i == 0)
                {
                    $sql .= " `$tableField[$key]` = $value";
                    $i++;
                }
                else
                {
                    $sql .= ", `$tableField[$key]` = $value";
                }
            }
        }
        $sql .= " where ".$tableField[0]." = ".$primaryValue;
        printError($sql);
        $res = mysqli_query($this->_dbConnection, $sql);
        if (mysql_errno())
        {
            return false;
        }
        return true;
    }

    function DB_select($tableName, $pk, $sqlValue, $selectPk = "*")
    {
        $_sql = "select {$selectPk} from {$tableName} where {$pk} = {$sqlValue};";
        return $this->query($_sql);
    }

    function DB_table_data_count($tableName)
    {
        $_fieldName = "dataNum";
        $_sql = "select count(*) as {$_fieldName} FROM {$tableName};";
        return $this->query($_sql)[0][$_fieldName];
    }

    function getFieldByIndex($field)
    {
        if(isset($this->data[$field]))
        {
            return $this->data[$field];
        }

        return null;
    }

    function setFieldByIndex($field, $value)
    {
        if(empty($this->data))
        {
            $this->data = array();
        }
        $this->data[$field] = $value;
    }

    function setExtraCacheField($field, $value)
    {
        $_newData = $this->data;
        $_newData[$field] = $value;
        $this->data = $_newData;
    }

    function getExtraCacheField($field)
    {
        $_newData = $this->data;
        if(empty($_newData[$field]))
            return null;
        return $_newData[$field];
    }

    function getCount()
    {
        return count($this->data);
    }

    function getDataCount()
    {
        return count($this->data);
    }

    function dataIsEmpty()
    {
        return empty($this->data());
    }

    ///////////////////////////////////////////
    //////////////数据库CRUD以下///////////////
    ///////////////////////////////////////////
    private function select($sql)
    {
        funcStart(__METHOD__);
        $res = mysqli_query($this->_dbConnection, $sql);
        if (mysqli_errno($this->_dbConnection))
        {
            return null;
        }

        $dataList = array();
        while ($rowArray = mysqli_fetch_array($res, MYSQLI_NUM))
        {
//            array_push($dataList, $rowArray);
            $dataList[$rowArray[0]] = $rowArray;
        }
        mysqli_free_result($res);
        funcEnd(__METHOD__);
        return $dataList;
    }

    function insert($sql)
    {
        funcStart(__METHOD__);
        //$sql = $this->escapeString($sql);
        $res = mysqli_query($this->_dbConnection, $sql);
        if(!$res)
        {
            writeLog(LOG_LEVEL_ERROR, $sql, "FAIL_SQL");
        }
        funcEnd(__METHOD__);
        return $res;
    }

    private function _update($sql)
    {
        funcStart(__METHOD__);
        $res = mysqli_query($this->_dbConnection, $sql);
        if(!$res)
        {
            writeLog(LOG_LEVEL_ERROR, $sql, "UPDATE_FAIL_SQL");
        }
        funcEnd(__METHOD__);
        return $res;
    }

    function DB_update1()
    {
        $_sql = "update {$this->_tableName} set";
        $i = 0;
        foreach($this->data as $key=>$value)
        {
            if($key != $this->_fieldList[0])
            {
                if(!isset($value))
                {
                    continue;
                }
                if(is_array($value))
                {
                    $value = '"'.$this->escapeString(json_encode($value)).'"';
                }
                else if(!is_numeric($value) && $value != "NULL")
                {
                    $value = '"'.$this->escapeString($value).'"';
                }

                if(empty($this->_fieldList[$key]))//表中没有该字段
                {
                    continue;
                }

                if($i == 0)
                {
                    $_sql .= " `$this->_fieldList[$key]` = $value";
                    $i++;
                }
                else
                {
                    $_sql .= ", `$this->_fieldList[$key]` = $value";
                }
            }
        }
        $_sql .= " where ".$this->_pk." = ".$this->data[0];
        printError($_sql);
        $_res = $this->_update($_sql);

        if($_res)
        {
            MemInfoLogic::Instance()->setMemData($this->_tableEnum, $this->data(), $this->data[0]);
        }
        return $_res;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/16
     * Time: 15:54
     * Des: 拼接插入语句的列名
     */
    private function _getInsertFieldStr(&$data)
    {
        $_data = $data;
        $_count = 0;
        $_fieldCount = count($_data) - 1;

        $_sql = null;
        foreach ($_data as $key => $value)
        {
            if(empty($this->_fieldList[$key]))
            {
                if($_count == $_fieldCount)
                {
                    $_sql = substr($_sql,0,strlen($_sql)-1);
                    $_sql .= ") values(";
                }

                $_count ++;
                unset($_data[$key]);
                continue;
            }
            if($_count == $_fieldCount)
            {
                $_sql .= $this->_fieldList[$key] . ") values(";
            }
            else
            {
                $_sql .= $this->_fieldList[$key] . ",";
            }
            $_count ++;
        }

        return $_sql;
    }

    function DB_single_insert1($data)
    {
        funcStart(__METHOD__);
        if(empty($data))
            return false;

        $_data = $data;

        $_sql = "insert into {$this->_tableName}(";
        $_sql.= $this->_getInsertFieldStr($_data);

        $_fieldCount = count($_data) - 1;
        $_count = 0;
        foreach ($_data as $key => $value)
        {
            $_value = $value;
            if(is_array($_value))
            {
                $_value = '"'.$this->escapeString(json_encode($_value)).'"';
            }
            else if(!is_numeric($_value) or is_string($_value))
            {
                $_value = '"'.$this->escapeString($_value).'"';
            }

            if($_count == $_fieldCount)
            {
                $_sql .= $_value . ");";
            }
            else
            {
                $_sql .= $_value . ",";
            }
            $_count ++;
        }
        funcEnd(__METHOD__);

        $_res = $this->insert($_sql);
        if($_res)
        {
            MemInfoLogic::Instance()->setMemData($this->_tableEnum, $data, $data[0]);//默认第一个字段为主键
            $this->_setPrimaryByPrimary($data[0], $data);
        }
        return $_res;
    }

    function DB_multi_insert1($data)
    {
        funcStart(__METHOD__);
        if(!is_array($data))
            return false;

        $_data = $data[0];
        $_fieldCount = count($_data[0]) - 1;

        $_sql = "insert into {$this->_tableName}(";
        $_sql.= $this->_getInsertFieldStr($_data);

        $_indexCount = count($data) - 1;
        $_index = 0;
        foreach($data as $key => $row)
        {
            if(!is_array($row))
            {
                continue;
            }
            $_count = 0;
            foreach ($row as $value)
            {
                $_value = $value;
                if(is_array($_value))
                {
                    $_value = '"'.$this->escapeString(json_encode($_value)).'"';
                }
                else if(!is_numeric($_value) or is_string($_value))
                {
                    $_value = '"'.$this->escapeString($_value).'"';
                }

                if($_count == $_fieldCount)
                {
                    if($_index == $_indexCount)
                    {
                        $_sql .= $_value . ");";
                    }
                    else
                        $_sql .= $_value . "),(";
                }
                else
                {
                    $_sql .= $_value . ",";
                }
                $_count ++;
            }

            $_index++;
        }

        funcEnd(__METHOD__);
        $_res = $this->insert($_sql);
        if($_res)
        {
            foreach($data as $value)
            {
                MemInfoLogic::Instance()->setMemData($this->_tableEnum, $data, $value[0]);//默认第一个字段为主键
                $this->_setPrimaryByPrimary($value[0], $value);
            }
        }
        return $_res;
    }


    ///////////////////////////////////////////
    //////////////数据库CRUD以上///////////////
    ///////////////////////////////////////////


    ///////////////////////////////////////////
    /////////////存取主键相关以下//////////////
    ///////////////////////////////////////////
    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/11
     * Time: 16:39
     * Des: $this->_fieldKeyList的结构说明：
     *  array(
     *      "字段拼接的key值例：userId_uId" => array(
     *          "字段具体的值拼接例：1_10" => array("主键的值");
     *      )
     * )
     * */


    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/15
     * Time: 15:35
     * Des: 注册查询的字段
     */
    function registerQueryField($queryFieldList)
    {
        if(is_array($queryFieldList))
        {
            foreach($queryFieldList as $key => $queryField)
            {
                $this->_queryFieldList[$key] = $queryField;
            }
        }
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/15
     * Time: 15:35
     * Des: 根据查询类型取得具体数据
     */
    function startQuery($queryType, $fieldValueList)
    {
        if(empty($this->_queryFieldList[$queryType]) || empty($this->_tableName))
        {
            return null;
        }

        $_fieldList = $this->_queryFieldList[$queryType];
        $_fieldKey = $this->_tableName.connectKey($_fieldList);
        $_primaryKey = connectKey($fieldValueList);
        $_primaryValueList = $this->_getPrimaryListFromMem($_fieldKey, $_primaryKey);

        if(empty($_primaryValueList))
        {
            $_primaryValueList = $this->_getPrimaryListFromDB($queryType, $fieldValueList);
        }

        if(!empty($_primaryValueList))
        {
            $this->_setPrimaryList($_primaryValueList, $queryType, $_primaryKey);
        }
        return $_primaryValueList;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/11
     * Time: 12:04
     * Des: 根据字段key和主键key，取得主键value集合
     */
    private function _getPrimaryValueList($fieldKey, $primaryKey)
    {
        if(empty($this->_fieldKeyList[$fieldKey]))
        {
            return null;
        }
        $_primaryKeyList = $this->_fieldKeyList[$fieldKey];
        if(empty($_primaryKeyList[$primaryKey]))
        {
            return null;
        }

        $_fieldValueList = MemInfoLogic::Instance()->getMemData($_primaryKeyList[0], $_primaryKeyList[1]);
        return $_fieldValueList[$primaryKey];
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/11
     * Time: 16:32
     * Des: 存入字段key所对应的值
     *  $primaryKey为null时，存入整体的值
     *  $primaryKey不为null时，存入对应的主键列表
     */
    private function _setPrimaryList($value, $queryType, $primaryKey)
    {
        if(empty($this->_tableName) || empty($this->_tableEnum))
        {
            return false;
        }

        if(empty($this->_fieldKeyList))
        {
            $this->_fieldKeyList = MemInfoLogic::Instance()->getMemData($this->_tableEnum);
            if(empty($this->_fieldKeyList))
            {
                return false;
            }
        }

        $_queryField = null;
        if(empty($queryType))
        {
            return false;
        }
        else
        {
            if(empty($this->_queryFieldList[$queryType]))
            {
                return false;
            }
            $_queryField = $this->_queryFieldList[$queryType];
        }

        $_fieldKey = $this->_tableName.connectKey($_queryField);
//        if(!isset($primaryKey))
//        {
//            $this->_fieldKeyList[$_fieldKey] = $value;
//        }
//        else
        {
            $_primaryKeyList = $this->_fieldKeyList[$_fieldKey];
            $_primaryValueList = array();
            if(!empty($_primaryKeyList))
            {
                $_primaryValueList = MemInfoLogic::Instance()->getMemData($_primaryKeyList[0], $_primaryKeyList[1]);
            }

            $_primaryValueList[$primaryKey] = $value;
            if(MemInfoLogic::Instance()->setMemData($this->_tableEnum, $_primaryValueList, $_fieldKey))
            {
                $this->_fieldKeyList[$_fieldKey] = array($this->_tableEnum, $_fieldKey);
            }
        }
        return MemInfoLogic::Instance()->setMemData($this->_tableEnum, $this->_fieldKeyList);
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/17
     * Time: 21:19
     * Des: 根据主键值更新主键列表
     */
    private function _setPrimaryByPrimary($primary, $data)
    {
        if(empty($this->_tableName) || empty($this->_tableEnum))
        {
            return false;
        }

        if(empty($this->_fieldKeyList))
        {
            $this->_fieldKeyList = MemInfoLogic::Instance()->getMemData($this->_tableEnum);
            if(empty($this->_fieldKeyList))
            {
                return false;
            }
        }

        foreach($this->_queryFieldList as $_queryField)
        {
            $_fieldKey = $this->_tableName.connectKey($_queryField);
            $_primaryKeyList = $this->_fieldKeyList[$_fieldKey];

            //取得字段具体的值
            $_fieldValueList = array();
            foreach($_queryField as $queryIndex => $queryField)
            {
                foreach($this->_fieldList as $index => $field)
                {
                    if($field == $queryField)
                    {
                        if(isset($data[$index]))
                        {
                            $_fieldValueList[] = $data[$index];
                        }
                        break;
                    }
                }
            }

            $_primaryValueList = array();
            if(!empty($_primaryKeyList))
            {
                $_primaryValueList = MemInfoLogic::Instance()->getMemData($_primaryKeyList[0], $_primaryKeyList[1]);
            }

            $_primaryKey = connectKey($_fieldValueList);
            $_primaryValueList[$_primaryKey][$primary] = $primary;
            if(MemInfoLogic::Instance()->setMemData($this->_tableEnum, $_primaryValueList, $_fieldKey))
            {
                $this->_fieldKeyList[$_fieldKey] = array($this->_tableEnum, $_fieldKey);
            }

            MemInfoLogic::Instance()->setMemData($this->_tableEnum, $this->_fieldKeyList);
        }
        return true;
    }

    private function _getPrimaryListFromMem($fieldKey, $primaryKey)
    {
        $_primaryList = $this->_getPrimaryValueList($fieldKey, $primaryKey);
        return $_primaryList;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/22
     * Time: 14:10
     * Des: 取得的主键格式
     *  array(
     *      [primary] = array(primary)
     * );
     * 改格式是为了和model加载的数据格式一致
     */
    private function _getPrimaryListFromDB($queryType, $fieldValueList)
    {
        if(empty($this->_queryFieldList[$queryType])  || !is_array($fieldValueList) )
        {
            return null;
        }

        $_pk = $this->_pk;
        $_tableName = $this->_tableName;
        if(empty($_pk)  || empty($_tableName) )
        {
            return null;
        }

        $_sql = "select `$_pk` from `$_tableName` where ";

        $_fieldList = $this->_queryFieldList[$queryType];
        if(is_array($_fieldList))
        {
            $_fieldCount = count($_fieldList) - 1;
            foreach($_fieldList as $key => $field)
            {
                if(is_array($field))
                {
                    return null;
                }
                $_sql .= "`".($field)."` = ";
                $_sql .= '"'.($fieldValueList[$key]).'"';
                if($_fieldCount != $key)
                {
                    $_sql .= " and ";
                }
            }
        }
        else
        {
            $_sql .= " `$_fieldList` = $fieldValueList[0]";
        }

        $_sql .= ";";
        $_data = $this->_foreachSelectDb($_sql);
        return $_data;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/15
     * Time: 16:01
     * Des: 遍历所有配置中的选中数据库，查询主键
     */
    private function _foreachSelectDb($sql)
    {
        $_totalData = array();

        global $DBConfig;
        foreach($DBConfig as $dbKey => $config)
        {
            $mysql = new MysqlDB();
            if (!$mysql)
                return $_totalData;

            if (!$mysql->initDB($config, false))
                return $_totalData;

            $_data = $mysql->select($sql);
            if(!empty($_data))
            {
                array_merge($_data, $_totalData);
            }
        }
        return $_totalData;
    }

    ///////////////////////////////////////////
    /////////////存取主键相关以上//////////////
    ///////////////////////////////////////////
}

class Node
{
    private $_startTime;
    private $_count = 0;

    function setStartTime($time)
    {
        if(is_numeric($time))
        {
            $this->_startTime = $time;
        }
        else
        {
            $this->_startTime = time();
        }
    }

    function getStartTime()
    {
        if(empty($this->_startTime))
        {
            $this->_startTime = time();
        }
        return $this->_startTime;
    }

    function addCount()
    {
        if(empty($count))
        {
            $this->_count = 0;
        }

        $this->_count += 1;
    }

    function getCount()
    {
        if(empty($this->_count))
        {
            $this->_count = 0;
        }
        return $this->_count;
    }
}
class MemDB
{
    private static $_mem = array();
    private static $_index = 0;
    public function init($index=0)
    {
        self::$_index = $index;
        if(!empty(self::$_mem[$index]))
        {
           return true;
        }
        else
        {
            $_maxIndex = self::getMemcacheCount() - 1;
            if($index > $_maxIndex)
            {
                return false;
            }
//            if (self::$_mem != null)
//            {
//                return;
//            }
            global $MemConfig;
            self::$_mem[$index] = new Memcache();
            self::$_mem[$index]->pconnect($MemConfig[$index]['memHost'], $MemConfig[$index]['memPort']);
            if (self::$_mem[$index] == null)
            {
//                echo 'mem null again!<br>';
                return false;
            }
        }
        return true;
   }

    public function set($key, $value, $timeout = 3600)
    {
        return self::$_mem[self::$_index]->set($key, $value, 0, $timeout);
    }

    public function get($key)
    {
        return self::$_mem[self::$_index]->get($key);
    }

    public function clean($roleId)
    {
        return self::$_mem[self::$_index]->delete($roleId);
    }

    public function delete($key)
    {
        self::$_mem[self::$_index]->delete($key);
    }

    public function cleanAll()
    {
        self::$_mem[self::$_index]->flush();
    }

    public function getStats()
    {
        return self::$_mem[self::$_index]->getStats();
    }

    public function increment($key)
    {
        return self::$_mem[self::$_index]->increment($key);
    }

    public static function getMemcacheCount()
    {
        global $MemConfig;
        return count($MemConfig);
    }
}

//class MemConfigDB
//{
////    private static $_mem;
////    public function __construct()
////    {
////        if (self::$_mem != null)
////        {
////            return;
////        }
////        self::$_mem = new Memcache();
////        $_config = new MemXmlConfig();
////        self::$_mem->pconnect($_config->memHost, $_config->memPort);
////        if (self::$_mem == null)
////        {
////            echo 'mem null again!<br>';
////        }
////
////    }
////
////    public function set($key, $value, $timeout = 3600)
////    {
////        self::$_mem->set($key, $value, 0, $timeout);
////    }
////
////    public function get($key)
////    {
////        return self::$_mem->get($key);
////    }
////
////    public function clean($roleId)
////    {
////        self::$_mem->delete($roleId);
////    }
////
////    public function delete($key)
////    {
////        self::$_mem->delete($key);
////    }
////
////    public function cleanAll()
////    {
////        self::$_mem->flush();
////    }
//}
