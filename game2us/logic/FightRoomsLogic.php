<?php
include_once(APP_MODEL_PATH."FightRoomsModel.php");
include_once(APP_LOGIC_PATH."LeagueLogic.php");
include_once(APP_LOGIC_PATH."FightDataLogic.php");
include_once(APP_LOGIC_PATH."PropertiesLogic.php");
include_once(APP_PATH."PollingMgr.php");
include_once(APP_MODEL_PATH."LeagueScheduleModel.php");

/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/3/18
 * Time: 15:25
 */
define("FIGHT_ROOMS_TYPE_LEAGUE", 1) ;

class FightRoomsLogic
{
    private $_homeUserId;
    private $_awayUserId;

    private $_fightRoomsModel;


    function init($homeUserId, $awayUserId)
    {
        $this->_fightRoomsModel = new FightRoomsModel();
        if(empty($this->_fightRoomsModel) || !$this->_fightRoomsModel->init($homeUserId))
        {
            return false;
        }

        $this->_homeUserId = $homeUserId;
        $this->_awayUserId = $awayUserId;
        return true;
    }
    
    static function queryByRoomId()
    {
        
    }

    private function _getFightRoomStrut($startTime, $type = null, $param = null)
    {
        $_roomList = array();

        $_roomList[DATA_BASE_FIGHTROOMS_HOMEUSERID] = $this->_homeUserId;
        $_roomList[DATA_BASE_FIGHTROOMS_AWAYUSERID] = $this->_awayUserId;
        if($startTime)
            $_roomList[DATA_BASE_FIGHTROOMS_STARTTIME] = $startTime;
        else
            $_roomList[DATA_BASE_FIGHTROOMS_STARTTIME] = time();
        
        $_roomList[DATA_BASE_FIGHTROOMS_STATUE] = GAME_STATUS_TYPE_WAITING;
        $_roomList[DATA_BASE_FIGHTROOMS_TYPE] = $type;
        $_roomList[DATA_BASE_FIGHTROOMS_PARAM] = $param;
        
        return $_roomList;
    }

    function addFightRoom($startTime = null, $type = null, $param = null)
    {
        $newRoom = $this->_getFightRoomStrut($startTime, $type, $param);
        if($this->_fightRoomsModel->insertRoomData($newRoom))
        {
            return true;
        }
        return false;
    }

    function updateFightRoomsData($roomId, $index)
    {
        return $this->_fightRoomsModel->updateRoomData($roomId, $index);
    }
    
    function getModel()
    {
        return $this->_fightRoomsModel;
    }

    function getFightRoomData()//取得房间信息
    {
        return $this->_fightRoomsModel->getRoomData();
    }

    function getMaxFightRoomIndex()//取得最新房间的Index
    {
        return count($this->_fightRoomsModel->getRoomData())-1;
    }
    
    function getRoomDataByUserId($homeUserId, $awayUserId)
    {
        $_data = $this->_fightRoomsModel->data();
        $_key = null;
        foreach ($_data as $key => $room)
        {
            if($room[DATA_BASE_FIGHTROOMS_HOMEUSERID] == $homeUserId && $room[DATA_BASE_FIGHTROOMS_AWAYUSERID] == $awayUserId)
            {
                $_key = $key;
            }
        }
        return $_key;
    }

    function getRoomDataByRoomId($roomId)
    {
        $_data = $this->_fightRoomsModel->data();
        foreach ($_data as $key => $room)
        {
            if($room[DATA_BASE_FIGHTROOMS_UID] == $roomId)
            {
                return $room;
            }
        }
        return null;
    }

    function getFightHomeUserId()
    {
        return $this->_homeUserId;
    }

    function getFightAwayUserId()
    {
        return $this->_awayUserId;
    }

    function getRoomIndexByRoomId($roomId)
    {
        $_data = $this->_fightRoomsModel->data();
        foreach ($_data as $key => $room)
        {
            if($room[DATA_BASE_FIGHTROOMS_UID] == $roomId)
            {
                return $key;
            }
        }
        return null;
    }

