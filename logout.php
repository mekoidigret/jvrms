<?php
	require 'config/initialize.inc';

	$session->logout();
	redirect('index.php');
?>