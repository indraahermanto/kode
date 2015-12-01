<div class="modal-header">
	<h3 class="text-center"><?php echo ucfirst(strtolower($user_uid ))."'s Payable" ?></h3>
</div>
<div class="modal-body">
	<table class="table table-stripped table-bordered">
		<thead>
			<tr>
				<th class="text-center">ID</th>
				<th class="text-center">Purchase Date</th>
				<th class="text-center">Code</th>
				<th class="text-center">Nomor</th>
				<th class="text-center">Price</th>
				<th class="text-center"><input class="checkbox_all" type="checkbox"></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no = 1;
		foreach ($hut_detail as $hut_details) { ?>
			<tr>
				<td class="text-center"><?php echo $hut_details->trx_id; ?></td>
				<td class="text-center"><?php echo $hut_details->trx_date; ?></td>
				<td class="text-center"><?php echo $hut_details->produk_kode; ?></td>
				<td class="text-center"><?php echo $hut_details->nomor; ?></td>
				<td class="text-center"><?php echo number_format($hut_details->produk_price,0,'','.') ?></td>
				<td class="text-center"><input name="trx_id[]" id="trx_id[]" class="checkbox" value="<?php echo $hut_details->trx_id; ?>" type="checkbox"></td>
			</tr>
		<?php  } ?>
		</tbody>
	</table>
</div>
<div class="modal-footer form-inline">
	<select name="InputPay" id="InputPay" class="form-control">
		<option value="">Select Payment</option>
		<option value="200">Bank</option>
		<option value="100">Cash</option>
	</select>
	<input type="submit" name="submit" id="submit" disabled class="btn btn-success" value="Pay">
	<button class="btn btn-warning" data-dismiss="modal">Cancel</button>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#InputPay').click(function(){
			var pay = $('#InputPay').val();
			if(pay != "")
				$('#submit').prop('disabled', false);
			else $('#submit').prop('disabled', true);
		});

		$('.checkbox_all').click(function(event) {
	        if(this.checked) {
	            $('.checkbox').each(function() {
	                this.checked = true;
	            })
	        }else{
	            $('.checkbox').each(function() {
	                this.checked = false;
	            });
	        }
	    });
	})
</script>