    function setScore($index, $homeScore, $awayScore)
    {
        $this->_fightRoomsModel->setFieldByIndex(DATA_BASE_FIGHTROOMS_TOTALHOMESCORE, $homeScore, $index);
        $this->_fightRoomsModel->setFieldByIndex(DATA_BASE_FIGHTROOMS_TOTALAWAYSCORE, $awayScore, $index);
    }

    function fightStart($index)
    {
        $this->_fightRoomsModel->setFieldByIndex(DATA_BASE_FIGHTROOMS_STATUE, GAME_STATUS_TYPE_GAMEING, $index);
    }

    function fightEnd($roomId, $index)
    {
        $this->_fightRoomsModel->setFieldByIndex(DATA_BASE_FIGHTROOMS_STATUE, GAME_STATUS_TYPE_FINISH, $index);
        $this->beFinishFight($roomId);
    }

    function bespeakFight($roomId, $startTime, $param)
    {
        $param1 = Array();
        $param1["roomId"] = $roomId;
        $param1["startTime"] =  $startTime;

        $param1["homeUserId"] =  $this->_homeUserId;
        $param1["awayUserId"] =  $this->_awayUserId;
        $param1["param"] = $param;

        $polling = new PollingMgr();
        $polling->PollingPush(POLLING_TYPE_TIMEING, "FightRoomsLogic::callBack", $param1, $startTime);
    }

    static function callBack($param)
    {
        writeLog(LOG_LEVEL_NORMAL, $param, "FightStart".__LINE__);
        $_roomData = new FightDataLogic();
        if(empty($_roomData))
        {
            writeLog(LOG_LEVEL_NORMAL, $param, "FightRoom".__LINE__);
            return;
        }

        $res = LeagueScheduleModel::queryByRoom($param["roomId"], LeagueLogic::getLeagueIndex());
        if(!$res)
        {
            writeLog(LOG_LEVEL_NORMAL, $res, "FightRoom".__LINE__);
            return;
        }

        if($res[0]["starttime"] != $param["startTime"])
        {
            writeLog(LOG_LEVEL_NORMAL, $res, "FightRoom".__LINE__);
            return;
        }

        $rooms = new FightRoomsLogic();
        if(!$rooms || !$rooms->init($param["homeUserId"], $param["awayUserId"]))
        {
            writeLog(LOG_LEVEL_ERROR, $res, "FightRoom".__LINE__);
            return;
        }

        $index = $rooms->getRoomIndexByRoomId($param["roomId"]);
        $rooms->fightStart($index);
        if(!$rooms->updateFightRoomsData($param["roomId"], $index))
        {
            writeLog(LOG_LEVEL_ERROR, $param["roomId"], "FightRoom".__LINE__);
            return;
        }
        writeLog(LOG_LEVEL_NORMAL, $param["roomId"], "FightStart".__LINE__);
//      $room = $rooms->getFightRoomData()[$index];
//      $room[DATA_BASE_FIGHTROOMS_HOMEUSERID] = $param["homeUserId"];
//      $room[DATA_BASE_FIGHTROOMS_AWAYUSERID] = $param["awayUserId"];
//      $room[DATA_BASE_FIGHTROOMS_UID] = $param["roomId"];

        $_userA = PropertiesModelMgr::Instance()->getModelByPrimary($param["homeUserId"]);
        if(empty($_userA))
        {
            return false;
        }

        $_userB = PropertiesModelMgr::Instance()->getModelByPrimary($param["awayUserId"]);
        if(empty($_userA))
        {
            return false;
        }

        $_roomTag = $param["homeUserId"] . "|" . $param["awayUserId"];
        $_userA->setFieldByIndex(DATA_BASE_PROPERTIES_PVPROOMID, $_roomTag);
        $_userA->DB_update1();

        $_userB->setFieldByIndex(DATA_BASE_PROPERTIES_PVPROOMID, $_roomTag);
        $_userB->DB_update1();

//      if(!$_roomData->initPvpRoom($param["homeUserId"], $room))
//      {
//          writeLog(LOG_LEVEL_NORMAL, $param["homeUserId"], __LINE__);
//          return;
//      }
        writeLog(LOG_LEVEL_NORMAL, $param["homeUserId"], __LINE__);
//      $_result = $_roomData->getPvpFightResult(0, $param["param"]["callBack"], $param["param"]["param"], $_isUpdate);
        call_user_func($param["param"]["callBack"], $param["param"]["param"]);
        
//      if($_result)
//      {
//          $attach1 = MemInfoLogic::Instance()->getMemData(HEART_BEAT_ATTACH_PACKAGE."_".$param["homeUserId"]);
//          if(!$attach1)
//              $attach1 = Array();
//          $attach1[] = array(SCID_APPLYGAME_ACK, $_result);
//          MemInfoLogic::Instance()->setMemData(HEART_BEAT_ATTACH_PACKAGE."_".$param["homeUserId"], $attach1);
//
//          $attach2 = MemInfoLogic::Instance()->getMemData(HEART_BEAT_ATTACH_PACKAGE."_".$param["awayUserId"]);
//          if(!$attach2)
//              $attach2 = Array();
//          $attach2[] = array(SCID_APPLYGAME_ACK, $_result);
//          MemInfoLogic::Instance()->setMemData(HEART_BEAT_ATTACH_PACKAGE."_".$param["awayUserId"], $attach2);
//
//      }
        
    }

