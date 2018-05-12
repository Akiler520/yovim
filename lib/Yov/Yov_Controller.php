<?php
/**
 * Main Controller of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-22 12:46:16
 * @author Akiler
 */
class Yov_Controller{
    /**
     * the request from client
     *
     * @var null
     */
    public $request = null;

    /**
     * the object of view
     * @var null|object|Smarty
     */
    public $view = null;

    /**
     * to filter the data by setting of client
     * @var array
     */
    public $filter = array();

    function __construct(){
        /**
         * if file is larger than UPLOAD_MAX_SIZE, the form from client will be null, so do below.
         */
        $contentLen = $_SERVER['CONTENT_LENGTH'];
        $contentType = substr($_SERVER['CONTENT_TYPE'], 0, stripos($_SERVER['CONTENT_TYPE'], ';'));

        if ($contentType == 'multipart/form-data' && $contentLen > UPLOAD_MAX_SIZE) {
            Ak_Message::getInstance()->add('Maybe the file is too large, Max is: '.(UPLOAD_MAX_SIZE/1024/1024).'M.')->output(0);
        }

        $this->request = Yov_Router::getInstance()->getRequest();

        $this->view = Yov_init::getInstance()->view;

        $clientIP = Ak_String::getClientIP();
        Ak_Message::getInstance()->add($clientIP)->toLog(1, true);

        $this->init();
    }

    public function init(){
        // controller => action, which need login access
        $passportCheckArr = array(
            'admin'     => array('*'),
            'user'      => array('index', 'detail')
        );

        $controller = Yov_Router::getInstance()->getController();
        $action = Yov_Router::getInstance()->getAction();

        $ifCheck = false;

        // admin controller can be 'Admin_SourceController', so we only get the first party 'Admin'.
        $tmp_split = explode('_', $controller);
        $controller = $tmp_split[0];

        foreach($passportCheckArr as $key_pass=>$val_pass){
            if($controller == $key_pass && (in_array('*', $val_pass) || in_array($action, $val_pass))){
                $ifCheck = true;
            }
        }

        // jump to login page when need to be checked, and not login
        if($ifCheck && !User::getInstance()->isLogin()){
            Yov_Router::getInstance()->redirect('user', 'loginpage');
        }

        // set page
        if(intval($this->request['page']) <= 0){
            $this->filter['page'] = 1;
        }else{
            $this->filter['page'] = intval($this->request['page']);
        }

        // set limit of list
        if(intval($this->request['rows']) <= 0){
            $this->filter['limit'] = PAGE_SIZE;
        }else{
            $this->filter['limit'] = intval($this->request['rows']);
        }

        // set order
        if(!$this->request['sort']){
            $this->filter['orderby'] = 'time_add';
        }else{
            $this->filter['orderby'] = $this->request['sort'];
        }

        // set order way
        if(!$this->request['order']){
            $this->filter['order'] = 'DESC';
        }else{
            $this->filter['order'] = $this->request['order'];
        }

        $menuType = Source_Type::getInstance()->getMenu();

        Yov_init::getInstance()->view->assign('menuType', $menuType);

        $friendLink = Friend_Link::getInstance()->lists();

        Yov_init::getInstance()->view->assign('friendLink', $friendLink);

        // save log
        /*$status = ($controller == 'admin') ? LOG_SYS_SUCCESS : LOG_USER_SUCCESS;
        $info = Ak_String::arr2equation($this->request);

        Log::getInstance()->add($status, $info);*/
    }

    /**
     * display the common view page
     *
     * @param $tplFile  : the template page
     * @param string $framework : the container of the page
     */
    protected function display($tplFile, $framework ='framework.tpl')
    {
        if ($framework == false) {
            $this->view->display($tplFile);
        } else {
            $this->view->assign('tplfile', $tplFile);
            $this->view->display($framework);
        }
    }

    /**
     * display only a single page, not framework
     *
     * @param $tplFile  : the template page
     */
    protected function displaySingle($tplFile)
    {
        $this->view->display($tplFile);
    }

    /**
     * display the source page
     *
     * @param $tplFile
     */
    protected function displaySource($tplFile)
    {
        //the source path is not the same one with the view path, so we need the change it before display
        $this->view->template_dir = SOURCE_PATH;

        $this->view->display($tplFile);
    }
}