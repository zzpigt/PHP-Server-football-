
static var ERROR_OK : int = 0;
static var ERROR_LOGIN : int = 1;
static var ERROR_CREATE : int = 2;
static var ERROR_NEED_LOGIN : int = 3;
static var ERROR_NEED_CREATE : int = 4;
static var ERROR_REPEAT_NAME : int = 5;
static var ERROR_NAME_LENGTH : int = 6;
static var ERROR_ONLINE : int = 7;
static var ERROR_REGISTER : int = 8;
static var ERROR_USERNAME_REGISTERED : int = 9;
static var ERROR_USER_NAME_LENGTH : int = 10;
static var ERROR_USER_PWD_LENGTH : int = 11;
static var ERROR_NAME_HAVED : int = 12;
static var ERROR_NOT_FIND_CARD : int = 30;
static var ERROR_NOT_HAVE_CARD : int = 31;
static var ERROR_FORMATION_CHANGE : int = 32;
static var ERROR_FORMATION_NOTFIND : int = 33;
static var ERROR_USER_LEVEL_FULL : int = 34;
static var ERROR_NOT_FIND_COUNTRY : int = 35;
static var ERROR_UPGRADE_LEVEL_EXPZROE : int = 36;
static var ERROR_CARD_FULL_LEVEL : int = 37;
static var ERROR_CARD_FULL_STAR : int = 38;
static var ERROR_UPGRADE_STAR_MONEYZROE : int = 39;
static var ERROR_UPGRADE_STAR_MATERIAL : int = 40;
static var ERROR_MATERIAL_NOTFIND : int = 41;
static var ERROR_FRAGMENT_NOTFIND : int = 42;
static var ERROR_EQUIP_NOTFIND : int = 43;
static var ERROR_LOOT_LOGIN_REWARD : int = 44;
static var ERROR_LOOTED_LOGIN_REWARD : int = 45;
static var ERROR_ACTIVE_MAP_TIME : int = 46;
static var ERROR_OPEN_MAP : int = 47;
static var ERROR_OPEN_CHILD_MAP : int = 48;
static var ERROR_POWER_NOT_ENOUGH : int = 49;
static var ERROR_CHILD_MAP_LIMIT_USED : int = 50;
static var ERROR_FIGHT : int = 51;
static var ERROR_CARDS_COUNT_LIMIT : int = 52;
static var ERROR_EQUIPS_COUNT_LIMIT : int = 53;
static var ERROR_NOT_HAVE_EQUIP : int = 54;
static var ERROR_EQUIP_FULL_LEVEL : int = 55;
static var ERROR_FREE_SUMMON : int = 56;
static var ERROR_FV_NUMBER : int = 57;
static var ERROR_MONEY_NUMBER : int = 58;
static var ERROR_RMB_NUMBER : int = 59;
static var ERROR_CARD_WORK : int = 60;
static var ERROR_NOT_FIND_TYPE : int = 1000;
static var ERROR_SERVER : int = 1001;
static var ERROR_LEVEL_NOT_UP : int = 1002;

public class ErrorCode {
	static var m_errorArr : Array = new Array();
	static var m_bInit : boolean = false;
	public static function GetDesc(ErrorCode : int)
	{
		if(!m_bInit)
		{
			m_errorArr[proto.ERROR_OK] = "成功";
			m_errorArr[proto.ERROR_LOGIN] = "登录失败";
			m_errorArr[proto.ERROR_CREATE] = "创建失败";
			m_errorArr[proto.ERROR_NEED_LOGIN] = "需要登录";
			m_errorArr[proto.ERROR_NEED_CREATE] = "需要创建";
			m_errorArr[proto.ERROR_REPEAT_NAME] = "重名";
			m_errorArr[proto.ERROR_NAME_LENGTH] = "超出长度";
			m_errorArr[proto.ERROR_ONLINE] = "账号已在线";
			m_errorArr[proto.ERROR_REGISTER] = "注册失败";
			m_errorArr[proto.ERROR_USERNAME_REGISTERED] = "用户名已存在";
			m_errorArr[proto.ERROR_USER_NAME_LENGTH] = "用户名超出长度";
			m_errorArr[proto.ERROR_USER_PWD_LENGTH] = "密码超出长度";
			m_errorArr[proto.ERROR_NAME_HAVED] = "昵称已存在";
			m_errorArr[proto.ERROR_NOT_FIND_CARD] = "没有发现卡牌";
			m_errorArr[proto.ERROR_NOT_HAVE_CARD] = "您没有这张卡牌";
			m_errorArr[proto.ERROR_FORMATION_CHANGE] = "替换失败";
			m_errorArr[proto.ERROR_FORMATION_NOTFIND] = "阵型不存在";
			m_errorArr[proto.ERROR_USER_LEVEL_FULL] = "玩家已到达最高等级";
			m_errorArr[proto.ERROR_NOT_FIND_COUNTRY] = "国家不存在";
			m_errorArr[proto.ERROR_UPGRADE_LEVEL_EXPZROE] = "升级出错(经验为0)";
			m_errorArr[proto.ERROR_CARD_FULL_LEVEL] = "卡牌到达最高等级";
			m_errorArr[proto.ERROR_CARD_FULL_STAR] = "卡牌到达最高星级";
			m_errorArr[proto.ERROR_UPGRADE_STAR_MONEYZROE] = "升星出错(消耗为0)";
			m_errorArr[proto.ERROR_UPGRADE_STAR_MATERIAL] = "升星出错(材料不足)";
			m_errorArr[proto.ERROR_MATERIAL_NOTFIND] = "材料不存在";
			m_errorArr[proto.ERROR_FRAGMENT_NOTFIND] = "碎片不存在";
			m_errorArr[proto.ERROR_EQUIP_NOTFIND] = "装备不存在";
			m_errorArr[proto.ERROR_LOOT_LOGIN_REWARD] = "每日登陆奖励拾取失败";
			m_errorArr[proto.ERROR_LOOTED_LOGIN_REWARD] = "今天已领取过了";
			m_errorArr[proto.ERROR_ACTIVE_MAP_TIME] = "活动地图未开启";
			m_errorArr[proto.ERROR_OPEN_MAP] = "大地图为开启";
			m_errorArr[proto.ERROR_OPEN_CHILD_MAP] = "小地图为开启";
			m_errorArr[proto.ERROR_POWER_NOT_ENOUGH] = "体力不足";
			m_errorArr[proto.ERROR_CHILD_MAP_LIMIT_USED] = "今日挑战次数已用完";
			m_errorArr[proto.ERROR_FIGHT] = "战斗失败";
			m_errorArr[proto.ERROR_CARDS_COUNT_LIMIT] = "卡牌数量超过上限";
			m_errorArr[proto.ERROR_EQUIPS_COUNT_LIMIT] = "装备数量超过上限";
			m_errorArr[proto.ERROR_NOT_HAVE_EQUIP] = "您没有这个装备";
			m_errorArr[proto.ERROR_EQUIP_FULL_LEVEL] = "装备到达最高等级";
			m_errorArr[proto.ERROR_FREE_SUMMON] = "免费召唤失败";
			m_errorArr[proto.ERROR_FV_NUMBER] = "友情点不足";
			m_errorArr[proto.ERROR_MONEY_NUMBER] = "金币不足";
			m_errorArr[proto.ERROR_RMB_NUMBER] = "钻石不足";
			m_errorArr[proto.ERROR_CARD_WORK] = "卡牌出战中";
			m_errorArr[proto.ERROR_NOT_FIND_TYPE] = "系统错误";
			m_errorArr[proto.ERROR_SERVER] = "系统错误";
			m_errorArr[proto.ERROR_LEVEL_NOT_UP] = "系统错误";
			m_bInit = true;
		}
		return m_errorArr[ErrorCode];
	}
}

