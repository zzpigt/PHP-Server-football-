﻿--
-- Script was generated by Devart dbForge Studio for MySQL, Version 7.1.13.0
-- Product home page: http://www.devart.com/dbforge/mysql/studio
-- Script date 2017/4/1 16:10:05
-- Server version: 5.7.9
-- Client version: 4.1
--


-- 
-- Disable foreign keys
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Set SQL mode
-- 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 
-- Set character set the client will use to send SQL statements to the server
--
SET NAMES 'utf8';

-- 
-- Set default database
--
USE football;

--
-- Definition for table cards
--
DROP TABLE IF EXISTS cards;
CREATE TABLE cards (
  uid INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '球员UID',
  cid INT(5) DEFAULT 0 COMMENT '球员ID',
  userid INT(11) NOT NULL DEFAULT 0 COMMENT '玩家ID',
  Nationality VARCHAR(10) DEFAULT NULL COMMENT '国籍',
  Name VARCHAR(10) DEFAULT NULL COMMENT '名',
  Familyname VARCHAR(10) DEFAULT NULL COMMENT '姓',
  Height TINYINT(3) UNSIGNED DEFAULT 0 COMMENT '身高',
  Weight TINYINT(3) UNSIGNED DEFAULT 0 COMMENT '体重',
  Position1 VARCHAR(10) DEFAULT NULL COMMENT '擅长位置1',
  Position2 VARCHAR(10) DEFAULT NULL COMMENT '擅长位置2',
  Position3 VARCHAR(10) DEFAULT NULL COMMENT '擅长位置3',
  Preferredfoot TINYINT(3) UNSIGNED DEFAULT 0 COMMENT '擅长脚',
  Feildposition VARCHAR(10) DEFAULT '0' COMMENT '场上位置',
  Age TINYINT(3) UNSIGNED DEFAULT 0 COMMENT '年龄',
  Retireage TINYINT(3) UNSIGNED DEFAULT 0 COMMENT '退休年龄',
  Club VARCHAR(10) DEFAULT NULL COMMENT '俱乐部',
  Value DOUBLE DEFAULT 0 COMMENT '身价',
  Wage DOUBLE DEFAULT 0 COMMENT '薪资',
  Number TINYINT(3) UNSIGNED DEFAULT 0 COMMENT '号码',
  Contratvaliduntil TINYINT(3) UNSIGNED DEFAULT 0 COMMENT '合约剩余时间',
  Attack DOUBLE DEFAULT 0 COMMENT '进攻',
  Skill DOUBLE DEFAULT 0 COMMENT '技术',
  Physicality DOUBLE DEFAULT 0 COMMENT '身体',
  Mentality DOUBLE DEFAULT 0 COMMENT '心理',
  Defence DOUBLE DEFAULT 0 COMMENT '防守',
  Gaolkeeping DOUBLE DEFAULT 0 COMMENT '守门',
  Finishing DOUBLE DEFAULT 0 COMMENT '射术',
  Crossing DOUBLE DEFAULT 0 COMMENT '传中',
  Heading DOUBLE DEFAULT 0 COMMENT '头球',
  Longshots DOUBLE DEFAULT 0 COMMENT '远射',
  Freekick DOUBLE DEFAULT 0 COMMENT '任意球精度',
  Dribbling DOUBLE DEFAULT 0 COMMENT '盘带',
  Longpassing DOUBLE DEFAULT 0 COMMENT '长传',
  Ballcontrol DOUBLE DEFAULT 0 COMMENT '控球',
  Curve DOUBLE DEFAULT 0 COMMENT '弧线',
  Shortpassig DOUBLE DEFAULT 0 COMMENT '短传',
  Power DOUBLE DEFAULT 0 COMMENT '力量',
  Stamina DOUBLE DEFAULT 0 COMMENT '体能',
  Strength DOUBLE DEFAULT 0 COMMENT '强壮',
  Reaction DOUBLE DEFAULT 0 COMMENT '反应',
  Speed DOUBLE DEFAULT 0 COMMENT '速度',
  Aggression DOUBLE DEFAULT 0 COMMENT '侵略性',
  Movement DOUBLE DEFAULT 0 COMMENT '跑位',
  Vision DOUBLE DEFAULT 0 COMMENT '视野',
  Composure DOUBLE DEFAULT 0 COMMENT '冷静',
  Penalties DOUBLE DEFAULT 0 COMMENT '点球',
  Marking DOUBLE DEFAULT 0 COMMENT '盯人',
  Standingtackle DOUBLE DEFAULT 0 COMMENT '抢断',
  Slidingtackle DOUBLE DEFAULT 0 COMMENT '铲球',
  Interceptions DOUBLE DEFAULT 0 COMMENT '拦截',
  Postioning DOUBLE DEFAULT 0 COMMENT '站位',
  Gkdiving DOUBLE DEFAULT 0 COMMENT '鱼跃',
  Gkhanding DOUBLE DEFAULT 0 COMMENT '手形',
  Gkpostioning DOUBLE DEFAULT 0 COMMENT '门将站位',
  Gkreflexes DOUBLE DEFAULT 0 COMMENT '门将反应',
  Gkkicking DOUBLE DEFAULT 0 COMMENT '开球',
  PRIMARY KEY (uid),
  INDEX cards_userid (userid)
)
ENGINE = INNODB
AUTO_INCREMENT = 866
AVG_ROW_LENGTH = 439
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '球员信息表'
ROW_FORMAT = DYNAMIC;

