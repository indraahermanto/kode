<title>Siimanto | Setup</title>
<div class="container" style="min-height:550px">
	<?php 
	if(isset($this->session->msg)){
		echo '
		<div class="alert alert-info alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>'.$this->session->msg.'
		</div>';
		unset($this->session->msg);
	}elseif (isset($this->session->war)) {
		echo '
		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>'.$this->session->war.'
		</div>';
		unset($this->session->war);
	}?>
	<br/><br/>
	<form method="POST">
	<div class="col-md-2"></div>
	<div class="col-md-8">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="text-center">First Setup</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-1"></div>
				<div class="col-sm-5 form-group">
					<label for="InputBank">Bank</label>
					<input type="text" class="form-control" name="InputBank" placeholder="Bank">
					<small class="text-danger"><?php echo form_error('InputBank') ?>&nbsp;</small>
				</div>
				<div class="col-sm-5 form-group">
					<label for="InputCash">Cash</label>
					<input type="text" class="form-control" name="InputCash" placeholder="Cash">
					<small class="text-danger"><?php echo form_error('InputCash') ?>&nbsp;</small>
				</div>
				<div class="col-sm-1"></div>
			</div>
			<div class="row">
				<div class="col-sm-1"></div>
				<div class="col-sm-5 form-group">
					<label for="InputToped">Tokopedia</label>
					<input type="text" class="form-control" name="InputToped" placeholder="Tokopedia">
					<small class="text-danger"><?php echo form_error('InputToped') ?>&nbsp;</small>
				</div>
				<div class="col-sm-5 form-group">
					<label for="InputPulsa">Pulsa</label>
					<input type="text" class="form-control" name="InputPulsa" placeholder="Pulsa">
					<small class="text-danger"><?php echo form_error('InputPulsa') ?>&nbsp;</small>
				</div>
				<div class="col-sm-1"></div>
			</div>
			<div class="row">
				<div class="col-sm-1"></div>
				<div class="col-sm-5 form-group">
					<label for="InputHut">Hutang</label>
					<input type="text" class="form-control" name="InputHut" placeholder="Hutang">
					<small class="text-danger"><?php echo form_error('InputHut') ?>&nbsp;</small>
				</div>
				<div class="col-sm-5 form-group">
					<!-- Free -->
				</div>
				<div class="col-sm-1"></div>
			</div>
			<div class="row">
				<div class="col-sm-1"></div>
				<div class="col-sm-10">
					<small>Note : If empty please input 0</small>
					<button name="submit" type="submit" class="btn btn-success pull-right">Set Now!</button>
				</div>
				<div class="col-sm-1"></div>
			</div>
		</div>
	</div>
	</div>
	<div class="col-md-2"></div>
	</form>
</div>
<br/><br/>