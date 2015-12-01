<?php
	$sql = mysql_query("SELECT MIN(trx_date) AS mdate FROM str_trx");
	$min_date = mysql_fetch_assoc($sql);
?>
<title>Siimanto | Transaction</title>
<div class="container" style="min-height:550px; min-width:350px;">
	<br/>
	<?php 
	if(isset($this->session->msg)){
		echo '
		<div class="alert alert-info alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button><span class="glyphicon glyphicon-ok">&nbsp;</span>'.$this->session->msg.'
		</div>';
		unset($this->session->msg);
	}elseif (isset($this->session->war)) {
		echo '
		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button><span class="glyphicon glyphicon-remove">&nbsp;</span>'.$this->session->war.'
		</div>';
		unset($this->session->war);
	}?>
	<h2 class="text-center">Transaction</h2>
	<br/>
	<div class="row">
	<div class="col-sm-4 col-xs-5">
		<ul class="list-unstyled list-inline">
			<li><a href="">Pulsa <?php echo number_format($saldo[0]) ?></a></li>
			<li><a href="">Tokopedia <?php //echo number_format($saldo[1]) ?></a></li>
			<li><a href="<?php echo base_url('payment') ?>">Piutang <?php echo number_format($saldo[2]) ?></a></li>
		</ul>
	</div>
	<div class="col-sm-4 col-xs-2"></div>
	<div class="col-sm-4 col-xs-5">
		<ul class="list-unstyled list-inline">
			<li><a href="">Bank <?php echo number_format($saldo[3]) ?></a></li>
			<li><a href="">Cash <?php echo number_format($saldo[4]) ?></a></li>
			<li><a href="">Modal <?php echo number_format($saldo[5]) ?></a></li>
		</ul>
	</div>
	</div>
	<div class="row text-center">
		<a href="<?php echo base_url().'pulsa/buy' ?>" class="btn btn-info">
			Buy Pulsa
		</a>
		<a href="<?php echo base_url().'transaction/buy' ?>" class="btn btn-success">
			Buy Goods
		</a>
		<button type="button" class="btn btn-warning" id="m_saldo" data-toggle="modal" data-target="#manage_saldo" data-backdrop="static" data-keyboard="false">
			Management Saldo
		</button>
	</div>
	<br/>
	<div class="row panel panel-default">
		<div class="panel-body">
		<form class="form-group">
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<label>Search</label>
					<input type="text" class="input-sm form-control" placeholder="User ID or Name or Number....." name="key" />
				</div>
				<div class="col-md-3 col-sm-6">
					<label>Group</label>
					<select name="group" class="form-control input-sm">
						<option value="">Select Group</option>
					</select>
				</div>
				<div class="col-md-3 col-sm-6">
					<label>Date</label>
					<div class="input-daterange input-group" id="datepicker">
					    <input type="text" class="input-sm form-control" placeholder="From" name="tstart" />
					    <span class="input-group-addon">to</span>
					    <input type="text" class="input-sm form-control" placeholder="To" name="tend" />
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<label>Payment Date</label>
					<div class="input-daterange input-group" id="datepicker">
					    <input type="text" class="input-sm form-control" placeholder="From" name="pstart" />
					    <span class="input-group-addon">to</span>
					    <input type="text" class="input-sm form-control" placeholder="To" name="pend" />
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<label>Provider</label>
					<select name="provider" class="form-control input-sm">
						<option value="">Select Provider</option>
					</select>
				</div>
				<div class="col-md-3 col-sm-6">
					<label>Status</label>
					<select name="stat" class="form-control input-sm">
						<option value="">Select Status</option>
					</select>
				</div>
			</div>
			<button type="submit" class="btn btn-default pull-right" name="search">
				Search
			</button>
			</form>
		</div>
	</div>
	<br/><br/>
	<div class="row table-responsive">
		<table class="table table-trx table-bordered table-striped table-condensed table-hover">
			<thead>
			<tr class="thead">
				<th class="text-center">No.</th>
				<th class="text-center">Date/Time</th>
				<th class="text-center" style="min-width:75px">Cust Name</th>
				<th class="text-center">Type</th>
				<th class="text-center hidden-xs">Group</th>
				<th class="text-center">Code</th>
				<th class="text-center hidden-xs">Phone Number</th>
				<th class="text-center">Cost</th>
				<th class="text-center hidden-xs">Price</th>
				<th class="text-center profit">Profit</th>
				<th class="text-center hidden-xs">Payment Method</th>
				<th class="text-center">Date Payment</th>
				<th class="text-center">Status</th>
			</tr>
			</thead>
			<tbody>
			<?php

				$urutan = $index+1;
				foreach ($trx as $transaksi) {
					if($transaksi->trx_type > 100 && $transaksi->trx_type < 200){
						$type = 'Setup';
						$stat = 'Completed';
						$payment = "-";
					}else {
						switch ($transaksi->trx_type) {
							case '100':
								$stat = 'Completed';
								$payment = "Cash";
								$type = 'Pulsa';
								break;

							case '200':
								$stat = 'Completed';
								$payment = "Bank";
								$type = 'Pulsa';
								break;

							case '300':
								$stat = 'Waiting Payment';
								$payment = "-";
								$type = 'Pulsa';
								break;

							case '400':
								$stat = 'Completed';
								$payment = "Cash";
								$type = 'Transfer';
								break;

							case '500':
								$stat = 'Completed';
								$payment = "Bank";
								$type = 'Deposit';
								break;

							case '600':
								$stat = 'Completed';
								$payment = "Bank";
								$type = 'Withdraw';
								break;

							case '610':
								$stat = 'Completed';
								$payment = "Cash";
								$type = 'Withdraw';
								break;

							case '650':
								$stat = 'Completed';
								$payment = "-";
								$type = 'Manage Saldo';
								break;

							case '900':
								$stat = 'Waiting Payment';
								$payment = "-";
								$type = "Tokopedia";
						}
						if ($transaksi->trx_stat == 0) {
							$stat = 'Cancelled';
						}
				}
				if($transaksi->nomor == 0) $transaksi->nomor = "-";
				if($transaksi->produk_kode == "") $transaksi->produk_kode = "-";
				if($type != 'Pulsa')
					$username = ucfirst(strtolower($transaksi->user_uid));
				else $username = ucfirst(strtolower($transaksi->user_fname))." ".ucfirst(strtolower($transaksi->user_lname));
			?>
			<tr>
				<td class="text-center"><?php echo $urutan ?></td>
				<td class="text-center">
					<p><?php echo $transaksi->trx_date ?></p>
				</td>
				<td class="text-center" style="min-width:75px">
					<?php
					if($transaksi->trx_stat == 0)
						echo $username;
					else echo "<a href='".base_url().'transaction/edit/'.$transaksi->trx_id."'>".$username."</a>" 
					?>
				</td>
				<td class="text-center"><?php echo $type ?></td>
				<td class="text-center hidden-xs"><?php echo ucfirst(strtolower($transaksi->user_group)) ?></td>
				<td class="text-center"><?php echo $transaksi->produk_kode ?></td>
				<td class="text-center hidden-xs"><?php echo $transaksi->nomor ?></td>
				<td class="text-right <?php if($stat != 'Cancelled' && $type == 'Pulsa') echo 'profit' ?>"><?php echo number_format($transaksi->produk_cost,0,'','.') ?></td>
				<td class="text-right hidden-xs <?php if($stat != 'Cancelled' && $type == 'Pulsa') echo 'profit' ?>"><?php echo number_format($transaksi->produk_price,0,'','.') ?></td>
				<td class="text-right <?php if($stat != 'Cancelled' && ($type != 'Withdraw' || $type != 'Manage Saldo')) echo 'profit' ?>"><?php echo number_format($transaksi->produk_profit,0,'','.') ?></td>
				<td class="text-center hidden-xs"><?php echo $payment ?></td>
				<td class="text-center"><?php if($stat != 'Completed') echo "-"; else echo $transaksi->trx_date_update ?></td>
				<td class="text-center"><?php echo $stat ?></td>
			</tr>
			<?php 
			$urutan++; }
			?>
			</tbody>
			<tfoot>
				<tr class="tfoot">
					<th colspan="3" class="text-center">Sub Total</th>
					<th></th>
					<th class="hidden-xs"></th>
					<th></th>
					<th class="hidden-xs"></th>
					<th class="text-right total"></th>
					<th class="text-right hidden-xs total"></th>
					<th class="text-right total"></th>
					<th></th>
				</tr>
				<tr class="tfoot">
					<th colspan="3" class="text-center">Total</th>
					<th></th>
					<th class="hidden-xs"></th>
					<th></th>
					<th class="hidden-xs"></th>
					<th class="text-right"></th>
					<th class="text-right hidden-xs"></th>
					<th class="text-right"><?php echo number_format($saldo[6]) ?></th>
					<th></th>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="row">
		<?php echo $this->pagination->create_links(); ?>
	</div>
	<br/><br/><br/>
