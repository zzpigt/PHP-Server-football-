<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/22
 * Time: 10:23
 */

/*
 * 是否命中随机概率
 * */
function chanceDetermine($percent)
{
    if(is_numeric($percent))
    {
        $_maxSeed = $percent;
        $_maxSeed *= MAGNIFICATION;
        $_maxSeed = round($_maxSeed);

        $_seed = rand(1, MAGNIFICATION);
        return $_maxSeed >= $_seed;
    }
    return false;
}

/*
 * 是否命中随机概率(多个概率)
 * 参数：
 *  $percentList - 概率数组
 * 返回值：
 *  null- 未命中 如果命中返回对应的索引
 * */
function getChanceDetermineIndex($percentList)
{
    if(!is_array($percentList))
    {
        return null;
    }

    $_lastProbability = 0;
    $_probabilityList = array();
    foreach($percentList as $key => $value)
    {
        $_probabilityList[$key] = $value * MAGNIFICATION + $_lastProbability;
        $_lastProbability = $_probabilityList[$key];
    }

    $_seed = rand(1, MAGNIFICATION);
    foreach($_probabilityList as $key => $value)
    {
        if($value >= $_seed)
        {
            return $key;
        }
    }
    return null;
}

/*
 * 传球成功率
 * 公式：
 *   Ps+(1+X)/(1+L/15)
 * */
function passBallFormula($constant, $attribute, $distance)
{
    $denominator = 1+$distance/15;
    if($denominator <= 0)
    {
        printError($distance, __METHOD__);
        return 0;
    }
    return $constant / 10000 +(1+$attribute)/$denominator;
}

/*
 * 越位概率
 * 公式：
 *   Po/[(1+X)*(1+Y)]
 * */
function offSideFormula($constant, $view, $moves)
{
    $denominator = (1+$view)*(1+$moves);
    if($denominator <= 0)
    {
        printError($view. "|" . $moves, __METHOD__);
        return 0;
    }
    return $constant / 10000 / $denominator;
}

/*
 * 拦截传球概率
 * 公式：
 *   Pi*(1+X)
 * */
function interceptFormula($constant, $attribute)
{
    return $constant / 10000 * (1+$attribute);
}

/*
 * 拦截传球成功率
 * 公式：
 *   Pi*(1+XA)/(1+XB)
 * */
