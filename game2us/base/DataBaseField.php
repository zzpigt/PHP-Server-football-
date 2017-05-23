<?php 

const DATA_BASE_PLAYER = 'player';
const DATA_BASE_PLAYER_USERID = 0;
const DATA_BASE_PLAYER_PLATFORMID = 1;
const DATA_BASE_PLAYER_USERNAME = 2;
const DATA_BASE_PLAYER_USERPWD = 3;
const DATA_BASE_PLAYER_USERKEY = 4;
const DATA_BASE_PLAYER_IMEI = 5;
const DATA_BASE_PLAYER_EMAIL = 6;
const DATA_BASE_PLAYER_ISROLE = 7;
const DATA_BASE_PLAYER_ISBD = 8;
const DATA_BASE_PLAYER_IDENTITY = 9;
const DATA_BASE_PLAYER_TRUENAME = 10;
const DATA_BASE_PLAYER_IPHONE = 11;
const DATA_BASE_PLAYER_ISADULT = 12;
const DATA_BASE_PLAYER_ISEMAIL = 13;
const DATA_BASE_PLAYER_REGDATE = 14;
const DATA_BASE_PLAYER_MACADDRESS = 15;
const DATA_BASE_PLAYER_TIMEZONE = 16;
const DATA_BASE_PLAYER_ISROBOT = 17;
const DATA_BASE_PLAYER_LEAGUERID = 18;
define('DATA_BASE_PLAYER_FIELD',"return array(
	'userId',
	'platformId',
	'userName',
	'userPwd',
	'userKey',
	'imei',
	'email',
	'isrole',
	'isbd',
	'identity',
	'trueName',
	'iphone',
	'isadult',
	'isemail',
	'regdate',
	'macAddress',
	'timezone',
	'isrobot',
	'leaguerid',
);");
define('DATA_BASE_PLAYER_PRI',"userId"); 


const DATA_BASE_PROPERTIES = 'properties';
const DATA_BASE_PROPERTIES_UID = 0;
const DATA_BASE_PROPERTIES_NICK = 1;
const DATA_BASE_PROPERTIES_DIAMOND = 2;
const DATA_BASE_PROPERTIES_MONEY = 3;
const DATA_BASE_PROPERTIES_POWERBAG = 4;
const DATA_BASE_PROPERTIES_MEDICALBAG = 5;
const DATA_BASE_PROPERTIES_MORALEBAG = 6;
const DATA_BASE_PROPERTIES_SKILLBAG = 7;
const DATA_BASE_PROPERTIES_PVPROOMID = 8;
const DATA_BASE_PROPERTIES_RECOMMENDENDTIME = 9;
const DATA_BASE_PROPERTIES_RECOMMENDSTARTTIME = 10;
const DATA_BASE_PROPERTIES_RECOMMENDLASTTIME = 11;
define('DATA_BASE_PROPERTIES_FIELD',"return array(
	'uId',
	'nick',
	'diamond',
	'money',
	'powerBag',
	'medicalBag',
	'moraleBag',
	'skillBag',
	'pvproomid',
	'recommendEndTime',
	'recommendStartTime',
	'recommendLastTime',
);");
define('DATA_BASE_PROPERTIES_PRI',"uId"); 


const DATA_BASE_USERPROFILE = 'userprofile';
const DATA_BASE_USERPROFILE_USERID = 0;
const DATA_BASE_USERPROFILE_USERNAME = 1;
define('DATA_BASE_USERPROFILE_FIELD',"return array(
	'userId',
	'userName',
);");
define('DATA_BASE_USERPROFILE_PRI',"userId"); 


