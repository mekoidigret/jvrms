<?php
	require '../config/initialize.inc';

	$header = new Header(array(
		'title' => 'Admins'
	));

	$session->check(Admin::LEVEL);

	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$per_page = 10;
	$total_count = $db->search(Admin::TABLE_NAME, array(
		'access_level' => Admin::LEVEL
	), 'count');
	$pagination = new Pagination($page, $per_page, $total_count);

	$admins = Admin::findAll($pagination);
?>
<?php if(!ajax()) { ?>
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<?=$header->set()?>
		</head>
	  	<body class="text-center">
	    	<div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
		      	<header class="masthead mb-auto">
		        	<div class="inner">
		          		<h3 class="masthead-brand">JVRMS</h3>
		         		<nav class="nav nav-masthead justify-content-center">
		            		<a class="nav-link active" href="<?=url('admin/index.php')?>">Admins</a>
		            		<a class="nav-link" href="<?=url('admin/officers.php')?>">Officers</a>
		            		<a class="nav-link" href="<?=url('admin/inmates.php')?>">Inmates</a>
		            		<a class="nav-link" href="<?=url('admin/logs.php')?>">Logs</a>
		            		<a class="nav-link logout" href="<?=url('logout.php')?>">Logout</a>
		          		</nav>
		        	</div>
	      	</header>
<?php } ?>
			<main id="container" class="text-left">
				<p id="message-pane">
					<?=$session->message()?>
				</p>
				<h4>Admins</h4>
				<p>
					<a class="btn btn-info btn-sm ajax-btn" href="add_admin.php">
						Add
					</a>
				</p>
				<?php if($admins) { ?>
					<table class="table table-sm text-light">
						<thead>
							<tr>
								<th>ID</th>
								<th>Username</th>
								<td>Actions</td>
							</tr>
						</thead>
						<tbody>
							<?php foreach($admins as $admin) { ?>
								<tr>
									<td>
										<?=htmlentities($admin->id)?>
									</td>
									<td>
										<?=htmlentities($admin->username)?>
									</td>
									<td>
										<a onclick="return confirm('Are you sure?')" class="btn btn-warning btn-sm" href="delete_user.php?id=<?=urlencode($admin->id)?>">
											Delete
										</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<?=$pagination?>
				<?php } else {
					echo 'There are no admins aside from you.';
				} ?>
			</main>
			<br /><br /><br /><br />
<?php if(!ajax()) { ?>
	      	<footer class="mastfoot mt-auto">
	        	<div class="inner">
	          	<p>&copy; <?=date('Y')?> : <a href="<?=url('index.php')?>">JVRMS</a></p>
	        	</div>
	      	</footer>
    	</div>
    	<?=$header->loadScripts()?>
	</body>
</html>
<?php } ?>