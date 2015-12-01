<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/style/bootstrap.css' ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/style/bootstrap.min.css' ?>">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-2.1.4.min.js' ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-ui.js' ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.min.js' ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/js/header.js' ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-number/jquery.number.js' ?>"></script>
</head>
<body>
<!-- Header Website -->
<div id="navbar">
	<nav class="navbar navbar-default">
		<div class="container-fluid container">
		<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
			<a class="navbar-brand" href="<?php echo base_url() ?>">
				<span>
					<h4>Siimanto System
						<h6><small>BETA</small></h6>
					</h4>
				</span>
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
				<?php if($logged_in) { ?>
					<li><a href="<?php echo base_url().'pulsa' ?>">Pulsa</a></li>
					<li><a href="<?php echo base_url().'transaction' ?>">Transaction</a></li>
					<li><a href="<?php echo base_url().'manage_user' ?>">Manage User</a></li>
					<li><a href="<?php echo base_url().'member/logout' ?>">Logout</a></li>
				<?php } else { ?>
					<li><a href="<?php echo base_url().'member/' ?>">Login</a></li>
					<li><a href="<?php echo base_url().'registration/' ?>">Register</a></li>
					<?php } ?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</div>