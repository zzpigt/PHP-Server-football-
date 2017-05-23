<?php
include_once("MyConstant.php");
include_once("ProtoAction.php");
include_once('proto/proto.php');
include_once('base/DataBaseField.php');
include_once('XmlConfigMgr.php');



$test = new TestAction();
//$test->testCleanXml();
//$test->getStrLen();
$test->test();
//$test->formatFormation();
//$test->getMapInfo();
//$test->testNull();
//$test->testIndex();
//$test->sortParaCardNum();
//$test->Xml();

class TestAction
{
	const SERVER_URL = "http://fb.gameshanghai.com/football/index.php";
    private $userName = "shen1129";
    private $userPwd = "1233";
    private $mac = "111115";
	public function test()
	{
		//S(11, null);
		//S("UsersPoolList", null);//testPvpStart/testHeart
		$result = $this->leagueTest();//testFormation//testGetPlayerInfo//TestGetTactics//TestSetTactics//testPara
				
		$data = new stdClass();
		$data->msgid = $result[0];
		$data->token = "1041053282|52691096";//516211621|14456";
		$data->value =  $result[1];
		
		$data = json_encode($data);
		
		//$requst = $this->request_by_curl("http://fb.gameshanghai.com/football/index.php", $data);
		
		$_POST['data'] = $data;
		$action = new ProtoAction();
		$action->proto();
	}
    
	function register()
	{
		$register = new CS_REGISTER_REQ();
		$register->__UserName = $this->userName;
		$register->__UserPwd = $this->userPwd;
		$register->__MacAddress = $this->mac;
		return array(CSID_REGISTER_REQ, $register);
	}
	
	function login()
	{
		$login =  new CS_LOGIN_REQ();
		$login->__UserName = $this->userName;
		$login->__UserPwd = $this->userPwd;
		return array(CSID_LOGIN_REQ, $login);
	}

    function testPosition()
    {
        $_data = new CS_FormationInfo_REQ();
        for($i = 1;$i<=18;$i++)
        {
            $_sInfo = new SInfo();
            $_sInfo->__Type = $i;
            $_sInfo->__Value = 'GK';

            array_push($_data->__FormationInfo, $_sInfo);
        }

        return array(CSID_FormationInfo_REQ, $_data);
    }

    function testRedPoint()
    {
        $_data = new CS_REDPOINT_REQ();

        return array(CSID_REDPOINT_REQ, $_data);
    }

    function testPvpStart()
    {
        $_data = new CS_APPLYGAME_REQ();
        $_data->__DefenseId = 85;

        return array(400, $_data);
    }

    function testHeart()
    {
        $_data = new CS_HeartBeat_REQ();

        return array(CSID_HeartBeat_REQ, $_data);
    }

    function testNull()
    {
        $_data = [0, 1];
        if(empty($_data[null]))
        {
            var_dump(1);
        }
        var_dump(2);
    }

    function testPara()
    {
        $_sendInfo = new CS_APPLYGAME_REQ();
        $_sendInfo->__DefenseId = 85;

        return array(100000, $_sendInfo);
    }

    function testCleanXml()
    {
        return array(100001, null);
    }

    function getStrLen()
    {
        $_str = "{\"__Classes\":2,\"__ApplyPVPEvent\":[{\"__EventPoint\":4,\"__Event\":[{\"__EventType\":0,\"__EventResult\":2,\"__EventBehavior\":2,\"__EventPositions\":{\"2\":4,\"3\":16},\"__EventRegion\":{\"__Type\":15,\"__Value\":8}},{\"__EventType\":0,\"__EventResult\":11,\"__EventBehavior\":8,\"__EventPositions\":{\"2\":16},\"__EventRegion\":null},{\"__EventType\":0,\"__EventResult\":15,\"__EventBehavior\":13,\"__EventPositions\":{\"2\":16},\"__EventRegion\":{\"__Type\":16,\"__Value\":8}},{\"__EventType\":0,\"__EventResult\":7,\"__EventBehavior\":7,\"__EventPositions\":{\"2\":16},\"__EventRegion\":{\"__Type\":16,\"__Value\":8}}]}]}";
        var_dump(strlen($_str));
    }

