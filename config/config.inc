<?php
	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

	$config = array(
		'db' => array(
			'dsn' => 'mysql:host=localhost;dbname=jvrms',
			'host' => '',
			'username' => 'root',
			'password' => '',
			'dbname' => '',
			'driver' => ''
		),
		'title' => array(
			'abbv' => 'JVRMS',
			'full' => 'Jail Visitor Record Management System'
		),
		'authors' => array(
			'John Michael Manlupig'
		)
	);

	date_default_timezone_set('Asia/Manila');

	$site_root = url();
	defined('SITE_ROOT') ? null : define('SITE_ROOT', $site_root);
?>