const DATA_BASE_CARDS = 'cards';
const DATA_BASE_CARDS_UID = 0;
const DATA_BASE_CARDS_CID = 1;
const DATA_BASE_CARDS_USERID = 2;
const DATA_BASE_CARDS_NATIONALITY = 3;
const DATA_BASE_CARDS_NAME = 4;
const DATA_BASE_CARDS_FAMILYNAME = 5;
const DATA_BASE_CARDS_HEIGHT = 6;
const DATA_BASE_CARDS_WEIGHT = 7;
const DATA_BASE_CARDS_POSITION1 = 8;
const DATA_BASE_CARDS_POSITION2 = 9;
const DATA_BASE_CARDS_POSITION3 = 10;
const DATA_BASE_CARDS_PREFERREDFOOT = 11;
const DATA_BASE_CARDS_FEILDPOSITION = 12;
const DATA_BASE_CARDS_AGE = 13;
const DATA_BASE_CARDS_RETIREAGE = 14;
const DATA_BASE_CARDS_CLUB = 15;
const DATA_BASE_CARDS_VALUE = 16;
const DATA_BASE_CARDS_WAGE = 17;
const DATA_BASE_CARDS_NUMBER = 18;
const DATA_BASE_CARDS_CONTRATVALIDUNTIL = 19;
const DATA_BASE_CARDS_ATTACK = 20;
const DATA_BASE_CARDS_SKILL = 21;
const DATA_BASE_CARDS_PHYSICALITY = 22;
const DATA_BASE_CARDS_MENTALITY = 23;
const DATA_BASE_CARDS_DEFENCE = 24;
const DATA_BASE_CARDS_GAOLKEEPING = 25;
const DATA_BASE_CARDS_FINISHING = 26;
const DATA_BASE_CARDS_CROSSING = 27;
const DATA_BASE_CARDS_HEADING = 28;
const DATA_BASE_CARDS_LONGSHOTS = 29;
const DATA_BASE_CARDS_FREEKICK = 30;
const DATA_BASE_CARDS_DRIBBLING = 31;
const DATA_BASE_CARDS_LONGPASSING = 32;
const DATA_BASE_CARDS_BALLCONTROL = 33;
const DATA_BASE_CARDS_CURVE = 34;
const DATA_BASE_CARDS_SHORTPASSIG = 35;
const DATA_BASE_CARDS_POWER = 36;
const DATA_BASE_CARDS_STAMINA = 37;
const DATA_BASE_CARDS_STRENGTH = 38;
const DATA_BASE_CARDS_REACTION = 39;
const DATA_BASE_CARDS_SPEED = 40;
const DATA_BASE_CARDS_AGGRESSION = 41;
const DATA_BASE_CARDS_MOVEMENT = 42;
const DATA_BASE_CARDS_VISION = 43;
const DATA_BASE_CARDS_COMPOSURE = 44;
const DATA_BASE_CARDS_PENALTIES = 45;
const DATA_BASE_CARDS_MARKING = 46;
const DATA_BASE_CARDS_STANDINGTACKLE = 47;
const DATA_BASE_CARDS_SLIDINGTACKLE = 48;
const DATA_BASE_CARDS_INTERCEPTIONS = 49;
const DATA_BASE_CARDS_POSTIONING = 50;
const DATA_BASE_CARDS_GKDIVING = 51;
const DATA_BASE_CARDS_GKHANDING = 52;
const DATA_BASE_CARDS_GKPOSTIONING = 53;
const DATA_BASE_CARDS_GKREFLEXES = 54;
const DATA_BASE_CARDS_GKKICKING = 55;
const DATA_BASE_CARDS_REDCARD = 56;
const DATA_BASE_CARDS_YELLOWCARD = 57;
const DATA_BASE_CARDS_LEAGUEDATA = 58;
const DATA_BASE_CARDS_CUPDATA = 59;
const DATA_BASE_CARDS_CHAMPIONSLEAGEUEDATA = 60;
const DATA_BASE_CARDS_SCORELIST = 61;
define('DATA_BASE_CARDS_FIELD',"return array(
	'uId',
	'cId',
	'userId',
	'nationality',
	'name',
	'familyName',
	'height',
	'weight',
	'position1',
	'position2',
	'position3',
	'preferredFoot',
	'feildPosition',
	'age',
	'retireAge',
	'club',
	'value',
	'wage',
	'number',
	'contratvaliduntil',
	'attack',
	'skill',
	'physicality',
	'mentality',
	'defence',
	'gaolkeeping',
	'finishing',
	'crossing',
	'heading',
	'longshots',
	'freekick',
	'dribbling',
	'longPassing',
	'ballControl',
	'curve',
	'shortPassig',
	'power',
	'stamina',
	'strength',
	'reaction',
	'speed',
	'aggression',
	'movement',
	'vision',
	'composure',
	'penalties',
	'marking',
	'standingTackle',
	'slidingTackle',
	'interceptions',
	'postioning',
	'gkDiving',
	'gkHanding',
	'gkPostioning',
	'gkReflexes',
	'gkKicking',
	'redCard',
	'yellowCard',
	'leagueData',
	'cupData',
	'championsLeageueData',
	'scoreList',
);");
define('DATA_BASE_CARDS_PRI',"uId"); 


