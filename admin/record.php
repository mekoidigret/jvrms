<?php
	require '../config/initialize.inc';

	$session->check(Admin::LEVEL);

	if(!ajax()) {
		redirect('index.php');
	}

	if(isset($_POST) && !empty($_POST)) {
		$visit = new Visit($_POST);
		if($visit->save()) {
			echo json_encode(array(
				'status' => true,
				'message' => 'Visit recorded successfully.'
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

	$sql = 'SELECT * FROM '.Inmate::TABLE_NAME.' '
		.'ORDER BY gender DESC, last_name ASC';
	$result = $db->query($sql);
	$inmates = array();
	if($result->rowCount() > 0) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$inmates[] = new Inmate($row);
		}
	}
	else {
		echo '<a class="btn btn-dark btn-sm ajax-btn" href="inmates.php">Back</a>';
		echo '<p class="lead">Please add inmates first before visits.</p>';
		exit;
	}
?>
<form id="add-visit-form" action="record.php" method="post">
	<span>Visitor Name:</span><br />
	<input type="text" name="visitor_name" placeholder="Visitor Name" class="form-control-sm" required=""><br />
	<span>Contact Number:</span><br />
	<input type="number" name="contact_number" placeholder="Contact Number" class="form-control-sm" required=""><br />
	<span>Time In:</span><br />
	<input type="time" name="time_in" placeholder="Time In" class="form-control-sm" required=""><br />
	<span>Time Out:</span><br />
	<input type="time" name="time_out" placeholder="Time Out" class="form-control-sm" required=""><br />
	<span>Inmate:</span><br />
	<select class="form-control-sm" name="inmate_id">
		<?php foreach($inmates as $inmate) { ?>
			<option value="<?=$inmate->id?>">
				<?=$inmate->getFullName()?>
			</option>
		<?php } ?>
	</select>
	<br /><br />
	<input type="submit" name="submit" class="btn btn-success btn-sm" value="Save">
</form>
<script type="text/javascript">
	$(document).ready(() => {
		$('#add-visit-form').submit(function(e) {
			disableLink(e);
			$.post($(this).attr('action'), $(this).serialize(), result => {
				const json = JSON.parse(result);
				if(json.status) {
					$.get('logs.php', result => {
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