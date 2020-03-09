<?php
	require 'config/initialize.inc';

	$header = new Header(array(
		'title' => 'Home'
	));

	if(isset($_SESSION['user_access_level'])) {
		switch($_SESSION['user_access_level']) {
			case Officer::LEVEL:
				redirect('officer');
				break;
			case Admin::LEVEL:
				redirect('admin');
				break;
		}
	}
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
		            		<a class="nav-link active" href="<?=url('index.php')?>">Home</a>
		            		<a class="nav-link" href="<?=url('login.php')?>">Login</a>
		            		<a class="nav-link" href="<?=url('features.php')?>">Features</a>
		            	</nav>
		        	</div>
	      	</header>
<?php } ?>

	      	<main id="container" class="inner cover" role="main">
	        	<h3 class="cover-heading">Jail Visitor Record Management System</h3>
	        	<p class="lead">
	        		Track every visit for inmates with precise accuracy and efficiency.
	        	</p>
	      	</main>
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