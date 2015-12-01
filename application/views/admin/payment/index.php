<title>Siimanto | Payment</title>
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
	<div>
		<h2 class="text-center">Payment</h2>
		<br/>
		<div class="row">
		<table class="table table-bordered table-striped">
			<thead>
			<tr>
				<th class="text-center">No.</th>
				<th class="text-center" style="min-width:50px">Cust Name</th>
				<th class="text-center">Group</th>
				<th class="text-center">Total</th>
			</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				foreach ($trx_hut as $hutang) {
					$username = ucfirst(strtolower($hutang->user_fname))." ".ucfirst(strtolower($hutang->user_lname));
				?>
				<tr>
					<td class="text-center"><?php echo $no ?></td>
					<td>
						<a href="" data-toggle="modal" class="id" data-id="<?php echo $hutang->user_id ?>" data-target="#HutDetail">
							<?php echo $username ?>
						</a>
					</td>
					<td class="text-center"><?php echo ucfirst(strtolower($hutang->user_group)) ?></td>
					<td class="text-right">
					<?php
						echo number_format($hut[$no]->price,0,'','.');
					?>
					</td>
				</tr>
				<?php $no++; } ?>
			</tbody>
			<tfoot>
				<tr>
					<th class="text-center" colspan="3">Total</th>
					<th class="text-right"><?php echo number_format($piutang) ?></th>
				</tr>
			</tfoot>
		</table>
		</div>
	</div>
</div>
<!-- Modal Bayar-->
<div class="modal fade" id="HutDetail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form method="POST" id="formHutDetail">

			</form>
		</div>
	</div>
</div>
</div>
<!-- End Modal Bayar-->
<script type="text/javascript">
	$(document).ready(function(){
	   $(".id").click(function(){
			var id = $(this).data('id');
			$.ajax({
				url: '<?php echo site_url('ajax/payment_detail'); ?>',
				type: 'POST',
				data: "id="+id,
				cache: false,
				success: function(msg){
					$("#formHutDetail").html(msg);
				}
			});
	   });

	});
</script>