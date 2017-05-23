<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/10
 * Time: 20:11
 */
class MemInfoModel extends MysqlDB
{
    private $_userId;
    function init($userId)
    {
        if (empty($userId)) {
            printError("MemInfoModel userId is " . $userId);
            return false;
        }

        if(!parent::initDB($userId))
            return false;

        $this->_userId = $userId;
        $this->data($this->getDataFromDB(DATA_BASE_MEMINFO, "memkey", 'userId'.$userId));
        return true;
    }

    function userId()
    {
        return $this->_userId;
    }

    public function saveMemInfoData($value, $index = 0)
    {
        $_data = $this->data();
        if(empty($value) || empty($_data[$index]))
            return false;

        $_fieldList=eval(DATA_BASE_MEMINFO_FIELD);

        if($this->DB_update(DATA_BASE_MEMINFO, $_fieldList, $_data[$index], $value))
        {
            return true;
        }
        return false;
    }

    function insertMemInfoData($data)
    {
        if(empty($data))
            return false;

        $_fieldList=eval(DATA_BASE_MEMINFO_FIELD);
        if($this->DB_single_insert(DATA_BASE_MEMINFO, $_fieldList, $data))
        {
            $_data = $this->data();
            $_data = $this->addModelData($_data, $data);
            $this->data($_data);
            return true;
        }
        return false;
    }


}