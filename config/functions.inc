<?php
	function redirect($location) {
		header('Location: '.SITE_ROOT.$location);
		exit;
	}

	function __autoload($class_name) {
		require_once 'class.'.$class_name.'.inc';
	}

	function ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	}

	function protocol() {
		$protocol='http';
		if (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS']) == 'ON') {
	  		$protocol='https';
		}
		return $protocol;
	}

	function url($url = '') {
		global $config;
		return sprintf(
			"%s://%s/%s/%s",
	    	isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
	    	$_SERVER['SERVER_NAME'],
	    	strtolower($config['title']['abbv']),
	    	$url
	  	);
	}
?>