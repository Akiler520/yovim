<?php
/**
 * Source type mode of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-22 12:46:16
 * @author Akiler
 */
class Source_Type extends Yov_Mode{

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

    function getByName($name){
        if(empty($name)){
            return false;
        }

        $info = $this->dbObj->select('name='.$name);

        return $info;
    }

    /**
     * show type in the menu
     *
     * @return array|bool
     */
    function getMenu(){
        $limit = 5;
        $info = $this->dbObj->select('active=1', '', '', $limit);

        return $info;
    }
}