<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/22
 * Time: 17:20
 */
class ConstDataConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_CONST_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_CONSTDATA);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_CONST_DATA, $this->initArray);
        }
        else
        {
            $this->initArray = $bInit;
        }
    }

    public function findConstDataConfig($id)
    {
        if(!empty($this->initArray[$id]))
        {
            return $this->initArray[$id];
        }
        return null;
    }
}