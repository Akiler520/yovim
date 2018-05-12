<?php
/**
 * User Controller of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-21 12:46:16
 * @author Akiler
 */
class UserController extends Yov_Controller{

    function init(){
        parent::init();
    }

    function loginpageAction(){
        $this->display('user/login.tpl');
    }

    function loginAction(){
        $userName = $this->request['username'];
        $password = $this->request['password'];

        if(!User::getInstance()->login($userName, $password)){
            Ak_Message::getInstance()->add("Error happen, check please!")->output(0);
        }

        Ak_Message::getInstance()->add("Success!")->output();
    }
}