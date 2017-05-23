<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_MODEL_PATH."PlayerModel.php");
include_once(APP_PROTO_PATH."proto.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/5
 * Time: 17:03
 */
class PlayerLogic
{
    private $_playerModel;
    function init($userId)
    {
        $this->_playerModel = new PlayerModel();
        if(empty($this->_playerModel) || !$this->_playerModel->init($userId))
        {
            return false;
        }
        return true;
    }
    
    function isCreate()
    {
    	return !empty($this->_playerModel->data());
    }

    private function _getPlayerStrut($userName, $userPwd, $mac, $leagueId, $isRobot = false)
    {
        $_data = array();

        $_data[DATA_BASE_PLAYER_USERID] = $this->_playerModel->userId();
        $_data[DATA_BASE_PLAYER_USERNAME] = $userName;
        $_data[DATA_BASE_PLAYER_USERPWD] = $userPwd;
        $_data[DATA_BASE_PLAYER_REGDATE] = time();
        $_data[DATA_BASE_PLAYER_MACADDRESS] = $mac;
        $_data[DATA_BASE_PLAYER_LEAGUERID] = $leagueId;
        $_data[DATA_BASE_PLAYER_ISROBOT] = ($isRobot ? 1 : 2);
        return $_data;
    }

    function addPlayer($userName, $userPwd, $mac, $leagueId, $isRobot = false)
    {
        $_player = $this->_getPlayerStrut($userName, $userPwd, $mac, $leagueId, $isRobot);
        return $this->_playerModel->insertPlayerData($_player);
    }
    
    function setFieldByIndex($field, $value)
    {
    	$this->_playerModel->setFieldByIndex($field, $value);
    }

    function getPlayerData()
    {
        return $this->_playerModel->data();
    }
    
    function getModel()
    {
    	return $this->_playerModel;
    }
}