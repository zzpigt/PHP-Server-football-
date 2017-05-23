<?php
include_once(getcwd()."/MyConstant.php");

class StaticConfig
{
	private $initArray = array();
	public function init()
	{
		$bInit = MemInfoLogic::Instance()->getMemData(CONFIG_STATIC_DATA);
		if(!$bInit)
		{
			$content = file_get_contents(CONFIG_STATIC);
			$this->initArray = my_xml_decode($content);
			MemInfoLogic::Instance()->setMemData(CONFIG_STATIC_DATA, $this->initArray);
		}
		else 
		{
			$this->initArray = $bInit;
		}
	}
	
	public function getConfig($param)
	{
		if(!isset($this->initArray[1][$param]))
			return false;
		return $this->initArray[1][$param];
	}
}