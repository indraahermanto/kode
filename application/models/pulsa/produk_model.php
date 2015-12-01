<?php
class Produk_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function add($prov_id){
		$produk_id 		= random_string('alnum',5);
		$produk_kode 	= $this->input->post('InputCode');
		$produk_nom 	= $this->input->post('InputNom');
		$produk_profit 	= $this->input->post('InputProfit');
		$produk_cost 	= $this->input->post('InputCost');
		$produk_price 	= $this->input->post('InputPrice');
		$produk_stat 	= $this->input->post('InputStat');
		
		$sql = "INSERT INTO str_product (produk_id, produk_kode, opr_id, produk_nom, produk_hb, produk_hj, produk_un, produk_stat) 
				VALUE ( '".$produk_id."', 
						'".$produk_kode."', 
						'".$prov_id."', 
						'".$produk_nom."', 
						'".$produk_cost."', 
						'".$produk_price."', 
						'".$produk_profit."', 
						'".$produk_stat."'
					   )";
		$result = $this->db->query($sql);
		return true;
	}

	function update($produk_id){
		$produk_profit 	= $this->input->post('InputProfit');
		$produk_cost 	= $this->input->post('InputCost');
		$produk_price 	= $this->input->post('InputPrice');
		$produk_stat 	= $this->input->post('InputStat');

		$sql = "UPDATE str_product SET 
				produk_hb = '$produk_cost', 
				produk_hj = '$produk_price', 
				produk_un = '$produk_profit', 
				produk_stat = '$produk_stat' WHERE produk_id = '$produk_id'";

		$this->db->query($sql);
	}

	function delete($produk_id){
		$this->db->where('produk_id', $produk_id);
		$this->db->delete('str_product');
	}

	function select_all_ready(){
		$this->db->select('*');
		$this->db->from('str_product');		
		$this->db->where('produk_stat', 1);
		return $this->db->get();
	}

	function select_all_ready_paging($limit, $row){
		$this->db->select('*');
		$this->db->from('str_product');		
		$this->db->where('produk_stat', 1);
		$this->db->order_by('opr_nama', 'asc');
		$this->db->limit($limit, $row);
		return $this->db->get();
	}

	function select_by_id($produk_id){
		$sql = "SELECT * FROM str_product WHERE produk_id = '$produk_id'";
		$result = $this->db->query($sql);
		return $result->row();
	}

	function select_by_prov($prov_kode){
		$this->db->where('opr_id',$prov_kode);
		$this->db->order_by('produk_nom', 'asc');
		return $this->db->get('str_product');
	}
}
?>