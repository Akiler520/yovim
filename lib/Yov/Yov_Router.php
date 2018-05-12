<?php
/**
 * Router of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-22 14:46:16
 * @author Akiler
 */
class Yov_Router{

    /**
     * http request
     * @var null
     */
    private $request = array();

    /**
     * controller of request
     * @var null
     */
    private $controller = null;

    /**
     * action of request
     * @var null
     */
    private $action = null;

    /**
     * object of class
     * @var object
     */
    private static $_instance;

    private function __construct(){
        $this->http_request();
    }

    static function getInstance()
    {
        if(!isset(self::$_instance))
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * parse http request
     */
    protected function 	http_request() {
        $URI = urldecode($_SERVER['REQUEST_URI']);
        $uriArr = explode('/', $URI);

        $webPathArr = explode('/', WEB_PATH);
        $webPathLen = count($webPathArr);
        $tmp_req = array();
        $request = array();

        if(!empty($webPathArr)){
            for($i = 0; $i < count($uriArr); $i++){
                if($i < ($webPathLen-1)){
                    continue;
                }

                $tmp_req[] = $uriArr[$i];
            }
        }

        foreach($tmp_req as $key_req=>$val_req){
            $val_req = strtolower($val_req);

            if($key_req == 0){
                $this->controller = $val_req;
                continue;
            }

            if($key_req == 1){
                $this->action = $val_req;
                continue;
            }

            if($key_req%2 == 1){
                continue;
            }

            $request[$val_req] = $tmp_req[$key_req+1];
        }

        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            if(!empty($_SERVER['QUERY_STRING'])){
                /*$query = explode('&', $_SERVER['QUERY_STRING']);
                foreach($query as $val_qur){
                    $tmp_qur = explode('=', $val_qur);
                    $this->request[$tmp_qur[0]] = $tmp_qur[1];
                }*/
                $this->request = $_GET;
            }else{
                $this->request = $request;
            }
        }else{
            $this->request = $_POST;
        }
    }

    /**
     * get the request from client
     * include POST,GET data
     * @return null
     */
    public function getRequest(){
        return $this->request;
    }

    /**
     * get the controller of current request
     * @return null
     */
    public function getController(){
        return $this->controller;
    }

    /**
     * get the action of current request
     * @return null
     */
    public function getAction(){
        return $this->action;
    }

    public function setController($controller){
        $this->controller = $controller;
    }

    public function setAction($action){
        $this->action = $action;
    }

    public function redirect($controller, $action = 'index', $params = array()){
        $this->setController($controller);
        $this->setAction($action);

        $this->run();
        exit;
    }

    /**
     * start to process the request of client
     */
    public function run(){
        try{
            if(empty($this->controller)){
                $this->controller = 'index';
            }

            if(empty($this->action)){
                $this->action = 'index';
            }

            $tmp_controller = explode('_', $this->controller);

            if(count($tmp_controller) > 1){
                $controller_arr = array();
                foreach($tmp_controller as $val_controller){
                    $controller_arr[] = ucwords($val_controller);
                }

                $controller = implode('_', $controller_arr);
            }else{
                $controller = ucwords($this->controller);
            }

            if(!is_file(CONTROLLER_PATH.$controller.'Controller.php')){
                $this->controller = 'Index';

//                throw new Exception("Unknown Controller");
            }

            $controllerClass = $this->controller.'Controller';

            $controllerObj = new $controllerClass();

            $actionFunc = $this->action.'Action';

            if(!method_exists($controllerObj, $actionFunc)){
                $this->action = 'index';
                $actionFunc = $this->action.'Action';

//                throw new Exception("Unknown Action");
            }

            // run action
            $controllerObj->$actionFunc();
        }catch (Exception $err) {
            Log::getInstance()->add(LOG_SYS_FATAL, $err->getMessage());
            Ak_String::printm($err->getMessage());
        }
    }
}
