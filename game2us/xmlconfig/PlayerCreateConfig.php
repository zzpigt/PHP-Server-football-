<?php

/**
 * @date: 2017年4月21日 下午3:30:47
 * @author: meishuijing
 * @desc: AI机器人创建
 */
class PlayerCreateConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_PLAYERCREATE_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_PLAYERCREATE);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_PLAYERCREATE_DATA, $this->initArray);
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
}