 <?php
const ERROR_OK = 0;
const ERROR_LOGIN = 1;
const ERROR_CREATE = 2;
const ERROR_NEED_LOGIN = 3;
const ERROR_NEED_CREATE = 4;
const ERROR_REPEAT_NAME = 5;
const ERROR_NAME_LENGTH = 6;
const ERROR_ONLINE = 7;
const ERROR_REGISTER = 8;
const ERROR_USERNAME_REGISTERED = 9;
const ERROR_USER_NAME_LENGTH = 10;
const ERROR_USER_PWD_LENGTH = 11;
const ERROR_NAME_HAVED = 12;
const ERROR_NOT_FIND_CARD = 30;
const ERROR_NOT_HAVE_CARD = 31;
const ERROR_FORMATION_CHANGE = 32;
const ERROR_FORMATION_NOTFIND = 33;
const ERROR_USER_LEVEL_FULL = 34;
const ERROR_NOT_FIND_COUNTRY = 35;
const ERROR_UPGRADE_LEVEL_EXPZROE = 36;
const ERROR_CARD_FULL_LEVEL = 37;
const ERROR_CARD_FULL_STAR = 38;
const ERROR_UPGRADE_STAR_MONEYZROE = 39;
const ERROR_UPGRADE_STAR_MATERIAL = 40;
const ERROR_MATERIAL_NOTFIND = 41;
const ERROR_FRAGMENT_NOTFIND = 42;
const ERROR_EQUIP_NOTFIND = 43;
const ERROR_LOOT_LOGIN_REWARD = 44;
const ERROR_LOOTED_LOGIN_REWARD = 45;
const ERROR_ACTIVE_MAP_TIME = 46;
const ERROR_OPEN_MAP = 47;
const ERROR_OPEN_CHILD_MAP = 48;
const ERROR_POWER_NOT_ENOUGH = 49;
const ERROR_CHILD_MAP_LIMIT_USED = 50;
const ERROR_FIGHT = 51;
const ERROR_CARDS_COUNT_LIMIT = 52;
const ERROR_EQUIPS_COUNT_LIMIT = 53;
const ERROR_NOT_HAVE_EQUIP = 54;
const ERROR_EQUIP_FULL_LEVEL = 55;
const ERROR_FREE_SUMMON = 56;
const ERROR_FV_NUMBER = 57;
const ERROR_MONEY_NUMBER = 58;
const ERROR_RMB_NUMBER = 59;
const ERROR_CARD_WORK = 60;
const ERROR_PVP_SELF_FIGHT = 100;
const ERROR_PVP_ENEMY_FIGHT = 101;
const ERROR_PVP_NO_USER = 102;
const ERROR_FRIEND_SELF = 200;
const ERROR_FRIEND_HAD = 201;
const ERROR_FRIEND_NOHAVE = 202;
const ERROR_NOT_FIND_TYPE = 1000;
const ERROR_SERVER = 1001;
const ERROR_LEVEL_NOT_UP = 1002;


