<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_BASE_PATH."Config.php");
include_once(APP_PATH.'XmlConfigMgr.php');
include_once(APP_PROTO_PATH.'proto.php');
include_once(APP_PROTO_PATH.'protoFile.php');
include_once(APP_LOGIC_PATH.'ConfigLogic.php');
include_once(APP_LOGIC_PATH.'MemInfoLogic.php');

class ProtoAction
{
	private function init()
	{
		XmlConfigMgr::getInstance()->init();
	}
	
	public function proto()
	{
		$this->init();
		if(empty($_POST['data']))
		{
			Send(SCID_LOGIN_ACK, ERROR_SERVER);
		}
		file_put_contents('d:/1.txt', $_POST['data'], FILE_APPEND);
		$data = Rece($_POST['data']);
		file_put_contents('d:/1.txt', "\n-----".print_r($data, true), FILE_APPEND);

		execProto($data);//执行协议，后面不需要了

//		switch($data->msgid)
//		{
//		case 10000://更新玩家数据
//			{
//				if($data->token === "m1m9s8s8j5j4")
//				{
//					UsersPool::getInstance()->updateMemUsers();
//					file_put_contents('d:/memtodb.txt', date("Y-m-d H:i:s")."  saved !\r\n", FILE_APPEND);
//				}
//			}
//			break;
//
//		case 10001://清除mem中的配置
//			{
//				if($data->token === "m1m9s8s8j5j4")
//				{
//					S("CONFIG_CARDS", null);
//					S("CONFIG_INIT", null);
//					S("CONFIG_FORMATION", null);
//					S("CONFIG_USERLEVEL", null);
//					S("CONFIG_CARDLEVEL", null);
//					S("CONFIG_CARDSTAR", null);
//					S("CONFIG_COUNTRY", null);
//					S("CONFIG_EQUIPS", null);
//					S("CONFIG_FRAGMENTS", null);
//					S("CONFIG_MATERIALS", null);
//					S("CONFIG_MAPS", null);
//					S("CONFIG_CHILDMAPS", null);
//					S("CONFIG_FIGHT", null);
//					S("CONFIG_IDCONTRAST", null);
//					S("CONFIG_LOGINREWARD", null);
//					S("CONFIG_EQUIPLEVEL", null);
//					S("CONFIG_SUMMON", null);
//					S("CONFIG_FVSUMMON", null);
//					S("CONFIG_MONEYSUMMON", null);
//					S("CONFIG_RMBSUMMON", null);
//					S("CONFIG_DROP", null);
//					file_put_contents('d:/clearconfig.txt', date("Y-m-d H:i:s")."  operation !\r\n", FILE_APPEND);
//					echo "clean success!";
//				}
//			}
//			break;
//
//		case CSID_REGISTER_REQ:
//			{
//				$this->register($data->value);
//			}
//			break;
//
//		case CSID_LOGIN_REQ:
//			{
//				$this->checkLogin($data->token, $data->value);
//			}
//			break;
//
//		case CSID_TESTPVE_REQ:
//			//$this->testPve($user, $data->value);
//			break;
//
//		default:
//			{
//                $index = substr($data->token, 14);
//                $userid = null;
//                if($index)
//                {
//                    $userid = ST($index, $data->token);
//                }
//                error_log("userid :" . $userid ."  ".$data->token);
//				if($userid)
//				{
//					$user = UsersPool::getInstance()->getUserInfo($userid);
//					// if(!$user->isCanProto())
//					// {
//						// //两次协议中需有0.5的间隔
//						// Send($data->msgid, ERROR_SERVER);
//						// exit;
//					// }
//					$user->setProtoTime();
//					switch($data->msgid)
//					{
//                        case CSID_APPLYGAME_REQ:
//                            $this->pvpStart($user, $data->value);
//                            break;
//						case CSID_HeartBeat_REQ:
//							$this->getPvpFightResult($user->roomId);
//							break;
//                        case 1002://测试
//                            $this->testDestoryRoom($user->roomId);
//                            break;
//                        case CSID_GETDIRTYTIME_REQ:
//                            $this->getDirtyTime($user);
//                            break;
//
//                        case CSID_CREATE_REQ:
//                            $this->create($user, $data->value);
//                            break;
//
//                        case CSID_GETINFO_REQ:
//                            $this->getInfo($user, $data->value);
//                            break;
//
//                        case CSID_UPGRADELEVEL_REQ:
//                            $this->upgradeLevel($user, $data->value);
//                            break;
//
//                        case CSID_UPGRADESTAR_REQ:
//                            $this->upgradeStar($user, $data->value);
//                            break;
//
//                        case CSID_LOOTLOGINREWARD_REQ:
//                            $this->lootLoginReward($user, $data->value);
//                            break;
//
//                        case CSID_PVE_REQ:
//                            $this->pve($user, $data->value);
//                            break;
//
//                        case CSID_SELLCARDS_REQ:
//                            $this->sellCards($user, $data->value);
//                            break;
//
//                        case CSID_POSITIONCHANGE_REQ:
//                            $this->positionChange($user, $data->value);
//                            break;
//
//                        case CSID_UPGRADEEQUIPLEVEL_REQ:
//                            $this->upgradeEquipLevel($user, $data->value);
//                            break;
//
//                        case CSID_EQUIPWORD_REQ:
//                            $this->equipWork($user, $data->value);
//                            break;
//
//                        case CSID_EQUIPREST_REQ:
//                            $this->equipRest($user, $data->value);
//                            break;
//
//                        case CSID_SELLEQUIPS_REQ:
//                            $this->sellEquips($user, $data->value);
//                            break;
//
//                        case CSID_SUMMON_REQ:
//                            $this->summon($user, $data->value);
//                            break;
//
//                        default:
//                            break;
//					}
//				}
//				else
//				{
//					file_put_contents('d:/1.txt', "\n-----".$data->msgid." not find msg", FILE_APPEND);
//					Send(SCID_LOGIN_ACK, ERROR_NEED_LOGIN);
//				}
//			}
//		}
	}



}
