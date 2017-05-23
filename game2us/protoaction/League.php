<?php

include_once(APP_LOGIC_PATH."LeagueLogic.php");

/**
 * @date: 2017年4月19日 下午5:25:01
 * @author: meishuijing
 * @desc: 联赛相关协议处理
 */
class League
{
    function getLeagueRank($data)
    {
    	$userId = Registry::getInstance()->get(CLIENT_ID);
    	if(!$userId)
    		Send(SCID_LEAGUE_RANK_ACK, ERROR_SERVER);
    	
    	$ack = new SC_LEAGUE_RANK_ACK();
    	if(!$ack)
    		Send(SCID_LEAGUE_RANK_ACK, ERROR_SERVER);
    	
    	$leagueLogic = new LeagueLogic();
    	if(!$leagueLogic || !$leagueLogic->init($userId))
    		Send(SCID_LEAGUE_RANK_ACK, ERROR_SERVER);
    	
    	$rank = $leagueLogic->getLeagueRank();
    	foreach ($rank as $v)
    	{
    		$ack->__LeagueRank[] = $v;
    	}
    	$ack->__LeagueRound = $leagueLogic->getLeagueRound();
    	
        Send(SCID_LEAGUE_RANK_ACK, ERROR_OK, $ack);
    }
    
    function getLeagueSchedule($data)
    {
    	$req = $data->value;
    	if(!isset($req->__UserId) || !isset($req->__Round) || !is_array($req->__Round))
    		Send(SCID_LEAGUE_SCHEDULE_ACK, ERROR_SERVER);
    	
    	$userId = Registry::getInstance()->get(CLIENT_ID);
    	if(!$userId)
    		Send(SCID_LEAGUE_SCHEDULE_ACK, ERROR_SERVER);
    	
    	$ack = new SC_LEAGUE_SCHEDULE_ACK();
    	if(!$ack)
    		Send(SCID_LEAGUE_SCHEDULE_ACK, ERROR_SERVER);
    	
    	$leagueLogic = new LeagueLogic();
    	if(!$leagueLogic || !$leagueLogic->init($userId))
    		Send(SCID_LEAGUE_SCHEDULE_ACK, ERROR_SERVER);
    	
    	$schedule = $leagueLogic->getLeagueSchedule($req->__Round);
    	foreach ($schedule as $v)
    	{
    		$ack->__Schedule[] = $v;
    	}
    	
    	Send(SCID_LEAGUE_SCHEDULE_ACK, ERROR_OK, $ack);
    }
    
    function getLeagueFBRank()
    {
    	$userId = Registry::getInstance()->get(CLIENT_ID);
    	if(!$userId)
    		Send(SCID_LEAGUE_FOOTBALLER_RANK_ACK, ERROR_SERVER);
    	
    	$ack = new SC_LEAGUE_FOOTBALLER_RANK_ACK();
    	if(!$ack)
    		Send(SCID_LEAGUE_FOOTBALLER_RANK_ACK, ERROR_SERVER);
    	
    	$leagueLogic = new LeagueLogic();
    	if(!$leagueLogic || !$leagueLogic->init($userId))
    		Send(SCID_LEAGUE_FOOTBALLER_RANK_ACK, ERROR_SERVER);
    	 
    	$rank = $leagueLogic->getLeagueFBRank();
    	if($rank)
    	{
    		foreach ($rank[LEAGUE_FB_RANK_TYPE_SHOOT] as $v)
    			$ack->__ShootRank[] = $v;
    		
    		foreach ($rank[LEAGUE_FB_RANK_TYPE_MARK] as $v)
    			$ack->__MarkRank[] = $v;
    		
    		foreach ($rank[LEAGUE_FB_RANK_TYPE_ASSISTS] as $v)
    			$ack->__AssistsRank[] = $v;
    	}
    	 
    	Send(SCID_LEAGUE_FOOTBALLER_RANK_ACK, ERROR_OK, $ack);
    }

}