const USER_DATA_CARDS_NATIONALITY = 3;
const USER_DATA_CARDS_NAME = 4;
const USER_DATA_CARDS_FAMILYNAME = 5;
const USER_DATA_CARDS_HEIGHT = 6;
const USER_DATA_CARDS_WEIGHT = 7;
const USER_DATA_CARDS_POSITION1 = 8;
const USER_DATA_CARDS_POSITION2 = 9;
const USER_DATA_CARDS_POSITION3 = 10;
const USER_DATA_CARDS_PREFERREDFOOT = 11;
const USER_DATA_CARDS_FEILDPOSITION = 12;
const USER_DATA_CARDS_AGE = 13;
const USER_DATA_CARDS_RETIREAGE = 14;
const USER_DATA_CARDS_CLUB = 15;
const USER_DATA_CARDS_VALUE = 16;
const USER_DATA_CARDS_WAGE = 17;
const USER_DATA_CARDS_NUMBER = 18;
const USER_DATA_CARDS_CONTRATVALIDUNTIL = 19;
const USER_DATA_CARDS_ATTACK = 20;
const USER_DATA_CARDS_SKILL = 21;
const USER_DATA_CARDS_PHYSICALITY = 22;
const USER_DATA_CARDS_MENTALITY = 23;
const USER_DATA_CARDS_DEFENCE = 24;
const USER_DATA_CARDS_GAOLKEEPING = 25;
const USER_DATA_CARDS_FINISHING = 26;
const USER_DATA_CARDS_CROSSING = 27;
const USER_DATA_CARDS_HEADING = 28;
const USER_DATA_CARDS_LONGSHOTS = 29;
const USER_DATA_CARDS_FREEKICK = 30;
const USER_DATA_CARDS_DRIBBLING = 31;
const USER_DATA_CARDS_LONGPASSING = 32;
const USER_DATA_CARDS_BALLCONTROL = 33;
const USER_DATA_CARDS_CURVE = 34;
const USER_DATA_CARDS_SHORTPASSIG = 35;
const USER_DATA_CARDS_POWER = 36;
const USER_DATA_CARDS_STAMINA = 37;
const USER_DATA_CARDS_STRENGTH = 38;
const USER_DATA_CARDS_REACTION = 39;
const USER_DATA_CARDS_SPEED = 40;
const USER_DATA_CARDS_AGGRESSION = 41;
const USER_DATA_CARDS_MOVEMENT = 42;
const USER_DATA_CARDS_VISION = 43;
const USER_DATA_CARDS_COMPOSURE = 44;
const USER_DATA_CARDS_PENALTIES = 45;
const USER_DATA_CARDS_MARKING = 46;
const USER_DATA_CARDS_STANDINGTACKLE = 47;
const USER_DATA_CARDS_SLIDINGTACKLE = 48;
const USER_DATA_CARDS_INTERCEPTIONS = 49;
const USER_DATA_CARDS_POSTIONING = 50;
const USER_DATA_CARDS_GKDIVING = 51;
const USER_DATA_CARDS_GKHANDING = 52;
const USER_DATA_CARDS_GKPOSTIONING = 53;
const USER_DATA_CARDS_GKREFLEXES = 54;
const USER_DATA_CARDS_GKKICKING = 55;
const USER_DATA_CARDS_REDCARD = 56;
const USER_DATA_CARDS_YELLOWCARD = 57;
const USER_DATA_CARDS_LEAGUEDATA = 58;
const USER_DATA_CARDS_CUPDATA = 59;
const USER_DATA_CARDS_CHAMPIONDATA = 60;
const USER_DATA_CARDS_SCORELIST = 61;
const CARD_STATISTICS_MATCH_NUM = 1;
const CARD_STATISTICS_MVP = 2;
const CARD_STATISTICS_GOAL = 3;
const CARD_STATISTICS_ASSISTS = 4;
const CARD_STATISTICS_YELLOW_CARD = 5;
const CARD_STATISTICS_RED_CARD = 6;
const CARD_STATISTICS_SCORE = 7;
const USER_DATA_FORMATION_GK = 1;
const USER_DATA_FORMATION_RB = 2;
const USER_DATA_FORMATION_LB = 3;
const USER_DATA_FORMATION_CBR = 4;
const USER_DATA_FORMATION_CBC = 5;
const USER_DATA_FORMATION_CBL = 6;
const USER_DATA_FORMATION_DMR = 7;
const USER_DATA_FORMATION_DMC = 8;
const USER_DATA_FORMATION_DML = 9;
const USER_DATA_FORMATION_RM = 10;
const USER_DATA_FORMATION_LM = 11;
const USER_DATA_FORMATION_CMR = 12;
const USER_DATA_FORMATION_CMC = 13;
const USER_DATA_FORMATION_CML = 14;
const USER_DATA_FORMATION_AMR = 15;
const USER_DATA_FORMATION_AMC = 16;
const USER_DATA_FORMATION_AML = 17;
const USER_DATA_FORMATION_RW = 18;
const USER_DATA_FORMATION_LW = 19;
const USER_DATA_FORMATION_RF = 20;
const USER_DATA_FORMATION_CF = 21;
const USER_DATA_FORMATION_LF = 22;
const USER_DATA_FORMATION_S1 = 23;
const USER_DATA_FORMATION_S2 = 24;
const USER_DATA_FORMATION_S3 = 25;
const USER_DATA_FORMATION_S4 = 26;
const USER_DATA_FORMATION_S5 = 27;
const USER_DATA_FORMATION_S6 = 28;
const USER_DATA_FORMATION_S7 = 29;
const FOOTBALLER_POSITION_UNLIMITED = 0;
const FOOTBALLER_POSITION_GK = 1;
const FOOTBALLER_POSITION_RB = 2;
const FOOTBALLER_POSITION_LB = 3;
const FOOTBALLER_POSITION_CB = 4;
const FOOTBALLER_POSITION_DMF = 5;
const FOOTBALLER_POSITION_RM = 6;
const FOOTBALLER_POSITION_LM = 7;
const FOOTBALLER_POSITION_CMF = 8;
const FOOTBALLER_POSITION_AMF = 9;
const FOOTBALLER_POSITION_RW = 10;
const FOOTBALLER_POSITION_LW = 11;
const FOOTBALLER_POSITION_CF = 12;
const FOOTBALLER_POSITION_RWLWCF = 13;
const FOOTBALLER_POSITION_AMFCMFLMRMDMF = 14;
const FOOTBALLER_POSITION_LBCBRB = 15;
const FIGHT_SELF_NO = 0;
const FIGHT_SELF_IS = 1;
const PVP_PASS_TYPE_NONE = 1;
const PVP_PASS_TYPE_LONG = 2;
const PVP_PASS_TYPE_SHORT = 3;
const PVP_PASS_TYPE_CENTER = 4;
const PVP_SHOOT_TYPE_HEAD = 10;
const PVP_SHOOT_TYPE_LONG = 11;
const PVP_SHOOT_TYPE_PENALTY = 12;
const PVP_SHOOT_TYPE_PENALTY_SHOT = 13;
const PVP_SHOOT_TYPE_FREE_KICK = 14;
const PVP_CATCH_TYPE_HEIGHT = 20;
const PVP_CATCH_TYPE_LOW = 21;
const PVP_DRIBBLE_TYPE_RULE = 30;
const PVP_DRIBBLE_TYPE_CROSS = 31;
const PVP_DRIBBLE_TYPE_NONE = 32;
const PVP_DRIBBLE_TYPE_RED = 33;
const PVP_DRIBBLE_TYPE_YELLOW = 34;
const PVP_DRIBBLE_TYPE_YELLOWTORED = 35;
const PVP_MODE_NORMAL = 0;
const PVP_MODE_FAST_COUNTERATTACK = 2;
const PVP_MODE_FOUL_BALL = 3;
const PVP_MODE_CORNER = 4;
const PVP_MODE_FREE_KICK = 5;
const PVP_MODE_PENALTY = 6;
const PVP_PASS_SHOW_CUT = 1;
const PVP_PASS_SHOW_SUCCESS = 2;
const PVP_PASS_SHOW_OUT = 3;
const PVP_SHOOT_SHOW_GOALOFF = 4;
const PVP_SHOOT_SHOW_HEAD = 5;
const PVP_SHOOT_SHOW_FOOT = 6;
const PVP_SHOOT_SHOW_GOAL = 7;
const PVP_SHOOT_SHOW_FLY = 8;
const PVP_SHOOT_SHOW_GET = 9;
const PVP_SHOOT_SHOW_WALL = 10;
const PVP_CATCH_SHOW_CUT = 11;
const PVP_CATCH_SHOW_GET = 12;
const PVP_CATCH_SHOW_OUT = 13;
const PVP_CATCH_SHOW_LOSE = 14;
const PVP_DRIBBLE_SHOW_CUT = 15;
const PVP_DRIBBLE_SHOW_ARRIVE = 16;
const PVP_DRIBBLE_SHOW_HURT = 17;
const APPLY_GAME_BACK_HOMESCORE = 2;
const APPLY_GAME_BACK_AWAYSCORE = 3;
const APPLY_GAME_BACK_EVENTDATE = 4;
const APPLY_GAME_BACK_EVENTLINE = 5;
const APPLY_GAME_BACK_EVENTPOINT = 6;
const PVP_BACK_SHOW = 1;
const PVP_BACK_TYPE = 2;
const PVP_BACK_POSITION = 3;
const PVP_BACK_POSITION_RAND = 4;
const PVP_BACK_POSITION_ENEMY = 1;
const PVP_BACK_POSITION_ACTIVE = 2;
const PVP_BACK_POSITION_PASSIVE = 3;
const FIGHT_EVENT_TYPE_PASS = 1;
const FIGHT_EVENT_TYPE_CATCH = 2;
const FIGHT_EVENT_TYPE_DRIBBLE = 3;
const FIGHT_EVENT_TYPE_SHOOT = 4;
const CLUB_JERSEY_ID = 1;
const CLUB_JERSEY_MAIN_COLOR = 2;
const CLUB_JERSEY_COLOR = 3;
const CLUB_TEAM_SIGN_ID = 1;
const CLUB_TEAM_SIGN_TYPE = 2;
const CLUB_TEAM_SIGN_MAIN_COLOR = 3;
const CLUB_TEAM_SIGN_COLOR = 4;
const CLUB_TEAM_SIGN_PATTERN = 5;
const CLUB_TEAM_SIGN_PATTERN_COLOR = 6;
const CLUB_TROPHY_RANKING = 1;
const CLUB_TROPHY_GETTIME = 2;
const CLUB_TROPHY_TYPE = 3;
const CLUB_TROPHY_LEVEL = 4;
const CLUB_TROPHY_ID = 5;
const CLUB_INFO_LEVEL = 1;
const CLUB_INFO_CREATEDATE = 2;
const CLUB_INFO_COUNTRY = 3;
const CLUB_INFO_CITY = 4;
const CLUB_INFO_STADIUMNAME = 5;
const CLUB_INFO_STADIUMSEATNUM = 6;
const CLUB_INFO_NAME = 7;
const CLUB_INFO_FANS = 8;
const CLUB_INFO_CLUBNAME = 9;
const CLUB_INFO_AVEGOAL = 10;
const CLUB_INFO_AVEFUMBLE = 11;
const CLUB_INFO_STARPLAYER = 12;
const CLUB_INFO_BESTSHOOTER = 13;
const CLUB_INFO_SCORELIST = 14;
const CLUB_INFO_HOMEJERSEY = 15;
const CLUB_INFO_AWAYJERSEY = 16;
const CLUB_INFO_TEAMSIGN = 17;
const CLUB_INFO_TROPHY1 = 18;
const CLUB_INFO_TROPHY2 = 19;
const CLUB_INFO_TROPHY3 = 20;
const MATCH_TYPE_LEAGUE = 1;
const MATCH_TYPE_CUP = 2;
const MATCH_TYPE_CHAMPION = 3;
const MATCH_TYPE_FRIEND = 4;
const GAME_STATISTICS_BALL_CONTROL = 3;
const GAME_STATISTICS_SHOT_NUM = 4;
const GAME_STATISTICS_PENALTY_SHOT = 5;
const GAME_STATISTICS_SHOT_SUCCESS_RATE = 6;
const GAME_STATISTICS_PASS_SUCCESS_RATE = 7;
const GAME_STATISTICS_FREE_KICK = 8;
const GAME_STATISTICS_CORNER = 9;
const GAME_STATISTICS_SAVES = 10;
const GAME_STATISTICS_TACKLE_NUM = 11;
const GAME_STATISTICS_FOUL = 12;
const GAME_STATISTICS_YELLOW_CARD = 13;
const GAME_STATISTICS_RED_CARD = 14;
const GAME_STATUS_TYPE_WAITING = 0;
const GAME_STATUS_TYPE_GAMEING = 1;
const GAME_STATUS_TYPE_FINISH = 2;
const FIGHT_SUMMARY_TYPE_GOAL = 0;
const FIGHT_SUMMARY_TYPE_HURT = 1;
const FIGHT_SUMMARY_TYPE_RED_CARD = 2;
const FIGHT_SUMMARY_TYPE_YELLOW_CARD = 3;
const FIGHT_SUMMARY_TYPE_YELLOW_TO_RED = 4;
const FIGHT_SUMMARY_DATA_IS_HOME = 0;
const FIGHT_SUMMARY_DATA_EVENT_POINT = 1;
const FIGHT_SUMMARY_DATA_EVENT_TYPE = 2;
const FIGHT_SUMMARY_DATA_MAIN_CARDUID = 3;
const FIGHT_SUMMARY_DATA_CARDUID = 4;
const GAME_RESULT_TYPE_NONE = 0;
const GAME_RESULT_TYPE_SUCC = 1;
const GAME_RESULT_TYPE_DRAW = 2;
const GAME_RESULT_TYPE_FAIL = 3;
const USER_DATA_FIRST_USERID = 0;
const USER_DATA_FIRST_PROPERTY = 1;
const USER_DATA_FIRST_CARDS = 2;
const USER_DATA_FIRST_EQUIPS = 3;
const USER_DATA_FIRST_MATERIALS = 4;
const USER_DATA_FIRST_FRAGMENTS = 5;
const USER_DATA_FIRST_FORMATION = 6;
const USER_DATA_FIRST_LIMIT = 7;
const USER_DATA_FIRST_MAPS = 8;
const USER_DATA_FIRST_CREATETIME = 9;
const USER_DATA_FIRST_LASTLOGIN = 10;
const USER_DATA_FIRST_LASTLEAVE = 11;
const USER_DATA_CARDS_UID = 0;
const USER_DATA_CARDS_CID = 1;
const USER_DATA_CARDS_USERID = 2;
const USER_DATA_EQUIPS_UID = 1;
const USER_DATA_EQUIPS_ID = 2;
const USER_DATA_EQUIPS_LEVEL = 3;
const USER_DATA_EQUIPS_EXP = 4;
const USER_DATA_EQUIPS_CARDUID = 5;
const USER_DATA_FRAGMENTS_ID = 1;
const USER_DATA_FRAGMENTS_NUMBER = 2;
const USER_DATA_MATERIALS_ID = 1;
const USER_DATA_MATERIALS_NUMBER = 2;
const USER_DATA_PROPERTY_NONE = 0;
const USER_DATA_PROPERTY_USERID = 1;
const USER_DATA_PROPERTY_NICK = 2;
const USER_DATA_PROPERTY_LEVEL = 3;
const USER_DATA_PROPERTY_EXP = 4;
const USER_DATA_PROPERTY_MONEY = 5;
const USER_DATA_PROPERTY_RMB = 6;
const USER_DATA_PROPERTY_RMBGM = 7;
const USER_DATA_PROPERTY_FORMATION = 8;
const USER_DATA_PROPERTY_CLUP = 9;
const USER_DATA_PROPERTY_COUNTRY = 10;
const USER_DATA_PROPERTY_LEADER = 11;
const USER_DATA_PROPERTY_CARDSCOUNT = 12;
const USER_DATA_PROPERTY_EQUIPSCOUNT = 13;
const USER_DATA_PROPERTY_FRIENDSHIP = 14;
const USER_DATA_PROPERTY_POWERCUR = 15;
const USER_DATA_PROPERTY_POWERALL = 16;
const USER_DATA_PROPERTY_POWRETIME = 17;
const USER_DATA_PROPERTY_PVPCUR = 18;
const USER_DATA_PROPERTY_PVPALL = 19;
const USER_DATA_PROPERTY_PVPRETIME = 20;
const USER_DATA_PROPERTY_HONOR = 21;
const USER_DATA_PROPERTY_FVSUMMONTIME = 22;
const USER_DATA_PROPERTY_MONEYSUMMONTIME = 23;
const USER_DATA_PROPERTY_RMBSUMMONTIME = 24;
const USER_DATA_PROPERTY_MEDICALCUR = 25;
const USER_DATA_PROPERTY_MORALECUR = 26;
const USER_DATA_LIMIT_LOGINREWARDID = 1;
const USER_DATA_LIMIT_LOGINREWARDDAY = 2;
const USER_DATA_LIMIT_LOGINREWARDLOOT = 3;
const EQUIP_TYPE_POSITION = 1;
const EQUIP_TYPE_CLOTH = 2;
const EQUIP_TYPE_COUNTRY = 3;
const EQUIP_TYPE_CLUB = 4;
const MAP_TYPE_COMMON = 1;
const MAP_TYPE_ELITE = 2;
const MAP_TYPE_ACTIVE = 3;
const CHILD_MAP_TYPE_COMMON = 1;
const CHILD_MAP_TYPE_LIMITNUMBER = 2;
const CLUB_JERSEY_USERID = 0;
const CLUB_TEAM_SIGN_USERID = 0;
const CLUB_TROPHY_USERID = 0;
const CLUB_INFO_USERID = 0;
const SERVER_OPERATION_NTF_PROPERTY_CHANGE = 1;
const SERVER_OPERATION_NTF_CARD_CHANGE = 2;
const SERVER_OPERATION_NTF_CARD_DELETE = 3;
const SERVER_OPERATION_NTF_CARD_ADD = 4;
const SERVER_OPERATION_NTF_EQUIP_ADD = 5;
const SERVER_OPERATION_NTF_EQUIP_DELETE = 6;
const SERVER_OPERATION_NTF_EQUIP_CHANGE = 7;
const SERVER_OPERATION_NTF_FRAGMENT_OPER = 8;
const SERVER_OPERATION_NTF_MATERIAL_OPER = 9;
const SERVER_OPERATION_NTF_FORMATION_OPER = 10;
const SERVER_OPERATION_NTF_DIRTYTIMES = 20;
const SUMMON_TYPE_FV = 1;
const SUMMON_TYPE_MONEY = 2;
const SUMMON_TYPE_RMB = 3;
const SUMMON_TYPE_RMBTEN = 4;
const CARD_QUALITY_TYPE_WHITE = 1;
const CARD_QUALITY_TYPE_GREEN = 2;
const CARD_QUALITY_TYPE_BLUE = 3;
const CARD_QUALITY_TYPE_PURPLE = 4;
const CARD_QUALITY_TYPE_ORANGE = 5;
const CARD_QUALITY_TYPE_RED = 6;
const PVP_POSITION_NONE = 0;
const PVP_POSITION_ATTACK = 1;
const PVP_POSITION_DEFENSE = 2;
const MYSQL_MAX_NUM = 2000000;
const MEM_MAX_NUM = 200000;
const ID_LIST_MAX_NUM = 2000;
const REDPOINT_PVPFIGHT = 0;
const TACTICS_TYPE_TEAMMEMTALITY = 1;
const TACTICS_TYPE_PASSDIRECTION = 2;
const TACTICS_TYPE_ATTACKDIRECTION = 3;
const TACTICS_TYPE_DEFENSE = 4;
const TACTICS_TYPE_COMPRESSION = 5;
const TACTICS_TYPE_TACKLE = 6;
const TACTICS_TYPE_OFFSIDE = 7;
const TACTICS_TYPE_MARKING = 8;

