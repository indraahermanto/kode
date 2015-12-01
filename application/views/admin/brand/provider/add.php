<title>Siimanto | Provider</title>
<div class="container" style="min-height:550px">
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
	}
	?>
	<div class="panel panel-default">
		<h2 class="text-center">Add Provider</h2>
		<div class="panel-body">
			<div class="" role="alert">
				<form action="<?php echo base_url().'provider/add/' ?>" method="post">
					<div class="col-sm-6">
						<label for="InputCode">Provider Code</label>
						<input type="text" maxlength="4" value="<?php if(validation_errors()) echo set_value('InputCode') ?>" class="form-control" name="InputCode" placeholder="Provider Code">
						<span><small class="text-danger"><?php echo form_error('InputCode') ?>&nbsp;</small></span>
					</div>
					<div class="col-sm-6">
						<label for="InputName">Provider Name</label>
						<input type="text" maxlength="10" value="<?php if(validation_errors()) echo set_value('InputName') ?>" class="form-control" name="InputName" placeholder="Provider Name">
						<span><small class="text-danger"><?php echo form_error('InputName') ?>&nbsp;</small></span>
					</div>
					<div class="col-sm-6">
						<label for="InputGroup">Group</label>
						<select name="InputGroup" class="form-control">
							<option value="">Select Group</option>
							<option value="G">GSM</option>
							<option value="C">CDMA</option>
						</select>
						<span><small class="text-danger"><?php echo form_error('InputGroup') ?>&nbsp;</small></span>
					</div>
					<div class="col-sm-6">
						<label for="InputStat">Status</label>
						<select name="InputStat" class="form-control">
							<option value="">Select Status</option>
							<option value="1">Ready</option>
							<option value="0">Closed</option>
						</select>
						<span><small class="text-danger"><?php echo form_error('InputStat') ?>&nbsp;</small></span>
					</div>
					<button type="submit" class="btn btn-success pull-right">Add Provider</button>
					<a href="<?php echo base_url().'provider' ?>"><span class="glyphicon glyphicon-chevron-left"></span>Back to product</a>
				</form>
			</div>
		</div>
	</div>
</div>