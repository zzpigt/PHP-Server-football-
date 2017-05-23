<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_MODEL_PATH."TeamSignModel.php");
include_once(APP_PROTO_PATH."proto.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/3/30
 * Time: 14:50
 */
class TeamSignLogic
{
    private $_teamSignModel;

    function isCreate($userId)
    {
        $teamSignModel = TeamSignModelMgr::Instance()->getModelByPrimary($userId);
        if(!$teamSignModel)
            return false;
        $this->_teamSignModel = $teamSignModel;
        return true;
    }

    private function _getTeamSignStrut($signId = 20201)
    {
        $_data = array();
        //默认队徽写死
        $_signType = 20301;
        $_mainColor = 1;
        $_color = 2;

        $_data[DATA_BASE_TEAMSIGN_USERID] = $this->_teamSignModel->getPrimaryValue();
        $_data[DATA_BASE_TEAMSIGN_SIGNID] = $signId;
        $_data[DATA_BASE_TEAMSIGN_SIGNTYPE] = $_signType;
        $_data[DATA_BASE_TEAMSIGN_MAINCOLOR] = $_mainColor;
        $_data[DATA_BASE_TEAMSIGN_COLOR] = $_color;
        $_data[DATA_BASE_TEAMSIGN_SIGNPATTERN] = 20401;
        $_data[DATA_BASE_TEAMSIGN_PATTERNCOLOR] = 20501;

        return $_data;
    }

    private function initTeamSign()
    {
        $_data = $this->_getTeamSignStrut();
        TeamSignModelMgr::Instance()->addSingleData($_data);
        return $_data;
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

    private function _checkId($id)
    {
        $_config = XmlConfigMgr::getInstance()->getShirtSetConfig();
        $_teamSingData = $_config->findShirtSetConfig($id);
        if(empty($_teamSingData))
        {
            return false;
        }

        return true;
    }

    private function _checkData($field, $value)
    {
        if($field == DATA_BASE_TEAMSIGN_MAINCOLOR || $field == DATA_BASE_TEAMSIGN_COLOR)
        {
            return $this->_checkColor($value);
        }

        return $this->_checkId($value);
    }

    function addTeamSign($signId = 20201)
    {
        if(empty($signId))
        {
            return false;
        }

        $_data = $this->_getTeamSignStrut($signId);
        return TeamSignModelMgr::Instance()->addSingleData($_data);
    }

    function updateTeamSign($data, $index)
    {
        if(is_array($data))
        {
            if(empty($data[DATA_BASE_TEAMSIGN_COLOR]) || empty($data[DATA_BASE_TEAMSIGN_MAINCOLOR]))
            {
                return false;
            }
            if($data[DATA_BASE_TEAMSIGN_COLOR] == $data[DATA_BASE_TEAMSIGN_MAINCOLOR])
            {
                return false;
            }
            foreach($data as $sInfo)
            {
                if($this->_checkData($sInfo->__Type, $sInfo->__Value))
                {
                    $this->_teamSignModel->setFieldByIndex($sInfo->__Type, $sInfo->__Value);
                }
            }

            return $this->_teamSignModel->DB_update1();
        }
        return false;
    }

    function getTeamSignData()
    {
        $_data = $this->_teamSignModel->getTeamSignData();
        if(empty($_data))
        {
            $_data[0] = $this->initTeamSign();
        }
        return $_data;
    }

    function getTeamSignInfo($data)
    {
        $_backInfo = new SC_CLUBTEAMSIGN_ACK();
        if(is_array($data))
        {
            foreach($data as $index => $teamSingData)
            {
                $_data = new TeamSignInfo();
                $_data->__Index = $index;
                $_data->__TeamSignId = $teamSingData[DATA_BASE_TEAMSIGN_SIGNID];
                foreach($teamSingData as $key => $value)
                {
                    if($key == CLUB_TEAM_SIGN_USERID)
                    {
                        continue;
                    }

                    $_info = new SInfo();
                    $_info->__Type = $key;
                    $_info->__Value = $value;

                    array_push($_data->__TeamSignData, $_info);
                }

                array_push($_backInfo->__TeamSigns, $_data);
            }
        }

        return $_backInfo;
    }

    function checkTeamSignIsSelf($teamSignId)
    {
        $_teamSignData = $this->_teamSignModel->getTeamSignData();
        if(is_array($_teamSignData))
        {
            foreach($_teamSignData as $teamSign)
            {
                if($teamSign[DATA_BASE_TEAMSIGN_SIGNID] == $teamSignId)
                {
                    return true;
                }
            }
        }

        return false;
    }
}