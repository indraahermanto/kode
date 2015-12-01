<title>Siimanto | Product</title>
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
	<div class="col-sm-3"></div>
	<div class="col-sm-6 panel panel-default" style="min-height:400px">
		<h2 class="text-center">Buy Pulsa</h2>
		<div class="panel-body">
			<form method="post" enctype="multipart/form-data" onsubmit="return formBuy('#AddNumber','#CNumber',this)">
				<div class="row">
					<div class="col-sm-6">
						<label for="InputName">Name </label>
						<input id="InputName" class="form-control" name="InputName" placeholder="Name">
					</div>
					<div class="col-sm-6" id="colNumber">
						<label for="InputPhone">Phone Number</label>
						<div class="row">
							<div class="col-sm-8">
								<select name="InputPhone" id="InputPhone" class="form-control">
									<option value="">Select Nomor</option>
								</select>
								<input id="InputPhone2" maxlength="12" class="form-control" name="InputPhone2" placeholder="New Number">
							</div>
							<div class="col-sm-4">
								<button type="button" id="AddNumber" class="form-control btn btn-primary">Add</button>
								<button type="button" id="CNumber" class="form-control btn btn-default">Undo</button>
							</div>
						</div>
						<span id="error_number"></span>
					</div>
				</div>
				<div class="row"><br/>
					<div class="col-sm-6">
						<label for="InputProv">Provider</label>
						<select name="InputProv" id="InputProv" class="form-control">
							<option value="">Select Provider</option>
							<?php foreach ($daftar_provider as $provider) { ?>
								<option value="<?php echo $provider->opr_id ?>"><?php echo $provider->opr_nama ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-6">
						<label for="InputNom">Nominal</label>
						<select name="InputNom" id="InputNom" class="form-control">
							<option value="">Select Nominal</option>
						</select>
					</div>
				</div>
				<div class="row"><br/>
					<div class="col-sm-6" id="price">
						<label for="InputPrice">Price</label>
						<input type="text" value="" class="text-center form-control" id="InputCode" name="InputPrice" readonly>
					</div>
					<div class="col-sm-6">
						<label for="InputPay">Payment Method</label>
						<select name="InputPay" id="InputPay" class="form-control">
							<option value="">Select Payment</option>
							<option value="200">TRANSFER</option>
							<option value="100">CASH</option>
							<option value="300">PENDING</option>
						</select>
					</div>
				</div>
				<div class="row"><br/>
					<div class="col-sm-6">
						<a href="<?php echo base_url().'transaction' ?>">
							<span class="glyphicon glyphicon-chevron-left"></span> Back to transaction
						</a>
					</div>
					<div class="col-sm-6">
						<button type="submit" id="submit" name="submit" value="Process" class="btn btn-success pull-right">
							Process
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-sm-3"></div>
</div>
<style>
	.ui-autocomplete {
		max-height: 100px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
	}
	/* IE 6 doesn't support max-height
	* we use height instead, but this forces the menu to always be this tall
	*/
	* html .ui-autocomplete {
		height: 100px;
	}
</style>
<script>
	$(function() {
		$("#InputPhone2").css("display","none");
		$("#CNumber").css("display","none");
		$("#colNumber").css("display","none");
		$("#InputName").focus(function(){
			$("#InputProv").val('');
			$("#InputNom").val('');
			$("#InputPrice").val('');
		});
		$("#InputName").autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: '<?php echo site_url('ajax/get_name'); ?>',
					type: 'POST',
					dataType: "json",
					data: {
						q: request.term
					},
					success: function( data ) {
						response(data);
					}
				});
			},
		});
		$("#InputName").keydown(function(){
			var name = $("#InputName").val();
			$.ajax({
		        url: '<?php echo site_url('ajax/get_phone_number'); ?>',
		        type: 'POST',
		        data: "name="+name,
		        cache: false,
		        success: function(msg){
		            $("#InputPhone").html(msg);
		        }
		    });
		    $("#colNumber").show(500);
		});
		$("#InputName").focusout(function(){
			var name = $("#InputName").val();
			$.ajax({
		        url: '<?php echo site_url('ajax/get_phone_number'); ?>',
		        type: 'POST',
		        data: "name="+name,
		        cache: false,
		        success: function(msg){
		            $("#InputPhone").html(msg);
		        }
		    });
		});
		$("#AddNumber").click(function(){
			$("#InputPhone").toggle(500);
			$("#InputPhone2").toggle(500);
			$("#AddNumber").hide(500);
			$("#CNumber").show(500);
			$("#InputPhone").val('')
			$("#InputProv").val('');
			$("#InputNom").val('');
			$("#InputPrice").val('');
			$("#text_error").hide(500);
			$("#hide").val('');
		});
		$("#CNumber").click(function(){
			$("#text_error").hide(500);
			$("#hide").val('');
			$("#InputPhone").toggle(500);
			$("#InputPhone2").toggle(500);
			$("#AddNumber").show(500);
			$("#CNumber").hide(500);
			$("#InputPhone2").val('');
			$("#InputProv").val('');
			$("#InputNom").val('');
			$("#InputPrice").val('');
		});
		$("#InputPhone").change(function(){
			var nomor_id = $("#InputPhone").val();
			$.ajax({
		        url: '<?php echo site_url('ajax/get_provider'); ?>',
		        type: 'POST',
		        data: "nomor_id="+nomor_id,
		        cache: false,
		        success: function(msg){
		            $("#InputProv").html(msg);
		        }
		    });
		});
		$("#InputProv").change(function(){
			var prov_id = $("#InputProv").val();
			$.ajax({
		        url: '<?php echo site_url('ajax/get_nominal'); ?>',
		        type: 'POST',
		        data: "prov_id="+prov_id,
		        cache: false,
		        success: function(msg){
		            $("#InputNom").html(msg);
		        }
		    });
		});
		$("#InputPhone").focusout(function(){
			var prov_id = $("#InputProv").val();
			$.ajax({
		        url: '<?php echo site_url('ajax/get_nominal'); ?>',
		        type: 'POST',
		        data: "prov_id="+prov_id,
		        cache: false,
		        success: function(msg){
		            $("#InputNom").html(msg);
		        }
		    });
		});
		$("#InputProv").focusout(function(){
			var prov_id = $("#InputProv").val();
			$.ajax({
		        url: '<?php echo site_url('ajax/get_nominal'); ?>',
		        type: 'POST',
		        data: "prov_id="+prov_id,
		        cache: false,
		        success: function(msg){
		            $("#InputNom").html(msg);
		        }
		    });
		});
		$("#InputNom").change(function(){
			var produk_id = $("#InputNom").val();
			$.ajax({
		        url: '<?php echo site_url('ajax/get_price'); ?>',
		        type: 'POST',
		        data: "produk_id="+produk_id,
		        cache: false,
		        success: function(msg){
		            $("#price").html(msg);
		        }
		    });
		});
		$("#InputPhone2").keydown(function(){
			var nomor = $("#InputPhone2").val();
			$.ajax({
		        url: '<?php echo site_url('ajax/check_number'); ?>',
		        type: 'POST',
		        data: "nomor="+nomor,
		        cache: false,
		        success: function(msg){
		            $("#error_number").html(msg);
		        }
		    });
		});
	});
	function formBuy(add, undo, form) {
		if(form.InputName.value == ""){
			alert("Nama belum diisi.");
			form.InputName.focus();
	    	return false;
		}else if($(undo).css('display') == 'none' && form.InputPhone.value == ""){
			alert("Phone number belum dipilih.");
	        form.InputPhone.focus();
	        return false;
		}else if($(add).css('display') == 'none' && form.InputPhone2.value == ""){
			alert("Phone number belum diisi.");
	        form.InputPhone2.focus();
	        return false;
		}else if(form.InputProv.value == ""){
			alert("Provider belum dipilih.");
			form.InputProv.focus();
	    	return false;
		}else if(form.InputNom.value == ""){
			alert("Nominal belum dipilih.");
			form.InputNom.focus();
	    	return false;
		}else if(form.InputPay.value == ""){
			alert("Payment method belum dipilih.");
			form.InputPay.focus();
	    	return false;
		}else if(form.hide.value == "gagal"){
			alert("Nomor tidak valid.");
			form.InputPhone2.focus();
	    	return false;
		}else{
			return true;
		}
	}
	
</script>