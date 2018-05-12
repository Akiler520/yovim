<?php
define('DS', 					DIRECTORY_SEPARATOR);
define('PS', 					PATH_SEPARATOR);
/*
define('DEBUG',					false);
define("IS_TEST",				false);*/

define('DEBUG',					true);
define("IS_TEST",				true);

if(IS_TEST === false || PHP_OS == 'Linux'){
    define('WEB_PATH',				'/');      // ** set null when publish, or error will happen
    define('SITE_PATH',				'');      // ** set null when publish, or error will happen
}else{
    define('WEB_PATH',				'/');      // ** set null when publish, or error will happen
    define('SITE_PATH',				'/');      // ** set null when publish, or error will happen
}

define('BASE_PATH', 			dirname(dirname(__FILE__)).'\\');		// for windows only

define('ROOT_PATH',				$_SERVER['DOCUMENT_ROOT'].WEB_PATH);		// for linux or windows

define('TMP_PATH',				ROOT_PATH.'tmp/');

define('EMAIL_ERR_LOCK',		ROOT_PATH.'email_err_lock');

define('UPLOAD_PATH',			ROOT_PATH.'source/');
define('UPLOAD_PATH_TMP',		ROOT_PATH.'source/tmp/');

define('UPLOAD_MAX_SIZE',		10*1024*1024);			// 10M, can be edit in file '.htaccess'

define('LIB_PATH',				ROOT_PATH.'lib/');
define('CONFIG_PATH',			ROOT_PATH.'config/');
define('SMARTY_PATH',			LIB_PATH.'Smarty/');
define('EMAIL_PATH',			LIB_PATH.'Mailer/');
define('YOV_PATH',			    LIB_PATH.'Yov/');

define('PLUGIN_PATH',			ROOT_PATH.'plugin/');
define('MODE_PATH',				ROOT_PATH.'mode/');
define('CONTROLLER_PATH',	    ROOT_PATH.'controller/');
define('SOURCE_PATH',		    ROOT_PATH.'source/');
define('COOKIE_PATH',			'/');
define('COOKIE_EXPIRE',			60*60);		// cookie expire time, half one hour (3600s)
define('SESSION_USER_NAME',		'yov_userinfo');
define('DOMAIN',				'');
define('THUMB_KEY',				'thumb-');  // thumbnail key to save the thumbnail file

define('LOG_FILE',				TMP_PATH.'info.log');

define('PAGE_SIZE',             20);    // page size of each list