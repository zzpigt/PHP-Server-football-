<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_MODEL_PATH."ClubModel.php");
include_once(APP_PROTO_PATH."proto.php");
include_once("TeamSignLogic.php");
include_once("JerseyLogic.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/3/31
 * Time: 17:19
 */
class ClubLogic
{
    private $_clubModel;
    function init($userId)
    {
        $this->_clubModel = new ClubModel();
        if(empty($this->_clubModel) || !$this->_clubModel->init($userId))
        {
            return false;	
        }
        return true;
    }
    
    function isCreate()
    {
    	return !empty($this->_clubModel->data());
    }
    
    function getModel()
    {
    	return $this->_clubModel;
    }

    private function _getClubStrut($name, $clubName, $fansName, $city, $countryId, $createTime)
    {
        $_data = array();

        $_data[DATA_BASE_CLUB_USERID] = $this->_clubModel->userId();
        $_data[DATA_BASE_CLUB_LEVEL] = 1;
        
        if($createTime)
        	$_data[DATA_BASE_CLUB_CREATEDATE] = $createTime;
        else
        	$_data[DATA_BASE_CLUB_CREATEDATE] = time();
        
        $_data[DATA_BASE_CLUB_NAME] = $name;
        $_data[DATA_BASE_CLUB_CLUBNAME] = $clubName;
        $_data[DATA_BASE_CLUB_STADIUMNAME] = $clubName . "Stadium";
        $_data[DATA_BASE_CLUB_STADIUMSEATNUM] = 200;
        $_data[DATA_BASE_CLUB_FANS] = $fansName;
        $_data[DATA_BASE_CLUB_CITY] = $city;
        $_data[DATA_BASE_CLUB_COUNTRY] = $countryId;

        $_teamSignLogic = new TeamSignLogic();
        if(empty($_teamSignLogic))
        {
            return $_data;
        }
        if(!$_teamSignLogic->isCreate($this->_clubModel->userId()))
        {
            return $_data;
        }
        $_data[DATA_BASE_CLUB_TEAMSIGN] = $_teamSignLogic->getTeamSignData()[0][DATA_BASE_TEAMSIGN_SIGNID];

        $_jerseyLogic = new JerseyLogic();
        if(empty($_jerseyLogic))
        {
            return $_data;
        }
        if(!$_jerseyLogic->isCreate($this->_clubModel->userId()))
        {
            return $_data;
        }
        $_jerseyData = $_jerseyLogic->getJerseyData();
        $_data[DATA_BASE_CLUB_HOMEJERSEY] = $_jerseyData[0][DATA_BASE_JERSEY_JERSEYID];
        $_data[DATA_BASE_CLUB_AWAYJERSEY] = $_jerseyData[1][DATA_BASE_JERSEY_JERSEYID];

        return $_data;
    }

    function addClub($name, $clubName, $fansName, $countryId, $city, $createTime = null)
    {
        $_data = $this->_getClubStrut($name, $clubName, $fansName, $city, $countryId, $createTime);
        return $this->_clubModel->insertClubData($_data);
    }

    function getClubInfo()
    {
        $_backInfo = new SC_GETCLUBINFO_ACK();
        $_clubData = $this->_clubModel->getClubData();
        if(is_array($_clubData))
        {
            foreach($_clubData as $field => $value)
            {
                if($field != DATA_BASE_CLUB_USERID)
                {
                    $_sInfo = new SInfo();
                    $_sInfo->__Type = $field;

                    $_value = "";
                    if(!empty($value))
                    {
                        $_value = $value;
                    }
                    $_sInfo->__Value = $_value;

                    array_push($_backInfo->__ClubData, $_sInfo);
                }
            }
        }

        return $_backInfo;
    }

    function checkCountryId($id)
    {
        $_config = XmlConfigMgr::getInstance()->getCountryConfig();
        if(empty($_config->findCountryConfig($id)))
        {
            return false;
        }
        return true;
    }

    private function _revisAbilityField()
    {
        $_fieldList = array();

        $_fieldList[DATA_BASE_CLUB_CLUBNAME] = true;
        $_fieldList[DATA_BASE_CLUB_FANS] = true;
        $_fieldList[DATA_BASE_CLUB_COUNTRY] = true;
        $_fieldList[DATA_BASE_CLUB_CITY] = true;
        $_fieldList[DATA_BASE_CLUB_FANS] = true;
        $_fieldList[DATA_BASE_CLUB_STADIUMNAME] = true;
        $_fieldList[DATA_BASE_CLUB_HOMEJERSEY] = true;
        $_fieldList[DATA_BASE_CLUB_AWAYJERSEY] = true;
        $_fieldList[DATA_BASE_CLUB_TEAMSIGN] = true;
        $_fieldList[DATA_BASE_CLUB_TROPHY1] = true;
        $_fieldList[DATA_BASE_CLUB_TROPHY2] = true;
        $_fieldList[DATA_BASE_CLUB_TROPHY3] = true;

        return $_fieldList;
    }

    private function _checkData($field, $value)
    {
        if($field == DATA_BASE_CLUB_CLUBNAME)
        {
            return !empty($value) || strlen($value) <= 18;
        }
        elseif($field == DATA_BASE_CLUB_CITY)
        {
            return !empty($value) || strlen($value) <= 15;
        }
        elseif($field == DATA_BASE_CLUB_FANS)
        {
            return !empty($value) || strlen($value) <= 15;
        }
        elseif($field == DATA_BASE_CLUB_STADIUMNAME)
        {
            return !empty($value) || strlen($value) <= 28;
        }
        elseif($field == DATA_BASE_CLUB_COUNTRY)
        {
            return $this->checkCountryId($value);
        }
        elseif($field == DATA_BASE_CLUB_TEAMSIGN)
        {
            $_teamSignLogic = new TeamSignLogic();
            if(empty($_teamSignLogic))
            {
                return false;
            }
            if(!$_teamSignLogic->isCreate($this->_clubModel->userId()))
            {
                return false;
            }
            return $_teamSignLogic->checkTeamSignIsSelf($value);
        }
        elseif($field == DATA_BASE_JERSEY_JERSEYID)
        {
            $_jerseyLogic = new JerseyLogic();
            if(empty($_jerseyLogic))
            {
                return false;
            }
            if(!$_jerseyLogic->isCreate($this->_clubModel->userId()))
            {
                return false;
            }
            return $_jerseyLogic->checkJerseyIsSelf($value);
        }

        return true;
    }

    function updateClub($data)
    {
        if(is_array($data))
        {
            $_fieldList = $this->_revisAbilityField();
            foreach($data as $sInfo)
            {
                if(!empty($_fieldList[$sInfo->__Type]))
                {
                    if($this->_checkData($sInfo->__Type, $sInfo->__Value))
                    {
                        $this->_clubModel->setFieldByIndex($sInfo->__Type, $sInfo->__Value);
                    }
                    else//数据验证失败
                    {
                        return false;
                    }
                }
                else//不可修改字段
                {
                    return false;
                }
            }

            return $this->_clubModel->saveClubData($this->_clubModel->userId());
        }
        return false;
    }
    
    function getClubTeamSign()
    {
    	$teamSignId = $this->_clubModel->getFieldByIndex(DATA_BASE_CLUB_TEAMSIGN);
    	if($teamSignId)
    	{
    		$teamSignModel = new TeamSignModel();
    		if(!$teamSignModel || !$teamSignModel->init($this->_clubModel->userId()))
    			return null;
    		
    		$data = $teamSignModel->getTeamSignData();
    		
    		foreach($data as $v)
    		{
    			if($v[DATA_BASE_TEAMSIGN_SIGNID] == $teamSignId)
    			{
    				$one = new TeamSignInfo();
    				$one->__Index = 0;
    				$one->__TeamSignId = $teamSignId;
    				foreach($v as $key => $value)
    				{
    					$_info = new SInfo();
    					$_info->__Type = $key;
    					$_info->__Value = $value;
    						
    					array_push($one->__TeamSignData, $_info);
    				}
    				
    				return $one;
    			}
    			
    		}
    	}
    	
    	return null; 
    }
}