</div>
<!-- Modal management saldo -->
<div class="modal fade" id="manage_saldo" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" style="min-width:330px">
		<div class="modal-content">
			<form method="POST" onsubmit="return formManage(this)">
			<div class="modal-body">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#tab-transfer" id="a-transfer" aria-controls="tab-transfer" role="tab" data-toggle="tab">TRANSFER</a></li>
						<li role="presentation"><a href="#tab-deposit" id="a-deposit" aria-controls="tab-deposit" role="tab" data-toggle="tab">DEPOSIT</a></li>
						<li role="presentation"><a href="#tab-manage" id="a-manage" aria-controls="tab-manage" role="tab" data-toggle="tab">MANAGE</a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="tab-transfer"><br/>
							<label for="InputNom">Nominal</label>
							<input name="InputNom" type="text" class="form-control" size="8" placeholder="Nominal">
							<small class="text-danger">*must numeric & more than 1000</small>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab-deposit"><br/>
							<label for="InputNom">Nominal</label>
							<input name="InputDep" type="text" class="form-control" size="8" placeholder="Nominal">
							<small class="text-danger">*must numeric & more than 1000</small>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab-manage"><br/>
							<select id="InputPay" name="InputPay" class="form-control">
								<option value="">Select Payment</option>
								<option value="bank">Bank</option>
								<option value="cash">Cash</option>
							</select><br/>
							<div id="InputManage">
								<label for="InputNom">Nominal</label>
								<input name="InputManage" type="text" class="form-control" size="8" placeholder="Nominal">
								<small class="text-danger">*must numeric & more than 1000</small>
							</div>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<input type="submit" disabled name="submit" style="max-width:85px" class="btn btn-primary hilang butt_manage" value="Withdraw">
				<input type="submit" disabled name="submit" style="max-width:115px" class="btn btn-success hilang butt_manage" value="Add to Modal">
				<input type="submit" disabled name="submit" id="butt_dep" class="btn btn-success hilang" value="Deposit">
				<input type="submit" disabled name="submit" id="butt_trans" class="btn btn-success hilang" value="Transfer">
				<button id="butt_cancel" class="btn btn-warning" data-dismiss="modal">Cancel</button>
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	var totals=[0,0,0];
	$(document).ready(function(){
		$("#manage_saldo").on('show.bs.modal', function () {
			$("#InputManage").css("display","none");
		});
		$(".hilang").css("display","none");
		$('ul.nav.nav-tabs a').click(function(){
			$(".hilang").hide(500);
			$("input.form-control").val('');
			$(".text-danger").show(500);
			$(".text-danger").html('*must numeric & more than 1000');
		});

		$('input.form-control').keydown(showButton);
		$('input.form-control').focusout(showButton);

		function showButton(){
			var id = $(this).attr('name');
			var val = $(this).val();
			$("#butt_trans").prop('disabled', true);
			$("#butt_dep").prop('disabled', true);
			$(".butt_manage").prop('disabled', true);
			if(val == "" || val.length < 4){
				$(".hilang").css("display","none");
    			$(".text-danger").show(500);
    			$(".text-danger").html('*must numeric & more than 1000');
			} else if($.isNumeric(val)){
				switch (id){
					case 'InputNom':
					$(".hilang").hide(500);
					$.ajax({
				        url: '<?php echo site_url('ajax/check_saldo'); ?>',
				        type: 'POST',
				        data: "type="+id+"&nom="+val,
				        cache: false,
				        success: function(msg){
				        	if(msg == ""){
				        		if(val == "" || val.length < 4){
				        			$(".text-danger").show(500);
				        			$(".text-danger").html('*must numeric & more than 1000');
				        			$(".hilang").hide(500);
				        		}else {
				        			$(".text-danger").hide(500);
				        			$("#butt_trans").show(500);
				        			$("#butt_trans").prop('disabled', false);
				        		} 
				        	} else {
				        		$(".text-danger").show(500);
				        		$(".text-danger").html(msg);
				            }
				        }
				    });
					break;

					case 'InputDep':
					$(".hilang").hide(500);
					$.ajax({
				        url: '<?php echo site_url('ajax/check_saldo'); ?>',
				        type: 'POST',
				        data: "type="+id+"&nom="+val,
				        cache: false,
				        success: function(msg){
				        	if(msg == ""){
				        		if(val == "" || val.length < 4){
				        			$(".text-danger").show(500);
				        			$(".text-danger").html('*must numeric & more than 1000');
				        			$(".hilang").hide(500);
				        		}else {
				        			$(".text-danger").hide(500);
				        			$("#butt_dep").show(500);
				        			$("#butt_dep").prop('disabled', false);
				        		} 
				        	} else {
				        		$(".text-danger").show(500);
				        		$(".text-danger").html(msg);
				            }
				        }
				    });
					break;

					case 'InputManage':
					$(".hilang").hide(500);
					id = $('#InputPay').val();
					$.ajax({
				        url: '<?php echo site_url('ajax/check_saldo'); ?>',
				        type: 'POST',
				        data: "type="+id+"&nom="+val,
				        cache: false,
				        success: function(msg){
				        	if(msg == ""){
				        		if(val == "" || val.length < 4){
				        			$(".text-danger").show(500);
				        			$(".text-danger").html('*must numeric & more than 1000');
				        			$(".hilang").hide(500);
				        		}else {
				        			$(".text-danger").hide(500);
				        			$(".butt_manage").show(500);
				        			$(".butt_manage").prop('disabled', false);
				        		} 
				        	} else {
				        		$(".text-danger").show(500);
				        		$(".text-danger").html(msg);
				            }
				        }
				    });
					break;
				}
			} else {
    			$(".text-danger").show(500);
    			$(".text-danger").html('*must numeric & more than 1000');
				$(".hilang").hide(500);
			}
		};
		
		$('#InputPay').change(function(){
			if($('#InputPay').val() != "")
				$("#InputManage").show(500);
			else $("#InputManage").hide(500);
		});

		$('#butt_cancel').click(function(){
			$(".hilang").css("display","none");
			$('.form-control').val('');
		});

		var $dataRows = $(".table-trx tr:not('.thead, .tfoot')");
		var profit;
    
		$dataRows.each(function() {
			$(this).find('.profit').each(function(i){
				profit = $(this).html().replace('.','');
				totals[i]+=parseInt(profit);
			});
		});
		$(".table-trx th.total").each(function(i){  
			$(this).html(totals[i]).number(true);
		});

		$('.input-daterange').datepicker({
		    format: "yyyy-mm-dd",
		    startDate: "<?php echo substr($min_date['mdate'], 0, 10); ?>",
		    endDate: "today",
		    maxViewMode: 0,
		    todayBtn: "linked",
		    multidateSeparator: 1,
		    todayHighlight: true,
		    toggleActive: true
		});
	});
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap-datepicker-1.5.0/css/bootstrap-datepicker.standalone.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap-datepicker-1.5.0/css/bootstrap-datepicker.standalone.min.css' ?>">
<script type="text/javascript" src="<?php echo base_url().'assets/bootstrap-datepicker-1.5.0/js/bootstrap-datepicker.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/bootstrap-datepicker-1.5.0/locales/bootstrap-datepicker.id.min.js' ?>"></script>