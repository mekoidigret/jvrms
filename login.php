<?php
	require 'config/initialize.inc';

	$header = new Header(array(
		'title' => 'Login'
	));

	if(isset($_POST['submit'])) {
		$user = User::authenticate($_POST['username'], $_POST['password']);
		if($user['status']) {
			$session->message($user['message'], 'success');
			$data = $user['data'];
			$session->login($data);
		}
		else {
			$session->message($user['message'], 'danger');
		}
	}

	$msg = $session->message();
	$message = empty($msg) ? 'Please fill the form below.' : $msg;
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
	            		<a class="nav-link" href="<?=url('index.php')?>">Home</a>
	            		<a class="nav-link active" href="<?=url('login.php')?>">Login</a>
	            		<a class="nav-link" href="<?=url('features.php')?>">Features</a>
	            		<a class="nav-link" href="<?=url('contact.php')?>">Contact</a>
	          		</nav>
	        	</div>
	      	</header>
<?php } ?>
	      	<main id="container" class="inner cover" role="main">
	      		<h3 class="cover-heading">Login</h3>
	      		<p class="lead">
	        		<?=$message?>
	        	</p>
	        	<form action="login.php" method="post">
	        		<span>Username:</span><br />
	        		<input type="text" name="username" placeholder="Username" class="form-control-sm" required="">
	        		<br />
	        		<span>Password:</span><br />
	        		<input type="password" name="password" placeholder="Password" class="form-control-sm" required="">
	        		<br /><br />
	        		<input type="submit" name="submit" class="btn btn-dark btn-sm" value="Login">
	        	</form>
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