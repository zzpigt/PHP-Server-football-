<?php
include_once(APP_LOGIC_PATH."PropertiesLogic.php");
include_once(APP_LOGIC_PATH."CardRecommendLogic.php");
include_once(APP_LOGIC_PATH."ScoutLogic.php");
include_once(APP_LOGIC_PATH."CardsLogic.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/22
 * Time: 21:42
 */
class Transfer
{
    function getCardRecommend()
    {
        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_propertiesLogic = new PropertiesLogic();
        if(empty($_propertiesLogic) || !$_propertiesLogic->init($_userId))
        {
            Send(SCID_GET_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        if($_propertiesLogic->isRecommend($_userId))
        {
            $_cardRecommendLogic = new CardRecommendLogic();
            if(empty($_cardRecommendLogic) || !$_cardRecommendLogic->init($_userId))
            {
                Send(SCID_GET_RECOMMEND_CARD_ACK, ERROR_SERVER);
            }
            if(!$_cardRecommendLogic->createCardRecommendData(1))
            {
                Send(SCID_GET_RECOMMEND_CARD_ACK, ERROR_SERVER);
            }

            $_cardArr = $_cardRecommendLogic->getCardRecommendInfo();
            $_backInfo = new SC_GET_RECOMMEND_CARD_ACK();
            $_backInfo->__EndTime = $_propertiesLogic->getPlayerDataByField($_userId, DATA_BASE_PROPERTIES_RECOMMENDENDTIME);
            $_backInfo->__CardArr = $_cardArr;
            Send(SCID_GET_RECOMMEND_CARD_ACK, ERROR_OK, $_backInfo);
        }
        Send(SCID_GET_RECOMMEND_CARD_ACK, ERROR_OK, new CardRecommendLogic());
    }

    function buyCardRecommend($data)
    {
        if(!isset($data->value->__Index))
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_cardLogic = new CardsLogic();
        if(empty($_cardLogic) || !$_cardLogic->init($_userId))
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        $_cardRecommendLogic = new CardRecommendLogic();
        if(empty($_cardRecommendLogic) || !$_cardRecommendLogic->init($_userId))
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        $_index = $data->value->__Index;
        $_cardData = $_cardRecommendLogic->getCardRecommendByIndex($_index);
        $_cardsModel = $_cardLogic->CardsModel();
        if(empty($_cardsModel) || !$_cardsModel->insertCardData($_cardData[DATA_BASE_CARD_RECOMMEND_CARDATTRIBUTE]))
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        $_cardRecommendModel = $_cardRecommendLogic->CardRecommendModel();
        if(empty($_cardRecommendModel))
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        if(!$_cardRecommendModel->deleteCardRecommend())
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        $_propertiesModel = PropertiesModelMgr::Instance()->getModelByPrimary($_userId);
        if(empty($_propertiesModel))
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        $_token =  $_propertiesModel->getFieldByIndex(DATA_BASE_PROPERTIES_DIAMOND);
        $_useToken = $_cardData[DATA_BASE_CARD_RECOMMEND_CARDATTRIBUTE][TOKEN];
        if($_token < $_useToken)
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        if(!$_propertiesModel->subMoneyByField(DATA_BASE_PROPERTIES_DIAMOND, $_useToken))
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        $_propertiesModel->setFieldByIndex(DATA_BASE_PROPERTIES_RECOMMENDENDTIME, time());
        if(!$_propertiesModel->DB_update1())
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        $_backInfo = new SC_BUY_RECOMMEND_CARD_ACK();
        $_backInfo->__IsSuccess = 1;
        Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_OK, $_backInfo);
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 11:58
     * Des: 取得球探球员的数据
     */
    function getScoutData()
    {
        $_userId = Registry::getInstance()->get(CLIENT_ID);

        $_scoutLogic = new ScoutLogic();
        if(empty($_scoutLogic) || !$_scoutLogic->init($_userId))
        {
            Send(SCID_GET_SCOUT_ACK, ERROR_SERVER);
        }

        $_scoutModel = $_scoutLogic->ScoutModel();
        if(empty($_scoutModel))
        {
            Send(SCID_GET_SCOUT_ACK, ERROR_SERVER);
        }

        $_cardDataArr = null;
        if($_scoutModel->isHaveScoutData())
        {
            $_cardDataArr = $_scoutModel->getScoutCardData();
            if(empty($_cardDataArr))
            {
                Send(SCID_GET_SCOUT_ACK, ERROR_SERVER);
            }
        }
        else
        {
            $_cardDataArr = $_scoutLogic->createScoutCardData(1);
            if(!$_cardDataArr)
            {
                Send(SCID_GET_SCOUT_ACK, ERROR_SERVER);
            }
            if(!$_scoutModel->insertScout($_cardDataArr))
            {
                Send(SCID_GET_SCOUT_ACK, ERROR_SERVER);
            }
        }

        $_backScoutCardArr = $_scoutLogic->getBackScoutCardData($_cardDataArr);
        if(empty($_backScoutCardArr))
        {
            Send(SCID_GET_SCOUT_ACK, ERROR_SERVER);
        }
        $_backInfo = new SC_GET_SCOUT_ACK();
        $_backInfo->__CardArr = $_backScoutCardArr;

        Send(SCID_GET_SCOUT_ACK, ERROR_OK, $_backInfo);
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 11:58
     * Des: 购买球探球员
     */
    function buyScoutCard($data)
    {
        if(!isset($data->value->__Index))
        {
            Send(SCID_BUY_SCOUT_ACK, ERROR_SERVER);
        }

        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_scoutLogic = new ScoutLogic();
        if(empty($_scoutLogic) || !$_scoutLogic->init($_userId))
        {
            Send(SCID_BUY_SCOUT_ACK, ERROR_SERVER);
        }

        $_scoutModel = $_scoutLogic->ScoutModel();
        if(empty($_scoutModel))
        {
            Send(SCID_BUY_SCOUT_ACK, ERROR_SERVER);
        }

        $_index = $data->value->__Index;
        $_cardData = $_scoutModel->getScoutCardData()[$_index];
        if(empty($_cardData))
        {
            Send(SCID_BUY_SCOUT_ACK, ERROR_SERVER);
        }

        $_cardLogic = new CardsLogic();
        if(empty($_cardLogic) || !$_cardLogic->init($_userId))
        {
            Send(SCID_BUY_SCOUT_ACK, ERROR_SERVER);
        }

        $_cardsModel = $_cardLogic->CardsModel();
        if(empty($_cardsModel) || !$_cardsModel->insertCardData($_cardData))
        {
            Send(SCID_BUY_SCOUT_ACK, ERROR_SERVER);
        }

        $_propertiesModel = PropertiesModelMgr::Instance()->getModelByPrimary($_userId);
        if(empty($_propertiesModel))
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        $_token =  $_propertiesModel->getFieldByIndex(DATA_BASE_PROPERTIES_DIAMOND);
        $_cash = $_propertiesModel->getFieldByIndex(DATA_BASE_PROPERTIES_MONEY);
        $_useToken = $_cardData[TOKEN];
        if($_token < $_useToken || $_cash + 100000000 < $_cardData[DATA_BASE_CARDS_VALUE])
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        if(!$_propertiesModel->subMoneyByField(DATA_BASE_PROPERTIES_DIAMOND, $_useToken))
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        if(!$_propertiesModel->subMoneyByField(DATA_BASE_PROPERTIES_MONEY, $_cardData[DATA_BASE_CARDS_VALUE]))
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        if(!$_propertiesModel->DB_update1())
        {
            Send(SCID_BUY_RECOMMEND_CARD_ACK, ERROR_SERVER);
        }

        $_scoutModel->setScoutCardData($_index, null);
        $_scoutModel->updateScout();//没有更新成功，也需要返回（购买已成事实）

        $_backInfo = new SC_BUY_SCOUT_ACK();
        $_backInfo->__IsSuccess = 1;
        Send(SCID_BUY_SCOUT_ACK, ERROR_OK, $_backInfo);
    }
}