--
-- Definition for table chat
--
DROP TABLE IF EXISTS chat;
CREATE TABLE chat (
  chatid BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  userid INT(11) UNSIGNED DEFAULT NULL,
  nick VARCHAR(20) DEFAULT NULL,
  content VARCHAR(200) DEFAULT NULL,
  PRIMARY KEY (chatid)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '聊天表（暂时没用）'
ROW_FORMAT = DYNAMIC;

--
-- Definition for table club
--
DROP TABLE IF EXISTS club;
CREATE TABLE club (
  userid INT(11) UNSIGNED NOT NULL COMMENT '玩家ID',
  level TINYINT(3) UNSIGNED NOT NULL COMMENT '俱乐部等级',
  createdata INT(11) UNSIGNED NOT NULL COMMENT '俱乐部创建时间',
  country VARCHAR(16) NOT NULL COMMENT '国家',
  city VARCHAR(17) NOT NULL COMMENT '城市',
  stadiumname VARCHAR(23) NOT NULL COMMENT '体育场名称',
  stadiumseatnum VARCHAR(255) NOT NULL COMMENT '体育场座位数量',
  name VARCHAR(20) NOT NULL COMMENT '经理人名称',
  fans VARCHAR(21) DEFAULT NULL COMMENT '粉丝俱乐部名称',
  clubname VARCHAR(17) DEFAULT NULL COMMENT '俱乐部名称',
  avegoal DOUBLE UNSIGNED DEFAULT NULL COMMENT '平局进球',
  avefumble DOUBLE UNSIGNED DEFAULT NULL COMMENT '平局失球',
  starplayer INT(11) UNSIGNED DEFAULT NULL COMMENT '明星球员',
  bestshooter INT(11) UNSIGNED DEFAULT NULL COMMENT '最佳射手',
  scorelist DOUBLE UNSIGNED DEFAULT NULL COMMENT '评分榜',
  homejersey SMALLINT(5) UNSIGNED DEFAULT NULL COMMENT '主队球衣',
  awayjersey SMALLINT(5) UNSIGNED DEFAULT NULL COMMENT '客队球衣',
  teamsign SMALLINT(5) UNSIGNED DEFAULT NULL COMMENT '队徽',
  PRIMARY KEY (userid),
  UNIQUE INDEX club_userid (userid)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 16384
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci
COMMENT = '俱乐部信息表'
ROW_FORMAT = DYNAMIC;

--
-- Definition for table fightdata
--
DROP TABLE IF EXISTS fightdata;
CREATE TABLE fightdata (
  uid INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'UID',
  roomid INT(11) UNSIGNED NOT NULL COMMENT '房间ID',
  homescore SMALLINT(5) DEFAULT 0 COMMENT '主场得分',
  awayscore SMALLINT(5) DEFAULT 0 COMMENT '客场得分',
  eventdate INT(11) UNSIGNED NOT NULL COMMENT '事件执行时间',
  eventline VARCHAR(1000) DEFAULT NULL COMMENT '事件链',
  eventpoint TINYINT(4) DEFAULT NULL COMMENT '时间点',
  stagedate INT(11) UNSIGNED NOT NULL COMMENT '时间执行到的时间',
  homeformation VARCHAR(500) DEFAULT NULL COMMENT '主场阵型',
  awayformation VARCHAR(500) DEFAULT NULL COMMENT '客场阵型',
  ballcontrol SMALLINT(5) UNSIGNED DEFAULT 0 COMMENT '控球率',
  PRIMARY KEY (uid),
  INDEX fightdata_roomid (roomid)
)
ENGINE = INNODB
AUTO_INCREMENT = 7918
AVG_ROW_LENGTH = 1043
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '战斗信息表'
ROW_FORMAT = DYNAMIC;

--
-- Definition for table fightrooms
--
DROP TABLE IF EXISTS fightrooms;
CREATE TABLE fightrooms (
  uid INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '房间ID',
  starttime INT(11) UNSIGNED NOT NULL COMMENT '战斗开始时间',
  homeuserid INT(11) UNSIGNED NOT NULL COMMENT '主场玩家ID',
  awayuserid INT(11) UNSIGNED NOT NULL COMMENT '客场玩家ID',
  totalhomescore SMALLINT(5) DEFAULT 0 COMMENT '主场总得分',
  totalawayscore SMALLINT(5) DEFAULT 0 COMMENT '客场总得分',
  PRIMARY KEY (uid),
  INDEX fightrooms_homeuserid_awayuserid (homeuserid, awayuserid)
)
ENGINE = INNODB
AUTO_INCREMENT = 2000
AVG_ROW_LENGTH = 57
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '战斗房间表'
ROW_FORMAT = DYNAMIC;

--
-- Definition for table formation
--
DROP TABLE IF EXISTS formation;
CREATE TABLE formation (
  userid INT(11) UNSIGNED NOT NULL COMMENT '玩家ID',
  GK INT(11) UNSIGNED DEFAULT NULL,
  RB INT(11) UNSIGNED DEFAULT NULL,
  CBR INT(11) UNSIGNED DEFAULT NULL,
  CBC INT(11) UNSIGNED DEFAULT NULL,
  CBL INT(11) UNSIGNED DEFAULT NULL,
  LB INT(11) UNSIGNED DEFAULT NULL,
  DMR INT(11) UNSIGNED DEFAULT NULL,
  DMC INT(11) UNSIGNED DEFAULT NULL,
  DML INT(11) UNSIGNED DEFAULT NULL,
  RM INT(11) UNSIGNED DEFAULT NULL,
  LM INT(11) UNSIGNED DEFAULT NULL,
  CMR INT(11) UNSIGNED DEFAULT NULL,
  CMC INT(11) UNSIGNED DEFAULT NULL,
  CML INT(11) UNSIGNED DEFAULT NULL,
  AMR INT(11) UNSIGNED DEFAULT NULL,
  AMC INT(11) UNSIGNED DEFAULT NULL,
  AML INT(11) UNSIGNED DEFAULT NULL,
  RW INT(11) UNSIGNED DEFAULT NULL,
  LW INT(11) UNSIGNED DEFAULT NULL,
  RF INT(11) UNSIGNED DEFAULT NULL,
  CF INT(11) UNSIGNED DEFAULT NULL,
  LF INT(11) UNSIGNED DEFAULT NULL,
  S1 INT(11) UNSIGNED DEFAULT NULL,
  S2 INT(11) UNSIGNED DEFAULT NULL,
  S3 INT(11) UNSIGNED DEFAULT NULL,
  S4 INT(11) UNSIGNED DEFAULT NULL,
  S5 INT(11) UNSIGNED DEFAULT NULL,
  S6 INT(11) UNSIGNED DEFAULT NULL,
  S7 INT(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (userid),
  UNIQUE INDEX formation_userid (userid)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 409
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '阵型位置表'
ROW_FORMAT = DYNAMIC;

--
-- Definition for table friendlist
--
DROP TABLE IF EXISTS friendlist;
CREATE TABLE friendlist (
  userid INT(11) UNSIGNED NOT NULL COMMENT '玩家ID',
  friendid INT(11) UNSIGNED DEFAULT NULL COMMENT '好友ID',
  nick VARCHAR(20) DEFAULT NULL COMMENT '好友名称',
  club VARCHAR(20) DEFAULT NULL COMMENT '好友俱乐部',
  UNIQUE INDEX friendlist_userid_friendid (userid, friendid)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 4096
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '好友列表'
ROW_FORMAT = DYNAMIC;

--
-- Definition for table jersey
--
DROP TABLE IF EXISTS jersey;
CREATE TABLE jersey (
  userid INT(11) UNSIGNED NOT NULL COMMENT '玩家ID',
  jerseyid SMALLINT(5) UNSIGNED NOT NULL COMMENT '球衣ID',
  maincolor TINYINT(3) UNSIGNED NOT NULL COMMENT '球衣主颜色',
  color TINYINT(3) UNSIGNED NOT NULL COMMENT '球衣次颜色',
  INDEX jerser_userid (userid)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 2048
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '球衣信息表'
ROW_FORMAT = DYNAMIC;

--
-- Definition for table player
--
DROP TABLE IF EXISTS player;
CREATE TABLE player (
  userid INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '玩家ID',
  platformid VARCHAR(50) DEFAULT NULL COMMENT '平台',
  username VARCHAR(50) DEFAULT NULL COMMENT '玩家名称',
  userpwd VARCHAR(50) DEFAULT NULL COMMENT '密码',
  userkey VARCHAR(25) DEFAULT NULL,
  imei VARCHAR(64) DEFAULT NULL,
  email VARCHAR(50) DEFAULT NULL COMMENT '邮箱',
  isrole ENUM('1','2') DEFAULT NULL COMMENT '是否存在角色 1- 没有角色 2- 已有角色',
  isbd ENUM('1','2') DEFAULT NULL COMMENT '是否绑定 1- 未绑定 2- 绑定',
  identity VARCHAR(18) DEFAULT NULL,
  truename VARCHAR(50) DEFAULT NULL COMMENT '真实名字',
  iphone INT(11) DEFAULT NULL COMMENT '手机号',
  isadult ENUM('1','2') DEFAULT NULL COMMENT '1- 未成年 2- 已成年',
  isemail ENUM('1','2') DEFAULT NULL COMMENT '1- 邮箱未绑定 2- 邮箱绑定',
  regdate DATETIME DEFAULT NULL COMMENT '注册时间',
  macaddress VARCHAR(40) DEFAULT NULL COMMENT 'mac地址',
  timezone TINYINT(3) UNSIGNED DEFAULT NULL COMMENT '时区',
  isrobot ENUM('1','2') DEFAULT NULL COMMENT '1- 机器人 2- 玩家',
  leaguegroup INT(11) UNSIGNED DEFAULT NULL COMMENT '联赛组',
  PRIMARY KEY (userid),
  UNIQUE INDEX player_userid (userid)
)
ENGINE = INNODB
AUTO_INCREMENT = 120
AVG_ROW_LENGTH = 138
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '玩家信息表'
ROW_FORMAT = DYNAMIC;

--
-- Definition for table properties
--
DROP TABLE IF EXISTS properties;
CREATE TABLE properties (
  uid INT(11) UNSIGNED NOT NULL COMMENT '玩家ID',
  nick VARCHAR(20) DEFAULT NULL COMMENT '名字',
  money INT(11) DEFAULT 0 COMMENT '游戏币',
  rmb INT(11) DEFAULT 0 COMMENT '人民币',
  powercur INT(5) DEFAULT 0 COMMENT '当前体力',
  powerall INT(5) DEFAULT 0 COMMENT '总体力',
  medicalcur INT(5) DEFAULT 0 COMMENT '医疗包',
  moralecur INT(5) DEFAULT 0 COMMENT '士气包',
  pvproomid VARCHAR(20) DEFAULT NULL COMMENT '战斗房间标记 格式：(AUserId|BUserId)',
  PRIMARY KEY (uid),
  UNIQUE INDEX properties_uid (uid)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 218
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '玩家属性表'
ROW_FORMAT = DYNAMIC;

--
-- Definition for table tactics
--
DROP TABLE IF EXISTS tactics;
CREATE TABLE tactics (
  userid INT(11) UNSIGNED NOT NULL COMMENT '玩家ID',
  tactical1 INT(6) UNSIGNED DEFAULT NULL COMMENT '战术1-8',
  tactical2 INT(6) UNSIGNED DEFAULT NULL,
  tactical3 INT(6) UNSIGNED DEFAULT NULL,
  tactical4 INT(6) UNSIGNED DEFAULT NULL,
  tactical5 INT(6) UNSIGNED DEFAULT NULL,
  tactical6 INT(6) UNSIGNED DEFAULT NULL,
  tactical7 INT(6) UNSIGNED DEFAULT NULL,
  tactical8 INT(6) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (userid),
  UNIQUE INDEX tactice_userid (userid)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 780
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '战术表'
ROW_FORMAT = DYNAMIC;

--
-- Definition for table teamsign
--
DROP TABLE IF EXISTS teamsign;
CREATE TABLE teamsign (
  userid INT(11) UNSIGNED NOT NULL COMMENT '玩家ID',
  signid SMALLINT(5) UNSIGNED NOT NULL COMMENT '队徽ID',
  signtype TINYINT(3) UNSIGNED NOT NULL COMMENT '队徽形状',
  maincolor TINYINT(3) UNSIGNED NOT NULL COMMENT '队徽主要颜色',
  color TINYINT(3) UNSIGNED NOT NULL COMMENT '队徽次要颜色',
  INDEX teamsign_userid (userid)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 4096
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '队徽表'
ROW_FORMAT = DYNAMIC;

--
-- Definition for table userprofile
--
DROP TABLE IF EXISTS userprofile;
CREATE TABLE userprofile (
  userid INT(11) NOT NULL COMMENT '玩家ID',
  username VARCHAR(32) NOT NULL COMMENT '玩家名称',
  PRIMARY KEY (userid),
  UNIQUE INDEX userprofile_username (username)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 199
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = '玩家名称表'
ROW_FORMAT = DYNAMIC;

-- 
-- Restore previous SQL mode
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Enable foreign keys
-- 
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;