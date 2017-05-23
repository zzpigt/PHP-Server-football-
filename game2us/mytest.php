<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/5/13
 * Time: 16:29
 */

include_once("MyConstant.php");
//include_once("ProtoAction.php");
include_once('proto/proto.php');
include_once('base/DataBaseField.php');
include_once('XmlConfigMgr.php');
include_once('logic/ConfigLogic.php');
include_once ('model/ConfigModel.php');
include_once ('MyConstant.php');
//include_once ('proto/protoFile.php');
include_once (APP_BASE_PATH."Security.php");
include_once (getcwd()."/Registry.php");
include_once (APP_LOGIC_PATH."MemInfoLogic.php");



$test = new TestFunction();
$test2 = new ConfigLogic();
// test
//$data = $test->encrypt(2,5);
//echo $data;
//$redata = $test->decrypt($data,5);
//echo "<br>".$redata;
/*if($data = $test2->getCurLeagueId()){
    echo $data;
}else
    echo "no";*/
//echo getMyDayIndex();
//echo $test->setToken(1093);
//$token = $test->setToken(1093);
//echo $test->getUserId($token);
//echo $test->createChar(4);
//$test->showXmlFile(CONFIG_COLORDATA);
//echo array_keys($DBConfig)[1];
//$arrayTest = $test->upDataTableNum(34,40);
//print_r($arrayTest);
//echo $dbKeyNum = array_keys($DBConfig)[0];

/*$a=array(array("A","Cat","Dog","A","Dog"),array("A","Cat","Dog","A","Dog"),array("B","Cat","Dog","A","Dog"),array("B","Cat","Dog","A","Dog"));
$i = 0;
foreach($a as $value){
    $b[$i++]=$value[0];
}
//print_r($b);
print_r(array_count_values($b));*/
/*
$one = array(1,2,3);
$two = array(4,5,6);
$arr = array();
$arr[] = $one;
//$arr[] = $two;

print_r($arr);

print_r($one);

print_r($two);*/

$connectMem = new Memcache();
if($connectMem->pconnect("127.0.0.1", "11211"))
    echo "access!";






class TestFunction{
    public function encrypt($input, $key) {
        $size = mcrypt_get_key_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = TestFunction::pkcs5_pad($input, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }

    private static function pkcs5_pad ($text, $blockSize) {
        $pad = $blockSize - (strlen($text) % $blockSize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public static function decrypt($sStr, $key) {
        $decrypted = mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $key,
            base64_decode($sStr),
            MCRYPT_MODE_ECB
        );

        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }
    function setToken($userId){
        if(empty($userId)){
            return 0;
        }
        //加密$userId
        $_userId = Security::encrypt($userId,SECURITY_KEY);
        //
        $token = mt_rand(time()/10, time());
        $token .= "|".$this->createChar(4).$_userId;
        return $token;
    }

    function getUserId($token)
    {
        if(empty($token))
            return 0;

        $index = substr($token, 14);
        $_index= Security::decrypt($index,SECURITY_KEY);
        $userId = null;
        if($_index)
        {
            $userId = MemInfoLogic::Instance()->getMemData($token);
        }

        if(!empty($userId)) {
            return $userId;
        }
        return 0;
    }

    //随机字符
    function createChar($length){
        $randStr = "";
        for($i=0;$i<$length;$i++){
            $randStr .=chr(mt_rand(65,122));
        }
        return $randStr;
    }

    function showXmlFile($xmlFile){
//        $initArray = array();
        $content = file_get_contents($xmlFile);
//        $this->$initArray = my_xml_decode($content);
        print_r(my_xml_decode($content)[1]);
    }

    function upDataTableNum( $dataNum, $shardingNum){
//        $leagueNum = self::$_ConfigModel->getFieldByIndex($dataBaseNum);
        $leagueNum = 10;
        if(isset($leagueNum) /*&& $this->updateConfig($dataBaseNum, $leagueNum + $dataNum)*/)
        {
            global $DBConfig;
            $dataTableNum = array();
//            $dbKeyNum = array_keys($DBConfig)[intval(floor(($leagueNum+1)/$shardingNum))];
//            $flog = 0;
            for($i=0;$i<$dataNum;$i++){
                $dbKeyNum = array_keys($DBConfig)[intval(floor(($leagueNum+1)/$shardingNum))];
                $dataTableNum[$i] = $dbKeyNum.(String)($leagueNum + $i + 1);
            }
            return $dataTableNum;//返回一个数组，每条数据所在数据库的key值
        }
        return null;
    }


}