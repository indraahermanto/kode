<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('model_trx');
		$this->load->model('model_login');
		if($this->session->userdata('logged_in')) $this->logged_in = true;
		else $this->logged_in = false;
		if($this->session->userdata('logged_in') && ($this->session->userdata('level') === 'admin' || $this->session->userdata('level') === 'root'))
			$this->access = true;
		else $this->access = false;
	}

	public function index(){
		redirect('');
	}

	public function get_name(){
		if(!$this->access) redirect('');
		$q = $_REQUEST["q"]; 
	    $sql="SELECT user_uid FROM str_user WHERE (user_uid LIKE '%$q%' OR user_fname LIKE '%$q%' OR user_lname LIKE '%$q%' OR user_group LIKE '%$q%') 
	    	AND user_stat = 1 AND (user_lvl != 'root' AND user_lvl != 'admin')";
	    $result = mysql_query($sql);

	    $json=array();

	    while($row = mysql_fetch_array($result)) {
			array_push($json, $row['user_uid']);
	    }

	    echo json_encode($json);
	}

	public function get_phone_number(){
		if(!$this->access) redirect('');
		$user_uid = $_POST['name'];
		$sql = mysql_query("SELECT user_id FROM str_user WHERE user_uid = '$user_uid'");
		$result = mysql_fetch_assoc($sql);

		$sql = mysql_query("SELECT nomor_id, nomor FROM str_nomor WHERE cus_id = $result[user_id]");
		echo "<option value=''>Select Nomor</option>";
		while ($nomor = mysql_fetch_assoc($sql)) {
			echo "<option value='".$nomor['nomor_id']."'>".$nomor['nomor']."</option>";
		}
	}

	public function get_provider(){
		if(!$this->access) redirect('');
		$nomor_id = $_POST['nomor_id'];
		$sql = mysql_query("SELECT opr_id FROM str_nomor WHERE nomor_id = '$nomor_id'");
		$provider_id = mysql_fetch_assoc($sql);

		$sql = mysql_query("SELECT opr_id, opr_nama FROM str_operator WHERE opr_stat = 1");
		echo "<option value=''>Select Provider</option>";
		while ($provider = mysql_fetch_assoc($sql)) {
			if($provider['opr_id'] == $provider_id['opr_id'])
				$select = "SELECTED";
			else $select = "";
			echo "<option ".$select." value='".$provider['opr_id']."'>".$provider['opr_nama']."</option>";
		}
	}

	public function get_nominal(){
		if(!$this->access) redirect('');
		$prov_id = $_POST['prov_id'];
		$sqlprov = mysql_query("SELECT opr_nama FROM str_operator WHERE opr_id = '$prov_id'");
		$provider = mysql_fetch_assoc($sqlprov);

		$sql = mysql_query("SELECT produk_id, produk_nom FROM str_product WHERE opr_id = '$prov_id' ORDER BY produk_nom ASC");
		echo "<option value=''>Select Nominal</option>";
		while ($pulsa = mysql_fetch_assoc($sql)) {
			echo "<option ".$select." value='".$pulsa['produk_id']."'>".$provider['opr_nama']." ".number_format($pulsa['produk_nom'],0,'','.')."</option>";
		}
	}

	public function get_price(){
		if(!$this->access) redirect('');
		$produk_id = $_POST['produk_id'];
		$sql = mysql_query("SELECT produk_hj FROM str_product WHERE produk_id = '$produk_id'");
		$pulsa = mysql_fetch_assoc($sql);
		?>
		<label for="InputPrice">Price</label>
		<input type="text" value="<?php echo 'Rp. '.number_format($pulsa['produk_hj'],0,'','.') ?>" class="text-center form-control" id="InputPrice" name="InputPrice" readonly>
	<?php 
	}

	public function check_number(){
		if(!$this->access) redirect('');
		$spanBeginOk = "<small class='glyphicon glyphicon-ok text-success'>
						<input name='hide' value='sukses' id='hide' type='hidden'>";
		$spanBegin = "<small id='text_error' class='glyphicon glyphicon-remove text-danger'>
						<input name='hide' id='hide' type='hidden' value='gagal'>";
		$spanEnd = "</small>";
		$nomor = $_POST['nomor'];
		
		$validNumber = $this->model_trx->check_valid_number($nomor);
		if($nomor == ""){

		}else if ($nomor == "0" || strlen($nomor) <10 || strlen($nomor) >13 || !is_numeric($nomor)){
			echo $spanBegin." Nomor tidak valid".$spanEnd;
		} else if($validNumber != 1){
			echo $spanBegin." Nomor milik ".$validNumber.$spanEnd;
		}else{
			echo $spanBeginOk." Nomor valid".$spanEnd;
		}
	}

	public function check_saldo(){
		if(!$this->access) redirect('');
		$nominal = $_POST['nom'];
		$type = $_POST['type'];
		if($type == 'InputNom')
			$type = "cash";
		else if($type == 'InputDep')
			$type = "bank";
		else if($type == 'InputManage')
			$type = "untung";

		$saldo = $this->model_trx->get_saldo_from_trx($type);
		$nama_saldo = strtoupper($type);
		
		if($nominal > $saldo)
			echo "Saldo ".$nama_saldo." Anda tidak mencukupi.";
		else echo "" ;
	}

	public function payment_detail(){
		if(!$this->access) redirect('');
		$user_id = $this->input->post('id');
		$data['hut_detail'] = $this->model_trx->select_trx_hut_price_detail($user_id)->result();
		$data['user_uid'] = $this->model_trx->select_trx_hut_price_detail($user_id)->row()->user_uid;
		$this->load->view('admin/payment/modal', $data);
	}
}