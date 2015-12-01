<title>Siimanto | Manage User</title>
<div class="container" style="min-height:550px">
<div class="col-md-2"></div>
	<div class="col-md-8">
	<br/>
	<?php 
	if(isset($this->session->msg)){
		echo '
		<div class="alert alert-info alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>'.$this->session->msg.'
		</div>';
		unset($this->session->msg);
	}?>
	<div>
		<h2 class="text-center">Manage User</h2>
	</div>
	<br/><br/><br/>
	<?php 
		foreach ($users as $user) { 
		if(validation_errors()) $group = set_value('Group');
		if(validation_errors()) $level = set_value('Level');
	?>
	<form action="<?php echo base_url().'manage_user/edit/'.$user_uid; ?>" method="POST">
		<div class="col-sm-6">
			<label for="InputUsername">Username</label>
			<input type="text" disabled value="<?php echo $user->user_uid ?>" class="form-control" name="InputUsername" placeholder="Username">
			<small class="text-danger">&nbsp;</small>
		</div>
		<div class="col-sm-6">
			<label for="InputEmail">Email Address</label>
			<input type="email" value="<?php echo $user->user_email ?>" class="form-control" name="InputEmail" readonly placeholder="Email">
			<small class="text-danger">&nbsp;</small>
		</div>
		<div class="col-sm-6">
			<label for="FName">First Name</label>
			<input type="text" value="<?php if(validation_errors()) echo set_value('FName');  else echo $user->user_fname ?>" class="form-control" name="FName" placeholder="First Name">
			<small class="text-danger"><?php if(validation_errors()) echo form_error('FName') ?>&nbsp;</small>
		</div>
		<div class="col-sm-6">
			<label for="LName">Last Name</label>
			<input type="text" value="<?php if(validation_errors()) echo set_value('LName');  else echo $user->user_lname ?>" class="form-control" name="LName" placeholder="Last Name">
			<small class="text-danger"><?php if(validation_errors()) echo form_error('LName') ?>&nbsp;</small>
		</div>
		<div class="col-sm-6">
			<label for="Group">Group</label>
			<select name="Group" class="form-control">
				<option value="" selected="selected">Select group</option>
				<option <?php if(isset($group) && $group == ''); else if(isset($group) && $group == 'depok') echo 'SELECTED'; else if($user->user_group == 'depok') echo 'SELECTED' ?> value="depok">DEPOK</option>
				<option <?php if(isset($group) && $group == ''); else if(isset($group) && $group == 'rmk') echo 'SELECTED'; if($user->user_group == 'rmk') echo 'SELECTED' ?> value="rmk">RMK</option>
				<option <?php if(isset($group) && $group == ''); else if(isset($group) && $group == 'rumah') echo 'SELECTED'; else if($user->user_group == 'rumah') echo 'SELECTED' ?> value="rumah">RUMAH</option>
				<option <?php if(isset($group) && $group == ''); else if(isset($group) && $group == 'smk') echo 'SELECTED'; if($user->user_group == 'smk') echo 'SELECTED' ?> value="smk">SMK</option>
				<option <?php if(isset($group) && $group == ''); else if(isset($group) && $group == 'unpam') echo 'SELECTED'; if($user->user_group == 'unpam') echo 'SELECTED' ?> value="unpam">UNPAM</option>
			</select>
			<small class="text-danger"><?php if(validation_errors()) echo form_error('Group') ?>&nbsp;</small>
		</div>
		<div class="col-sm-6">
			<label for="Level">Level</label>
			<select name="Level" class="form-control">
				<option value="" selected="selected">Select level</option>
				<option <?php if(isset($level) && $level == ''); else if(isset($level) && $level == 'admin') echo 'SELECTED'; else if($user->user_lvl == 'admin') echo 'SELECTED' ?> value="admin">ADMIN</option>
				<option <?php if(isset($level) && $level == ''); else if(isset($level) && $level == 'cust') echo 'SELECTED'; else if($user->user_lvl == 'cust') echo 'SELECTED' ?> value="cust">CUST</option>
			</select>
			<small class="text-danger"><?php if(validation_errors()) echo form_error('Level') ?>&nbsp;</small>
		</div>
		<div class="col-sm-6">
			<label for="Phone">Primary Phone Number</label>
			<input type="text" value="<?php if(validation_errors()) echo set_value('Phone');  else echo $user->user_lname ?>" class="form-control" name="Phone">
			<small class="text-danger"><?php if(validation_errors()) echo form_error('Phone') ?>&nbsp;</small>
		</div>
		<div class="col-sm-6">
			<br/><br/><br/><br/>
		</div>

		<div class="col-sm-1">
			<a href="<?php echo base_url('manage_user') ?>" class="glyphicon glyphicon-chevron-left">Back</a>
		</div>
		<div class="col-sm-9"></div>
		<div class="col-sm-1">
			<button type="submit" class="btn btn-success">Update</button>
		</div>
		<?php } ?>
	</form>
	</div>
</div>
</div>
<br/><br/>