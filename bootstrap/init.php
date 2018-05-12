<?php
if (version_compare(PHP_VERSION, '5.0.0', '<')) {
    exit("Sorry, this system only run on PHP version 5 or greater!");
}




/**
 * init the configure and the object of the DMS System
 *
 */
class Yov_init{
    /**
     * view
     *
     * @var object
     */
    public $view;

    /**
     * database
     *
     * @var object
     */
    public $db;

    /**
     * email
     *
     * @var object
     */
    public $email;

    /**
     * tree
     *
     * @var object
     */
    public $tree;

    /**
     * http request from client
     *
     * @var array
     */
    public $request;

    /**
     * user
     *
     * @var object
     */
    public $user;

    /**
     * permission
     *
     * @var object
     */
    public $acl;

    /**
     * object of class
     * @var object
     */
    private static $_instance;

    private function __construct() {
        $this->load();

        $this->view = new Smarty();

        $this->db = Ak_Mysql::getInstance();
    }

    public static function getInstance()
    {
        if(!isset(self::$_instance))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function init() {
        $this->view();
        $this->database();
        $this->sys_global();

        if (DEBUG) {
            error_reporting(E_ALL ^ E_NOTICE);
        } else {
            error_reporting(0);
        }
    }

    protected function load() {
        @session_start();
        require_once(dirname(dirname(__FILE__)).'/config/constant.php');

        require_once(CONFIG_PATH.'db.php');
        require_once(CONFIG_PATH.'common.php');

        set_include_path(
            LIB_PATH.PS.
            get_include_path().PS
        );

        spl_autoload_register(array($this, 'autoload'));
    }

    protected function view() {
        $this->view->template_dir      = ROOT_PATH.'view/';
        $this->view->compile_dir       = ROOT_PATH.'tmp/templates_c/';
        $this->view->config_dir        = ROOT_PATH.'config/';
        $this->view->cache_dir         = ROOT_PATH.'tmp/cache/';
        $this->view->caching           = false;
        $this->view->cache_lifetime    = 3600;
    }

    protected function database() {
        $this->db->debug(DEBUG);		// set to false when publish.
        $this->db->connect(YOV_DB_HOST, YOV_DB_USER, YOV_DB_PASS, YOV_DB_NAME);
    }

    protected function sys_global() {
        $this->view->assign("title", "B-P-G Document Manage System");
        $this->view->assign("_web_path", WEB_PATH);
        $this->view->assign("_source_path", SOURCE_PATH);
		$this->view->assign("_host", $_SERVER['HTTP_HOST']);
        $this->view->assign("_host_date", date("Ymd"));

        if (isset($_SESSION['_msg'])) {
            $this->view->assign("_msg", $_SESSION['_msg']);
            unset($_SESSION['_msg']);
        }
    }


    protected static function autoload($classname) {
        $paths = array(LIB_PATH, PLUGIN_PATH, MODE_PATH, CONTROLLER_PATH, SMARTY_PATH,YOV_PATH, EMAIL_PATH);

        foreach ($paths as $path) {
            $file = $path.$classname.'.php';
            if (file_exists($file)) {
                require_once($file);
                break;
            }
        }

        return true;
    }
}
