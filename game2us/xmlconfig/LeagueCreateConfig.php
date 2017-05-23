<?php

/**
 * @date: 2017年4月21日 下午3:30:47
 * @author: meishuijing
 * @desc: 联赛创建
 */
class LeagueCreateConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_LEAGUECREATE_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_LEAGUECREATE);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_LEAGUECREATE_DATA, $this->initArray);
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
    
    public function findConfig($level)
    {
    	if(isset($this->initArray[$level]))
    	{
    		return $this->initArray[$level];
    	}
    	return null;
    }
}