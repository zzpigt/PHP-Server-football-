<?php

/**
 * @date: 2017年4月21日 下午3:30:47
 * @author: meishuijing
 * @desc: 球员名字配置表
 */
class NameConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_NAME_DATA);//这个数据都是从data/server/里xml存的数据
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_NAME);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_NAME_DATA, $this->initArray);
        }
        else
        {
            $this->initArray = $bInit;
        }
    }

    public function getConfig()
    {
        if(!empty($this->initArray))
        {
            return $this->initArray;
        }
        return null;
    }
    
    public function findConfig($key)
    {
    	if(!isset($this->initArray[$key]))
    		return null;
    	return $this->initArray[$key];
    }
}