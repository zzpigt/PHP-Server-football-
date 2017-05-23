<?php
include_once(APP_LOGIC_PATH."FriendLogic.php");
include_once(APP_LOGIC_PATH."PropertiesLogic.php");
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/15
 * Time: 17:31
 */
class friend
{
    function getFriendList()
    {
        $_friendLogic = new FriendLogic();
        if(empty($_friendLogic))
        {
            Send(SCID_Friend_ACK, ERROR_SERVER);
        }
        if(!$_friendLogic->isCreate(Registry::getInstance()->get(CLIENT_ID)))
        {
            Send(SCID_Friend_ACK, ERROR_SERVER);
        }
        Send(SCID_Friend_ACK, ERROR_OK, $_friendLogic->getFriendList());
    }

    function addFriendList($data)
    {
        $_friendId = $data->value->__FriendID;
        if(empty($_friendId))
        {
            Send(SCID_FriendADD_ACK, ERROR_OK, null);
        }

        $_userId = Registry::getInstance()->get(CLIENT_ID);
        if($_friendId == $_userId)
        {
            Send(SCID_FriendADD_ACK, ERROR_FRIEND_SELF, null);
        }
        $_friendLogic = new FriendLogic();
        if(empty($_friendLogic))
        {
            Send(SCID_FriendADD_ACK, ERROR_SERVER);
        }
        if(!$_friendLogic->isCreate($_userId))
        {
            Send(SCID_FriendADD_ACK, ERROR_SERVER);
        }
        if($_friendLogic->isFriend($_friendId))
        {
            Send(SCID_FriendADD_ACK, ERROR_FRIEND_HAD);
        }

        $_propertiesModelFriend = PropertiesModelMgr::Instance()->getModelByPrimary($_friendId);
        if(empty($_propertiesModelFriend))
        {
            Send(SCID_FriendADD_ACK, ERROR_SERVER);
        }

        $_userInfo = array();
        $_userInfo[DATA_BASE_FRIENDLIST_FRIENDID] = $_friendId;
        $_userInfo[DATA_BASE_FRIENDLIST_NICK] = $_propertiesModelFriend->getFieldByIndex(DATA_BASE_PROPERTIES_NICK);
        $_userInfo[DATA_BASE_FRIENDLIST_CLUB] = "";

        $_backInfo = $_friendLogic->addFriend($_userInfo);
        printError($_backInfo, "proto layer backinfo");
        unset($_userInfo);

        $_propertiesModelSelf = PropertiesModelMgr::Instance()->getModelByPrimary($_userId);
        $_userInfo = array();
        $_userInfo[DATA_BASE_FRIENDLIST_FRIENDID] = $_userId;
        $_userInfo[DATA_BASE_FRIENDLIST_NICK] = $_propertiesModelSelf->getFieldByIndex(DATA_BASE_PROPERTIES_NICK);
        $_userInfo[DATA_BASE_FRIENDLIST_CLUB] = "";

        $_friendLogic = new FriendLogic();
        if(empty($_friendLogic))
        {
            Send(SCID_FriendADD_ACK, ERROR_SERVER);
        }
        if(!$_friendLogic->isCreate($_friendId))
        {
            Send(SCID_FriendADD_ACK, ERROR_SERVER);
        }
        $_friendLogic->addFriend($_userInfo);
        Send(SCID_FriendADD_ACK, ERROR_OK, $_backInfo);
    }

    //之后删除好友改为修改状态
    function deleteFriendList($data)
    {
//        $_friendId = $data->value->__FriendID;
//        if(empty($_friendId))
//        {
            Send(SCID_FriendDestory_ACK, ERROR_OK, null);
//        }
//
//        $_userId = Registry::getInstance()->get(CLIENT_ID);
//        if($_friendId == $_userId)
//        {
//            Send(SCID_FriendDestory_ACK, ERROR_FRIEND_NOHAVE, null);
//        }
//
//        $_friendLogic = new FriendLogic();
//        if(empty($_friendLogic))
//        {
//            Send(SCID_FriendDestory_ACK, ERROR_SERVER);
//        }
//        if(!$_friendLogic->isCreate($_userId))
//        {
//            Send(SCID_FriendDestory_ACK, ERROR_SERVER);
//        }
//        if(!$_friendLogic->isFriend($_friendId))
//        {
//            Send(SCID_FriendDestory_ACK, ERROR_FRIEND_NOHAVE, null);
//        }
//        $_isSelfSucess = $_friendLogic->deleteFriend($_friendId);
//
//        $_friendLogic = new FriendLogic();
//        if(empty($_friendLogic))
//        {
//            Send(SCID_FriendDestory_ACK, ERROR_SERVER);
//        }
//        if(!$_friendLogic->isCreate($_friendId))
//        {
//            Send(SCID_FriendDestory_ACK, ERROR_SERVER);
//        }
//        $_isFriendSucess = $_friendLogic->deleteFriend($_userId);
//
//        $_backInfo = new SC_FriendDestory_ACK();
//        if($_isFriendSucess and $_isSelfSucess)
//        {
//            $_backInfo->__isSuccess = 1;
//            Send(SCID_FriendDestory_ACK, ERROR_OK, $_backInfo);
//        }
//        else
//        {
//            printError("friend do fail:" . $_isFriendSucess .":". $_isSelfSucess, __CLASS__);
//        }
//        $_backInfo->__isSuccess = 0;
//        Send(SCID_FriendDestory_ACK, ERROR_OK, $_backInfo);
    }
}