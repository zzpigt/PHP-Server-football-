<?php
include_once(APP_LOGIC_PATH."CardsLogic.php");
include_once(APP_LOGIC_PATH."PropertiesLogic.php");
include_once(APP_LOGIC_PATH."FormationLogic.php");
include_once(APP_LOGIC_PATH."TacticsLogic.php");
include_once(APP_LOGIC_PATH."ClubLogic.php");
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/3
 * Time: 14:36
 */
class Player
{
    function create($data)
    {
        if(empty($data))
        {
            Send(SCID_CREATE_ACK, ERROR_CREATE, null);
        }
        if(!isset($data->value->__Name))
        {
            Send(SCID_CREATE_ACK, ERROR_NAME_LENGTH);
        }

        $_nick = $data->value->__Name;
        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_propertiesLogic = new PropertiesLogic();
        if(empty($_propertiesLogic))
        {
            Send(SCID_CREATE_ACK, ERROR_SERVER);
        }
        if(!$_propertiesLogic->init($_userId))
        {
            Send(SCID_CREATE_ACK, ERROR_SERVER);
        }
        if($_propertiesLogic->nameLengthIsError($_nick))
        {
            Send(SCID_CREATE_ACK, ERROR_NAME_LENGTH);
        }

        $_nick = $_propertiesLogic->formatStr($_nick);
        if($_propertiesLogic->nameIsRepeat($_nick))
        {
            Send(SCID_CREATE_ACK, ERROR_NAME_HAVED);
        }

        if(!$_propertiesLogic->createProperties($_nick))
        {
            Send(SCID_CREATE_ACK, ERROR_CREATE);
        }

        $_ack = new SC_CREATE_ACK();
        Send(SCID_CREATE_ACK, ERROR_OK, $_ack);
    }

    function getPlayerInfo()
    {
        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_propertiesLogic = new PropertiesLogic();
        if(empty($_propertiesLogic))
        {
            Send(SCID_Property_ACK, ERROR_SERVER);
        }
        if(!$_propertiesLogic->init($_userId))
        {
            Send(SCID_Property_ACK, ERROR_SERVER);
        }
        $_info = $_propertiesLogic->getPlayerProperties();
        Send(SCID_Property_ACK, ERROR_OK, $_info);
    }

    function getCardsInfo($data)
    {
        if(empty($data->value->__UserId))
        {
            Send(SCID_FootballerInfo_ACK, ERROR_OK, null);
        }

        $_userId = $data->value->__UserId;
        $_cardLogic = new CardsLogic();
        if(empty($_cardLogic))
        {
            Send(SCID_FootballerInfo_ACK, ERROR_SERVER);
        }
        if(!$_cardLogic->init($_userId))
        {
            Send(SCID_FootballerInfo_ACK, ERROR_SERVER);
        }
        $_cardInfo = $_cardLogic->getInfo();
        Send(SCID_FootballerInfo_ACK, ERROR_OK, $_cardInfo);
    }

    function getFormationInfo($data)
    {
        if(empty($data->value->__UserId))
        {
            Send(SCID_FormationInfo_ACK, ERROR_OK, null);
        }

        $_userId = $data->value->__UserId;
        $_formation = new FormationLogic();
        if(empty($_formation))
        {
            Send(SCID_FormationInfo_ACK, ERROR_SERVER);
        }
        if(!$_formation->init($_userId))
        {
            Send(SCID_FormationInfo_ACK, ERROR_SERVER);
        }
        $_backInfo = $_formation->getFormationInfo($_formation->getFormationData());
        Send(SCID_FormationInfo_ACK, ERROR_OK, $_backInfo);
    }

    function updateFieldPosition($data)
    {
        if(empty($data))
        {
            Send(SCID_FormationSet_ACK, ERROR_OK);
        }

        $_formation = new FormationLogic();
        if(empty($_formation))
        {
            Send(SCID_FormationSet_ACK, ERROR_SERVER);
        }
        if(!$_formation->init(Registry::getInstance()->get(CLIENT_ID)))
        {
            Send(SCID_FormationSet_ACK, ERROR_SERVER);
        }
        $_cardInfo = $_formation->formatFieldPosition($data->value->__FormationInfo);
        if(empty($_cardInfo))
        {
            Send(SCID_FormationSet_ACK, ERROR_OK);
        }

        if($_formation->saveFormation($_cardInfo))
        {
            $_backInfo = new SC_FormationInfo_ACK();
            $_backInfo->__FormationInfo = 1;
            Send(SCID_FormationSet_ACK, ERROR_OK, $_backInfo);
        }

        Send(SCID_FormationSet_ACK, ERROR_FORMATION_CHANGE);
    }

    function addCard($data)
    {
        $_cardId = $data->value->__FootballerID;
        if (empty($_cardId))
        {
            Send(SCID_FootballerADD_ACK, ERROR_NOT_FIND_CARD, null);
        }

        //缺少验证卡牌ID
        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_cardLogic = new CardsLogic();
        if(empty($_cardLogic))
        {
            Send(SCID_FootballerADD_ACK, ERROR_SERVER);
        }
        if(!$_cardLogic->init($_userId))
        {
            Send(SCID_FootballerADD_ACK, ERROR_SERVER);
        }

        if($_cardLogic->haveTheCard($_cardId))
        {
            Send(SCID_FootballerADD_ACK, ERROR_NOT_FIND_CARD, null);
        }

        $_backInfo = $_cardLogic->addCard($_cardId, false);
        if(empty($_backInfo))
        {
            Send(SCID_FootballerADD_ACK, ERROR_SERVER, null);
        }
        Send(SCID_FootballerADD_ACK, ERROR_OK, $_backInfo);
    }

