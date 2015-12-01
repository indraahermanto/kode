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
	<div class="col-sm-6">
	<h2 class="text-center">Product List</h2>
	<br/>
	<div class="form-group pull-right row">
	<form action="<?php echo base_url().'pulsa/' ?>" class="form-inline">
		<input class="form-control" name="key" value="<?php echo $key ?>">
		<button type="submit" class="form-control btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
	</form>
	</div>
	<br/>
	<br/>
	<div class="row">
		<ul class="list-unstyled panel panel-content">
			<li class="col-xs-1 text-center">No.</li>
			<li class="col-xs-1 text-center">Code</li>
			<li class="col-xs-5 text-center">Provider</li>
			<li class="col-xs-4 text-center">
				<a class="btn btn-info" href="<?php echo base_url().'pulsa/add';?>">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				</a>
			</li>
		</ul>
	</div>
	<div class="row">
	<?php foreach ($daftar_produk as $produk) { $index++; ?>
		<ul class="list-unstyled panel panel-content">
			<li class="col-xs-1 text-center"><?php echo $index ?></li>
			<li class="col-xs-1 text-center"><?php echo $produk->produk_kode ?></li>
			<li class="col-xs-5 text-center"><?php echo $produk->opr_nama ?></li>
			<li class="col-xs-4 text-center">
				<a href="<?php echo base_url().'pulsa/edit/'.$produk->produk_kode ?>" class="btn btn-warning">
					<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				</a>
				<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-<?php echo $product['produk_kode'] ?>" data-backdrop="static" data-keyboard="false">
  					<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
				</button>
			</li>
		</ul>
		<br/>
		<div class="modal fade" id="modal-delete-<?php echo $product['produk_kode'] ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body">
						Are you sure?	
					</div>
					<div class="modal-footer">
						<a href="<?php echo base_url().'pulsa/delete/'.$produk->produk_kode ?>" class="btn btn-danger">Yes, Delete</a>
						<button class="btn btn-warning" data-dismiss="modal">Cancel</button>
					</div>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	<?php } ?>
	<p class="text-center">
<?php 
echo $this->pagination->create_links();
?>
	</p>
	</div>
	</div>
	<div></div>
	<br />
</div>