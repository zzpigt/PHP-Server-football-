<?php
include_once(APP_LOGIC_PATH."PropertiesLogic.php");
include_once(APP_LOGIC_PATH."MemInfoLogic.php");
include_once(APP_LOGIC_PATH."PlayerLogic.php");
include_once(APP_LOGIC_PATH."LeagueLogic.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/2/3
 * Time: 10:37
 */

class BaseProto
{
	function deal()
	{
		$userId = Registry::getInstance()->get(CLIENT_ID);
		if($userId)	
		{
			$user = new PlayerModel($userId);
			if($user)
			{
				
			}
		}
	
	}
	
    function register($data)
    {
        $register = $data->value;
        if(empty($register->__UserName) || empty($register->__UserPwd))
        {
            Send(SCID_REGISTER_ACK, ERROR_REGISTER);
        }

        if(strlen($register->__UserName) > 15)
        {
            Send(SCID_REGISTER_ACK, ERROR_USER_NAME_LENGTH);
        }
        if(strlen($register->__UserPwd) > 15)
        {
            Send(SCID_REGISTER_ACK, ERROR_USER_PWD_LENGTH);
        }

       	
        $leagueLogic = new LeagueLogic();//联盟
        $userLeague = $leagueLogic->robot2User();
        if(!$userLeague)
        	Send(SCID_REGISTER_ACK, ERROR_SERVER);
        
        $_userId = $userLeague[0];
        $_leagueId = $userLeague[1];
       
        $playerModel = new PlayerModel();
        if(empty($playerModel) || !$playerModel->init($_userId))//
        {
            Send(SCID_REGISTER_ACK, ERROR_SERVER);
        }
        
        $register->__UserName = $playerModel->escapeString($register->__UserName);
        if(!$register->__UserName)
        	Send(SCID_REGISTER_ACK, ERROR_SERVER);
        
        $register->__UserPwd = md5($register->__UserPwd);
        
        $playerModel->setFieldByIndex(DATA_BASE_PLAYER_USERNAME, $register->__UserName);
        $playerModel->setFieldByIndex(DATA_BASE_PLAYER_USERPWD, $register->__UserPwd);
        $playerModel->setFieldByIndex(DATA_BASE_PLAYER_MACADDRESS, $register->__MacAddress);
        $playerModel->setFieldByIndex(DATA_BASE_PLAYER_LEAGUERID, $_leagueId);
        $res = $playerModel->savePlayerData();//保存玩家数据

//        $date = time();
//        $sql = "insert into player (`username`, `userpwd`, `regdate`, `macaddress`) values('{$username}', '{$password}', '{$date}', '{$register->__MacAddress}') ;";
//        $res = $m->insert($sql);
//        printError("insert sql :" . $sql);
        if($res)//保存成功以后
        {
           /* $token = mt_rand(time()/10, time());
            $token .= "|".mt_rand(1111,9999).$_userId;*/
            $token = setToken($_userId);

            if(!MemInfoLogic::Instance()->setMemData($token, $_userId, null, 3600))//缓存玩家ID
            {
                Send(SCID_REGISTER_ACK, ERROR_SERVER);
            }
//            ST($userid, $token, $userid);
            $ack = new SC_REGISTER_ACK();
            $ack->__Token = $token;
            $ack->__TimeStamp = time();

            Send(SCID_REGISTER_ACK, ERROR_OK, $ack);
        }
        else
        {
            Send(SCID_REGISTER_ACK, ERROR_REGISTER);
        }

    }

    function checkLogin($data)
    {
        $checkLogin = $data -> value;
        $token = $data-> token;
        if(strlen($checkLogin->__UserName) > 15)
        {
            Send(SCID_LOGIN_ACK, ERROR_USER_NAME_LENGTH);
        }
        if(strlen($checkLogin->__UserPwd) > 15)
        {
            Send(SCID_LOGIN_ACK, ERROR_USER_PWD_LENGTH);
        }

        $index = substr($token, 14);    //取得玩家Id;
        $userIdMem = null;
        if($index)
        {
            $userIdMem = MemInfoLogic::Instance()->getMemData($token);
        }

        if(!empty($token) && $userIdMem)
        {
            printError("has the token");
            $ack = new SC_LOGIN_ACK();
            $ack->__Token = $token;
            $ack->__TimeStamp = time();

            $_userId = getUserId($token);
            $_propertiesLogic = new PropertiesLogic();
            if(empty($_propertiesLogic))
            {
                Send(SCID_LOGIN_ACK, ERROR_SERVER);
            }
            if(!$_propertiesLogic->init($_userId))
            {
                Send(SCID_LOGIN_ACK, ERROR_SERVER);
            }
            $_name = $_propertiesLogic->getPlayerDataByField(DATA_BASE_PROPERTIES_NICK);//得到玩家用户名

            if (empty($_name))
            {
                Send(SCID_LOGIN_ACK, ERROR_NEED_CREATE, $ack);
            }
            else
            {
                Send(SCID_LOGIN_ACK, ERROR_OK, $ack);
            }
        }
        else
        {
            printError($checkLogin);
            $username = addslashes(trim($checkLogin->__UserName));//可以有_
            $password = md5($checkLogin->__UserPwd);
            file_put_contents('d:/1.txt', $username.'----'.$password, FILE_APPEND);

            if(!isset($username) || empty($username) || !isset($password) || empty($password))
            {
                Send(SCID_LOGIN_ACK, ERROR_LOGIN);
            }
            else
            {
               
                $m=new MysqlDB();
                if(!$m->initDB(1))
                {
                    Send(SCID_REGISTER_ACK, ERROR_SERVER);
                }
                $result=$m->query("select * from player where username = '{$username}' and userpwd = '{$password}';");
                if($result)
                {
                    $token = mt_rand(time()/10, time());
                    $_userId = $result[0]['userid'];
                    $token .= "|".mt_rand(1111,9999).$_userId;

                    //$token = "516211621|14456";
                    if(!MemInfoLogic::Instance()->setMemData($token, $_userId, null, 3600))
                    {
                        Send(SCID_LOGIN_ACK, ERROR_SERVER);
                    }

                    $ack = new SC_LOGIN_ACK();
                    $ack->__Token = $token;
                    $ack->__TimeStamp = time();

                    $_userId = getUserId($token);
                    $_propertiesLogic = new PropertiesLogic();
                    if(empty($_propertiesLogic))
                    {
                        Send(SCID_LOGIN_ACK, ERROR_SERVER);
                    }
                    if(!$_propertiesLogic->init($_userId))
                    {
                        Send(SCID_LOGIN_ACK, ERROR_SERVER);
                    }
                    $_name = $_propertiesLogic->getPlayerDataByField(DATA_BASE_PROPERTIES_NICK);

                    if (empty($_name))
                    {
                        Send(SCID_LOGIN_ACK, ERROR_NEED_CREATE, $ack);
                    }
                    else
                    {
                        Send(SCID_LOGIN_ACK, ERROR_OK, $ack);
                    }
                }
                else
                {
                    Send(SCID_LOGIN_ACK, ERROR_LOGIN);
                }
            }
        }
    }
}