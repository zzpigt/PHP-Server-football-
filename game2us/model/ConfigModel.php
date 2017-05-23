<?php
include_once(APP_BASE_PATH."Config.php");
include_once(APP_BASE_PATH."DataBaseField.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/6
 * Time: 15:41
 */
class ConfigModel extends MysqlDB
{
    function init()
    {
        global $DBConfig;
        $_dbKey = null;
        //取得第一个数据库的key
        foreach($DBConfig as $key => $value)
        {
            $_dbKey = $key;
            break;
        }
        
        $_dbKey = $_dbKey."|";
        if(!parent::initDB($_dbKey))
            return false;

        $this->data($this->getModelData(DATA_BASE_CONFIG, "id", 0));//配置表只有一条数据
        return true;
    }

    function updateConfig()
    {
        $_data = $this->data();

        $_fieldList=eval(DATA_BASE_CONFIG_FIELD);
        if($this->DB_update(DATA_BASE_CONFIG, $_fieldList, $_data, 0))
        {
//            $this->setMemData(DATA_BASE_CONFIG, 0, $_data);
//             if(!MemInfoLogic::Instance()->setMemData(DATA_BASE_CONFIG, $_data, 0))
//             {
//                 MemInfoLogic::Instance()->setMemData(DATA_BASE_CONFIG, null, 0);
//             }
            return true;
        }
        return false;
    }

}