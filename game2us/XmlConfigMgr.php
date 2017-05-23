<?php
include_once("MyConstant.php");
include_once(APP_XMLCONFIG_PATH.'PlayerDataConfig.php');
include_once(APP_XMLCONFIG_PATH.'FieldPositionConfig.php');
include_once(APP_XMLCONFIG_PATH.'EventDataConfig.php');
include_once(APP_XMLCONFIG_PATH.'ConstDataConfig.php');
include_once(APP_XMLCONFIG_PATH.'FieldDistanceConfig.php');
include_once(APP_XMLCONFIG_PATH.'PlayerPositionConfig.php');
include_once(APP_XMLCONFIG_PATH.'ShirtSetConfig.php');
include_once(APP_XMLCONFIG_PATH.'ColorDataConfig.php');
include_once(APP_XMLCONFIG_PATH.'CountryConfig.php');
include_once(APP_XMLCONFIG_PATH.'StaticConfig.php');
include_once(APP_XMLCONFIG_PATH.'LeagueTimeConfig.php');
include_once(APP_XMLCONFIG_PATH.'FormationCreateConfig.php');
include_once(APP_XMLCONFIG_PATH.'LeagueCreateConfig.php');
include_once(APP_XMLCONFIG_PATH.'PlayerCreateConfig.php');
include_once(APP_XMLCONFIG_PATH.'PositionCreateConfig.php');
include_once(APP_XMLCONFIG_PATH.'NameConfig.php');
include_once(APP_XMLCONFIG_PATH.'LanguageConfig.php');
include_once(APP_XMLCONFIG_PATH.'StringNameConfig.php');

class XmlConfigMgr
{
	private static $_instance;
	private $oPlayerDataConfig;//卡牌配置表
	private $oFieldPositionConfig;//站位配置表
	private $oEventDataConfig;//事件链配置表
	private $oConstDataConfig;//事件常量配置表
	private $oFieldDistanceConfig;//站位距离配置表
	private $oPlayerPositionConfig;//卡牌站位配置表
	private $oShirtSetConfig;//条纹配置表
	private $oColorDataConfig;//颜色配置表
	private $oCountryConfig;//俱乐部配置表
	private $oStaticConfig;//静态变量配置
	private $oLeaguTimeConfig;//联赛时间安排配置表
	private $oFormationConfig;//球队阵型初始化配置表
	private $oLeagueCreateConfig;//联赛初始化配置表
	private $oPlayerCreateConfig;//球员初始化配置表
	private $oPositionCreateConfig;//球员位置初始化配置表
	private $oNameConfig;//球员的名字配置表
	private $oLanguageConfig;//语言配置表
	private $oStringNameConfig;//名字配置表
	
	function __construct()
	{
		$this->oPlayerDataConfig = new PlayerDataConfig();
		$this->oFieldPositionConfig = new FieldPositionConfig();
		$this->oEventDataConfig = new EventDataConfig();
		$this->oConstDataConfig = new ConstDataConfig();
		$this->oFieldDistanceConfig = new FieldDistanceConfig();
		$this->oPlayerPositionConfig = new PlayerPositionConfig();
		$this->oShirtSetConfig = new ShirtSetConfig();
		$this->oColorDataConfig = new ColorDataConfig();
		$this->oCountryConfig = new CountryConfig();
		$this->oStaticConfig = new StaticConfig();
		$this->oLeaguTimeConfig = new LeagueTimeConfig();
		$this->oFormationConfig = new FormationCreateConfig();
		$this->oLeagueCreateConfig = new LeagueCreateConfig();
		$this->oPlayerCreateConfig = new PlayerCreateConfig();
		$this->oPositionCreateConfig = new PositionCreateConfig();
		$this->oNameConfig = new NameConfig();
		$this->oLanguageConfig = new LanguageConfig();
		$this->oStringNameConfig = new StringNameConfig();
	}
	
	public function init()
	{
		$this->oPlayerDataConfig->init();
		$this->oFieldPositionConfig->init();
		$this->oEventDataConfig->init();
		$this->oConstDataConfig->init();
		$this->oFieldDistanceConfig->init();
		$this->oPlayerPositionConfig->init();
		$this->oShirtSetConfig->init();
		$this->oColorDataConfig->init();
		$this->oCountryConfig->init();
		$this->oStaticConfig->init();
		$this->oLeaguTimeConfig->init();
		$this->oFormationConfig->init();
		$this->oLeagueCreateConfig->init();
		$this->oPlayerCreateConfig->init();
		$this->oPositionCreateConfig->init();
		$this->oNameConfig->init();
		$this->oLanguageConfig->init();
		$this->oStringNameConfig->init();
	}
	
	static public function getInstance()
	{
		if (!self::$_instance instanceof self) {
			self::$_instance = new self();
		}
	
		return self::$_instance;
	}

	public 	function getPlayerDataConfig()
	{
		return $this->oPlayerDataConfig;
	}

	public 	function getFieldPositionConfig()
	{
		return $this->oFieldPositionConfig;
	}

	public 	function getEventDataConfig()
	{
		return $this->oEventDataConfig;
	}

	public 	function getConstDataConfig()
	{
		return $this->oConstDataConfig;
	}

	public 	function getFieldDistanceConfig()
	{
		return $this->oFieldDistanceConfig;
	}

	public 	function getPlayerPositionConfig()
	{
		return $this->oPlayerPositionConfig;
	}

	public 	function getShirtSetConfig()
	{
		return $this->oShirtSetConfig;
	}

	public 	function getColorDataConfig()
	{
		return $this->oColorDataConfig;
	}

	public function getCountryConfig()
	{
		return $this->oCountryConfig;
	}
	
	public function getStaticConfig()
	{
		return $this->oStaticConfig;
	}
	
	public function getLeagueTimeConfig()
	{
		return $this->oLeaguTimeConfig;
	}
	
	public function getFormationCreateConfig()
	{
		return $this->oFormationConfig;
	}
	
	public function getLeagueCreateConfig()
	{
		return $this->oLeagueCreateConfig;
	}
	
	public function getPlayerCreateConfig()
	{
		return $this->oPlayerCreateConfig;
	}
	
	public function getPositionCreateConfig()
	{
		return $this->oPositionCreateConfig;
	}
	
	public function getNameConfig()
	{
		return $this->oNameConfig;
	}
	
	public function getLanguageConfig()
	{
		return $this->oLanguageConfig;
	}
	
	public function getStringNameConfig()
	{
		return $this->oStringNameConfig;
	}
}
	
