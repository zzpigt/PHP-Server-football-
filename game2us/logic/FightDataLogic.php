<?php
include_once(APP_MODEL_PATH."FightDataModel.php");
include_once(APP_MODEL_PATH."CardStatisticsModel.php");
include_once(APP_MODEL_PATH."GameStatisticsModel.php");
include_once(APP_PROTO_PATH."proto.php");
include_once(APP_BASE_PATH."Formula.php");
include_once(APP_LOGIC_PATH."FormationLogic.php");
include_once("MapsLogic.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/3/18
 * Time: 16:19
 */
define("MAP_ONE_GRID_DISTANCE", 5.5);
define("FIGHT_DELAY_TIME", 5);

define("FIGHT_EVENT_START", "fight_event_start");
define("FIGHT_EVENT_CLEAR", "fight_event_clear");
class FightDataLogic
{
    const MAX_EVENT_POINT = 90;
    const MAX_EVENT_LINE = 3;

    const POSITION_ATTACK_X = 'AttackCoordnateX';
    const POSITION_ATTACK_Y = 'AttackCoordnateY';
    const POSITION_DEFENCE_X = 'DefenceCoordnateX';
    const POSITION_DEFENCE_Y = 'DefenceCoordnateY';

    const CALL_BACK_FUNCTION = 'call_back_function';
    const CALL_BACK_PARAM = 'call_back_param';
    const GAME_TYPE = 'game_type';
    const GAME_BALL_CONTROL = 'game_ball_control';

    const FORMATION_FORMAT_CARD_X = 0;
    const FORMATION_FORMAT_CARD_Y = 1;

    //不需要返回给客户端
    const FIGHT_EVENT_LINE_CONTINUE = 0;
    const FIGHT_EVENT_LINE_DISTANCE = 100;

    const MAX_FORMATION_LINE = 6;//场上最多有几条线

    //公式常量Id
    const CONST_PARA_SHORTPASSING = 1;
    const CONST_PARA_LONGPASSING = 2;
    const CONST_PARA_CROSSING = 3;
    const CONST_PARA_OFFSIDE = 4;
    const CONST_PARA_INTERTRIGGER = 5;
    const CONST_PARA_INTERCEPTION = 6;
    const CONST_PARA_MARKING = 7;
    const CONST_PARA_PACE = 8;
    const CONST_PARA_STANDINGTACKLE = 9;
    const CONST_PARA_SLIDINGTACKLE = 10;
    const CONST_PARA_STDFOUL = 11;
    const CONST_PARA_SLDFOUL = 12;
    const CONST_PARA_YELLOWFOUL = 13;
    const CONST_PARA_REDFOUL = 14;
    const CONST_PARA_INJURED = 15;
    const CONST_PARA_INTERFERE = 16;
    const CONST_PARA_BALLCONTROL = 17;
    const CONST_PARA_FREEKICK = 18;
    const CONST_PARA_FINISHING = 19;
    const CONST_PARA_PLUGGINGTRIGGER = 20;
    const CONST_PARA_PLUGGING = 21;
    const CONST_PARA_GKDIVING = 22;
    const CONST_PARA_GKHANDING = 23;
    const CONST_PARA_BALLSPEED = 24;
    const CONST_PARA_DRIBBLINGSPEED = 25;
    const CONST_PARA_GRAVITATION = 26;
    const CONST_PARA_CAMAREHEIGHT = 27;
    const CONST_PARA_ATTACK = 28;
    const CONST_PARA_FREEKICKTRIGGER = 29;
    const CONST_PARA_PENALTYTRIGGER = 30;
    const CONST_PARA_FASTATTACK = 31;
    const CONST_PARA_EVENTTIME = 32;
    const CONST_PARA_PASSINGPLUS = 36;
    const CONST_PARA_LOWBALL = 58;
    const CONST_PARA_WALL = 71;
    const CONST_PARA_PASSING_LENGTH = 76;
    const CONST_PARA_TOUCHING_LENGTH = 77;
    const CONST_PARA_SHOOTING_LENGTH = 78;

    const EVENT_PROBABILITY_ATTACK_A = 0;
    const EVENT_PROBABILITY_FAST_A = 1;
    const EVENT_PROBABILITY_ATTACK_B = 2;
    const EVENT_PROBABILITY_FAST_B = 3;

    private $_roomData;
    private $_roomId;
    private $_fightDataModel;

    private $_userAId;
    private $_userBId;

    private $_userACard;
    private $_userBCard;

    private $_map;
    //纵向格式化的阵型
    private $_formationA;
    private $_formationB;
    //球员位置对应的线上索引
    private $_formationIndexA;
    private $_formationIndexB;

    //横向格式化的阵型
    private $_formationXA;
    private $_formationXB;
    //球员位置对应的线上索引
    private $_formationIndexXA;
    private $_formationIndexXB;

    //球员位置对应球员UID
    private $_formationDataA;
    private $_formationDataB;

    //球员UID对应球员位置
    private $_formationUidA;
    private $_formationUidB;

    //球员逻辑
    private $_cardLogicA;
    private $_cardLogicB;

    //球员格式化数据
    private $_formatCardA;
    private $_formatCardB;

    //数据统计相关
    private $_ballControlList = array();//主场控球情况（每一个事件点一个控球率）
    private $_gameDataA = array();
    private $_gameDataB = array();

    private $_cardsDataA = array();//主场球员数据统计
    private $_cardsDataB = array();//客场球员数据统计
    //是否是前半场
    private $_isFirstHalf = true;

    private $_eventPointTimeArr;//事件点的时间
    private $_lastEventPointTime;//上一次事件点的时间

    private $_backParam = array();

    private $_fightMode = PVP_MODE_NORMAL;
    

    private function _getFieldPositionArr()
    {
        $_fieldPosition = array();

        $_fieldPosition[USER_DATA_FORMATION_GK] = "PerformanceGK";
        $_fieldPosition[USER_DATA_FORMATION_RB] = "PerformanceRB";
        $_fieldPosition[USER_DATA_FORMATION_CBR] = "PerformanceCBR";
        $_fieldPosition[USER_DATA_FORMATION_CBC] = "PerformanceCBC";
        $_fieldPosition[USER_DATA_FORMATION_CBL] = "PerformanceCBL";
        $_fieldPosition[USER_DATA_FORMATION_LB] = "PerformanceLB";
        $_fieldPosition[USER_DATA_FORMATION_DMR] = "PerformanceDMR";
        $_fieldPosition[USER_DATA_FORMATION_DMC] = "PerformanceDMC";
        $_fieldPosition[USER_DATA_FORMATION_DML] = "PerformanceDML";
        $_fieldPosition[USER_DATA_FORMATION_RM] = "PerformanceRM";
        $_fieldPosition[USER_DATA_FORMATION_LM] = "PerformanceLM";
        $_fieldPosition[USER_DATA_FORMATION_CMR] = "PerformanceCMR";
        $_fieldPosition[USER_DATA_FORMATION_CMC] = "PerformanceCMC";
        $_fieldPosition[USER_DATA_FORMATION_CML] = "PerformanceCML";
        $_fieldPosition[USER_DATA_FORMATION_AMR] = "PerformanceAMR";
        $_fieldPosition[USER_DATA_FORMATION_AMC] = "PerformanceAMC";
        $_fieldPosition[USER_DATA_FORMATION_AML] = "PerformanceAML";
        $_fieldPosition[USER_DATA_FORMATION_RW] = "PerformanceRW";
        $_fieldPosition[USER_DATA_FORMATION_LW] = "PerformanceLW";
        $_fieldPosition[USER_DATA_FORMATION_RF] = "PerformanceRF";
        $_fieldPosition[USER_DATA_FORMATION_CF] = "PerformanceCF";
        $_fieldPosition[USER_DATA_FORMATION_LF] = "PerformanceLF";

        return $_fieldPosition;
    }

    private function _getFightDataStrut($homeScore, $awayScore, $stageDate, $eventPoint, $_result)
    {
        $_fightData = array();

        $_fightData[DATA_BASE_FIGHTDATA_ROOMID] = $this->_roomId;
        $_fightData[DATA_BASE_FIGHTDATA_HOMESCORE] = $homeScore;
        $_fightData[DATA_BASE_FIGHTDATA_AWAYSCORE] = $awayScore;
        $_fightData[DATA_BASE_FIGHTDATA_EVENTDATE] = $_result[FIGHT_RESULT_TIME];
        $_fightData[DATA_BASE_FIGHTDATA_EVENTLINE] = $_result[FIGHT_RESULT_LINE];
        $_fightData[DATA_BASE_FIGHTDATA_STAGEDATE] = $stageDate;
        $_fightData[DATA_BASE_FIGHTDATA_EVENTPOINT] = $eventPoint;
        $_fightData[DATA_BASE_FIGHTDATA_BALLCONTROL] = $_result[FIGHT_RESULT_BALL_CONTROL];
        $_fightData[DATA_BASE_FIGHTDATA_FIGHTMODE] = $this->_fightMode;
        $_fightData[DATA_BASE_FIGHTDATA_ISHOME] = $_result[FIGHT_RESULT_IS_HOME];
        if(!empty($_result[FIGHT_RESULT_SUMMARY]))
        {
            $_fightData[DATA_BASE_FIGHTDATA_SUMMARY] = $_result[FIGHT_RESULT_SUMMARY];
        }
        else
        {
            $_fightData[DATA_BASE_FIGHTDATA_SUMMARY] = '';
        }

        $_formationLogicA = new FormationLogic();
        if(empty($_formationLogicA))
        {
            return $_fightData;
        }
        if(!$_formationLogicA->init($this->_userAId))
        {
            return $_fightData;
        }
        $_fightData[DATA_BASE_FIGHTDATA_HOMEFORMATION] = $_formationLogicA->getFormationInfo($this->_formationDataA);
        $_formationLogicB = new FormationLogic();
        if(empty($_formationLogicB))
        {
            return $_fightData;
        }
        if(!$_formationLogicB->init($this->_userBId))
        {
            return $_fightData;
        }

        $_fightData[DATA_BASE_FIGHTDATA_AWAYFORMATION] = $_formationLogicB->getFormationInfo($this->_formationDataB);
        return $_fightData;
    }

    function initPvpRoom($homeUserId, $room)
    {
        if(empty($room))
        {
            return false;
        }

        $this->_roomData = $room;
        $this->_roomId = $room[DATA_BASE_FIGHTROOMS_UID];

        $this->_eventPointTimeArr = $this->_getDataByField($room, DATA_BASE_FIGHTROOMS_EVENTTIMEARR);
        if(empty($this->_eventPointTimeArr))
        {
            $this->_eventPointTimeArr = array();
        }
        $this->_lastEventPointTime = $this->_getEventPointTime(count($this->_eventPointTimeArr) - 1);
        if(empty($this->_lastEventPointTime))
        {
            $this->_lastEventPointTime = $this->_getDataByField($room, DATA_BASE_FIGHTROOMS_STARTTIME);
        }

        $this->_fightDataModel = new FightDataModel();
        if(empty($this->_fightDataModel) || !$this->_fightDataModel->init($homeUserId, $this->_roomId))
        {
            return false;
        }

        $_userAId = $room[DATA_BASE_FIGHTROOMS_HOMEUSERID];
        $_userBId = $room[DATA_BASE_FIGHTROOMS_AWAYUSERID];

        $this->_userAId = $_userAId;
        $this->_userBId = $_userBId;

//        $this->_map = MapsLogic::getInstance()->getMapInfo();

        $_formationA = new FormationLogic();
        if(empty($_formationA))
        {
            return false;
        }
        if(!$_formationA->init($_userAId))
        {
            return false;
        }
        $this->_formationDataA = $_formationA->getFormationData();
        //纵向格式化阵型
        $this->_formationA = $_formationA->formatFormation();
        $this->_formationUidA = $_formationA->getFormationUid($this->_formationDataA);
        $this->_formationIndexA = $_formationA->getFormationIndex($this->_formationA);
        //横向格式化阵型
        $this->_formationXA = $_formationA->formatFormationX();
        $this->_formationIndexXA = $_formationA->getFormationIndexX($this->_formationXA);

        $_formationB = new FormationLogic();
        if(empty($_formationB))
        {
            return false;
        }
        if(!$_formationB->init($_userBId))
        {
            return false;
        }
        $this->_formationDataB = $_formationB->getFormationData();
        //纵向格式化阵型
        $this->_formationB = $_formationB->formatFormation();
        $this->_formationUidB = $_formationB->getFormationUid($this->_formationDataB);
        $this->_formationIndexB = $_formationB->getFormationIndex($this->_formationB);
        //横向格式化阵型
        $this->_formationXB = $_formationB->formatFormationX();
        $this->_formationIndexXB = $_formationB->getFormationIndexX($this->_formationXB);

        $_cardA = new CardsLogic();
        if(empty($_cardA))
        {
            return false;
        }
        if(!$_cardA->init($_userAId))
        {
            return false;
        }
        $this->_cardLogicA = $_cardA;
        $this->_formatCardA = $_cardA->getFormatCards();
        $this->_userACard = $this->_getFormationCardInfo($this->_formationDataA, $this->_formatCardA);

        $_cardB = new CardsLogic();
        if(empty($_cardB))
        {
            return false;
        }
        if(!$_cardB->init($_userBId))
        {
            return false;
        }
        $this->_cardLogicB = $_cardB;
        $this->_formatCardB = $_cardB->getFormatCards();
        $this->_userBCard = $this->_getFormationCardInfo($this->_formationDataB, $this->_formatCardB);

        $this->_getGlobalData();
        return true;
    }

    private function _setBallControl($value)
    {
        if(!is_numeric($value))
        {
            return;
        }

        array_push($this->_ballControlList, $value);
    }

    private function _setEventPointTime($point, $value)
    {
        if(!is_numeric($value))
        {
            return;
        }

        $this->_eventPointTimeArr[$point] = $value;
        $this->_lastEventPointTime = $value;
    }

    private function _getEventPointTime($point)
    {
        if(!empty($this->_eventPointTimeArr[$point]))
        {
            return $this->_eventPointTimeArr[$point];
        }

        return 0;
    }

    private function _getAverageBallControl()
    {
        $_ballControlList = $this->_ballControlList;
        $_totalBallControl = 0;
        foreach($_ballControlList as $value)
        {
            $_totalBallControl += $value;
        }

        return  round($_totalBallControl / self::MAX_EVENT_POINT);
    }

    private function _initGameData()
    {
        $_gameData = array();
        $_gameData[TOTAL_SHOT_NUM] = 0;
        $_gameData[SHOT_JUST_NUM] = 0;
        $_gameData[TOTAL_GOAL_NUM] = 0;
        $_gameData[TOTAL_PASS_NUM] = 0;
        $_gameData[PASS_SUCCESS_NUM] = 0;
        $_gameData[FREE_KICK_NUM] = 0;
        $_gameData[CORNER_NUM] = 0;
        $_gameData[SAVES_NUM] = 0;
        $_gameData[TACKLE_SUCCESS_NUM] = 0;
        $_gameData[TOTAL_FOUL_NUM] = 0;
        $_gameData[TOTAL_YELLOW_CARD_NUM] = 0;
        $_gameData[TOTAL_RED_CARD_NUM] = 0;
        $_gameData[GAME_DATA_USER_ID] = 0;

        return $_gameData;
    }

    private function _addGameDataByField($isHome, $field)
    {
        $_gameData = null;
        if($isHome)
        {
            $_gameData = &$this->_gameDataA;
        }
        else
        {
            $_gameData = &$this->_gameDataB;
        }
        if(empty($_gameData[$field]))
        {
            $_gameData[$field] = 0;
        }

        $_gameData[$field] += 1;
    }

    private function _subGameDataByField($isHome, $field)
    {
        $_gameData = null;
        if($isHome)
        {
            $_gameData = &$this->_gameDataA;
        }
        else
        {
            $_gameData = &$this->_gameDataB;
        }
        if(empty($_gameData[$field]))
        {
            $_gameData[$field] = 0;
        }
        else
        {
            $_gameData[$field] -= 1;
        }
    }

    private function _gameArrayToStrut($isHome, $gameArray)
    {
        $_gameStrut = new SGameStatisticsInfo();
        if($isHome)
        {
            $_gameStrut->__IsHome = '1';
            $_gameStrut->__UserId = $this->_userAId;
        }
        else
        {
            $_gameStrut->__IsHome = '0';
            $_gameStrut->__UserId = $this->_userBId;
        }

        $_gameStrut->__ShotNum = $gameArray[TOTAL_SHOT_NUM];
        $_gameStrut->__PenaltyShot = $gameArray[SHOT_JUST_NUM];
        if($gameArray[SHOT_JUST_NUM] == 0)
        {
            $_gameStrut->__ShotSuccessRate = 0;
        }
        else
        {
            $_gameStrut->__ShotSuccessRate = $gameArray[TOTAL_GOAL_NUM]/$gameArray[SHOT_JUST_NUM];
        }
        if($gameArray[TOTAL_PASS_NUM] == 0)
        {
            $_gameStrut->__PassSuccessRate = 0;
        }
        else
        {
            $_gameStrut->__PassSuccessRate = $gameArray[PASS_SUCCESS_NUM] / $gameArray[TOTAL_PASS_NUM];
        }
        $_gameStrut->__FreeKick = $gameArray[FREE_KICK_NUM];
        $_gameStrut->__Corner = $gameArray[CORNER_NUM];
        $_gameStrut->__Saves = $gameArray[SAVES_NUM];
        $_gameStrut->__TackleNum = $gameArray[TACKLE_SUCCESS_NUM];
        $_gameStrut->__Foul = $gameArray[TOTAL_FOUL_NUM];
        $_gameStrut->__YellowCard = $gameArray[TOTAL_YELLOW_CARD_NUM];
        $_gameStrut->__RedCard = $gameArray[TOTAL_RED_CARD_NUM];
        $_gameStrut->__TotalGoalNum = $gameArray[TOTAL_GOAL_NUM];

        return $_gameStrut;
    }

    private function _getGameStrutList($roomId, $gameType)
    {
        $_gameStrutList = array();
        $_ballControlA = $this->_getAverageBallControl();

        $_gameDataA = $this->_gameDataA;
        $_gameStrutA = $this->_gameArrayToStrut(true, $_gameDataA);
        $_gameStrutA->__RoomId = $roomId;
        $_gameStrutA->__GameType = $gameType;
        $_gameStrutA->__BallControl = $_ballControlA;
        array_push($_gameStrutList, $_gameStrutA);

        $this->_backParam[HOME_GAME_DATA] = $_gameStrutA;

        $_gameDataB = $this->_gameDataB;
        $_gameStrutB = $this->_gameArrayToStrut(false, $_gameDataB);
        $_gameStrutB->__RoomId = $roomId;
        $_gameStrutB->__GameType = $gameType;
        $_gameStrutB->__BallControl = 100 - $_ballControlA;
        array_push($_gameStrutList, $_gameStrutB);

        $this->_backParam[AWAY_GAME_DATA] = $_gameStrutB;
        return $_gameStrutList;
    }

    private function _addGameStatistics($roomId, $gameType)
    {
        $_gameStatisticsModel = new GameStatisticsModel();
        if(empty($_gameStatisticsModel) || !$_gameStatisticsModel->init())
        {
            return false;
        }

        $_gameStrutList = $this->_getGameStrutList($roomId, $gameType);
        $_data = $_gameStatisticsModel->getGameStatistics($_gameStrutList);
        return $_gameStatisticsModel->addStatisticsData($_data);
    }

    private function _initCardData()
    {
        $_cardData = array();
        $_cardData[IS_MVP] = 0;
        $_cardData[GOAL_NUM] = 0;
        $_cardData[ASSISTS_NUM] = 0;
        $_cardData[YELLOW_CARD_NUM] = 0;
        $_cardData[RED_CARD_NUM] = 0;
        $_cardData[SCORE_NUM] = 0;

        return $_cardData;
    }

    private function _initCardDataList($isHome)
    {
        $_cardDataList = array();
        $_formatCard = null;
        if($isHome)
        {
            $_formatCard = $this->_formatCardA;
        }
        else
        {
            $_formatCard = $this->_formatCardB;
        }

        foreach($_formatCard as $cardUid => $data)
        {
            $_cardDataList[$cardUid] = $this->_initCardData();
        }
        return $_cardDataList;
    }

    private function _addCardsDataByField($isHome, $cardUid, $field)
    {
        $_cardsData = null;
        if($isHome)
        {
            $_cardsData = &$this->_cardsDataA;
        }
        else
        {
            $_cardsData = &$this->_cardsDataB;
        }
        if(empty($_cardsData[$cardUid][$field]))
        {
            $_cardsData[$cardUid][$field] = 0;
        }

        $_cardsData[$cardUid][$field] += 1;
    }

    private function _subCardsDataByField($isHome, $cardUid, $field)
    {
        $_cardsData = null;
        if($isHome)
        {
            $_cardsData = &$this->_cardsDataA;
        }
        else
        {
            $_cardsData = &$this->_cardsDataB;
        }
        if(empty($_cardsData[$cardUid][$field]))
        {
            $_cardsData[$cardUid][$field] = 0;
        }
        else
        {
            $_cardsData[$cardUid][$field] -= 1;
        }
    }

    private function _cardArrayToStrut($cardArray)
    {
        $_cardStrut = new SCardStatisticsInfo();

        $_cardStrut->__IsMVP = $this->_getDataByField($cardArray, IS_MVP);
        $_cardStrut->__GoalNum =$this->_getDataByField($cardArray, GOAL_NUM);
        $_cardStrut->__Assists = $this->_getDataByField($cardArray, ASSISTS_NUM);
        $_cardStrut->__Score = $this->_getDataByField($cardArray, SCORE_NUM);
        $_cardStrut->__YellowCard = $this->_getDataByField($cardArray, YELLOW_CARD_NUM);
        $_cardStrut->__RedCard = $this->_getDataByField($cardArray, RED_CARD_NUM);

        return $_cardStrut;
    }

    private function _getDataByField($cardArray, $field, $defaultValue = 0)
    {
        if(empty($cardArray[$field]))
        {
            return $defaultValue;
        }
        return $cardArray[$field];
    }

    private function _getCardStrutList($roomId)
    {
        $_cardStrutList = array();

        $_cardDataA = $this->_cardsDataA;
        $_cardStrutA = null;
        $_cardStrutAList = array();
        foreach($_cardDataA as $cardUid => $cardData)
        {
            $_cardStrutA = $this->_cardArrayToStrut($cardData);
            $_cardStrutA->__CardUid = $cardUid;
            $_cardStrutA->__RoomId = $roomId;

            array_push($_cardStrutList, $_cardStrutA);
            array_push($_cardStrutAList, $_cardStrutA);
        }

        $this->_backParam[HOME_CARD_DATA] = $_cardStrutAList;

        $_cardDataB = $this->_cardsDataB;
        $_cardStrutB = null;
        $_cardStrutBList = array();
        foreach($_cardDataB as $cardUid => $cardData)
        {
            $_cardStrutB = $this->_cardArrayToStrut($cardData);
            $_cardStrutB->__CardUid = $cardUid;
            $_cardStrutB->__RoomId = $roomId;

            array_push($_cardStrutList, $_cardStrutB);
            array_push($_cardStrutBList, $_cardStrutB);
        }

        $this->_backParam[AWAY_CARD_DATA] = $_cardStrutBList;

        return $_cardStrutList;
    }

    private function _addCardStatistics($roomId)
    {
        $_cardStatisticsModel = new CardStatisticsModel();
        if(empty($_cardStatisticsModel) || !$_cardStatisticsModel->init())
        {
            return false;
        }

        $_cardStrutList = $this->_getCardStrutList($roomId);
        $_data = $_cardStatisticsModel->getCardStatistics($_cardStrutList);
        return $_cardStatisticsModel->addStatisticsData($_data);
    }

    private function _saveGlobalData()
    {
        $this->_fightDataModel->setExtraCacheField(self::GAME_BALL_CONTROL, $this->_ballControlList);

        $this->_fightDataModel->setExtraCacheField(HOME_GAME_DATA, $this->_gameDataA);
        $this->_fightDataModel->setExtraCacheField(AWAY_GAME_DATA, $this->_gameDataB);

        $this->_fightDataModel->setExtraCacheField(HOME_CARD_DATA, $this->_cardsDataA);
        $this->_fightDataModel->setExtraCacheField(AWAY_CARD_DATA, $this->_cardsDataB);
    }

    private function _getGlobalData()
    {
        $this->_gameDataA = $this->_fightDataModel->getExtraCacheField(HOME_GAME_DATA);
        if(empty($this->_gameDataA))
        {
            $this->_gameDataA = $this->_initGameData();
        }
        $this->_gameDataB = $this->_fightDataModel->getExtraCacheField(AWAY_GAME_DATA);
        if(empty($this->_gameDataB))
        {
            $this->_gameDataB = $this->_initGameData();
        }
        $this->_cardsDataA = $this->_fightDataModel->getExtraCacheField(HOME_CARD_DATA);
        if(empty($this->_cardsDataA))
        {
            $this->_cardsDataA = $this->_initCardDataList(true);
        }
        $this->_cardsDataB = $this->_fightDataModel->getExtraCacheField(AWAY_CARD_DATA);
        if(empty($this->_cardsDataB))
        {
            $this->_cardsDataB = $this->_initCardDataList(false);
        }
        $this->_ballControlList = $this->_fightDataModel->getExtraCacheField(self::GAME_BALL_CONTROL);
        if(empty($this->_ballControlList))
        {
            $this->_ballControlList = array();
        }
    }

    private function getCardLogicByIsHome($isHome)
    {
        $_card = $this->_cardLogicA;
        if(!$isHome)
        {
            $_card = $this->_cardLogicB;
        }
        return $_card;
    }

    function getRoomId()
    {
        return $this->_roomId;
    }

    /*
     * 计算场上发挥的属性
     * 参数：
     *  $formation：阵型数据
     *  $cardArr：格式化过后的卡牌信息
     * */
    private function _getFormationCardInfo($formation, $cardArr, $leagueWeak = 25)
    {
         if(is_array($formation))
         {
             $_fieldPositionArr = $this->_getFieldPositionArr();
             $_config = XmlConfigMgr::getInstance()->getPlayerPositionConfig();

             $_newCardArr = array();
             foreach($formation as $fieldPosition => $cardUid)
             {
                 if($fieldPosition >= DATA_BASE_FORMATION_S1)
                 {
                     break;
                 }
                 if($fieldPosition != DATA_BASE_FORMATION_USERID && isset($cardUid) && $cardUid != 'NULL')
                 {
                     $_position1 = $cardArr[$cardUid][USER_DATA_CARDS_POSITION1];
                     if(empty($_position1))
                     {
                         writeLog(LOG_LEVEL_ERROR, $cardUid, "error_card_uid");
                         writeLog(LOG_LEVEL_ERROR, $formation, "error_formation");
                         writeLog(LOG_LEVEL_ERROR, $this->_roomData, "error_room_data");
                     }
                     $_weight = $_config->findPlayerPositionConfig($_position1)[$_fieldPositionArr[$fieldPosition]];//取得位置权重

                     $_newCardArr[$cardUid] = $this->_updateLargeAttribute($cardArr[$cardUid], $_weight/100, $_position1, $leagueWeak);
                 }
             }

             return $_newCardArr;
         }

        return $cardArr;
    }

    private function _updateLargeAttribute($card, $weight, $position1, $leagueWeak)
    {
        $_total = 0;
        $_config = XmlConfigMgr::getInstance()->getPlayerPositionConfig()->findPlayerPositionConfig($position1);
        $card[USER_DATA_CARDS_ATTACK] *= $_config['WeightAttack'] / 100;
        $card[USER_DATA_CARDS_SKILL] *= $_config['WeightSkill'] / 100;
        $card[USER_DATA_CARDS_PHYSICALITY] *= $_config['WeightPhysicality'] / 100;
        $card[USER_DATA_CARDS_MENTALITY] *= $_config['WeightMentality'] / 100;
        $card[USER_DATA_CARDS_DEFENCE] *= $_config['WeightDefence'] / 100;
        $card[USER_DATA_CARDS_GAOLKEEPING] *= $_config['WeightGaolkeeping'] / 100;

        for($i = USER_DATA_CARDS_ATTACK; $i <= USER_DATA_CARDS_GAOLKEEPING; $i++)
        {
            $_total += $card[$i];
        }
        $_total = $_total * round($weight, 2) / $leagueWeak;
        $card[USER_DATA_CARDS_FEILDPOSITION] = $_total;//场上位置字段废弃，暂时作为总评
        return $card;
    }

    private function _getAverageGeneral($cardArr, $formation)
    {
        if(is_array($cardArr))
        {
//            $_count = count($cardArr);
            $_general = 0;
            foreach($cardArr as $key => $card)
            {
                $_position = $formation[$key];
                if($_position >= DATA_BASE_FORMATION_S1)
                {
                    continue;
                }
                if(empty($card[DATA_BASE_CARDS_REDCARD]))
                {
                    $_config = XmlConfigMgr::getInstance()->getFieldPositionConfig();
                    $_const = $_config->findFieldPositionConfig($_position);
                    $_weight = $_const['Controlling']/MAGNIFICATION;

                    $_general += $card[USER_DATA_CARDS_FEILDPOSITION] * $_weight;
                }
            }

            return $_general;
        }
        return 0;
    }

    private function _getHomeCardAttribute($cardUid, $field, $weak)
    {
        if(empty($this->_userACard[$cardUid][$field]) || $weak == 0)
        {
            return 0;
        }

        return $this->_userACard[$cardUid][$field] / $weak;
    }

    private function _getAwayCardAttribute($cardUid, $field, $weak)
    {
        if(empty($this->_userBCard[$cardUid][$field]) || $weak == 0)
        {
            return 0;
        }

        return $this->_userBCard[$cardUid][$field] / $weak;
    }

    private function _getEventConst($id)
    {
        $_xmlData = XmlConfigMgr::getInstance()->getConstDataConfig();
        return $_xmlData->findConstDataConfig($id);
    }

    function addFightData($data)
    {
        if(empty($data))
        {
            return false;
        }

        return $this->_fightDataModel->insertRoomData($data);
    }

    function getPvpFightResult($gameType = null, $funcName = null, $param = null, $isOver = false, &$isUpdate = false, $fightEventPoint = null)
    {
        if(empty($this->_roomData[DATA_BASE_FIGHTROOMS_STATUE]) || $this->_roomData[DATA_BASE_FIGHTROOMS_STATUE] != 1)
        {
            return null;
        }

        $this->_fightDataModel->setExtraCacheField(self::CALL_BACK_FUNCTION, $funcName);
        $this->_fightDataModel->setExtraCacheField(self::CALL_BACK_PARAM, $param);
        $this->_fightDataModel->setExtraCacheField(self::GAME_TYPE, $gameType);
        $_data = $this->_playGame($isUpdate, $isOver, $fightEventPoint);
        return $_data;
    }

    private function _playGame(&$isUpdate = false, $isOver, $fightEventPoint)
    {
        $_eventPoint = $this->getStartEventId();
        writeLog(LOG_LEVEL_NORMAL, $_eventPoint, $this->_roomId."_startPoint");
        if(!empty($_eventPoint))
        {
            $_fightDataArr = array();
            $_sendDataArr = array();
            $_eventLineNum = 0;

            $_homeScore = 0;
            $_awayScore = 0;
            if(!empty($this->_roomData[DATA_BASE_FIGHTROOMS_TOTALHOMESCORE]))
            {
                $_homeScore = $this->_roomData[DATA_BASE_FIGHTROOMS_TOTALHOMESCORE];
            }
            if(!empty($this->_roomData[DATA_BASE_FIGHTROOMS_TOTALAWAYSCORE]))
            {
                $_awayScore = $this->_roomData[DATA_BASE_FIGHTROOMS_TOTALAWAYSCORE];
            }

            $_isResend = empty($fightEventPoint);
            $_isCreateLines = true;

            if($this->_eventIsHappen($_eventPoint))
            {
                //提前几秒计算事件链
//                $_advancePoint = $this->_getAdvancePoint($_eventPoint);
//                if($_advancePoint)
//                {
//                    $_eventPoint = $_advancePoint;
//                }
//                else
                {
                    $_isCreateLines = false;
                }
            }

            if($_isResend && !$isOver)
            {
                $_sendDataArr = $this->_fightDataModel->getHadEventLines($_eventPoint);
                //重发时修改客户端是否计时属性
                if(empty($_sendDataArr))
                {
                    $_sendData = array();
                    $_sendData[DATA_BASE_FIGHTDATA_EVENTPOINT] = $_eventPoint;
                    $_sendData[FIGHT_EVENT_START] = 1;
                    if($_eventPoint == self::MAX_EVENT_POINT)
                    {
                        $_sendData[FIGHT_EVENT_CLEAR] = 1;
                    }
                    array_push($_sendDataArr, $_sendData);
                    $_isCreateLines = true;
                }
                else
                {
                    foreach($_sendDataArr as $key => $value)
                    {
                        $_sendDataArr[$key][FIGHT_EVENT_START] = 1;
                        break;
                    }
                    $_isCreateLines = false;
                }
            }

            $_endPoint = $_eventPoint > self::MAX_EVENT_POINT ? self::MAX_EVENT_POINT : $_eventPoint;
            if($_isCreateLines)
            {
                writeLog(LOG_LEVEL_NORMAL, $_eventPoint, $this->_roomId."START CREATE LINE");
                for($eventPoint = $_eventPoint; $eventPoint <= self::MAX_EVENT_POINT; $eventPoint ++)//事件点
                {
                    $_endPoint = $eventPoint;
                    if($eventPoint > 45)
                    {
                        $this->_isFirstHalf = false;
                    }

                    $_result = $this->Fight();
                    $_stageDate = null;
                    if(!empty($_result))//事件链
                    {
                        $_stageDate = $this->_getStageDate($_result[FIGHT_RESULT_TIME]);
                        $_newFightData = $this->_getFightDataStrut($_homeScore, $_awayScore, $_stageDate, $eventPoint, $_result);

                        array_push($_fightDataArr, $_newFightData);
                        if($eventPoint == $_eventPoint && $_eventPoint > 1)
                        {
                            $_newFightData[FIGHT_EVENT_START] = 1;
                        }
                        if($eventPoint == self::MAX_EVENT_POINT)
                        {
                            $_newFightData[FIGHT_EVENT_CLEAR] = 1;
                        }
                        array_push($_sendDataArr, $_newFightData);

                        $_homeScore += $_result[FIGHT_RESULT_HOME_SCORE];
                        $_awayScore += $_result[FIGHT_RESULT_AWAY_SCORE];

                        $_eventLineNum ++;
                    }
                    else
                    {
                        if($eventPoint == $_eventPoint && $_eventPoint > 1)
                        {
                            $_sendData = array();
                            $_sendData[DATA_BASE_FIGHTDATA_EVENTPOINT] = $eventPoint;
                            $_sendData[FIGHT_EVENT_START] = 1;
                            if($_eventPoint == self::MAX_EVENT_POINT)
                            {
                                $_sendData[FIGHT_EVENT_CLEAR] = 1;
                            }
                            array_push($_sendDataArr, $_sendData);
                        }
                        $_stageDate = $this->_getStageDate(0);
                    }

                    $this->_setEventPointTime($eventPoint, $_stageDate);
                    if($_eventLineNum >= self::MAX_EVENT_LINE && !$isOver)//单次最大事件链
                    {
                        break;
                    }
                }
                writeLog(LOG_LEVEL_NORMAL, $_endPoint, $this->_roomId."_endPoint");
            }

            if($this->_isUpdateRoomData($_endPoint) || $isOver)
            {
                //更新战斗房间数据
                $isUpdate = true;
                $_gameType = $this->_fightDataModel->getExtraCacheField(self::GAME_TYPE);
                $_gameType = !isset($_gameType)?0:$_gameType;

                $this->_addGameStatistics($this->_roomId, $_gameType);
                $this->_addCardStatistics($this->_roomId);

                $_backFunc = $this->_fightDataModel->getExtraCacheField(self::CALL_BACK_FUNCTION);
                if(!empty($_backFunc))
                {
                    $_param = $this->_fightDataModel->getExtraCacheField(self::CALL_BACK_PARAM);
                    $_param["statistics"] = $this->_backParam;
                    call_user_func($_backFunc, $_param);
                }
            }

            $this->_saveGlobalData();
            if(!$_isCreateLines && $_isResend)
            {
                return $this->_getSendData($_sendDataArr, $isUpdate);
            }

            $_isFinish = $_eventPoint >= self::MAX_EVENT_POINT;//特殊使用最初始的时间点判断
            $_addSuccess = $this->addFightData($_fightDataArr);
            if($_isFinish || $_addSuccess)
            {
                $_fightRoomLogic = new FightRoomsLogic();
                if($_fightRoomLogic && $_fightRoomLogic->init($this->_userAId, $this->_userBId))
                {
                    $_index = $_fightRoomLogic->getRoomIndexByRoomId($this->_roomId);
                    $_fightRoomLogic->setScore($_index, $_homeScore, $_awayScore);
                    $_fightRoomLogic->getModel()->setFieldByIndex(DATA_BASE_FIGHTROOMS_EVENTTIMEARR, $this->_eventPointTimeArr, $_index);
                    if($isUpdate)
                    {
                        $_fightRoomLogic->fightEnd($this->_roomId, $_index);
                    }

                    $_fightRoomLogic->updateFightRoomsData($this->_roomId, $_index);
                }
                //FightRoomsModel::updateScore($this->_userAId, $this->_roomId,$this->_gameDataA[TOTAL_GOAL_NUM], $this->_gameDataB[TOTAL_GOAL_NUM]);
                //发送事件链的数据结构
                $_data = $this->_getSendData($_sendDataArr, $isUpdate);
                return $_data;
            }
        }

        return new SC_APPLYGAME_ACK();
    }

    /*
     * 比赛完成后，更新战斗相关数据
     * */
    function updateFightUserData()
    {
        $_userA = PropertiesModelMgr::Instance()->getModelByPrimary($this->_userAId);
        if(empty($_userA))
        {
            return false;
        }

        $_userA->setFieldByIndex(DATA_BASE_PROPERTIES_PVPROOMID, "");
        $_userA->DB_update1();

        $_userB = PropertiesModelMgr::Instance()->getModelByPrimary($this->_userBId);
        if(empty($_userA))
        {
            return false;
        }

        $_userB->setFieldByIndex(DATA_BASE_PROPERTIES_PVPROOMID, "");
        $_userB->DB_update1();
        return true;
    }

    /*
     * 将事件链的结果进行格式化输出
     * */
    private function _getSendData($fightData, $isUpdate = false)
    {
        $_sendData = new SC_APPLYGAME_ACK();
        if(is_array($fightData))
        {
            $_sendData->__FightRoomId = $this->_roomId;
            foreach($fightData as $key => $eventData)
            {
                $_fightData = new FightBackInfo();
                $_fightData->__HomeScore = $this->_getDataByField($eventData, APPLY_GAME_BACK_HOMESCORE);
                $_fightData->__AwayScore = $this->_getDataByField($eventData, APPLY_GAME_BACK_AWAYSCORE);

                $_fightData->__ExecTime = $this->_getDataByField($eventData, APPLY_GAME_BACK_EVENTDATE);
                $_fightData->__EventPoint = $this->_getDataByField($eventData, APPLY_GAME_BACK_EVENTPOINT);

                $_eventLine = new EventLines();
                $_eventLine->__EventLineData = $this->_getDataByField($eventData, APPLY_GAME_BACK_EVENTLINE, null);
                $_eventLine->__IsSelf = $this->_eventLineBelong($this->_getDataByField($eventData, DATA_BASE_FIGHTDATA_ISHOME));
                $_eventLine->__FightMode = $this->_getDataByField($eventData, DATA_BASE_FIGHTDATA_FIGHTMODE);
;
                $_eventLine->__HomeFormation = $this->_getDataByField($eventData, DATA_BASE_FIGHTDATA_HOMEFORMATION, null);
                $_eventLine->__AwayFormation = $this->_getDataByField($eventData, DATA_BASE_FIGHTDATA_AWAYFORMATION, null);
                $_eventLine->__HomeBallControl = $this->_getDataByField($eventData, DATA_BASE_FIGHTDATA_BALLCONTROL);
                $_eventLine->__IsStart = $this->_getDataByField($eventData, FIGHT_EVENT_START);//特殊的处理，提示客户端是否开始计时
                $_eventLine->__IsClear = $this->_getDataByField($eventData, FIGHT_EVENT_CLEAR);//特殊的处理，提示客户端是否结束事件链
                if($isUpdate)
                {
                    $_eventLine->__IsClear = 1;
                }
                $_fightData->__EventLine = $_eventLine;

                array_push($_sendData->__ApplyEventInfo, $_fightData);
            }
        }
        return $_sendData;
    }

    /*
     * 取得事件链执行到的时间戳
     * 参数：
     *  $_eventLineDate：事件链的执行时长
     * des: 每次比执行所以每次加1
     * */
    private function _getStageDate($_eventLineDate)
    {
        return $this->_lastEventPointTime + $_eventLineDate + 1 + FIGHT_DELAY_TIME;
    }

    function getEventTimeArr()
    {
        return $this->_eventPointTimeArr;
    }

    function getStartEventId()
    {
        $startTime = time();
        $_eventTimeArr = $this->_eventPointTimeArr;
        $_maxIndex = count($_eventTimeArr);

        if(empty($_eventTimeArr[$_maxIndex]) || $startTime <= $_eventTimeArr[1])
        {
            return 1;
        }

        for($i = 1; $i < $_maxIndex - 1; $i ++)
        {
            if($startTime >= $_eventTimeArr[$i] &&
                $startTime < $_eventTimeArr[$i+1])
            {
                return $i;
            }
        }

        if($startTime <= $_eventTimeArr[$_maxIndex])
        {
            return $_maxIndex;
        }
        return $_maxIndex + 1;
    }

    private function _eventIsHappen($point)
    {
        if(empty($this->_eventPointTimeArr[$point]))
        {
            writeLog(LOG_LEVEL_NORMAL, $this->_eventPointTimeArr, $this->_roomId."TIME ARR");
            writeLog(LOG_LEVEL_NORMAL, $point, $this->_roomId."POINT");
            return false;
        }
        return true;
    }

    private function _getAdvancePoint($point)
    {
        $_timeArr = $this->_eventPointTimeArr;
        $_maxPoint = count($_timeArr);

        if(empty($_timeArr[$point]))
        {
            return null;
        }
        if($_timeArr[$_maxPoint] - FIGHT_DELAY_TIME >= $_timeArr[$point])
        {
            return $_maxPoint + 1;
        }
        return null;
    }

    private function _isUpdateRoomData($point)
    {
        if($point >= self::MAX_EVENT_POINT && time() >= $this->_lastEventPointTime && $this->_roomData[DATA_BASE_FIGHTROOMS_STATUE] != 2)
        {
            writeLog(LOG_LEVEL_NORMAL, $this->_eventPointTimeArr, "Fight end");
            writeLog(LOG_LEVEL_NORMAL, $this->_lastEventPointTime, "End Point Time");
            writeLog(LOG_LEVEL_NORMAL, time(), "Cur Time");
            return true;
        }
        return false;
    }
//    function getStartEventId()
//    {
//        $_fightData = $this->_fightDataModel->getLastEventLine();
//        if(empty($_fightData))
//        {
//            return 1;
//        }
//
//        $_curTime = time();
//        $_subTime = $_curTime - $_fightData[DATA_BASE_FIGHTDATA_STAGEDATE];
//        if($_subTime >= $_fightData[DATA_BASE_FIGHTDATA_EVENTDATE])
//        {
//            return $_fightData[DATA_BASE_FIGHTDATA_EVENTPOINT]+1;
//        }
//
//        return 0;
//    }

    function Fight()
    {
        $_formationA = $this->_formationA;
        $_formationB = $this->_formationB;
        //var_dump("EventLineStart:");
        $_isHome = false;
        $_eventLineResult = array();
        $_eventTime = 0;

        $_constant = XmlConfigMgr::getInstance()->getConstDataConfig();
        $_probabilityA = $this->_getAttackProbability($_constant->findConstDataConfig(self::CONST_PARA_ATTACK), $this->_userACard, $this->_formationUidA);
        $_fastProbabilityA = $this->_getFastAttackProbability($_constant->findConstDataConfig(self::CONST_PARA_FASTATTACK), $this->_userACard, $this->_formationUidA);

        $_probabilityB = $this->_getAttackProbability($_constant->findConstDataConfig(self::CONST_PARA_ATTACK), $this->_userBCard, $this->_formationUidB);
        $_fastProbabilityB = $this->_getFastAttackProbability($_constant->findConstDataConfig(self::CONST_PARA_FASTATTACK), $this->_userBCard, $this->_formationUidB);
        $_paraAttack = $this->_getCreateEventChance($_probabilityA, $_fastProbabilityA, $_probabilityB, $_fastProbabilityB);

        $_totalProbabilityA = ($_probabilityA + $_fastProbabilityA);
        $_totalProbabilityB = ($_probabilityB + $_fastProbabilityB);
        $_ballControlA = $this->_countBallControl($_totalProbabilityA, $_totalProbabilityB);
        $this->_setBallControl($_ballControlA);
//        $_ballControlB = $this->_countBallControl($_totalProbabilityB, $_totalProbabilityA);
        if(isset($_paraAttack))
        {
            $_result = null;
            $_eventLine = $this->_createEventLine(1);

            $_homeScore = 0;
            $_awayScore = 0;

            $_allChangeCoordinate = [0, 0];//全场移动参数
            //取得对位信息
            if ($_paraAttack <= self::EVENT_PROBABILITY_FAST_A)//判断主场控球
            {
                $_isHome = true;
                $_para = $this->formationPara($this->_formationDataA, $this->_formationDataB);
            }
            else
            {
                $_para = $this->formationPara($this->_formationDataB, $this->_formationDataA);
            }
            //取得格式化阵型
            $_formation = $_formationB;
            if ($_isHome)
            {
                $_formation = $_formationA;
            }

            $_tempEventId = 0;
            foreach ($_eventLine as $eventId)
            {
                //操控下一个事件
                if(empty($_tempEventId))
                {
                    $_eventId = $eventId;
                }
                else
                {
                    $_eventId = $_tempEventId;
                    unset($_tempEventId);
                }

                $_position = null;
                $_result = $this->_chooseEvent($_eventId, $_isHome, $_formation, $_para, $_result, $_allChangeCoordinate);

                $_allChangeCoordinate = $this->_getRandPositionOffSide($_isHome, $_eventId, $_result);//计算带球偏移量
                //防止坐标出界
                if(!empty($_result[PVP_BACK_POSITION_RAND]))
                {
                    $_result[PVP_BACK_POSITION_RAND] = MapsLogic::getInstance()->regionOut($_result[PVP_BACK_POSITION_RAND]);
                }

                $_isContinue = $_result[self::FIGHT_EVENT_LINE_CONTINUE];
                $_backResult = $this->_handleEventResult($_result, $_eventId);
                array_push($_eventLineResult, $_backResult);

                if($this->_isGoal($_eventId, $_result[PVP_BACK_SHOW]))
                {
                    if($_isHome)
                    {
                        $_homeScore += 1;
                    }
                    else
                    {
                        $_awayScore += 1;
                    }
                }

                $_behavior = $_result[PVP_BACK_TYPE];
                //如果带到禁区概率射门
                if($_eventId == FIGHT_EVENT_TYPE_DRIBBLE || $_eventId == FIGHT_EVENT_TYPE_CATCH)
                {
                    $_isPenalty = MapsLogic::getInstance()->isPenalty($_result[PVP_BACK_POSITION_RAND]);
                    if($_isPenalty)
                    {
//                        if($this->_isNowShoot())
                        {
                            $_tempEventId = FIGHT_EVENT_TYPE_SHOOT;
                        }
                    }

                    if($this->_isPenaltyShot($_position, $_behavior))
                    {
                        $this->_fightMode = PVP_MODE_PENALTY;
                        $_tempEventId = FIGHT_EVENT_TYPE_SHOOT;
                        $_isContinue = true;
                    }

                    $_distance = $this->_getShootDistance($_isHome, $this->_isFirstHalf, $_result[PVP_BACK_POSITION_RAND]);
                    if($this->_isFreeKick($_isPenalty, $_distance, $_behavior))
                    {
                        $this->_fightMode = PVP_MODE_FREE_KICK;
                        $_tempEventId = FIGHT_EVENT_TYPE_SHOOT;
                        $_isContinue = true;
                    }
                }

                $_distance = 0;
                if(!empty($_result[self::FIGHT_EVENT_LINE_DISTANCE]))
                {
                    $_distance = $_result[self::FIGHT_EVENT_LINE_DISTANCE];
                }
                $_eventTime += $this->_getEventTime($_behavior, $_distance);
                if(!$_isContinue)
                    break;
            }

            $_eventTime = ceil($_eventTime);

            $_backInfo = array();
            $_backInfo[FIGHT_RESULT_TIME] = $_eventTime;
            $_backInfo[FIGHT_RESULT_HOME_SCORE] = $_homeScore;
            $_backInfo[FIGHT_RESULT_AWAY_SCORE] = $_awayScore;
            $_backInfo[FIGHT_RESULT_LINE] = $_eventLineResult;
            $_backInfo[FIGHT_RESULT_IS_HOME] = intval($_isHome);
            $_backInfo[FIGHT_RESULT_BALL_CONTROL] = $_ballControlA;

            $_backInfo[FIGHT_RESULT_SUMMARY] = $this->_getSummaryInfo($_isHome, $_eventLineResult);

            return $_backInfo;
        }

        return null;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/8
     * Time: 15:23
     * Des: 取得单个事件时长
     */
    private function _getEventTime($behavior, $distance)
    {
        $_time = 0;
        if(!empty($distance))
        {
            $_const = self::CONST_PARA_BALLSPEED;
            if($behavior == FIGHT_EVENT_TYPE_DRIBBLE)
            {
                $_const = self::CONST_PARA_DRIBBLINGSPEED;
            }

            $_ballSpeed = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_const)['Value'];
            $_ballSpeed = intval($_ballSpeed);
            $_ballSpeed = $_ballSpeed / MAGNIFICATION;

            if(empty($_ballSpeed))
            {
                writeLog(LOG_LEVEL_ERROR, $_const, "Error Config".__LINE__);
            }
            $_time = $distance / $_ballSpeed;
        }

        $_const = self::CONST_PARA_EVENTTIME;
        $_eventTime = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_const)['Value'] / MAGNIFICATION;
        if(empty($_eventTime))
        {
            writeLog(LOG_LEVEL_ERROR, $_const, "Error Config".__LINE__);
        }
        $_time += $_eventTime;
        return $_time;
    }

    private function _getSummaryInfo($isHome, $eventLineResult)
    {
        if(!is_array($eventLineResult))
        {
            return null;
        }
        $_eventIndex = count($eventLineResult) - 1;
        $_backResult = $eventLineResult[$_eventIndex];
        if($_backResult instanceof EventData)
        {
            $_summaryArray = array();
            if ($_backResult->__EventResult == PVP_SHOOT_SHOW_GOALOFF ||
                $_backResult->__EventResult == PVP_SHOOT_SHOW_GOAL)
            {
                $_summaryArray[FIGHT_SUMMARY_DATA_EVENT_TYPE] = FIGHT_SUMMARY_TYPE_GOAL;
            }
            elseif ($_backResult->__EventBehavior == PVP_DRIBBLE_SHOW_HURT)
            {
                $_summaryArray[FIGHT_SUMMARY_DATA_EVENT_TYPE] = FIGHT_SUMMARY_TYPE_HURT;
            }
            elseif ($_backResult->__EventBehavior == PVP_DRIBBLE_TYPE_RED)
            {
                $_summaryArray[FIGHT_SUMMARY_DATA_EVENT_TYPE] = FIGHT_SUMMARY_TYPE_RED_CARD;
            }
            elseif ($_backResult->__EventBehavior == PVP_DRIBBLE_TYPE_YELLOWTORED)
            {
                $_summaryArray[FIGHT_SUMMARY_DATA_EVENT_TYPE] = FIGHT_SUMMARY_TYPE_YELLOW_TO_RED;
            }
            elseif ($_backResult->__EventBehavior == PVP_DRIBBLE_TYPE_YELLOW)
            {
                $_summaryArray[FIGHT_SUMMARY_DATA_EVENT_TYPE] = FIGHT_SUMMARY_TYPE_YELLOW_CARD;
            }

            if(isset($_summaryArray[FIGHT_SUMMARY_DATA_EVENT_TYPE]))
            {
                $_formatData = $this->_formationDataA;
                $_summaryArray[FIGHT_SUMMARY_DATA_IS_HOME] = 1;
                if(!$isHome)
                {
                    $_formatData = $this->_formationDataB;
                    $_summaryArray[FIGHT_SUMMARY_DATA_IS_HOME] = 0;
                }

                foreach($_backResult->__EventPositions as $value)
                {
                    if($value->__Type = PVP_BACK_POSITION_ACTIVE)
                    {
                        $_position = $value->__Value;
                        $_summaryArray[FIGHT_SUMMARY_DATA_MAIN_CARDUID] = $_formatData[$_position];
                    }
                    elseif($value->__Type = PVP_BACK_POSITION_PASSIVE)
                    {
                        $_position = $value->__Value;
                        $_summaryArray[FIGHT_SUMMARY_DATA_CARDUID] = $_formatData[$_position];
                    }
                }

                return $_summaryArray;
            }
        }
        return null;
    }

    private function _countBallControl($probabilityA, $probabilityB)
    {
        if(!is_numeric($probabilityA) || !is_numeric($probabilityB) || $probabilityA+$probabilityB == 0)
        {
            return 0;
        }
        return round($probabilityA / ($probabilityA + $probabilityB), 2) * 100;
    }

    private function _passOffSide($isHome, $isFirstHalf)
    {
        $_config = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig(self::CONST_PARA_PASSINGPLUS);
        $_seed = rand(1, MAGNIFICATION);
        if($_config['Value'] >= $_seed)
        {
            if(($isHome && $isFirstHalf) || (!$isHome && !$isFirstHalf))
            {
                return [1, 0];
            }
            else
            {
                return [-1, 0];
            }
        }

        return [0, 0];
    }

    private function _eventLineBelong($isHome)
    {
        if($isHome)
        {
            if($this->_userAId == Registry::getInstance()->get(CLIENT_ID))
            {
                return FIGHT_SELF_IS;
            }
            return FIGHT_SELF_NO;
        }
        else
        {
            if($this->_userBId == Registry::getInstance()->get(CLIENT_ID))
            {
                return FIGHT_SELF_IS;
            }
            return FIGHT_SELF_NO;
        }
    }

    private function _getRandPositionOffSide($isHome, $_eventId, $result)
    {
        $_changeArr = [0, 0];

        $_cardPosition = null;
        if($_eventId != FIGHT_EVENT_TYPE_PASS)//做常量//接球事件前置为传球事件
        {
            $_cardPosition = $result[PVP_BACK_POSITION][PVP_BACK_POSITION_ACTIVE];
        }
        else
        {
            $_cardPosition = $result[PVP_BACK_POSITION][PVP_BACK_POSITION_PASSIVE];
        }

        if($_eventId == FIGHT_EVENT_TYPE_DRIBBLE || $_eventId == FIGHT_EVENT_TYPE_PASS)
        {
            if(!empty($result[PVP_BACK_POSITION_RAND]))
            {
                $_cardCoordinate = $this->_getCardFixedPosition(true, $isHome, $_cardPosition);
                $_changeArr = MapsLogic::getInstance()->coordinateSub($result[PVP_BACK_POSITION_RAND], $_cardCoordinate);
                return $_changeArr;
            }
        }

        return $_changeArr;
    }

    private function _isNowShoot()
    {
        $_seed = rand(1, 10);
        if($_seed <= 7)
        {
            return true;
        }
        return false;
    }

    private function _isGoal($eventId, $eventShow)
    {
        if(empty($eventShow))
        {
            return false;
        }
        if($eventId == FIGHT_EVENT_TYPE_SHOOT)
        {
            if($eventShow == PVP_SHOOT_SHOW_GOAL || $eventShow == PVP_SHOOT_SHOW_GOALOFF)
            {
                return true;
            }
        }

        return false;
    }

    private function _formatValue($value)
    {
        if(empty($value))
        {
            return 0;
        }
        return $value;
    }

    private function _getCreateEventChance($probabilityA, $fastProbabilityA, $probabilityB, $fastProbabilityB)
    {
        $probabilityA = $this->_formatValue($probabilityA);
        $fastProbabilityA = $this->_formatValue($fastProbabilityA);
        $probabilityB = $this->_formatValue($probabilityB);
        $fastProbabilityB = $this->_formatValue($fastProbabilityB);

        $probability = [
            $probabilityA,
            $probabilityA + $fastProbabilityA,
            $probabilityA + $fastProbabilityA + $probabilityB,
            $probabilityA + $fastProbabilityA + $probabilityB + $fastProbabilityB,
        ];
        writeLog(LOG_LEVEL_DEBUG, $probability, $this->_roomId."list");
        $_isCreate = rand(1, MAGNIFICATION);
        writeLog(LOG_LEVEL_DEBUG, $_isCreate, $this->_roomId."isCreate");
        foreach($probability as $key => $value)
        {
            if($value >= $_isCreate)
            {
                return $key;
            }
        }
        return null;
    }

    private function  _getAttackProbability($config, $cardArr, $formation)
    {
        $_general = $this->_getAverageGeneral($cardArr, $formation);
        $_paraAttack = $config['Value'] * $_general;
        return $_paraAttack;
    }

    private function _getFastAttackProbability($config, $cardArr, $formation)
    {
        $_general = $this->_getAverageGeneral($cardArr, $formation);
        $_paraFastAttack = $config['Value'] * $_general;
        return $_paraFastAttack;
    }

//    private function _getCreateEventProbability()
//    {
//        $_constant = XmlConfigMgr::getInstance()->getConstDataConfig();
//        $_general = $this->_getAverageGeneral($this->_userACard) + $this->_getAverageGeneral($this->_userBCard);
//
//        $_paraAttack = $_constant->findConstDataConfig(self::CONST_PARA_ATTACK) * $_general * MAGNIFICATION;
//        $_paraFastAttack = $_constant->findConstDataConfig(self::CONST_PARA_FASTATTACK) * $_general * MAGNIFICATION;
//        return [$_paraAttack, $_paraFastAttack];
//    }

    private function _createEventLine($trigger)
    {
        $_classId = rand(1, 2);//根据表
        $_eventLine = XmlConfigMgr::getInstance()->getEventDataConfig()->findEventTypeByClassId($_classId, $trigger);
//        for($i = 0; $i < 5; $i++)
//        {
//            $_eventId = rand(1, 4);//1:传球2:接球3:带球4:射球
//            array_push($_eventLine, $_eventId);
//        }
//        var_dump($_eventLine);
//        $_eventLine = [1, 2, 3, 4];
        return $_eventLine;
    }

    private function _isSelfControl($paraAttack)
    {
        if($paraAttack <= self::EVENT_PROBABILITY_FAST_A)
        {

        }

        if(!empty(rand(0, 1)))
        {
            return true;
        }
        return false;
    }

    /*
     * 格式化对位信息
     * 参数：
     * formationA:进攻方阵型信息
     * formationB:防守方阵型信息
     * 返回值:
     * 防守方为主的对位信息
     * */
    function formationPara($formationA, $formationB)
    {
        if(empty($formationA) || empty($formationB))
        {
            return null;
        }
        $_paraNum = $this->_getParaCardNum($formationA, $formationB);
        $_paraNum = $this->_sortParaCardNum($_paraNum);

        $_paraArr = array();
        foreach($_paraNum as $position => $paraPosition)
        {
            if(empty($_paraArr[$position]))
            {
                $_paraArr[$position] = array();
            }
            array_push($_paraArr[$position], $paraPosition[rand(1, count($paraPosition))-1]);
        }

        return $_paraArr;
    }

    /*
     * 取得位置对位人数
     * */
    private function _getParaCardNum($formationA, $formationB)
    {
        $_paraCountArr = array();
        $_para = $this->_getPara();

        foreach($formationB as $position => $uid)
        {
            if(!empty($position) && $position != USER_DATA_FORMATION_GK && $position <= USER_DATA_FORMATION_LF)
            {
                $_positionPara = $_para[$position];
                foreach($_positionPara as $para)
                {
                    if(!empty($formationA[$para]))
                    {
                        if(empty($_paraCountArr[$position]))
                        {
                            $_paraCountArr[$position] = array();
                        }
                        array_push($_paraCountArr[$position],$para);
                    }
                }
            }
        }

        return $_paraCountArr;
    }

    /*
     * 取得对位信息
     * */
    private function _getPara()
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
        $_para[USER_DATA_FORMATION_AMC] = [USER_DATA_FORMATION_DML,USER_DATA_FORMATION_DMC,USER_DATA_FORMATION_DMR];
        $_para[USER_DATA_FORMATION_AMR] = [USER_DATA_FORMATION_DML,USER_DATA_FORMATION_DMC];

        $_para[USER_DATA_FORMATION_LM] = [USER_DATA_FORMATION_LM,USER_DATA_FORMATION_CMR];
        $_para[USER_DATA_FORMATION_CML] = [USER_DATA_FORMATION_CMC,USER_DATA_FORMATION_RM,USER_DATA_FORMATION_CMR];
        $_para[USER_DATA_FORMATION_CMC] = [USER_DATA_FORMATION_CML,USER_DATA_FORMATION_CMC, USER_DATA_FORMATION_CMR];
        $_para[USER_DATA_FORMATION_CMR] = [USER_DATA_FORMATION_LM,USER_DATA_FORMATION_CML,USER_DATA_FORMATION_CMC];
        $_para[USER_DATA_FORMATION_RM] = [USER_DATA_FORMATION_LM,USER_DATA_FORMATION_CML];

        return $_para;
    }

    private function _sortParaCardNum($paraArr)
    {
        if(!asort($paraArr))
        {
            printError('asort fail', __METHOD__);
        }
        return $paraArr;
    }

    /*
     * 暂时取得每段结果开始时进攻方的位置
     * 从门将及后卫中选出
     * 参数：
     * $formation:格式化后的阵型
     * */
    private function _getStartPosition($formation)
    {
        $_line = rand(1, 2);//选择门将线或者后卫线
        if(empty($formation[$_line]))
        {
            $_line = 1;
        }
        $_index = rand(1, count($formation[$_line])) - 1;//随机线上球员

        $_backInfo = array();
        $_backInfo[FORMATION_DATA_LINE] = $_line;
        $_backInfo[FORMATION_DATA_INDEX] = $_index;
        return $_backInfo;
    }

    private function _chooseEvent($_eventId, $isAttack, $formation, $para, $result, $offSide)
    {
        $_eventResult = null;
        $_line = null;
        $_index = null;
        if(empty($result))//事件链的第一环
        {
            $_startPosition = $this->_getStartPosition($formation);
            $_line = $_startPosition[FORMATION_DATA_LINE];
            $_index = $_startPosition[FORMATION_DATA_INDEX];
        }
        else
        {
            $_formationIndex = null;
            if($isAttack)
            {
                $_formationIndex = $this->_formationIndexA;
            }
            else
            {
                $_formationIndex = $this->_formationIndexB;
            }
            if(empty($result[PVP_BACK_POSITION][PVP_BACK_POSITION_ACTIVE]))
            {
                return null;
            }

            $_cardPosition = null;
            if($_eventId != FIGHT_EVENT_TYPE_CATCH)//接球事件前置为传球事件
            {
                $_cardPosition = $result[PVP_BACK_POSITION][PVP_BACK_POSITION_ACTIVE];
            }
            else
            {
                $_cardPosition = $result[PVP_BACK_POSITION][PVP_BACK_POSITION_PASSIVE];
            }
            $_line = $_formationIndex[$_cardPosition][FORMATION_DATA_LINE];
            $_index = $_formationIndex[$_cardPosition][FORMATION_DATA_INDEX];
//            var_dump("_passive:".$_passive, "_line:".$_line, "_index:".$_index);
        }

        switch($_eventId)
        {
            case 1://传球
                $_eventResult = $this->passTheBall($isAttack, $formation, $para, $_line, $_index, $offSide);
                break;
            case 2://接球
                if(!isset($result[self::FIGHT_EVENT_LINE_DISTANCE]) || empty($result[PVP_BACK_POSITION_RAND]))
                {
                    return null;
                }
                $_distance = $result[self::FIGHT_EVENT_LINE_DISTANCE];
                $_randPosition = $result[PVP_BACK_POSITION_RAND];
                $_eventResult = $this->getBall($isAttack, $formation, $para, $_line, $_index, $_distance, $_randPosition);
                break;
            case 3://带球
                $_eventResult = $this->dribble($isAttack, $formation, $para, $_line, $_index, $offSide);
                break;
            case 4://射门
                if(empty($result[PVP_BACK_POSITION_RAND]))
                {
                    return null;
                }
                $_position = $result[PVP_BACK_POSITION_RAND];
                $_behavior = $result[PVP_BACK_TYPE];
                $_eventResult = $this->shoot($isAttack, $formation, $para, $_line, $_index, $_position, $_behavior);
                break;
        }
//        var_dump($_eventResult);
        return $_eventResult;
    }

    /*
     * 根据阵型位置取得对应的坐标
     * 参数：
     *  $isAttack：是否是进攻方
     *  $formationPosition：阵型上的位置
     * */
    private function _getCardFixedPosition($isAttack, $isHome, $formationPosition)
    {
        $_positionArr = null;
        if($isAttack)
        {
            $_positionArr = $this->_getAttackFieldPosition($isHome, $formationPosition);
        }
        else
        {
            $_positionArr = $this->_getDefenceFieldPosition($isHome, $formationPosition);
        }

        return $_positionArr;
    }

    /*
     * 取得阵型位置的XML信息
     * */
    private function _getFieldPositionByPosition($isHome, $formationPosition)
    {
        $_config = XmlConfigMgr::getInstance()->getFieldPositionConfig();
        $_position = $_config->findFieldPositionConfig($formationPosition);
        if(!$isHome)
        {
            if(!empty($_position))
            {
                if($this->_isFirstHalf)
                {
                    $_position[self::POSITION_ATTACK_X] = 20 - $_position[self::POSITION_ATTACK_X] + 1;
                    $_position[self::POSITION_ATTACK_Y] = 13 - $_position[self::POSITION_ATTACK_Y] + 1;
                }
            }
        }
        else
        {
            if(!empty($_position))
            {
                if(!$this->_isFirstHalf)
                {
                    $_position[self::POSITION_ATTACK_X] = 20 - $_position[self::POSITION_ATTACK_X] + 1;
                    $_position[self::POSITION_ATTACK_Y] = 13 - $_position[self::POSITION_ATTACK_Y] + 1;
                }
            }
        }

        return $_position;
    }

    private function _getAttackFieldPosition($isHome, $formationPosition)
    {
        $_position = $this->_getFieldPositionByPosition($isHome, $formationPosition);

        if(!empty($_position))
        {
            return [$_position[self::POSITION_ATTACK_X], $_position[self::POSITION_ATTACK_Y]];
        }
        return null;
    }

    private function _getDefenceFieldPosition($isHome, $formationPosition)
    {
        $_position = $this->_getFieldPositionByPosition($isHome, $formationPosition);

        if(!empty($_position))
        {
            return [$_position[self::POSITION_DEFENCE_X], $_position[self::POSITION_DEFENCE_Y]];
        }
        return null;
    }

    private function _handleEventResult($result, $eventId)
    {
//        var_dump($result);
        $_result = new EventData();
        if(empty($result[PVP_BACK_SHOW]) || empty($result[PVP_BACK_TYPE]))
        {
            return $_result;
        }

        $_result->__EventType = $eventId;
        $_result->__EventResult = $result[PVP_BACK_SHOW];
        $_result->__EventBehavior = $result[PVP_BACK_TYPE];

        if(!empty($result[PVP_BACK_POSITION]))
        {
            foreach($result[PVP_BACK_POSITION] as $key => $position)
            {
                $_info = new SInfo();
                $_info->__Type = $key;
                $_info->__Value = $position;
                array_push($_result->__EventPositions, $_info);
//                $_result->__EventPositions[$key] = $_info;
            }
        }

        if(!empty($result[PVP_BACK_POSITION_RAND]))
        {
            $_info = new SInfo();
            $_info->__Type = $result[PVP_BACK_POSITION_RAND][0];
            $_info->__Value = $result[PVP_BACK_POSITION_RAND][1];
            $_result->__EventRegion = $_info;
        }

        return $_result;
    }

    /*
     * 取得格式化阵型的球员位置或者UID
     * */
    private function _getFormatFormationInfo($formation, $line, $index, $field)
    {
        if(empty($formation[$line][$index][$field]))
        {
            printError($formation);
            printError($line."|".$index."|".$field);
            return null;
        }
        return $formation[$line][$index][$field];
    }

    /*
     * 取得对方的索引对应位置阵型
     * */
    private function _getFormation($isHome)
    {
        if(!$isHome)
        {
            return $this->_formationDataA;
        }

        return $this->_formationDataB;
    }

    /***************************************/
    /**********取得事件成功率相关***********/
    /***************************************/
    /*
     * 取得拦截命中
     * 参数：
     *  $isHome：是否是主场
     *  $uId：盯防的卡牌ID
     * */
    private function _isIntercept($isHome, $uId, $constId, $weak = 25)
    {
        $_value = null;
        if($isHome)
        {
            $_value = $this->_getAwayCardAttribute($uId, DATA_BASE_CARDS_MARKING, $weak);
        }
        else
        {
            $_value = $this->_getHomeCardAttribute($uId, DATA_BASE_CARDS_MARKING, $weak);
        }

        $_constId = $constId;
        $_const = $this->_getEventConst($_constId)['Value'];
//        $_const = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_constId)['Value'];
        return chanceDetermine(interceptFormula($_const, $_value));
    }

    /*
     * 取得拦截成功命中
     * 参数：
     *  $isHome：是否是主场
     *  $uIdA：控球方球员Id
     *  $uIdB：防守方球员Id
     *  $passType：传球类型
     * */
    private function _isInterceptSuccess($isHome, $uIdA, $uIdB, $passType, $weakA = 25, $weakB = 25)
    {
        $_passType = null;
        if($passType == PVP_PASS_TYPE_CENTER)
        {
            $_passType = DATA_BASE_CARDS_CROSSING;
        }
        elseif($passType == PVP_PASS_TYPE_LONG)
        {
            $_passType = DATA_BASE_CARDS_LONGPASSING;
        }
        else
        {
            $_passType = DATA_BASE_CARDS_SHORTPASSIG;
        }

        $_passBall = null;
        $_intercept = null;
        if($isHome)
        {
            $_passBall = $this->_getHomeCardAttribute($uIdA, $_passType, $weakA);
            $_intercept = $this->_getAwayCardAttribute($uIdB, DATA_BASE_CARDS_INTERCEPTIONS, $weakB);
        }
        else
        {
            $_intercept = $this->_getHomeCardAttribute($uIdA, DATA_BASE_CARDS_INTERCEPTIONS, $weakA);
            $_passBall = $this->_getAwayCardAttribute($uIdB, $_passType, $weakB);
        }
        $_constId = self::CONST_PARA_INTERCEPTION;
        $_const = $this->_getEventConst($_constId)['Value'];
//        $_const = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_constId)['Value'];
        return chanceDetermine(interceptSuccessFormula($_const, $_passBall, $_intercept));
    }

    /*
     * 取得传球命中
     * 参数：
     *  $isHome：是否是主场
     *  $uId：传球球员Id
     *  $passType：传球类型
     *  $distance：传球距离
     *  $weak：虚弱度（跟联赛等级有关暂无）
     * */
    private function _isPassBall($isHome, $uId, $passType, $distance, $weakA = 25, $weakB = 25)
    {
        $_passType = null;
        $_constType = null;
        if($passType == PVP_PASS_TYPE_CENTER)
        {
            $_passType = DATA_BASE_CARDS_CROSSING;
            $_constType = self::CONST_PARA_CROSSING;
        }
        elseif($passType == PVP_PASS_TYPE_LONG)
        {
            $_passType = DATA_BASE_CARDS_LONGPASSING;
            $_constType = self::CONST_PARA_LONGPASSING;
        }
        else
        {
            $_passType = DATA_BASE_CARDS_SHORTPASSIG;
            $_constType = self::CONST_PARA_SHORTPASSING;
        }

        $_passBall = null;
        if($isHome)
        {
            $_passBall = $this->_getHomeCardAttribute($uId, $_passType, $weakA);
        }
        else
        {
            $_passBall = $this->_getAwayCardAttribute($uId, $_passType, $weakB);
        }

        $_const = $this->_getEventConst($_constType)['Value'];
//        $_const = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_constType)['Value'];
        $_constId = self::CONST_PARA_PASSING_LENGTH;
        $_constPass = $this->_getEventConst($_constId)['Value'];
        return chanceDetermine(passBallFormula($_const, $_passBall, $distance, $_constPass));
    }

    /*
     * 取得干扰命中
     * 参数：
     *  $isHome：是否是主场
     *  $uIdA：控球方球员Id
     *  $uIdB：防守方球员Id
     * */
    private function _isInterfere($isHome, $uIdA, $uIdB, $weakA = 25, $weakB = 25)
    {
        if($isHome)
        {
            $_strongA = $this->_getHomeCardAttribute($uIdA, DATA_BASE_CARDS_STRENGTH, $weakA);
            $_strongB = $this->_getAwayCardAttribute($uIdB, DATA_BASE_CARDS_STRENGTH, $weakB);
        }
        else
        {
            $_strongB = $this->_getAwayCardAttribute($uIdA, DATA_BASE_CARDS_STRENGTH, $weakA);
            $_strongA = $this->_getHomeCardAttribute($uIdB, DATA_BASE_CARDS_STRENGTH, $weakB);
        }

        $_constId = self::CONST_PARA_INTERFERE;
        $_const = $this->_getEventConst($_constId)['Value'];
//        $_const = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_constId)['Value'];
        return chanceDetermine(interfereFormula($_const, $_strongA, $_strongB));
    }

    /*
     * 取得接球命中
     * 参数：
     *  $isHome：是否是主场
     *  $uId：控球方球员Id
     *  $distance：接球距离
     * */
    private function _isCatchBall($isHome, $uId, $distance, $weak = 25)
    {
        $_value = null;
        if($isHome)
        {
            $_value = $this->_getHomeCardAttribute($uId, DATA_BASE_CARDS_BALLCONTROL, $weak);
        }
        else
        {
            $_value = $this->_getAwayCardAttribute($uId, DATA_BASE_CARDS_BALLCONTROL, $weak);
        }

        $_constId = self::CONST_PARA_BALLCONTROL;
        $_const = $this->_getEventConst($_constId)['Value'];
//        $_const = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_constId)['Value'];
        $_constId = self::CONST_PARA_TOUCHING_LENGTH;
        $_constGet = $this->_getEventConst($_constId)['Value'];
        return chanceDetermine(catchBallFormula($_const, $_value, $distance, $_constGet));
    }

    /*
     * 取得抢断命中
     * 参数：
     *  $isHome：是否是主场
     *  $uIdA：控球方球员Id
     *  $uIdB：防守方球员Id
     * */
    private function _isSteals($uIdA, $uIdB, $weakA = 25, $weakB = 25)
    {
        $_standTackle = null;
        $_dribbling = null;

        $_standTackle = $this->_getAwayCardAttribute($uIdB, DATA_BASE_CARDS_STANDINGTACKLE, $weakB);
        $_dribbling = $this->_getHomeCardAttribute($uIdA, DATA_BASE_CARDS_DRIBBLING, $weakA);

        $_constId = self::CONST_PARA_STANDINGTACKLE;
        $_const = $this->_getEventConst($_constId)['Value'];
//        $_const = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_constId)['Value'];
        return chanceDetermine(stealsFormula($_const, $_standTackle, $_dribbling));
    }

    /*
     * 取得受伤命中
     * 参数：
     *  $isHome：是否是主场
     *  $uId：控球方Id
     * */
    private function _isInjured($isHome, $uId, $weak = 25)
    {
        $_value = null;
        if($isHome)
        {
            $_value = $this->_getHomeCardAttribute($uId, DATA_BASE_CARDS_STRENGTH, $weak);
        }
        else
        {
            $_value = $this->_getAwayCardAttribute($uId, DATA_BASE_CARDS_STRENGTH, $weak);
        }

        $_constId = self::CONST_PARA_INJURED;
        $_const = $this->_getEventConst($_constId)['Value'];
//        $_const = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_constId)['Value'];
        return chanceDetermine(injuredFormula($_const, $_value));
    }

    /*
     * 取得抢断犯规命中
     * 参数：
     *  $isHome：是否是主场
     *  $uId：控球方球员Id
     * */
    private function _isStealsFoul($isHome, $uId, $weak = 25)
    {
        $_value = null;
        if($isHome)
        {
            $_value = $this->_getHomeCardAttribute($uId, DATA_BASE_CARDS_STANDINGTACKLE, $weak);
        }
        else
        {
            $_value = $this->_getAwayCardAttribute($uId, DATA_BASE_CARDS_STANDINGTACKLE, $weak);
        }

        $_constId = self::CONST_PARA_STDFOUL;
        $_const = $this->_getEventConst($_constId)['Value'];
//        $_const = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_constId)['Value'];
        return chanceDetermine(stealsFoulFormula($_const, $_value));
    }

    /*
    * 取得射正命中
     * 参数：
     *  $isHome：是否是主场
     *  $uId：控球方球员Id
     *  $shootType：射门类型
     *  $distance：射门距离
    * */
    private function _isShotJust($isHome, $uId, $shootType, $distance, $weak = 25)
    {
        $_shootType = $shootType;
        if($_shootType == PVP_SHOOT_TYPE_PENALTY)
        {
            $_shootType = DATA_BASE_CARDS_FINISHING;
        }
        elseif($_shootType == PVP_SHOOT_TYPE_HEAD)
        {
            $_shootType = DATA_BASE_CARDS_HEADING;
        }
        elseif($_shootType == PVP_SHOOT_TYPE_PENALTY_SHOT)
        {
            $_shootType = DATA_BASE_CARDS_PENALTIES;
        }
        elseif($_shootType == PVP_SHOOT_TYPE_FREE_KICK)
        {
            $_shootType = DATA_BASE_CARDS_FREEKICK;
        }
        else
        {
            $_shootType = DATA_BASE_CARDS_LONGSHOTS;
        }

        $_value = null;
        if($isHome)
        {
            $_value = $this->_getHomeCardAttribute($uId, $_shootType, $weak);
        }
        else
        {
            $_value = $this->_getAwayCardAttribute($uId, $_shootType, $weak);
        }

        $_constId = self::CONST_PARA_FINISHING;
        $_const = $this->_getEventConst($_constId)['Value'];
//        $_const = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_constId)['Value'];
        $_constId = self::CONST_PARA_SHOOTING_LENGTH;
        $_constShoot = $this->_getEventConst($_constId)['Value'];
        return chanceDetermine(shootJustFormula($_const, $_value, $distance, $_constShoot));
    }

    /*
     * 取得脱手命中
     * 参数：
     *  $isHome：是否是主场
     *  $uIdA：射门球员Id
     *  $uIdB：守门球员Id
     * */
    private function _isGetRid($isHome, $uIdA, $uIdB, $weakA = 25, $weakB = 25)
    {
        $_power = null;
        $_handType = null;
        if($isHome)
        {
            $_power = $this->_getHomeCardAttribute($uIdA, DATA_BASE_CARDS_POWER, $weakA);
            $_handType = $this->_getAwayCardAttribute($uIdB, DATA_BASE_CARDS_GKHANDING, $weakB);
        }
        else
        {
            $_handType = $this->_getHomeCardAttribute($uIdA, DATA_BASE_CARDS_GKHANDING, $weakA);
            $_power = $this->_getAwayCardAttribute($uIdB, DATA_BASE_CARDS_POWER, $weakB);
        }

        $_constId = self::CONST_PARA_GKHANDING;
        $_const = $this->_getEventConst($_constId)['Value'];
//        $_const = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_constId)['Value'];
        return chanceDetermine(getRidFormula($_const, $_power, $_handType));
    }

    /*
     * 取得扑救命中
     * 参数：
     *  $isHome：是否是主场
     *  $uIdA：射门球员Id
     *  $uIdB：守门球员Id
     * */
    private function _isSaves($isHome, $uIdA, $uIdB, $distance, $weakA = 25, $weakB = 25)
    {
        $_curve = null;
        $_diving = null;
        if($isHome)
        {
            $_curve = $this->_getHomeCardAttribute($uIdA, DATA_BASE_CARDS_CURVE, $weakA);
            $_diving = $this->_getAwayCardAttribute($uIdB, DATA_BASE_CARDS_GKDIVING, $weakB);
        }
        else
        {
            $_diving = $this->_getHomeCardAttribute($uIdA, DATA_BASE_CARDS_GKDIVING, $weakA);
            $_curve = $this->_getAwayCardAttribute($uIdB, DATA_BASE_CARDS_CURVE, $weakB);
        }

        $_constId = self::CONST_PARA_GKDIVING;
        $_const = $this->_getEventConst($_constId)['Value'];
//        $_const = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_constId)['Value'];
        return chanceDetermine(savesFormula($_const, $_diving, $_curve, $distance));
    }

    /*
     * 取得低平球命中
     * 参数：
     *  $distance：传球距离
     * */
    private function _isLowBall($distance)
    {
        $_constId = self::CONST_PARA_LOWBALL;
        $_const = $this->_getEventConst($_constId)['Value'];

        return chanceDetermine(getLowBallFormula($_const, $distance));
    }

    /*
     * 取得黄牌命中
     * 参数：
     *  $isHome：是否是主场
     *  $uId：盯防的卡牌ID
     * */
    private function _isYellowCard($isHome, $uId, $weak = 25)
    {
        $_value = null;
        if($isHome)
        {
            $_value = $this->_getAwayCardAttribute($uId, DATA_BASE_CARDS_STANDINGTACKLE, $weak);
        }
        else
        {
            $_value = $this->_getHomeCardAttribute($uId, DATA_BASE_CARDS_STANDINGTACKLE, $weak);
        }

        $_percentList = array();

        $_constId = self::CONST_PARA_YELLOWFOUL;
        $_const = $this->_getEventConst($_constId)['Value'];
        $_percentList[$_constId] = getYellowCardFormula($_const, $_value);

        $_constId = self::CONST_PARA_REDFOUL;
        $_const = $this->_getEventConst($_constId)['Value'];
        $_percentList[$_constId] = getRedCardFormula($_const, $_value);


        return getChanceDetermineIndex($_percentList);
    }

    /*
     * 是否越过人墙
     * 参数：
     *  $isHome：是否是主场
     *  $uId：射门的卡牌ID
     *  $haveWall：0- 没有人墙技能 1- 有人墙技能
     * */
    private function _isCrossWall($isHome, $uId, $haveWall, $weak = 25)
    {
        $_value = null;
        if($isHome)
        {
            $_value = $this->_getHomeCardAttribute($uId, DATA_BASE_CARDS_FREEKICK, $weak);
        }
        else
        {
            $_value = $this->_getAwayCardAttribute($uId, DATA_BASE_CARDS_FREEKICK, $weak);
        }

        $_constId = self::CONST_PARA_FREEKICK;
        $_const = $this->_getEventConst($_constId)['Value'];

        $_wallConstId = self::CONST_PARA_WALL;
//        $_const = XmlConfigMgr::getInstance()->getConstDataConfig()->findConstDataConfig($_constId)['Value'];
        return chanceDetermine(getCrossWallFormula($_const, $_value, $_wallConstId * $haveWall));
    }

    /***************************************/
    /***********单个事件流程相关************/
    /***************************************/
    /*
     * 传球流程
     * $formation:格式化过的阵型
     * $para：对位信息
     * $line: 传球球员所在线
     * $index: 传球球员所在位置
     * $back: [传球类型, 位置，表现，敌我]
     * */
    private function passTheBall($isHome, $formation, $para, $line, $index, $offSide)
    {
        $this->_addGameDataByField($isHome, TOTAL_PASS_NUM);
        if(empty($formation[$line]))
        {
            return null;
        }
        //选择阵型不靠后的球员
//        $this->_chooseFrontCard($formation, $_newLine, $_index);//方法内部改变值

        $_result = array();
        $_positionArr = array();
        $_cardPosition = $this->_getFormatFormationInfo($formation, $line, $index, FORMATION_FORMAT_CARD_TYPE);
        $_positionArr[PVP_BACK_POSITION_ACTIVE] = $_cardPosition;

        $_result[self::FIGHT_EVENT_LINE_CONTINUE] = false;
        $_newCardPosition = $this->_chooseCardPosition($isHome, $_cardPosition);

        //判断传球类型
        $_position = $this->_getCardFixedPosition(true, $isHome, $_newCardPosition);//
        $_position = $this->_getCardRandPosition($_position);
//        $_distance = $this->_getCardDistance(true, $isHome, $_cardPosition, $_newCardPosition);//设置为true是因为目前只有进攻方会发生事件
        $_distance = MapsLogic::getInstance()->getPointDistance($this->_getCardFixedPosition(true, $isHome, $_cardPosition), $_position) * MAP_ONE_GRID_DISTANCE;

        if(!empty($_position))
        {
            $_passOffSide = $this->_passOffSide($isHome, $this->_isFirstHalf);//传球概率加一
            $offSide = MapsLogic::getInstance()->coordinateAdd($_passOffSide, $offSide);//更新偏移量
            $_position = MapsLogic::getInstance()->coordinateAdd($_position, $offSide);
            $_result[PVP_BACK_POSITION_RAND] = $_position;
            $_passType = null;
            if($_distance >= 10 && MapsLogic::getInstance()->isPenalty($_position))
            {
                $_result[PVP_BACK_TYPE] = PVP_PASS_TYPE_CENTER;
            }
            elseif($_distance >= 30)
            {
                $_result[PVP_BACK_TYPE] = PVP_PASS_TYPE_LONG;
            }
            else
            {
                $_result[PVP_BACK_TYPE] = PVP_PASS_TYPE_SHORT;
            }
            $_result[self::FIGHT_EVENT_LINE_DISTANCE] = $_distance;

            $_positionArr[PVP_BACK_POSITION_PASSIVE] = $_newCardPosition;
            if(!empty($para[$_newCardPosition]))//有人
            {
                $_cardPositionArr = $para[$_newCardPosition];
                $_selectIndex = rand(0, count($_cardPositionArr)-1);

                $_cardIdB = $this->_getFormation($isHome)[$_cardPositionArr[$_selectIndex]];
                if(!$this->_cardHaveRedCard(!$isHome, $_cardIdB))//该球员有红牌
                {
                    if($this->_isIntercept($isHome, $_cardIdB, self::CONST_PARA_INTERTRIGGER))//是否拦截
                    {
                        $_positionArr[PVP_BACK_POSITION_ENEMY] = $_cardPositionArr[$_selectIndex];
                        $_result[PVP_BACK_POSITION] = $_positionArr;

                        $_cardIdA = $this->_getFormatFormationInfo($formation, $line, $index, FORMATION_FORMAT_CARD_UID);
                        if($this->_isInterceptSuccess($isHome, $_cardIdA, $_cardIdB, $_result[PVP_BACK_TYPE]))//是否拦截成功
                        {
                            $_result[PVP_BACK_SHOW] = PVP_PASS_SHOW_CUT;
                            $_result[PVP_BACK_TYPE] = PVP_PASS_TYPE_NONE;
                            return $_result;
                        }
                    }
                }
            }

            $_result[PVP_BACK_POSITION] = $_positionArr;
            //传球是否成功
            $_cardId = $this->_getFormatFormationInfo($formation, $line, $index, FORMATION_FORMAT_CARD_UID);
            if($this->_isPassBall($isHome, $_cardId, $_result[PVP_BACK_TYPE], $_distance))
            {
//            var_dump("passive:".$_positionArr[PVP_BACK_POSITION_PASSIVE]);
//            var_dump("ACTIVE:".$_positionArr[PVP_BACK_POSITION_ACTIVE]);
//            var_dump("distance:".$_result[self::FIGHT_EVENT_LINE_DISTANCE]);
                $this->_addGameDataByField($isHome, PASS_SUCCESS_NUM);
                $_result[PVP_BACK_SHOW] = PVP_PASS_SHOW_SUCCESS;
                $_result[self::FIGHT_EVENT_LINE_CONTINUE] = true;
                return $_result;
            }

            $_result[PVP_BACK_SHOW] = PVP_PASS_SHOW_OUT;
        }

        return $_result;
    }

    private function _chooseCardPosition($isHome, $fieldPosition)
    {
        $_fieldPositionArr = XmlConfigMgr::getInstance()->getFieldDistanceConfig()->getFormatFieldDistance();
        //取得对应阵型位置对应UID数据
        $_formationData = null;
        if($isHome)
        {
            $_formationData = $this->_formationDataA;
        }
        else
        {
            $_formationData = $this->_formationDataB;
        }
        $_fieldPosition = $this->_formatPassBallDistance($_fieldPositionArr[$fieldPosition], $_formationData);
        $_distance = MapsLogic::getInstance()->getPassBallDistance($_fieldPosition);

        //将不为空的位置装入数组（可能一个都没）
        $_cardArr = array();
        foreach($_fieldPositionArr[$fieldPosition][$_distance] as $key => $_fieldPosition)
        {
            if(!empty($_formationData[$_fieldPosition]))//判断该位置是否有人
            {
                array_push($_cardArr, $_fieldPosition);
            }
        }

        $_cardsNum = count($_cardArr);
        $_seed = rand(0, $_cardsNum - 1);
        return $_cardArr[$_seed];
    }

    /*
     *取得可以传球的位置
     * */
    private function _formatPassBallDistance($_distanceArr, $formationData)
    {
        $_fieldPositionArr = array();
        if(is_array($_distanceArr) && is_array($formationData))
        {
            foreach($_distanceArr as $key => $fieldPositions)
            {
                foreach($fieldPositions as $fieldPosition)
                {
                    if(!empty($formationData[$fieldPosition]))
                    {
                        if(!isset($_fieldPositionArr[$key]))
                        {
                            $_fieldPositionArr[$key] = array();
                        }
                        array_push($_fieldPositionArr[$key], $fieldPosition);
                    }
                }
            }
        }

        return $_fieldPositionArr;
    }

    private function _getCardRandPosition($position)
    {
        if(empty($position))
        {
            return null;
        }

        $_seed = rand(-1, 1);
        $position[0] += $_seed;

        $_seed = rand(-1, 1);
        $position[1] += $_seed;

        return $position;
    }

    //射门相关
    /*
     * [射球类型,球员，表现]
     * */
    private function shoot($isHome, $formation, $para, $line, $index, $position, $behavior)
    {
        $this->_addGameDataByField($isHome, TOTAL_SHOT_NUM);
        $_result = array();
        $_positionArr = array();

        $_cardPosition = $this->_getFormatFormationInfo($formation, $line, $index, FORMATION_FORMAT_CARD_TYPE);
        $_cardIdA = $this->_getFormatFormationInfo($formation, $line, $index, FORMATION_FORMAT_CARD_UID);

        $_positionArr[PVP_BACK_POSITION_ACTIVE] = $_cardPosition;
        $_result[PVP_BACK_POSITION] = $_positionArr;
        $_result[self::FIGHT_EVENT_LINE_CONTINUE] = false;

        $_position = $position;
        if($this->_fightMode == PVP_MODE_PENALTY)//点球
        {
            $_result[PVP_BACK_TYPE] = PVP_SHOOT_TYPE_PENALTY_SHOT;
            $_cardIdA = $this->_getPenaltyShotCard($isHome, DATA_BASE_CARDS_PENALTIES);

            $_positionArr[PVP_BACK_POSITION_ACTIVE] = $this->_getCardPositionByUid($isHome, $_cardIdA);
            $_result[PVP_BACK_POSITION] = $_positionArr;
        }
        elseif($this->_fightMode == PVP_MODE_FREE_KICK)//任意球
        {
            $this->_addGameDataByField($isHome, FREE_KICK_NUM);
            $_result[PVP_BACK_TYPE] = PVP_SHOOT_TYPE_FREE_KICK;
            $_cardIdA = $this->_getPenaltyShotCard($isHome, DATA_BASE_CARDS_FREEKICK);

            $_positionArr[PVP_BACK_POSITION_ACTIVE] = $this->_getCardPositionByUid($isHome, $_cardIdA);
            $_result[PVP_BACK_POSITION] = $_positionArr;

            if(!$this->_isCrossWall($isHome, $_cardIdA, 0))
            {
                $_result[PVP_BACK_SHOW] = PVP_SHOOT_SHOW_WALL;
                return $_result;
            }
        }
        else
        {
            //判断射球类型
            if(MapsLogic::getInstance()->isPenalty($_position))
            {
                if($behavior == PVP_CATCH_TYPE_HEIGHT)
                {
                    $_result[PVP_BACK_TYPE] = PVP_SHOOT_TYPE_HEAD;
                }
                else
                {
                    $_result[PVP_BACK_TYPE] = PVP_SHOOT_TYPE_PENALTY;
                }
            }
            else
            {
                $_result[PVP_BACK_TYPE] = PVP_SHOOT_TYPE_LONG;
            }

            if(!empty($para[$_cardPosition]))//是否有守方球员
            {
                $_cardPositionArr = $para[$_cardPosition];
                $_selectIndex = rand(0, count($_cardPositionArr)-1);

                $_cardIdB = $this->_getFormation($isHome)[$_cardPositionArr[$_selectIndex]];
                if(!$this->_cardHaveRedCard($isHome, $_cardIdB))//该球员有红牌
                {
                    if($this->_isIntercept($isHome, $this->_getFormation($isHome)[$_cardPositionArr[$_selectIndex]], self::CONST_PARA_PLUGGINGTRIGGER))//是否拦截
                    {
                        $_positionArr[PVP_BACK_POSITION_ENEMY] = $_cardPositionArr[$_selectIndex];
                        $_result[PVP_BACK_POSITION] = $_positionArr;

                        $_cardIdA = $this->_getFormatFormationInfo($formation, $line, $index, FORMATION_FORMAT_CARD_UID);
//                    $_cardIdB = $this->_getFormation($isHome)[$_card];
                        if($this->_isInterceptSuccess($isHome, $_cardIdA, $_cardIdB, $_result[PVP_BACK_TYPE]))//是否拦截成功
                        {
                            $_result[PVP_BACK_SHOW] = PVP_SHOOT_SHOW_FOOT;
                            return $_result;
                        }
                    }
                }
            }
        }

        $_distance = $this->_getShootDistance($isHome, $this->_isFirstHalf,$_position);
        $_result[self::FIGHT_EVENT_LINE_DISTANCE] = $_distance;
        if($this->_isShotJust($isHome, $_cardIdA,$_result[PVP_BACK_TYPE], $_distance))//是否射正
        {
            $this->_addGameDataByField($isHome, SHOT_JUST_NUM);
            $_cardIdB = $this->_getFormation($isHome)[DATA_BASE_FORMATION_GK];
            if($this->_isSaves($isHome, $_cardIdA, $_cardIdB, $_distance))//是否扑救成功
            {
                $this->_addGameDataByField(!$isHome, SAVES_NUM);
                if($this->_isGetRid($isHome, $_cardIdA, $_cardIdB))//是否脱手
                {
                    $_result[PVP_BACK_SHOW] = PVP_SHOOT_SHOW_GOALOFF;
                    $this->_addGameDataByField($isHome, TOTAL_GOAL_NUM);
                    $this->_addCardsDataByField($isHome, $_cardIdA, GOAL_NUM);
                }
                else
                {
                    $_result[PVP_BACK_SHOW] = PVP_SHOOT_SHOW_GET;
                }
            }
            else
            {
                $_result[PVP_BACK_SHOW] = PVP_SHOOT_SHOW_GOAL;
                $this->_addGameDataByField($isHome, TOTAL_GOAL_NUM);
                $this->_addCardsDataByField($isHome, $_cardIdA,GOAL_NUM);
            }
        }
        else
        {
            $_result[PVP_BACK_SHOW] = PVP_SHOOT_SHOW_FLY;
        }
        return $_result;
    }

    /*
     * 取得射门的距离
     * 参数：
     *  $isHome：是否是主场
     *  $position：射门坐标
     * */
    private function _getShootDistance($isHome, $isFirstHalf, $position)
    {
        $_position = [0, 0];
        //两边球门坐标固定
        if(($isHome && $isFirstHalf) || (!$isHome && !$isFirstHalf))
        {
            $_position = [21, 7];
        }
        else
        {
            $_position = [0, 7];
        }

        return MapsLogic::getInstance()->getPointDistance($_position, $position) * MAP_ONE_GRID_DISTANCE;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/3
     * Time: 14:51
     * Des: 是否是点球
     */
    private function _isPenaltyShot($position, $eventResultType)
    {
        if(MapsLogic::getInstance()->isPenalty($position))
        {
            if($eventResultType == PVP_DRIBBLE_TYPE_RULE || $eventResultType == PVP_DRIBBLE_TYPE_RED ||
            $eventResultType == PVP_DRIBBLE_TYPE_YELLOW || $eventResultType == PVP_DRIBBLE_TYPE_YELLOWTORED)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/4
     * Time: 13:48
     * Des: 是否是任意球
     */
    private function _isFreeKick($isPenalty, $distance, $eventResultType)
    {
        if(!$isPenalty && $distance <= 40)
        {
            if($eventResultType == PVP_DRIBBLE_TYPE_RULE || $eventResultType == PVP_DRIBBLE_TYPE_RED ||
                $eventResultType == PVP_DRIBBLE_TYPE_YELLOW || $eventResultType == PVP_DRIBBLE_TYPE_YELLOWTORED)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/3
     * Time: 17:00
     * Des: 根据UID取得卡牌位置
     */
    private function _getCardPositionByUid($isHome, $uId)
    {
        if($isHome)
        {
            return $this->_formationUidA[$uId];
        }
        else
        {
            return $this->_formationUidB[$uId];
        }
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/3
     * Time: 15:08
     * Des: 取得点球卡牌
     */
    private function _getPenaltyShotCard($isHome, $field)
    {
        $_card = null;
        $_formation = null;
        if($isHome)
        {
            $_card = $this->_formatCardA;
            $_formation = $this->_formationUidA;
        }
        else
        {
            $_card = $this->_formatCardB;
            $_formation = $this->_formationUidB;
        }
        $_maxAttribute = 0;
        $_cardUid = 0;
        foreach($_card as $uId => $data)
        {
            if(!empty($_formation[$uId]))
            {
                if($_formation[$uId] >= DATA_BASE_FORMATION_S1)
                {
                    continue;
                }
            }
            if(!empty($data[$field]))
            {
                if($data[$field] > $_maxAttribute)
                {
                    $_maxAttribute = $data[$field];
                    $_cardUid = $uId;
                }
            }
        }

        return $_cardUid;
    }

    /*
     * 接球
     * */
    private function getBall($isHome, $formation, $para, $line, $index, $passDistance, $randPosition)
    {
        $_result = array();
        $_positionArr = array();

        $_cardPosition = $this->_getFormatFormationInfo($formation, $line, $index, FORMATION_FORMAT_CARD_TYPE);
        $_positionArr[PVP_BACK_POSITION_ACTIVE] = $_cardPosition;
        $_result[PVP_BACK_POSITION] = $_positionArr;
        $_result[self::FIGHT_EVENT_LINE_CONTINUE] = false;
        $_result[PVP_BACK_POSITION_RAND] = $randPosition;

        if(!empty($para[$_cardPosition]))//是否有对方球员
        {
            $_cardPositionArr = $para[$_cardPosition];
            $_selectIndex = rand(0, count($_cardPositionArr)-1);

            $_cardIdB = $this->_getFormation($isHome)[$_cardPositionArr[$_selectIndex]];
            if(!$this->_cardHaveRedCard($isHome, $_cardIdB))//该球员有红牌
            {
                $_positionArr[PVP_BACK_POSITION_ENEMY] = $_cardPositionArr[$_selectIndex];
                $_result[PVP_BACK_POSITION] = $_positionArr;

                $_cardIdA = $this->_getFormatFormationInfo($formation, $line, $index, FORMATION_FORMAT_CARD_UID);
//                $_cardIdB = $this->_getFormation($isHome)[$_card];
                if($this->_isInterfere($isHome, $_cardIdA, $_cardIdB))//是否干扰成功
                {
                    $_result[PVP_BACK_SHOW] = PVP_CATCH_SHOW_CUT;
                    $_result[PVP_BACK_TYPE] = PVP_CATCH_TYPE_LOW;

                    return $_result;
                }
            }
        }

        if($this->_isLowBall($passDistance))
        {
            $_result[PVP_BACK_TYPE] = PVP_CATCH_TYPE_HEIGHT;
        }
        else
        {
            $_result[PVP_BACK_TYPE] = PVP_CATCH_TYPE_LOW;
        }

        $_cardId = $this->_getFormatFormationInfo($formation, $line, $index, FORMATION_FORMAT_CARD_UID);
        if($this->_isCatchBall($isHome, $_cardId, $passDistance))//是否接球成功
        {
            $_result[PVP_BACK_SHOW] = PVP_CATCH_SHOW_GET;
            $_result[self::FIGHT_EVENT_LINE_CONTINUE] = true;
        }
        else
        {
            if($this->_isCenter($_positionArr[PVP_BACK_POSITION_ACTIVE]))//是否是中场球员
            {
                $_result[PVP_BACK_SHOW] = PVP_CATCH_SHOW_LOSE;
                $_result[self::FIGHT_EVENT_LINE_CONTINUE] = true;
            }
            else
            {
                $_result[PVP_BACK_SHOW] = PVP_CATCH_SHOW_OUT;
            }
        }
//        var_dump("getBallType:".$_result[PVP_BACK_TYPE]);
//        var_dump($_result);
        return $_result;
    }

    private function _isCenter($field)
    {
        return false;
    }

    //控球
    /*
     * [带球表现, 球员, 带球类型, 区域]
     * */
    private function dribble($isHome, $formation, $para, $line, $index, $offSide)
    {
        $_result = array();
        $_positionArr = array();

        $_cardPosition = $this->_getFormatFormationInfo($formation, $line, $index, FORMATION_FORMAT_CARD_TYPE);
        $_positionArr[PVP_BACK_POSITION_ACTIVE] = $_cardPosition;
        $_result[self::FIGHT_EVENT_LINE_CONTINUE] = false;
        $_result[self::FIGHT_EVENT_LINE_DISTANCE] = MAP_ONE_GRID_DISTANCE;

        $_region = MapsLogic::getInstance()->getRandRegion($isHome, $this->_isFirstHalf, $this->_getCardFixedPosition(true, $isHome,$_cardPosition));
        $_region = MapsLogic::getInstance()->coordinateAdd($_region, $offSide);
        $_result[PVP_BACK_POSITION_RAND] = $_region;
        $_result[PVP_BACK_POSITION] = $_positionArr;

        if(!empty($para[$_cardPosition]))//是否有对方球员
        {
            $_cardPositionArr = $para[$_cardPosition];
            $_selectIndex = rand(0, count($_cardPositionArr) - 1);

            $_cardIdB = $this->_getFormation($isHome)[$_cardPositionArr[$_selectIndex]];
            if(!$this->_cardHaveRedCard($isHome, $_cardIdB))//该球员有红牌
            {
                $_positionArr[PVP_BACK_POSITION_ENEMY] = $_cardPositionArr[$_selectIndex];
                $_result[PVP_BACK_POSITION] = $_positionArr;

                $_cardIdA = $this->_getFormatFormationInfo($formation, $line, $index, FORMATION_FORMAT_CARD_UID);

                if($this->_isSteals($_cardIdA, $_cardIdB))//抢断是否成功
                {
                    $this->_addGameDataByField(!$isHome, TACKLE_SUCCESS_NUM);
                    $_result[PVP_BACK_SHOW] = PVP_DRIBBLE_SHOW_CUT;
                    $_result[PVP_BACK_TYPE] = PVP_DRIBBLE_TYPE_NONE;
                    return $_result;
                }
                else
                {
                    $_result[PVP_BACK_TYPE] = PVP_DRIBBLE_TYPE_NONE;
                    if($this->_isStealsFoul(!$isHome, $_cardIdB))//是否犯规
                    {
                        $_index = $this->_isYellowCard(!$isHome, $_cardIdB);
                        if(empty($_index))
                        {
                            $_result[PVP_BACK_TYPE] = PVP_DRIBBLE_TYPE_RULE;
                            $this->_addGameDataByField($isHome, TOTAL_FOUL_NUM);
                        }
                        elseif($_index == self::CONST_PARA_REDFOUL)
                        {
                            if($this->_updateCard(!$isHome, $_cardIdB, DATA_BASE_CARDS_REDCARD,1))
                            {
                                $_result[PVP_BACK_TYPE] = PVP_DRIBBLE_TYPE_RED;
                                $this->_addGameDataByField($isHome, TOTAL_RED_CARD_NUM);
                            }
                        }
                        else
                        {
                            if($this->_cardHaveYellowCard(!$isHome, $_cardIdB))
                            {
                                if($this->_updateCard(!$isHome, $_cardIdB, DATA_BASE_CARDS_REDCARD,1))
                                {
                                    $_result[PVP_BACK_TYPE] = PVP_DRIBBLE_TYPE_YELLOWTORED;
                                    $this->_addGameDataByField($isHome, TOTAL_RED_CARD_NUM);
                                    $this->_addCardsDataByField($isHome, $_cardIdB, RED_CARD_NUM);
                                    //需要减一张黄牌(单场两张黄牌变为一张红牌)
                                    $this->_subGameDataByField($isHome, TOTAL_YELLOW_CARD_NUM);
                                    $this->_subCardsDataByField($isHome, $_cardIdB, YELLOW_CARD_NUM);
                                }
                            }
                            else
                            {
                                if($this->_updateCard(!$isHome, $_cardIdB, DATA_BASE_CARDS_YELLOWCARD,1))
                                {
                                    $_result[PVP_BACK_TYPE] = PVP_DRIBBLE_TYPE_YELLOW;
                                    $this->_addGameDataByField($isHome, TOTAL_YELLOW_CARD_NUM);
                                    $this->_addCardsDataByField($isHome, $_cardIdB, YELLOW_CARD_NUM);
                                }
                            }
                        }
                        $_result[self::FIGHT_EVENT_LINE_CONTINUE] = true;
                    }
                    if($this->_isInjured($isHome, $_cardIdA))//是否受伤
                    {
                        $_result[PVP_BACK_SHOW] = PVP_DRIBBLE_SHOW_HURT;
                    }
                    else
                    {
                        if(empty($_result[PVP_BACK_TYPE]))
                        {
                            $_result[PVP_BACK_TYPE] = PVP_DRIBBLE_TYPE_CROSS;
                        }
                        $_result[PVP_BACK_SHOW] = PVP_DRIBBLE_SHOW_ARRIVE;
                        $_result[self::FIGHT_EVENT_LINE_CONTINUE] = true;
                    }

                    return $_result;
                }
            }
        }

        $_result[PVP_BACK_TYPE] = PVP_DRIBBLE_TYPE_NONE;
        $_result[PVP_BACK_SHOW] = PVP_DRIBBLE_SHOW_ARRIVE;
        $_result[self::FIGHT_EVENT_LINE_CONTINUE] = true;

        return $_result;
    }

    private function _getFormatCardByIsHome($isHome)
    {
        if($isHome)
        {
            return $this->_formatCardA;
        }
        return $this->_formatCardB;
    }

    private function _updateFormatCardData($isHome, $cardId, $field, $value)
    {
        $_formatCardList = &$this->_formatCardA;
        if(!$isHome)
        {
            $_formatCardList = &$this->_formatCardB;
        }
        if(!isset($_formatCardList[$cardId][$field]))
        {
            return false;
        }
        $_formatCardList[$cardId][$field] = $value;
        return true;
    }

    private function _updateCard($isHome, $cardId, $field, $value)
    {
        $_cardLogic = $this->getCardLogicByIsHome($isHome);
        $_index = $_cardLogic->getCardIndexById($cardId);
        if(empty($_index))
        {
            return false;
        }
        $_cardLogic->setFieldByIndex($field, $value, $_index);

        if(!$this->_updateFormatCardData($isHome, $cardId, $field, $value))
        {
            return false;
        }

        return $_cardLogic->saveCardData($cardId, $_index);
    }

    private function _cardHaveRedCard($isHome, $cardId)
    {
        $_formatCardList = $this->_getFormatCardByIsHome($isHome);
        if(empty($_formatCardList[$cardId]))
        {
            return false;
        }

        if(empty($_formatCardList[$cardId][DATA_BASE_CARDS_REDCARD]))
        {
            return false;
        }
        return true;
    }

    private function _cardHaveYellowCard($isHome, $cardId)
    {
        $_formatCardList = $this->_getFormatCardByIsHome($isHome);
        if(empty($_formatCardList[$cardId]))
        {
            return false;
        }

        if(empty($_formatCardList[$cardId][DATA_BASE_CARDS_YELLOWCARD]))
        {
            return false;
        }
        return true;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/3
     * Time: 14:25
     * Des: 点球
     */
    private function penalty($isHome, $formation, $para, $line, $index, $offSide)
    {

    }
}