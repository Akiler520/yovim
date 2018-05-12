<?php
/**
 * Admin Controller of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-25 12:46:16
 * @author Akiler
 */
class AdminController extends Yov_Controller{

    function init(){
        parent::init();
    }

    function indexAction(){
        $this->display('admin/index.tpl', false);
    }
}