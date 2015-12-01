<title>Siimanto | Pulsa</title>
<div class="container" style="min-height:550px">
	<br/>
	<div>
		<h2 class="text-center">Pulsa List </h2>
	</div>		
	<br/><br/><br/>
	<div class="row">
	<?php foreach ($providers as $provider) { ?>
		<div id="" class="col-xs-11 col-sm-6 col-md-4">
			<div class="thumbnail" data-spy="scroll">
				<div class="caption">
					<div class="text-center form-group">
						<h4 class=""> <?php echo $provider->opr_nama ?> </h4>
					</div>
				</div>
				<div class="caption thumbnail-content">
					<ul class="list-group">
					<?php 
						$query = mysql_query("SELECT * FROM str_product WHERE opr_id = '$provider->opr_id' ORDER BY produk_nom ASC");
						if(mysql_num_rows($query) === 0) echo '<li class="text-center">No Available Product</li>';
						else {while($product = mysql_fetch_assoc($query)){?>
					 		<li class="list-group-item" style="min-height: 30px">
					 			<ul class="list-unstyled list-inline">
					 				<li>
					 					<?php echo $provider->opr_nama.' '.str_replace('000', '', $product['produk_nom']); ?>	
					 				</li>
					 				<li class="pull-right">
					 					<button type="button" class="btn btn-info">
  											<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
										</button>
					 				</li>
					 			<br/><br/>
					 			</ul>
					 		</li>
					 	<?php }} ?>
					</ul>
				</div>
			</div>
		</div>
	<?php } 
	?>
	</div>
	<?php echo $this->pagination->create_links(); ?>
	<br/><br/><br/>
</div>

<style type="text/css">
	.thumbnail-content{
		max-height : 200px; 
		min-height: 200px; 
		overflow-y:auto
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		})
	})
</script>