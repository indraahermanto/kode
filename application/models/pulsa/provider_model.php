<?php
class Provider_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function select_all(){
		return $this->db->get('str_operator');
	}

	function select_all_paging($row, $limit){
		$this->db->order_by('opr_nama', 'asc');
		$this->db->limit($limit, $row);
		return $this->db->get('str_operator');
	}

	function select_all_ready(){
		$this->db->select('*');
		$this->db->from('str_operator');
		$this->db->where('opr_stat', '1');
		$this->db->order_by('opr_nama','asc');
		return $this->db->get();
	}

	function select_all_ready_paging($row, $limit){
		$this->db->select('*');
		$this->db->from('str_operator');
		$this->db->where('opr_stat', '1');
		$this->db->order_by('opr_nama','asc');
		$this->db->limit($limit, $row);
		return $this->db->get();
	}

	function check_by_id($prov_id){
		$this->db->where('opr_id', $prov_id);
		$this->db->get('str_operator');
		if($this->db->affected_rows() == 1)
			return true;
		else return false; 
	}

	function select_by_id($prov_id){
		$sql = "SELECT * FROM str_operator WHERE opr_id = '$prov_id'";
		$result = $this->db->query($sql);
		return $result->row();
	}

	function select_by_kode($prov_kode){
		$sql = "SELECT * FROM str_operator WHERE opr_kode = '$prov_kode'";
		$result = $this->db->query($sql);
		return $result->row();
	}

	function add(){
		$prov_id 	= random_string('alnum',4);
		$prov_kode 	= strtoupper($this->input->post('InputCode'));
		$prov_name	= strtoupper($this->input->post('InputName'));
		$prov_group	= strtoupper($this->input->post('InputGroup'));
		$prov_stat	= $this->input->post('InputStatus');

		$sql = "INSERT INTO str_operator (opr_id, opr_kode, opr_grup, opr_nama, opr_stat) 
				VALUE ( '".$prov_id."', 
						'".$prov_kode."', 
						'".$prov_group."', 
						'".$prov_name."', 
						'".$prov_stat."')";
		$this->db->query($sql);
		return true;
	}

	function update($prov_id){
		$temp_kode   = $this->select_by_id($prov_id);
		$prov_kode   = strtoupper($this->input->post('InputCode'));
		$prov_name	 = strtoupper($this->input->post('InputName'));
		$prov_group	 = strtoupper($this->input->post('InputGroup'));
		$prov_stat	 = $this->input->post('InputStat');
		$produk_stat = $prov_stat;

		$sql = "UPDATE str_operator SET 
				opr_kode = '$prov_kode', 
				opr_grup = '$prov_group', 
				opr_nama = '$prov_name', 
				opr_stat = '$prov_stat' WHERE opr_id = '$prov_id'";

		$select_product = $this->db->query("SELECT produk_kode, produk_id, produk_stat FROM str_product WHERE opr_id = '$prov_id'")->row();
		$produk_nom = str_replace('000','',preg_replace('/[^0-9.]/', '', 'ax5000'));
		$produk_kode = $prov_kode.$produk_nom;

		$this->db->query($sql);

		//cek kode sama
		$check = $this->select_by_kode($prov_kode);
		if($check->opr_kode == $prov_kode && $check->opr_id == $prov_id){
			$produk = "UPDATE str_product SET 
								produk_kode = '$produk_kode', 
								produk_stat = '$produk_stat' WHERE opr_id = '$prov_id'";
			$this->db->query($produk);
			return true;
		} else if($check->opr_kode == $prov_kode){
			$sql = "UPDATE str_operator SET opr_kode = '$temp_kode->opr_kode' WHERE opr_id = '$prov_id'";
			$this->db->query($sql);
			return false;
		}
		else {
			$produk = "UPDATE str_product SET 
								produk_kode = '$produk_kode', 
								produk_stat = '$produk_stat' WHERE opr_id = '$prov_id'";
			$this->db->query($produk);
			return true;
		}
	}
}
?>