    function testIndex()
    {
//        $a=array("a"=>"Dog","b"=>"Dog","c"=>5,"d"=>"5");
//        print_r(array_search("Dog", $a));

        $_paraArr = array();
        for($i = 1;$i<=22;$i++)
        {
            $_arr = array();
            $_arr[$i] = 23 - $i;

            $_paraArr[$i] = $_arr;
        }

        var_dump($_paraArr);
    }
	
	function create()
	{
		$create = new CS_CREATE_REQ();
		$create->__Name = $this->userName.rand(111, 999);
		$create->__CountryId = 100;
		$create->__CaptainId = 101;
		
		return array(CSID_CREATE_REQ, $create);
	}

    function getinfo()
    {
        return array(CSID_Property_REQ, null);
    }

    function getCardInfo()
    {
        $getinfo =  new CS_FootballerInfo_REQ();
        return array(CSID_FootballerInfo_REQ, $getinfo);
//        $getinfo->__InfoType = USER_DATA_FIRST_PROPERTY;
//        return array(CSID_GETINFO_REQ, $getinfo);
    }

    function getFormationInfo()
    {
        $getinfo =  new CS_FormationInfo_REQ();
        return array(CSID_FormationInfo_REQ, NULL);
//        $getinfo->__InfoType = USER_DATA_FIRST_PROPERTY;
//        return array(CSID_GETINFO_REQ, $getinfo);
    }

    function testFormation()
    {
        $_send = new CS_FormationInfo_REQ();
        $_send->__UserId = 92;

        return array(CSID_FormationInfo_REQ, $_send);
    }

    function testGetPlayerInfo()
    {
        $_sendInfo = new CS_GETPLAYERINFO_REQ();
//        $_sendInfo->__UserId = 85;
        return array(CSID_GETPLAYERINFO_REQ, $_sendInfo);
    }
	
	function upgradelevel()
	{
		$upgrade = new CS_UPGRADELEVEL_REQ();
		$upgrade->__CardMainUid = 1;
		array_push($upgrade->__CardUidsArr, 14);
		return array(CSID_UPGRADELEVEL_REQ, $upgrade);
	}
	
	function summon()
	{
		$summon = new CS_SUMMON_REQ();
		$summon->__SummonType = SUMMON_TYPE_MONEY;
		return array(CSID_SUMMON_REQ, $summon);
	}
	
	function doPve()
	{
		$dopve =  new CS_PVE_REQ();
		$dopve->__MapId = 1;
		$dopve->__ChildMapId = 1;
		return array(CSID_PVE_REQ, $dopve);
	}
	
	function doTestPve()
	{
		$dopve =  new CS_TESTPVE_REQ();
		return array(CSID_TESTPVE_REQ, $dopve);
	}

    function TestGetTactics()
    {
        return array(CSID_TACTICSGET_REQ, null);
    }

    function TestSetTactics()
    {
        $_sendInfo = new CS_TACTICSSET_REQ();
        $_sendInfo->__TacticsClass = 1;
        $_sendInfo->__TacticsId = 1000002;
        return array(CSID_TACTICSSET_REQ, $_sendInfo);
    }

    function Xml()
    {
        XmlConfigMgr::getInstance()->init();
        //var_dump(XmlConfigMgr::getInstance()->getFieldDistanceConfig()->getFieldDistanceByDistance());
    }

