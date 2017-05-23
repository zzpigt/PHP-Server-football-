<?php
include_once(getcwd()."/MyConstant.php");
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/13
 * Time: 10:28
 */
class FieldPositionConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_FIELDPOSITION_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_FIELDPOSITION);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_FIELDPOSITION_DATA, $this->initArray);
        }
        else
        {
            $this->initArray = $bInit;
        }
    }

    public function getArray()
    {
        return $this->initArray;
    }

    public function findFieldPositionConfig($field)
    {
        if(empty($this->initArray[$field]))
        {
            return null;
        }
        return $this->initArray[$field];
    }
}