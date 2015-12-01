<title>Siimanto | Edit Product</title>
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
		<h2 class="text-center">Edit Product <?php echo $data_produk->produk_kode ?></h2>
		<div class="panel-body">				
			<div class="" role="alert">
				<form action="<?php echo base_url().'pulsa/edit/'.$data_produk->produk_id ?>" method="post">
					<div class="col-sm-6">
						<label for="InputCode">Product Code</label>
						<input type="text" maxlength="13" value="<?php echo $data_produk->produk_kode ?>" class="form-control" id="InputCode" name="InputCode" readonly>
					</div>
					<div class="col-sm-6">
						<label for="InputProfit">Product Profit</label>
						<input type="text" value="<?php if(validation_errors()) echo set_value('InputProfit'); else echo $data_produk->produk_un; ?>" class="form-control" name="InputProfit" id="InputProfit" readonly>
						<span><small class="text-danger"><?php echo form_error('InputProfit') ?>&nbsp;</small></span>
					</div>
					<div id="form-input-false">
					<div class="col-sm-6">
						<label for="InputCost">Product Cost</label>
						<input type="text" maxlength="8" value="<?php if(validation_errors()) echo set_value('InputCost'); else  echo $data_produk->produk_hb; ?>" class="form-control" name="InputCost" id="InputCost" placeholder="Cost">
						<span><small class="text-danger"><?php echo form_error('InputCost') ?>&nbsp;</small></span>
					</div>
					<div class="col-sm-6">
						<label for="InputPrice">Product Price</label>
						<input type="text" maxlength="8" value="<?php if(validation_errors()) echo set_value('InputPrice'); else echo $data_produk->produk_hj; ?>" class="form-control" name="InputPrice" id="InputPrice" placeholder="Price">
						<span><small class="text-danger"><?php echo form_error('InputPrice') ?>&nbsp;</small></span>
					</div>
					<div class="col-sm-6">
						<label for="InputNom">Product Nominal</label>
						<input type="text" readonly value="<?php echo $data_produk->produk_nom ?>" class="form-control" name="InputNom" id="InputNom">
					</div>
					<div class="col-sm-6">
						<label for="InputStat">Status</label>
						<select name="InputStat" id="InputStat" class="form-control">
							<option value="">Select Status</option>
							<option value="1" <?php if($data_produk->produk_stat == 1) echo 'selected' ?>>Ready</option>
							<option value="0" <?php if($data_produk->produk_stat == 0) echo 'selected' ?>>Closed</option>
						</select>
						<span><small class="text-danger"><?php echo form_error('InputStat') ?>&nbsp;</small></span>
					</div>
					<button type="submit" class="pull-right btn btn-success">Save Product</button>
					<button class="btn btn-link" type="button" onclick="goBack()">
						<span class="glyphicon glyphicon-chevron-left"></span>Back to product
					</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url().'assets/js/product/pulsa/edit.js' ?>"></script>
<script src="<?php echo base_url().'assets/js/autonumeric/autoNumeric.js' ?>" type="text/javascript"></script>