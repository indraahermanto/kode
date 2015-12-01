<title>Siimanto | Transaction</title>
<div class="container" style="min-height:550px">
	<br/>
	<?php 
	if(isset($this->session->msg)){
		echo '
		<div class="alert alert-info alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button><span class="glyphicon glyphicon-ok">&nbsp;</span>'.$this->session->msg.'
		</div>';
		echo "<input type='hidden' value='a".$this->session->msg."' id='msg'>";
		unset($this->session->msg);
	}elseif (isset($this->session->war)) {
		echo '
		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button><span class="glyphicon glyphicon-remove">&nbsp;</span>'.$this->session->war.'
		</div>';
		unset($this->session->war);
	}
	$cost = $transaksi->produk_cost;
	$price = $transaksi->produk_price;
	$profit = $transaksi->produk_profit;
	$code = $transaksi->produk_kode;
	$nomor = $transaksi->nomor;
	$readonly = 'readonly';
	switch ($transaksi->trx_type) {
		case '100':
			$type = 'Cash';
			break;

		case '200':
			$type = 'Bank';
			break;

		case '300':
			$type = 'Waiting Payment';
			break;

		case '400':
			$type = 'Transfer';
			$cost = '-';
			$profit = '-';
			$nomor = '-';
			$code = '-';
			break;

		case '500':
			$type = 'Deposit';
			$price = '-';
			$profit = '-';
			$nomor = '-';
			$code = '-';
			break;

		case '600':
			$type = 'Manage Saldo';
			$cost = '-';
			$price = '-';
			$nomor = '-';
			$code = '-';
			$readonly = '';
			break;

		case '610':
			$type = 'Manage Saldo';
			$cost = '-';
			$price = '-';
			$nomor = '-';
			$code = '-';
			$readonly = '';
			break;

		case '650':
			$type = 'Manage Saldo';
			$cost = '-';
			$price = '-';
			$nomor = '-';
			$code = '-';
			$readonly = '';
			break;
		
		default:
			
			break;
	}
	?>
	<div class="col-sm-2"></div>
	<div class="col-sm-8 panel panel-default">
		<h2 class="text-center">Edit Transaction</h2>
		<div class="panel-body">
			<div class="col-md-1"></div>
				<form method="post" class="col-md-10">
				<div class="row">
					<div class="col-sm-6">
						<label for="InputID">ID Transaction</label>
						<input type="text" maxlength="13" name="InputID" value="<?php echo $transaksi->trx_id ?>" class="form-control text-center" readonly>
					</div>
					<div class="col-sm-6">
						<label for="InputUser">Username</label>
						<input type="text" value="<?php echo $transaksi->user_uid ?>" class="form-control text-center" readonly>
					</div>
				</div><br/>
				<div class="row">
					<div class="col-sm-6">
						<label for="InputPhone">Phone Number</label>
						<input type="text" value="<?php echo $nomor ?>" class="form-control text-center" readonly>
					</div>
					<div class="col-sm-6">
						<label for="InputCode">Code</label>
						<input type="text" value="<?php echo $code ?>" class="form-control text-center" readonly>
					</div>
				</div><br/>
				<div class="row">
					<div class="col-sm-6">
						<label for="InputCost">Cost</label>
						<input name="InputCost" <?php if($transaksi->trx_stat == 0) echo 'disabled' ?> id="InputCost" maxlength="10" type="text" <?php if($cost == '-') echo 'readonly' ?> value="<?php echo $cost ?>" class="form-control text-center">
					</div>
					<div class="col-sm-6">
						<label for="InputPrice">Price</label>
						<input name="InputPrice" <?php if($transaksi->trx_stat == 0) echo 'disabled' ?> maxlength="10" id="InputPrice" type="text" <?php if($price == '-') echo 'readonly' ?> value="<?php echo $price ?>" class="form-control text-center">
					</div>
				</div><br/>
				<div class="row">
					<div class="col-sm-6">
						<label for="InputProfit">Profit</label>
						<input name="InputProfit" <?php if($transaksi->trx_stat == 0) echo 'disabled' ?> maxlength="10" id="InputProfit" <?php echo $readonly ?> type="text" class="form-control text-center">
					</div>
					<div class="col-sm-6">
						<label for="Type">Type</label>
						<input type="text" value="<?php echo $type ?>" class="form-control text-center" readonly>
						<input type="hidden" name="InputPay" value="<?php echo $transaksi->trx_type ?>" class="form-control text-center" readonly>
					</div>
				</div><br/>
				<div class="row">
					<div class="col-sm-6">
						<a href="<?php echo base_url().'transaction/' ?>">
						Back to transaction
						</a>
					</div>
					<div class="col-sm-6">
						<input type="submit" name="submit" <?php if($transaksi->trx_stat == 0) echo 'disabled' ?> class="btn btn-danger" style="max-width:150px" value="Cancel Transaction">
						<input type="submit" name="submit" disabled class="form-control pull-right btn btn-success" style="max-width:75px" value="Save">
					</div>
				</div>
				</form>
				<div class="col-md-1"></div>
			</div>
	</div>
	<div class="col-sm-2"></div>
</div>
<script type="text/javascript">
	$(function() {
		var cost = $('#InputCost').val();
		var price = $('#InputPrice').val();
		
		if(cost == '-' || price == '-'){
			$('#InputProfit').val('-');
		}else {
			$('#InputProfit').number(true);
			var profit = price - cost;
			if(!$.isNumeric(profit))
				$('#InputProfit').val('-');
			else $('#InputProfit').val(profit);
		}
		
		$('#InputCost').change(function(){
			cost = $('#InputCost').val();
			price = $('#InputPrice').val();
			profit = $('#InputProfit').val();
			if(price != "-"){
				profit = price - cost;
				if(profit > 0){
					$('.btn-success').prop('disabled', false);
					$('#InputProfit').val(profit);
				}else{
					alert("Sorry profit must be greater than zero.");
					$('#InputProfit').val(0);
				}	
			}else
				$('.btn-success').prop('disabled', false);
		});

		$('#InputPrice').change(function(){
			cost = $('#InputCost').val();
			price = $('#InputPrice').val();
			profit = $('#InputProfit').val();
			if(cost != "-"){
				profit = price - cost;
				if(profit > 0){
					$('.btn-success').prop('disabled', false);
					$('#InputProfit').val(profit);
				}else{
					alert("Sorry profit must be greater than zero.");
					$('#InputProfit').val(0);
				}	
			}else
				$('.btn-success').prop('disabled', false);
		});

		$('#InputProfit').change(function(){
			if($('#InputProfit').val() > 0){
				$('.btn-success').prop('disabled', false);
			}
		});
	})
</script>