<title>Siimanto | Manage User</title>
<div class="container" style="min-height:550px">
	<br/>
	<div>
		<h2 class="text-center">Manage User</h2>
	</div>
	<br/><br/><br/>
	<div class="row">
		<table class="table">
			<thead>
				<th class="text-center">No.</th>
				<th class="text-center">User ID</th>
				<th class="text-center">User Level</th>
				<th class="text-center">Email</th>
				<th class="text-center">Saldo</th>
				<th class="text-center">Status</th>
				<th class="text-center">Operation</th>
			</thead>
			<tbody>
			<?php 
			$urutan = 1;
			foreach ($users as $user) { ?>
			<tr>
				<td class="text-center">
					<?php echo $urutan; ?>
				</td>
				<td>
					<?php echo $user->user_uid ?>
				</td>
				<td class="text-center">
					<?php echo $user->user_lvl ?>
				</td>
				<td class="text-center">
					<?php echo $user->user_email ?>
				</td>
				<td class="text-right">
					<?php echo $user->user_saldo ?>
				</td>
				<td class="text-center">
					<?php if(($user->user_stat) == 1) echo "Active"; else echo "Not Active" ?>
				</td>
				<td class="text-center">
	 				<a data-toggle="tooltip" data-placement="left" title="Edit" href="<?php echo base_url().'manage_user/edit/'.$user->user_uid ?>" class="btn btn-warning glyphicon glyphicon-pencil"></a>	
				</td>
			<tr>
			<?php $urutan++; } ?>
			</tbody>
		</table>
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