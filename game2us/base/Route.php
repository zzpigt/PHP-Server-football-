<?php

function getHash($str)
{
	$hash = 0;
    $_md5 = md5($str);
    $seed = 5;
    $len = 32;
    for ($i=0; $i < $len; $i++) { 
        $hash = ($hash<<$seed) + $hash + ord($_md5{$i});
    }

    return $hash & 0x7FFFFFFF;
}

//route need extra add rule 
//get serverList
//serverList strut:
//$[getDBIndexByHash] = real index
function getDBIndexByHash($hash)
{
    $_config = ConfigLogic::Instance();
    if(empty($_config))
    {
        return 0;
    }
    $_serverNum = $_config->getConfigByField(DATA_BASE_CONFIG_SERVERNUM);
	$_index = $hash % $_serverNum;
	return intval($_index); 
}

//?拿到用户ID的一个方法
function getDataBaseIndex($userID)
{
    return intval(floor($userID/MYSQL_MAX_NUM));
}