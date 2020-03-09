<?php
	require '../config/initialize.inc';

	$session->check(Admin::LEVEL);

	$id = isset($_GET['id']) ? (int)$_GET['id'] : redirect('admin/index.php');

	$sql = 'DELETE FROM '.User::TABLE_NAME.' '
		. 'WHERE id = '.$id.' '
		. 'AND id NOT IN ('.$_SESSION['user_id'].')';

	if($db->query($sql)) {
		$session->message('User deleted successfully.');
		redirect('admin/index.php');
	}
?>