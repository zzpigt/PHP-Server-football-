<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/4
 * Time: 10:57
 */
class Registry
{
    private $_objects = array();
    private static $_instance;

    function set($name, $object)
    {
        $this->_objects[$name] = $object;
    }

    function get($name)
    {
        if(empty($this->_objects[$name]))
            return null;
        return $this->_objects[$name];
    }

    static public function getInstance()
    {
        if (!self::$_instance instanceof self) {//instanceof 判断$_instance是否是self（本class类）变量
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}