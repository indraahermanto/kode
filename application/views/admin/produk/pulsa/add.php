<?php if(validation_errors()) $form_input = 'form-input-false'; else $form_input = 'form-input-true'; ?>
<title>Siimanto | Product</title>
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
	}?>
	<div class="col-sm-6 panel panel-default">
		<h2 class="text-center">Add Product</h2>
		<div class="panel-body">
			<form action="<?php echo base_url().'pulsa/add/' ?>" method="post">
				<div class="col-sm-6">
					<label for="InputCode">Product Code</label>
					<input type="text" maxlength="13" value="<?php if(validation_errors()) echo set_value('InputCode') ?>" class="form-control" id="InputCode" name="InputCode" readonly>
					<span><small class="text-danger"><?php echo form_error('InputCode') ?>&nbsp;</small></span>
				</div>
				<div class="col-sm-6">
					<label for="InputProv">Provider</label>
					<select name="InputProv" id="InputProv" class="form-control">
						<option value="">Select Provider</option>
						<?php foreach ($daftar_provider as $provider) { ?>
							<option value="<?php echo $provider->opr_kode ?>"><?php echo $provider->opr_nama ?></option>
						<?php } ?>
					</select>
					<span><small class="text-danger"><?php echo form_error('InputProv') ?>&nbsp;</small></span>
				</div>
				<div id="<?php echo $form_input ?>">
				<div class="col-sm-6">
					<label for="InputNom">Product Nominal</label>
					<input type="text" maxlength="8" value="<?php if(validation_errors()) echo set_value('InputNom') ?>" class="form-control" name="InputNom" id="InputNom" placeholder="Nominal">
					<span><small class="text-danger"><?php echo form_error('InputNom') ?>&nbsp;</small></span>
				</div>
				<div class="col-sm-6">
					<label for="InputProfit">Product Profit</label>
					<input type="text" value="<?php if(validation_errors()) echo set_value('InputProfit') ?>" class="form-control" name="InputProfit" id="InputProfit" readonly>
					<span><small class="text-danger"><?php echo form_error('InputProfit') ?>&nbsp;</small></span>
				</div>
				<div class="col-sm-6">
					<label for="InputCost">Product Cost</label>
					<input type="text" maxlength="8" value="<?php if(validation_errors()) echo set_value('InputCost') ?>" class="form-control" name="InputCost" id="InputCost" placeholder="Cost">
					<span><small class="text-danger"><?php echo form_error('InputCost') ?>&nbsp;</small></span>
				</div>
				<div class="col-sm-6">
					<label for="InputPrice">Product Price</label>
					<input type="text" maxlength="8" value="<?php if(validation_errors()) echo set_value('InputPrice') ?>" class="form-control" name="InputPrice" id="InputPrice" placeholder="Price">
					<span><small class="text-danger"><?php echo form_error('InputPrice') ?>&nbsp;</small></span>
				</div>
				<div class="col-sm-6">
					<label for="InputStat">Status</label>
					<select name="InputStat" id="InputStat" class="form-control">
						<option value="">Select Status</option>
						<option value="1">Ready</option>
						<option value="0">Closed</option>
					</select>
					<span><small class="text-danger"><?php echo form_error('InputStat') ?>&nbsp;</small></span>
				</div>
				<div class="col-sm-6">
					<br/>
					<br/>
					<br/>
					<br/>
					<br/><br/>
				</div>
				<button type="submit" class="btn btn-success pull-right">Add Product</button>
				<a href="<?php echo base_url().'pulsa' ?>"><span class="glyphicon glyphicon-chevron-left"></span>Back to product</a>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url().'assets/js/product/pulsa/add.js' ?>"></script>
<script src="<?php echo base_url().'assets/js/autonumeric/autoNumeric.js' ?>" type="text/javascript"></script>