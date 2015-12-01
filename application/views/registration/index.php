<title>Siimanto | Register</title>
<div class="container" style="min-height:550px">
<div class="col-md-2"></div>
	<div class="col-md-8">
		<h1>Registration Form</h1>
		<br/>
		<form action="<?php echo base_url().'registration/register'; ?>" method="POST">
			<div class="col-sm-6">
				<label for="InputUsername">Username</label>
				<input type="text" value="<?php echo set_value('InputUsername') ?>" class="form-control" name="InputUsername" placeholder="Username">
				<small class="text-danger"><?php echo form_error('InputUsername') ?>&nbsp;</small>
			</div>
			<div class="col-sm-6">
				<label for="InputEmail">Email Address</label>
				<input type="email" value="<?php echo set_value('InputEmail') ?>" class="form-control" name="InputEmail" placeholder="Email">
				<small class="text-danger"><?php echo form_error('InputEmail') ?>&nbsp;</small>
			</div>
			<div class="col-sm-6">
				<label for="InputPassword">Password</label>
				<input type="password" value="<?php echo set_value('InputPassword') ?>" class="form-control" name="InputPassword" placeholder="Password">
				<small class="text-danger"><?php echo form_error('InputPassword') ?>&nbsp;</small>
			</div>
			<div class="col-sm-6">
				<label for="InputPasswordConf">Confirm Password</label>
				<input type="password" value="<?php echo set_value('InputPasswordConf') ?>" class="form-control" name="InputPasswordConf" placeholder="Confirm Password">
				<small class="text-danger"><?php echo form_error('InputPasswordConf') ?>&nbsp;</small>
			</div>
			<div class="col-sm-6">
				<label for="FName">First Name</label>
				<input type="text" value="<?php echo set_value('FName') ?>" class="form-control" name="FName" placeholder="First Name">
				<small class="text-danger"><?php echo form_error('FName') ?>&nbsp;</small>
			</div>
			<div class="col-sm-6">
				<label for="LName">Last Name</label>
				<input type="text" value="<?php echo set_value('LName') ?>" class="form-control" name="LName" placeholder="Last Name">
				<small class="text-danger"><?php echo form_error('LName') ?>&nbsp;</small>
			</div>
			<div class="col-sm-6">
				<label for="Group">Group</label>
				<select name="Group" class="form-control">
					<option value="" selected="selected">Select your group</option>
					<option value="depok">DEPOK</option>
					<option value="rmk">RMK</option>
					<option value="rumah">RUMAH</option>
					<option value="smk">SMK</option>
					<option value="unpam">UNPAM</option>
				</select>
				<small class="text-danger"><?php echo form_error('Group') ?>&nbsp;</small>
			</div>
			<div class="col-sm-6">
				<label for="InputNomor">Phone Number</label>
				<input type="text" maxlength="13" value="<?php echo set_value('InputNomor') ?>" class="form-control" name="InputNomor" placeholder="Phone Number">
				<small class="text-danger"><?php echo form_error('InputNomor') ?>&nbsp;</small>
			</div>
			<button type="submit" class="btn btn-default">Register</button>
		</form>
	</div>
<div class="col-md-2"></div>
</div>

<br/>