    function beFinishFight($roomId)
    {
        $param1 = Array();
        $param1["roomId"] = $roomId;

        $param1["homeUserId"] =  $this->_homeUserId;
        $param1["awayUserId"] =  $this->_awayUserId;
//      $param1["param"] = $param;

        self::fightFinish($param1);
    }

    static function fightFinish($param)
    {
        $playerLogic = new PlayerLogic();
        if($playerLogic && $playerLogic->init($param["homeUserId"]))
        {
            $leagueId = $playerLogic->getModel()->getFieldByIndex(DATA_BASE_PLAYER_LEAGUERID);
            //$_rooms->updateFightRoomsData($_roomData->getRoomId(), $_index);

            $leagueScheduleModel = new LeagueScheduleModel;
            if($leagueScheduleModel && $leagueScheduleModel->init($leagueId, LeagueLogic::getLeagueIndex()))
            {
                $data = $leagueScheduleModel->data();
                foreach($data as $v)
                {
                    if($v[DATA_BASE_LEAGUE_SCHEDULE_ROOMID] == $param["roomId"])
                    {
                        $one = new SLeagueScheduleInfo;
                        $one->__RoomId = $v[DATA_BASE_LEAGUE_SCHEDULE_ROOMID];
                        $one->__Round = $v[DATA_BASE_LEAGUE_SCHEDULE_ROUND];
                        $one->__NO = $v[DATA_BASE_LEAGUE_SCHEDULE_NO];
                        $one->__UserId1 = $v[DATA_BASE_LEAGUE_SCHEDULE_LEAGUER1];
                        $clubLogic1 = new ClubLogic();
                        if($clubLogic1 && $clubLogic1->init($one->__UserId1))
                        {
                            $one->__ClubName1 = $clubLogic1->getModel()->getFieldByIndex(DATA_BASE_CLUB_CLUBNAME);
                            $one->__TeamSign1 = $clubLogic1->getClubTeamSign();
                        }

                        $one->__UserId2 = $v[DATA_BASE_LEAGUE_SCHEDULE_LEAGUER2];
                        $clubLogic2 = new ClubLogic();
                        if($clubLogic2 && $clubLogic2->init($one->__UserId2))
                        {
                            $one->__ClubName2 = $clubLogic2->getModel()->getFieldByIndex(DATA_BASE_CLUB_CLUBNAME);
                            $one->__TeamSign2 = $clubLogic2->getClubTeamSign();
                        }

                        $score =  FightRoomsModel::getScore($one->__UserId1, $one->__RoomId);
                        $score1 = $score[0]["totalHomeScore"];
                        $score2 = $score[0]["totalAwayScore"];

                        $one->__StartTime = $v[DATA_BASE_LEAGUE_SCHEDULE_STARTTIME];
                        $one->__Status = GAME_STATUS_TYPE_FINISH;
                        $one->__Score = array($score1, $score2);
                        $one->__IsLocked = $v[DATA_BASE_LEAGUE_SCHEDULE_ISLOCKED];

                        $ntf = new SC_LEAGUE_SCHEDULE_NTF;
                        $ntf->__Schedule[] = $one;

                        writeLog(LOG_LEVEL_NORMAL, $ntf, "endNTF");

                        LeagueScheduleModel::updateStatusByRoom(LeagueLogic::getLeagueIndex(), $one->__RoomId, GAME_STATUS_TYPE_FINISH, $score1, $score2);

                        Send(SCID_LEAGUE_SCHEDULE_NTF, ERROR_OK, $ntf, false);
//
                        $attach2 = MemInfoLogic::Instance()->getMemData(HEART_BEAT_ATTACH_PACKAGE."_".$one->__UserId2);
                        if(!$attach2)
                            $attach2 = Array();
                        $attach2[] = array(SCID_LEAGUE_SCHEDULE_NTF, $ntf);
                        MemInfoLogic::Instance()->setMemData(HEART_BEAT_ATTACH_PACKAGE."_".$one->__UserId2, $attach2);
                        break;
                    }
                }
            }
        }
    }
    
