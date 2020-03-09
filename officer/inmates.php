<?php
	require '../config/initialize.inc';

	$session->check(Officer::LEVEL);

	if(!ajax()) {
		redirect('admin/index.php');
	}

	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$per_page = 10;
	$total_count = $db->search(Inmate::TABLE_NAME, array(), 'count');
	$pagination = new Pagination($page, $per_page, $total_count);

	$inmates = Inmate::findAll($pagination);
?>
<main class="text-left">
	<p id="message-pane">
		<?=$session->message()?>
	</p>
	<h4>Inmates</h4>
	<?php if($inmates) { ?>
		<?php /*
		<p>
			<a class="btn btn-primary btn-sm ajax-btn" href="record.php">
				Record Visit
			</a>
		</p> */ ?>
		<table class="table table-sm text-light">
			<thead>
				<tr>
					<th>Name</th>
					<th>Gender</th>
					<th>Cell Number</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($inmates as $inmate) { ?>
					<tr>
						<td>
							<?=$inmate->getFullName()?>
						</td>
						<td>
							<?=$inmate->gender?>
						</td>
						<td>
							<?=htmlentities($inmate->cell_number)?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?=$pagination?>
	<?php } else {
		echo 'There are no inmates.';
	} ?>
</main>
<br /><br /><br /><br />