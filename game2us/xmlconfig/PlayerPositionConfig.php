<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/28
 * Time: 17:13
 */
class PlayerPositionConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_PLAYERPOSITION_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_PLAYERPOSITION);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_PLAYERPOSITION_DATA, $this->initArray);
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

    public function findPlayerPositionConfig($key)
    {
        if(empty($this->initArray[$key]))
        {
            return null;
        }
        return $this->initArray[$key];
    }
}