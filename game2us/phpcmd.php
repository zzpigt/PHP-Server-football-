<?php
include_once("MyConstant.php");
include_once(APP_PATH."PollingMgr.php");
include_once(APP_LOGIC_PATH."FightRoomsLogic.php");
include_once("ProtoAction.php");
include_once(APP_PROTO_PATH."proto.php");
include_once(APP_BASE_PATH."DataBaseField.php");
include_once('XmlConfigMgr.php');

define("POLLING_FILE_LOCK", "polling.lock");

$f = fopen(POLLING_FILE_LOCK, 'w+');
if(flock($f, LOCK_EX | LOCK_NB))
{
	XmlConfigMgr::getInstance()->init();
	MemInfoLogic::Instance()->setMemData(POLLING_LOCK, 0);
	$polling = new PollingMgr();
	$polling->Clear();
	$polling->PollingPush(POLLING_TYPE_ALWAYS, "FightRoomsLogic::dealNotFinishGame", array(), 30, time());
	$polling->PollingRun();
}
else
{
	echo "the program started!";
}



?>