<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/30
 * Time: 17:03
 */
class ColorDataConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_COLOR_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_COLORDATA);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_COLOR_DATA, $this->initArray);
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

    public function findColorDataConfig($key)
    {
        if(empty($this->initArray[$key]))
        {
            return null;
        }
        return $this->initArray[$key];
    }
}