static var USER_DATA_FIRST_NONE : int = 0;
static var USER_DATA_FIRST_PROPERTY : int = 1;
static var USER_DATA_FIRST_CARDS : int = 2;
static var USER_DATA_FIRST_EQUIPS : int = 3;
static var USER_DATA_FIRST_MATERIALS : int = 4;
static var USER_DATA_FIRST_FRAGMENTS : int = 5;
static var USER_DATA_FIRST_FORMATION : int = 6;
static var USER_DATA_FIRST_LIMIT : int = 7;
static var USER_DATA_FIRST_MAPS : int = 8;
static var USER_DATA_FIRST_CREATETIME : int = 9;
static var USER_DATA_FIRST_LASTLOGIN : int = 10;
static var USER_DATA_FIRST_LASTLEAVE : int = 11;
static var USER_DATA_CARDS_NONE : int = 0;
static var USER_DATA_CARDS_UID : int = 1;
static var USER_DATA_CARDS_ID : int = 2;
static var USER_DATA_CARDS_LEVEL : int = 3;
static var USER_DATA_CARDS_EXP : int = 4;
static var USER_DATA_CARDS_STAR : int = 5;
static var USER_DATA_CARDS_EQUIP1 : int = 6;
static var USER_DATA_CARDS_EQUIP2 : int = 7;
static var USER_DATA_CARDS_EQUIP3 : int = 8;
static var USER_DATA_CARDS_EQUIP4 : int = 9;
static var USER_DATA_CARDS_ISCAPTAIN : int = 10;
static var USER_DATA_CARDS_ISWORK : int = 11;
static var USER_DATA_EQUIPS_UID : int = 1;
static var USER_DATA_EQUIPS_ID : int = 2;
static var USER_DATA_EQUIPS_LEVEL : int = 3;
static var USER_DATA_EQUIPS_EXP : int = 4;
static var USER_DATA_EQUIPS_CARDUID : int = 5;
static var USER_DATA_FRAGMENTS_ID : int = 1;
static var USER_DATA_FRAGMENTS_NUMBER : int = 2;
static var USER_DATA_MATERIALS_ID : int = 1;
static var USER_DATA_MATERIALS_NUMBER : int = 2;
static var USER_DATA_PROPERTY_NONE : int = 0;
static var USER_DATA_PROPERTY_USERID : int = 1;
static var USER_DATA_PROPERTY_NICK : int = 2;
static var USER_DATA_PROPERTY_LEVEL : int = 3;
static var USER_DATA_PROPERTY_EXP : int = 4;
static var USER_DATA_PROPERTY_MONEY : int = 5;
static var USER_DATA_PROPERTY_RMB : int = 6;
static var USER_DATA_PROPERTY_RMBGM : int = 7;
static var USER_DATA_PROPERTY_FORMATION : int = 8;
static var USER_DATA_PROPERTY_CLUP : int = 9;
static var USER_DATA_PROPERTY_COUNTRY : int = 10;
static var USER_DATA_PROPERTY_LEADER : int = 11;
static var USER_DATA_PROPERTY_CARDSCOUNT : int = 12;
static var USER_DATA_PROPERTY_EQUIPSCOUNT : int = 13;
static var USER_DATA_PROPERTY_FRIENDSHIP : int = 14;
static var USER_DATA_PROPERTY_POWERCUR : int = 15;
static var USER_DATA_PROPERTY_POWERALL : int = 16;
static var USER_DATA_PROPERTY_POWRETIME : int = 17;
static var USER_DATA_PROPERTY_PVPCUR : int = 18;
static var USER_DATA_PROPERTY_PVPALL : int = 19;
static var USER_DATA_PROPERTY_PVPRETIME : int = 20;
static var USER_DATA_PROPERTY_HONOR : int = 21;
static var USER_DATA_PROPERTY_FVSUMMONTIME : int = 22;
static var USER_DATA_PROPERTY_MONEYSUMMONTIME : int = 23;
static var USER_DATA_PROPERTY_RMBSUMMONTIME : int = 24;
static var USER_DATA_FORMATION_FORWARD : int = 1;
static var USER_DATA_FORMATION_CENTERFORWARD : int = 2;
static var USER_DATA_FORMATION_GUARD : int = 3;
static var USER_DATA_FORMATION_GOALKEEPER : int = 4;
static var USER_DATA_FORMATION_ALTERNATIVE : int = 5;
static var USER_DATA_LIMIT_LOGINREWARDID : int = 1;
static var USER_DATA_LIMIT_LOGINREWARDDAY : int = 2;
static var USER_DATA_LIMIT_LOGINREWARDLOOT : int = 3;
static var EQUIP_TYPE_POSITION : int = 1;
static var EQUIP_TYPE_CLOTH : int = 2;
static var EQUIP_TYPE_COUNTRY : int = 3;
static var EQUIP_TYPE_CLUB : int = 4;
static var MAP_TYPE_COMMON : int = 1;
static var MAP_TYPE_ELITE : int = 2;
static var MAP_TYPE_ACTIVE : int = 3;
static var CHILD_MAP_TYPE_COMMON : int = 1;
static var CHILD_MAP_TYPE_LIMITNUMBER : int = 2;
static var SERVER_OPERATION_NTF_PROPERTY_CHANGE : int = 1;
static var SERVER_OPERATION_NTF_CARD_CHANGE : int = 2;
static var SERVER_OPERATION_NTF_CARD_DELETE : int = 3;
static var SERVER_OPERATION_NTF_CARD_ADD : int = 4;
static var SERVER_OPERATION_NTF_EQUIP_ADD : int = 5;
static var SERVER_OPERATION_NTF_EQUIP_DELETE : int = 6;
static var SERVER_OPERATION_NTF_EQUIP_CHANGE : int = 7;
static var SERVER_OPERATION_NTF_FRAGMENT_OPER : int = 8;
static var SERVER_OPERATION_NTF_MATERIAL_OPER : int = 9;
static var SERVER_OPERATION_NTF_FORMATION_OPER : int = 10;
static var SERVER_OPERATION_NTF_DIRTYTIMES : int = 20;
static var SUMMON_TYPE_FV : int = 1;
static var SUMMON_TYPE_MONEY : int = 2;
static var SUMMON_TYPE_RMB : int = 3;
static var SUMMON_TYPE_RMBTEN : int = 4;
static var CARD_QUALITY_TYPE_WHITE : int = 1;
static var CARD_QUALITY_TYPE_GREEN : int = 2;
static var CARD_QUALITY_TYPE_BLUE : int = 3;
static var CARD_QUALITY_TYPE_PURPLE : int = 4;
static var CARD_QUALITY_TYPE_ORANGE : int = 5;
static var CARD_QUALITY_TYPE_RED : int = 6;

