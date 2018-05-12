<?php
/**
 * User of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-15 12:46:16
 * @author Akiler
 */
class User extends Yov_Mode{

    /**
     * current name of data table
     * @var null
     */
    public $tableName;

    /**
     * user info
     *
     * @var array
     */
    protected $info = null;

    /**
     * if user is login
     *
     * @var bool
     */
    protected $isLogin = false;

    /**
     * object of class
     * @var object
     */
    private static $_instance;

    function init(){
        $this->tableName = strtolower(__CLASS__);

        if ($this->session(SESSION_USER_NAME)) {    // ($info = $this->cookie(SESSION_USER_NAME)) &&
            $this->info = $this->session(SESSION_USER_NAME);
            $this->isLogin = true;
        }
    }

    static function getInstance()
    {
        if(!isset(self::$_instance)) {
            self::$_instance = new self();
        }

        self::$_instance->setTableName(strtolower(__CLASS__));

        return self::$_instance;
    }

    /**
     * login
     *
     * @param $userName
     * @param $password
     * @return bool
     */
    function login($userName, $password){
        $userInfo = $this->getByName($userName);

        if(empty($userInfo)) {
            return false;
        }

        if($userInfo['password'] != md5($password.$userInfo['code'])) {
            return false;
        }

        //save SESSION
        $loginInfo = array(
            'id'				=> $userInfo['id'],
            'username'			=> $userInfo['username'],
            'name'				=> $userInfo['name'],
            'vorname'			=> $userInfo['vorname'],
//            'email'				=> $userInfo['email'],
            'group'				=> $userInfo['id_group'],
            'time_add'			=> $userInfo['time_add']
        );

        $this->assign_info($loginInfo);

        return true;
    }

    /**
     * add user
     *
     * @param $userName
     * @param $password
     * @return bool
     */
    function add($userName, $password){
        $userInfo = $this->getByName($userName);

        if($userInfo){
            return false;
        }

        $userCode = Ak_String::getRand();

        $data_user = array(
            'username'  => $userName,
            'code'      => $userCode,
            'password'  => md5($password.$userCode),
            'time_add'  => date('Y-m-d H:i:s')
        );

        return $this->insert($data_user);
    }

    function getByName($userName){
        return $this->dbObj->getRow('username="'.$userName.'" AND active=1');
    }

    function session($name, $value = '') {
        if ($name == '') {
            return false;
        }

        if ($value === '') {
            // get session
            return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
        } elseif ($value === null) {
            // clear session
            unset($_SESSION[$name]);
            /*session_unset();
            session_destroy();*/
        } else {
            // set session
            $_SESSION[$name]  =  $value;
        }

        return true;
    }

    function cookie($name, $value = '') {
        if ($name == '') {
            return false;
        }

        if ($value === '') {
            // get cookie
            return isset($_COOKIE[$name]) ? Ak_String::str2arr($_COOKIE[$name]) : null;
        } else {
            if ($value === null) {
                // clear cookie
                setcookie($name, '', time() - COOKIE_EXPIRE, COOKIE_PATH, DOMAIN);
                unset($_COOKIE[$name]);
            } else {
                // set cookie
                $value  = Ak_String::arr2str($value);
                $expire = time() + COOKIE_EXPIRE;
                setcookie($name, $value, $expire);
//	            setcookie($name, $value, $expire, COOKIE_PATH, DOMAIN);
                $_COOKIE[$name] = $value;
            }
        }

        return true;
    }

    function loginOut() {
        $this->session(SESSION_USER_NAME, null);
        $this->cookie(SESSION_USER_NAME, null);
    }

    function assign_info($user_info) {
        $this->session(SESSION_USER_NAME, $user_info);
        $this->cookie(SESSION_USER_NAME, $user_info);
        $this->info = $user_info;
        $this->isLogin = true;
    }

    function getLoginInfo() {
        return $this->info;
    }

    function isLogin() {
        return ($this->isLogin && isset($_SESSION[SESSION_USER_NAME]));
    }
}