const DATA_BASE_CHAT = 'chat';
const DATA_BASE_CHAT_CHATID = 0;
const DATA_BASE_CHAT_USERID = 1;
const DATA_BASE_CHAT_NICK = 2;
const DATA_BASE_CHAT_CONTENT = 3;
define('DATA_BASE_CHAT_FIELD',"return array(
	'chatId',
	'userId',
	'nick',
	'content',
);");
define('DATA_BASE_CHAT_PRI',"chatId"); 


const DATA_BASE_FRIENDLIST = 'friendlist';
const DATA_BASE_FRIENDLIST_USERID = 0;
const DATA_BASE_FRIENDLIST_FRIENDID = 1;
const DATA_BASE_FRIENDLIST_NICK = 2;
const DATA_BASE_FRIENDLIST_CLUB = 3;
define('DATA_BASE_FRIENDLIST_FIELD',"return array(
	'userId',
	'friendId',
	'nick',
	'club',
);");
define('DATA_BASE_FRIENDLIST_PRI',"userId"); 


const DATA_BASE_FORMATION = 'formation';
const DATA_BASE_FORMATION_USERID = 0;
const DATA_BASE_FORMATION_GK = 1;
const DATA_BASE_FORMATION_RB = 2;
const DATA_BASE_FORMATION_CBR = 3;
const DATA_BASE_FORMATION_CBC = 4;
const DATA_BASE_FORMATION_CBL = 5;
const DATA_BASE_FORMATION_LB = 6;
const DATA_BASE_FORMATION_DMR = 7;
const DATA_BASE_FORMATION_DMC = 8;
const DATA_BASE_FORMATION_DML = 9;
const DATA_BASE_FORMATION_RM = 10;
const DATA_BASE_FORMATION_LM = 11;
const DATA_BASE_FORMATION_CMR = 12;
const DATA_BASE_FORMATION_CMC = 13;
const DATA_BASE_FORMATION_CML = 14;
const DATA_BASE_FORMATION_AMR = 15;
const DATA_BASE_FORMATION_AMC = 16;
const DATA_BASE_FORMATION_AML = 17;
const DATA_BASE_FORMATION_RW = 18;
const DATA_BASE_FORMATION_LW = 19;
const DATA_BASE_FORMATION_RF = 20;
const DATA_BASE_FORMATION_CF = 21;
const DATA_BASE_FORMATION_LF = 22;
const DATA_BASE_FORMATION_S1 = 23;
const DATA_BASE_FORMATION_S2 = 24;
const DATA_BASE_FORMATION_S3 = 25;
const DATA_BASE_FORMATION_S4 = 26;
const DATA_BASE_FORMATION_S5 = 27;
const DATA_BASE_FORMATION_S6 = 28;
const DATA_BASE_FORMATION_S7 = 29;
define('DATA_BASE_FORMATION_FIELD',"return array(
	'userId',
	'GK',
	'RB',
	'CBR',
	'CBC',
	'CBL',
	'LB',
	'DMR',
	'DMC',
	'DML',
	'RM',
	'LM',
	'CMR',
	'CMC',
	'CML',
	'AMR',
	'AMC',
	'AML',
	'RW',
	'LW',
	'RF',
	'CF',
	'LF',
	'S1',
	'S2',
	'S3',
	'S4',
	'S5',
	'S6',
	'S7',
);");
define('DATA_BASE_FORMATION_PRI',"userId"); 