    function getPara()
    {
        $_para = array();
        $_para[USER_DATA_FORMATION_LW] = [USER_DATA_FORMATION_RB,USER_DATA_FORMATION_CBR];
        $_para[USER_DATA_FORMATION_LF] = [USER_DATA_FORMATION_RB,USER_DATA_FORMATION_CBR,USER_DATA_FORMATION_CBC];
        $_para[USER_DATA_FORMATION_CF] = [USER_DATA_FORMATION_CBR,USER_DATA_FORMATION_CBC, USER_DATA_FORMATION_CBL];
        $_para[USER_DATA_FORMATION_RF] = [USER_DATA_FORMATION_CBC,USER_DATA_FORMATION_CBL,USER_DATA_FORMATION_LB];
        $_para[USER_DATA_FORMATION_RW] = [USER_DATA_FORMATION_CBL,USER_DATA_FORMATION_LB];

        $_para[USER_DATA_FORMATION_RB] = [USER_DATA_FORMATION_LW,USER_DATA_FORMATION_LF];
        $_para[USER_DATA_FORMATION_CBR] = [USER_DATA_FORMATION_LW,USER_DATA_FORMATION_LF,USER_DATA_FORMATION_CF];
        $_para[USER_DATA_FORMATION_CBC] = [USER_DATA_FORMATION_LF,USER_DATA_FORMATION_CF, USER_DATA_FORMATION_RF];
        $_para[USER_DATA_FORMATION_CBL] = [USER_DATA_FORMATION_CF,USER_DATA_FORMATION_RF,USER_DATA_FORMATION_RW];
        $_para[USER_DATA_FORMATION_LB] = [USER_DATA_FORMATION_RF,USER_DATA_FORMATION_RW];

        $_para[USER_DATA_FORMATION_DML] = [USER_DATA_FORMATION_AMR,USER_DATA_FORMATION_AMC];
        $_para[USER_DATA_FORMATION_DMC] = [USER_DATA_FORMATION_AMR,USER_DATA_FORMATION_AMC,USER_DATA_FORMATION_AMR];
        $_para[USER_DATA_FORMATION_DMR] = [USER_DATA_FORMATION_AML,USER_DATA_FORMATION_AMC];

        $_para[USER_DATA_FORMATION_AML] = [USER_DATA_FORMATION_DMR,USER_DATA_FORMATION_DMC];
        $_para[USER_DATA_FORMATION_AMC] = [USER_DATA_FORMATION_DMR,USER_DATA_FORMATION_DMC,USER_DATA_FORMATION_DMR];
        $_para[USER_DATA_FORMATION_AMR] = [USER_DATA_FORMATION_DML,USER_DATA_FORMATION_DMC];

        $_para[USER_DATA_FORMATION_LM] = [USER_DATA_FORMATION_LW,USER_DATA_FORMATION_LF];
        $_para[USER_DATA_FORMATION_CML] = [USER_DATA_FORMATION_LW,USER_DATA_FORMATION_LF,USER_DATA_FORMATION_CF];
        $_para[USER_DATA_FORMATION_CMC] = [USER_DATA_FORMATION_LF,USER_DATA_FORMATION_CF, USER_DATA_FORMATION_RF];
        $_para[USER_DATA_FORMATION_CMR] = [USER_DATA_FORMATION_CF,USER_DATA_FORMATION_RF,USER_DATA_FORMATION_RW];
        $_para[USER_DATA_FORMATION_RM] = [USER_DATA_FORMATION_RF,USER_DATA_FORMATION_RW];

        return $_para;
    }

    function sortParaCardNum($paraArr = null)
    {
        $_count = [1=>2,4=>3,6=>1,3=>3,7=>2,9=>1,2=>3,15=>2,11=>1];
//        foreach($paraArr as $paraNum)
//        {
//            array_push($_count, count($paraNum));
//        }
        $_para = $this->getPara();
        asort($_para);
//        asort($_count);
        var_dump($_para);
    }

    function formatFormation()
    {
        XmlConfigMgr::getInstance()->init();
        $_fieldPosition = XmlConfigMgr::getInstance()->getFieldPositionConfig();
//        var_dump($_fieldPosition);
        $_formationArr = array();

        $_data = array();
        $_count = 0;
        for($i=1;$i<=22;$i++)
        {
            if(!empty(rand(0, 1)))
            {
                $_data[$i] = $i;
                $_count ++;
            }

            if($_count == 12)
                break;
        }
        var_dump($_fieldPosition);
        foreach($_data as $field => $value)
        {
            if($field == DATA_BASE_FORMATION_USERID)
            {
                continue;
            }

            $_config = $_fieldPosition->findFieldPositionConfig($field);
            $_line = $_config['Line'];
            $_index = $_config['LineOrder'];
            if(empty($_formationArr[$_line]))
            {
                $_formationArr[$_line] = array();
            }

            $_info = array();
            $_info[0] = $field;
            $_info[1] = $value;

//            array_push($_formationArr[$_line], $_info);
            $_formationArr[$_line][$_index] = $_info;
        }
        var_dump($_formationArr);

//        $_info = array();
//        $_info[0] = 0;
//        $_info[1] = 0;
//        $_info[2] = 1;
//        $_info[3] = 7;
//
//        $_info2 = array();
//        $_info2[0] = 0;
//        $_info2[1] = 0;
//        $_info2[2] = 10;
//        $_info2[3] = 2;
//        var_dump($this->getCardDistance($_info, $_info2));
    }

