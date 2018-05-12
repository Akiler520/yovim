<?php
/**
 *	message information
 *	@author		akiler <532171911@qq.com>
 *	@copyright	2010-2011
 *	@version	1.0
 *	@package	LIB-Ak
 *
 *	$Id: AkMessage.class.php 2010-09-29 14:06:12 akiler $
 */

class Ak_Message
{
    /**
     * object of Ak_Error
     *
     * @var object
     */
	private static $_instance;
	
    /**
     * message
     * 
     * @var array
     */
	protected $_msgs = array();

    /**
     * the data info can be return to user
     * @var array
     */
    protected $_data = '';
	
	/**
	 * log file
	 *
	 * @var string
	 */
	private $_file_log = '';

    function __construct()
	{
		$this->clear();
		
		$this->_file_log = LOG_FILE;
	}

    function __destruct(){
		
	}

    function __toString()
	{
		return $this->getMsg();
	}

	static function getInstance()
	{
        if(!isset(self::$_instance))
            self::$_instance = new self();
        return self::$_instance;
	}

    /**
     * add message
     * @param string $msg 
     * 
     * $return object self
     */
	function add($msg, $data = '')
	{
		if (is_array($msg)) {
			$msg = Ak_String::arr2equation($msg, "\n");
		}
		
		$this->_msgs[] = (string)$msg;
        $this->_data = $data;

		return $this;
	}
	
	function setLogFile($pathto) 
	{
		$this->_file_log = $pathto;
	}
	
	/**
	 * save message to log.txt
	 *
	 * @param $level
     * @param $toFile   : true = save log to log file, or save into database
	 * @return object self
	 */
	function toLog($level = 1, $toFile = false) {
        $msg = $this->getMsg();

        if($toFile){
            $fp = fopen($this->_file_log, 'a+');

            if ($fp) {
                $msg = '[System]['.date('Y-m-d H:i:s').'] '.$msg;
                fwrite($fp, $msg."\r\n");

                fclose($fp);
            }
        }else{
            // save log into database
            Log::getInstance()->add($level, $msg);
        }

        // after record to log file, clean the messages.
        $this->msgClean();

	    return $this;
	}
	
	/**
	 * clean message
	 *
	 * @return object self
	 */
	function msgClean() {
	    $this->_msgs = array();
	    
	    return $this;
	}
	
	/**
	 * output message
	 *
	 * @param integer $msgType		0=error,1=success,2=warning
	 * @param integer $dataType		0=html, 1=json, 2=xml
	 * @param bool $isExit			true='echo exit',false=''
	 */
	function output($msgType = 1, $dataType = 1, $isExit = true) {
		switch ($dataType) {
			case 0:
				echo $this->getMsg();
				break;
			case 1:
				$retJson = array(
							'status'	=> $msgType,
							'msg'		=> $this->getMsg(),
                            'data'      => $this->_data
						);

				echo json_encode($retJson);
				
				break;
			case 2:
				break;
			case 3:
				break;
			default:
				break;
		}
		
		if ($isExit) {
			exit;
		}
	}
	
	function getMsg()
	{
		return implode('; ', $this->_msgs);
	}

    /**
     * redirect the page link
     * @param sting $action page
     * @param array $params parameter
     */
	function redirect($action, $params = array())
	{
		$_SESSION['_msg'] = $this->getMsg();
		if (!empty($params)) {
			$action .= '?' . Ak_String::arr2equation($params, '&');
		}
		
		header('Location:'.$action);
	}
	
	function goBack(){
		echo '<script language="javascript">history.back();</script>';
		exit;
	}

    /**
     * clear all message
     * $return object self
     */ 
	function clear()
	{
		$this->_msgs = array();
		unset($_SESSION['_msg']);
		
		return $this;
	}
}