<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/30
 * Time: 16:59
 */
class ShirtSetConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_SHIRTSET_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_SHIRTSET);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_SHIRTSET_DATA, $this->initArray);
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

    public function findShirtSetConfig($key)
    {
        if(empty($this->initArray[$key]))
        {
            return null;
        }
        return $this->initArray[$key];
    }
}