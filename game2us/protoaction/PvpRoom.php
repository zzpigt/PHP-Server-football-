<?php
include_once (APP_LOGIC_PATH."PropertiesLogic.php");
include_once (APP_LOGIC_PATH."FightRoomsLogic.php");
include_once (APP_LOGIC_PATH."FightDataLogic.php");
include_once (APP_MODEL_PATH."FightDataModel.php");
include_once (APP_MODEL_PATH."LeagueScheduleModel.php");
include_once (APP_LOGIC_PATH."CardsLogic.php");
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/7
 * Time: 11:25
 */
class PvpRoom
{
    function  pvpStart($data)
    {
//        $_userBId = $data->value->__DefenseId;
//        if(empty($_userBId))
//        {
//            Send(SCID_APPLYGAME_ACK,ERROR_PVP_NO_USER);//没有B玩家
//        }
//        $_userB = new PropertiesLogic();
//        if(empty($_userB))
//        {
//            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
//        }
//        if(!$_userB->init($_userBId))
//        {
//            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
//        }
//        if(empty($_userB->getPlayerDataByField(DATA_BASE_PROPERTIES_NICK)))
//        {
//            Send(SCID_APPLYGAME_ACK,ERROR_PVP_NO_USER);//没有B玩家
//        }
////        if($_userB->selfIsFight())
////        {
////            Send(SCID_APPLYGAME_ACK,ERROR_PVP_ENEMY_FIGHT);//B在战斗
////        }
//
//        $_userAId = Registry::getInstance()->get(CLIENT_ID);
//        $_userA = new PropertiesLogic();
//        if(empty($_userA))
//        {
//            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
//        }
//        if(!$_userA->init($_userAId))
//        {
//            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
//        }
////        if($_userA->selfIsFight())
////        {
////            Send(SCID_APPLYGAME_ACK,ERROR_PVP_SELF_FIGHT);//自己已经在战斗
////        }
//
//        $_rooms = new FightRoomsLogic();
//        if(empty($_rooms))
//        {
//            Send(SCID_APPLYGAME_ACK,ERROR_SERVER);
//        }
//        if(!$_rooms->init($_userAId, $_userBId))
//        {
//            Send(SCID_APPLYGAME_ACK,ERROR_SERVER);
//        }
//        $_isSuccess = $_rooms->addFightRoom();
//        if(!$_isSuccess)
//        {
//            Send(SCID_APPLYGAME_ACK,ERROR_NOT_FIND_TYPE);
//        }
//        $_room = $_rooms->getFightRoomData()[$_rooms->getMaxFightRoomIndex()];
//
//        $_roomTag = $_userAId . "|" . $_userBId;
//        $_userA->setPlayerDataByField(DATA_BASE_PROPERTIES_PVPROOMID, $_roomTag);
//        $_userA->updateProperties();
//
//        $_userB->setPlayerDataByField(DATA_BASE_PROPERTIES_PVPROOMID, $_roomTag);
//        $_userB->updateProperties();
//
//        //战斗
//        $_roomData = new FightDataLogic();
//        if(empty($_roomData))
//        {
//            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
//        }
//        if(!$_roomData->initPvpRoom($_userAId, $_room))
//        {
//            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
//        }
//        $_result = $_roomData->getPvpFightResult();
//
//        Send(SCID_APPLYGAME_ACK, ERROR_OK, $_result);
    }