public class CProtoBase 
{
}
public class CS_LOGIN_REQ extends CProtoBase 
{
	var m_UserName : String = "";//string
	var m_UserPwd : String = "";//string
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_UserName;
		arr[1] = m_UserPwd;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_UserName = data[0];
		m_UserPwd = data[1];
	}
}

public class SC_LOGIN_ACK extends CProtoBase 
{
	var m_Token : String = "";//string
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_Token;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_Token = data[0];
	}
}

public class CS_REGISTER_REQ extends CProtoBase 
{
	var m_UserName : String = "";//string
	var m_UserPwd : String = "";//string
	var m_MacAddress : String = "";//string
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_UserName;
		arr[1] = m_UserPwd;
		arr[2] = m_MacAddress;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_UserName = data[0];
		m_UserPwd = data[1];
		m_MacAddress = data[2];
	}
}

public class SC_REGISTER_ACK extends CProtoBase 
{
	var m_Token : String = "";//string
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_Token;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_Token = data[0];
	}
}

public class CS_CREATE_REQ extends CProtoBase 
{
	var m_Name : String = "";//string
	var m_CountryId : int = 0;
	var m_CaptainId : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_Name;
		arr[1] = m_CountryId;
		arr[2] = m_CaptainId;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_Name = data[0];
		m_CountryId = data[1];
		m_CaptainId = data[2];
	}
}

public class SC_CREATE_ACK extends CProtoBase 
{
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
	}
}

public class SDrop extends CProtoBase 
{
	var m_Id : int = 0;
	var m_Param1 : int = 0;
	var m_Param2 : int = 0;
	var m_Param3 : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_Id;
		arr[1] = m_Param1;
		arr[2] = m_Param2;
		arr[3] = m_Param3;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_Id = data[0];
		m_Param1 = data[1];
		m_Param2 = data[2];
		m_Param3 = data[3];
	}
}

public class SInfo extends CProtoBase 
{
	var m_Type : int = 0;
	var m_Value : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_Type;
		arr[1] = m_Value;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_Type = data[0];
		m_Value = data[1];
	}
}

public class SProperties extends CProtoBase 
{
	var m_Name : String = "";//string
	var m_InfoArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_Name;
		var arr1 : Array = new Array();
		for(var i1 : int = 0; i1 < m_InfoArr.length; i1++)
		{
			arr1.push(m_InfoArr[i1].serialize(0));//array elem is class Object
		}
		arr[1] = arr1;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_Name = data[0];
		for(var i1 : int = 0; i1 < data[1].length; i1++)
		{
			var tempClass1 : SInfo = new SInfo();
			tempClass1.arrToObj(data[1][i1], 0);
			m_InfoArr.push(tempClass1);//array elem is class Object
		}
	}
}

