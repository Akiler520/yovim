<?php
// database host

if (IS_TEST === false || PHP_OS == 'Linux') {
    define("YOV_DB_HOST",			"localhost:3306");

    // database name
    define("YOV_DB_NAME",			"yovim_com");

    // database username
    define("YOV_DB_USER",			"yovim_com");

    // database password
    define("YOV_DB_PASS",			"akilerdb.");

    // prefix of table
    define("YOV_DB_PREFIX",			"yov_");

    //set time area, china;
    date_default_timezone_set('PRC');
}else{
    define("YOV_DB_HOST",			"localhost:3306");

    // database name
    define("YOV_DB_NAME",			"yovim");

    // database username
    define("YOV_DB_USER",			"root");

    // database password
    define("YOV_DB_PASS",			"123456");

    // prefix of table
    define("YOV_DB_PREFIX",			"yov_");

    //set time area, china;
    date_default_timezone_set('PRC');
}