const DATA_BASE_TACTICS = 'tactics';
const DATA_BASE_TACTICS_USERID = 0;
const DATA_BASE_TACTICS_TACTICAL1 = 1;
const DATA_BASE_TACTICS_TACTICAL2 = 2;
const DATA_BASE_TACTICS_TACTICAL3 = 3;
const DATA_BASE_TACTICS_TACTICAL4 = 4;
const DATA_BASE_TACTICS_TACTICAL5 = 5;
const DATA_BASE_TACTICS_TACTICAL6 = 6;
const DATA_BASE_TACTICS_TACTICAL7 = 7;
const DATA_BASE_TACTICS_TACTICAL8 = 8;
define('DATA_BASE_TACTICS_FIELD',"return array(
	'userId',
	'tactical1',
	'tactical2',
	'tactical3',
	'tactical4',
	'tactical5',
	'tactical6',
	'tactical7',
	'tactical8',
);");
define('DATA_BASE_TACTICS_PRI',"userId"); 


const DATA_BASE_FIGHTROOMS = 'fightrooms';
const DATA_BASE_FIGHTROOMS_UID = 0;
const DATA_BASE_FIGHTROOMS_STARTTIME = 1;
const DATA_BASE_FIGHTROOMS_HOMEUSERID = 2;
const DATA_BASE_FIGHTROOMS_AWAYUSERID = 3;
const DATA_BASE_FIGHTROOMS_TOTALHOMESCORE = 4;
const DATA_BASE_FIGHTROOMS_TOTALAWAYSCORE = 5;
const DATA_BASE_FIGHTROOMS_STATUE = 6;
const DATA_BASE_FIGHTROOMS_TYPE = 7;
const DATA_BASE_FIGHTROOMS_PARAM = 8;
const DATA_BASE_FIGHTROOMS_EVENTTIMEARR = 9;
const DATA_BASE_FIGHTROOMS_ISOPERATION = 10;
define('DATA_BASE_FIGHTROOMS_FIELD',"return array(
	'uId',
	'startTime',
	'homeUserId',
	'awayUserId',
	'totalHomeScore',
	'totalAwayScore',
	'statue',
	'type',
	'param',
	'eventTimeArr',
	'isOperation',
);");
define('DATA_BASE_FIGHTROOMS_PRI',"uId"); 


const DATA_BASE_FIGHTDATA = 'fightdata';
const DATA_BASE_FIGHTDATA_UID = 0;
const DATA_BASE_FIGHTDATA_ROOMID = 1;
const DATA_BASE_FIGHTDATA_HOMESCORE = 2;
const DATA_BASE_FIGHTDATA_AWAYSCORE = 3;
const DATA_BASE_FIGHTDATA_EVENTDATE = 4;
const DATA_BASE_FIGHTDATA_EVENTLINE = 5;
const DATA_BASE_FIGHTDATA_EVENTPOINT = 6;
const DATA_BASE_FIGHTDATA_STAGEDATE = 7;
const DATA_BASE_FIGHTDATA_HOMEFORMATION = 8;
const DATA_BASE_FIGHTDATA_AWAYFORMATION = 9;
const DATA_BASE_FIGHTDATA_BALLCONTROL = 10;
const DATA_BASE_FIGHTDATA_SUMMARY = 11;
const DATA_BASE_FIGHTDATA_FIGHTMODE = 12;
const DATA_BASE_FIGHTDATA_ISHOME = 13;
define('DATA_BASE_FIGHTDATA_FIELD',"return array(
	'uId',
	'roomId',
	'homeScore',
	'awayScore',
	'eventDate',
	'eventLine',
	'eventPoint',
	'stageDate',
	'homeFormation',
	'awayFormation',
	'ballControl',
	'summary',
	'fightMode',
	'isHome',
);");
define('DATA_BASE_FIGHTDATA_PRI',"uId"); 


const DATA_BASE_JERSEY = 'jersey';
const DATA_BASE_JERSEY_UID = 0;
const DATA_BASE_JERSEY_USERID = 1;
const DATA_BASE_JERSEY_JERSEYID = 2;
const DATA_BASE_JERSEY_MAINCOLOR = 3;
const DATA_BASE_JERSEY_COLOR = 4;
define('DATA_BASE_JERSEY_FIELD',"return array(
	'uId',
	'userId',
	'jerseyId',
	'mainColor',
	'color',
);");
define('DATA_BASE_JERSEY_PRI',"uId"); 


