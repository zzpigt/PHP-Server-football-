<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_MODEL_PATH."TacticsModel.php");
include_once(APP_PROTO_PATH."proto.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/3/14
 * Time: 10:43
 */
class TacticsLogic
{

    private function _getTacticsStrut($userId)
    {
        $_tacticsArr = array();
        $_tacticsArr[USER_DATA_FIRST_USERID] = $userId;
        $_tacticsArr[TACTICS_TYPE_TEAMMEMTALITY] = 100001;
        $_tacticsArr[TACTICS_TYPE_PASSDIRECTION] = 100006;
        $_tacticsArr[TACTICS_TYPE_ATTACKDIRECTION] = 100011;
        $_tacticsArr[TACTICS_TYPE_DEFENSE] = 100014;
        $_tacticsArr[TACTICS_TYPE_COMPRESSION] = 100016;
        $_tacticsArr[TACTICS_TYPE_TACKLE] = 100018;
        $_tacticsArr[TACTICS_TYPE_OFFSIDE] = 100021;
        $_tacticsArr[TACTICS_TYPE_MARKING] = 100023;

        return $_tacticsArr;
    }

    function initTactics($userId)
    {
        $_data = $this->_getTacticsStrut($userId);
//        $this->_tacticsModel->insertTacticsData($_data);
        TacticsModelMgr::Instance()->addSingleData($_data);
        return $_data;
    }

    function getTacticsInfo($data)
    {
        $_backInfo = new SC_TACTICSGET_ACK();
        foreach($data as $key=>$value)
        {
            if($key == USER_DATA_FIRST_USERID)
            {
                continue;
            }
            $_sInfo = new SInfo();
            $_sInfo->__Type = $key;
            $_sInfo->__Value = $value;

            array_push($_backInfo->__TacticsInfo, $_sInfo);
        }

        return $_backInfo;
    }

    function formatTactics($value)
    {
        if(empty($value) || empty($value->__TacticsClass) || empty($value->__TacticsId))
        {
            return null;
        }

        $_data = array();
        $_data[$value->__TacticsClass] = $value->__TacticsId;

        return $_data;
    }

    function updateTacticsInfo($value,$userId)
    {
        if(empty($value) || empty($value->__TacticsClass) || empty($value->__TacticsId))
        {
            return null;
        }

        if(!$tacticsModel = TacticsModelMgr::Instance()->getModelList(TACTICS_MODEL_DEFAULT,array($userId))){
            return false;
        }
        $tacticsModel->setFieldByIndex($value->__TacticsClass, $value->__TacticsId);
        return $tacticsModel->DB_update1();
    }

    function getTacticsData($userId)
    {
        if(!$tacticsModel = TacticsModelMgr::Instance()->getModelList(TACTICS_MODEL_DEFAULT,array($userId))){
            return false;
        }
        if(empty($tacticsModel->data()[0]))
        {
            return null;
        }
        return $tacticsModel->data()[0];
    }
}