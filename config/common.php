<?php
/**
 * it is test info, we can edit it when use is login.
 */
$GLOBALS['_YOV_CONFIG_EMAIL'] = array(
	'smtp'	=> array( 
		'mode'			=> 'smtp',
		'host'			=> 'vwp10374.webpack.hosteurope.de',
		'port'			=> 25,
		'auth_username'	=> 'wp11122427-administration',		// the name of the email which can login
		'auth_password'	=> '5bNUnGcj4z'			// login password
	),
	'pop'	=> array(
		'host'			=> 'vwp10374.webpack.hosteurope.de',
		'auth_username'	=> 'wp11122427-dms',	//'wp11122427-dmstest',	//
		'auth_password'	=> 'EvJ-WkmCrD'			//'Pbz6ubKRMn'	// 
	)
);

/**
 * action filter
 * key=controller
 * value=action list of the controller
 */
$GLOBALS['_YOV_CONFIG_ACCESS_FILTER'] = array(
	'Login'		=> array('filter', 'init'),     // Controller => action
	'Test'		=> array('edit_newversion')
);
