$(document).ready(function(){
	$('#form-input-true').hide();	
	var prov_id = $('#InputProv').val();
	var produk_nom = $('#InputNom').val();
	var produk_profit = $('#InputProfit').val();
	var produk_cost = $('#InputCost').val();
	var produk_price = $('#InputPrice').val();

	if(produk_nom.length < 4) var nom = '';
	else nom = produk_nom.replace('000','');
	
	$('#InputProv').change(function(){
		prov_id = $('#InputProv').val();;
		if(prov_id === ""){
			$('#InputCode').val('');
			$('#InputNom').val('');
			$('#InputCost').val('');
			$('#InputPrice').val('');
			$('#InputProfit').val('');
			$('#InputStatus').val('');
			$('#form-input-true').hide(500);
		} else {
			$('#InputCode').val(prov_id+nom);
			$('#form-input-true').show(500);
		}
	})

	$('#InputNom').keyup(function(){
		produk_nom = $('#InputNom').val();
		if(produk_nom.length < 4) nom = '';
		else nom = produk_nom.replace('000','');
		$('#InputCode').val(prov_id+nom);
	})

	$('#InputCost').keyup(function(){
		produk_cost = $('#InputCost').val();
		produk_price = $('#InputPrice').val();
		if(produk_price >0 ){
			produk_profit = produk_price - produk_cost;
			$('#InputProfit').val(produk_profit);
			if($('#InputProfit').val() <= 0) $('#InputProfit').val(0);
		}
	})

	$('#InputPrice').keyup(function(){
		produk_cost = $('#InputCost').val();
		produk_price = $('#InputPrice').val();
		if(produk_cost > 0){
			produk_profit = produk_price - produk_cost;
			$('#InputProfit').val(produk_profit);
			if($('#InputProfit').val() <= 0) $('#InputProfit').val(0);

		}
	})
})