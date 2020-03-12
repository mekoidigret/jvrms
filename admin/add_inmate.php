<?php
	require '../config/initialize.inc';

	$session->check(Admin::LEVEL);

	if(!ajax()) {
		redirect('index.php');
	}

	if(isset($_POST) && !empty($_POST)) {
		$inmate = new Inmate($_POST);
		if($inmate->save()) {
			echo json_encode(array(
				'status' => true,
				'message' => 'Inmate added successfully.'
			));
			exit;
		}
		else {
			echo json_encode(array(
				'status' => false,
				'message' => 'Something went wrong.'
			));
			exit;
		}
	}
?>
<form id="add-inmate-form" action="add_inmate.php" method="post">
	<h3>Add Inmate</h3>
	<p id="message-pane"></p>
	<div class="row">
		<div class="col-md-6">
			<span>First Name:</span><br />
			<input type="text" name="first_name" placeholder="First Name" class="form-control-sm" required=""><br />
			<span>Last Name:</span><br />
			<input type="text" name="last_name" placeholder="Last Name" class="form-control-sm" required=""><br />
			<span>Gender:</span><br />
			<select class="form-control-sm" name="gender">
				<option value="Male">Male</option>
				<option value="Female">Female</option>
			</select>
		</div>
		<div class="col-md-6">
			<span>Cell Number:</span><br />
			<input type="text" name="cell_number" placeholder="Cell Number" class="form-control-sm" required=""><br />
			<span>Case Number:</span><br />
			<input type="text" name="case_number" placeholder="Case Number" class="form-control-sm" required=""><br />
			<span>Crime:</span><br />
			<textarea name="crime" placeholder="Crime" class="form-control-sm" required=""></textarea>
		</div>
	</div>
	<br /><br />
	<input type="submit" name="submit" class="btn btn-success btn-sm" value="Save Inmate">
</form>
<script type="text/javascript">
	$(document).ready(() => {
		$('#add-inmate-form').submit(function(e) {
			disableLink(e);
			$.post($(this).attr('action'), $(this).serialize(), result => {
				const json = JSON.parse(result);
				if(json.status) {
					$.get('inmates.php', result => {
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