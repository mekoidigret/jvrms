<?php
	require '../config/initialize.inc';

	$session->check(Admin::LEVEL);

	if(!ajax()) {
		redirect('index.php');
	}

	if(isset($_POST) && !empty($_POST)) {
		$officer = new Officer($_POST);
		if($officer->save()) {
			echo json_encode(array(
				'status' => true,
				'message' => 'Officer added successfully.'
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
<form id="add-officer-form" action="add_officer.php" method="post">
	<h3>Add Officer</h3>
	<p id="message-pane"></p>
	<span>Username:</span><br />
	<input type="text" name="username" placeholder="Username" class="form-control-sm" required=""><br />
	<span>Password:</span><br />
	<input type="password" name="password" placeholder="Password" class="form-control-sm" required=""><br /><br />
	<input type="submit" name="submit" class="btn btn-success btn-sm" value="Save Officer">
</form>
<script type="text/javascript">
	$(document).ready(() => {
		$('#add-officer-form').submit(function(e) {
			disableLink(e);
			$.post($(this).attr('action'), $(this).serialize(), result => {=
				const json = JSON.parse(result);
				if(json.status) {
					$.get('officers.php', result => {
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