<?php
/**
 * Friend link mode of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-11-30 22:58:16
 * @author Akiler
 */
class Friend_Link extends Yov_Mode{

    /**
     * current name of data table
     * @var null
     */
    public $tableName;

    /**
     * object of class
     * @var object
     */
    private static $_instance;

    function init(){
        $this->tableName = strtolower(__CLASS__);
    }

    static function getInstance()
    {
        if(!isset(self::$_instance)) {
            self::$_instance = new self();
        }

        self::$_instance->setTableName(strtolower(__CLASS__));

        return self::$_instance;
    }

}