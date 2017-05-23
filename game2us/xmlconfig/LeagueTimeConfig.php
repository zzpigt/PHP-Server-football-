<?php
include_once(getcwd()."/MyConstant.php");

class LeagueTimeConfig
{
	private $initArray = array();
	public function init()
	{
		$bInit = MemInfoLogic::Instance()->getMemData(CONFIG_LEAGUETIME_DATA);
		if(!$bInit)
		{
			$content = file_get_contents(CONFIG_LEAGUETIME);
			$this->initArray = my_xml_decode($content);
			MemInfoLogic::Instance()->setMemData(CONFIG_LEAGUETIME_DATA, $this->initArray);
		}
		else 
		{
			$this->initArray = $bInit;
		}
	}
	
	public function getConfig()
	{
		return $this->initArray;
	}
}