    private function getCardDistance($cardA, $cardB)
    {
//        return ceil(sqrt(pow($cardA[2]-$cardB[2], 2) + pow($cardA[3]-$cardB[3], 2)));
        return $_seed = rand(-1, 1);
    }

    function testMultiInsert()
    {
        $_db = new MysqlDB(1);
        $_fieldList=eval(DATA_BASE_FRIEND_FIELD);

        $data = array();
        for($i=0;$i<18;$i++)
        {
            $_friend = array();
            $_friend[DATA_BASE_FRIEND_USERID] = $i+1;
            $_friend[DATA_BASE_FRIEND_NICK] = $i;
            $_friend[DATA_BASE_FRIEND_FRIENDID] = 18- $i+1;

            array_push($data, $_friend);
        }
        $_db->DB_multi_insert(DATA_BASE_FRIEND, $_fieldList, $data);

    }

    function getMapInfo()
    {
        $_map = array();

        for($row = 1;$row <= 13; $row ++)
        {
            for($column = 1; $column <=20;$column++)
            {
                $_map[$row][$column] = $column;
            }
        }

        var_dump( $_map[10][3]);
    }

    public function DB_multi_insert($tableName, $fieldList, $data)
    {
        funcStart(__METHOD__);
        if(!is_array($data))
            return false;

        $_count = 0;
        $_filedCount = count($data[0]) - 1;

        $_sql = "insert into {$tableName}(";
        //拼接需要的字段
        foreach ($data[0] as $key => $attribute)
        {
            if($_count == $_filedCount)
            {
                $_sql .= $fieldList[$key] . ") values(";
            }
            else
            {
                $_sql .= $fieldList[$key] . ",";
            }
            $_count ++;
        }


//        foreach ($data as $key => $value)
//        {
//            if($_count == $_filedCount)
//            {
//                $_sql .= $fieldList[$key] . ") values(";
//            }
//            else
//            {
//                $_sql .= $fieldList[$key] . ",";
//            }
//            $_count ++;
//        }

        $_indexCount = count($data) - 1;
        $_index = 0;
        foreach($data as $row)
        {
            if(!is_array($row))
            {
                continue;
            }
            $_count = 0;
            foreach ($row as $value)
            {
                $_value = $value;
                if(is_array($_value))
                {
                    $_value = "'".json_encode($_value)."'";
                }
                else if(!is_numeric($_value) or is_string($_value))
                {
                    $_value = "'{$_value}'";
                }

                if($_count == $_filedCount)
                {
                    if($_index == $_indexCount)
                    {
                        $_sql .= $_value . ");";
                    }
                    else
                        $_sql .= $_value . "),(";
                }
                else
                {
                    $_sql .= $_value . ",";
                }
                $_count ++;
            }

            $_index++;
        }

        funcEnd(__METHOD__);
        var_dump($_sql);
        return true;
    }

