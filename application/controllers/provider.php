<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Provider extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('pulsa/produk_model');
		$this->load->model('pulsa/provider_model');
		$this->load->model('model_user');
		$this->load->model('model_login');
		if($this->session->userdata('logged_in')){
			$this->logged_in = true;
		} else {
			$this->logged_in = false;
		}
		if($this->session->userdata('level') === 'admin' || $this->session->userdata('level') === 'root' )
			$this->access = true;
		else $this->access = false;
	}

	public function index(){
		redirect('pulsa');
	}

	public function add(){
		if(!$this->access)
			redirect('pulsa');

		$data['user_dep'] = $this->model_user->get_deposit()->result();
		$data['logged_in'] = $this->logged_in;

		$this->form_validation->set_rules('InputCode','Product Code', 'trim|required|max_length[4]|is_unique[str_operator.opr_id]|xss_clean');
		$this->form_validation->set_rules('InputName','Provider Name', 'trim|required|min_length[4]|max_length[10]|is_unique[str_operator.opr_nama]|xss_clean');
		$this->form_validation->set_rules('InputGroup','Provider Group', 'required');
		$this->form_validation->set_rules('InputStat','Status', 'required');
		$this->form_validation->set_message('is_unique', 'That %s Already Exists.');
		
		if($this->access){
			$this->load->view('includes/admin_header', $data);
		} else $this->load->view('includes/header', $data);

		if($this->form_validation->run() === FALSE){
			//Failed add product
			$this->load->view('admin/brand/provider/add');
		} else {
			if($this->provider_model->add())
				$this->session->msg  = 'Provider berhasil ditambahkan.';
			$this->load->view('admin/brand/provider/add');
		}
		$this->load->view('includes/footer');
	}

	public function edit($prov_id){
		if(!$this->access || !isset($prov_id))
			redirect('pulsa');
		else if(!$this->provider_model->check_by_id($prov_id))
			redirect('pulsa');

		$data['user_dep'] = $this->model_user->get_deposit()->result();
		$data['logged_in'] = $this->logged_in;
		$data['provider'] = $this->provider_model->select_by_id($prov_id);

		$this->form_validation->set_rules('InputCode','Provider Code', 'trim|required|max_length[4]|xss_clean');
		$this->form_validation->set_rules('InputName','Provider Name', 'trim|required|min_length[4]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('InputGroup','Provider Group', 'required');
		$this->form_validation->set_rules('InputStat','Status', 'required');

		if($this->access){
			$this->load->view('includes/admin_header', $data);
		} else $this->load->view('includes/header', $data);
		
		if($this->form_validation->run() === FALSE){
			//Failed add product
			$this->load->view('admin/brand/provider/edit', $data);
		} else {
			if($this->provider_model->update($prov_id))
				$this->session->msg  = 'Provider berhasil diupdate.';
			else {
				$this->session->msg  = '<strong>Gagal!</strong> Kode provider sudah ada.';
				$this->session->class = 'danger';
			}
			$data['provider'] = $this->provider_model->select_by_id($prov_id);
			$this->load->view('admin/brand/provider/edit', $data);
		}
		$this->load->view('includes/footer');
	}
}