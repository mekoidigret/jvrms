<?php
	require '../config/initialize.inc';

	if(!ajax()) {
		redirect('admin/index.php');
	}

	$session->check(Officer::LEVEL);

	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$per_page = 10;
	$total_count = $db->search(Visit::TABLE_NAME, array(), 'count');
	$pagination = new Pagination($page, $per_page, $total_count);

	$visits = Visit::findAll($pagination);
?>
<main class="text-left">
	<p id="message-pane"></p>
	<?php if($visits) { ?>
		<h3>Visits</h3>
		<table class="table table-sm text-light">
			<thead>
				<tr>
					<th>Date</th>
					<th>Visitor Name</th>
					<th>Contact Number</th>
					<th>Inmate Name</th>
					<th>Time In</th>
					<th>Time Out</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($visits as $visit) { ?>
					<tr>
						<td>
							<?=$visit->getDate()?>
						</td>
						<td>
							<?=htmlentities($visit->visitor_name)?>
						</td>
						<td>
							<?=htmlentities($visit->contact_number)?>
						</td>
						<td>
							<?=$visit->getInmateName()?>
						</td>
						<td>
							<?=$visit->getTimeIn()?>
						</td>
						<td>
							<?=$visit->getTimeOut()?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?=$pagination?>
	<?php } else {
		echo 'There are no visits.';
	} ?>
</main>