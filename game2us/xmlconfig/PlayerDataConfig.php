<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/6
 * Time: 13:22
 */
class PlayerDataConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_PLAYER_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_PLAYERDATA);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_PLAYER_DATA, $this->initArray);
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

    public function findPlayerDataConfig($key)
    {
        return $this->initArray[$key];
    }
}