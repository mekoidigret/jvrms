<?php
	require '../config/initialize.inc';

	$session->check(Admin::LEVEL);

	if(!ajax()) {
		redirect('index.php');
	}

	if(isset($_POST) && !empty($_POST)) {
		$admin = new Admin($_POST);
		if($admin->save()) {
			echo json_encode(array(
				'status' => true,
				'message' => 'Admin added successfully.'
			));
			exit;
		}
		else {
			echo json_encode(array(
				'status' => false,
				'message' => 'Username already taken.'
			));
			exit;
		}
	}
?>
<form id="add-admin-form" action="add_admin.php" method="post">
	<h3>Add Admin</h3>
	<p id="message-pane"></p>
	<span>Username:</span><br />
	<input type="text" name="username" placeholder="Username" class="form-control-sm" required=""><br />
	<span>Password:</span><br />
	<input type="password" name="password" placeholder="Password" class="form-control-sm" required=""><br /><br />
	<input type="submit" name="submit" class="btn btn-success btn-sm" value="Save Admin">
</form>
<script type="text/javascript">
	$(document).ready(() => {
		$('#add-admin-form').submit(function(e) {
			disableLink(e);
			$.post($(this).attr('action'), $(this).serialize(), result => {
				const json = JSON.parse(result);
				if(json.status) {
					$.get('index.php', result => {
						container.loadHTML(result);
						setTimeout(() => {
							message(json.message, 'success');
						}, 400);
					});
				}
				else {
					message(json.message, 'danger');
				}
			});
		});
	});
</script>