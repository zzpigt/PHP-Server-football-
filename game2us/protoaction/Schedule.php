<?php

include_once(APP_LOGIC_PATH."ScheduleLogic.php");

/**
 * @date: 2017年4月19日 下午5:25:01
 * @author: meishuijing
 * @desc: 赛程相关协议处理
 */
class Schedule
{
    function getMySchedule($data)
    {
    	$req = $data->value;
    	if(!isset($req->__Week))
    		Send(SCID_GET_MY_SCHEDULE_ACK, ERROR_SERVER);
    	
    	$userId = Registry::getInstance()->get(CLIENT_ID);
    	if(!$userId)
    		Send(SCID_GET_MY_SCHEDULE_ACK, ERROR_SERVER);
    	
    	$ack = new SC_GET_MY_SCHEDULE_ACK();
    	if(!$ack)
    		Send(SCID_GET_MY_SCHEDULE_ACK, ERROR_SERVER);
    	
    	$scheduleLogic = new ScheduleLogic();
    	if(!$scheduleLogic || !$scheduleLogic->init($userId))
    		Send(SCID_GET_MY_SCHEDULE_ACK, ERROR_SERVER);
    	
    	$schedule = $scheduleLogic->getSchedule($req->__Week);
    	$ack->__Week = $schedule["week"];
    	$ack->__LeagueSchedule = $schedule["leagueSchedule"];
    	
        Send(SCID_GET_MY_SCHEDULE_ACK, ERROR_OK, $ack);
    }
    
    function modifySchedule($data)
    {
    	$req = $data->value;
    	if(!isset($req->__RoomId) || !isset($req->__StartTime))
    		Send(SCID_MODIFY_SCHEDULE_ACK, ERROR_SERVER);
    	
    	$userId = Registry::getInstance()->get(CLIENT_ID);
    	if(!$userId)
    		Send(SCID_MODIFY_SCHEDULE_ACK, ERROR_SERVER);
    	
    	$scheduleLogic = new ScheduleLogic();
    	if(!$scheduleLogic || !$scheduleLogic->init($userId))
    		Send(SCID_MODIFY_SCHEDULE_ACK, ERROR_SERVER);
    	
    	if($scheduleLogic->isLocked($req->__RoomId))
    	{
    		Send(SCID_MODIFY_SCHEDULE_ACK, ERROR_MODIFY_LOCKED_SCHEDULE);
    	}
    	
    	$scheduleLogic->modifySchedule($req->__RoomId, $req->__StartTime);
    	 
    	Send(SCID_MODIFY_SCHEDULE_ACK, ERROR_OK, new SC_MODIFY_SCHEDULE_ACK());
    } 
    
    function lockSchedule($data)
    {
    	$req = $data->value;
    	if(!isset($req->__RoomId))
    		Send(SCID_LOCK_SCHEDULE_ACK, ERROR_SERVER);
    	 
    	$userId = Registry::getInstance()->get(CLIENT_ID);
    	if(!$userId)
    		Send(SCID_LOCK_SCHEDULE_ACK, ERROR_SERVER);
    	 
    	$scheduleLogic = new ScheduleLogic();
    	if(!$scheduleLogic || !$scheduleLogic->init($userId))
    		Send(SCID_LOCK_SCHEDULE_ACK, ERROR_SERVER);
    	 
    	$scheduleLogic->lockSchedule($req->__RoomId);
    	
    	Send(SCID_LOCK_SCHEDULE_ACK, ERROR_OK, new SC_LOCK_SCHEDULE_ACK());
    }
	
    
    function getRoomTimeList($data)
    {
    	$req = $data->value;
    	if(!isset($req->__RoomId))
    		Send(SCID_GET_GAME_TIME_LIST_ACK, ERROR_SERVER);
    	
    	$userId = Registry::getInstance()->get(CLIENT_ID);
    	if(!$userId)
    		Send(SCID_GET_GAME_TIME_LIST_ACK, ERROR_SERVER);
    	
    	$scheduleLogic = new ScheduleLogic();
    	if(!$scheduleLogic || !$scheduleLogic->init($userId))
    		Send(SCID_GET_GAME_TIME_LIST_ACK, ERROR_SERVER);
    	
    	$timeList = Array();
    	if(!$scheduleLogic->getTimeList($userId, $req->__RoomId, $timeList))
    	{
    		Send(SCID_GET_GAME_TIME_LIST_ACK, ERROR_SERVER);
    	}
    	
    	$ack = new SC_GET_GAME_TIME_LIST_ACK;
    	$ack->__TimeList = $timeList;
    	
    	Send(SCID_LOCK_SCHEDULE_ACK, ERROR_OK, $ack);
    }
}