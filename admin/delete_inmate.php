<?php
	require '../config/initialize.inc';

	$session->check(Admin::LEVEL);

	$id = isset($_GET['id']) ? (int)$_GET['id'] : redirect('admin/index.php');

	$sql = 'DELETE FROM '.Inmate::TABLE_NAME.' '
		. 'WHERE id = '.$id.' ';

	if($db->query($sql)) {
		$session->message('Inmate deleted successfully.');
		redirect('admin/index.php');
	}
?>