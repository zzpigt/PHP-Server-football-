<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/27
 * Time: 21:24
 */
class FieldDistanceConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_FIELDDISTANCE_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_FIELDDISTANCE);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_FIELDDISTANCE_DATA, $this->initArray);
        }
        else
        {
            $this->initArray = $bInit;
        }
    }

    public function findFieldDistanceConfig($id)
    {
        if(!empty($this->initArray[$id]))
        {
            return $this->initArray[$id];
        }
        return null;
    }

    public function getFormatFieldDistance()
    {
        $bInit = MemInfoLogic::Instance()->getMemData('CONFIG_FIELDDISTANCE_DIR');
        if(!$bInit)
        {
            $_arr = $this->initArray;
            $_count = count($_arr);
            $_distanceDir = array();
            for($i = 1; $i <= $_count; $i++)
            {
                $_distance = $_arr[$i]['Distance'];
                $_sPosition = $_arr[$i]['SupportPosition'];
                $_position = $_arr[$i]['Position'];

                if(empty($_distanceDir[$_position]))
                {
                    $_distanceDir[$_position] = array();
                }

                if(empty($_distanceDir[$_position][$_distance]))
                {
                    $_distanceDir[$_position][$_distance] = array();
                }

                array_push($_distanceDir[$_position][$_distance], $_sPosition);
            }

            MemInfoLogic::Instance()->setMemData('CONFIG_FIELDDISTANCE_DIR', $_distanceDir);
            return $_distanceDir;
        }
        else
        {
            return $bInit;
        }
    }
}