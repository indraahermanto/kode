<title>Welcome to our website</title>
<div class="container"  style="min-height:550px">

<?php 
	if($logged_in){
		$firstname = $this->session->userdata('firstname');
		echo "<h2>Welcome to the Root Home Page, {$firstname}!</h2>";
	} else {
		echo "<h2>Visitor Home Page</h2>";
	}
?>

</div>