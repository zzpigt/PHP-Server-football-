<?php
include_once(APP_MODEL_PATH."CardRecommendModel.php");
include_once(APP_PROTO_PATH."proto.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/22
 * Time: 17:25
 */
class CardRecommendLogic
{
    private static $_modelArr;
    private $_cardRecommendModel;
    function init($primaryValue)
    {
        if(empty(self::$_modelArr[$primaryValue]))
        {
            $this->_cardRecommendModel = new CardRecommendModel();
            if(empty($this->_cardRecommendModel) || !$this->_cardRecommendModel->init($primaryValue))
            {
                return false;
            }
            return true;
        }
        else
        {
            $this->_cardRecommendModel = self::$_modelArr[$primaryValue];
            if($this->_cardRecommendModel instanceof CardRecommendModel)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/24
     * Time: 16:30
     * Des: 取得推荐球员Model
     */
    function CardRecommendModel()
    {
        if($this->_cardRecommendModel instanceof CardRecommendModel)
        {
            return $this->_cardRecommendModel;
        }
        return null;
    }

    function getCardRecommendInfo()
    {
        $_model = $this->CardRecommendModel();
        if(!empty($_model))
        {
            $_cardArr = array();
            $_data = $_model->data();
            foreach($_data as $index => $cardRecommend)
            {
                $_info = new SCardInfos();
                $_info->__Uid = 0;
                $_info->__Index = $index;

                if(!empty($cardRecommend[DATA_BASE_CARD_RECOMMEND_CARDATTRIBUTE]))
                {
                    $_cardData = $cardRecommend[DATA_BASE_CARD_RECOMMEND_CARDATTRIBUTE];
                    $_recommend = new SCardRecommend();
                    $_recommend->__Token = $_cardData[TOKEN];
                    foreach($_cardData as $key => $value)
                    {
                        if($key == TOKEN)
                        {
                            continue;
                        }
                        $_sInfo = new SInfo();
                        $_sInfo->__Type = $key;
                        $_sInfo->__Value = $value;
                        array_push($_info->__InfoArr, $_sInfo);
                    }
                    $_recommend->__CardInfo = $_info;
                    array_push($_cardArr, $_recommend);
                }
            }
            return $_cardArr;
        }
        return null;
    }

    function getCardRecommendByIndex($index)
    {
        $_model = $this->CardRecommendModel();
        if(!empty($_model))
        {
            $_data = $_model->data();
            if(empty($_data[$index]))
            {
                return null;
            }
            return $_data[$index];
        }

        return null;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/24
     * Time: 16:29
     * Des: 创建推荐球员数据
     */
    function createCardRecommendData($leagueLevel)
    {
        if(!empty($this->_cardRecommendModel->data()))
        {
            return true;
        }

        $cardsLogic = new CardsLogic();
        if(empty($cardsLogic) || !$cardsLogic->init($this->_cardRecommendModel->UserId()))
            return false;

        $_cardArr = array();
        $_position = rand(1, 12);
        for($i = 7; $i <= 9; $i ++)
        {
            $_cardData = $cardsLogic->createUserCard($_position, $leagueLevel, CARD_CREATE_TYPE_RECOMMEND);
            $_general = CardsLogic::countGeneral($_cardData);
            $_cardData[TOKEN] = countRecommendPrice($_general, $_cardData[DATA_BASE_CARDS_AGE], 1);
            if($_cardData)
            {
                array_push($_cardArr, $_cardData);
            }
        }
//        $_cardRecommendArr = array();
//        $_starNum = 4;
//        for($i = 1; $i <= 3; $i++)
//        {
//            if($i == 2)
//            {
////                $_starNum = rand()
//            }
//            elseif($i == 3)
//            {
//
//            }
//
//            $_minAbility = ($_starNum - $leagueLevel) * 5;
//            $_maxAbility = ($_starNum - $leagueLevel + 1) * 5 - 1;
//        }

//        if(!empty($this->_cardRecommendModel->data()))
//        {
//            return true;
//        }
//
//        $_cardLogic = new CardsLogic();
//        $_cardLogic->init($this->_cardRecommendModel->userId());
//        $_constant = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig(37)['Value'];
//
//        $_cardArr = array();
//        for($i = 1; $i < 4; $i ++)
//        {
//            $newCard = $_cardLogic->_getCardsStrut(1, $leagueLevel, $_constant);
//            array_push($_cardArr, $newCard);
//        }

        if($this->_cardRecommendModel->insertCardRecommend($_cardArr))
        {
            return true;
        }
        return false;
    }
}