    static function dealNotFinishGame($param)
    {
        global $DBConfig;
        for ($i = 0; $i < count($DBConfig); $i++)
        {
            $mysql = new MysqlDB();
            if(!$mysql)
                return; 
            
            if(!$mysql->initDB($DBConfig[$i], false))
                return;
            
            $res = $mysql->query("select * from `fightrooms` where statue != ".GAME_STATUS_TYPE_FINISH."  and unix_timestamp() >= (startTime + 900) limit 10;");
            if($res)
            {
                foreach($res as $v)
                {
                    $_roomData = new FightDataLogic();
                    if(empty($_roomData))
                    {
                        continue;
                    }
                    $room[DATA_BASE_FIGHTROOMS_HOMEUSERID] = $v["homeUserId"];
                    $room[DATA_BASE_FIGHTROOMS_AWAYUSERID] = $v["awayUserId"];
                    $room[DATA_BASE_FIGHTROOMS_UID] = $v["uId"];
                    $room[DATA_BASE_FIGHTROOMS_STATUE] = GAME_STATUS_TYPE_GAMEING;

                    $_eventTimeArr = $v["uId"];
                    if(!empty($_eventTimeArr))
                    {
                        $room[DATA_BASE_FIGHTROOMS_EVENTTIMEARR] = json_decode(gzuncompress(base64_decode($_eventTimeArr)), true);
                    }

                     
                    if(!$_roomData->initPvpRoom($v["homeUserId"], $room))
                    {
                        continue;
                    }
                    
                    $roomsParam = json_decode($v["param"]);
                    
                    $param["callBack"] = "LeagueLogic::callBack";
                    $param["param"] = Array("data"=>array($roomsParam->leagueId,$v["homeUserId"],$roomsParam->leagueIndex), "type"=>LEAGUE_CALL_BACK_TYPE_STATISTICS);
                        
                    $_result = $_roomData->getPvpFightResult($v["type"], $param["callBack"], $param["param"], true, $isUpdate);
                    
                    $score =  FightRoomsModel::getScore($v["homeUserId"], $v["uId"]);
                    $score1 = $score[0]["totalHomeScore"];
                    $score2 = $score[0]["totalAwayScore"];
                    LeagueScheduleModel::updateStatusByRoom($roomsParam->leagueIndex, $v["uId"], GAME_STATUS_TYPE_FINISH, $score1, $score2);

                    //临时清空赛程缓存
                    MemInfoLogic::Instance()->setMemData(DATA_BASE_LEAGUE_SCHEDULE, null, $roomsParam->leagueId, 0, "league");
                }
            }
        }
    }
}