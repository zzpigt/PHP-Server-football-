<?php

/**
 * @date: 2017年4月21日 下午3:30:47
 * @author: meishuijing
 * @desc: 阵型创建
 */
class FormationCreateConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_FORMATIONCREATE_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_FORMATIONCREATE);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_FORMATIONCREATE_DATA, $this->initArray);
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