<?php
include_once(APP_MODEL_PATH."ScoutModel.php");
include_once(APP_PROTO_PATH."proto.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/25
 * Time: 10:39
 */
class ScoutLogic
{
    private static $_modelArr;
    private $_scoutModel;
    function init($userId)
    {
        if(empty(self::$_modelArr[$userId]))
        {
            $this->_scoutModel = new ScoutModel();
            if(empty($this->_scoutModel) || !$this->_scoutModel->init($userId))
            {
                return false;
            }
            return true;
        }
        else
        {
            $this->_scoutModel = self::$_modelArr[$userId];
            if($this->_scoutModel instanceof ScoutModel)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 11:50
     * Des: 球探Model属性
     */
    function ScoutModel()
    {
        if($this->_scoutModel instanceof ScoutModel)
        {
            return $this->_scoutModel;
        }
        return null;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 13:59
     * Des: 创建45个球探球员数据
     */
    function createScoutCardData($leagueLevel)
    {
        $cardsLogic = new CardsLogic();
        if(empty($cardsLogic) || !$cardsLogic->init($this->_scoutModel->UserId()))
            return false;

        $_cardDataArr = array();
        for($i = 0; $i < 45; $i ++)
        {
            $_cardData = $cardsLogic->createUserCard(0, $leagueLevel, CARD_CREATE_TYPE_SCOUT);
            $_general = CardsLogic::countGeneral($_cardData);
            $_cardData[TOKEN] = countScoutPrice($_general, $_cardData[DATA_BASE_CARDS_AGE], 1);
            if($_cardData)
            {
                array_push($_cardDataArr, $_cardData);
            }
        }

        return $_cardDataArr;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/25
     * Time: 14:18
     * Des: 取得协议返回的数据组装
     */
    function getBackScoutCardData($cardDataArr)
    {
        if(is_array($cardDataArr))
        {
            $_scoutCardArr = array();
            foreach($cardDataArr as $index => $cardData)
            {
                $_info = new SCardInfos();
                $_info->__Uid = 0;
                $_info->__Index = $index;

                $_cardData = new SCardRecommend();
                if(is_array($cardData))
                {
                    $_cardData->__Token = $cardData[TOKEN];
                    foreach($cardData as $field => $value)
                    {
                        if($field == TOKEN)
                        {
                            continue;
                        }
                        $_sInfo = new SInfo();
                        $_sInfo->__Type = $field;
                        $_sInfo->__Value = $value;

                        array_push($_info->__InfoArr, $_sInfo);
                    }
                }
                $_cardData->__CardInfo = $_info;
                array_push($_scoutCardArr, $_cardData);
            }
            return $_scoutCardArr;
        }
        return null;
    }
}