public class SCardInfos extends CProtoBase 
{
	var m_InfoArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_InfoArr.length; i0++)
		{
			arr0.push(m_InfoArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SInfo = new SInfo();
			tempClass0.arrToObj(data[0][i0], 0);
			m_InfoArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class SCardBag extends CProtoBase 
{
	var m_CardArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_CardArr.length; i0++)
		{
			arr0.push(m_CardArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SCardInfos = new SCardInfos();
			tempClass0.arrToObj(data[0][i0], 0);
			m_CardArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class SPositionInfo extends CProtoBase 
{
	var m_Position : int = 0;
	var m_CardUidsArr : Array = new Array();//array elem is int
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_Position;
		var arr1 : Array = new Array();
		for(var i1 : int = 0; i1 < m_CardUidsArr.length; i1++)
		{
			arr1.push(m_CardUidsArr[i1]);//array elem is int
		}
		arr[1] = arr1;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_Position = data[0];
		for(var i1 : int = 0; i1 < data[1].length; i1++)
		{
			m_CardUidsArr.push(data[1][i1]);//array elem is int
		}
	}
}

public class SFormation extends CProtoBase 
{
	var m_PositionInfoArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_PositionInfoArr.length; i0++)
		{
			arr0.push(m_PositionInfoArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SPositionInfo = new SPositionInfo();
			tempClass0.arrToObj(data[0][i0], 0);
			m_PositionInfoArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class SEquipInfos extends CProtoBase 
{
	var m_InfoArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_InfoArr.length; i0++)
		{
			arr0.push(m_InfoArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SInfo = new SInfo();
			tempClass0.arrToObj(data[0][i0], 0);
			m_InfoArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class SEquipBag extends CProtoBase 
{
	var m_EquipArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_EquipArr.length; i0++)
		{
			arr0.push(m_EquipArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SEquipInfos = new SEquipInfos();
			tempClass0.arrToObj(data[0][i0], 0);
			m_EquipArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class SFragmentInfos extends CProtoBase 
{
	var m_InfoArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_InfoArr.length; i0++)
		{
			arr0.push(m_InfoArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SInfo = new SInfo();
			tempClass0.arrToObj(data[0][i0], 0);
			m_InfoArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class SFragmentBag extends CProtoBase 
{
	var m_FragmentArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_FragmentArr.length; i0++)
		{
			arr0.push(m_FragmentArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SFragmentInfos = new SFragmentInfos();
			tempClass0.arrToObj(data[0][i0], 0);
			m_FragmentArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class SMaterialInfos extends CProtoBase 
{
	var m_InfoArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_InfoArr.length; i0++)
		{
			arr0.push(m_InfoArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SInfo = new SInfo();
			tempClass0.arrToObj(data[0][i0], 0);
			m_InfoArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class SMaterialBag extends CProtoBase 
{
	var m_MaterialArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_MaterialArr.length; i0++)
		{
			arr0.push(m_MaterialArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SMaterialInfos = new SMaterialInfos();
			tempClass0.arrToObj(data[0][i0], 0);
			m_MaterialArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class SLimit extends CProtoBase 
{
	var m_LoginRewardId : int = 0;
	var m_LoginRewardDay : int = 0;
	var m_LoginRewardLooted : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_LoginRewardId;
		arr[1] = m_LoginRewardDay;
		arr[2] = m_LoginRewardLooted;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_LoginRewardId = data[0];
		m_LoginRewardDay = data[1];
		m_LoginRewardLooted = data[2];
	}
}

public class SChildMapInfo extends CProtoBase 
{
	var m_ChildMapId : int = 0;
	var m_State : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_ChildMapId;
		arr[1] = m_State;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_ChildMapId = data[0];
		m_State = data[1];
	}
}

public class SMapInfo extends CProtoBase 
{
	var m_MapId : int = 0;
	var m_ChildMapArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_MapId;
		var arr1 : Array = new Array();
		for(var i1 : int = 0; i1 < m_ChildMapArr.length; i1++)
		{
			arr1.push(m_ChildMapArr[i1].serialize(0));//array elem is class Object
		}
		arr[1] = arr1;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_MapId = data[0];
		for(var i1 : int = 0; i1 < data[1].length; i1++)
		{
			var tempClass1 : SChildMapInfo = new SChildMapInfo();
			tempClass1.arrToObj(data[1][i1], 0);
			m_ChildMapArr.push(tempClass1);//array elem is class Object
		}
	}
}

public class SMap extends CProtoBase 
{
	var m_MapType : int = 0;
	var m_MapArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_MapType;
		var arr1 : Array = new Array();
		for(var i1 : int = 0; i1 < m_MapArr.length; i1++)
		{
			arr1.push(m_MapArr[i1].serialize(0));//array elem is class Object
		}
		arr[1] = arr1;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_MapType = data[0];
		for(var i1 : int = 0; i1 < data[1].length; i1++)
		{
			var tempClass1 : SMapInfo = new SMapInfo();
			tempClass1.arrToObj(data[1][i1], 0);
			m_MapArr.push(tempClass1);//array elem is class Object
		}
	}
}

public class SMapGather extends CProtoBase 
{
	var m_MapGahterArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_MapGahterArr.length; i0++)
		{
			arr0.push(m_MapGahterArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SMap = new SMap();
			tempClass0.arrToObj(data[0][i0], 0);
			m_MapGahterArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class SUserInfo extends CProtoBase 
{
	var m_Property : SProperties = new SProperties(); //class Object
	var m_CardBag : SCardBag = new SCardBag(); //class Object
	var m_Formation : SFormation = new SFormation(); //class Object
	var m_EquipBag : SEquipBag = new SEquipBag(); //class Object
	var m_Limit : SLimit = new SLimit(); //class Object
	var m_FragmentBag : SFragmentBag = new SFragmentBag(); //class Object
	var m_MaterialBag : SMaterialBag = new SMaterialBag(); //class Object
	var m_Maps : SMapGather = new SMapGather(); //class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		if(select == proto.USER_DATA_FIRST_PROPERTY)
		{
			arr[0] = m_Property.serialize(0);
		}
		else if(select == proto.USER_DATA_FIRST_CARDS)
		{
			arr[1] = m_CardBag.serialize(0);
		}
		else if(select == proto.USER_DATA_FIRST_FORMATION)
		{
			arr[2] = m_Formation.serialize(0);
		}
		else if(select == proto.USER_DATA_FIRST_EQUIPS)
		{
			arr[3] = m_EquipBag.serialize(0);
		}
		else if(select == proto.USER_DATA_FIRST_LIMIT)
		{
			arr[4] = m_Limit.serialize(0);
		}
		else if(select == proto.USER_DATA_FIRST_FRAGMENTS)
		{
			arr[5] = m_FragmentBag.serialize(0);
		}
		else if(select == proto.USER_DATA_FIRST_MATERIALS)
		{
			arr[6] = m_MaterialBag.serialize(0);
		}
		else if(select == proto.USER_DATA_FIRST_MAPS)
		{
			arr[7] = m_Maps.serialize(0);
		}
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		if(select == proto.USER_DATA_FIRST_PROPERTY)
		{
			m_Property.arrToObj(data[0], 0);
		}
		else if(select == proto.USER_DATA_FIRST_CARDS)
		{
			m_CardBag.arrToObj(data[1], 0);
		}
		else if(select == proto.USER_DATA_FIRST_FORMATION)
		{
			m_Formation.arrToObj(data[2], 0);
		}
		else if(select == proto.USER_DATA_FIRST_EQUIPS)
		{
			m_EquipBag.arrToObj(data[3], 0);
		}
		else if(select == proto.USER_DATA_FIRST_LIMIT)
		{
			m_Limit.arrToObj(data[4], 0);
		}
		else if(select == proto.USER_DATA_FIRST_FRAGMENTS)
		{
			m_FragmentBag.arrToObj(data[5], 0);
		}
		else if(select == proto.USER_DATA_FIRST_MATERIALS)
		{
			m_MaterialBag.arrToObj(data[6], 0);
		}
		else if(select == proto.USER_DATA_FIRST_MAPS)
		{
			m_Maps.arrToObj(data[7], 0);
		}
	}
}

public class CS_GETINFO_REQ extends CProtoBase 
{
	var m_InfoType : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_InfoType;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_InfoType = data[0];
	}
}

public class SC_GETINFO_ACK extends CProtoBase 
{
	var m_InfoType : int = 0;
	var m_Info : SUserInfo = new SUserInfo(); //class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_InfoType;
		arr[1] = m_Info.serialize(m_InfoType);
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_InfoType = data[0];
		m_Info.arrToObj(data[1],data[0]);
	}
}

public class SPropertyChangeNtf extends CProtoBase 
{
	var m_InfoArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_InfoArr.length; i0++)
		{
			arr0.push(m_InfoArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SInfo = new SInfo();
			tempClass0.arrToObj(data[0][i0], 0);
			m_InfoArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class SCardChangeNtf extends CProtoBase 
{
	var m_CardUid : int = 0;
	var m_InfoArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_CardUid;
		var arr1 : Array = new Array();
		for(var i1 : int = 0; i1 < m_InfoArr.length; i1++)
		{
			arr1.push(m_InfoArr[i1].serialize(0));//array elem is class Object
		}
		arr[1] = arr1;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_CardUid = data[0];
		for(var i1 : int = 0; i1 < data[1].length; i1++)
		{
			var tempClass1 : SInfo = new SInfo();
			tempClass1.arrToObj(data[1][i1], 0);
			m_InfoArr.push(tempClass1);//array elem is class Object
		}
	}
}

public class SCardDelNtf extends CProtoBase 
{
	var m_CardUidsArr : Array = new Array();//array elem is int
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_CardUidsArr.length; i0++)
		{
			arr0.push(m_CardUidsArr[i0]);//array elem is int
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			m_CardUidsArr.push(data[0][i0]);//array elem is int
		}
	}
}

public class SCardAddNtf extends CProtoBase 
{
	var m_NewCard : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_NewCard.length; i0++)
		{
			arr0.push(m_NewCard[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SCardInfos = new SCardInfos();
			tempClass0.arrToObj(data[0][i0], 0);
			m_NewCard.push(tempClass0);//array elem is class Object
		}
	}
}

public class SEquipAddNtf extends CProtoBase 
{
	var m_NewEquip : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_NewEquip.length; i0++)
		{
			arr0.push(m_NewEquip[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SEquipInfos = new SEquipInfos();
			tempClass0.arrToObj(data[0][i0], 0);
			m_NewEquip.push(tempClass0);//array elem is class Object
		}
	}
}

public class SEquipDelNtf extends CProtoBase 
{
	var m_EquipUidsArr : Array = new Array();//array elem is int
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_EquipUidsArr.length; i0++)
		{
			arr0.push(m_EquipUidsArr[i0]);//array elem is int
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			m_EquipUidsArr.push(data[0][i0]);//array elem is int
		}
	}
}

public class SEquipChangeNtf extends CProtoBase 
{
	var m_EquipUid : int = 0;
	var m_InfoArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_EquipUid;
		var arr1 : Array = new Array();
		for(var i1 : int = 0; i1 < m_InfoArr.length; i1++)
		{
			arr1.push(m_InfoArr[i1].serialize(0));//array elem is class Object
		}
		arr[1] = arr1;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_EquipUid = data[0];
		for(var i1 : int = 0; i1 < data[1].length; i1++)
		{
			var tempClass1 : SInfo = new SInfo();
			tempClass1.arrToObj(data[1][i1], 0);
			m_InfoArr.push(tempClass1);//array elem is class Object
		}
	}
}

public class SFragmentOperNtf extends CProtoBase 
{
	var m_Fragment : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_Fragment.length; i0++)
		{
			arr0.push(m_Fragment[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SFragmentInfos = new SFragmentInfos();
			tempClass0.arrToObj(data[0][i0], 0);
			m_Fragment.push(tempClass0);//array elem is class Object
		}
	}
}

public class SMaterialOperNtf extends CProtoBase 
{
	var m_Material : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_Material.length; i0++)
		{
			arr0.push(m_Material[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SMaterialInfos = new SMaterialInfos();
			tempClass0.arrToObj(data[0][i0], 0);
			m_Material.push(tempClass0);//array elem is class Object
		}
	}
}

public class SDirtyTimeNtf extends CProtoBase 
{
	var m_DirtyTime : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_DirtyTime.length; i0++)
		{
			arr0.push(m_DirtyTime[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SInfo = new SInfo();
			tempClass0.arrToObj(data[0][i0], 0);
			m_DirtyTime.push(tempClass0);//array elem is class Object
		}
	}
}

public class SOperationNtf extends CProtoBase 
{
	var m_PropertyChangeNtf : SPropertyChangeNtf = new SPropertyChangeNtf(); //class Object
	var m_CardChangeNtf : SCardChangeNtf = new SCardChangeNtf(); //class Object
	var m_CardDelNtf : SCardDelNtf = new SCardDelNtf(); //class Object
	var m_CardAddNtf : SCardAddNtf = new SCardAddNtf(); //class Object
	var m_EquipAddNtf : SEquipAddNtf = new SEquipAddNtf(); //class Object
	var m_EquipDelNtf : SEquipDelNtf = new SEquipDelNtf(); //class Object
	var m_EquipChangeNtf : SEquipChangeNtf = new SEquipChangeNtf(); //class Object
	var m_FragmentOperNtf : SFragmentOperNtf = new SFragmentOperNtf(); //class Object
	var m_MaterialOperNtf : SMaterialOperNtf = new SMaterialOperNtf(); //class Object
	var m_FormationChangeNtf : SFormation = new SFormation(); //class Object
	var m_DirtyTimeNtf : SDirtyTimeNtf = new SDirtyTimeNtf(); //class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		if(select == proto.SERVER_OPERATION_NTF_PROPERTY_CHANGE)
		{
			arr[0] = m_PropertyChangeNtf.serialize(0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_CARD_CHANGE)
		{
			arr[1] = m_CardChangeNtf.serialize(0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_CARD_DELETE)
		{
			arr[2] = m_CardDelNtf.serialize(0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_CARD_ADD)
		{
			arr[3] = m_CardAddNtf.serialize(0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_EQUIP_ADD)
		{
			arr[4] = m_EquipAddNtf.serialize(0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_EQUIP_DELETE)
		{
			arr[5] = m_EquipDelNtf.serialize(0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_EQUIP_CHANGE)
		{
			arr[6] = m_EquipChangeNtf.serialize(0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_FRAGMENT_OPER)
		{
			arr[7] = m_FragmentOperNtf.serialize(0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_MATERIAL_OPER)
		{
			arr[8] = m_MaterialOperNtf.serialize(0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_FORMATION_OPER)
		{
			arr[9] = m_FormationChangeNtf.serialize(0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_DIRTYTIMES)
		{
			arr[10] = m_DirtyTimeNtf.serialize(0);
		}
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		if(select == proto.SERVER_OPERATION_NTF_PROPERTY_CHANGE)
		{
			m_PropertyChangeNtf.arrToObj(data[0], 0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_CARD_CHANGE)
		{
			m_CardChangeNtf.arrToObj(data[1], 0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_CARD_DELETE)
		{
			m_CardDelNtf.arrToObj(data[2], 0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_CARD_ADD)
		{
			m_CardAddNtf.arrToObj(data[3], 0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_EQUIP_ADD)
		{
			m_EquipAddNtf.arrToObj(data[4], 0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_EQUIP_DELETE)
		{
			m_EquipDelNtf.arrToObj(data[5], 0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_EQUIP_CHANGE)
		{
			m_EquipChangeNtf.arrToObj(data[6], 0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_FRAGMENT_OPER)
		{
			m_FragmentOperNtf.arrToObj(data[7], 0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_MATERIAL_OPER)
		{
			m_MaterialOperNtf.arrToObj(data[8], 0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_FORMATION_OPER)
		{
			m_FormationChangeNtf.arrToObj(data[9], 0);
		}
		else if(select == proto.SERVER_OPERATION_NTF_DIRTYTIMES)
		{
			m_DirtyTimeNtf.arrToObj(data[10], 0);
		}
	}
}

public class SLogicOperationNtf extends CProtoBase 
{
	var m_NtfType : int = 0;
	var m_Operation : SOperationNtf = new SOperationNtf(); //class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_NtfType;
		arr[1] = m_Operation.serialize(m_NtfType);
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_NtfType = data[0];
		m_Operation.arrToObj(data[1],data[0]);
	}
}

public class CS_GETDIRTYTIME_REQ extends CProtoBase 
{
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
	}
}

public class SC_GETDIRTYTIME_ACK extends CProtoBase 
{
	var m_DirtyTime : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_DirtyTime.length; i0++)
		{
			arr0.push(m_DirtyTime[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SInfo = new SInfo();
			tempClass0.arrToObj(data[0][i0], 0);
			m_DirtyTime.push(tempClass0);//array elem is class Object
		}
	}
}

public class CS_UPGRADELEVEL_REQ extends CProtoBase 
{
	var m_CardMainUid : int = 0;
	var m_CardUidsArr : Array = new Array();//array elem is int
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_CardMainUid;
		var arr1 : Array = new Array();
		for(var i1 : int = 0; i1 < m_CardUidsArr.length; i1++)
		{
			arr1.push(m_CardUidsArr[i1]);//array elem is int
		}
		arr[1] = arr1;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_CardMainUid = data[0];
		for(var i1 : int = 0; i1 < data[1].length; i1++)
		{
			m_CardUidsArr.push(data[1][i1]);//array elem is int
		}
	}
}

public class SC_UPGRADELEVEL_ACK extends CProtoBase 
{
	var m_OperationNtfArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_OperationNtfArr.length; i0++)
		{
			arr0.push(m_OperationNtfArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SLogicOperationNtf = new SLogicOperationNtf();
			tempClass0.arrToObj(data[0][i0], 0);
			m_OperationNtfArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class CS_UPGRADESTAR_REQ extends CProtoBase 
{
	var m_CardMainUid : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_CardMainUid;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_CardMainUid = data[0];
	}
}

public class SC_UPGRADESTAR_ACK extends CProtoBase 
{
	var m_OperationNtfArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_OperationNtfArr.length; i0++)
		{
			arr0.push(m_OperationNtfArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SLogicOperationNtf = new SLogicOperationNtf();
			tempClass0.arrToObj(data[0][i0], 0);
			m_OperationNtfArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class CS_LOOTLOGINREWARD_REQ extends CProtoBase 
{
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
	}
}

public class SC_LOOTLOGINREWARD_ACK extends CProtoBase 
{
	var m_OperationNtfArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_OperationNtfArr.length; i0++)
		{
			arr0.push(m_OperationNtfArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SLogicOperationNtf = new SLogicOperationNtf();
			tempClass0.arrToObj(data[0][i0], 0);
			m_OperationNtfArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class CS_PVE_REQ extends CProtoBase 
{
	var m_MapId : int = 0;
	var m_ChildMapId : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_MapId;
		arr[1] = m_ChildMapId;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_MapId = data[0];
		m_ChildMapId = data[1];
	}
}

public class SPVEShotSuc extends CProtoBase 
{
	var m_ShotCardUid : int = 0;
	var m_DefCardUid : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_ShotCardUid;
		arr[1] = m_DefCardUid;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_ShotCardUid = data[0];
		m_DefCardUid = data[1];
	}
}

public class SPVEShotFail extends CProtoBase 
{
	var m_ShotCardUid : int = 0;
	var m_DefCardUid : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_ShotCardUid;
		arr[1] = m_DefCardUid;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_ShotCardUid = data[0];
		m_DefCardUid = data[1];
	}
}

public class SPVEResult extends CProtoBase 
{
	var m_ShotSuc : Array = new Array(); //array elem is class Object
	var m_ShotFail : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_ShotSuc.length; i0++)
		{
			arr0.push(m_ShotSuc[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		var arr1 : Array = new Array();
		for(var i1 : int = 0; i1 < m_ShotFail.length; i1++)
		{
			arr1.push(m_ShotFail[i1].serialize(0));//array elem is class Object
		}
		arr[1] = arr1;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SPVEShotSuc = new SPVEShotSuc();
			tempClass0.arrToObj(data[0][i0], 0);
			m_ShotSuc.push(tempClass0);//array elem is class Object
		}
		for(var i1 : int = 0; i1 < data[1].length; i1++)
		{
			var tempClass1 : SPVEShotFail = new SPVEShotFail();
			tempClass1.arrToObj(data[1][i1], 0);
			m_ShotFail.push(tempClass1);//array elem is class Object
		}
	}
}

public class SC_PVE_ACK extends CProtoBase 
{
	var m_OperationNtfArr : Array = new Array(); //array elem is class Object
	var m_NPCCardBag : SCardBag = new SCardBag(); //class Object
	var m_MyResult : SPVEResult = new SPVEResult(); //class Object
	var m_NPCResult : SPVEResult = new SPVEResult(); //class Object
	var m_Drop : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_OperationNtfArr.length; i0++)
		{
			arr0.push(m_OperationNtfArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		arr[1] = m_NPCCardBag.serialize(0);
		arr[2] = m_MyResult.serialize(0);
		arr[3] = m_NPCResult.serialize(0);
		var arr4 : Array = new Array();
		for(var i4 : int = 0; i4 < m_Drop.length; i4++)
		{
			arr4.push(m_Drop[i4].serialize(0));//array elem is class Object
		}
		arr[4] = arr4;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SLogicOperationNtf = new SLogicOperationNtf();
			tempClass0.arrToObj(data[0][i0], 0);
			m_OperationNtfArr.push(tempClass0);//array elem is class Object
		}
		m_NPCCardBag.arrToObj(data[1], 0);
		m_MyResult.arrToObj(data[2], 0);
		m_NPCResult.arrToObj(data[3], 0);
		for(var i4 : int = 0; i4 < data[4].length; i4++)
		{
			var tempClass4 : SDrop = new SDrop();
			tempClass4.arrToObj(data[4][i4], 0);
			m_Drop.push(tempClass4);//array elem is class Object
		}
	}
}

public class CS_TESTPVE_REQ extends CProtoBase 
{
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
	}
}

public class SC_TESTPVE_ACK extends CProtoBase 
{
	var m_NPC1CardBag : SCardBag = new SCardBag(); //class Object
	var m_NPC2CardBag : SCardBag = new SCardBag(); //class Object
	var m_NPC1Result : SPVEResult = new SPVEResult(); //class Object
	var m_NPC2Result : SPVEResult = new SPVEResult(); //class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_NPC1CardBag.serialize(0);
		arr[1] = m_NPC2CardBag.serialize(0);
		arr[2] = m_NPC1Result.serialize(0);
		arr[3] = m_NPC2Result.serialize(0);
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_NPC1CardBag.arrToObj(data[0], 0);
		m_NPC2CardBag.arrToObj(data[1], 0);
		m_NPC1Result.arrToObj(data[2], 0);
		m_NPC2Result.arrToObj(data[3], 0);
	}
}

public class CS_SELLCARDS_REQ extends CProtoBase 
{
	var m_CardUidsArr : Array = new Array();//array elem is int
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_CardUidsArr.length; i0++)
		{
			arr0.push(m_CardUidsArr[i0]);//array elem is int
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			m_CardUidsArr.push(data[0][i0]);//array elem is int
		}
	}
}

public class SC_SELLCARDS_ACK extends CProtoBase 
{
	var m_OperationNtfArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_OperationNtfArr.length; i0++)
		{
			arr0.push(m_OperationNtfArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SLogicOperationNtf = new SLogicOperationNtf();
			tempClass0.arrToObj(data[0][i0], 0);
			m_OperationNtfArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class CS_POSITIONCHANGE_REQ extends CProtoBase 
{
	var m_SrcCardUid : int = 0;
	var m_DesCardUid : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_SrcCardUid;
		arr[1] = m_DesCardUid;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_SrcCardUid = data[0];
		m_DesCardUid = data[1];
	}
}

public class SC_POSITIONCHANGE_ACK extends CProtoBase 
{
	var m_OperationNtfArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_OperationNtfArr.length; i0++)
		{
			arr0.push(m_OperationNtfArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SLogicOperationNtf = new SLogicOperationNtf();
			tempClass0.arrToObj(data[0][i0], 0);
			m_OperationNtfArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class CS_UPGRADEEQUIPLEVEL_REQ extends CProtoBase 
{
	var m_EquipMainUid : int = 0;
	var m_EquipUidsArr : Array = new Array();//array elem is int
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_EquipMainUid;
		var arr1 : Array = new Array();
		for(var i1 : int = 0; i1 < m_EquipUidsArr.length; i1++)
		{
			arr1.push(m_EquipUidsArr[i1]);//array elem is int
		}
		arr[1] = arr1;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_EquipMainUid = data[0];
		for(var i1 : int = 0; i1 < data[1].length; i1++)
		{
			m_EquipUidsArr.push(data[1][i1]);//array elem is int
		}
	}
}

public class SC_UPGRADEEQUIPLEVEL_ACK extends CProtoBase 
{
	var m_OperationNtfArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_OperationNtfArr.length; i0++)
		{
			arr0.push(m_OperationNtfArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SLogicOperationNtf = new SLogicOperationNtf();
			tempClass0.arrToObj(data[0][i0], 0);
			m_OperationNtfArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class CS_EQUIPWORD_REQ extends CProtoBase 
{
	var m_CardUid : int = 0;
	var m_EquipUid : int = 0;
	var m_EquipType : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_CardUid;
		arr[1] = m_EquipUid;
		arr[2] = m_EquipType;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_CardUid = data[0];
		m_EquipUid = data[1];
		m_EquipType = data[2];
	}
}

public class SC_EQUIPWORD_ACK extends CProtoBase 
{
	var m_OperationNtfArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_OperationNtfArr.length; i0++)
		{
			arr0.push(m_OperationNtfArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SLogicOperationNtf = new SLogicOperationNtf();
			tempClass0.arrToObj(data[0][i0], 0);
			m_OperationNtfArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class CS_EQUIPREST_REQ extends CProtoBase 
{
	var m_EquipUid : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_EquipUid;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_EquipUid = data[0];
	}
}

public class SC_EQUIPREST_ACK extends CProtoBase 
{
	var m_OperationNtfArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_OperationNtfArr.length; i0++)
		{
			arr0.push(m_OperationNtfArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SLogicOperationNtf = new SLogicOperationNtf();
			tempClass0.arrToObj(data[0][i0], 0);
			m_OperationNtfArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class CS_SELLEQUIPS_REQ extends CProtoBase 
{
	var m_EquipUidsArr : Array = new Array();//array elem is int
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_EquipUidsArr.length; i0++)
		{
			arr0.push(m_EquipUidsArr[i0]);//array elem is int
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			m_EquipUidsArr.push(data[0][i0]);//array elem is int
		}
	}
}

public class SC_SELLEQUIPS_ACK extends CProtoBase 
{
	var m_OperationNtfArr : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_OperationNtfArr.length; i0++)
		{
			arr0.push(m_OperationNtfArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SLogicOperationNtf = new SLogicOperationNtf();
			tempClass0.arrToObj(data[0][i0], 0);
			m_OperationNtfArr.push(tempClass0);//array elem is class Object
		}
	}
}

public class CS_SUMMON_REQ extends CProtoBase 
{
	var m_SummonType : int = 0;
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		arr[0] = m_SummonType;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		m_SummonType = data[0];
	}
}

public class SC_SUMMON_ACK extends CProtoBase 
{
	var m_OperationNtfArr : Array = new Array(); //array elem is class Object
	var m_Drop : Array = new Array(); //array elem is class Object
	public function serialize (select : int /*effect in union class*/) : Array
	{
		var arr : Array = new Array();
		var arr0 : Array = new Array();
		for(var i0 : int = 0; i0 < m_OperationNtfArr.length; i0++)
		{
			arr0.push(m_OperationNtfArr[i0].serialize(0));//array elem is class Object
		}
		arr[0] = arr0;
		var arr1 : Array = new Array();
		for(var i1 : int = 0; i1 < m_Drop.length; i1++)
		{
			arr1.push(m_Drop[i1].serialize(0));//array elem is class Object
		}
		arr[1] = arr1;
		return arr;
	}
	public function arrToObj (data : Array, select : int /*effect in union class*/)
	{
		for(var i0 : int = 0; i0 < data[0].length; i0++)
		{
			var tempClass0 : SLogicOperationNtf = new SLogicOperationNtf();
			tempClass0.arrToObj(data[0][i0], 0);
			m_OperationNtfArr.push(tempClass0);//array elem is class Object
		}
		for(var i1 : int = 0; i1 < data[1].length; i1++)
		{
			var tempClass1 : SDrop = new SDrop();
			tempClass1.arrToObj(data[1][i1], 0);
			m_Drop.push(tempClass1);//array elem is class Object
		}
	}
}

static var CSID_LOGIN_REQ : int = 1;
static var SCID_LOGIN_ACK : int = 2;
static var CSID_CREATE_REQ : int = 3;
static var SCID_CREATE_ACK : int = 4;
static var CSID_GETINFO_REQ : int = 5;
static var SCID_GETINFO_ACK : int = 6;
static var CSID_REGISTER_REQ : int = 7;
static var SCID_REGISTER_ACK : int = 8;
static var CSID_UPGRADELEVEL_REQ : int = 100;
static var SCID_UPGRADELEVEL_ACK : int = 101;
static var CSID_UPGRADESTAR_REQ : int = 102;
static var SCID_UPGRADESTAR_ACK : int = 103;
static var CSID_LOOTLOGINREWARD_REQ : int = 104;
static var SCID_LOOTLOGINREWARD_ACK : int = 105;
static var CSID_PVE_REQ : int = 200;
static var SCID_PVE_ACK : int = 201;
static var CSID_SELLCARDS_REQ : int = 202;
static var SCID_SELLCARDS_ACK : int = 203;
static var CSID_POSITIONCHANGE_REQ : int = 204;
static var SCID_POSITIONCHANGE_ACK : int = 205;
static var CSID_UPGRADEEQUIPLEVEL_REQ : int = 206;
static var SCID_UPGRADEEQUIPLEVEL_ACK : int = 207;
static var CSID_EQUIPWORD_REQ : int = 208;
static var SCID_EQUIPWORD_ACK : int = 209;
static var CSID_EQUIPREST_REQ : int = 210;
static var SCID_EQUIPREST_ACK : int = 211;
static var CSID_SELLEQUIPS_REQ : int = 212;
static var SCID_SELLEQUIPS_ACK : int = 213;
static var CSID_SUMMON_REQ : int = 214;
static var SCID_SUMMON_ACK : int = 215;
static var CSID_GETDIRTYTIME_REQ : int = 300;
static var SCID_GETDIRTYTIME_ACK : int = 301;
static var CSID_TESTPVE_REQ : int = 1000;
static var SCID_TESTPVE_ACK : int = 1001;
public class MsgCoder 
{
	public static function decode (message : int, data : Array) : CProtoBase
	{	
		
		if (message == proto.CSID_LOGIN_REQ)
		{
			var proto1 :CS_LOGIN_REQ = new CS_LOGIN_REQ();
			proto1.arrToObj(data, 0);
			return proto1;
		}
		else if (message == proto.SCID_LOGIN_ACK)
		{
			var proto2 :SC_LOGIN_ACK = new SC_LOGIN_ACK();
			proto2.arrToObj(data, 0);
			return proto2;
		}
		else if (message == proto.CSID_CREATE_REQ)
		{
			var proto3 :CS_CREATE_REQ = new CS_CREATE_REQ();
			proto3.arrToObj(data, 0);
			return proto3;
		}
		else if (message == proto.SCID_CREATE_ACK)
		{
			var proto4 :SC_CREATE_ACK = new SC_CREATE_ACK();
			proto4.arrToObj(data, 0);
			return proto4;
		}
		else if (message == proto.CSID_GETINFO_REQ)
		{
			var proto5 :CS_GETINFO_REQ = new CS_GETINFO_REQ();
			proto5.arrToObj(data, 0);
			return proto5;
		}
		else if (message == proto.SCID_GETINFO_ACK)
		{
			var proto6 :SC_GETINFO_ACK = new SC_GETINFO_ACK();
			proto6.arrToObj(data, 0);
			return proto6;
		}
		else if (message == proto.CSID_REGISTER_REQ)
		{
			var proto7 :CS_REGISTER_REQ = new CS_REGISTER_REQ();
			proto7.arrToObj(data, 0);
			return proto7;
		}
		else if (message == proto.SCID_REGISTER_ACK)
		{
			var proto8 :SC_REGISTER_ACK = new SC_REGISTER_ACK();
			proto8.arrToObj(data, 0);
			return proto8;
		}
		else if (message == proto.CSID_UPGRADELEVEL_REQ)
		{
			var proto100 :CS_UPGRADELEVEL_REQ = new CS_UPGRADELEVEL_REQ();
			proto100.arrToObj(data, 0);
			return proto100;
		}
		else if (message == proto.SCID_UPGRADELEVEL_ACK)
		{
			var proto101 :SC_UPGRADELEVEL_ACK = new SC_UPGRADELEVEL_ACK();
			proto101.arrToObj(data, 0);
			return proto101;
		}
		else if (message == proto.CSID_UPGRADESTAR_REQ)
		{
			var proto102 :CS_UPGRADESTAR_REQ = new CS_UPGRADESTAR_REQ();
			proto102.arrToObj(data, 0);
			return proto102;
		}
		else if (message == proto.SCID_UPGRADESTAR_ACK)
		{
			var proto103 :SC_UPGRADESTAR_ACK = new SC_UPGRADESTAR_ACK();
			proto103.arrToObj(data, 0);
			return proto103;
		}
		else if (message == proto.CSID_LOOTLOGINREWARD_REQ)
		{
			var proto104 :CS_LOOTLOGINREWARD_REQ = new CS_LOOTLOGINREWARD_REQ();
			proto104.arrToObj(data, 0);
			return proto104;
		}
		else if (message == proto.SCID_LOOTLOGINREWARD_ACK)
		{
			var proto105 :SC_LOOTLOGINREWARD_ACK = new SC_LOOTLOGINREWARD_ACK();
			proto105.arrToObj(data, 0);
			return proto105;
		}
		else if (message == proto.CSID_PVE_REQ)
		{
			var proto200 :CS_PVE_REQ = new CS_PVE_REQ();
			proto200.arrToObj(data, 0);
			return proto200;
		}
		else if (message == proto.SCID_PVE_ACK)
		{
			var proto201 :SC_PVE_ACK = new SC_PVE_ACK();
			proto201.arrToObj(data, 0);
			return proto201;
		}
		else if (message == proto.CSID_SELLCARDS_REQ)
		{
			var proto202 :CS_SELLCARDS_REQ = new CS_SELLCARDS_REQ();
			proto202.arrToObj(data, 0);
			return proto202;
		}
		else if (message == proto.SCID_SELLCARDS_ACK)
		{
			var proto203 :SC_SELLCARDS_ACK = new SC_SELLCARDS_ACK();
			proto203.arrToObj(data, 0);
			return proto203;
		}
		else if (message == proto.CSID_POSITIONCHANGE_REQ)
		{
			var proto204 :CS_POSITIONCHANGE_REQ = new CS_POSITIONCHANGE_REQ();
			proto204.arrToObj(data, 0);
			return proto204;
		}
		else if (message == proto.SCID_POSITIONCHANGE_ACK)
		{
			var proto205 :SC_POSITIONCHANGE_ACK = new SC_POSITIONCHANGE_ACK();
			proto205.arrToObj(data, 0);
			return proto205;
		}
		else if (message == proto.CSID_UPGRADEEQUIPLEVEL_REQ)
		{
			var proto206 :CS_UPGRADEEQUIPLEVEL_REQ = new CS_UPGRADEEQUIPLEVEL_REQ();
			proto206.arrToObj(data, 0);
			return proto206;
		}
		else if (message == proto.SCID_UPGRADEEQUIPLEVEL_ACK)
		{
			var proto207 :SC_UPGRADEEQUIPLEVEL_ACK = new SC_UPGRADEEQUIPLEVEL_ACK();
			proto207.arrToObj(data, 0);
			return proto207;
		}
		else if (message == proto.CSID_EQUIPWORD_REQ)
		{
			var proto208 :CS_EQUIPWORD_REQ = new CS_EQUIPWORD_REQ();
			proto208.arrToObj(data, 0);
			return proto208;
		}
		else if (message == proto.SCID_EQUIPWORD_ACK)
		{
			var proto209 :SC_EQUIPWORD_ACK = new SC_EQUIPWORD_ACK();
			proto209.arrToObj(data, 0);
			return proto209;
		}
		else if (message == proto.CSID_EQUIPREST_REQ)
		{
			var proto210 :CS_EQUIPREST_REQ = new CS_EQUIPREST_REQ();
			proto210.arrToObj(data, 0);
			return proto210;
		}
		else if (message == proto.SCID_EQUIPREST_ACK)
		{
			var proto211 :SC_EQUIPREST_ACK = new SC_EQUIPREST_ACK();
			proto211.arrToObj(data, 0);
			return proto211;
		}
		else if (message == proto.CSID_SELLEQUIPS_REQ)
		{
			var proto212 :CS_SELLEQUIPS_REQ = new CS_SELLEQUIPS_REQ();
			proto212.arrToObj(data, 0);
			return proto212;
		}
		else if (message == proto.SCID_SELLEQUIPS_ACK)
		{
			var proto213 :SC_SELLEQUIPS_ACK = new SC_SELLEQUIPS_ACK();
			proto213.arrToObj(data, 0);
			return proto213;
		}
		else if (message == proto.CSID_SUMMON_REQ)
		{
			var proto214 :CS_SUMMON_REQ = new CS_SUMMON_REQ();
			proto214.arrToObj(data, 0);
			return proto214;
		}
		else if (message == proto.SCID_SUMMON_ACK)
		{
			var proto215 :SC_SUMMON_ACK = new SC_SUMMON_ACK();
			proto215.arrToObj(data, 0);
			return proto215;
		}
		else if (message == proto.CSID_GETDIRTYTIME_REQ)
		{
			var proto300 :CS_GETDIRTYTIME_REQ = new CS_GETDIRTYTIME_REQ();
			proto300.arrToObj(data, 0);
			return proto300;
		}
		else if (message == proto.SCID_GETDIRTYTIME_ACK)
		{
			var proto301 :SC_GETDIRTYTIME_ACK = new SC_GETDIRTYTIME_ACK();
			proto301.arrToObj(data, 0);
			return proto301;
		}
		else if (message == proto.CSID_TESTPVE_REQ)
		{
			var proto1000 :CS_TESTPVE_REQ = new CS_TESTPVE_REQ();
			proto1000.arrToObj(data, 0);
			return proto1000;
		}
		else if (message == proto.SCID_TESTPVE_ACK)
		{
			var proto1001 :SC_TESTPVE_ACK = new SC_TESTPVE_ACK();
			proto1001.arrToObj(data, 0);
			return proto1001;
		}
		else
		{
			return null;
		}
	}
	public static function encode (message : int, data : CProtoBase) : Array
	{	
		if (message == proto.CSID_LOGIN_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_LOGIN_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_CREATE_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_CREATE_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_GETINFO_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_GETINFO_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_REGISTER_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_REGISTER_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_UPGRADELEVEL_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_UPGRADELEVEL_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_UPGRADESTAR_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_UPGRADESTAR_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_LOOTLOGINREWARD_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_LOOTLOGINREWARD_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_PVE_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_PVE_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_SELLCARDS_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_SELLCARDS_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_POSITIONCHANGE_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_POSITIONCHANGE_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_UPGRADEEQUIPLEVEL_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_UPGRADEEQUIPLEVEL_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_EQUIPWORD_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_EQUIPWORD_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_EQUIPREST_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_EQUIPREST_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_SELLEQUIPS_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_SELLEQUIPS_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_SUMMON_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_SUMMON_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_GETDIRTYTIME_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_GETDIRTYTIME_ACK)
		{
			return data.serialize(0);
		}
		else if (message == proto.CSID_TESTPVE_REQ)
		{
			return data.serialize(0);
		}
		else if (message == proto.SCID_TESTPVE_ACK)
		{
			return data.serialize(0);
		}
		else
		{
			return null;
		}
	}
}