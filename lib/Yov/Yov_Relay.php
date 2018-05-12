<?php
/**
 * Relay of Yovim
 *
 * Relay request to another site and get response
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-22 12:46:16
 * @author Akiler
 */
class Yov_Relay
{
    /**
     * the url of the target
     */
    private $url = 'http://www.yovim.com/';

    /**
     * the post data send to the target server
     * @var array
     */
    private $postData = array();

    /**
     * the max time to connect to server (s)
     * @var int
     */
    private $connectTimeout = 10;

    /**
     * the max time to run the curl code (s)
     * @var int
     */
    private $runTimeout = 15;

    /**
     * the max time to save the dns cache (s)
     * @var int
     */
    private $dnsCacheTimeout = 1800;

    /**
     * instance of current class
     *
     * @var object
     */
    private static $_instance = null;

    /**
     * get instance of current class
     *
     * single model
     *
     * @return object
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __destruct()
    {
    }

    /**
     * set the url of target server
     *
     * @param $url
     * @return object
     */
    public function setUrl($url){
        $this->url = $url;

        return self::$_instance;
    }

    /**
     * set timeout of connection
     * @param $time
     * @return object
     */
    public function setConnectTimeout($time){
        if($time >= 0){
            $this->connectTimeout = $time;
        }

        return self::$_instance;
    }

    /**
     * set timeout of run the cURL
     * @param $time
     * @return object
     */
    public function setRunTimeout($time){
        if($time >= 0){
            $this->runTimeout = $time;
        }

        return self::$_instance;
    }

    /**
     * set timeout of dns cache
     * @param $time
     * @return object
     */
    public function setDnsCacheTimeout($time){
        if($time >= 0){
            $this->dnsCacheTimeout = $time;
        }

        return self::$_instance;
    }

    /**
     * set post data
     *
     * @param array $data
     * @return object
     */
    public function setPostData($data = array()){
        if(!empty($data)){
            $this->postData = $data;
        }else{
            $this->postData = $_REQUEST;
        }

        return self::$_instance;
    }

    /**
     * send request to the target server
     *
     * @return string
     */
    public function relay()
    {
        $ch = curl_init();

        if(!$ch){
            return false;
        }

        $options = array(
            CURLOPT_URL                 => $this->url,              // set the url of the target server
            CURLOPT_RETURNTRANSFER      => true,                    // set if save the result to be string
            CURLOPT_CONNECTTIMEOUT      => $this->connectTimeout,   // set the connect time
            CURLOPT_TIMEOUT             => $this->runTimeout,       // set the run time
            CURLOPT_DNS_CACHE_TIMEOUT   => $this->dnsCacheTimeout,  // set the time to save the cache of dns
            CURLOPT_HEADER              => 0,                       // set if cut off the header info
            CURLOPT_POST                => 1,                       // use post method
            CURLOPT_POSTFIELDS          => $this->postData          // set post data
        );

        curl_setopt_array($ch, $options);

        // start to run
        $sData = curl_exec($ch);

        // release the curl instance
        curl_close($ch);
        unset($ch);

        return $sData;
    }
}