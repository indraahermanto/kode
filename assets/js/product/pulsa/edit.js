$(document).ready(function(){
	var produk_profit = $('#InputProfit').val();
	var produk_cost = $('#InputCost').val();
	var produk_price = $('#InputPrice').val();

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