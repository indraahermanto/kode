<title>Siimanto | Provider</title>
<div class="container" style="min-height:550px">
	<br/>
	<?php 
	if(isset($this->session->msg)){
		if(isset($this->session->class))
			$class = 'alert-danger';
		else $class = 'alert-info';
		echo '
		<div class="alert '.$class.' alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>'.$this->session->msg.'
		</div>';
		unset($this->session->msg);
		unset($this->session->class);
	}
	?>
	<div class="panel panel-default">
		<h2 class="text-center">Edit Provider</h2>
		<div class="panel-body">
			<div class="" role="alert">
				<form action="<?php echo base_url().'provider/edit/'.$provider->opr_id; ?>" method="post">
					<div class="col-sm-6">
						<label for="InputCode">Provider Code</label>
						<input type="text" value="<?php if(validation_errors()) echo set_value('InputCode'); else echo $provider->opr_kode; ?>" class="form-control" name="InputCode">
						<span><small class="text-danger"><?php echo form_error('InputCode') ?>&nbsp;</small></span>
					</div>
					<div class="col-sm-6">
						<label for="InputName">Provider Name</label>
						<input type="text" maxlength="10" value="<?php if(validation_errors()) echo set_value('InputName'); else echo $provider->opr_nama ?>" class="form-control" name="InputName" placeholder="Provider Name">
						<span><small class="text-danger"><?php echo form_error('InputName') ?>&nbsp;</small></span>
					</div>
					<div class="col-sm-6">
						<label for="InputGroup">Group</label>
						<select name="InputGroup" class="form-control">
							<option value="">Select Group</option>
							<option value="G" <?php if($provider->opr_grup == 'G') echo 'selected' ?> >GSM</option>
							<option value="C" <?php if($provider->opr_grup == 'C') echo 'selected' ?> >CDMA</option>
						</select>
						<span><small class="text-danger"><?php echo form_error('InputGroup') ?>&nbsp;</small></span>
					</div>
					<div class="col-sm-6">
						<label for="InputStat">Status</label>
						<select name="InputStat" class="form-control">
							<option value="">Select Status</option>
							<option value="1" <?php if($provider->opr_stat == 1) echo 'selected' ?>>Ready</option>
							<option value="0" <?php if($provider->opr_stat == 0) echo 'selected' ?>>Closed</option>
						</select>
						<span><small class="text-danger"><?php echo form_error('InputStat') ?>&nbsp;</small></span>
					</div>
					<button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-ok"><strong> Save</strong></span></button>
					<a href="<?php echo base_url().'pulsa' ?>"><span class="glyphicon glyphicon-chevron-left"></span>Back to product</a>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	
</script>