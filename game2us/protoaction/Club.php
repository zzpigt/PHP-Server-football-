<?php
include_once(APP_LOGIC_PATH."TeamSignLogic.php");
include_once(APP_LOGIC_PATH."JerseyLogic.php");
include_once(APP_LOGIC_PATH."ClubLogic.php");
include_once(APP_LOGIC_PATH."PropertiesLogic.php");
include_once(APP_LOGIC_PATH."TrophyLogic.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/3/30
 * Time: 15:17
 */
class Club
{
    function createClub($data)
    {
        if(empty($data))
        {
            Send(SCID_CREATECLUB_ACK, ERROR_OK, NULL);
        }

        if(empty($data->value->__ClubInfo->__ClubName) || strlen($data->value->__ClubInfo->__ClubName) > 17)
        {
            Send(SCID_CREATECLUB_ACK, ERROR_NAME_LENGTH, NULL);
        }

        if(empty($data->value->__ClubInfo->__FansName) || strlen($data->value->__ClubInfo->__FansName) > 17)
        {
            Send(SCID_CREATECLUB_ACK, ERROR_NAME_LENGTH, NULL);
        }

        if(empty($data->value->__ClubInfo->__CountryId) || !strlen($data->value->__ClubInfo->__CountryId)>16)
        {
            Send(SCID_CREATECLUB_ACK, ERROR_NAME_LENGTH, NULL);
        }

        if(empty($data->value->__ClubInfo->__City) || strlen($data->value->__ClubInfo->__City) > 17)
        {
            Send(SCID_CREATECLUB_ACK, ERROR_NAME_LENGTH, NULL);
        }

        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_clubLogic = new ClubLogic();
        if(empty($_clubLogic))
        {
            Send(SCID_CREATECLUB_ACK, ERROR_SERVER);
        }
        if(!$_clubLogic->init($_userId))
        {
            Send(SCID_CREATECLUB_ACK, ERROR_SERVER);
        }

        if(!$_clubLogic->checkCountryId($data->value->__ClubInfo->__CountryId))
        {
            Send(SCID_CREATECLUB_ACK, ERROR_NOT_FIND_COUNTRY);
        }

        $_propertiesModel = PropertiesModelMgr::Instance()->getModelByPrimary($_userId);
        $_name = $_propertiesModel->getFieldByIndex(DATA_BASE_PROPERTIES_NICK);

        $_clubName = $_propertiesModel->escapeString($data->value->__ClubInfo->__ClubName);
        $_fansName = $_propertiesModel->escapeString($data->value->__ClubInfo->__FansName);
        $_city = $_propertiesModel->escapeString($data->value->__ClubInfo->__City);
        $_countryId = $data->value->__ClubInfo->__CountryId;

        $_isSuccess = $_clubLogic->addClub($_name, $_clubName, $_fansName, $_countryId, $_city);
        $_backInfo = new SC_CREATECLUB_ACK();
        $_backInfo->__IsSuccess = 0;
        if($_isSuccess)
        {
            $_backInfo->__IsSuccess = 1;
        }

        Send(SCID_CREATECLUB_ACK, ERROR_OK, $_backInfo);
    }

    function updateClub($data)
    {
        if(empty($data))
        {
            Send(SCID_UPDATECLUB_ACK, ERROR_OK, NULL);
        }

        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_clubLogic = new ClubLogic();
        if(empty($_clubLogic))
        {
            Send(SCID_UPDATECLUB_ACK, ERROR_SERVER);
        }
        if(!$_clubLogic->init($_userId))
        {
            Send(SCID_UPDATECLUB_ACK, ERROR_SERVER);
        }

        $_isSuccess = $_clubLogic->updateClub($data->value->__ClubInfo);
        $_backInfo = new SC_UPDATECLUB_ACK();
        $_backInfo->__IsSuccess = 0;
        if($_isSuccess)
        {
            $_backInfo->__IsSuccess = 1;
        }
        Send(SCID_UPDATECLUB_ACK, ERROR_OK, $_backInfo);
    }

    function getClubInfo($data)
    {
        if(empty($data->value->__UserId))
        {
            Send(SCID_GETCLUBINFO_ACK, ERROR_OK);
        }

        $_userId = $data->value->__UserId;
        $_clubLogic = new ClubLogic();
        if(empty($_clubLogic))
        {
            Send(SCID_GETCLUBINFO_ACK, ERROR_SERVER);
        }
        if(!$_clubLogic->init($_userId))
        {
            Send(SCID_GETCLUBINFO_ACK, ERROR_SERVER);
        }
        $_backInfo = $_clubLogic->getClubInfo();

        Send(SCID_GETCLUBINFO_ACK, ERROR_OK, $_backInfo);
    }

    function getTeamSign()
    {
        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_teamSignLogic = new TeamSignLogic();
        if(empty($_teamSignLogic))
        {
            Send(SCID_CLUBTEAMSIGN_ACK, ERROR_SERVER);
        }
        if(!$_teamSignLogic->isCreate($_userId))
        {
            Send(SCID_CLUBTEAMSIGN_ACK, ERROR_SERVER);
        }
        $_backInfo = $_teamSignLogic->getTeamSignInfo($_teamSignLogic->getTeamSignData());

        Send(SCID_CLUBTEAMSIGN_ACK, ERROR_OK, $_backInfo);
    }

    function updateTeamSign($data)
    {
        if(empty($data) || !isset($data->value->__TeamIndex) || !isset($data->value->__TeamSignInfo))
        {
            Send(SCID_UPDATECLUBTEAMSIGN_ACK, ERROR_OK, null);
        }

        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_teamSignLogic = new TeamSignLogic();
        if(empty($_teamSignLogic))
        {
            Send(SCID_UPDATECLUBTEAMSIGN_ACK, ERROR_SERVER);
        }
        if(!$_teamSignLogic->isCreate($_userId))
        {
            Send(SCID_UPDATECLUBTEAMSIGN_ACK, ERROR_SERVER);
        }

        $_index = $data->value->__TeamIndex;
        $_teamSignInfo = $data->value->__TeamSignInfo;
        $_isSuccess = $_teamSignLogic->updateTeamSign($_teamSignInfo, $_index);

        $_backInfo = new SC_UPDATETEAMSIGN_ACK();
        $_backInfo->__IsSuccess = $_isSuccess;

        Send(SCID_UPDATECLUBTEAMSIGN_ACK, ERROR_OK, $_backInfo);
    }

    function getJersey()
    {
        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_jerseyLogic = new JerseyLogic();
        if(empty($_jerseyLogic))
        {
            Send(SCID_CLUBSHIRT_ACK, ERROR_SERVER);
        }
        if(!$_jerseyLogic->isCreate($_userId))
        {
            Send(SCID_CLUBSHIRT_ACK, ERROR_SERVER);
        }
        $_backInfo = $_jerseyLogic->getJerseyInfo($_jerseyLogic->getJerseyData());

        Send(SCID_CLUBSHIRT_ACK, ERROR_OK, $_backInfo);
    }

    function updateJersey($data)
    {
        if(empty($data) || !isset($data->value->__ShirtIndex) || !isset($data->value->__MainColor) || !isset($data->value->__Color))
        {
            Send(SCID_CLUBSHIRT_ACK, ERROR_OK, null);
        }

        if($data->value->__MainColor == $data->value->__Color)
        {
            Send(SCID_CLUBSHIRT_ACK, ERROR_OK, null);
        }

        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_jerseyLogic = new JerseyLogic();
        if(empty($_jerseyLogic))
        {
            Send(SCID_UPDATECLUBSHIRT_ACK, ERROR_SERVER);
        }
        if(!$_jerseyLogic->isCreate($_userId))
        {
            Send(SCID_UPDATECLUBSHIRT_ACK, ERROR_SERVER);
        }

        $_index = $data->value->__ShirtIndex;
        $_mainColor = $data->value->__MainColor;
        $_color = $data->value->__Color;
        $_isSuccess = $_jerseyLogic->updateJersey($_userId, $_index, $_mainColor, $_color);

        $_backInfo = new SC_UPDATECLUBSHIRT_ACK();
        $_backInfo->__IsSuccess = $_isSuccess;

        Send(SCID_UPDATECLUBSHIRT_ACK, ERROR_OK, $_backInfo);
    }

    function getTrophyList()
    {
        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_trophyLogic = new TrophyLogic();
        if(empty($_trophyLogic))
        {
            Send(SCID_GETTROPHYLIST_ACK, ERROR_SERVER);
        }

        $_backInfo = $_trophyLogic->getTrophyList($_userId);

        Send(SCID_GETTROPHYLIST_ACK, ERROR_OK, $_backInfo);
    }

    //测试接口
    function addTrophy($data)
    {
        $_value = $data->value;
        $_level = $_value->__Level;
        $_rank = $_value->__Ranking;
        $_type = $_value->__TrophyType;

        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_trophyLogic = new TrophyLogic();
        if(empty($_trophyLogic))
        {
            Send(SCID_GETTROPHYLIST_ACK, ERROR_SERVER);
        }

        $isSuccess = $_trophyLogic->addTrophy($_userId, $_level, $_rank, $_type);

        $_backInfo = 0;
        if($isSuccess)
        {
            $_backInfo = 1;
        }

        Send(SCID_GETTROPHYLIST_ACK, ERROR_OK, $_backInfo);
    }
}