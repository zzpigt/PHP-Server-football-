<?php
include_once(getcwd()."/MyConstant.php");

class CountryConfig
{
	private $initArray = array();
	public function init()
	{
		$bInit = MemInfoLogic::Instance()->getMemData(CONFIG_COUNTRY_DATA);
		if(!$bInit)
		{
			$content = file_get_contents(CONFIG_COUNTRY);
			$this->initArray = my_xml_decode($content);
			MemInfoLogic::Instance()->setMemData(CONFIG_COUNTRY_DATA, $this->initArray);
		}
		else
		{
			$this->initArray = $bInit;
		}
	}

	public function getArray()
	{
		return $this->initArray;
	}

	public function findCountryConfig($key)
	{
		if(empty($this->initArray[$key]))
		{
			return null;
		}
		return $this->initArray[$key];
	}
	
	public function RandCountryId()
	{
		return array_rand($this->initArray, 1);
	}
}