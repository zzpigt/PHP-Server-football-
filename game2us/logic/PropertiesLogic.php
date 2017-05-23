<?php
include_once (APP_MODEL_PATH."PropertiesModel.php");
include_once(APP_PROTO_PATH."proto.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/2/4
 * Time: 11:28
 */
class PropertiesLogic
{
    private function _getPropertiesStrut($userId, $nick)
    {
        $_propertyList = array();
        $_propertyList[DATA_BASE_PROPERTIES_UID] = $userId;
        $_propertyList[DATA_BASE_PROPERTIES_NICK] = "{$nick}";
        $_propertyList[DATA_BASE_PROPERTIES_MONEY] = 10000000;
        $_propertyList[DATA_BASE_PROPERTIES_DIAMOND] = 10000000;
        $_propertyList[DATA_BASE_PROPERTIES_POWERBAG] = 10000000;
        $_propertyList[DATA_BASE_PROPERTIES_MEDICALBAG] = 10000000;
        $_propertyList[DATA_BASE_PROPERTIES_MORALEBAG] = 10000000;
        $_propertyList[DATA_BASE_PROPERTIES_SKILLBAG] =  10000000;
        $_propertyList[DATA_BASE_PROPERTIES_PVPROOMID] = 0;
        $_propertyList[DATA_BASE_PROPERTIES_RECOMMENDENDTIME] = 0;
        $_propertyList[DATA_BASE_PROPERTIES_RECOMMENDSTARTTIME] = 0;
        $_propertyList[DATA_BASE_PROPERTIES_RECOMMENDLASTTIME] = 0;

        return $_propertyList;
    }

    private function _getUserProfileStrut($userId, $nick)
    {
        $_userProfileList = array();

        $_userProfileList[DATA_BASE_PROPERTIES_UID] = $userId;
        $_userProfileList[DATA_BASE_PROPERTIES_NICK] = "{$nick}";

        return $_userProfileList;
    }

    function nameLengthIsError($nick)
    {
        if(strlen($nick) > 15 || strlen($nick) == 0)
        {
            return true;
        }
        return false;
    }

    function createProperties($userId, $nick)
    {
        $_newProperties = $this->_getPropertiesStrut($userId, $nick);
        if(!PropertiesModelMgr::Instance()->addSingleData($_newProperties))
        {
            return false;
        }

        //缺少profileModel
//        $_userId = Registry::getInstance()->get(CLIENT_ID);
//        if(!$this->_propertiesModel->insertUserProfile($this->_getUserProfileStrut($_userId, $nick)))
//        {
//            return false;
//        }

        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_clubModel = ClubModelMgr::Instance()->getModelByPrimary($_userId);
        if(empty($_clubModel))
        {
            return false;
        }

        $_clubModel->setFieldByIndex(DATA_BASE_CLUB_NAME, $nick);
        if(!$_clubModel->saveClubData($_userId))
        {
            return false;
        }

        return true;
    }

//    function currencyOperation($key, $value)
//    {
//        $_data = $this->_propertiesModel->getPropertiesData();
//        $_data[0][$key] +=  $value;
//        if($key == DATA_BASE_PROPERTIES_MONEY)
//        {
//            $_data[0][$key] = $this->_propertiesModel->getParamNum($_data[0][$key], -100000000, 99999999999);
//        }
//        elseif($key == DATA_BASE_PROPERTIES_DIAMOND)
//        {
//            $_data[0][$key] = $this->_propertiesModel->getParamNum($_data[0][$key], 0, 999999999);
//        }
//        else
//        {
//            $_data[0][$key] = $this->_propertiesModel->getParamNum($_data[0][$key], 0, 10000000);
//        }
//        $this->updateProperties();
//    }

    function getPlayerProperties($_userId)
    {
        $_property = new SC_Property_ACK();
        $_model = PropertiesModelMgr::Instance()->getModelByPrimary($_userId);
        if(empty($_model))
        {
            return $_property;
        }

        $_property->__Uid = $_model->getFieldByIndex(DATA_BASE_PROPERTIES_UID);
        $_property->__Name = $_model->getFieldByIndex(DATA_BASE_PROPERTIES_NICK);
        for($field = DATA_BASE_PROPERTIES_NICK; $field <= DATA_BASE_PROPERTIES_SKILLBAG; $field ++)
        {
            $_sInfo = new SInfo();
            $_sInfo->__Type = $field + 5000000 - 1;
            $_sInfo->__Value = $_model->getFieldByIndex($field);
            array_push($_property->__InfoArr, $_sInfo);
        }

        return $_property;
    }

    function roomTagHandle($userId)
    {
        $_model = PropertiesModelMgr::Instance()->getModelByPrimary($userId);
        if(empty($_model))
        {
            return null;
        }

        $_roomTag = $_model->getFieldByIndex(DATA_BASE_PROPERTIES_PVPROOMID);
        if(empty($_roomTag))
        {
            return null;
        }

        return explode('|', $_roomTag);
    }

    function selfIsFight($userId)
    {
        $_model = PropertiesModelMgr::Instance()->getModelByPrimary($userId);
        if(empty($userId))
        {
            return false;
        }

        if(!empty($_model->getFieldByIndex(DATA_BASE_PROPERTIES_PVPROOMID)))
        {
            return true;
        }

        return false;
    }

    function getPlayerDataByField($userId, $field)
    {
        $_model = PropertiesModelMgr::Instance()->getModelByPrimary($userId);
        if(empty($_model))
        {
            return null;
        }

        return $_model->getFieldByIndex($field);
    }

    function isRecommend($userID)
    {
        $_model = PropertiesModelMgr::Instance()->getModelByPrimary($userID);
        if(empty($_model))
        {
            return false;
        }

        $_loginTime = time();
        $_recommendStartTime = $_model->getFieldByIndex(DATA_BASE_PROPERTIES_RECOMMENDSTARTTIME);
        if(empty($_recommendStartTime))
        {
            $_recommendStartTime = $_loginTime;
            $_model->setFieldByIndex(DATA_BASE_PROPERTIES_RECOMMENDSTARTTIME, $_loginTime);
            $_model->setFieldByIndex(DATA_BASE_PROPERTIES_RECOMMENDENDTIME, $_recommendStartTime + 25 * 60 *60);
            if(!$_model->DB_update1())
            {
                return false;
            }
        }

        if($_model->getFieldByIndex(DATA_BASE_PROPERTIES_RECOMMENDENDTIME) > $_loginTime)
        {
            return true;
        }
        else
        {
            $_playDays = getTimeStamp($_recommendStartTime, $_loginTime);
            $_probability = 0;
            if($_playDays > 5 && $_playDays < 8)
            {
                $_probability = 50;
            }
            elseif($_playDays >= 8)
            {
                $_probability = 100;
            }
            if(rand(1, 100) <= $_probability)
            {
                $_model->setFieldByIndex(DATA_BASE_PROPERTIES_RECOMMENDSTARTTIME, $_loginTime);
                $_model->setFieldByIndex(DATA_BASE_PROPERTIES_RECOMMENDENDTIME, $_recommendStartTime + 25 * 60 *60);
                if($_model->DB_update1())
                {
                    return true;
                }
            }
        }
        return false;
    }
}