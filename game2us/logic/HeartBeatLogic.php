<?php


class HeartBeatLogic
{
	
	function addMessage($userId, $message, $err = null, $data = null)
	{
		$playerModel = new $playerModel();
		if($playerModel && $playerModel->init($userId))
		{
			$proto = array("msgid"=>$message, "err"=>$err, "data"=>$data);
			$user->addHeartBeatSync(array($proto));
		}
	}
}