const DATA_BASE_TEAMSIGN = 'teamsign';
const DATA_BASE_TEAMSIGN_UID = 0;
const DATA_BASE_TEAMSIGN_USERID = 1;
const DATA_BASE_TEAMSIGN_SIGNID = 2;
const DATA_BASE_TEAMSIGN_SIGNTYPE = 3;
const DATA_BASE_TEAMSIGN_MAINCOLOR = 4;
const DATA_BASE_TEAMSIGN_COLOR = 5;
const DATA_BASE_TEAMSIGN_SIGNPATTERN = 6;
const DATA_BASE_TEAMSIGN_PATTERNCOLOR = 7;
define('DATA_BASE_TEAMSIGN_FIELD',"return array(
	'uId',
	'userId',
	'signId',
	'signType',
	'mainColor',
	'color',
	'signPattern',
	'patternColor',
);");
define('DATA_BASE_TEAMSIGN_PRI',"uId"); 


const DATA_BASE_CLUB = 'club';
const DATA_BASE_CLUB_USERID = 0;
const DATA_BASE_CLUB_LEVEL = 1;
const DATA_BASE_CLUB_CREATEDATE = 2;
const DATA_BASE_CLUB_COUNTRY = 3;
const DATA_BASE_CLUB_CITY = 4;
const DATA_BASE_CLUB_STADIUMNAME = 5;
const DATA_BASE_CLUB_STADIUMSEATNUM = 6;
const DATA_BASE_CLUB_NAME = 7;
const DATA_BASE_CLUB_FANS = 8;
const DATA_BASE_CLUB_CLUBNAME = 9;
const DATA_BASE_CLUB_AVEGOAL = 10;
const DATA_BASE_CLUB_AVEFUMBLE = 11;
const DATA_BASE_CLUB_STARPLAYER = 12;
const DATA_BASE_CLUB_BESTSHOOTER = 13;
const DATA_BASE_CLUB_SCORELIST = 14;
const DATA_BASE_CLUB_HOMEJERSEY = 15;
const DATA_BASE_CLUB_AWAYJERSEY = 16;
const DATA_BASE_CLUB_TEAMSIGN = 17;
const DATA_BASE_CLUB_TROPHY1 = 18;
const DATA_BASE_CLUB_TROPHY2 = 19;
const DATA_BASE_CLUB_TROPHY3 = 20;
const DATA_BASE_CLUB_LEAGUENUM = 21;
const DATA_BASE_CLUB_CUPNUM = 22;
const DATA_BASE_CLUB_CHAMPIONLEAGUENUM = 23;
const DATA_BASE_CLUB_LEAGUEGOAL = 24;
const DATA_BASE_CLUB_CUPGOAL = 25;
const DATA_BASE_CLUB_CHAMPIONGOAL = 26;
define('DATA_BASE_CLUB_FIELD',"return array(
	'userId',
	'level',
	'createDate',
	'country',
	'city',
	'stadiumName',
	'stadiumSeatNum',
	'name',
	'fans',
	'clubName',
	'avegoal',
	'avefumble',
	'starPlayer',
	'bestShooter',
	'scoreList',
	'homeJersey',
	'awayJersey',
	'teamSign',
	'trophy1',
	'trophy2',
	'trophy3',
	'leagueNum',
	'cupNum',
	'championLeagueNum',
	'leagueGoal',
	'cupGoal',
	'championGoal',
);");
define('DATA_BASE_CLUB_PRI',"userId"); 


const DATA_BASE_TROPHY = 'trophy';
const DATA_BASE_TROPHY_TROPHYID = 0;
const DATA_BASE_TROPHY_USERID = 1;
const DATA_BASE_TROPHY_RANKING = 2;
const DATA_BASE_TROPHY_GETTIME = 3;
const DATA_BASE_TROPHY_TROPHYTYPE = 4;
const DATA_BASE_TROPHY_LEVEL = 5;
define('DATA_BASE_TROPHY_FIELD',"return array(
	'trophyId',
	'userId',
	'ranking',
	'getTime',
	'trophyType',
	'level',
);");
define('DATA_BASE_TROPHY_PRI',"trophyId"); 


