<?php
/**
 * Xueer Controller of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-26 12:46:16
 * @author Akiler
 */
class XueerController extends Yov_Controller{
    function init(){
        parent::init();
    }

    function indexAction(){
        Yov_init::getInstance()->view->assign('controller', Yov_Router::getInstance()->getController());
        $this->displaySource('xueer/index.html');
    }
}