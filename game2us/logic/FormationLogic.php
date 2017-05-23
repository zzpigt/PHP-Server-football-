<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_MODEL_PATH."FormationModel.php");
include_once(APP_PROTO_PATH."proto.php");
include_once("CardsLogic.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/3/7
 * Time: 19:00
 */
class FormationLogic
{
    private $_formationModel;
    private $_userId;
    function init($userId)
    {
    	$this->_userId = $userId;
        $this->_formationModel = new FormationModel();
        if(empty($this->_formationModel) || !$this->_formationModel->init($userId))
        {
            return false;
        }
        return true;
    }

    function getFormationInfo($data)
    {
        if(is_array($data))
        {
            $_backInfo = new SC_FormationInfo_ACK();
            $_backInfo->__UserId = $data[DATA_BASE_FORMATION_USERID];
            foreach($data as $key=>$value)
            {
                if(!empty($value) && $key!=DATA_BASE_FORMATION_USERID && is_numeric($value))
                {
                    $_sInfo = new SInfo();
                    $_sInfo->__Type = $key;
                    $_sInfo->__Value = $value;

                    array_push($_backInfo->__FormationInfo, $_sInfo);
                }
            }
            return $_backInfo;
        }
        return null;
    }

    function insertFormation($data)
    {
        if(empty($data))
        {
            return false;
        }

        return $this->_formationModel->insertFormationData($data);
    }

    function saveFormation($data)
    {
        if(is_array($data))
        {
            $_data = $this->getFormationData();
            foreach($_data as $_position => $_uid)
            {
                if(!empty($data[$_position]))
                {
                    $this->setFieldByIndex($_position, $data[$_position]);
                }
                elseif($_position != USER_DATA_FIRST_USERID)
                {
                    if(!empty($_uid))
                    {
                        $this->setFieldByIndex($_position, "NULL");
                    }
                }
            }
            return $this->_formationModel->saveFormationData($this->_formationModel->getFormationData()[0][USER_DATA_CARDS_UID]);
        }

        return false;
    }

    function formatFieldPosition($data)
    {
        $_tempArr = array();
        if(is_array($data))
        {
            foreach($data as $_position)
            {
                $_tempArr[$_position->__Type] = $_position->__Value;
            }
            return $_tempArr;
        }
        return null;
    }

    function setFieldByIndex($field, $value)
    {
        $this->_formationModel->setFieldByIndex($field, $value);
    }
    
    function createUserFormation($footballerCout, $leagueLevel)
    {
    	$formationConfig = XmlConfigMgr::getInstance()->getFormationCreateConfig()->getConfig();
    	if(!$formationConfig || empty($formationConfig))
    		return false;
    	 
    	$weight = 0;
    	foreach ($formationConfig as $v)
    	{
    		$weight += $v["Weight"];
    	}
    	
    	$rand = mt_rand(1, $weight);
    	$formation = $formationConfig[1];
    	foreach ($formationConfig as $v)
    	{
    		if($rand <= $v["Weight"])
    		{
    			$formation = $v;
    			break;
    		}
    		else
    		{
    			$rand -= $v["Weight"];
    		}
    	}
    	 
    	$cardsLogic = new CardsLogic();
    	if(!$cardsLogic->init($this->_userId))
    		return false;
    	 
    	$data = Array();
    	$index = 0;
    	for($i = 1; $i <= $footballerCout; $i++)
    	{
    		if(isset($formation["Position".$i]) && isset($formation["Player".$i]))
    		{
    			$position = $formation["Position".$i];
    			$player = $formation["Player".$i];
    			 
    			if($cardsLogic->createUserCard($player, $leagueLevel, CARD_CREATE_TYPE_LEAGUE))
    			{
    				$data[$position] = $cardsLogic->getModel()->getFieldByIndex(DATA_BASE_CARDS_UID, $index);
    				$index++;
    			}
    				
    		}
    		else if(!isset($formation["Position".$i]) && isset($formation["Player".$i]))
    		{
    			$player = $formation["Player".$i];
    	
    			$cardsLogic->createUserCard($player, $leagueLevel, CARD_CREATE_TYPE_LEAGUE);
    		}
    	}
    	$data[DATA_BASE_FORMATION_USERID] = $this->_userId;
    	return $this->insertFormation($data);
    }

    function initUserFormation()
    {
    	
    	
//         $_cardLogic = new CardsLogic();
//         if(empty($_cardLogic))
//         {
//             return false;
//         }
//         if(!$_cardLogic->init($this->_formationModel->userId()))
//         {
//             return false;
//         }

//         $_cards = $_cardLogic->getAllCards();
//         $this->setFieldByIndex(DATA_BASE_FORMATION_USERID, $this->_formationModel->userId());
//         foreach($_cards as $key => $value)
//         {
//             $this->setFieldByIndex($_cards[$key][DATA_BASE_CARDS_FEILDPOSITION], $_cards[$key][DATA_BASE_CARDS_UID]);
//         }

//         $this->insertFormation($this->_formationModel->getFormationData()[0]);
        return true;
    }

    function getFormationData()
    {
        if(empty($this->_formationModel->getFormationData()))
        {
            return null;
        }
        return $this->_formationModel->getFormationData()[0];
    }


    /*
     * 格式化阵型
     * 数据格式：
     * 1 =>
     *   array (size=1)
     *     0 =>
     *       array (size=2)
     *        0 => int 1
     *        1 => int 1
     * 取得数据：[线][随机位置][0:球员位置1:球员UID]
     * */
    function formatFormation()
    {
        $_fieldPosition = XmlConfigMgr::getInstance()->getFieldPositionConfig();
        $_formationArr = array();

        $_data = $this->getFormationData();
        foreach($_data as $field => $value)
        {
            if($field == DATA_BASE_FORMATION_USERID || empty($value))
            {
                continue;
            }

            $_config = $_fieldPosition->findFieldPositionConfig($field);
            $_line = $_config['Line'];
            if(empty($_formationArr[$_line]))
            {
                $_formationArr[$_line] = array();
            }

            $_info = array();
            $_info[0] = $field;
            $_info[1] = $value;

            array_push($_formationArr[$_line], $_info);
        }

        return $_formationArr;
    }

    /*
     * 取得阵型位置对应线和线上索引
     * 参数:$formation
     * 格式化后的阵型
     * */
    function getFormationIndex($formation)
    {
        $_formationIndexArr = array();
        foreach($formation as $line => $value)
        {
            foreach($value as $position => $cardInfo)
            {
                $_formationIndexArr[$cardInfo[FORMATION_FORMAT_CARD_TYPE]][FORMATION_DATA_LINE] = $line;
                $_formationIndexArr[$cardInfo[FORMATION_FORMAT_CARD_TYPE]][FORMATION_DATA_INDEX] = $position;
            }
        }

        return $_formationIndexArr;
    }

    /**
     * Created by
     * User: Vincent
     * Date: 2017/5/3
     * Time: 16:08
     * Des: 取得UID对应场上位置
     */
    function getFormationUid($formation)
    {
        $_formationArr = array();
        foreach($formation as $position => $uId)
        {
            $_formationArr[$uId] = $position;
        }

        return $_formationArr;
    }

    /*
     * 横向格式化
     * 格式：
     * 1 =>(横向线)
     *   array (size=2)
     *     0 => int 1
     *     1 => int 1
     * 取得数据：[横向线][球员位置]
     * */
    function formatFormationX()
    {
        $_fieldPosition = XmlConfigMgr::getInstance()->getFieldPositionConfig();
        $_formationArr = array();

        $_data = $this->getFormationData();
        foreach($_data as $field => $value)
        {
            if($field == DATA_BASE_FORMATION_USERID || empty($value))
            {
                continue;
            }

            $_config = $_fieldPosition->findFieldPositionConfig($field);
            $_lineOrder = $_config['LineOrder'];
            if(empty($_formationArr[$_lineOrder]))
            {
                $_formationArr[$_lineOrder] = array();
            }


            array_push($_formationArr[$_lineOrder], $value);
        }

        return $_formationArr;
    }

    function getFormationIndexX($formationX)
    {
        $_formationIndexArr = array();
        foreach($formationX as $line => $value)
        {
            foreach($value as $index => $position)
            {
                $_formationIndexArr[$position][FORMATION_DATA_LINE] = $line;
                $_formationIndexArr[$position][FORMATION_DATA_INDEX] = $index;
            }
        }

        return $_formationIndexArr;
    }
}