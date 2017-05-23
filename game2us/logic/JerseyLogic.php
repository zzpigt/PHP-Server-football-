<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_MODEL_PATH."JerseyModel.php");
include_once(APP_PROTO_PATH."proto.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/3/30
 * Time: 15:44
 */
class JerseyLogic
{
    private $_jerseyModel;

    function isCreate($userId)
    {
        $JerseyModel = JerseyModelMgr::Instance()->getModelByPrimary($userId);
        if(!$JerseyModel)
            return false;
        $this->_jerseyModel = $JerseyModel;
        return true;
    }

    private function _getJerseyStrut($jersey = 10101)
    {
        $_data = array();
        //默认球服写死
        $_mainColor = 1;
        $_color = 2;

        $_data[DATA_BASE_JERSEY_USERID] = $this->_jerseyModel->getPrimaryValue();
        $_data[DATA_BASE_JERSEY_JERSEYID] = $jersey;
        $_data[DATA_BASE_JERSEY_MAINCOLOR] = $_mainColor;
        $_data[DATA_BASE_JERSEY_COLOR] = $_color;

        return $_data;
    }

    private function _initJersey()
    {
        $_jerseyArr = array();
        $_data = $this->_getJerseyStrut();
        JerseyModelMgr::Instance()->addSingleData($_data);
        array_push($_jerseyArr, $_data);

        $_data = $this->_getJerseyStrut(10102);
        JerseyModelMgr::Instance()->addSingleData($_data);
        array_push($_jerseyArr, $_data);

        return $_jerseyArr;
    }

    private function _checkColor($mainColor)
    {
        $_config = XmlConfigMgr::getInstance()->getColorDataConfig();
        if(empty($_config->findColorDataConfig($mainColor)))
        {
            return false;
        }
        return true;
    }

    function addJersey($signId = 10102)
    {
        if(empty($signId))
        {
            return false;
        }
        $_data = $this->_getJerseyStrut($signId);
        return JerseyModelMgr::Instance()->addSingleData($_data);
    }

    function updateJersey($userId, $index, $mainColor, $color)
    {
        if(empty($userId) || !isset($index))
        {
            return false;
        }
        if(!$this->_checkColor($mainColor) || !$this->_checkColor($color))
        {
            return false;
        }
        $this->_jerseyModel->setFieldByIndex(DATA_BASE_JERSEY_MAINCOLOR, $mainColor);
        $this->_jerseyModel->setFieldByIndex(DATA_BASE_JERSEY_COLOR, $color);
        return $this->_jerseyModel->DB_update1();
    }

    function getJerseyData()
    {
        $_data = $this->_jerseyModel->getJerseyData();
        if(empty($_data))
        {
            $_data = $this->_initJersey();
        }
        return $_data;
    }

    function getJerseyInfo($data)
    {
        $_backInfo = new SC_CLUBSHIRT_ACK();
        if(is_array($data))
        {
            foreach($data as $index => $shirtData)
            {
                $_data = new ShirtInfo();
                $_data->__Index = $index;
                $_data->__ShirtId = $shirtData[DATA_BASE_JERSEY_JERSEYID];
                foreach($shirtData as $key => $value)
                {
                    if($key == CLUB_JERSEY_USERID)
                    {
                        continue;
                    }

                    $_info = new SInfo();
                    $_info->__Type = $key;
                    $_info->__Value = $value;

                    array_push($_data->__ShirtData, $_info);
                }

                array_push($_backInfo->__ShirtInfos, $_data);
            }
        }
        return $_backInfo;
    }

    function checkJerseyIsSelf($jerseyId)
    {
        $_jerseyData = $this->_jerseyModel->getJerseyData();
        if(is_array($_jerseyData))
        {
            foreach($_jerseyData as $jersey)
            {
                if($jersey[DATA_BASE_JERSEY_JERSEYID] == $jerseyId)
                {
                    return true;
                }
            }
        }
        return false;
    }
}