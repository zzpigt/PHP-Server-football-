<?php
/**
 * @date: 2017年4月13日 下午3:12:22
 * @author: meishuijing
 * @desc: 机器人类
 */
include_once(APP_LOGIC_PATH."ClubLogic.php");
include_once(APP_LOGIC_PATH."CardsLogic.php");
include_once(APP_LOGIC_PATH."FormationLogic.php");

class RobotLogic
{
	/**
	 * @date : 2017年4月13日 下午3:15:31
	 * @author : meishuijing
	 * @param : 
	 * @return : 
	 * @desc : 初始化一个机器人数据
	 */
	
	private $_userId;//用户id
	private $_leagueId;//联赛id
	private $_playerLogic;//角色对象逻辑
	private $_clubLogic;//俱乐部对象逻辑
	private $_cardLogic;//卡牌球员对象逻辑
	
	function init($userId = -1, $leagueId = 1, $leagueLevel = 1)
	{
		if(!is_int($userId))
		{
			return false;
		}
		
		if($userId == -1)
		{
			/**
			 * 申请userid
			 */
			$userId = ConfigLogic::Instance()->newUserId();
			if(!$userId)
			{
				return false;
			}
		}
		
		$this->_userId = $userId;
		
		$countryId = XmlConfigMgr::getInstance()->getCountryConfig()->RandCountryId();
		if(!$countryId)
		{
			return false;
		}
		
		$countryConfig = XmlConfigMgr::getInstance()->getCountryConfig()->findCountryConfig($countryId);
		if(!$countryConfig)
		{
			return false;
		}
		
		$nameConfig = XmlConfigMgr::getInstance()->getNameConfig()->getConfig();
		if(!$nameConfig)
		{
			return false;
		}
		
		$languageConfig = XmlConfigMgr::getInstance()->getLanguageConfig()->findConfig($countryConfig["LanguageType"]);
		if(!$languageConfig)
		{
			return false;
		}
		

		$name = "";
		$rand = 0;
		if(isset($languageConfig["GKey"]) && !empty($languageConfig["GKey"]))
		{
			$rand += $languageConfig["GUpperLimit"];
		}
		if(isset($languageConfig["DKey"]) && !empty($languageConfig["DKey"]))
		{
			$rand += $languageConfig["DUpperLimit"];
		}
		
		if($rand == 0)
		{
			return false;
		}
		
		$rand = mt_rand(1, $rand);
		$rand = sprintf("%03d", $rand);
		if(isset($languageConfig["GKey"]) && !empty($languageConfig["GKey"]))
		{
			if($rand <= $languageConfig["GUpperLimit"])
			{
				$nameConfig = XmlConfigMgr::getInstance()->getNameConfig()->findConfig($languageConfig["GKey"].$rand);
				if($nameConfig)
				{
					$stringNameConfig = XmlConfigMgr::getInstance()->getStringNameConfig()->findConfig($languageConfig["GKey"].$rand);
					if($stringNameConfig)
					{
						$name = $stringNameConfig[$languageConfig["LanguageIndex"]];
					}
				}
			}
			else
				$rand -= $languageConfig["GUpperLimit"];
		}
		if(isset($languageConfig["DKey"]) && !empty($languageConfig["DKey"]))
		{
			if($rand <= $languageConfig["DUpperLimit"])
			{
				$nameConfig = XmlConfigMgr::getInstance()->getNameConfig()->findConfig($languageConfig["DKey"].$rand);
				if($nameConfig)
				{

					$stringNameConfig = XmlConfigMgr::getInstance()->getStringNameConfig()->findConfig($languageConfig["DKey"].$rand);
					if($stringNameConfig)
					{
						$name = $stringNameConfig[$languageConfig["LanguageIndex"]];
					}
				}
			}
		}
		
		$playerLogic = new PlayerLogic();
		if(!$playerLogic)
		{
			return false;
		}

		if(!$playerLogic->init($userId))
		{
			return false;
			//如果初始化不成功，尝试去创建新的
		}
		
		if(!$playerLogic->isCreate())
		{
			if($playerLogic->addPlayer("", "", "", $leagueId, true))
				$this->_playerLogic = $playerLogic;
			else
			{
				return false;
			}
		}
		
		$leagueCreateConfig = XmlConfigMgr::getInstance()->getLeagueCreateConfig()->findConfig($leagueLevel);
		if(!$leagueCreateConfig)
		{
			return false;
		}
		
		$footballerCout = mt_rand($leagueCreateConfig["LowerLimit"], $leagueCreateConfig["UpperLimit"]);
		$coin = mt_rand($leagueCreateConfig["BudgetLowerLimit"], $leagueCreateConfig["BudgetUpperLimit"]);
		
		$leagueIndexSub = mt_rand($leagueCreateConfig["CreatLowerLimit"], $leagueCreateConfig["CreatUpperLimit"]);
		
		$leagueIndex = LeagueLogic::getLeagueIndex();
		if($leagueIndex <= $leagueIndexSub)
		{
			if($leagueIndex > 1)
				$leagueIndex -= 1;
		}
		else
			$leagueIndex -= $leagueIndexSub;
		
		$leagueTimeBetween = LeagueLogic::getLeagueIndexTime($leagueIndex);
		if(!$leagueTimeBetween)
		{
			return false;
		}
		
		$createTime = mt_rand($leagueTimeBetween[0], ($leagueTimeBetween[1] > time() ? time() : $leagueTimeBetween[1]));
		
		$clubLogic = new ClubLogic();
		if(!$clubLogic)
		{
			return false;
		}

		if(!$clubLogic->init($userId))
		{
			return false;
		}
		
		if(!$clubLogic->isCreate())
		{
			if($clubLogic->addClub($name, $name." FC", $name." FC Fans", $countryId, $countryConfig["ENG"], $createTime))
			{
				$this->_clubLogic = $clubLogic;
			}
			else
			{
				return false;
			}
		}
		
		$formationLogic = new FormationLogic();
		if(!$formationLogic || !$formationLogic->init($userId))
		{
			return false;
		}
		
		if(!$formationLogic->createUserFormation($footballerCout, $leagueLevel))
		{
			return false;
		}
		
		$cardLogic = new CardsLogic();
		if(!$cardLogic)
		{
			return false;
		}
		
		if(!$cardLogic->init($userId))
		{
			return false;
		}
		
		return true;	
	}
	
	function getUserId()
	{
		return $this->_userId;
	}
	
}