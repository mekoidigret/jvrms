<?php
	require '../config/initialize.inc';

	$session->check(Admin::LEVEL);

	if(!ajax()) {
		redirect('admin/index.php');
	}

	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$per_page = 10;
	$total_count = $db->search(Officer::TABLE_NAME, array(
		'access_level' => Officer::LEVEL
	), 'count');
	$pagination = new Pagination($page, $per_page, $total_count);

	$officers = Officer::findAll($pagination);
?>
<main class="text-left">
	<p id="message-pane">
		<?=$session->message()?>
	</p>
	<h4>Officers</h4>
	<p>
		<a class="btn btn-info btn-sm ajax-btn" href="add_officer.php">
			Add
		</a>
	</p>
	<?php if($officers) { ?>
		<table class="table table-sm text-light">
			<thead>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<td>Actions</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($officers as $officer) { ?>
					<tr>
						<td>
							<?=htmlentities($officer->id)?>
						</td>
						<td>
							<?=htmlentities($officer->username)?>
						</td>
						<td>
							<a onclick="return confirm('Are you sure?')" class="btn btn-warning btn-sm" href="delete_user.php?id=<?=urlencode($officer->id)?>">
								Delete
							</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?=$pagination?>
	<?php } else {
		echo 'There are no officers.';
	} ?>
</main>
<br /><br /><br /><br />