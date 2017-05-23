<?php
include_once (getcwd()."/Registry.php");

$protoList = array();

//$protoList[协议号] = "协议类.方法";
$protoList[CSID_REGISTER_REQ] = "BaseProto.register";
$protoList[CSID_LOGIN_REQ] = "BaseProto.checkLogin";

$protoList[CSID_CREATE_REQ] = "Player.create";
$protoList[CSID_Property_REQ] = "Player.getPlayerInfo";
$protoList[CSID_FootballerInfo_REQ] = "Player.getCardsInfo";
$protoList[CSID_FootballerADD_REQ] = "Player.addCard";
$protoList[CSID_FootballerDestory_REQ] = "Player.delCard";
$protoList[CSID_FormationInfo_REQ] = "Player.getFormationInfo";
$protoList[CSID_FormationSet_REQ] = "Player.updateFieldPosition";
//$protoList[CSID_GETPLAYERINFO_REQ] = "Player.getPlayerPvpInfoByUserId";
$protoList[CSID_TACTICSGET_REQ] = "Player.getTactics";
$protoList[CSID_TACTICSSET_REQ] = "Player.updateTactics";

$protoList[CSID_APPLYGAME_REQ] = "PvpRoom.pvpStart";
$protoList[CSID_HeartBeat_REQ] = "PvpRoom.getPvpFightResult";
$protoList[CSID_GET_SUMMARY_REQ] = "PvpRoom.getFightSummary";
$protoList[CSID_FIGHT_ROOM_INFO_REQ] = "PvpRoom.getFightRoomInfo";
$protoList[CSID_FIGHT_STATISTICS_REQ] = "PvpRoom.getFightStatistics";


//$protoList[CSID_CREATECLUB_REQ] = "Club.createClub";
$protoList[CSID_UPDATECLUB_REQ] = "Club.updateClub";
$protoList[CSID_GETCLUBINFO_REQ] = "Club.getClubInfo";
$protoList[CSID_CLUBTEAMSIGN_REQ] = "Club.getTeamSign";
$protoList[CSID_UPDATECLUBTEAMSIGN_REQ] = "Club.updateTeamSign";
$protoList[CSID_CLUBSHIRT_REQ] = "Club.getJersey";
$protoList[CSID_UPDATECLUBSHIRT_REQ] = "Club.updateJersey";
$protoList[CSID_GETTROPHYLIST_REQ] = "Club.getTrophyList";
$protoList[CSID_ADDTROPHY_REQ] = "Club.addTrophy";

$protoList[CSID_Friend_REQ] = "Friend.getFriendList";
$protoList[CSID_FriendADD_REQ] = "Friend.addFriendList";
$protoList[CSID_FriendDestory_REQ] = "Friend.deleteFriendList";

//begin 联赛
$protoList[CSID_LEAGUERANK_REQ] = "League.getLeagueRank";
$protoList[CSID_LEAGUE_SCHEDULE_REQ] = "League.getLeagueSchedule";
$protoList[CSID_LEAGUE_FOOTBALLER_RANK_REQ] = "League.getLeagueFBRank";
//end 联赛

//begin 赛程
$protoList[CSID_GET_MY_SCHEDULE_REQ] = "Schedule.getMySchedule";
$protoList[CSID_MODIFY_SCHEDULE_REQ] = "Schedule.modifySchedule";
$protoList[CSID_LOCK_SCHEDULE_REQ] = "League.getLeagueFBRank";
//end 赛程

//beg 转会
$protoList[CSID_GET_RECOMMEND_CARD_REQ] = "Transfer.getCardRecommend";
$protoList[CSID_BUY_RECOMMEND_CARD_REQ] = "Transfer.buyCardRecommend";
$protoList[CSID_GET_SCOUT_REQ] = "Transfer.getScoutData";
$protoList[CSID_BUY_SCOUT_REQ] = "Transfer.buyScoutCard";
//end 转会

$protoList[CSID_REDPOINT_REQ] = "Player.getRedPoint";
$protoList[10000] = "Player.init";
$protoList[100000] = "Player.testAllFunc";
$protoList[100001] = "Player.cleanXmlCache";
$timer;

function execProto($data)
{
    printError($data,"into proto center");
    if(empty($data))
    {
        exit();
    }

    if($data->msgid != CSID_REGISTER_REQ and $data->msgid != CSID_LOGIN_REQ)
    {
        $userId = getUserId($data->token);
        printError($userId, "login success userId");
        if(empty($userId))
        {
            exit();
        }
        Registry::getInstance()->set(CLIENT_ID, $userId);

        if(!MemInfoLogic::Instance()->setMemData($data->token, $userId, null, 3600))
        {
            Send($data->msgid, ERROR_SERVER);
        }
    }

    global $protoList;
	$_pro = explode('.', $protoList[$data->msgid]);

    spl_autoload_register( 'loadBaseProto' );
    $_obj = new $_pro[0]();

//    list($usec, $sec) = explode(' ', microtime());
//    global $timer;
//    $timer = (float)$usec + (float)$sec;
    funcStart($data->msgid);

    printError("","into proto success");
    $_obj->$_pro[1]($data);
}

function loadBaseProto($class) {
    $file = APP_PROTOACTION_PATH.$class . '.php';
    if (is_file($file)) {
        include_once($file);
    }
}

//2017/5/16 修改内容：userId加密和解密
function getUserId($token)
{
    if(empty($token))
        return 0;

    $index = substr($token, 14);
    $_index= Security::decrypt($index,SECURITY_KEY);
    $userId = null;
    if($_index)
    {
        $userId = MemInfoLogic::Instance()->getMemData($token);
    }

    if(!empty($userId)) {
        return $userId;
    }
    return 0;
}

/*
 * 设置token
 */
function setToken($userId){
    if(empty($userId)){
        return 0;
    }
    //加密$userId
    $_userId = Security::encrypt($userId,SECURITY_KEY);
    //
    $token = mt_rand(time()/10, time());
    $token .= "|".$this->createChar(4).$_userId;
    return $token;
}

//随机字符
function createChar($length){
    $randStr = "";
    for($i=0;$i<$length;$i++){
        $randStr .=chr(mt_rand(65,122));
    }
    return $randStr;
}
