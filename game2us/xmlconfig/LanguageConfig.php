<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/6
 * Time: 13:22
 */
class LanguageConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_LANGUAGE_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_LANGUAGE);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_LANGUAGE_DATA, $this->initArray);
        }
        else
        {
            $this->initArray = $bInit;
        }
    }

    public function getConfig()
    {
    	if(empty($this->initArray))
    		return null;
        return $this->initArray;
    }

    public function findConfig($key)
    {
    	if(!isset($this->initArray[$key]))
    		return null;
        return $this->initArray[$key];
    }
}