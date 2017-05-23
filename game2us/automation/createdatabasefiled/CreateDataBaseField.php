<?php
/*
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/2/7
 * Time: 14:01
 */
include_once ("../base/DB.php");
include_once ("../proto/proto.php");

$tableName = array(
    'DATA_BASE_PLAYER' => 'player',
    'DATA_BASE_PROPERTIES' => 'properties',
    'DATA_BASE_USERPROFILE' => 'userprofile',
    'DATA_BASE_CARDS' => 'cards',
    'DATA_BASE_CHAT' => 'chat',
    'DATA_BASE_FRIENDLIST' => 'friendlist',
    'DATA_BASE_FORMATION' => 'formation',
    'DATA_BASE_TACTICS' => 'tactics',
    'DATA_BASE_FIGHTROOMS' => 'fightrooms',
    'DATA_BASE_FIGHTDATA' => 'fightdata',
    'DATA_BASE_JERSEY' => 'jersey',
    'DATA_BASE_TEAMSIGN' => 'teamsign',
    'DATA_BASE_CLUB' => 'club',
    'DATA_BASE_TROPHY' => 'trophy',
    'DATA_BASE_MEMINFO' => 'meminfo',
    'DATA_BASE_CONFIG' => 'config',
    'DATA_BASE_CARD_RECOMMEND' => 'card_recommend',
    'DATA_BASE_SCOUT' => 'scout',

    'DATA_BASE_CARD_STATISTICS' => 'card_statistics',
    'DATA_BASE_GAME_STATISTICS' => 'game_statistics',
    'DATA_BASE_LEAGUE' => 'league',
    'DATA_BASE_LEAGUE_SCHEDULE' => 'league_schedule',
    'DATA_BASE_LEAGUE_RANK' => 'league_rank',
    'DATA_BASE_LEAGUE_FOOTBALLER_RANK' => 'league_footballer_rank'
);

createDataBaseField();
function createDataBaseField()
{
    $_file = fopen("../base/DataBaseField.php", "w") or die("Unable to open file!");
    $_txt = "<?php \r\n";
    fwrite($_file, $_txt);

    global $tableName;
    fwrite($_file, getFieldTxt($tableName));

    fclose($_file);
}

function getFieldTxt($list)
{
    $_txt = null;
    global $DBConfig;
    $_db = new MysqlDB();
    $_db->TableName(1);
    $_db->PK(1);
    $_db->FieldList(array(1));
    $_db->TableEnum(1);
    if(!$_db->initDB("dbKey1|1"))
    {
        return null;
    }
    foreach ($list as $_constName => $_tableName)
    {
        $_txt .= "\r\n";
        $_txt .= "const ". $_constName . " = '". $_tableName ."';\r\n";

        $_fieldList = $_db->query("select DISTINCT column_name  from Information_schema.columns  where table_Name = '".$_tableName."';");

        if(!is_array($_fieldList))
        {
            echo $_tableName."no have field";
            break;
        }

        $_count = 0;
        foreach ($_fieldList as $_value)
        {
            $_txt .= "const $_constName".'_'.strtoupper($_value['column_name'])." = ". $_count .";\r\n";
            $_count ++;
        }

        //取出字段
        $_txt .= "define('".$_constName."_FIELD',\"return array(\n";
//        if($addColumn)
//        {
//            $_txt .= "\t'',\n";
//        }
        //$_txt .= print_r($_fieldList, true);
        foreach ($_fieldList as $_value)
        {
            $_txt .= "\t'$_value[column_name]',\n";
        }
        $_txt .= ');");';
        $_txt .= "\r\n";

        //取出主键
        $_primaryKeyTxt = "define('".$_constName."_PRI',";
//        $_txt .= "define('".$_constName."_PRI',";
        $sql = "desc $_tableName";
        $res = $_db->query($sql);

        $_havePrimary = false;
        foreach ($res as $_value)
        {
            if($_value['Key'] == 'PRI'){
                $_primaryKeyTxt .= "\"".$_value['Field']."\"); \n"; //主键
                $_havePrimary = true;
                break;
            }
        }
        if(!$_havePrimary)
        {
            unset($_primaryKeyTxt);
        }
        else
        {
            $_txt .= $_primaryKeyTxt;
        }
        $_txt .= "\r\n";
    }
    return $_txt;
}