    function delCard($data)
    {
        $_cardId = $data->value->__FootballerID;
        if (empty($_cardId))
        {
            Send(SCID_FootballerDestory_ACK, ERROR_NOT_FIND_CARD, null);
        }

        $_cardLogic = new CardsLogic();
        if(empty($_cardLogic))
        {
            Send(SCID_FootballerDestory_ACK, ERROR_SERVER);
        }
        if(!$_cardLogic->init(Registry::getInstance()->get(CLIENT_ID)))
        {
            Send(SCID_FootballerDestory_ACK, ERROR_SERVER);
        }
        if(!$_cardLogic->haveTheCard($_cardId))
        {
            Send(SCID_FootballerDestory_ACK, ERROR_NOT_HAVE_CARD, null);
        }

        $_isSuccess = $_cardLogic->deleteCardData($_cardId);
        $_backInfo = new SC_FootballerDestory_ACK();
        $_backInfo->__IsScuess = $_isSuccess;
        Send(SCID_FootballerDestory_ACK, ERROR_OK, $_backInfo);
    }

    function getRedPoint()
    {
        $_userAId = Registry::getInstance()->get(CLIENT_ID);
        $_userA = new PropertiesLogic();
        if(empty($_userA))
        {
            Send(SCID_REDPOINT_ACK, ERROR_SERVER);
        }
        if(!$_userA->init($_userAId))
        {
            Send(SCID_REDPOINT_ACK, ERROR_SERVER);
        }
        $_isRed = 0;
        if($_userA->selfIsFight())
        {
            $_isRed = 1;
        }

        $_redPoints = new SC_REDPOINT_ACK();

        $_sInfo = new SInfo();
        $_sInfo->__Type = REDPOINT_PVPFIGHT;
        $_sInfo->__Value = $_isRed;

        array_push($_redPoints->__RedPointsArr, $_sInfo);
        Send(SCID_REDPOINT_ACK,ERROR_OK, $_redPoints);
    }

    //proto id: 900
    function getTactics($userId)
    {
        $_tactics = new TacticsLogic();
        if(empty($_tactics))
        {
            Send(SCID_TACTICSGET_ACK, ERROR_SERVER);
        }
        /*if(!$_tactics->isCreate(Registry::getInstance()->get(CLIENT_ID)))
        {
            Send(SCID_TACTICSGET_ACK, ERROR_SERVER);
        }*/
        $_data = $_tactics->getTacticsData($userId);
        if(empty($_data))
        {
            $_data = $_tactics->initTactics($userId);
        }

        $_backInfo = $_tactics->getTacticsInfo($_data);
        Send(SCID_TACTICSGET_ACK, ERROR_OK, $_backInfo);
    }

    //proto id: 902
    function updateTactics($data, $userId)
    {
        $_tactics = new TacticsLogic();
        if(empty($_tactics))
        {
            Send(SCID_TACTICSSET_ACK, ERROR_SERVER);
        }

        $_isSuccess = 0;
        if($_tactics->updateTacticsInfo($data->value, $userId))
        {
            $_isSuccess = 1;
        }

        $_user = new PropertiesLogic();
        if(empty($_user) || !$_user->init(Registry::getInstance()->get(CLIENT_ID)))
        {
            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
        }
        $_userArr = $_user->roomTagHandle();
        if(!empty($_userArr))
        {
            $_rooms = new FightRoomsLogic();
            if(empty($_rooms) || !$_rooms->init($_userArr[0], $_userArr[1]))
            {
                Send(SCID_APPLYGAME_ACK,ERROR_SERVER);
            }
            $_index = $_rooms->getRoomDataByUserId($_userArr[0], $_userArr[1]);
            if(!isset($_index))
            {
                Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
            }
            $_roomId = $_rooms->getModel()->getRoomIdByIndex($_index);
            if(empty($_roomId))
            {
                Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
            }

            $_rooms->getModel()->updateRoomIsOperation($_roomId, $_index, 1);
        }

        $_backInfo = new SC_TACTICSSET_ACK();
        $_backInfo->__IsSuccess = $_isSuccess;
        Send(SCID_TACTICSSET_ACK,ERROR_OK, $_backInfo);
    }

    /*
     * 测试函数
     * proto id: 100000
     * */
    function testAllFunc($data)
    {
//        $_userBId = $data->value->__DefenseId;
//        if(empty($_userBId))
//        {
//            Send(SCID_APPLYGAME_ACK,ERROR_PVP_NO_USER);//没有B玩家
//        }
//        $_userB = new PropertiesLogic($_userBId);
//        if(empty($_userB->getPlayerDataByField(DATA_BASE_PROPERTIES_NICK)))
//        {
//            Send(SCID_APPLYGAME_ACK,ERROR_PVP_NO_USER);//没有B玩家
//        }
//        if($_userB->selfIsFight())
//        {
//            Send(SCID_APPLYGAME_ACK,ERROR_PVP_ENEMY_FIGHT);//B在战斗
//        }
//
//        $_userAId = Registry::getInstance()->get(CLIENT_ID);
//        $_userA = new PropertiesLogic($_userAId);
//        if($_userA->selfIsFight())
//        {
//            Send(SCID_APPLYGAME_ACK,ERROR_PVP_SELF_FIGHT);//自己已经在战斗
//        }
//
//        $_roomLogic = new RoomsLogic($this->_userId);
//        $_roomId = $_roomLogic->createPvpRoom($_userAId, $_userBId);
//        $this->_cardsLogic->initUserCards();
//        var_dump( $_roomLogic->testFormat());
    }

    function cleanXmlCache()
    {
        MemInfoLogic::Instance()->setMemData('CONFIG_PLAYERDATA', null);
        MemInfoLogic::Instance()->setMemData('CONFIG_FIELDPOSITION', null);

        echo "clean success!";
    }
}