class CS_LOGIN_REQ
{
	public $__UserName = "";//string
	public $__UserPwd = "";//string
	function _construct()
	{
	}
}

class SC_LOGIN_ACK
{
	public $__Token = "";//string
	public $__TimeStamp = "";//string
	function _construct()
	{
	}
}

class CS_REGISTER_REQ
{
	public $__UserName = "";//string
	public $__UserPwd = "";//string
	public $__MacAddress = "";//string
	function _construct()
	{
	}
}

class SC_REGISTER_ACK
{
	public $__Token = "";//string
	public $__TimeStamp = "";//string
	function _construct()
	{
	}
}

class CS_CREATE_REQ
{
	public $__Name = "";//string
	public $__CountryId = 0;
	public $__CaptainId = 0;
	function _construct()
	{
	}
}

class SC_CREATE_ACK
{
	function _construct()
	{
	}
}

class SDrop
{
	public $__Id = 0;
	public $__Param1 = 0;
	public $__Param2 = 0;
	public $__Param3 = 0;
	function _construct()
	{
	}
}

class SInfo
{
	public $__Type = 0;
	public $__Value = "";//string
	function _construct()
	{
	}
}

class SProperties
{
	public $__Name = "";//string
	public $__InfoArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SCardInfos
{
	public $__Uid = 0;
	public $__Index = 0;
	public $__InfoArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SCardBag
{
	public $__CardArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SPositionInfo
{
	public $__Position = 0;
	public $__CardUidsArr = array();//array elem is int
	function _construct()
	{
	}
}

class SFormation
{
	public $__PositionInfoArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SEquipInfos
{
	public $__InfoArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SEquipBag
{
	public $__EquipArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SFragmentInfos
{
	public $__InfoArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SFragmentBag
{
	public $__FragmentArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SMaterialInfos
{
	public $__InfoArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SMaterialBag
{
	public $__MaterialArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SLimit
{
	public $__LoginRewardId = 0;
	public $__LoginRewardDay = 0;
	public $__LoginRewardLooted = 0;
	function _construct()
	{
	}
}

class SChildMapInfo
{
	public $__ChildMapId = 0;
	public $__State = 0;
	function _construct()
	{
	}
}

class SMapInfo
{
	public $__MapId = 0;
	public $__ChildMapArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SMap
{
	public $__MapType = 0;
	public $__MapArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SMapGather
{
	public $__MapGahterArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SUserInfo
{
	public $__Property; //class object SProperties
	public $__CardBag; //class object SCardBag
	public $__Formation; //class object SFormation
	public $__EquipBag; //class object SEquipBag
	public $__Limit; //class object SLimit
	public $__FragmentBag; //class object SFragmentBag
	public $__MaterialBag; //class object SMaterialBag
	public $__Maps; //class object SMapGather
	function _construct()
	{
		$this->__Property = new SProperties(); //class object SProperties
		$this->__CardBag = new SCardBag(); //class object SCardBag
		$this->__Formation = new SFormation(); //class object SFormation
		$this->__EquipBag = new SEquipBag(); //class object SEquipBag
		$this->__Limit = new SLimit(); //class object SLimit
		$this->__FragmentBag = new SFragmentBag(); //class object SFragmentBag
		$this->__MaterialBag = new SMaterialBag(); //class object SMaterialBag
		$this->__Maps = new SMapGather(); //class object SMapGather
	}
}

class CS_GETINFO_REQ
{
	public $__InfoType = 0;
	function _construct()
	{
	}
}

class SC_GETINFO_ACK
{
	public $__InfoType = 0;
	public $__Info; //class object SUserInfo
	function _construct()
	{
		$this->__Info = new SUserInfo(); //class object SUserInfo
	}
}

class SPropertyChangeNtf
{
	public $__InfoArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SCardChangeNtf
{
	public $__CardUid = 0;
	public $__InfoArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SCardDelNtf
{
	public $__CardUidsArr = array();//array elem is int
	function _construct()
	{
	}
}

class SCardAddNtf
{
	public $__NewCard = array(); //array elem is class object
	function _construct()
	{
	}
}

class SEquipAddNtf
{
	public $__NewEquip = array(); //array elem is class object
	function _construct()
	{
	}
}

class SEquipDelNtf
{
	public $__EquipUidsArr = array();//array elem is int
	function _construct()
	{
	}
}

class SEquipChangeNtf
{
	public $__EquipUid = 0;
	public $__InfoArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class SFragmentOperNtf
{
	public $__Fragment = array(); //array elem is class object
	function _construct()
	{
	}
}

class SMaterialOperNtf
{
	public $__Material = array(); //array elem is class object
	function _construct()
	{
	}
}

class SDirtyTimeNtf
{
	public $__DirtyTime = array(); //array elem is class object
	function _construct()
	{
	}
}

class SOperationNtf
{
	public $__PropertyChangeNtf; //class object SPropertyChangeNtf
	public $__CardChangeNtf; //class object SCardChangeNtf
	public $__CardDelNtf; //class object SCardDelNtf
	public $__CardAddNtf; //class object SCardAddNtf
	public $__EquipAddNtf; //class object SEquipAddNtf
	public $__EquipDelNtf; //class object SEquipDelNtf
	public $__EquipChangeNtf; //class object SEquipChangeNtf
	public $__FragmentOperNtf; //class object SFragmentOperNtf
	public $__MaterialOperNtf; //class object SMaterialOperNtf
	public $__FormationChangeNtf; //class object SFormation
	public $__DirtyTimeNtf; //class object SDirtyTimeNtf
	function _construct()
	{
		$this->__PropertyChangeNtf = new SPropertyChangeNtf(); //class object SPropertyChangeNtf
		$this->__CardChangeNtf = new SCardChangeNtf(); //class object SCardChangeNtf
		$this->__CardDelNtf = new SCardDelNtf(); //class object SCardDelNtf
		$this->__CardAddNtf = new SCardAddNtf(); //class object SCardAddNtf
		$this->__EquipAddNtf = new SEquipAddNtf(); //class object SEquipAddNtf
		$this->__EquipDelNtf = new SEquipDelNtf(); //class object SEquipDelNtf
		$this->__EquipChangeNtf = new SEquipChangeNtf(); //class object SEquipChangeNtf
		$this->__FragmentOperNtf = new SFragmentOperNtf(); //class object SFragmentOperNtf
		$this->__MaterialOperNtf = new SMaterialOperNtf(); //class object SMaterialOperNtf
		$this->__FormationChangeNtf = new SFormation(); //class object SFormation
		$this->__DirtyTimeNtf = new SDirtyTimeNtf(); //class object SDirtyTimeNtf
	}
}

class SLogicOperationNtf
{
	public $__NtfType = 0;
	public $__Operation; //class object SOperationNtf
	function _construct()
	{
		$this->__Operation = new SOperationNtf(); //class object SOperationNtf
	}
}

class CS_GETDIRTYTIME_REQ
{
	function _construct()
	{
	}
}

class SC_GETDIRTYTIME_ACK
{
	public $__DirtyTime = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_UPGRADELEVEL_REQ
{
	public $__CardMainUid = 0;
	public $__CardUidsArr = array();//array elem is int
	function _construct()
	{
	}
}

class SC_UPGRADELEVEL_ACK
{
	public $__OperationNtfArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_UPGRADESTAR_REQ
{
	public $__CardMainUid = 0;
	function _construct()
	{
	}
}

class SC_UPGRADESTAR_ACK
{
	public $__OperationNtfArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_LOOTLOGINREWARD_REQ
{
	function _construct()
	{
	}
}

class SC_LOOTLOGINREWARD_ACK
{
	public $__OperationNtfArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_PVE_REQ
{
	public $__MapId = 0;
	public $__ChildMapId = 0;
	function _construct()
	{
	}
}

class SPVEShotSuc
{
	public $__ShotCardUid = 0;
	public $__DefCardUid = 0;
	function _construct()
	{
	}
}

class SPVEShotFail
{
	public $__ShotCardUid = 0;
	public $__DefCardUid = 0;
	function _construct()
	{
	}
}

class SPVEResult
{
	public $__ShotSuc = array(); //array elem is class object
	public $__ShotFail = array(); //array elem is class object
	function _construct()
	{
	}
}

class SC_PVE_ACK
{
	public $__OperationNtfArr = array(); //array elem is class object
	public $__NPCCardBag; //class object SCardBag
	public $__MyResult; //class object SPVEResult
	public $__NPCResult; //class object SPVEResult
	public $__Drop = array(); //array elem is class object
	function _construct()
	{
		$this->__NPCCardBag = new SCardBag(); //class object SCardBag
		$this->__MyResult = new SPVEResult(); //class object SPVEResult
		$this->__NPCResult = new SPVEResult(); //class object SPVEResult
	}
}

class CS_TESTPVE_REQ
{
	function _construct()
	{
	}
}

class SC_TESTPVE_ACK
{
	public $__NPC1CardBag; //class object SCardBag
	public $__NPC2CardBag; //class object SCardBag
	public $__NPC1Result; //class object SPVEResult
	public $__NPC2Result; //class object SPVEResult
	function _construct()
	{
		$this->__NPC1CardBag = new SCardBag(); //class object SCardBag
		$this->__NPC2CardBag = new SCardBag(); //class object SCardBag
		$this->__NPC1Result = new SPVEResult(); //class object SPVEResult
		$this->__NPC2Result = new SPVEResult(); //class object SPVEResult
	}
}

class CS_REDPOINT_REQ
{
	function _construct()
	{
	}
}

class SC_REDPOINT_ACK
{
	public $__RedPointsArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_SELLCARDS_REQ
{
	public $__CardUidsArr = array();//array elem is int
	function _construct()
	{
	}
}

class SC_SELLCARDS_ACK
{
	public $__OperationNtfArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_POSITIONCHANGE_REQ
{
	public $__SrcCardUid = 0;
	public $__DesCardUid = 0;
	function _construct()
	{
	}
}

class SC_POSITIONCHANGE_ACK
{
	public $__OperationNtfArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_UPGRADEEQUIPLEVEL_REQ
{
	public $__EquipMainUid = 0;
	public $__EquipUidsArr = array();//array elem is int
	function _construct()
	{
	}
}

class SC_UPGRADEEQUIPLEVEL_ACK
{
	public $__OperationNtfArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_EQUIPWORD_REQ
{
	public $__CardUid = 0;
	public $__EquipUid = 0;
	public $__EquipType = 0;
	function _construct()
	{
	}
}

class SC_EQUIPWORD_ACK
{
	public $__OperationNtfArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_EQUIPREST_REQ
{
	public $__EquipUid = 0;
	function _construct()
	{
	}
}

class SC_EQUIPREST_ACK
{
	public $__OperationNtfArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_SELLEQUIPS_REQ
{
	public $__EquipUidsArr = array();//array elem is int
	function _construct()
	{
	}
}

class SC_SELLEQUIPS_ACK
{
	public $__OperationNtfArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_SUMMON_REQ
{
	public $__SummonType = 0;
	function _construct()
	{
	}
}

class SC_SUMMON_ACK
{
	public $__OperationNtfArr = array(); //array elem is class object
	public $__Drop = array(); //array elem is class object
	function _construct()
	{
	}
}

class SC_USER_DATA_NTF
{
	public $____test = 0;
	function _construct()
	{
	}
}

class CS_HeartBeat_REQ
{
	public $__FightEventPoint = 0;
	function _construct()
	{
	}
}

class CS_APPLYGAME_REQ
{
	public $__DefenseId = 0;
	public $__IsReconnection = 0;
	function _construct()
	{
	}
}

class EventData
{
	public $__EventType = 0;
	public $__EventResult = 0;
	public $__EventBehavior = 0;
	public $__EventPositions = array(); //array elem is class object
	public $__EventRegion; //class object SInfo
	function _construct()
	{
		$this->__EventRegion = new SInfo(); //class object SInfo
	}
}

class SPVPEvent
{
	public $__EventPoint = 0;
	public $__Event = array(); //array elem is class object
	function _construct()
	{
	}
}

class SPVPEventClass
{
	public $__Classes = 0;
	public $__ApplyPVPEvent = array(); //array elem is class object
	function _construct()
	{
	}
}

class SC_FormationInfo_ACK
{
	public $__UserId = 0;
	public $__FormationInfo = array(); //array elem is class object
	function _construct()
	{
	}
}

class EventLines
{
	public $__IsSelf = 0;
	public $__HomeBallControl = 0;
	public $__FightMode = 0;
	public $__EventLineData = array(); //array elem is class object
	public $__HomeFormation; //class object SC_FormationInfo_ACK
	public $__AwayFormation; //class object SC_FormationInfo_ACK
	public $__IsStart = 0;
	public $__IsClear = 0;
	function _construct()
	{
		$this->__HomeFormation = new SC_FormationInfo_ACK(); //class object SC_FormationInfo_ACK
		$this->__AwayFormation = new SC_FormationInfo_ACK(); //class object SC_FormationInfo_ACK
	}
}

class FightBackInfo
{
	public $__HomeScore = 0;
	public $__AwayScore = 0;
	public $__EventPoint = 0;
	public $__ExecTime = 0;
	public $__EventLine; //class object EventLines
	function _construct()
	{
		$this->__EventLine = new EventLines(); //class object EventLines
	}
}

class SC_APPLYGAME_ACK
{
	public $__FightRoomId = 0;
	public $__ApplyEventInfo = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_FIGHT_ROOM_INFO_REQ
{
	public $__FightRoomId = 0;
	function _construct()
	{
	}
}

class SC_FIGHT_ROOM_INFO_ACK
{
	public $__FightRoomId = 0;
	public $__HomeUserId = 0;
	public $__AwayUserId = 0;
	public $__HomeScore = 0;
	public $__AwayScore = 0;
	public $__StartEventPoint = 0;
	function _construct()
	{
	}
}

class CS_FootballerInfo_REQ
{
	public $__UserId = 0;
	function _construct()
	{
	}
}

class SC_FootballerInfo_ACK
{
	public $__CardArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_FootballerADD_REQ
{
	public $__FootballerID = 0;
	function _construct()
	{
	}
}

class SC_FootballerADD_ACK
{
	public $__InfoArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_FootballerDestory_REQ
{
	public $__FootballerID = 0;
	function _construct()
	{
	}
}

class SC_FootballerDestory_ACK
{
	public $__IsScuess = 0;
	function _construct()
	{
	}
}

class CS_Property_REQ
{
	function _construct()
	{
	}
}

class SC_Property_ACK
{
	public $__Name = "";//string
	public $__Uid = 0;
	public $__InfoArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class ChatInfo
{
	public $__UserName = "";//string
	public $__ChatMessage = "";//string
	function _construct()
	{
	}
}

class CS_Chat_REQ
{
	public $__UserID = 0;
	function _construct()
	{
	}
}

class SC_Chat_ACK
{
	public $__ChatArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_ChatSetInfo_REQ
{
	public $__UserID = 0;
	public $__Message = "";//string
	function _construct()
	{
	}
}

class SC_ChatSetInfo_ACK
{
	public $__isSuccess = 0;
	function _construct()
	{
	}
}

class FriendInfo
{
	public $__Name = "";//string
	public $__UserID = "";//string
	public $__Club = "";//string
	function _construct()
	{
	}
}

class CS_Friend_REQ
{
	function _construct()
	{
	}
}

class SC_Friend_ACK
{
	public $__FriendArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_FriendADD_REQ
{
	public $__FriendID = 0;
	function _construct()
	{
	}
}

class SC_FriendADD_ACK
{
	public $__Name = "";//string
	public $__UserID = "";//string
	public $__Club = "";//string
	function _construct()
	{
	}
}

class CS_FriendDestory_REQ
{
	public $__FriendID = 0;
	function _construct()
	{
	}
}

class SC_FriendDestory_ACK
{
	public $__isSuccess = 0;
	function _construct()
	{
	}
}

class CS_FriendFind_REQ
{
	public $__FriendID = 0;
	function _construct()
	{
	}
}

class SC_FriendFind_ACK
{
	public $__isSuccess = 0;
	function _construct()
	{
	}
}

class CS_FormationInfo_REQ
{
	public $__UserId = 0;
	function _construct()
	{
	}
}

class CS_FormationSet_REQ
{
	public $__FormationInfo = array(); //array elem is class object
	function _construct()
	{
	}
}

class SC_FormationSet_ACK
{
	public $__FormationInfo = 0;
	function _construct()
	{
	}
}

class CS_GETPLAYERINFO_REQ
{
	public $__UserId = 0;
	function _construct()
	{
	}
}

class SC_GETPLAYERINFO_ACK
{
	public $__CardArr = array(); //array elem is class object
	public $__UserId = 0;
	public $__FormationInfo = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_TACTICSGET_REQ
{
	function _construct()
	{
	}
}

class SC_TACTICSGET_ACK
{
	public $__TacticsInfo = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_TACTICSSET_REQ
{
	public $__TacticsClass = 0;
	public $__TacticsId = 0;
	function _construct()
	{
	}
}

class SC_TACTICSSET_ACK
{
	public $__IsSuccess = 0;
	function _construct()
	{
	}
}

class CS_CLUBSHIRT_REQ
{
	function _construct()
	{
	}
}

class ShirtInfo
{
	public $__Index = 0;
	public $__ShirtId = 0;
	public $__ShirtData = array(); //array elem is class object
	function _construct()
	{
	}
}

class SC_CLUBSHIRT_ACK
{
	public $__ShirtInfos = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_UPDATECLUBSHIRT_REQ
{
	public $__ShirtIndex = 0;
	public $__MainColor = 0;
	public $__Color = 0;
	function _construct()
	{
	}
}

class SC_UPDATECLUBSHIRT_ACK
{
	public $__IsSuccess = 0;
	function _construct()
	{
	}
}

class CS_CLUBTEAMSIGN_REQ
{
	function _construct()
	{
	}
}

class TeamSignInfo
{
	public $__Index = 0;
	public $__TeamSignId = 0;
	public $__TeamSignData = array(); //array elem is class object
	function _construct()
	{
	}
}

class SC_CLUBTEAMSIGN_ACK
{
	public $__TeamSigns = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_UPDATETEAMSIGN_REQ
{
	public $__TeamIndex = 0;
	public $__TeamSignInfo = array(); //array elem is class object
	function _construct()
	{
	}
}

class SC_UPDATETEAMSIGN_ACK
{
	public $__IsSuccess = 0;
	function _construct()
	{
	}
}

class UpdateClubInfo
{
	public $__ClubName = "";//string
	public $__FansName = "";//string
	public $__CountryId = "";//string
	public $__City = "";//string
	function _construct()
	{
	}
}

class CS_CREATECLUB_REQ
{
	public $__ClubInfo; //class object UpdateClubInfo
	function _construct()
	{
		$this->__ClubInfo = new UpdateClubInfo(); //class object UpdateClubInfo
	}
}

class SC_CREATECLUB_ACK
{
	public $__IsSuccess = 0;
	function _construct()
	{
	}
}

class CS_UPDATECLUB_REQ
{
	public $__ClubInfo = array(); //array elem is class object
	function _construct()
	{
	}
}

class SC_UPDATECLUB_ACK
{
	public $__IsSuccess = 0;
	function _construct()
	{
	}
}

class CS_GETCLUBINFO_REQ
{
	public $__UserId = 0;
	function _construct()
	{
	}
}

class SC_GETCLUBINFO_ACK
{
	public $__ClubData = array(); //array elem is class object
	function _construct()
	{
	}
}

class Trophy
{
	public $__Index = 0;
	public $__TrophyId = 0;
	public $__TrophyData = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_GETTROPHYLIST_REQ
{
	function _construct()
	{
	}
}

class SC_GETTROPHYLIST_ACK
{
	public $__TrophyList = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_ADDTROPHY_REQ
{
	public $__Level = 0;
	public $__Ranking = 0;
	public $__TrophyType = 0;
	function _construct()
	{
	}
}

class SC_ADDTROPHY_ACK
{
	public $__IsSuccess = 0;
	function _construct()
	{
	}
}

class CS_LEAGUERANK_REQ
{
	function _construct()
	{
	}
}

class SLeagueRankInfo
{
	public $__UserId = 0;
	public $__LastRank = 0;
	public $__ClubName = "";//string
	public $__Finish = 0;
	public $__Succ = 0;
	public $__Draw = 0;
	public $__Fail = 0;
	public $__Goal = 0;
	public $__Fumble = 0;
	public $__GoalFumble = 0;
	public $__Integral = 0;
	public $__Performance = 0;
	public $__TeamSign; //class object TeamSignInfo
	function _construct()
	{
		$this->__TeamSign = new TeamSignInfo(); //class object TeamSignInfo
	}
}

class SC_LEAGUE_RANK_ACK
{
	public $__LeagueRound = 0;
	public $__LeagueRank = array(); //array elem is class object
	function _construct()
	{
	}
}

class SC_LEAGUE_RANK_NTF
{
	public $__LeagueRank = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_LEAGUE_SCHEDULE_REQ
{
	public $__UserId = 0;
	public $__Round = array();//array elem is int
	function _construct()
	{
	}
}

class SLeagueScheduleInfo
{
	public $__RoomId = 0;
	public $__Round = 0;
	public $__NO = 0;
	public $__UserId1 = 0;
	public $__UserId2 = 0;
	public $__ClubName1 = "";//string
	public $__ClubName2 = "";//string
	public $__TeamSign1; //class object TeamSignInfo
	public $__TeamSign2; //class object TeamSignInfo
	public $__StartTime = 0;
	public $__Status = 0;
	public $__Score = array();//array elem is int
	public $__IsLocked = 0;
	function _construct()
	{
		$this->__TeamSign1 = new TeamSignInfo(); //class object TeamSignInfo
		$this->__TeamSign2 = new TeamSignInfo(); //class object TeamSignInfo
	}
}

class SC_LEAGUE_SCHEDULE_ACK
{
	public $__Schedule = array(); //array elem is class object
	function _construct()
	{
	}
}

class SC_LEAGUE_SCHEDULE_NTF
{
	public $__Schedule = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_LEAGUE_FOOTBALLER_RANK_REQ
{
	function _construct()
	{
	}
}

class SLeagueFootballerRank
{
	public $__UserId = 0;
	public $__CardId = 0;
	public $__TeamSign; //class object TeamSignInfo
	public $__ClubName = "";//string
	public $__RankResult = "";//string
	function _construct()
	{
		$this->__TeamSign = new TeamSignInfo(); //class object TeamSignInfo
	}
}

class SC_LEAGUE_FOOTBALLER_RANK_ACK
{
	public $__ShootRank = array(); //array elem is class object
	public $__MarkRank = array(); //array elem is class object
	public $__AssistsRank = array(); //array elem is class object
	function _construct()
	{
	}
}

class SC_LEAGUE_FOOTBALLER_RANK_NTF
{
	public $__ShootRank = array(); //array elem is class object
	public $__MarkRank = array(); //array elem is class object
	public $__AssistsRank = array(); //array elem is class object
	function _construct()
	{
	}
}

class SCardStatisticsInfo
{
	public $__CardUid = 0;
	public $__IsMVP = "";//string
	public $__GoalNum = 0;
	public $__Assists = 0;
	public $__Score = 0;
	public $__YellowCard = 0;
	public $__RedCard = 0;
	public $__RoomId = 0;
	function _construct()
	{
	}
}

class SGameStatisticsInfo
{
	public $__RoomId = 0;
	public $__GameType = 0;
	public $__IsHome = "";//string
	public $__BallControl = 0;
	public $__ShotNum = 0;
	public $__PenaltyShot = 0;
	public $__ShotSuccessRate = 0;
	public $__PassSuccessRate = 0;
	public $__FreeKick = 0;
	public $__Corner = 0;
	public $__Saves = 0;
	public $__TackleNum = 0;
	public $__Foul = 0;
	public $__YellowCard = 0;
	public $__RedCard = 0;
	public $__TotalScore = 0;
	public $__TotalGoalNum = 0;
	public $__UserId = 0;
	function _construct()
	{
	}
}

class SMatchSummaryInfo
{
	public $__IsHome = 0;
	public $__EventPoint = 0;
	public $__EventType = 0;
	public $__MainCardUid = 0;
	public $__CardUid = 0;
	function _construct()
	{
	}
}

class CS_MATCH_SUMMARY_REQ
{
	public $__RoomId = 0;
	function _construct()
	{
	}
}

class SC_MATCH_SUMMARY_ACK
{
	public $__RoomId = 0;
	public $__SummaryInfo = array(); //array elem is class object
	function _construct()
	{
	}
}

class SCardRecommend
{
	public $__Token = 0;
	public $__CardInfo; //class object SCardInfos
	function _construct()
	{
		$this->__CardInfo = new SCardInfos(); //class object SCardInfos
	}
}

class CS_GET_RECOMMEND_CARD_REQ
{
	function _construct()
	{
	}
}

class SC_GET_RECOMMEND_CARD_ACK
{
	public $__EndTime = 0;
	public $__CardArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_BUY_RECOMMEND_CARD_REQ
{
	public $__Index = 0;
	function _construct()
	{
	}
}

class SC_BUY_RECOMMEND_CARD_ACK
{
	public $__IsSuccess = 0;
	function _construct()
	{
	}
}

class CS_GET_MY_SCHEDULE_REQ
{
	public $__Week = 0;
	function _construct()
	{
	}
}

class SC_GET_MY_SCHEDULE_ACK
{
	public $__Week = 0;
	public $__LeagueSchedule = array(); //array elem is class object
	function _construct()
	{
	}
}

class SC_GET_MY_SCHEDULE_NTF
{
	public $__Schedule = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_MODIFY_SCHEDULE_REQ
{
	public $__RoomId = 0;
	public $__StartTime = 0;
	function _construct()
	{
	}
}

class SC_MODIFY_SCHEDULE_ACK
{
	function _construct()
	{
	}
}

class CS_LOCK_SCHEDULE_REQ
{
	public $__RoomId = 0;
	function _construct()
	{
	}
}

class SC_LOCK_SCHEDULE_ACK
{
	function _construct()
	{
	}
}

class CS_GET_SCOUT_REQ
{
	function _construct()
	{
	}
}

class SC_GET_SCOUT_ACK
{
	public $__CardArr = array(); //array elem is class object
	function _construct()
	{
	}
}

class CS_BUY_SCOUT_REQ
{
	public $__Index = 0;
	function _construct()
	{
	}
}

class SC_BUY_SCOUT_ACK
{
	public $__IsSuccess = 0;
	function _construct()
	{
	}
}

class FightStatisticsInfo
{
	public $__BallControl = 0;
	public $__ShotNum = 0;
	public $__PenaltyShot = 0;
	public $__ShotSuccessRate = 0;
	public $__PassSuccessRate = 0;
	public $__FreeKick = 0;
	public $__Corner = 0;
	public $__Saves = 0;
	public $__TackleNum = 0;
	public $__Foul = 0;
	public $__YellowCard = 0;
	public $__RedCard = 0;
	function _construct()
	{
	}
}

class CS_FIGHT_STATISTICS_REQ
{
	public $__RoomId = 0;
	function _construct()
	{
	}
}

class SC_FIGHT_STATISTICS_ACK
{
	public $__HomeStatistics = array(); //array elem is class object
	public $__AwayStatistics = array(); //array elem is class object
	function _construct()
	{
	}
}

const CSID_LOGIN_REQ = 1;
const SCID_LOGIN_ACK = 2;
const CSID_CREATE_REQ = 3;
const SCID_CREATE_ACK = 4;
const CSID_GETINFO_REQ = 5;
const SCID_GETINFO_ACK = 6;
const CSID_REGISTER_REQ = 7;
const SCID_REGISTER_ACK = 8;
const CSID_UPGRADELEVEL_REQ = 100;
const SCID_UPGRADELEVEL_ACK = 101;
const CSID_UPGRADESTAR_REQ = 102;
const SCID_UPGRADESTAR_ACK = 103;
const CSID_LOOTLOGINREWARD_REQ = 104;
const SCID_LOOTLOGINREWARD_ACK = 105;
const CSID_PVE_REQ = 200;
const SCID_PVE_ACK = 201;
const CSID_SELLCARDS_REQ = 202;
const SCID_SELLCARDS_ACK = 203;
const CSID_POSITIONCHANGE_REQ = 204;
const SCID_POSITIONCHANGE_ACK = 205;
const CSID_UPGRADEEQUIPLEVEL_REQ = 206;
const SCID_UPGRADEEQUIPLEVEL_ACK = 207;
const CSID_EQUIPWORD_REQ = 208;
const SCID_EQUIPWORD_ACK = 209;
const CSID_EQUIPREST_REQ = 210;
const SCID_EQUIPREST_ACK = 211;
const CSID_SELLEQUIPS_REQ = 212;
const SCID_SELLEQUIPS_ACK = 213;
const CSID_SUMMON_REQ = 214;
const SCID_SUMMON_ACK = 215;
const CSID_GETDIRTYTIME_REQ = 300;
const SCID_GETDIRTYTIME_ACK = 301;
const CSID_APPLYGAME_REQ = 400;
const SCID_APPLYGAME_ACK = 401;
const CSID_GETPLAYERINFO_REQ = 402;
const SCID_GETPLAYERINFO_ACK = 403;
const CSID_GET_SUMMARY_REQ = 404;
const SCID_GET_SUMMARY_ACK = 405;
const CSID_FIGHT_ROOM_INFO_REQ = 406;
const SCID_FIGHT_ROOM_INFO_ACK = 407;
const CSID_FIGHT_STATISTICS_REQ = 408;
const SCID_FIGHT_STATISTICS_ACK = 409;
const CSID_FootballerInfo_REQ = 500;
const SCID_FootballerInfo_ACK = 501;
const CSID_FootballerADD_REQ = 502;
const SCID_FootballerADD_ACK = 503;
const CSID_FootballerDestory_REQ = 504;
const SCID_FootballerDestory_ACK = 505;
const CSID_FormationInfo_REQ = 510;
const SCID_FormationInfo_ACK = 511;
const CSID_FormationSet_REQ = 512;
const SCID_FormationSet_ACK = 513;
const CSID_Property_REQ = 600;
const SCID_Property_ACK = 601;
const CSID_Chat_REQ = 700;
const SCID_Chat_ACK = 701;
const CSID_ChatSetInfo_REQ = 702;
const SCID_ChatSetInfo_ACK = 703;
const CSID_Friend_REQ = 800;
const SCID_Friend_ACK = 801;
const CSID_FriendADD_REQ = 802;
const SCID_FriendADD_ACK = 803;
const CSID_FriendDestory_REQ = 804;
const SCID_FriendDestory_ACK = 805;
const CSID_FriendFind_REQ = 806;
const SCID_FriendFind_ACK = 807;
const CSID_TACTICSGET_REQ = 900;
const SCID_TACTICSGET_ACK = 901;
const CSID_TACTICSSET_REQ = 902;
const SCID_TACTICSSET_ACK = 903;
const CSID_CREATECLUB_REQ = 1000;
const SCID_CREATECLUB_ACK = 1001;
const CSID_UPDATECLUB_REQ = 1002;
const SCID_UPDATECLUB_ACK = 1003;
const CSID_GETCLUBINFO_REQ = 1004;
const SCID_GETCLUBINFO_ACK = 1005;
const CSID_CLUBSHIRT_REQ = 1010;
const SCID_CLUBSHIRT_ACK = 1011;
const CSID_UPDATECLUBSHIRT_REQ = 1012;
const SCID_UPDATECLUBSHIRT_ACK = 1013;
const CSID_CLUBTEAMSIGN_REQ = 1020;
const SCID_CLUBTEAMSIGN_ACK = 1021;
const CSID_UPDATECLUBTEAMSIGN_REQ = 1022;
const SCID_UPDATECLUBTEAMSIGN_ACK = 1023;
const CSID_GETTROPHYLIST_REQ = 1030;
const SCID_GETTROPHYLIST_ACK = 1031;
const CSID_ADDTROPHY_REQ = 1032;
const SCID_ADDTROPHY_ACK = 1033;
const CSID_GET_RECOMMEND_CARD_REQ = 1100;
const SCID_GET_RECOMMEND_CARD_ACK = 1101;
const CSID_BUY_RECOMMEND_CARD_REQ = 1102;
const SCID_BUY_RECOMMEND_CARD_ACK = 1103;
const CSID_GET_SCOUT_REQ = 1104;
const SCID_GET_SCOUT_ACK = 1105;
const CSID_BUY_SCOUT_REQ = 1106;
const SCID_BUY_SCOUT_ACK = 1107;
const CSID_REDPOINT_REQ = 2000;
const SCID_REDPOINT_ACK = 2001;
const CSID_LEAGUERANK_REQ = 2010;
const SCID_LEAGUE_RANK_ACK = 2011;
const SCID_LEAGUE_RANK_NTF = 2012;
const CSID_LEAGUE_SCHEDULE_REQ = 2013;
const SCID_LEAGUE_SCHEDULE_ACK = 2014;
const SCID_LEAGUE_SCHEDULE_NTF = 2015;
const CSID_LEAGUE_FOOTBALLER_RANK_REQ = 2016;
const SCID_LEAGUE_FOOTBALLER_RANK_ACK = 2017;
const SCID_LEAGUE_FOOTBALLER_RANK_NTF = 2018;
const CSID_GET_MY_SCHEDULE_REQ = 2030;
const SCID_GET_MY_SCHEDULE_ACK = 2031;
const CSID_MODIFY_SCHEDULE_REQ = 2032;
const SCID_MODIFY_SCHEDULE_ACK = 2033;
const CSID_LOCK_SCHEDULE_REQ = 2034;
const SCID_LOCK_SCHEDULE_ACK = 2035;
const SCID_GET_MY_SCHEDULE_NTF = 2036;
const SCID_USER_DATA_NTF = 1009;
const CSID_HeartBeat_REQ = 9999;

function Send($message, $err = null, $data = null, $isExist = true)
{
	static $object;
	if(!$object)
		$object = new stdclass();
	if(!isset($object->messages))
		$object->messages = Array();
	
	$oneMessage = new stdClass;
	$oneMessage->msgid = $message;
	$oneMessage->err = $err;
	$oneMessage->value = $data;
	$object->messages[] = $oneMessage;
	if($isExist)
	{
		funcEnd($message-1);
		$json = stripslashes(json_encode($object));
		exit($json);
	}
}
function Rece($data)
{
	return json_decode($data);
}