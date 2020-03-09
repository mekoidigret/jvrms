<?php
	require '../config/initialize.inc';

	$header = new Header(array(
		'title' => 'Officers'
	));

	$session->check(Officer::LEVEL);

	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$per_page = 10;
	$total_count = $db->search(Officer::TABLE_NAME, array(
		'access_level' => Officer::LEVEL
	), 'count');
	$pagination = new Pagination($page, $per_page, $total_count);

	$officers = Officer::findAll($pagination);
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
		            		<a class="nav-link active" href="<?=url('officer/index.php')?>">Officers</a>
		            		<a class="nav-link" href="<?=url('officer/inmates.php')?>">Inmates</a>
		            		<a class="nav-link" href="<?=url('officer/logs.php')?>">Logs</a>
		            		<a class="nav-link logout" href="<?=url('logout.php')?>">Logout</a>
		          		</nav>
		        	</div>
	      	</header>
<?php } ?>
			<main id="container" class="text-left">
				<p id="message-pane">
					<?=$session->message()?>
				</p>
				<h4>Officers</h4>
				<?php if($officers) { ?>
					<table class="table table-sm text-light">
						<thead>
							<tr>
								<th>ID</th>
								<th>Username</th>
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