    function getPvpFightResult($data)
    {
    	$attach = MemInfoLogic::Instance()->getMemData(HEART_BEAT_ATTACH_PACKAGE."_".Registry::getInstance()->get(CLIENT_ID));
    	if($attach)
    	{
    		foreach($attach as $v)
    		{
                writeLog(LOG_LEVEL_NORMAL, $v[0], "START_NTF");
    			Send($v[0], ERROR_OK, $v[1], false);
    		}
    	}
    	
    	MemInfoLogic::Instance()->setMemData(HEART_BEAT_ATTACH_PACKAGE."_".Registry::getInstance()->get(CLIENT_ID), null);
    	
        $_user = new PropertiesLogic();
        if(empty($_user))
        {
            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
        }

        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_userArr = $_user->roomTagHandle($_userId);
        if(empty($_userArr))
        {
            Send(SCID_APPLYGAME_ACK, ERROR_OK);
        }

        $_rooms = new FightRoomsLogic();
        if(empty($_rooms))
        {
            Send(SCID_APPLYGAME_ACK,ERROR_SERVER);
        }
        if(!$_rooms->init($_userArr[0], $_userArr[1]))
        {
            Send(SCID_APPLYGAME_ACK,ERROR_SERVER);
        }
        $_index = $_rooms->getRoomDataByUserId($_userArr[0], $_userArr[1]);
        if(!isset($_index))
        {
            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
        }
        $_roomData = new FightDataLogic();
        if(empty($_roomData))
        {
            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
        }
        if(!$_roomData->initPvpRoom($_userArr[0], $_rooms->getFightRoomData()[$_index]))
        {
            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
        }

        $_fightEventPoint = 0;
        if(!empty($data->value->__FightEventPoint))
        {
            $_fightEventPoint = $data->value->__FightEventPoint;
        }
        $_isUpdate = false;
        $_result = $_roomData->getPvpFightResult(0, null, null, false, $_isUpdate, $_fightEventPoint);
        if($_isUpdate)
        {
            writeLog(LOG_LEVEL_DEBUG, $_result,"_isUpdate");
        	//
            foreach($_userArr as $userId)
            {
                $_cardLogic = new CardsLogic();
                if(empty($_cardLogic) || !$_cardLogic->init($userId))
                {
                    Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
                }
                if(!$_cardLogic->updateCardsData())
                {
                    Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
                }
            }

            $_roomData->updateFightUserData();
        }
        Send(SCID_APPLYGAME_ACK, ERROR_OK, $_result);
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/27
     * Time: 11:43
     * Des: 取得战斗摘要
     */
    function getFightSummary($data)
    {
        if(empty($data->value->__RoomId))
        {
            Send(SCID_GET_SUMMARY_ACK, ERROR_OK);
        }
        $_roomId = $data->value->__RoomId;
        $_fightDataMode = new FightDataModel();
        if(empty($_fightDataMode) || !$_fightDataMode->init(Registry::getInstance()->get(CLIENT_ID), $_roomId))
        {
            Send(SCID_GET_SUMMARY_ACK, ERROR_SERVER);
        }

        $_backInfo = $_fightDataMode->getFightSummary();
        if(empty($_backInfo))
        {
            Send(SCID_GET_SUMMARY_ACK, ERROR_SERVER);
        }
        Send(SCID_GET_SUMMARY_ACK, ERROR_OK, $_backInfo);
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/4/27
     * Time: 11:44
     * Des: 取得战斗房间信息
     */
    function getFightRoomInfo($data)
    {
        if(empty($data->value->__FightRoomId))
        {
            Send(SCID_GET_SUMMARY_ACK, ERROR_OK);
        }

        $_roomId = $data->value->__FightRoomId;
        $_user = new PropertiesLogic();
        if(empty($_user))
        {
            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
        }

        $_userId = Registry::getInstance()->get(CLIENT_ID);
        $_userArr = $_user->roomTagHandle($_userId);
        if(empty($_userArr))
        {
            Send(SCID_APPLYGAME_ACK, ERROR_OK);
        }

        $_rooms = new FightRoomsLogic();
        if(empty($_rooms))
        {
            Send(SCID_APPLYGAME_ACK,ERROR_SERVER);
        }
        if(!$_rooms->init($_userArr[0], $_userArr[1]))
        {
            Send(SCID_APPLYGAME_ACK,ERROR_SERVER);
        }
        $_room = $_rooms->getRoomDataByRoomId($_roomId);
        $_roomData = new FightDataLogic();
        if(empty($_roomData))
        {
            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
        }
        if(!$_roomData->initPvpRoom($_userArr[0], $_room))
        {
            Send(SCID_APPLYGAME_ACK, ERROR_SERVER);
        }

        $_backInfo = new SC_FIGHT_ROOM_INFO_ACK();
        $_backInfo->__FightRoomId = $_roomId;
        $_backInfo->__HomeUserId = $_room[DATA_BASE_FIGHTROOMS_HOMEUSERID];
        $_backInfo->__AwayUserId = $_room[DATA_BASE_FIGHTROOMS_AWAYUSERID];
        $_backInfo->__HomeScore = $_room[DATA_BASE_FIGHTROOMS_TOTALHOMESCORE];
        $_backInfo->__AwayScore = $_room[DATA_BASE_FIGHTROOMS_TOTALAWAYSCORE];
        $_backInfo->__StartEventPoint = $_roomData->getStartEventId();

        Send(SCID_FIGHT_ROOM_INFO_ACK, ERROR_OK, $_backInfo);
    }

    function getFightStatistics($data)
    {
        if(empty($data->value->__RoomId))
        {
            Send(SCID_FIGHT_STATISTICS_ACK, ERROR_SERVER);
        }

        $_gameStatisticsModel = new GameStatisticsModel();
        if(empty($_gameStatisticsModel) || !$_gameStatisticsModel->init())
        {
            Send(SCID_FIGHT_STATISTICS_ACK, ERROR_SERVER);
        }

        $_roomId = $data->value->__RoomId;
        $_backArr = $_gameStatisticsModel->getGameStatisticsByRoomId($_roomId);
        if(empty($_backArr))
        {
            Send(SCID_FIGHT_STATISTICS_ACK, ERROR_SERVER);
        }

        $_backInfo = new SC_FIGHT_STATISTICS_ACK();
        $_backInfo->__HomeStatistics = $_backArr[0];
        $_backInfo->__AwayStatistics = $_backArr[1];

        Send(SCID_FIGHT_STATISTICS_ACK, ERROR_OK, $_backInfo);
    }
//    function cleanRoomData()
//    {
//        $_userId = Registry::getInstance()->get(CLIENT_ID);
//        ST($_userId , DATA_BASE_PROPERTIES .$_userId, null);
//        ST($_userId , DATA_BASE_PROPERTIES ."12", null);
//        $_user = new PropertiesLogic($_userId);
//        $_roomId = $_user->getPlayerDataByField(DATA_BASE_PROPERTIES_PVPROOMID);
//        if(empty($_roomId))
//        {
//            exit();
//        }
//        $this->_roomsLogic->initPvpRoom($_roomId);
//        $this->_roomsLogic->destoryPvpRoom();
//    }
}