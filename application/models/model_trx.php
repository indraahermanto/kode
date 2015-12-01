<?php
class Model_trx extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->model('model_user');
		$this->load->model('pulsa/produk_model');
	}

	public function buy(){

	}

	public function isEmpty(){
		$trx = $this->db->query("SELECT * FROM str_trx");

		if($trx->num_rows() < 1)
			return true;
	}

	public function get_trx(){
		$this->db->from('str_trx as a');
		$this->db->join('str_user as b', 'a.user_id = b.user_id');
		$this->db->join('str_nomor as c', 'a.nomor_id = c.nomor_id');
		$this->db->order_by('trx_id','desc');
		return $this->db->get();
	}

	public function get_trx_paging($row, $limit){
		$this->db->from('str_trx as a');
		$this->db->join('str_user as b', 'a.user_id = b.user_id');
		$this->db->join('str_nomor as c', 'a.nomor_id = c.nomor_id');
		$this->db->limit($limit, $row);
		$this->db->order_by('trx_id','desc');
		return $this->db->get();
	}

	public function get_trx_with_filter($date_from, $date_to, $date_pay, $key, $show){
		$this->db->from('str_trx as a');
		$this->db->join('str_user as b', 'a.user_id = b.user_id');
		$this->db->join('str_nomor as c', 'a.nomor_id = c.nomor_id');
		$this->db->order_by('trx_id','desc');
		return $this->db->get();
	}

	public function isEmptySal(){
		return $this->db->query("SELECT SUM(saldo_nom) AS saldo FROM str_saldo");
	}

	public function get_saldo(){
		$this->db->select('saldo_nama, saldo_nom');
		return $this->db->get('str_saldo');
	}

	public function get_saldo_from_trx($cat){
		//Menghitung total saldo
		$type = "";
		$sql = "SELECT SUM(produk_price) AS saldo FROM str_trx WHERE trx_stat = '1' AND ";
		$sqlc = "SELECT SUM(produk_cost) AS saldo FROM str_trx WHERE trx_stat = '1' AND ";
		$sqlp = "SELECT SUM(produk_profit) AS saldo FROM str_trx WHERE trx_stat = '1' AND ";
		switch ($cat) {
			case 'cash':
				$type = "(trx_type IN ('100','110','700'))";
				$plus = $this->db->query($sql.$type)->row()->saldo;

				$type = "(trx_type = '400')";
				$minus = $this->db->query($sql.$type)->row()->saldo;
				$type = "(trx_type = '610')";
				$minus = $minus + $this->db->query($sqlp.$type)->row()->saldo;
				$saldo = $plus - $minus;
				break;

			case 'bank':
				$type = "(trx_type IN ('120','200','400','800'))";
				$plus = $this->db->query($sql.$type)->row()->saldo;

				$type = "(trx_type = '600')";
				$minus = $this->db->query($sqlp.$type)->row()->saldo;
				$type = "(trx_type = '500')";
				$minus = $minus + $this->db->query($sqlc.$type)->row()->saldo;
				$saldo = $plus - $minus;
				break;

			case 'pulsa':
				$type = "(trx_type IN ('140','500'))";
				$plus = $this->db->query($sqlc.$type)->row()->saldo;

				$type = "(trx_type IN ('100','200','300'))";
				$minus = $this->db->query($sqlc.$type)->row()->saldo;
				$saldo = $plus - $minus;
				break;

			case 'toped':
				$type = "(trx_type = '100' OR trx_type = '110')";
				$plus = $this->db->query($sql.$type)->row()->saldo;

				$type = "(trx_type = '400')";
				$minus = $this->db->query($sql.$type)->row()->saldo;
				$saldo = $plus - $minus;
				break;

			case 'piutang':
				$type = "(trx_type IN ('300','900'))";
				$plus = $this->db->query($sql.$type)->row()->saldo;

				$minus = 0;
				$saldo = $plus - $minus;
				break;

			case 'hutang':
				$type = "(trx_type IN ('100','110'))";
				$plus = $this->db->query($sql.$type)->row()->saldo;

				$type = "(trx_type = '400')";
				$minus = $this->db->query($sql.$type)->row()->saldo;
				$saldo = $plus - $minus;
				break;

			case 'untung':
				$type = "(trx_type IN ('100','200','300'))";
				$plus = $this->db->query($sqlp.$type)->row()->saldo;

				$type = "(trx_type IN ('600','610','650'))";
				$minus = $this->db->query($sqlp.$type)->row()->saldo;
				$saldo = $plus - $minus;
				break;

			case 'modal':
				$type = "(trx_type IN ('110','120','130'))";
				$plus = $this->db->query($sql.$type)->row()->saldo;
				$type = "(trx_type IN ('140'))";
				$plus = $plus + $this->db->query($sqlc.$type)->row()->saldo;
				$type = "(trx_type IN ('650'))";
				$plus = $plus + $this->db->query($sqlp.$type)->row()->saldo;

				$minus = 0;
				$saldo = $plus - $minus;
				break;
			
			default:
				$saldo = 0;
				break;
		}
		return $saldo;
	}

	public function get_saldo_by_kode($saldo_kode){
		$this->db->where('saldo_kode',$saldo_kode);
		return $this->db->get('str_saldo');
	}

	public function select_saldo_by_kode($skode){
		$sql = "SELECT saldo_nom FROM str_saldo WHERE saldo_kode = '".$skode."'";
		return $this->db->query($sql);
	}

	public function get_max_trxID(){
		$this->db->select_max('trx_id');
		return $this->db->get('str_trx');
	}

	public function get_trxID($date){
		$this->db->select_max('trx_id');
		$this->db->like('trx_id', $date, 'after');
		if($this->db->get('str_trx')->row()->trx_id)
			$a = $this->db->get('str_trx')->row()->trx_id;
		else $a = '';

		if($a == ''){
			$a = 1;
			$b = date("ymd");
			$t = $b."%04s";
			$trx_id = sprintf($t,$a);
		}else{
			$trx_id = $this->get_max_trxID()->row()->trx_id+1;
		};

		return $trx_id;
	}

	public function setup(){
		$bank = $this->input->post('InputBank');
		$cash = $this->input->post('InputCash');
		$toped = $this->input->post('InputToped');
		$pulsa = $this->input->post('InputPulsa');
		$hutang = $this->input->post('InputHut');
		$modal = $bank + $cash + $toped + $pulsa;
		$a = 0; //untuk cari user_id di session
		$user_id = $this->model_user->select_by_uid($this->session->userdata('user_uid'))->result();
		foreach ($user_id as $key) {
			foreach ($key as $id) {
				if($a == 0)
					$user_id = $id;
				$a++;
			}
		}

		if($modal == 0) return false;
		else {
			//query table saldo
			for($number = 1; $number<=6; $number++){
				$query = "UPDATE str_saldo SET saldo_nom = ";
				switch ($number) {
					case '1':
						$sql = $query."'$bank' WHERE saldo_kode = 'BNK'";
						break;
					case '2':
						$sql = $query."'$cash' WHERE saldo_kode = 'CAS'";
						break;
					case '3':
						$sql = $query."'$toped' WHERE saldo_kode = 'TOP'";
						break;
					case '4':
						$sql = $query."'$pulsa' WHERE saldo_kode = 'PUL'";
						break;
					case '5':
						$sql = $query."'$hutang' WHERE saldo_kode = 'HUT'";
						break;
					case '6':
						$sql = $query."'$modal' WHERE saldo_kode = 'MDL'";
						break;
				}
				$this->db->query($sql);
			}
			//query table transaksi
			for($number = 1; $number<5; $number++){
				$t = date("ymd")."%04s";
				$id_trx = sprintf($t,$number);
				$query = "INSERT INTO str_trx 
					(trx_id, trx_date, trx_response, user_id, nomor_id, pulsa_id, produk_cost, 
						produk_price, trx_type, trx_stat) 
					VALUES ('$id_trx', 
							now(), 
							now(), 
							$user_id, 'AdMn', ";
				switch ($number) {
					case '1':
						$sql = $query."0, 0, $bank, 120, 1)";
						break;
					case '2':
						$sql = $query."0, 0, $cash, 110, 1)";
						break;
					case '3':
						$sql = $query."0, 0, $toped, 130, 1)";
						break;
					case '4':
						$sql = $query."0, $pulsa, 0, 140, 1)";
						break;
					case '5':
						$sql = $query."0, 0, $hut, 150, 1)";
						break;
				}
				$this->db->query($sql);
			}
			return true;
		}
	}

	public function check_valid_number($nomor){
		$this->db->select('*');
		$this->db->from('str_nomor as a');
		$this->db->join('str_user as b', 'b.user_id = a.cus_id');
		$this->db->where('a.nomor', $nomor);
		$select = $this->db->get()->result();

		foreach ($select as $key) {
			$select_number = $key->nomor;
			$user_uid = $key->user_uid;
		}

		if(isset($select_number) && $select_number == $nomor)
			return $user_uid;
		else return true;
	}

	public function update_saldo($cost, $price, $profit, $payment, $cancel){
		$sql = "UPDATE str_saldo SET saldo_nom = saldo_nom ";

		switch ($payment) {
			case '100':
				$kode = 'CAS';
				break;

			case '200':
				$kode = 'BNK';
				break;

			case '300':
				$kode = 'PIU';
				break;

			case '400': //transfer
				if($cancel == true){
					$main1 = "+ '$price' WHERE saldo_kode = 'CAS'";
					$main2 = "- '$price' WHERE saldo_kode =  'BNK'";
				}else{
					$main1 = "- '$price' WHERE saldo_kode = 'CAS'";
					$main2 = "+ '$price' WHERE saldo_kode =  'BNK'";	
				}
				break;

			case '500': //deposit
				if($cancel == true){
					$main1 = "+ '$cost' WHERE saldo_kode = 'BNK'";
					$main2 = "- '$cost' WHERE saldo_kode =  'PUL'";
				}else{
					$main1 = "- '$cost' WHERE saldo_kode = 'BNK'";
					$main2 = "+ '$cost' WHERE saldo_kode =  'PUL'";
				}
				break;
			
			case '600': //withdraw BANK
				if($cancel == true){
					$main1 = "+ '$profit' WHERE saldo_kode = 'UNT'";
					$main2 = "+ '$profit' WHERE saldo_kode =  'BNK'";
				}else{
					$main1 = "- '$profit' WHERE saldo_kode = 'UNT'";
					$main2 = "- '$profit' WHERE saldo_kode =  'BNK'";
				}
				break;

			case '610': //withdraw CAS
				if($cancel == true){
					$main1 = "+ '$profit' WHERE saldo_kode = 'UNT'";
					$main2 = "+ '$profit' WHERE saldo_kode =  'CAS'";
				}else{
					$main1 = "- '$profit' WHERE saldo_kode = 'UNT'";
					$main2 = "- '$profit' WHERE saldo_kode =  'CAS'";
				}
				break;
			
			case '650': //Add to modal
				if($cancel == true){
					$main1 = "+ '$profit' WHERE saldo_kode = 'UNT'";
					$main2 = "- '$profit' WHERE saldo_kode =  'MDL'";
				}else{
					$main1 = "- '$profit' WHERE saldo_kode = 'UNT'";
					$main2 = "+ '$profit' WHERE saldo_kode =  'MDL'";
				}
				break;
			
			default:
				return false;
				break;
		}
		if($payment < 400){
			if($cancel == true){
				$pul = "+ '$cost' WHERE saldo_kode = 'PUL'";
				$prof = "- '$profit' WHERE saldo_kode = 'UNT'";
				$pay = "- '$price' WHERE saldo_kode = '$kode'";
			}else {
				$pul = "- '$cost' WHERE saldo_kode = 'PUL'";
				$prof = "+ '$profit' WHERE saldo_kode = 'UNT'";
				$pay = "+ '$price' WHERE saldo_kode = '$kode'";
			}

			$this->db->query($sql.$pul);
			$this->db->query($sql.$prof);
			$this->db->query($sql.$pay);
		}else if($payment >= 400 && $payment < 700){
			if($this->db->query($sql.$main1) && $this->db->query($sql.$main2))
			return true;
		}
	}	

	public function buy_pulsa(){
		$a = 0;
		$user_uid = strtolower($this->input->post('InputName'));
		$user_id = $this->model_user->select_by_uid($user_uid)->result();
		foreach ($user_id as $key) {
			foreach ($key as $id) {
				if($a == 0)
					$user_id = $id;
				$a++;
			}
		}
		//cek nomor sudah ada blm
		if($this->input->post('InputPhone') == "")
			$nomor = $this->input->post('InputPhone2');
		else $nomor = $this->input->post('InputPhone');
		$prov_id = $this->input->post('InputProv');
		$produk_id = $this->input->post('InputNom');
		$payment = $this->input->post('InputPay');

		if(is_array($user_id)){
			//register user baru & nomor baru
			if($this->model_user->auto_register($user_uid, $nomor, $prov_id)){
				$user = $this->model_user->select_by_uid($user_uid)->row();
				$nomor = $this->model_user->get_number_id($nomor)->nomor_id;
				$user_id = $user->user_id;
			}
		}else if($this->input->post('InputPhone') == "" && $this->check_valid_number($nomor) == true){
			//tambah nomor baru untuk user lama
			$this->model_user->add_number($user_id, $prov_id, $nomor);
			$nomor = $this->model_user->get_number_id($nomor)->nomor_id;
		}
		//get produk kode
		$produk_kode = $this->produk_model->select_by_id($produk_id)->produk_kode;
		$produk_cost = $this->produk_model->select_by_id($produk_id)->produk_hb;
		$produk_price = $this->produk_model->select_by_id($produk_id)->produk_hj;
		$produk_profit = $this->produk_model->select_by_id($produk_id)->produk_un;
		$trx_id = $this->get_trxID(date("ymd"));

		$sql = "INSERT INTO str_trx 
					(trx_id, trx_date, trx_response, user_id, nomor_id, produk_kode, 
						pulsa_id, produk_cost, produk_price, produk_profit, trx_type, trx_stat) 
					VALUES ('$trx_id', 
							now(), 
							now(), 
							'$user_id', 
							'$nomor', 
							'$produk_kode', 
							'$produk_id', 
							'$produk_cost', 
							'$produk_price', 
							'$produk_profit', 
							'$payment', 1)";

		$saldo = $this->get_saldo_from_trx('pulsa');

		if($produk_cost > $saldo){
			return false;
		} else {
			$this->db->query($sql);
			return $produk_kode.".".$this->model_user->get_number($nomor)->nomor;
		}
	}

	public function management_saldo(){
		$cost = 0;
		$price = 0;
		$profit = 0;
		$type = $this->input->post('submit');
		$bank = $this->model_trx->get_saldo_from_trx('bank');
		$cash = $this->model_trx->get_saldo_from_trx('cash');
		$profit = $this->model_trx->get_saldo_from_trx('untung');
		$trx_id = $this->get_trxID(date("ymd"));
		$user_uid = $this->session->userdata('user_uid');
		$user_id = $this->model_user->select_by_uid($user_uid)->row()->user_id;

		//cek saldo mencukupi atau tidak, jika tidak return false
		if($type == 'Transfer'){
			$price = $this->input->post('InputNom');
			$payment = '400';
			$profit = 0;
			if($price > $cash)
				return 'Failed : Saldo cash Anda tidak mencukupi.';
			else $msg = 'Transfer berhasil.';
		}else if($type == 'Deposit'){
			$cost = $this->input->post('InputDep');
			$payment = '500';
			$profit = 0;
			if($cost > $bank)
				return 'Failed : Saldo bank Anda tidak mencukupi.';
			else $msg = 'Pengisian deposit berhasil.';
		}else if($type == 'Withdraw'){
			$nom = $this->input->post('InputManage');
			$type = $this->input->post('InputPay');

			if($nom > $profit)
				return 'Failed : Saldo untung Anda tidak mencukupi.';
			else if($type == 'BNK' && $nom > $bank) {
				return 'Saldo bank Anda tidak mencukupi.';
			}else if($type == 'CAS' && $nom > $cash)
				return 'Failed : Saldo cash Anda tidak mencukupi.';
			else {
				if($type == 'BNK')
					$payment = '600';
				else $payment = '610';
				$profit = $nom;
				$msg = 'Withdraw berhasil.';
			}
		}else if($type == 'Add to Modal'){
			$nom = $this->input->post('InputManage');
			$type = $this->input->post('InputPay');
			$payment = '650';

			if($nom > $profit)
				return 'Failed : Saldo untung Anda tidak mencukupi.';
			else if($type == 'BNK' && $nom > $bank) {
				return 'Failed : Saldo bank Anda tidak mencukupi.';
			}else if($type == 'CAS' && $nom > $cash)
				return 'Failed : Saldo cash Anda tidak mencukupi.';
			else{
				$msg = 'Add modal berhasil.';
				$profit = $nom;
			}
		}else return false;

		if($cost == 0 && $price == 0 && $profit == 0)
			return 'Failed : Please contact Administration';
		$s = "INSERT INTO str_trx 
					(trx_id, trx_date, trx_response, user_id, nomor_id, 
						pulsa_id, produk_cost, produk_price, produk_profit, trx_type, trx_stat) 
					VALUES ('$trx_id', 
							now(), now(), 
							'$user_id', 'AdMn', 0, 
							'$cost', '$price', '$profit', 
							'$payment', 1)";
		$update_saldo = $this->db->query($s);

		if($update_saldo == true)
			return $msg;
	}

	public function select_trx_hut_all(){
		$this->db->distinct();
		$this->db->from('str_trx as a');
		$this->db->join('str_user as b', 'a.user_id = b.user_id');
		$this->db->join('str_nomor as c', 'a.nomor_id = c.nomor_id');
		$this->db->group_by('a.user_id');
		$this->db->order_by('b.user_fname','asc');
		$this->db->where('a.trx_type', '300');
		$this->db->where('a.trx_stat', '1');
		return $this->db->get();
	}

	public function select_trx_hut_price($user_id){
		$this->db->select('*');
		$this->db->select_sum('a.produk_price','price');
		$this->db->from('str_trx as a');
		$this->db->join('str_user as b', 'a.user_id = b.user_id');
		$this->db->join('str_nomor as c', 'a.nomor_id = c.nomor_id');
		$this->db->where('a.trx_type', '300');
		$this->db->where('a.trx_stat', '1');
		$this->db->where('a.user_id', $user_id);
		$this->db->group_by('a.user_id');
		$this->db->order_by('a.trx_id','desc');
		return $this->db->get();
	}

	public function select_trx_hut_price_detail($user_id){
		$this->db->select('*');
		$this->db->from('str_trx as a');
		$this->db->join('str_user as b', 'a.user_id = b.user_id');
		$this->db->join('str_nomor as c', 'a.nomor_id = c.nomor_id');
		$this->db->where('a.trx_type', '300');
		$this->db->where('a.trx_stat', '1');
		$this->db->where('a.user_id', $user_id);
		return $this->db->get();
	}

	public function get_trx_by_trx_id($trx_id){
		$this->db->where('trx_id',$trx_id);
		$this->db->from('str_trx as a');
		$this->db->join('str_user as b', 'a.user_id = b.user_id');
		$this->db->join('str_nomor as c', 'a.nomor_id = c.nomor_id');
		return $this->db->get();
	}

	public function payment_payable(){
		$trx = $this->input->post('trx_id');
		$payment = $this->input->post('InputPay');
		
		if(!empty($trx)){
			foreach ($trx as $trx_id) {
				$sql = "UPDATE str_trx SET trx_type = '$payment' WHERE trx_id = '$trx_id'";
				$this->db->query($sql);
			}
			return true;
		}
		else return 'Failed : No transaction is chosen.';
	}

	public function edit_transaction(){
		$trx_id = $this->input->post('InputID');
		$cost = str_replace(',', '', $this->input->post('InputCost'));
		$price = str_replace(',', '', $this->input->post('InputPrice'));
		$profit = str_replace(',', '', $this->input->post('InputProfit'));
		$payment = $this->input->post('InputPay');
		$submit = $this->input->post('submit');
		
		$trx_old = $this->get_trx_by_trx_id($trx_id)->row();
		$cost_old = $trx_old->produk_cost;
		$price_old = $trx_old->produk_price;
		$profit_old = $trx_old->produk_profit;
		$payment_old = $trx_old->trx_type;

		if($payment > 400){
			switch ($payment) {
				case '400':
					$cost = 0;
					$profit = 0;
					break;
				case '500':
					$price = 0;
					$profit = 0;
					break;
			}
			if($payment > 500 || $payment < 700){
				$cost = 0;
				$price = 0;
			}
		}
		if($submit != 'Save'){
			$cancel = 0;
		}else {
			$cancel = 1;
		}

		$sql = "UPDATE str_trx SET produk_cost = '$cost', produk_price = '$price', produk_profit = '$profit', 
						trx_type = '$payment', trx_stat = '$cancel' WHERE trx_id = '$trx_id'";
		$this->db->query($sql);
		if($cancel == 0)
			return 'cancel';
		else return 'update';
	}

	public function update_transaction($payment){
		
	}
}