<?php
/**
 * Register of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-11-22 12:46:16
 * @author Akiler
 */
class Yov_Register extends ArrayObject
{
    /**
     * instance of current class
     *
     * @var object
     */
    private static $_instance = null;

    /**
     * get instance of current class
     *
     * single model
     *
     * @return object
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * set an element into Register table
     *
     * @param string $key : key
     * @param mixed $value : value
     *
     * @return void
     */
    public static function set($key, $value)
    {
        self::getInstance()->offsetSet($key, $value);
    }

    /**
     * get an element from register table
     *
     * @param string $key key
     *
     * @return mixed
     */
    public static function get($key)
    {
        $instance = self::getInstance();

        if (!$instance->offsetExists($key)) {
            return null;
        }
        return $instance->offsetGet($key);
    }

    /**
     * check if an element is exist by key
     *
     * @param string $key key
     *
     * @return boolean
     */
    public static function isRegistered($key)
    {
        return self::getInstance()->offsetExists($key);
    }

    /**
     * delete an element from register table by key
     *
     * @param string $key key
     *
     * @return void
     */
    public static function remove($key)
    {
        self::getInstance()->offsetUnset($key);
    }
}
