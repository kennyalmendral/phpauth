<?php
	session_start();

	$GLOBALS['config'] = array(
		'mysql' => array(
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'db' => 'phpauth'
		),
		'remember' => array(
			'cookie_name' => 'hash',
			'cookie_expiry' => 604800 
		),
		'session' => array(
			'session_name' => 'user',
			'token_name' => 'token'
		),
		'site_info' => array(
			'name' => 'PHPAuth',
			'description' => 'Extendable PHP System with Base User Authentication',
			'url' => "http://$_SERVER[HTTP_HOST]/phpauth"
		)
	);

	spl_autoload_register(function($class) {
		require_once 'lib/' . $class . '.php';
	});

	require_once 'functions.php';

	if (Cookie::exists(Config::get('remember/cookie_name')) && ! Session::exists(Config::get('session/session_name'))) {
		$hash = Cookie::get(Config::get('remember/cookie_name'));
		$hash_check = DB::getInstance()->get('users_session', array('hash', '=', $hash));

		if ($hash_check->count()) {
			$user = new User($hash_check->first()->user_id);
			$user->login();
		}
	}
?>
