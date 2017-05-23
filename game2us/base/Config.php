<?php
/**
 * 网站配置信息
 */
define("DB_HOST",'dbHost');
define("DB_USER",'dbUser');
define("DB_PASSWORD",'dbPassWd');
define("DB_CHARSET",'dbCharset');
define("DB_NAME_LIST",'dbNameList');
define("DB_SHARDING_LEVEL",'shardingLevel');

define("DB_SHARDING_DEFAULT",2000000);
define("DB_SHARDING_LEAGUE",0);

define("DB_DEFAULT","football");
define("DB_LEAGUE","football_league");

$DBConfig = Array(
    //[1 -> 2000000]
    'dbKey1' =>
    Array(
//        DB_HOST    => '192.168.2.30',
        DB_HOST    => 'localhost',
        DB_USER    => 'root',
        DB_PASSWORD  => '',
        DB_CHARSET => 'utf8',
     // dbName'    => 'football',
        DB_NAME_LIST => array(DB_DEFAULT=>DB_DEFAULT,DB_LEAGUE=>DB_LEAGUE),
        DB_SHARDING_LEVEL => array(DB_DEFAULT=>DB_SHARDING_DEFAULT,DB_LEAGUE=>DB_SHARDING_LEAGUE),
    ),
    //[2000001 -> 4000000]
    'dbKey2' =>
    Array(
//        DB_HOST    => '192.168.2.30',
        DB_HOST    => 'localhost',
        DB_USER    => 'root',
        DB_PASSWORD  => '',
        DB_CHARSET => 'utf8',
        // 'dbName'    => 'football',
        DB_NAME_LIST => array(DB_DEFAULT=>DB_DEFAULT,DB_LEAGUE=>DB_LEAGUE),
        DB_SHARDING_LEVEL => array(DB_DEFAULT=>DB_SHARDING_DEFAULT,DB_LEAGUE=>DB_SHARDING_LEAGUE),
    ),
);

$StatisticsDB = array(
    'dbHost'    => '192.168.2.30',
    'dbUser'    => 'root',
    'dbPasswd'  => '',
    'dbCharset' => 'utf8',
    'dbName'    => 'football_statistics',
);

class AppConfig
{
    public $dbHost;        // 数据库地址
    public $dbUser;        // 数据库用户名
    public $dbPasswd;      // 数据库密码
    public $dbCharset;     // 数据库字符集
    public $dbName;        // 数据库名

    public function __construct()
    {
        $this->dbHost     = 'localhost';    // 数据库地址
        $this->dbUser     = 'root';           // 数据库用户名
        $this->dbPasswd   = '';         // 数据库密码
        $this->dbCharset  = 'utf8';            // 数据库字符集
        $this->dbName     = 'football';    // 数据库名
    }
}

class WebServerConfig extends AppConfig
{
	public function __construct()
	{
		$this->dbHost     = 'localhost';    // 数据库地址
		$this->dbUser     = 'root';           // 数据库用户名
		$this->dbPasswd   = '';         // 数据库密码
		$this->dbCharset  = 'utf8';            // 数据库字符集
		$this->dbName     = 'football';    // 数据库名
	}
}

//class MemXmlConfig
//{
//    public $memHost;        // mem地址
//    public $memPort;        // memPort
//    public  function  __construct()
//    {
//        $this->memHost = '127.0.0.1';
//        $this->memPort = '11210';
//    }
//}

class PlayerMaxNumDB
{
    public $dbHost;        // 数据库地址
    public $dbUser;        // 数据库用户名
    public $dbPasswd;      // 数据库密码
    public $dbCharset;     // 数据库字符集
    public $dbName;        // 数据库名

    public function __construct()
    {
        $this->dbHost     = '';    // 数据库地址
        $this->dbUser     = 'root';           // 数据库用户名
        $this->dbPasswd   = 'root';         // 数据库密码
        $this->dbCharset  = 'utf8';            // 数据库字符集
        $this->dbName     = 'playermaxnum';    // 数据库名
    }
}

$LeagueDB = array(
		'dbHost'    => '192.168.2.30',
		'dbUser'    => 'root',
		'dbPasswd'  => '',
		'dbCharset' => 'utf8',
		'dbName'    => 'football_league',
);

$MemConfig = Array(
    //[1 -> 200000]
    Array(
        'memHost' => '127.0.0.1',
        'memPort' => '11211',
    ),
    
//    Array(
//        'memHost' => '127.0.0.1',
//        'memPort' => '11213',
//    ),
//    Array(
//        'memHost' => '127.0.0.1',
//        'memPort' => '11214',
//    ),
//    Array(
//        'memHost' => '127.0.0.1',
//        'memPort' => '11215',
//    ),
//    Array(
//        'memHost' => '127.0.0.1',
//        'memPort' => '11216',
//    ),
//    Array(
//        'memHost' => '127.0.0.1',
//        'memPort' => '11217',
//    ),
//    Array(
//        'memHost' => '127.0.0.1',
//        'memPort' => '11218',
//    ),
//    Array(
//        'memHost' => '127.0.0.1',
//        'memPort' => '11219',
//    ),
//    Array(
//        'memHost' => '127.0.0.1',
//        'memPort' => '11220',
//    ),
);