function interceptSuccessFormula($constant, $passBall, $intercept)
{
    $denominator = 1+$intercept;
    if($denominator <= 0)
    {
        printError($intercept, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1+$passBall)/ $denominator;
}

/*
 * 盯防概率
 * 公式：
 *   Pm*(1+XA)/(1+XB)
 * */
function markFormula($constant, $station, $moves)
{
    $denominator = 1+$moves;
    if($denominator <= 0)
    {
        printError($moves, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1+$station)/ $denominator;
}

/*
 * 加速过人成功率
 * 公式：
 *   Pp*(1+XA)/(1+XB)
 * */
function speedFormula($constant, $speedA, $speedB)
{
    $denominator = 1+$speedB;
    if($denominator <= 0)
    {
        printError($speedB, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1+$speedA)/ $denominator;
}

/*
 * 抢断成功率
 * 公式：
 *   Psdt*(1+XA)/(1+XB)
 * */
function stealsFormula($constant, $steals, $dribble)
{
    $denominator = 1+$dribble;
    if($denominator <= 0)
    {
        printError($dribble, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1+$steals)/ $denominator;
}

/*
 * 铲球成功率
 * 公式：
 *   Pslt*(1+XA)/(1+XB)
 * */
function paceFormula($constant, $pace, $dribble)
{
    $denominator = 1+$dribble;
    if($denominator <= 0)
    {
        printError($dribble, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1+$pace)/ $denominator;
}

/*
 * 抢断犯规率
 * 公式：
 *   Pf*(1+XA)
 * */
function stealsFoulFormula($constant, $attribute)
{
    return $constant / 10000 / (1 + $attribute);
}

/*
 * 铲球犯规率
 * 公式：
 *   Pf*(1+XA)
 * */
function tackleFoulFormula($constant, $attribute)
{
    return $constant / 10000 / (1 + $attribute);
}

/*
 * 受伤率
 * 公式：
 *   Pi*(1+XA)
 * */
function injuredFormula($constant, $attribute)
{
    return $constant / 10000 * (1 + $attribute);
}

/*
 * 干扰成功率
 * 公式：
 *   Pi*(1+XA)/(1+XB)
 * */
function interfereFormula($constant, $strongA, $strongB)
{
    $denominator = 1+$strongB;
    if($denominator <= 0)
    {
        printError($strongB, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1+$strongA)/ $denominator;
}

/*
 * 接球成功率
 * 公式：
 *   Pt*(1+X)/(1+L/15)
 * */
function catchBallFormula($constant, $control, $distance)
{
    $denominator = 1+$distance/15;
    if($denominator <= 0)
    {
        printError($distance, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1+$control)/ $denominator;
}

/*
 * 任意球越过人墙概率
 * 公式：
 *   Pf*(1+X)
 * */
function beyondWallFormula($constant, $freeBall)
{
    return $constant / 10000 * (1+$freeBall);
}

/*
 * 射正率
 * 公式：
 *   Pf*(1+X)/(1+L/15)
 * */
function shootJustFormula($constant, $attribute, $distance)
{
    $denominator = 1+$distance/15;
    if($denominator <= 0)
    {
        printError($distance, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1+$attribute)/ $denominator;
}

/*
 * 拦截射门概率
 * 公式：
 *   Pi*(1+X)
 * */
function interceptShotFormula($constant, $attribute)
{
    if($constant <= 0)
    {
        printError($constant, __METHOD__);
        return 0;
    }
    return $constant / 10000 * (1+$attribute);
}

/*
 * 拦截射门成功率
 * 公式：
 *   Pi*(1+XA)/(1+XB)
 * */
function interceptShotSuccessFormula($constant, $arc, $intercept)
{
    $denominator = 1+$intercept;
    if($denominator <= 0)
    {
        printError($intercept, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1+$arc)/ $denominator;
}

/*
 * 扑救成功率
 * 公式：
 *   Pg*(1+XA)*(2L/(15+L))/(1+XB*L/15)
 *   Pg*(1+XA)/(1+XB*L/15)
 * */
function savesFormula($constant, $saves, $arc, $distance)
{
    $denominator = 1+ $arc * $distance/15;
    if($denominator <= 0)
    {
        printError($arc, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1+$saves) * (2 * $distance / (15 + $distance))/ $denominator;
}

/*
 * 脱手概率
 * 公式：
 *   Pi*(1+XA)/(1+XB)
 * */
function getRidFormula($constant, $power, $handType)
{
    $denominator = 1+$handType;
    if($denominator <= 0)
    {
        printError($handType, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1+$power)/ $denominator;
}

/*
 * 计算低平球公式
 * 公式：
 *   min(1-min(max(L/Pl-0.1,0),1)^2,1)
 * */
function getLowBallFormula($constant, $distance)
{
    if($constant <= 0)
    {
        printError($constant, __METHOD__);
        return 0;
    }

    $_value = 1 - min(max($distance / $constant - 0.1, 0), 1);
    return min($_value * $_value, 1);
}

/*
 * 计算单项属性公式
 * 公式：
 *   X/P-Lv/5+20%
 * */
function getSingleAttributeFormula($constant, $attribute, $matchLevel)
{
    if($constant <= 0)
    {
        printError($constant, __METHOD__);
        return 0;
    }

    return $attribute/($constant / MAGNIFICATION) - $matchLevel / 5 + 0.2;
}

/*
 * 计算红牌概率公式
 * 公式：
 *   Py*(1+XA)
 * */
function getRedCardFormula($constant, $attribute)
{
    if($constant <= 0)
    {
        printError($constant, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1 + $attribute);
}

/*
 * 计算黄牌概率公式
 * 公式：
 *   Pr*(1+XA)
 * */
function getYellowCardFormula($constant, $attribute)
{
    if($constant <= 0)
    {
        printError($constant, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1 + $attribute);
}

/*
 * 计算越过人墙概率公式
 * 公式：
 *   Pf*(1+X)*(1-Pw*Bw)
 * */
function getCrossWallFormula($constant, $attribute, $wallConstant)
{
    if($constant <= 0)
    {
        printError($constant, __METHOD__);
        return 0;
    }

    return $constant / 10000 * (1 + $attribute) * (1 - $wallConstant);
}

/**
 * Created by
 * User: Vincent
 * Date: 2017/4/21
 * Time: 17:11
 * Des: 计算推荐球员价格
 */
function countRecommendPrice($abilityValue, $age, $leagueLevel)
{
    if(!is_numeric($abilityValue) || !is_numeric($age) || !is_numeric($leagueLevel))
    {
        return 0;
    }

    $_abilityValue = ceil($abilityValue);
    $_starNum = ceil($_abilityValue / 5) - $leagueLevel + 1;
    $_basePrice = 6;
    $_abilityToken = 1;
    if($_starNum == 5)
    {
        $_basePrice = 11;
        $_abilityToken = 4;
    }
    elseif($_starNum == 6)
    {
        $_basePrice = 39;
        $_abilityToken = 10;
    }

    $_ageToken = 2;
    if($_starNum == 4)
    {
        $_ageToken = 0;
    }
    $_minStarValue = ($_starNum - $leagueLevel) * 5;
    $_totalPrice = $_basePrice + ($_abilityValue - $_minStarValue) * $_abilityToken - ($age - 19) * $_ageToken;
    $_totalPrice = $_totalPrice < $_basePrice ? $_basePrice : $_totalPrice;
    return $_totalPrice;
}

/**
 * Created by
 * User: Vincent
 * Date: 2017/4/24
 * Time: 16:48
 * Des: 计算球员中球员价格
 */
function countScoutPrice($abilityValue, $age, $leagueLevel)
{
    if(!is_numeric($abilityValue) || !is_numeric($age) || !is_numeric($leagueLevel))
    {
        return 0;
    }

    $_minAge = 22;
    $_maxDifferAge = 4;
    $_differAge = $age - $_minAge;
    $_differAge = $_differAge > $_maxDifferAge ? $_maxDifferAge : $_differAge;

    $_maxStarValue = (6 - $leagueLevel) * 5;
    $_differAbility = $_maxStarValue - ceil($abilityValue);
    $_differAbility = $_differAbility > 0 ? $_differAbility : 0;

    $_minPrice = 39;
    $_maxPrice = 69;
    $_totalPrice = $_maxPrice;
    $_totalPrice -= ($_differAge * 5 + $_differAbility * 5);
    $_totalPrice = $_totalPrice < $_minPrice ? $_minPrice : $_totalPrice;
    $_totalPrice = $_totalPrice > $_maxPrice ? $_maxPrice : $_totalPrice;

    if($_totalPrice == 44)
    {
        $_totalPrice = $_minPrice;
    }

    return $_totalPrice;
}