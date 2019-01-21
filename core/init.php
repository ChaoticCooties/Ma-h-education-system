<?php 
session_start();

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1', //Localhost without DNS lookup
		'username' => 'root', //conection
		'password' => '',
		'db' => 'portfolio'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800 //1 week in seconds
	), 
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

//Load all helper classes
spl_autoload_register(function($class) {
	require_once '../classes/' . $class . '.php';
});

require_once '../functions/sanitize.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name')); //check session cookie hash
	$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

	if($hashCheck->count()) { 
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}