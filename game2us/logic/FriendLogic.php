<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_MODEL_PATH."FriendListModel.php");
include_once(APP_PROTO_PATH."proto.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/2/15
 * Time: 17:15
 */
class FriendLogic
{
    private $_friendModel;

    function isCreate($userId)
    {
        $friendListModel = FriendListModelMgr::Instance()->getModelByPrimary($userId);
        if(!$friendListModel)
            return false;
        $this->_friendModel = $friendListModel;
        return true;
    }

    private function _getFriendStrut($friendInfo)
    {
        $_friendList = array();

        $_friendList[DATA_BASE_FRIENDLIST_USERID] = $this->_friendModel->getPrimaryValue();
        $_friendList[DATA_BASE_FRIENDLIST_FRIENDID] = $friendInfo[DATA_BASE_FRIENDLIST_FRIENDID];
        $_friendList[DATA_BASE_FRIENDLIST_NICK] = $friendInfo[DATA_BASE_FRIENDLIST_NICK];
        $_friendList[DATA_BASE_FRIENDLIST_CLUB] = $friendInfo[DATA_BASE_FRIENDLIST_CLUB];
        return $_friendList;
    }

    function addFriend($friendInfo)
    {
        if(empty($friendInfo))
        {
            return null;
        }
        $_friendInfo = $this->_getFriendStrut($friendInfo);
        $_backInfo = FriendListModelMgr::Instance()->addSingleData($_friendInfo);
        if(!empty($_backInfo))
        {
            return $_backInfo;
        }
        return null;
    }

//    function deleteFriend($friendId)
//    {
//        if(empty($friendId))
//        {
//            return false;
//        }
//        return $this->_friendModel->deleteFriend($friendId);
//    }

    function getFriendList()
    {
        return $this->_friendModel->getFriendList();
    }

    function isFriend($friendId)
    {
        $_friendIndex = $this->_friendModel->getFriendIndex($friendId);
        if(isset($_friendIndex))
        {
            return true;
        }
        return false;
    }
}