using System.Collections.Generic;
using System.Net;
using System.IO;
using System.Text;
using LitJson;
using UnityEngine;
using System.Collections;
namespace Proto
{


	public class CS_LOGIN_REQ
	{
		public string __UserName = "";//string
		public string __UserPwd = "";//string
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserName"] = __UserName;
			jd["__UserPwd"] = __UserPwd;
			return jd;
		}
	}

	public class SC_LOGIN_ACK
	{
		public string __Token = "";//string
		public string __TimeStamp = "";//string
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Token"] = __Token;
			jd["__TimeStamp"] = __TimeStamp;
			return jd;
		}
	}

	public class CS_REGISTER_REQ
	{
		public string __UserName = "";//string
		public string __UserPwd = "";//string
		public string __MacAddress = "";//string
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserName"] = __UserName;
			jd["__UserPwd"] = __UserPwd;
			jd["__MacAddress"] = __MacAddress;
			return jd;
		}
	}

	public class SC_REGISTER_ACK
	{
		public string __Token = "";//string
		public string __TimeStamp = "";//string
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Token"] = __Token;
			jd["__TimeStamp"] = __TimeStamp;
			return jd;
		}
	}

	public class CS_CREATE_REQ
	{
		public string __Name = "";//string
		public int __CountryId = 0;
		public int __CaptainId = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Name"] = __Name;
			jd["__CountryId"] = __CountryId;
			jd["__CaptainId"] = __CaptainId;
			return jd;
		}
	}

	public class SC_CREATE_ACK
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class SDrop
	{
		public int __Id = 0;
		public int __Param1 = 0;
		public int __Param2 = 0;
		public int __Param3 = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Id"] = __Id;
			jd["__Param1"] = __Param1;
			jd["__Param2"] = __Param2;
			jd["__Param3"] = __Param3;
			return jd;
		}
	}

	public class SInfo
	{
		public int __Type = 0;
		public string __Value = "";//string
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Type"] = __Type;
			jd["__Value"] = __Value;
			return jd;
		}
	}

	public class SProperties
	{
		public string __Name = "";//string
		public SInfo[] __InfoArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Name"] = __Name;
			jd["__InfoArr"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __InfoArr)
			{
				JsonData temp = var.toJsonData();
				jd["__InfoArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SCardInfos
	{
		public int __Uid = 0;
		public int __Cid = 0;
		public int __Index = 0;
		public SInfo[] __InfoArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Uid"] = __Uid;
			jd["__Cid"] = __Cid;
			jd["__Index"] = __Index;
			jd["__InfoArr"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __InfoArr)
			{
				JsonData temp = var.toJsonData();
				jd["__InfoArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SCardBag
	{
		public SCardInfos[] __CardArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__CardArr"] = new JsonData(JsonType.Array);
			foreach(SCardInfos var in __CardArr)
			{
				JsonData temp = var.toJsonData();
				jd["__CardArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SPositionInfo
	{
		public int __Position = 0;
		public int[] __CardUidsArr;//array elem is int
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Position"] = __Position;
			jd["__CardUidsArr"] = new JsonData(JsonType.Array);
			foreach(int var in __CardUidsArr)
			{
				jd["__CardUidsArr"].asList().Add(var);//array elem is int
			}
			return jd;
		}
	}

	public class SFormation
	{
		public SPositionInfo[] __PositionInfoArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__PositionInfoArr"] = new JsonData(JsonType.Array);
			foreach(SPositionInfo var in __PositionInfoArr)
			{
				JsonData temp = var.toJsonData();
				jd["__PositionInfoArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SEquipInfos
	{
		public SInfo[] __InfoArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__InfoArr"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __InfoArr)
			{
				JsonData temp = var.toJsonData();
				jd["__InfoArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SEquipBag
	{
		public SEquipInfos[] __EquipArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__EquipArr"] = new JsonData(JsonType.Array);
			foreach(SEquipInfos var in __EquipArr)
			{
				JsonData temp = var.toJsonData();
				jd["__EquipArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SFragmentInfos
	{
		public SInfo[] __InfoArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__InfoArr"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __InfoArr)
			{
				JsonData temp = var.toJsonData();
				jd["__InfoArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SFragmentBag
	{
		public SFragmentInfos[] __FragmentArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__FragmentArr"] = new JsonData(JsonType.Array);
			foreach(SFragmentInfos var in __FragmentArr)
			{
				JsonData temp = var.toJsonData();
				jd["__FragmentArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SMaterialInfos
	{
		public SInfo[] __InfoArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__InfoArr"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __InfoArr)
			{
				JsonData temp = var.toJsonData();
				jd["__InfoArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SMaterialBag
	{
		public SMaterialInfos[] __MaterialArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__MaterialArr"] = new JsonData(JsonType.Array);
			foreach(SMaterialInfos var in __MaterialArr)
			{
				JsonData temp = var.toJsonData();
				jd["__MaterialArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SLimit
	{
		public int __LoginRewardId = 0;
		public int __LoginRewardDay = 0;
		public int __LoginRewardLooted = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__LoginRewardId"] = __LoginRewardId;
			jd["__LoginRewardDay"] = __LoginRewardDay;
			jd["__LoginRewardLooted"] = __LoginRewardLooted;
			return jd;
		}
	}

	public class SChildMapInfo
	{
		public int __ChildMapId = 0;
		public int __State = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ChildMapId"] = __ChildMapId;
			jd["__State"] = __State;
			return jd;
		}
	}

	public class SMapInfo
	{
		public int __MapId = 0;
		public SChildMapInfo[] __ChildMapArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__MapId"] = __MapId;
			jd["__ChildMapArr"] = new JsonData(JsonType.Array);
			foreach(SChildMapInfo var in __ChildMapArr)
			{
				JsonData temp = var.toJsonData();
				jd["__ChildMapArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SMap
	{
		public int __MapType = 0;
		public SMapInfo[] __MapArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__MapType"] = __MapType;
			jd["__MapArr"] = new JsonData(JsonType.Array);
			foreach(SMapInfo var in __MapArr)
			{
				JsonData temp = var.toJsonData();
				jd["__MapArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SMapGather
	{
		public SMap[] __MapGahterArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__MapGahterArr"] = new JsonData(JsonType.Array);
			foreach(SMap var in __MapGahterArr)
			{
				JsonData temp = var.toJsonData();
				jd["__MapGahterArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SUserInfo
	{
		public SProperties __Property = new SProperties(); //class object SProperties
		public SCardBag __CardBag = new SCardBag(); //class object SCardBag
		public SFormation __Formation = new SFormation(); //class object SFormation
		public SEquipBag __EquipBag = new SEquipBag(); //class object SEquipBag
		public SLimit __Limit = new SLimit(); //class object SLimit
		public SFragmentBag __FragmentBag = new SFragmentBag(); //class object SFragmentBag
		public SMaterialBag __MaterialBag = new SMaterialBag(); //class object SMaterialBag
		public SMapGather __Maps = new SMapGather(); //class object SMapGather
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			switch(select)
			{
				case 1:
				{
				jd["__Property"] = new JsonData(JsonType.Object);
				jd["__Property"] = __Property.toJsonData();
				}
				break;
				case 2:
				{
				jd["__CardBag"] = new JsonData(JsonType.Object);
				jd["__CardBag"] = __CardBag.toJsonData();
				}
				break;
				case 6:
				{
				jd["__Formation"] = new JsonData(JsonType.Object);
				jd["__Formation"] = __Formation.toJsonData();
				}
				break;
				case 3:
				{
				jd["__EquipBag"] = new JsonData(JsonType.Object);
				jd["__EquipBag"] = __EquipBag.toJsonData();
				}
				break;
				case 7:
				{
				jd["__Limit"] = new JsonData(JsonType.Object);
				jd["__Limit"] = __Limit.toJsonData();
				}
				break;
				case 5:
				{
				jd["__FragmentBag"] = new JsonData(JsonType.Object);
				jd["__FragmentBag"] = __FragmentBag.toJsonData();
				}
				break;
				case 4:
				{
				jd["__MaterialBag"] = new JsonData(JsonType.Object);
				jd["__MaterialBag"] = __MaterialBag.toJsonData();
				}
				break;
				case 8:
				{
				jd["__Maps"] = new JsonData(JsonType.Object);
				jd["__Maps"] = __Maps.toJsonData();
				}
				break;
			}
			return jd;
		}
	}

	public class CS_GETINFO_REQ
	{
		public int __InfoType = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__InfoType"] = __InfoType;
			return jd;
		}
	}

	public class SC_GETINFO_ACK
	{
		public int __InfoType = 0;
		public SUserInfo __Info = new SUserInfo(); //class object SUserInfo
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__InfoType"] = __InfoType;
			jd["__Info"] = new JsonData(JsonType.Object);
			jd["__Info"] = __Info.toJsonData(__InfoType);
			return jd;
		}
	}

	public class SPropertyChangeNtf
	{
		public SInfo[] __InfoArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__InfoArr"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __InfoArr)
			{
				JsonData temp = var.toJsonData();
				jd["__InfoArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SCardChangeNtf
	{
		public int __CardUid = 0;
		public SInfo[] __InfoArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__CardUid"] = __CardUid;
			jd["__InfoArr"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __InfoArr)
			{
				JsonData temp = var.toJsonData();
				jd["__InfoArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SCardDelNtf
	{
		public int[] __CardUidsArr;//array elem is int
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__CardUidsArr"] = new JsonData(JsonType.Array);
			foreach(int var in __CardUidsArr)
			{
				jd["__CardUidsArr"].asList().Add(var);//array elem is int
			}
			return jd;
		}
	}

	public class SCardAddNtf
	{
		public SCardInfos[] __NewCard; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__NewCard"] = new JsonData(JsonType.Array);
			foreach(SCardInfos var in __NewCard)
			{
				JsonData temp = var.toJsonData();
				jd["__NewCard"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SEquipAddNtf
	{
		public SEquipInfos[] __NewEquip; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__NewEquip"] = new JsonData(JsonType.Array);
			foreach(SEquipInfos var in __NewEquip)
			{
				JsonData temp = var.toJsonData();
				jd["__NewEquip"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SEquipDelNtf
	{
		public int[] __EquipUidsArr;//array elem is int
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__EquipUidsArr"] = new JsonData(JsonType.Array);
			foreach(int var in __EquipUidsArr)
			{
				jd["__EquipUidsArr"].asList().Add(var);//array elem is int
			}
			return jd;
		}
	}

	public class SEquipChangeNtf
	{
		public int __EquipUid = 0;
		public SInfo[] __InfoArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__EquipUid"] = __EquipUid;
			jd["__InfoArr"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __InfoArr)
			{
				JsonData temp = var.toJsonData();
				jd["__InfoArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SFragmentOperNtf
	{
		public SFragmentInfos[] __Fragment; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Fragment"] = new JsonData(JsonType.Array);
			foreach(SFragmentInfos var in __Fragment)
			{
				JsonData temp = var.toJsonData();
				jd["__Fragment"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SMaterialOperNtf
	{
		public SMaterialInfos[] __Material; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Material"] = new JsonData(JsonType.Array);
			foreach(SMaterialInfos var in __Material)
			{
				JsonData temp = var.toJsonData();
				jd["__Material"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SDirtyTimeNtf
	{
		public SInfo[] __DirtyTime; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__DirtyTime"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __DirtyTime)
			{
				JsonData temp = var.toJsonData();
				jd["__DirtyTime"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SOperationNtf
	{
		public SPropertyChangeNtf __PropertyChangeNtf = new SPropertyChangeNtf(); //class object SPropertyChangeNtf
		public SCardChangeNtf __CardChangeNtf = new SCardChangeNtf(); //class object SCardChangeNtf
		public SCardDelNtf __CardDelNtf = new SCardDelNtf(); //class object SCardDelNtf
		public SCardAddNtf __CardAddNtf = new SCardAddNtf(); //class object SCardAddNtf
		public SEquipAddNtf __EquipAddNtf = new SEquipAddNtf(); //class object SEquipAddNtf
		public SEquipDelNtf __EquipDelNtf = new SEquipDelNtf(); //class object SEquipDelNtf
		public SEquipChangeNtf __EquipChangeNtf = new SEquipChangeNtf(); //class object SEquipChangeNtf
		public SFragmentOperNtf __FragmentOperNtf = new SFragmentOperNtf(); //class object SFragmentOperNtf
		public SMaterialOperNtf __MaterialOperNtf = new SMaterialOperNtf(); //class object SMaterialOperNtf
		public SFormation __FormationChangeNtf = new SFormation(); //class object SFormation
		public SDirtyTimeNtf __DirtyTimeNtf = new SDirtyTimeNtf(); //class object SDirtyTimeNtf
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			switch(select)
			{
				case 1:
				{
				jd["__PropertyChangeNtf"] = new JsonData(JsonType.Object);
				jd["__PropertyChangeNtf"] = __PropertyChangeNtf.toJsonData();
				}
				break;
				case 2:
				{
				jd["__CardChangeNtf"] = new JsonData(JsonType.Object);
				jd["__CardChangeNtf"] = __CardChangeNtf.toJsonData();
				}
				break;
				case 3:
				{
				jd["__CardDelNtf"] = new JsonData(JsonType.Object);
				jd["__CardDelNtf"] = __CardDelNtf.toJsonData();
				}
				break;
				case 4:
				{
				jd["__CardAddNtf"] = new JsonData(JsonType.Object);
				jd["__CardAddNtf"] = __CardAddNtf.toJsonData();
				}
				break;
				case 5:
				{
				jd["__EquipAddNtf"] = new JsonData(JsonType.Object);
				jd["__EquipAddNtf"] = __EquipAddNtf.toJsonData();
				}
				break;
				case 6:
				{
				jd["__EquipDelNtf"] = new JsonData(JsonType.Object);
				jd["__EquipDelNtf"] = __EquipDelNtf.toJsonData();
				}
				break;
				case 7:
				{
				jd["__EquipChangeNtf"] = new JsonData(JsonType.Object);
				jd["__EquipChangeNtf"] = __EquipChangeNtf.toJsonData();
				}
				break;
				case 8:
				{
				jd["__FragmentOperNtf"] = new JsonData(JsonType.Object);
				jd["__FragmentOperNtf"] = __FragmentOperNtf.toJsonData();
				}
				break;
				case 9:
				{
				jd["__MaterialOperNtf"] = new JsonData(JsonType.Object);
				jd["__MaterialOperNtf"] = __MaterialOperNtf.toJsonData();
				}
				break;
				case 10:
				{
				jd["__FormationChangeNtf"] = new JsonData(JsonType.Object);
				jd["__FormationChangeNtf"] = __FormationChangeNtf.toJsonData();
				}
				break;
				case 20:
				{
				jd["__DirtyTimeNtf"] = new JsonData(JsonType.Object);
				jd["__DirtyTimeNtf"] = __DirtyTimeNtf.toJsonData();
				}
				break;
			}
			return jd;
		}
	}

	public class SLogicOperationNtf
	{
		public int __NtfType = 0;
		public SOperationNtf __Operation = new SOperationNtf(); //class object SOperationNtf
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__NtfType"] = __NtfType;
			jd["__Operation"] = new JsonData(JsonType.Object);
			jd["__Operation"] = __Operation.toJsonData(__NtfType);
			return jd;
		}
	}

	public class CS_GETDIRTYTIME_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class SC_GETDIRTYTIME_ACK
	{
		public SInfo[] __DirtyTime; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__DirtyTime"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __DirtyTime)
			{
				JsonData temp = var.toJsonData();
				jd["__DirtyTime"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_UPGRADELEVEL_REQ
	{
		public int __CardMainUid = 0;
		public int[] __CardUidsArr;//array elem is int
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__CardMainUid"] = __CardMainUid;
			jd["__CardUidsArr"] = new JsonData(JsonType.Array);
			foreach(int var in __CardUidsArr)
			{
				jd["__CardUidsArr"].asList().Add(var);//array elem is int
			}
			return jd;
		}
	}

	public class SC_UPGRADELEVEL_ACK
	{
		public SLogicOperationNtf[] __OperationNtfArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__OperationNtfArr"] = new JsonData(JsonType.Array);
			foreach(SLogicOperationNtf var in __OperationNtfArr)
			{
				JsonData temp = var.toJsonData();
				jd["__OperationNtfArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_UPGRADESTAR_REQ
	{
		public int __CardMainUid = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__CardMainUid"] = __CardMainUid;
			return jd;
		}
	}

	public class SC_UPGRADESTAR_ACK
	{
		public SLogicOperationNtf[] __OperationNtfArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__OperationNtfArr"] = new JsonData(JsonType.Array);
			foreach(SLogicOperationNtf var in __OperationNtfArr)
			{
				JsonData temp = var.toJsonData();
				jd["__OperationNtfArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_LOOTLOGINREWARD_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class SC_LOOTLOGINREWARD_ACK
	{
		public SLogicOperationNtf[] __OperationNtfArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__OperationNtfArr"] = new JsonData(JsonType.Array);
			foreach(SLogicOperationNtf var in __OperationNtfArr)
			{
				JsonData temp = var.toJsonData();
				jd["__OperationNtfArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_PVE_REQ
	{
		public int __MapId = 0;
		public int __ChildMapId = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__MapId"] = __MapId;
			jd["__ChildMapId"] = __ChildMapId;
			return jd;
		}
	}

	public class SPVEShotSuc
	{
		public int __ShotCardUid = 0;
		public int __DefCardUid = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ShotCardUid"] = __ShotCardUid;
			jd["__DefCardUid"] = __DefCardUid;
			return jd;
		}
	}

	public class SPVEShotFail
	{
		public int __ShotCardUid = 0;
		public int __DefCardUid = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ShotCardUid"] = __ShotCardUid;
			jd["__DefCardUid"] = __DefCardUid;
			return jd;
		}
	}

	public class SPVEResult
	{
		public SPVEShotSuc[] __ShotSuc; //array elem is class object
		public SPVEShotFail[] __ShotFail; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ShotSuc"] = new JsonData(JsonType.Array);
			foreach(SPVEShotSuc var in __ShotSuc)
			{
				JsonData temp = var.toJsonData();
				jd["__ShotSuc"].asList().Add(temp);//array elem is class object
			}
			jd["__ShotFail"] = new JsonData(JsonType.Array);
			foreach(SPVEShotFail var in __ShotFail)
			{
				JsonData temp = var.toJsonData();
				jd["__ShotFail"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SC_PVE_ACK
	{
		public SLogicOperationNtf[] __OperationNtfArr; //array elem is class object
		public SCardBag __NPCCardBag = new SCardBag(); //class object SCardBag
		public SPVEResult __MyResult = new SPVEResult(); //class object SPVEResult
		public SPVEResult __NPCResult = new SPVEResult(); //class object SPVEResult
		public SDrop[] __Drop; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__OperationNtfArr"] = new JsonData(JsonType.Array);
			foreach(SLogicOperationNtf var in __OperationNtfArr)
			{
				JsonData temp = var.toJsonData();
				jd["__OperationNtfArr"].asList().Add(temp);//array elem is class object
			}
			jd["__NPCCardBag"] = new JsonData(JsonType.Object);
			jd["__NPCCardBag"] = __NPCCardBag.toJsonData();
			jd["__MyResult"] = new JsonData(JsonType.Object);
			jd["__MyResult"] = __MyResult.toJsonData();
			jd["__NPCResult"] = new JsonData(JsonType.Object);
			jd["__NPCResult"] = __NPCResult.toJsonData();
			jd["__Drop"] = new JsonData(JsonType.Array);
			foreach(SDrop var in __Drop)
			{
				JsonData temp = var.toJsonData();
				jd["__Drop"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_TESTPVE_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class SC_TESTPVE_ACK
	{
		public SCardBag __NPC1CardBag = new SCardBag(); //class object SCardBag
		public SCardBag __NPC2CardBag = new SCardBag(); //class object SCardBag
		public SPVEResult __NPC1Result = new SPVEResult(); //class object SPVEResult
		public SPVEResult __NPC2Result = new SPVEResult(); //class object SPVEResult
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__NPC1CardBag"] = new JsonData(JsonType.Object);
			jd["__NPC1CardBag"] = __NPC1CardBag.toJsonData();
			jd["__NPC2CardBag"] = new JsonData(JsonType.Object);
			jd["__NPC2CardBag"] = __NPC2CardBag.toJsonData();
			jd["__NPC1Result"] = new JsonData(JsonType.Object);
			jd["__NPC1Result"] = __NPC1Result.toJsonData();
			jd["__NPC2Result"] = new JsonData(JsonType.Object);
			jd["__NPC2Result"] = __NPC2Result.toJsonData();
			return jd;
		}
	}

	public class CS_REDPOINT_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class SC_REDPOINT_ACK
	{
		public SInfo[] __RedPointsArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__RedPointsArr"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __RedPointsArr)
			{
				JsonData temp = var.toJsonData();
				jd["__RedPointsArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_SELLCARDS_REQ
	{
		public int[] __CardUidsArr;//array elem is int
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__CardUidsArr"] = new JsonData(JsonType.Array);
			foreach(int var in __CardUidsArr)
			{
				jd["__CardUidsArr"].asList().Add(var);//array elem is int
			}
			return jd;
		}
	}

	public class SC_SELLCARDS_ACK
	{
		public SLogicOperationNtf[] __OperationNtfArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__OperationNtfArr"] = new JsonData(JsonType.Array);
			foreach(SLogicOperationNtf var in __OperationNtfArr)
			{
				JsonData temp = var.toJsonData();
				jd["__OperationNtfArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_POSITIONCHANGE_REQ
	{
		public int __SrcCardUid = 0;
		public int __DesCardUid = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__SrcCardUid"] = __SrcCardUid;
			jd["__DesCardUid"] = __DesCardUid;
			return jd;
		}
	}

	public class SC_POSITIONCHANGE_ACK
	{
		public SLogicOperationNtf[] __OperationNtfArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__OperationNtfArr"] = new JsonData(JsonType.Array);
			foreach(SLogicOperationNtf var in __OperationNtfArr)
			{
				JsonData temp = var.toJsonData();
				jd["__OperationNtfArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_UPGRADEEQUIPLEVEL_REQ
	{
		public int __EquipMainUid = 0;
		public int[] __EquipUidsArr;//array elem is int
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__EquipMainUid"] = __EquipMainUid;
			jd["__EquipUidsArr"] = new JsonData(JsonType.Array);
			foreach(int var in __EquipUidsArr)
			{
				jd["__EquipUidsArr"].asList().Add(var);//array elem is int
			}
			return jd;
		}
	}

	public class SC_UPGRADEEQUIPLEVEL_ACK
	{
		public SLogicOperationNtf[] __OperationNtfArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__OperationNtfArr"] = new JsonData(JsonType.Array);
			foreach(SLogicOperationNtf var in __OperationNtfArr)
			{
				JsonData temp = var.toJsonData();
				jd["__OperationNtfArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_EQUIPWORD_REQ
	{
		public int __CardUid = 0;
		public int __EquipUid = 0;
		public int __EquipType = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__CardUid"] = __CardUid;
			jd["__EquipUid"] = __EquipUid;
			jd["__EquipType"] = __EquipType;
			return jd;
		}
	}

	public class SC_EQUIPWORD_ACK
	{
		public SLogicOperationNtf[] __OperationNtfArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__OperationNtfArr"] = new JsonData(JsonType.Array);
			foreach(SLogicOperationNtf var in __OperationNtfArr)
			{
				JsonData temp = var.toJsonData();
				jd["__OperationNtfArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_EQUIPREST_REQ
	{
		public int __EquipUid = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__EquipUid"] = __EquipUid;
			return jd;
		}
	}

	public class SC_EQUIPREST_ACK
	{
		public SLogicOperationNtf[] __OperationNtfArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__OperationNtfArr"] = new JsonData(JsonType.Array);
			foreach(SLogicOperationNtf var in __OperationNtfArr)
			{
				JsonData temp = var.toJsonData();
				jd["__OperationNtfArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_SELLEQUIPS_REQ
	{
		public int[] __EquipUidsArr;//array elem is int
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__EquipUidsArr"] = new JsonData(JsonType.Array);
			foreach(int var in __EquipUidsArr)
			{
				jd["__EquipUidsArr"].asList().Add(var);//array elem is int
			}
			return jd;
		}
	}

	public class SC_SELLEQUIPS_ACK
	{
		public SLogicOperationNtf[] __OperationNtfArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__OperationNtfArr"] = new JsonData(JsonType.Array);
			foreach(SLogicOperationNtf var in __OperationNtfArr)
			{
				JsonData temp = var.toJsonData();
				jd["__OperationNtfArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_SUMMON_REQ
	{
		public int __SummonType = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__SummonType"] = __SummonType;
			return jd;
		}
	}

	public class SC_SUMMON_ACK
	{
		public SLogicOperationNtf[] __OperationNtfArr; //array elem is class object
		public SDrop[] __Drop; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__OperationNtfArr"] = new JsonData(JsonType.Array);
			foreach(SLogicOperationNtf var in __OperationNtfArr)
			{
				JsonData temp = var.toJsonData();
				jd["__OperationNtfArr"].asList().Add(temp);//array elem is class object
			}
			jd["__Drop"] = new JsonData(JsonType.Array);
			foreach(SDrop var in __Drop)
			{
				JsonData temp = var.toJsonData();
				jd["__Drop"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SC_USER_DATA_NTF
	{
		public int ____test = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["____test"] = ____test;
			return jd;
		}
	}

	public class CS_HeartBeat_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class CS_APPLYGAME_REQ
	{
		public int __DefenseId = 0;
		public int __IsReconnection = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__DefenseId"] = __DefenseId;
			jd["__IsReconnection"] = __IsReconnection;
			return jd;
		}
	}

	public class EventData
	{
		public int __EventType = 0;
		public int __EventResult = 0;
		public int __EventBehavior = 0;
		public SInfo[] __EventPositions; //array elem is class object
		public SInfo __EventRegion = new SInfo(); //class object SInfo
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__EventType"] = __EventType;
			jd["__EventResult"] = __EventResult;
			jd["__EventBehavior"] = __EventBehavior;
			jd["__EventPositions"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __EventPositions)
			{
				JsonData temp = var.toJsonData();
				jd["__EventPositions"].asList().Add(temp);//array elem is class object
			}
			jd["__EventRegion"] = new JsonData(JsonType.Object);
			jd["__EventRegion"] = __EventRegion.toJsonData();
			return jd;
		}
	}

	public class SPVPEvent
	{
		public int __EventPoint = 0;
		public EventData[] __Event; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__EventPoint"] = __EventPoint;
			jd["__Event"] = new JsonData(JsonType.Array);
			foreach(EventData var in __Event)
			{
				JsonData temp = var.toJsonData();
				jd["__Event"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SPVPEventClass
	{
		public int __Classes = 0;
		public SPVPEvent[] __ApplyPVPEvent; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Classes"] = __Classes;
			jd["__ApplyPVPEvent"] = new JsonData(JsonType.Array);
			foreach(SPVPEvent var in __ApplyPVPEvent)
			{
				JsonData temp = var.toJsonData();
				jd["__ApplyPVPEvent"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SC_FormationInfo_ACK
	{
		public int __UserId = 0;
		public SInfo[] __FormationInfo; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserId"] = __UserId;
			jd["__FormationInfo"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __FormationInfo)
			{
				JsonData temp = var.toJsonData();
				jd["__FormationInfo"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class EventLines
	{
		public int __IsSelf = 0;
		public int __HomeBallControl = 0;
		public EventData[] __EventLineData; //array elem is class object
		public SC_FormationInfo_ACK __SelfFormation = new SC_FormationInfo_ACK(); //class object SC_FormationInfo_ACK
		public SC_FormationInfo_ACK __EnemyFormation = new SC_FormationInfo_ACK(); //class object SC_FormationInfo_ACK
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__IsSelf"] = __IsSelf;
			jd["__HomeBallControl"] = __HomeBallControl;
			jd["__EventLineData"] = new JsonData(JsonType.Array);
			foreach(EventData var in __EventLineData)
			{
				JsonData temp = var.toJsonData();
				jd["__EventLineData"].asList().Add(temp);//array elem is class object
			}
			jd["__SelfFormation"] = new JsonData(JsonType.Object);
			jd["__SelfFormation"] = __SelfFormation.toJsonData();
			jd["__EnemyFormation"] = new JsonData(JsonType.Object);
			jd["__EnemyFormation"] = __EnemyFormation.toJsonData();
			return jd;
		}
	}

	public class FightBackInfo
	{
		public int __HomeScore = 0;
		public int __AwayScore = 0;
		public int __EventPoint = 0;
		public int __ExecTime = 0;
		public EventLines __EventLine = new EventLines(); //class object EventLines
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__HomeScore"] = __HomeScore;
			jd["__AwayScore"] = __AwayScore;
			jd["__EventPoint"] = __EventPoint;
			jd["__ExecTime"] = __ExecTime;
			jd["__EventLine"] = new JsonData(JsonType.Object);
			jd["__EventLine"] = __EventLine.toJsonData();
			return jd;
		}
	}

	public class SC_APPLYGAME_ACK
	{
		public int __FightRoomId = 0;
		public FightBackInfo[] __ApplyEventInfo; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__FightRoomId"] = __FightRoomId;
			jd["__ApplyEventInfo"] = new JsonData(JsonType.Array);
			foreach(FightBackInfo var in __ApplyEventInfo)
			{
				JsonData temp = var.toJsonData();
				jd["__ApplyEventInfo"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_FootballerInfo_REQ
	{
		public int __UserId = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserId"] = __UserId;
			return jd;
		}
	}

	public class SC_FootballerInfo_ACK
	{
		public SCardInfos[] __CardArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__CardArr"] = new JsonData(JsonType.Array);
			foreach(SCardInfos var in __CardArr)
			{
				JsonData temp = var.toJsonData();
				jd["__CardArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_FootballerADD_REQ
	{
		public int __FootballerID = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__FootballerID"] = __FootballerID;
			return jd;
		}
	}

	public class SC_FootballerADD_ACK
	{
		public SInfo[] __InfoArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__InfoArr"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __InfoArr)
			{
				JsonData temp = var.toJsonData();
				jd["__InfoArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_FootballerDestory_REQ
	{
		public int __FootballerID = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__FootballerID"] = __FootballerID;
			return jd;
		}
	}

	public class SC_FootballerDestory_ACK
	{
		public int __IsScuess = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__IsScuess"] = __IsScuess;
			return jd;
		}
	}

	public class CS_Property_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class SC_Property_ACK
	{
		public string __Name = "";//string
		public int __Uid = 0;
		public SInfo[] __InfoArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Name"] = __Name;
			jd["__Uid"] = __Uid;
			jd["__InfoArr"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __InfoArr)
			{
				JsonData temp = var.toJsonData();
				jd["__InfoArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class ChatInfo
	{
		public string __UserName = "";//string
		public string __ChatMessage = "";//string
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserName"] = __UserName;
			jd["__ChatMessage"] = __ChatMessage;
			return jd;
		}
	}

	public class CS_Chat_REQ
	{
		public int __UserID = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserID"] = __UserID;
			return jd;
		}
	}

	public class SC_Chat_ACK
	{
		public ChatInfo[] __ChatArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ChatArr"] = new JsonData(JsonType.Array);
			foreach(ChatInfo var in __ChatArr)
			{
				JsonData temp = var.toJsonData();
				jd["__ChatArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_ChatSetInfo_REQ
	{
		public int __UserID = 0;
		public string __Message = "";//string
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserID"] = __UserID;
			jd["__Message"] = __Message;
			return jd;
		}
	}

	public class SC_ChatSetInfo_ACK
	{
		public int __isSuccess = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__isSuccess"] = __isSuccess;
			return jd;
		}
	}

	public class FriendInfo
	{
		public string __Name = "";//string
		public string __UserID = "";//string
		public string __Club = "";//string
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Name"] = __Name;
			jd["__UserID"] = __UserID;
			jd["__Club"] = __Club;
			return jd;
		}
	}

	public class CS_Friend_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class SC_Friend_ACK
	{
		public FriendInfo[] __FriendArr; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__FriendArr"] = new JsonData(JsonType.Array);
			foreach(FriendInfo var in __FriendArr)
			{
				JsonData temp = var.toJsonData();
				jd["__FriendArr"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_FriendADD_REQ
	{
		public int __FriendID = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__FriendID"] = __FriendID;
			return jd;
		}
	}

	public class SC_FriendADD_ACK
	{
		public string __Name = "";//string
		public string __UserID = "";//string
		public string __Club = "";//string
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Name"] = __Name;
			jd["__UserID"] = __UserID;
			jd["__Club"] = __Club;
			return jd;
		}
	}

	public class CS_FriendDestory_REQ
	{
		public int __FriendID = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__FriendID"] = __FriendID;
			return jd;
		}
	}

	public class SC_FriendDestory_ACK
	{
		public int __isSuccess = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__isSuccess"] = __isSuccess;
			return jd;
		}
	}

	public class CS_FriendFind_REQ
	{
		public int __FriendID = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__FriendID"] = __FriendID;
			return jd;
		}
	}

	public class SC_FriendFind_ACK
	{
		public int __isSuccess = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__isSuccess"] = __isSuccess;
			return jd;
		}
	}

	public class CS_FormationInfo_REQ
	{
		public int __UserId = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserId"] = __UserId;
			return jd;
		}
	}

	public class CS_FormationSet_REQ
	{
		public SInfo[] __FormationInfo; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__FormationInfo"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __FormationInfo)
			{
				JsonData temp = var.toJsonData();
				jd["__FormationInfo"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SC_FormationSet_ACK
	{
		public int __FormationInfo = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__FormationInfo"] = __FormationInfo;
			return jd;
		}
	}

	public class CS_GETPLAYERINFO_REQ
	{
		public int __UserId = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserId"] = __UserId;
			return jd;
		}
	}

	public class SC_GETPLAYERINFO_ACK
	{
		public SCardInfos[] __CardArr; //array elem is class object
		public int __UserId = 0;
		public SInfo[] __FormationInfo; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__CardArr"] = new JsonData(JsonType.Array);
			foreach(SCardInfos var in __CardArr)
			{
				JsonData temp = var.toJsonData();
				jd["__CardArr"].asList().Add(temp);//array elem is class object
			}
			jd["__UserId"] = __UserId;
			jd["__FormationInfo"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __FormationInfo)
			{
				JsonData temp = var.toJsonData();
				jd["__FormationInfo"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_TACTICSGET_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class SC_TACTICSGET_ACK
	{
		public SInfo[] __TacticsInfo; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__TacticsInfo"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __TacticsInfo)
			{
				JsonData temp = var.toJsonData();
				jd["__TacticsInfo"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_TACTICSSET_REQ
	{
		public int __TacticsClass = 0;
		public int __TacticsId = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__TacticsClass"] = __TacticsClass;
			jd["__TacticsId"] = __TacticsId;
			return jd;
		}
	}

	public class SC_TACTICSSET_ACK
	{
		public int __IsSuccess = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__IsSuccess"] = __IsSuccess;
			return jd;
		}
	}

	public class CS_CLUBSHIRT_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class ShirtInfo
	{
		public int __Index = 0;
		public int __ShirtId = 0;
		public SInfo[] __ShirtData; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Index"] = __Index;
			jd["__ShirtId"] = __ShirtId;
			jd["__ShirtData"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __ShirtData)
			{
				JsonData temp = var.toJsonData();
				jd["__ShirtData"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SC_CLUBSHIRT_ACK
	{
		public ShirtInfo[] __ShirtInfos; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ShirtInfos"] = new JsonData(JsonType.Array);
			foreach(ShirtInfo var in __ShirtInfos)
			{
				JsonData temp = var.toJsonData();
				jd["__ShirtInfos"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_UPDATECLUBSHIRT_REQ
	{
		public int __ShirtIndex = 0;
		public int __MainColor = 0;
		public int __Color = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ShirtIndex"] = __ShirtIndex;
			jd["__MainColor"] = __MainColor;
			jd["__Color"] = __Color;
			return jd;
		}
	}

	public class SC_UPDATECLUBSHIRT_ACK
	{
		public int __IsSuccess = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__IsSuccess"] = __IsSuccess;
			return jd;
		}
	}

	public class CS_CLUBTEAMSIGN_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class TeamSignInfo
	{
		public int __Index = 0;
		public int __TeamSignId = 0;
		public SInfo[] __TeamSignData; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Index"] = __Index;
			jd["__TeamSignId"] = __TeamSignId;
			jd["__TeamSignData"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __TeamSignData)
			{
				JsonData temp = var.toJsonData();
				jd["__TeamSignData"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SC_CLUBTEAMSIGN_ACK
	{
		public TeamSignInfo[] __TeamSigns; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__TeamSigns"] = new JsonData(JsonType.Array);
			foreach(TeamSignInfo var in __TeamSigns)
			{
				JsonData temp = var.toJsonData();
				jd["__TeamSigns"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_UPDATETEAMSIGN_REQ
	{
		public int __TeamIndex = 0;
		public SInfo[] __TeamSignInfo; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__TeamIndex"] = __TeamIndex;
			jd["__TeamSignInfo"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __TeamSignInfo)
			{
				JsonData temp = var.toJsonData();
				jd["__TeamSignInfo"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SC_UPDATETEAMSIGN_ACK
	{
		public int __IsSuccess = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__IsSuccess"] = __IsSuccess;
			return jd;
		}
	}

	public class UpdateClubInfo
	{
		public string __ClubName = "";//string
		public string __FansName = "";//string
		public string __CountryId = "";//string
		public string __City = "";//string
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ClubName"] = __ClubName;
			jd["__FansName"] = __FansName;
			jd["__CountryId"] = __CountryId;
			jd["__City"] = __City;
			return jd;
		}
	}

	public class CS_CREATECLUB_REQ
	{
		public UpdateClubInfo __ClubInfo = new UpdateClubInfo(); //class object UpdateClubInfo
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ClubInfo"] = new JsonData(JsonType.Object);
			jd["__ClubInfo"] = __ClubInfo.toJsonData();
			return jd;
		}
	}

	public class SC_CREATECLUB_ACK
	{
		public int __IsSuccess = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__IsSuccess"] = __IsSuccess;
			return jd;
		}
	}

	public class CS_UPDATECLUB_REQ
	{
		public SInfo[] __ClubInfo; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ClubInfo"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __ClubInfo)
			{
				JsonData temp = var.toJsonData();
				jd["__ClubInfo"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SC_UPDATECLUB_ACK
	{
		public int __IsSuccess = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__IsSuccess"] = __IsSuccess;
			return jd;
		}
	}

	public class CS_GETCLUBINFO_REQ
	{
		public int __UserId = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserId"] = __UserId;
			return jd;
		}
	}

	public class SC_GETCLUBINFO_ACK
	{
		public SInfo[] __ClubData; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ClubData"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __ClubData)
			{
				JsonData temp = var.toJsonData();
				jd["__ClubData"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class Trophy
	{
		public int __Index = 0;
		public int __TrophyId = 0;
		public SInfo[] __TrophyData; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Index"] = __Index;
			jd["__TrophyId"] = __TrophyId;
			jd["__TrophyData"] = new JsonData(JsonType.Array);
			foreach(SInfo var in __TrophyData)
			{
				JsonData temp = var.toJsonData();
				jd["__TrophyData"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_GETTROPHYLIST_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class SC_GETTROPHYLIST_ACK
	{
		public Trophy[] __TrophyList; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__TrophyList"] = new JsonData(JsonType.Array);
			foreach(Trophy var in __TrophyList)
			{
				JsonData temp = var.toJsonData();
				jd["__TrophyList"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_ADDTROPHY_REQ
	{
		public int __Level = 0;
		public int __Ranking = 0;
		public int __TrophyType = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Level"] = __Level;
			jd["__Ranking"] = __Ranking;
			jd["__TrophyType"] = __TrophyType;
			return jd;
		}
	}

	public class SC_ADDTROPHY_ACK
	{
		public int __IsSuccess = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__IsSuccess"] = __IsSuccess;
			return jd;
		}
	}

	public class CS_LEAGUERANK_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class SLeagueRankInfo
	{
		public int __UserId = 0;
		public int __LastRank = 0;
		public string __ClubName = "";//string
		public int __Finish = 0;
		public int __Succ = 0;
		public int __Draw = 0;
		public int __Fail = 0;
		public int __Goal = 0;
		public int __Fumble = 0;
		public int __GoalFumble = 0;
		public int __Integral = 0;
		public int __Performance = 0;
		public TeamSignInfo __TeamSign = new TeamSignInfo(); //class object TeamSignInfo
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserId"] = __UserId;
			jd["__LastRank"] = __LastRank;
			jd["__ClubName"] = __ClubName;
			jd["__Finish"] = __Finish;
			jd["__Succ"] = __Succ;
			jd["__Draw"] = __Draw;
			jd["__Fail"] = __Fail;
			jd["__Goal"] = __Goal;
			jd["__Fumble"] = __Fumble;
			jd["__GoalFumble"] = __GoalFumble;
			jd["__Integral"] = __Integral;
			jd["__Performance"] = __Performance;
			jd["__TeamSign"] = new JsonData(JsonType.Object);
			jd["__TeamSign"] = __TeamSign.toJsonData();
			return jd;
		}
	}

	public class SC_LEAGUE_RANK_ACK
	{
		public int __LeagueRound = 0;
		public SLeagueRankInfo[] __LeagueRank; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__LeagueRound"] = __LeagueRound;
			jd["__LeagueRank"] = new JsonData(JsonType.Array);
			foreach(SLeagueRankInfo var in __LeagueRank)
			{
				JsonData temp = var.toJsonData();
				jd["__LeagueRank"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SC_LEAGUE_RANK_NTF
	{
		public SLeagueRankInfo[] __LeagueRank; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__LeagueRank"] = new JsonData(JsonType.Array);
			foreach(SLeagueRankInfo var in __LeagueRank)
			{
				JsonData temp = var.toJsonData();
				jd["__LeagueRank"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_LEAGUE_SCHEDULE_REQ
	{
		public int __UserId = 0;
		public int[] __Round;//array elem is int
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserId"] = __UserId;
			jd["__Round"] = new JsonData(JsonType.Array);
			foreach(int var in __Round)
			{
				jd["__Round"].asList().Add(var);//array elem is int
			}
			return jd;
		}
	}

	public class SLeagueScheduleInfo
	{
		public int __Round = 0;
		public int __NO = 0;
		public int __UserId1 = 0;
		public int __UserId2 = 0;
		public string __ClubName1 = "";//string
		public string __ClubName2 = "";//string
		public TeamSignInfo __TeamSign1 = new TeamSignInfo(); //class object TeamSignInfo
		public TeamSignInfo __TeamSign2 = new TeamSignInfo(); //class object TeamSignInfo
		public int __StartTime = 0;
		public int __Status = 0;
		public int[] __Score;//array elem is int
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Round"] = __Round;
			jd["__NO"] = __NO;
			jd["__UserId1"] = __UserId1;
			jd["__UserId2"] = __UserId2;
			jd["__ClubName1"] = __ClubName1;
			jd["__ClubName2"] = __ClubName2;
			jd["__TeamSign1"] = new JsonData(JsonType.Object);
			jd["__TeamSign1"] = __TeamSign1.toJsonData();
			jd["__TeamSign2"] = new JsonData(JsonType.Object);
			jd["__TeamSign2"] = __TeamSign2.toJsonData();
			jd["__StartTime"] = __StartTime;
			jd["__Status"] = __Status;
			jd["__Score"] = new JsonData(JsonType.Array);
			foreach(int var in __Score)
			{
				jd["__Score"].asList().Add(var);//array elem is int
			}
			return jd;
		}
	}

	public class SC_LEAGUE_SCHEDULE_ACK
	{
		public SLeagueScheduleInfo[] __Schedule; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Schedule"] = new JsonData(JsonType.Array);
			foreach(SLeagueScheduleInfo var in __Schedule)
			{
				JsonData temp = var.toJsonData();
				jd["__Schedule"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SC_LEAGUE_SCHEDULE_NTF
	{
		public SLeagueScheduleInfo[] __Schedule; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__Schedule"] = new JsonData(JsonType.Array);
			foreach(SLeagueScheduleInfo var in __Schedule)
			{
				JsonData temp = var.toJsonData();
				jd["__Schedule"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class CS_LEAGUE_FOOTBALLER_RANK_REQ
	{
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			return jd;
		}
	}

	public class SLeagueFootballerRank
	{
		public int __UserId = 0;
		public int __CardId = 0;
		public TeamSignInfo __TeamSign = new TeamSignInfo(); //class object TeamSignInfo
		public string __ClubName = "";//string
		public string __RankResult = "";//string
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__UserId"] = __UserId;
			jd["__CardId"] = __CardId;
			jd["__TeamSign"] = new JsonData(JsonType.Object);
			jd["__TeamSign"] = __TeamSign.toJsonData();
			jd["__ClubName"] = __ClubName;
			jd["__RankResult"] = __RankResult;
			return jd;
		}
	}

	public class SC_LEAGUE_FOOTBALLER_RANK_ACK
	{
		public SLeagueFootballerRank[] __ShootRank; //array elem is class object
		public SLeagueFootballerRank[] __MarkRank; //array elem is class object
		public SLeagueFootballerRank[] __AssistsRank; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ShootRank"] = new JsonData(JsonType.Array);
			foreach(SLeagueFootballerRank var in __ShootRank)
			{
				JsonData temp = var.toJsonData();
				jd["__ShootRank"].asList().Add(temp);//array elem is class object
			}
			jd["__MarkRank"] = new JsonData(JsonType.Array);
			foreach(SLeagueFootballerRank var in __MarkRank)
			{
				JsonData temp = var.toJsonData();
				jd["__MarkRank"].asList().Add(temp);//array elem is class object
			}
			jd["__AssistsRank"] = new JsonData(JsonType.Array);
			foreach(SLeagueFootballerRank var in __AssistsRank)
			{
				JsonData temp = var.toJsonData();
				jd["__AssistsRank"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SC_LEAGUE_FOOTBALLER_RANK_NTF
	{
		public SLeagueFootballerRank[] __ShootRank; //array elem is class object
		public SLeagueFootballerRank[] __MarkRank; //array elem is class object
		public SLeagueFootballerRank[] __AssistsRank; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__ShootRank"] = new JsonData(JsonType.Array);
			foreach(SLeagueFootballerRank var in __ShootRank)
			{
				JsonData temp = var.toJsonData();
				jd["__ShootRank"].asList().Add(temp);//array elem is class object
			}
			jd["__MarkRank"] = new JsonData(JsonType.Array);
			foreach(SLeagueFootballerRank var in __MarkRank)
			{
				JsonData temp = var.toJsonData();
				jd["__MarkRank"].asList().Add(temp);//array elem is class object
			}
			jd["__AssistsRank"] = new JsonData(JsonType.Array);
			foreach(SLeagueFootballerRank var in __AssistsRank)
			{
				JsonData temp = var.toJsonData();
				jd["__AssistsRank"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class SCardStatisticsInfo
	{
		public int __CardUid = 0;
		public string __IsMVP = "";//string
		public int __GoalNum = 0;
		public int __Assists = 0;
		public int __Score = 0;
		public int __YellowCard = 0;
		public int __RedCard = 0;
		public int __RoomId = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__CardUid"] = __CardUid;
			jd["__IsMVP"] = __IsMVP;
			jd["__GoalNum"] = __GoalNum;
			jd["__Assists"] = __Assists;
			jd["__Score"] = __Score;
			jd["__YellowCard"] = __YellowCard;
			jd["__RedCard"] = __RedCard;
			jd["__RoomId"] = __RoomId;
			return jd;
		}
	}

	public class SGameStatisticsInfo
	{
		public int __RoomId = 0;
		public int __GameType = 0;
		public string __IsHome = "";//string
		public int __BallControl = 0;
		public int __ShotNum = 0;
		public int __PenaltyShot = 0;
		public int __ShotSuccessRate = 0;
		public int __PassSuccessRate = 0;
		public int __FreeKick = 0;
		public int __Corner = 0;
		public int __Saves = 0;
		public int __TackleNum = 0;
		public int __Foul = 0;
		public int __YellowCard = 0;
		public int __RedCard = 0;
		public int __TotalScore = 0;
		public int __TotalGoalNum = 0;
		public int __UserId = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__RoomId"] = __RoomId;
			jd["__GameType"] = __GameType;
			jd["__IsHome"] = __IsHome;
			jd["__BallControl"] = __BallControl;
			jd["__ShotNum"] = __ShotNum;
			jd["__PenaltyShot"] = __PenaltyShot;
			jd["__ShotSuccessRate"] = __ShotSuccessRate;
			jd["__PassSuccessRate"] = __PassSuccessRate;
			jd["__FreeKick"] = __FreeKick;
			jd["__Corner"] = __Corner;
			jd["__Saves"] = __Saves;
			jd["__TackleNum"] = __TackleNum;
			jd["__Foul"] = __Foul;
			jd["__YellowCard"] = __YellowCard;
			jd["__RedCard"] = __RedCard;
			jd["__TotalScore"] = __TotalScore;
			jd["__TotalGoalNum"] = __TotalGoalNum;
			jd["__UserId"] = __UserId;
			return jd;
		}
	}

	public class SMatchSummaryInfo
	{
		public int __IsHome = 0;
		public int __EventPoint = 0;
		public int __EventType = 0;
		public int __MainCardUid = 0;
		public int __CardUid = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__IsHome"] = __IsHome;
			jd["__EventPoint"] = __EventPoint;
			jd["__EventType"] = __EventType;
			jd["__MainCardUid"] = __MainCardUid;
			jd["__CardUid"] = __CardUid;
			return jd;
		}
	}

	public class CS_MATCH_SUMMARY_REQ
	{
		public int __RoomId = 0;
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__RoomId"] = __RoomId;
			return jd;
		}
	}

	public class SC_MATCH_SUMMARY_ACK
	{
		public int __RoomId = 0;
		public SMatchSummaryInfo[] __SummaryInfo; //array elem is class object
		public JsonData toJsonData(int select = 0 /*effect in union class*/)
		{
			JsonData jd = new JsonData(JsonType.Object);
			jd["__RoomId"] = __RoomId;
			jd["__SummaryInfo"] = new JsonData(JsonType.Array);
			foreach(SMatchSummaryInfo var in __SummaryInfo)
			{
				JsonData temp = var.toJsonData();
				jd["__SummaryInfo"].asList().Add(temp);//array elem is class object
			}
			return jd;
		}
	}

	public class ProtoCode
	{
		public static string objectToJsonData(int nMsgId, object oObject)
		{
			switch(nMsgId)
			{
				case 1 : 
				{
					CS_LOGIN_REQ protoData = (CS_LOGIN_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 2 : 
				{
					SC_LOGIN_ACK protoData = (SC_LOGIN_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 3 : 
				{
					CS_CREATE_REQ protoData = (CS_CREATE_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 4 : 
				{
					SC_CREATE_ACK protoData = (SC_CREATE_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 5 : 
				{
					CS_GETINFO_REQ protoData = (CS_GETINFO_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 6 : 
				{
					SC_GETINFO_ACK protoData = (SC_GETINFO_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 7 : 
				{
					CS_REGISTER_REQ protoData = (CS_REGISTER_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 8 : 
				{
					SC_REGISTER_ACK protoData = (SC_REGISTER_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 100 : 
				{
					CS_UPGRADELEVEL_REQ protoData = (CS_UPGRADELEVEL_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 101 : 
				{
					SC_UPGRADELEVEL_ACK protoData = (SC_UPGRADELEVEL_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 102 : 
				{
					CS_UPGRADESTAR_REQ protoData = (CS_UPGRADESTAR_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 103 : 
				{
					SC_UPGRADESTAR_ACK protoData = (SC_UPGRADESTAR_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 104 : 
				{
					CS_LOOTLOGINREWARD_REQ protoData = (CS_LOOTLOGINREWARD_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 105 : 
				{
					SC_LOOTLOGINREWARD_ACK protoData = (SC_LOOTLOGINREWARD_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 200 : 
				{
					CS_PVE_REQ protoData = (CS_PVE_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 201 : 
				{
					SC_PVE_ACK protoData = (SC_PVE_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 202 : 
				{
					CS_SELLCARDS_REQ protoData = (CS_SELLCARDS_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 203 : 
				{
					SC_SELLCARDS_ACK protoData = (SC_SELLCARDS_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 204 : 
				{
					CS_POSITIONCHANGE_REQ protoData = (CS_POSITIONCHANGE_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 205 : 
				{
					SC_POSITIONCHANGE_ACK protoData = (SC_POSITIONCHANGE_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 206 : 
				{
					CS_UPGRADEEQUIPLEVEL_REQ protoData = (CS_UPGRADEEQUIPLEVEL_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 207 : 
				{
					SC_UPGRADEEQUIPLEVEL_ACK protoData = (SC_UPGRADEEQUIPLEVEL_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 208 : 
				{
					CS_EQUIPWORD_REQ protoData = (CS_EQUIPWORD_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 209 : 
				{
					SC_EQUIPWORD_ACK protoData = (SC_EQUIPWORD_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 210 : 
				{
					CS_EQUIPREST_REQ protoData = (CS_EQUIPREST_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 211 : 
				{
					SC_EQUIPREST_ACK protoData = (SC_EQUIPREST_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 212 : 
				{
					CS_SELLEQUIPS_REQ protoData = (CS_SELLEQUIPS_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 213 : 
				{
					SC_SELLEQUIPS_ACK protoData = (SC_SELLEQUIPS_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 214 : 
				{
					CS_SUMMON_REQ protoData = (CS_SUMMON_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 215 : 
				{
					SC_SUMMON_ACK protoData = (SC_SUMMON_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 300 : 
				{
					CS_GETDIRTYTIME_REQ protoData = (CS_GETDIRTYTIME_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 301 : 
				{
					SC_GETDIRTYTIME_ACK protoData = (SC_GETDIRTYTIME_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 400 : 
				{
					CS_APPLYGAME_REQ protoData = (CS_APPLYGAME_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 401 : 
				{
					SC_APPLYGAME_ACK protoData = (SC_APPLYGAME_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 402 : 
				{
					CS_GETPLAYERINFO_REQ protoData = (CS_GETPLAYERINFO_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 403 : 
				{
					SC_GETPLAYERINFO_ACK protoData = (SC_GETPLAYERINFO_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 404 : 
				{
					CS_MATCH_SUMMARY_REQ protoData = (CS_MATCH_SUMMARY_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 405 : 
				{
					SC_MATCH_SUMMARY_ACK protoData = (SC_MATCH_SUMMARY_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 500 : 
				{
					CS_FootballerInfo_REQ protoData = (CS_FootballerInfo_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 501 : 
				{
					SC_FootballerInfo_ACK protoData = (SC_FootballerInfo_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 502 : 
				{
					CS_FootballerADD_REQ protoData = (CS_FootballerADD_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 503 : 
				{
					SC_FootballerADD_ACK protoData = (SC_FootballerADD_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 504 : 
				{
					CS_FootballerDestory_REQ protoData = (CS_FootballerDestory_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 505 : 
				{
					SC_FootballerDestory_ACK protoData = (SC_FootballerDestory_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 510 : 
				{
					CS_FormationInfo_REQ protoData = (CS_FormationInfo_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 511 : 
				{
					SC_FormationInfo_ACK protoData = (SC_FormationInfo_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 512 : 
				{
					CS_FormationSet_REQ protoData = (CS_FormationSet_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 513 : 
				{
					SC_FormationSet_ACK protoData = (SC_FormationSet_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 600 : 
				{
					CS_Property_REQ protoData = (CS_Property_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 601 : 
				{
					SC_Property_ACK protoData = (SC_Property_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 700 : 
				{
					CS_Chat_REQ protoData = (CS_Chat_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 701 : 
				{
					SC_Chat_ACK protoData = (SC_Chat_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 702 : 
				{
					CS_ChatSetInfo_REQ protoData = (CS_ChatSetInfo_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 703 : 
				{
					SC_ChatSetInfo_ACK protoData = (SC_ChatSetInfo_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 800 : 
				{
					CS_Friend_REQ protoData = (CS_Friend_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 801 : 
				{
					SC_Friend_ACK protoData = (SC_Friend_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 802 : 
				{
					CS_FriendADD_REQ protoData = (CS_FriendADD_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 803 : 
				{
					SC_FriendADD_ACK protoData = (SC_FriendADD_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 804 : 
				{
					CS_FriendDestory_REQ protoData = (CS_FriendDestory_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 805 : 
				{
					SC_FriendDestory_ACK protoData = (SC_FriendDestory_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 806 : 
				{
					CS_FriendFind_REQ protoData = (CS_FriendFind_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 807 : 
				{
					SC_FriendFind_ACK protoData = (SC_FriendFind_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 900 : 
				{
					CS_TACTICSGET_REQ protoData = (CS_TACTICSGET_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 901 : 
				{
					SC_TACTICSGET_ACK protoData = (SC_TACTICSGET_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 902 : 
				{
					CS_TACTICSSET_REQ protoData = (CS_TACTICSSET_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 903 : 
				{
					SC_TACTICSSET_ACK protoData = (SC_TACTICSSET_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1000 : 
				{
					CS_CREATECLUB_REQ protoData = (CS_CREATECLUB_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1001 : 
				{
					SC_CREATECLUB_ACK protoData = (SC_CREATECLUB_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1002 : 
				{
					CS_UPDATECLUB_REQ protoData = (CS_UPDATECLUB_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1003 : 
				{
					SC_UPDATECLUB_ACK protoData = (SC_UPDATECLUB_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1004 : 
				{
					CS_GETCLUBINFO_REQ protoData = (CS_GETCLUBINFO_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1005 : 
				{
					SC_GETCLUBINFO_ACK protoData = (SC_GETCLUBINFO_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1010 : 
				{
					CS_CLUBSHIRT_REQ protoData = (CS_CLUBSHIRT_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1011 : 
				{
					SC_CLUBSHIRT_ACK protoData = (SC_CLUBSHIRT_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1012 : 
				{
					CS_UPDATECLUBSHIRT_REQ protoData = (CS_UPDATECLUBSHIRT_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1013 : 
				{
					SC_UPDATECLUBSHIRT_ACK protoData = (SC_UPDATECLUBSHIRT_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1020 : 
				{
					CS_CLUBTEAMSIGN_REQ protoData = (CS_CLUBTEAMSIGN_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1021 : 
				{
					SC_CLUBTEAMSIGN_ACK protoData = (SC_CLUBTEAMSIGN_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1022 : 
				{
					CS_UPDATETEAMSIGN_REQ protoData = (CS_UPDATETEAMSIGN_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1023 : 
				{
					SC_UPDATETEAMSIGN_ACK protoData = (SC_UPDATETEAMSIGN_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1030 : 
				{
					CS_GETTROPHYLIST_REQ protoData = (CS_GETTROPHYLIST_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1031 : 
				{
					SC_GETTROPHYLIST_ACK protoData = (SC_GETTROPHYLIST_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1032 : 
				{
					CS_ADDTROPHY_REQ protoData = (CS_ADDTROPHY_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1033 : 
				{
					SC_ADDTROPHY_ACK protoData = (SC_ADDTROPHY_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 2000 : 
				{
					CS_REDPOINT_REQ protoData = (CS_REDPOINT_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 2001 : 
				{
					SC_REDPOINT_ACK protoData = (SC_REDPOINT_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 2010 : 
				{
					CS_LEAGUERANK_REQ protoData = (CS_LEAGUERANK_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 2011 : 
				{
					SC_LEAGUE_RANK_ACK protoData = (SC_LEAGUE_RANK_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 2012 : 
				{
					SC_LEAGUE_RANK_NTF protoData = (SC_LEAGUE_RANK_NTF)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 2013 : 
				{
					CS_LEAGUE_SCHEDULE_REQ protoData = (CS_LEAGUE_SCHEDULE_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 2014 : 
				{
					SC_LEAGUE_SCHEDULE_ACK protoData = (SC_LEAGUE_SCHEDULE_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 2015 : 
				{
					SC_LEAGUE_SCHEDULE_NTF protoData = (SC_LEAGUE_SCHEDULE_NTF)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 2016 : 
				{
					CS_LEAGUE_FOOTBALLER_RANK_REQ protoData = (CS_LEAGUE_FOOTBALLER_RANK_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 2017 : 
				{
					SC_LEAGUE_FOOTBALLER_RANK_ACK protoData = (SC_LEAGUE_FOOTBALLER_RANK_ACK)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 2018 : 
				{
					SC_LEAGUE_FOOTBALLER_RANK_NTF protoData = (SC_LEAGUE_FOOTBALLER_RANK_NTF)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 1009 : 
				{
					SC_USER_DATA_NTF protoData = (SC_USER_DATA_NTF)oObject;
					return protoData.toJsonData().ToJson();
				}
				case 9999 : 
				{
					CS_HeartBeat_REQ protoData = (CS_HeartBeat_REQ)oObject;
					return protoData.toJsonData().ToJson();
				}
				default:
				return null;
			}
		}
		public static object getProto(int nMsgId,Response ret)
		{
			switch(nMsgId)
			{
				case 1 : 
				{
					CS_LOGIN_REQ protoData = JsonMapper.ToObject<CS_LOGIN_REQ>(ret.Data);
					return protoData;
				}
				case 2 : 
				{
					SC_LOGIN_ACK protoData = JsonMapper.ToObject<SC_LOGIN_ACK>(ret.Data);
					return protoData;
				}
				case 3 : 
				{
					CS_CREATE_REQ protoData = JsonMapper.ToObject<CS_CREATE_REQ>(ret.Data);
					return protoData;
				}
				case 4 : 
				{
					SC_CREATE_ACK protoData = JsonMapper.ToObject<SC_CREATE_ACK>(ret.Data);
					return protoData;
				}
				case 5 : 
				{
					CS_GETINFO_REQ protoData = JsonMapper.ToObject<CS_GETINFO_REQ>(ret.Data);
					return protoData;
				}
				case 6 : 
				{
					SC_GETINFO_ACK protoData = JsonMapper.ToObject<SC_GETINFO_ACK>(ret.Data);
					return protoData;
				}
				case 7 : 
				{
					CS_REGISTER_REQ protoData = JsonMapper.ToObject<CS_REGISTER_REQ>(ret.Data);
					return protoData;
				}
				case 8 : 
				{
					SC_REGISTER_ACK protoData = JsonMapper.ToObject<SC_REGISTER_ACK>(ret.Data);
					return protoData;
				}
				case 100 : 
				{
					CS_UPGRADELEVEL_REQ protoData = JsonMapper.ToObject<CS_UPGRADELEVEL_REQ>(ret.Data);
					return protoData;
				}
				case 101 : 
				{
					SC_UPGRADELEVEL_ACK protoData = JsonMapper.ToObject<SC_UPGRADELEVEL_ACK>(ret.Data);
					return protoData;
				}
				case 102 : 
				{
					CS_UPGRADESTAR_REQ protoData = JsonMapper.ToObject<CS_UPGRADESTAR_REQ>(ret.Data);
					return protoData;
				}
				case 103 : 
				{
					SC_UPGRADESTAR_ACK protoData = JsonMapper.ToObject<SC_UPGRADESTAR_ACK>(ret.Data);
					return protoData;
				}
				case 104 : 
				{
					CS_LOOTLOGINREWARD_REQ protoData = JsonMapper.ToObject<CS_LOOTLOGINREWARD_REQ>(ret.Data);
					return protoData;
				}
				case 105 : 
				{
					SC_LOOTLOGINREWARD_ACK protoData = JsonMapper.ToObject<SC_LOOTLOGINREWARD_ACK>(ret.Data);
					return protoData;
				}
				case 200 : 
				{
					CS_PVE_REQ protoData = JsonMapper.ToObject<CS_PVE_REQ>(ret.Data);
					return protoData;
				}
				case 201 : 
				{
					SC_PVE_ACK protoData = JsonMapper.ToObject<SC_PVE_ACK>(ret.Data);
					return protoData;
				}
				case 202 : 
				{
					CS_SELLCARDS_REQ protoData = JsonMapper.ToObject<CS_SELLCARDS_REQ>(ret.Data);
					return protoData;
				}
				case 203 : 
				{
					SC_SELLCARDS_ACK protoData = JsonMapper.ToObject<SC_SELLCARDS_ACK>(ret.Data);
					return protoData;
				}
				case 204 : 
				{
					CS_POSITIONCHANGE_REQ protoData = JsonMapper.ToObject<CS_POSITIONCHANGE_REQ>(ret.Data);
					return protoData;
				}
				case 205 : 
				{
					SC_POSITIONCHANGE_ACK protoData = JsonMapper.ToObject<SC_POSITIONCHANGE_ACK>(ret.Data);
					return protoData;
				}
				case 206 : 
				{
					CS_UPGRADEEQUIPLEVEL_REQ protoData = JsonMapper.ToObject<CS_UPGRADEEQUIPLEVEL_REQ>(ret.Data);
					return protoData;
				}
				case 207 : 
				{
					SC_UPGRADEEQUIPLEVEL_ACK protoData = JsonMapper.ToObject<SC_UPGRADEEQUIPLEVEL_ACK>(ret.Data);
					return protoData;
				}
				case 208 : 
				{
					CS_EQUIPWORD_REQ protoData = JsonMapper.ToObject<CS_EQUIPWORD_REQ>(ret.Data);
					return protoData;
				}
				case 209 : 
				{
					SC_EQUIPWORD_ACK protoData = JsonMapper.ToObject<SC_EQUIPWORD_ACK>(ret.Data);
					return protoData;
				}
				case 210 : 
				{
					CS_EQUIPREST_REQ protoData = JsonMapper.ToObject<CS_EQUIPREST_REQ>(ret.Data);
					return protoData;
				}
				case 211 : 
				{
					SC_EQUIPREST_ACK protoData = JsonMapper.ToObject<SC_EQUIPREST_ACK>(ret.Data);
					return protoData;
				}
				case 212 : 
				{
					CS_SELLEQUIPS_REQ protoData = JsonMapper.ToObject<CS_SELLEQUIPS_REQ>(ret.Data);
					return protoData;
				}
				case 213 : 
				{
					SC_SELLEQUIPS_ACK protoData = JsonMapper.ToObject<SC_SELLEQUIPS_ACK>(ret.Data);
					return protoData;
				}
				case 214 : 
				{
					CS_SUMMON_REQ protoData = JsonMapper.ToObject<CS_SUMMON_REQ>(ret.Data);
					return protoData;
				}
				case 215 : 
				{
					SC_SUMMON_ACK protoData = JsonMapper.ToObject<SC_SUMMON_ACK>(ret.Data);
					return protoData;
				}
				case 300 : 
				{
					CS_GETDIRTYTIME_REQ protoData = JsonMapper.ToObject<CS_GETDIRTYTIME_REQ>(ret.Data);
					return protoData;
				}
				case 301 : 
				{
					SC_GETDIRTYTIME_ACK protoData = JsonMapper.ToObject<SC_GETDIRTYTIME_ACK>(ret.Data);
					return protoData;
				}
				case 400 : 
				{
					CS_APPLYGAME_REQ protoData = JsonMapper.ToObject<CS_APPLYGAME_REQ>(ret.Data);
					return protoData;
				}
				case 401 : 
				{
					SC_APPLYGAME_ACK protoData = JsonMapper.ToObject<SC_APPLYGAME_ACK>(ret.Data);
					return protoData;
				}
				case 402 : 
				{
					CS_GETPLAYERINFO_REQ protoData = JsonMapper.ToObject<CS_GETPLAYERINFO_REQ>(ret.Data);
					return protoData;
				}
				case 403 : 
				{
					SC_GETPLAYERINFO_ACK protoData = JsonMapper.ToObject<SC_GETPLAYERINFO_ACK>(ret.Data);
					return protoData;
				}
				case 404 : 
				{
					CS_MATCH_SUMMARY_REQ protoData = JsonMapper.ToObject<CS_MATCH_SUMMARY_REQ>(ret.Data);
					return protoData;
				}
				case 405 : 
				{
					SC_MATCH_SUMMARY_ACK protoData = JsonMapper.ToObject<SC_MATCH_SUMMARY_ACK>(ret.Data);
					return protoData;
				}
				case 500 : 
				{
					CS_FootballerInfo_REQ protoData = JsonMapper.ToObject<CS_FootballerInfo_REQ>(ret.Data);
					return protoData;
				}
				case 501 : 
				{
					SC_FootballerInfo_ACK protoData = JsonMapper.ToObject<SC_FootballerInfo_ACK>(ret.Data);
					return protoData;
				}
				case 502 : 
				{
					CS_FootballerADD_REQ protoData = JsonMapper.ToObject<CS_FootballerADD_REQ>(ret.Data);
					return protoData;
				}
				case 503 : 
				{
					SC_FootballerADD_ACK protoData = JsonMapper.ToObject<SC_FootballerADD_ACK>(ret.Data);
					return protoData;
				}
				case 504 : 
				{
					CS_FootballerDestory_REQ protoData = JsonMapper.ToObject<CS_FootballerDestory_REQ>(ret.Data);
					return protoData;
				}
				case 505 : 
				{
					SC_FootballerDestory_ACK protoData = JsonMapper.ToObject<SC_FootballerDestory_ACK>(ret.Data);
					return protoData;
				}
				case 510 : 
				{
					CS_FormationInfo_REQ protoData = JsonMapper.ToObject<CS_FormationInfo_REQ>(ret.Data);
					return protoData;
				}
				case 511 : 
				{
					SC_FormationInfo_ACK protoData = JsonMapper.ToObject<SC_FormationInfo_ACK>(ret.Data);
					return protoData;
				}
				case 512 : 
				{
					CS_FormationSet_REQ protoData = JsonMapper.ToObject<CS_FormationSet_REQ>(ret.Data);
					return protoData;
				}
				case 513 : 
				{
					SC_FormationSet_ACK protoData = JsonMapper.ToObject<SC_FormationSet_ACK>(ret.Data);
					return protoData;
				}
				case 600 : 
				{
					CS_Property_REQ protoData = JsonMapper.ToObject<CS_Property_REQ>(ret.Data);
					return protoData;
				}
				case 601 : 
				{
					SC_Property_ACK protoData = JsonMapper.ToObject<SC_Property_ACK>(ret.Data);
					return protoData;
				}
				case 700 : 
				{
					CS_Chat_REQ protoData = JsonMapper.ToObject<CS_Chat_REQ>(ret.Data);
					return protoData;
				}
				case 701 : 
				{
					SC_Chat_ACK protoData = JsonMapper.ToObject<SC_Chat_ACK>(ret.Data);
					return protoData;
				}
				case 702 : 
				{
					CS_ChatSetInfo_REQ protoData = JsonMapper.ToObject<CS_ChatSetInfo_REQ>(ret.Data);
					return protoData;
				}
				case 703 : 
				{
					SC_ChatSetInfo_ACK protoData = JsonMapper.ToObject<SC_ChatSetInfo_ACK>(ret.Data);
					return protoData;
				}
				case 800 : 
				{
					CS_Friend_REQ protoData = JsonMapper.ToObject<CS_Friend_REQ>(ret.Data);
					return protoData;
				}
				case 801 : 
				{
					SC_Friend_ACK protoData = JsonMapper.ToObject<SC_Friend_ACK>(ret.Data);
					return protoData;
				}
				case 802 : 
				{
					CS_FriendADD_REQ protoData = JsonMapper.ToObject<CS_FriendADD_REQ>(ret.Data);
					return protoData;
				}
				case 803 : 
				{
					SC_FriendADD_ACK protoData = JsonMapper.ToObject<SC_FriendADD_ACK>(ret.Data);
					return protoData;
				}
				case 804 : 
				{
					CS_FriendDestory_REQ protoData = JsonMapper.ToObject<CS_FriendDestory_REQ>(ret.Data);
					return protoData;
				}
				case 805 : 
				{
					SC_FriendDestory_ACK protoData = JsonMapper.ToObject<SC_FriendDestory_ACK>(ret.Data);
					return protoData;
				}
				case 806 : 
				{
					CS_FriendFind_REQ protoData = JsonMapper.ToObject<CS_FriendFind_REQ>(ret.Data);
					return protoData;
				}
				case 807 : 
				{
					SC_FriendFind_ACK protoData = JsonMapper.ToObject<SC_FriendFind_ACK>(ret.Data);
					return protoData;
				}
				case 900 : 
				{
					CS_TACTICSGET_REQ protoData = JsonMapper.ToObject<CS_TACTICSGET_REQ>(ret.Data);
					return protoData;
				}
				case 901 : 
				{
					SC_TACTICSGET_ACK protoData = JsonMapper.ToObject<SC_TACTICSGET_ACK>(ret.Data);
					return protoData;
				}
				case 902 : 
				{
					CS_TACTICSSET_REQ protoData = JsonMapper.ToObject<CS_TACTICSSET_REQ>(ret.Data);
					return protoData;
				}
				case 903 : 
				{
					SC_TACTICSSET_ACK protoData = JsonMapper.ToObject<SC_TACTICSSET_ACK>(ret.Data);
					return protoData;
				}
				case 1000 : 
				{
					CS_CREATECLUB_REQ protoData = JsonMapper.ToObject<CS_CREATECLUB_REQ>(ret.Data);
					return protoData;
				}
				case 1001 : 
				{
					SC_CREATECLUB_ACK protoData = JsonMapper.ToObject<SC_CREATECLUB_ACK>(ret.Data);
					return protoData;
				}
				case 1002 : 
				{
					CS_UPDATECLUB_REQ protoData = JsonMapper.ToObject<CS_UPDATECLUB_REQ>(ret.Data);
					return protoData;
				}
				case 1003 : 
				{
					SC_UPDATECLUB_ACK protoData = JsonMapper.ToObject<SC_UPDATECLUB_ACK>(ret.Data);
					return protoData;
				}
				case 1004 : 
				{
					CS_GETCLUBINFO_REQ protoData = JsonMapper.ToObject<CS_GETCLUBINFO_REQ>(ret.Data);
					return protoData;
				}
				case 1005 : 
				{
					SC_GETCLUBINFO_ACK protoData = JsonMapper.ToObject<SC_GETCLUBINFO_ACK>(ret.Data);
					return protoData;
				}
				case 1010 : 
				{
					CS_CLUBSHIRT_REQ protoData = JsonMapper.ToObject<CS_CLUBSHIRT_REQ>(ret.Data);
					return protoData;
				}
				case 1011 : 
				{
					SC_CLUBSHIRT_ACK protoData = JsonMapper.ToObject<SC_CLUBSHIRT_ACK>(ret.Data);
					return protoData;
				}
				case 1012 : 
				{
					CS_UPDATECLUBSHIRT_REQ protoData = JsonMapper.ToObject<CS_UPDATECLUBSHIRT_REQ>(ret.Data);
					return protoData;
				}
				case 1013 : 
				{
					SC_UPDATECLUBSHIRT_ACK protoData = JsonMapper.ToObject<SC_UPDATECLUBSHIRT_ACK>(ret.Data);
					return protoData;
				}
				case 1020 : 
				{
					CS_CLUBTEAMSIGN_REQ protoData = JsonMapper.ToObject<CS_CLUBTEAMSIGN_REQ>(ret.Data);
					return protoData;
				}
				case 1021 : 
				{
					SC_CLUBTEAMSIGN_ACK protoData = JsonMapper.ToObject<SC_CLUBTEAMSIGN_ACK>(ret.Data);
					return protoData;
				}
				case 1022 : 
				{
					CS_UPDATETEAMSIGN_REQ protoData = JsonMapper.ToObject<CS_UPDATETEAMSIGN_REQ>(ret.Data);
					return protoData;
				}
				case 1023 : 
				{
					SC_UPDATETEAMSIGN_ACK protoData = JsonMapper.ToObject<SC_UPDATETEAMSIGN_ACK>(ret.Data);
					return protoData;
				}
				case 1030 : 
				{
					CS_GETTROPHYLIST_REQ protoData = JsonMapper.ToObject<CS_GETTROPHYLIST_REQ>(ret.Data);
					return protoData;
				}
				case 1031 : 
				{
					SC_GETTROPHYLIST_ACK protoData = JsonMapper.ToObject<SC_GETTROPHYLIST_ACK>(ret.Data);
					return protoData;
				}
				case 1032 : 
				{
					CS_ADDTROPHY_REQ protoData = JsonMapper.ToObject<CS_ADDTROPHY_REQ>(ret.Data);
					return protoData;
				}
				case 1033 : 
				{
					SC_ADDTROPHY_ACK protoData = JsonMapper.ToObject<SC_ADDTROPHY_ACK>(ret.Data);
					return protoData;
				}
				case 2000 : 
				{
					CS_REDPOINT_REQ protoData = JsonMapper.ToObject<CS_REDPOINT_REQ>(ret.Data);
					return protoData;
				}
				case 2001 : 
				{
					SC_REDPOINT_ACK protoData = JsonMapper.ToObject<SC_REDPOINT_ACK>(ret.Data);
					return protoData;
				}
				case 2010 : 
				{
					CS_LEAGUERANK_REQ protoData = JsonMapper.ToObject<CS_LEAGUERANK_REQ>(ret.Data);
					return protoData;
				}
				case 2011 : 
				{
					SC_LEAGUE_RANK_ACK protoData = JsonMapper.ToObject<SC_LEAGUE_RANK_ACK>(ret.Data);
					return protoData;
				}
				case 2012 : 
				{
					SC_LEAGUE_RANK_NTF protoData = JsonMapper.ToObject<SC_LEAGUE_RANK_NTF>(ret.Data);
					return protoData;
				}
				case 2013 : 
				{
					CS_LEAGUE_SCHEDULE_REQ protoData = JsonMapper.ToObject<CS_LEAGUE_SCHEDULE_REQ>(ret.Data);
					return protoData;
				}
				case 2014 : 
				{
					SC_LEAGUE_SCHEDULE_ACK protoData = JsonMapper.ToObject<SC_LEAGUE_SCHEDULE_ACK>(ret.Data);
					return protoData;
				}
				case 2015 : 
				{
					SC_LEAGUE_SCHEDULE_NTF protoData = JsonMapper.ToObject<SC_LEAGUE_SCHEDULE_NTF>(ret.Data);
					return protoData;
				}
				case 2016 : 
				{
					CS_LEAGUE_FOOTBALLER_RANK_REQ protoData = JsonMapper.ToObject<CS_LEAGUE_FOOTBALLER_RANK_REQ>(ret.Data);
					return protoData;
				}
				case 2017 : 
				{
					SC_LEAGUE_FOOTBALLER_RANK_ACK protoData = JsonMapper.ToObject<SC_LEAGUE_FOOTBALLER_RANK_ACK>(ret.Data);
					return protoData;
				}
				case 2018 : 
				{
					SC_LEAGUE_FOOTBALLER_RANK_NTF protoData = JsonMapper.ToObject<SC_LEAGUE_FOOTBALLER_RANK_NTF>(ret.Data);
					return protoData;
				}
				case 1009 : 
				{
					SC_USER_DATA_NTF protoData = JsonMapper.ToObject<SC_USER_DATA_NTF>(ret.Data);
					return protoData;
				}
				case 9999 : 
				{
					CS_HeartBeat_REQ protoData = JsonMapper.ToObject<CS_HeartBeat_REQ>(ret.Data);
					return protoData;
				}
				default:
					return null;
			}
		}
	}
}