const DATA_BASE_MEMINFO = 'meminfo';
const DATA_BASE_MEMINFO_MEMKEY = 0;
const DATA_BASE_MEMINFO_CARDS = 1;
const DATA_BASE_MEMINFO_CLUB = 2;
const DATA_BASE_MEMINFO_FIGHTDATA = 3;
const DATA_BASE_MEMINFO_FIGHTROOMS = 4;
const DATA_BASE_MEMINFO_FORMATION = 5;
const DATA_BASE_MEMINFO_FRIENDLIST = 6;
const DATA_BASE_MEMINFO_JERSEY = 7;
const DATA_BASE_MEMINFO_PLAYER = 8;
const DATA_BASE_MEMINFO_PROPERTIES = 9;
const DATA_BASE_MEMINFO_TACTICS = 10;
const DATA_BASE_MEMINFO_TEAMSIGN = 11;
const DATA_BASE_MEMINFO_TROPHY = 12;
const DATA_BASE_MEMINFO_LEAGUE = 13;
const DATA_BASE_MEMINFO_LEAGUE_RANK = 14;
const DATA_BASE_MEMINFO_LEAGUE_SCHEDULE = 15;
const DATA_BASE_MEMINFO_LEAGUE_FOOTBALLER_RANK = 16;
define('DATA_BASE_MEMINFO_FIELD',"return array(
	'memkey',
	'cards',
	'club',
	'fightData',
	'fightRooms',
	'formation',
	'friendList',
	'jersey',
	'player',
	'properties',
	'tactics',
	'teamSign',
	'trophy',
	'league',
	'league_rank',
	'league_schedule',
	'league_footballer_rank',
);");
define('DATA_BASE_MEMINFO_PRI',"memkey"); 


const DATA_BASE_CONFIG = 'config';
const DATA_BASE_CONFIG_ID = 0;
const DATA_BASE_CONFIG_SERVERNUM = 1;
const DATA_BASE_CONFIG_PLAYERNUM = 2;
const DATA_BASE_CONFIG_MEMINDEX = 3;
const DATA_BASE_CONFIG_NOWMEMINDEX = 4;
const DATA_BASE_CONFIG_CARDSTATISTICSNUM = 5;
const DATA_BASE_CONFIG_GAMESTATISTICSNUM = 6;
const DATA_BASE_CONFIG_LEAGUENUM = 7;
const DATA_BASE_CONFIG_CARDSDATANUM = 8;
const DATA_BASE_CONFIG_CARDRECOMMENDNUM = 9;
const DATA_BASE_CONFIG_FIGHTDATANUM = 10;
const DATA_BASE_CONFIG_FIGHTROOMSNUM = 11;
const DATA_BASE_CONFIG_JERSEYNUM = 12;
const DATA_BASE_CONFIG_TEAMSIGNNUM = 13;
const DATA_BASE_CONFIG_TROPHYNUM = 14;
define('DATA_BASE_CONFIG_FIELD',"return array(
	'id',
	'serverNum',
	'playerNum',
	'memIndex',
	'nowMemIndex',
	'cardStatisticsNum',
	'gameStatisticsNum',
	'leagueNum',
	'cardsDataNum',
	'cardRecommendNum',
	'fightDataNum',
	'fightRoomsNum',
	'jerseyNum',
	'teamsignNum',
	'trophyNum',
);");
define('DATA_BASE_CONFIG_PRI',"id"); 


const DATA_BASE_CARD_RECOMMEND = 'card_recommend';
const DATA_BASE_CARD_RECOMMEND_UID = 0;
const DATA_BASE_CARD_RECOMMEND_USERID = 1;
const DATA_BASE_CARD_RECOMMEND_CARDATTRIBUTE = 2;
const DATA_BASE_CARD_RECOMMEND_TOKEN = 3;
const DATA_BASE_CARD_RECOMMEND_SHOPINGINDEX = 4;
define('DATA_BASE_CARD_RECOMMEND_FIELD',"return array(
	'uId',
	'userId',
	'cardAttribute',
	'token',
	'shopingIndex',
);");
define('DATA_BASE_CARD_RECOMMEND_PRI',"uId"); 


const DATA_BASE_SCOUT = 'scout';
const DATA_BASE_SCOUT_USERID = 0;
const DATA_BASE_SCOUT_CARDATTRIBUTE = 1;
define('DATA_BASE_SCOUT_FIELD',"return array(
	'userId',
	'cardAttribute',
);");


