<?php
include_once(getcwd()."/MyConstant.php");
include_once(APP_MODEL_PATH."TrophyModel.php");
include_once(APP_PROTO_PATH."proto.php");
/**
 * Created by PhpStorm.
 * User: Vincent
 * Date: 2017/4/5
 * Time: 11:36
 */
class TrophyLogic
{
    private function _getTrophyStrut($userId, $level, $ranking, $trophyType)
    {
        $_data = array();

        $_data[DATA_BASE_TROPHY_USERID] = $userId;
        $_data[DATA_BASE_TROPHY_GETTIME] = time();
        $_data[DATA_BASE_TROPHY_TROPHYTYPE] = $trophyType;
        $_data[DATA_BASE_TROPHY_RANKING] = $ranking;
        $_data[DATA_BASE_TROPHY_LEVEL] = $level;

        return $_data;
    }

    /**
     * @param $level
     * @param $ranking
     * @param $trophyType
     * @return bool
     *
     */

    function addTrophy($userId, $level, $ranking, $trophyType)
    {
        $_trophy = $this->_getTrophyStrut($userId, $level, $ranking, $trophyType);
        return TrophyModelMgr::Instance()->addSingleData($_trophy);
    }

    /**
     * @param $userId
     * @return SC_GETTROPHYLIST_ACK
     */

    function getTrophyList($userId)
    {
        $_backInfo = new SC_GETTROPHYLIST_ACK();
        $_trophyModelList = TrophyModelMgr::Instance()->getModelList(TROPHY_MODEL_DEFAULT, array($userId));
        if(empty($_trophyModelList))
        {
            return $_backInfo;
        }

        if(is_array($_trophyModelList))
        {
            foreach($_trophyModelList as $index => $trophyModel)
            {
                $_trophy = new Trophy();
                $_trophy->__Index = $index;

                $_trophyData = null;
                if($trophyModel instanceof TrophyModel)
                {
                    $_trophyData = $trophyModel->data();
                }
                foreach($_trophyData as $field => $value)
                {
                    if($field == CLUB_TROPHY_ID)
                    {
                        $_trophy->__TrophyId = $trophyModel->getFieldByIndex($field);
                        continue;
                    }
                    if($field != CLUB_TROPHY_USERID)
                    {
                        $_sInfo = new SInfo();
                        $_sInfo->__Type = $field;
                        $_sInfo->__Value = $trophyModel->getFieldByIndex($field);

                        array_push($_trophy->__TrophyData, $_sInfo);
                    }
                }
                array_push($_backInfo->__TrophyList, $_trophy);
            }
        }

        return $_backInfo;
    }
}