    function toDaXie()
    {

       $a = "Nationality";
       echo var_dump(strtoupper($a));
       $a = "Name" ;
        echo var_dump(strtoupper($a));
       $a = "Familyname" ;
        echo var_dump(strtoupper($a));
       $a = "Height";
        echo var_dump(strtoupper($a));
       $a = "Weight" ;
        echo var_dump(strtoupper($a));
       $a = "Position1" ;
        echo var_dump(strtoupper($a));
       $a = "Position2" ;
        echo var_dump(strtoupper($a));
       $a = "Position3" ;
        echo var_dump(strtoupper($a));
       $a = "Preferredfoot";
        echo var_dump(strtoupper($a));
       $a = "Feildposition";
        echo var_dump(strtoupper($a));
       $a = "Age";
        echo var_dump(strtoupper($a));
       $a = "Retireage" ;
        echo var_dump(strtoupper($a));
       $a = "Club";
        echo var_dump(strtoupper($a));
       $a = "Value";
        echo var_dump(strtoupper($a));
       $a = "Wage";
        echo var_dump(strtoupper($a));
       $a = "Number";
        echo var_dump(strtoupper($a));
       $a = "Contratvaliduntil";
        echo var_dump(strtoupper($a));
       $a = "Attack";
        echo var_dump(strtoupper($a));
       $a = "Skill";
        echo var_dump(strtoupper($a));
       $a = "Physicality" ;
        echo var_dump(strtoupper($a));
       $a = "Mentality"  ;
        echo var_dump(strtoupper($a));
       $a = "Defence";
        echo var_dump(strtoupper($a));
       $a = "Gaolkeeping" ;
        echo var_dump(strtoupper($a));
       $a = "Finishing"  ;
        echo var_dump(strtoupper($a));
       $a = "Crossing";
        echo var_dump(strtoupper($a));
       $a = "Heading";
        echo var_dump(strtoupper($a));
       $a = "Longshots"  ;
        echo var_dump(strtoupper($a));
       $a = "Freekick";
        echo var_dump(strtoupper($a));
       $a = "Dribbling"  ;
        echo var_dump(strtoupper($a));
       $a = "Longpassing" ;
        echo var_dump(strtoupper($a));
       $a = "Ballcontrol" ;
        echo var_dump(strtoupper($a));
       $a = "Curve";
        echo var_dump(strtoupper($a));
       $a = "Shortpassig" ;
        echo var_dump(strtoupper($a));
       $a = "Power";
        echo var_dump(strtoupper($a));
       $a = "Stamina";
        echo var_dump(strtoupper($a));
       $a = "Strength";
        echo var_dump(strtoupper($a));
       $a = "Reaction";
        echo var_dump(strtoupper($a));
       $a = "Speed";
        echo var_dump(strtoupper($a));
       $a = "Aggression" ;
        echo var_dump(strtoupper($a));
       $a = "Movement";
        echo var_dump(strtoupper($a));
       $a = "Vision";
        echo var_dump(strtoupper($a));
       $a = "Composure"  ;
        echo var_dump(strtoupper($a));
       $a = "Penalties"  ;
        echo var_dump(strtoupper($a));
       $a = "Marking";
        echo var_dump(strtoupper($a));
       $a = "Standingtackle";
       echo var_dump(strtoupper($a));
       $a = "Slidingtackle";
       echo var_dump(strtoupper($a));
       $a = "Interceptions";
       echo var_dump(strtoupper($a));
       $a = "Postioning" ;
        echo var_dump(strtoupper($a));
       $a = "Gkdiving";
        echo var_dump(strtoupper($a));
       $a = "Gkhanding"  ;
        echo var_dump(strtoupper($a));
       $a = "Gkpostioning";
        echo var_dump(strtoupper($a));
       $a = "Gkreflexes" ;
        echo var_dump(strtoupper($a));
       $a = "Gkkicking"  ;
        echo var_dump(strtoupper($a));

    }
    
    function leagueTest()
    {
    	XmlConfigMgr::getInstance()->init();
    	include_once 'logic/LeagueLogic.php';
    	$a = new LeagueLogic();
    	$a->massGenerate(1);
    	
    	exit;
    }
    
    function leagueRank()
    {
    	$a = new CS_LEAGUERANK_REQ();
		return array(CSID_LEAGUERANK_REQ, $a);
    }
    
    function leagueSchedule()
    {
    	$a = new CS_LEAGUE_SCHEDULE_REQ();
    	$a->__UserId = 0;
    	$a->__Round = array(1,2,3,4);
    	return array(CSID_LEAGUE_SCHEDULE_REQ, $a);
    }
    
    function leagueFBRank()
    {
    	$a = new CS_LEAGUE_FOOTBALLER_RANK_REQ();
    	return array(CSID_LEAGUE_FOOTBALLER_RANK_REQ, $a);
    }
	
	/**
	 * Curl版本
	 * 使用方法：
	 * $post_string = "app=request&version=beta";
	 * request_by_curl('http://facebook.cn/restServer.php',$post_string);
	 */
	function request_by_curl($remote_server, $post_string)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $remote_server);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'data=' . $post_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Jimmy's CURL Example beta");
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}