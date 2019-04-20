<?php

function get_header() {
	include_once 'includes/header.php';
}

function get_footer() {
	include_once 'includes/footer.php';
}

function page_title() {
	$request_uri = explode('/', $_SERVER['REQUEST_URI']);
	$page = $request_uri[2];

	switch ($page) {
		case 'login.php':
			$page_title = "Login &ndash; " . Config::get('site_info/name');
			break;
		case 'register.php':
			$page_title = "Register &ndash; " . Config::get('site_info/name');
			break;
		default:
			$page_title = Config::get('site_info/name') . " &ndash; " . Config::get('site_info/description');
			break;
	}

	return $page_title;
}

function page_class() {
	$request_uri = explode('/', $_SERVER['REQUEST_URI']);
	$page_class = explode('.', $request_uri[2]);

	return "page-{$page_class[0]}";
}

function escape($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function show_errors($errors) {
	echo '<ul class="errors">';
		foreach ($errors as $error) {
			echo '<li>' . $error . '</li>';
		}
	echo '</ul>';
}

function is_auth_page() {
	$request_uri = explode('/', $_SERVER['REQUEST_URI']);
	$auth_pages = ['login.php', 'register.php'];

	if (in_array($request_uri[2], $auth_pages)) {
		return true;
	} else {
		return false;
	}
}

function is_user_logged_in() {
	$user = new User();

	if ($user->isLoggedIn()) {
		return true;
	}

	return false;
}

function pp($array) {
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}
