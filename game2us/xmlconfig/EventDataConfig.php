<?php
include_once(getcwd()."/MyConstant.php");
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 20:28
 */
class EventDataConfig
{
    private $initArray = array();
    public function init()
    {
        $bInit = MemInfoLogic::Instance()->getMemData(CONFIG_EVENT_DATA);
        if(!$bInit)
        {
            $content = file_get_contents(CONFIG_EVENTDATA);
            $this->initArray = my_xml_decode($content);
            MemInfoLogic::Instance()->setMemData(CONFIG_EVENT_DATA, $this->initArray);
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

    public function findEventDataConfig($field)
    {
        return $this->initArray[$field];
    }

    public function findEventTypeByClassId($classId, $trigger)
    {
        $_eventTypeArr = array();
        foreach($this->initArray as $value)
        {
            if($value['ClassID'] == $classId && $value['Trigger'] == $trigger)
            {
                $_eventTypeArr[$value['EventOrder']] = $value['EventType'];
            }
        }

        return $_eventTypeArr;
    }
}