<title>Welcome to Siimanto Website</title>
<div class="container" style="min-height:550px">
<div class="row">
	<div class="col-md-3 col-sm-4"></div>
	<div class="col-md-6 col-sm-4">
		<div class="panel panel-default">
			<div class="panel-heading text-center"><h4>Login System</h4></div>
			<div class="panel-body">
				<?php echo validation_errors('<p class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>','</p>'); if($logged_in){?>
				<div class="alert alert-danger alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?php 
						if($logged_in === 'incorrect_password') echo 'Incorrect password.';
						if($logged_in === 'not_activated') echo 'Your account not actived.';
						if($logged_in === 'not_found') echo 'Username not found, 
							Please <a href=" '.base_url().'registration/">register</a> first.';
						echo '</div>'; }
					?>
				<form action="<?php echo base_url().'member/login/' ?>" method="post">
					<div class="form-group">
						<label for="InputUsername">Username</label>
						<input type="text" value="<?php echo set_value('InputUsername') ?>" class="form-control" name="InputUsername" placeholder="Username">
					</div>
					<div class="form-group">
						<label for="InputPassword">Password</label>
						<input type="password" value="<?php echo set_value('InputPassword') ?>" class="form-control" name="InputPassword" placeholder="Password">
					</div>
					<div class="">
						<a class="" href="">Forgot Password?</a>
						<input class="pull-right btn btn-success" type="submit" value="Login">
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-4"></div>
</div>
</div>