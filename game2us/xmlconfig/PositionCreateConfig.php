<?php

/**
 * @date: 2017年4月21日 下午3:30:47
 * @author: meishuijing
 * @desc: 球员位置创建
 */
class PositionCreateConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_POSITIONCREATE_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_POSITIONCREATE);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_POSITIONCREATE_DATA, $this->initArray);
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
        if(isset($this->initArray[$key]))
        {
            return $this->initArray[$key];
        }
        return null;
    }
}