<?php
/**
 * Log mode of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-12-02 12:46:16
 * @author Akiler
 */
class Log extends Yov_Mode{

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

    public function add($status, $info){
        $loginInfo = User::getInstance()->getLoginInfo();
        $remoteAddr = $_SERVER['REMOTE_ADDR'];

        $data_log = array(
            'controller'    => Yov_Router::getInstance()->getController(),
            'action'        => Yov_Router::getInstance()->getAction(),
            'id_user'       => $loginInfo['id'],
            'ip'            => ($remoteAddr == '::1' || $remoteAddr == '127.0.0.1') ? 'On Server' : $remoteAddr,
            'status'        => $status,
            'info'          => $info,
            'time_add'      => date(DATE_FORMAT)
        );

        self::getInstance()->insert($data_log);
    }
}