const DATA_BASE_CARD_STATISTICS = 'card_statistics';
const DATA_BASE_CARD_STATISTICS_UID = 0;
const DATA_BASE_CARD_STATISTICS_CARDUID = 1;
const DATA_BASE_CARD_STATISTICS_ISMVP = 2;
const DATA_BASE_CARD_STATISTICS_GOALNUM = 3;
const DATA_BASE_CARD_STATISTICS_ASSISTS = 4;
const DATA_BASE_CARD_STATISTICS_SCORE = 5;
const DATA_BASE_CARD_STATISTICS_YELLOWCARD = 6;
const DATA_BASE_CARD_STATISTICS_REDCARD = 7;
const DATA_BASE_CARD_STATISTICS_ROOMID = 8;
define('DATA_BASE_CARD_STATISTICS_FIELD',"return array(
	'uId',
	'carduId',
	'ismvp',
	'goalNum',
	'assists',
	'score',
	'yellowCard',
	'redCard',
	'roomId',
);");
define('DATA_BASE_CARD_STATISTICS_PRI',"uId"); 


const DATA_BASE_GAME_STATISTICS = 'game_statistics';
const DATA_BASE_GAME_STATISTICS_UID = 0;
const DATA_BASE_GAME_STATISTICS_ROOMID = 1;
const DATA_BASE_GAME_STATISTICS_GAMETYPE = 2;
const DATA_BASE_GAME_STATISTICS_ISHOME = 3;
const DATA_BASE_GAME_STATISTICS_BALLCONTROL = 4;
const DATA_BASE_GAME_STATISTICS_SHOTNUM = 5;
const DATA_BASE_GAME_STATISTICS_PENALTYSHOT = 6;
const DATA_BASE_GAME_STATISTICS_SHOTSUCCESSRATE = 7;
const DATA_BASE_GAME_STATISTICS_PASSSUCCESSRATE = 8;
const DATA_BASE_GAME_STATISTICS_FREEKICK = 9;
const DATA_BASE_GAME_STATISTICS_CORNER = 10;
const DATA_BASE_GAME_STATISTICS_SAVES = 11;
const DATA_BASE_GAME_STATISTICS_TACKLENUM = 12;
const DATA_BASE_GAME_STATISTICS_FOUL = 13;
const DATA_BASE_GAME_STATISTICS_YELLOWCARD = 14;
const DATA_BASE_GAME_STATISTICS_REDCARD = 15;
define('DATA_BASE_GAME_STATISTICS_FIELD',"return array(
	'uId',
	'roomId',
	'gameType',
	'isHome',
	'ballControl',
	'shotNum',
	'penaltyShot',
	'shotSuccessrate',
	'passSuccessrate',
	'freekick',
	'corner',
	'saves',
	'tackleNum',
	'foul',
	'yellowCard',
	'redCard',
);");
define('DATA_BASE_GAME_STATISTICS_PRI',"uId"); 


const DATA_BASE_LEAGUE = 'league';
const DATA_BASE_LEAGUE_ID = 0;
const DATA_BASE_LEAGUE_LEVEL = 1;
const DATA_BASE_LEAGUE_LEAGUER1 = 2;
const DATA_BASE_LEAGUE_LEAGUER2 = 3;
const DATA_BASE_LEAGUE_LEAGUER3 = 4;
const DATA_BASE_LEAGUE_LEAGUER4 = 5;
const DATA_BASE_LEAGUE_LEAGUER5 = 6;
const DATA_BASE_LEAGUE_LEAGUER6 = 7;
const DATA_BASE_LEAGUE_LEAGUER7 = 8;
const DATA_BASE_LEAGUE_LEAGUER8 = 9;
const DATA_BASE_LEAGUE_LEAGUER9 = 10;
const DATA_BASE_LEAGUE_LEAGUER10 = 11;
const DATA_BASE_LEAGUE_LEAGUER11 = 12;
const DATA_BASE_LEAGUE_LEAGUER12 = 13;
const DATA_BASE_LEAGUE_LEAGUER13 = 14;
const DATA_BASE_LEAGUE_LEAGUER14 = 15;
const DATA_BASE_LEAGUE_REALNUM = 16;
define('DATA_BASE_LEAGUE_FIELD',"return array(
	'id',
	'level',
	'leaguer1',
	'leaguer2',
	'leaguer3',
	'leaguer4',
	'leaguer5',
	'leaguer6',
	'leaguer7',
	'leaguer8',
	'leaguer9',
	'leaguer10',
	'leaguer11',
	'leaguer12',
	'leaguer13',
	'leaguer14',
	'realNum',
);");
define('DATA_BASE_LEAGUE_PRI',"id"); 


const DATA_BASE_LEAGUE_SCHEDULE = 'league_schedule';
const DATA_BASE_LEAGUE_SCHEDULE_LEAGUEID = 0;
const DATA_BASE_LEAGUE_SCHEDULE_ROUND = 1;
const DATA_BASE_LEAGUE_SCHEDULE_NO = 2;
const DATA_BASE_LEAGUE_SCHEDULE_LEAGUER1 = 3;
const DATA_BASE_LEAGUE_SCHEDULE_LEAGUER2 = 4;
const DATA_BASE_LEAGUE_SCHEDULE_STARTTIME = 5;
const DATA_BASE_LEAGUE_SCHEDULE_STATUS = 6;
const DATA_BASE_LEAGUE_SCHEDULE_SCORE1 = 7;
const DATA_BASE_LEAGUE_SCHEDULE_SCORE2 = 8;
const DATA_BASE_LEAGUE_SCHEDULE_ROOMID = 9;
const DATA_BASE_LEAGUE_SCHEDULE_ISLOCKED = 10;
define('DATA_BASE_LEAGUE_SCHEDULE_FIELD',"return array(
	'leagueId',
	'round',
	'no',
	'leaguer1',
	'leaguer2',
	'startTime',
	'status',
	'score1',
	'score2',
	'roomid',
	'islocked',
);");
define('DATA_BASE_LEAGUE_SCHEDULE_PRI',"roomid"); 


const DATA_BASE_LEAGUE_RANK = 'league_rank';
const DATA_BASE_LEAGUE_RANK_UID = 0;
const DATA_BASE_LEAGUE_RANK_LEAGUEID = 1;
const DATA_BASE_LEAGUE_RANK_LEAGUER = 2;
const DATA_BASE_LEAGUE_RANK_LASTRANK = 3;
const DATA_BASE_LEAGUE_RANK_FINISH = 4;
const DATA_BASE_LEAGUE_RANK_SUCC = 5;
const DATA_BASE_LEAGUE_RANK_DRAW = 6;
const DATA_BASE_LEAGUE_RANK_FAIL = 7;
const DATA_BASE_LEAGUE_RANK_GOAL = 8;
const DATA_BASE_LEAGUE_RANK_FUMBLE = 9;
const DATA_BASE_LEAGUE_RANK_INTEGRAL = 10;
const DATA_BASE_LEAGUE_RANK_PERFORMANCE = 11;
define('DATA_BASE_LEAGUE_RANK_FIELD',"return array(
	'uId',
	'leagueId',
	'leaguer',
	'lastRank',
	'finish',
	'succ',
	'draw',
	'fail',
	'goal',
	'fumble',
	'integral',
	'performance',
);");
define('DATA_BASE_LEAGUE_RANK_PRI',"uId"); 


const DATA_BASE_LEAGUE_FOOTBALLER_RANK = 'league_footballer_rank';
const DATA_BASE_LEAGUE_FOOTBALLER_RANK_UID = 0;
const DATA_BASE_LEAGUE_FOOTBALLER_RANK_LEAGUEID = 1;
const DATA_BASE_LEAGUE_FOOTBALLER_RANK_CARDUID = 2;
const DATA_BASE_LEAGUE_FOOTBALLER_RANK_USERID = 3;
const DATA_BASE_LEAGUE_FOOTBALLER_RANK_TYPE = 4;
const DATA_BASE_LEAGUE_FOOTBALLER_RANK_RANKRESULT = 5;
const DATA_BASE_LEAGUE_FOOTBALLER_RANK_SCORE = 6;
const DATA_BASE_LEAGUE_FOOTBALLER_RANK_JOINS = 7;
define('DATA_BASE_LEAGUE_FOOTBALLER_RANK_FIELD',"return array(
	'uId',
	'leagueId',
	'carduId',
	'userId',
	'type',
	'rankResult',
	'score',
	'joins',
);");
define('DATA_BASE_LEAGUE_FOOTBALLER_RANK_PRI',"uId"); 

