<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup extends CI_Controller {
	
	private $logged_in;

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('model_user');
		$this->load->model('model_trx');
		if($this->session->userdata('logged_in') && ($this->session->userdata('level') === 'admin' || $this->session->userdata('level') === 'root'))
			$this->access = true;
		else $this->access = false;
	}

	public function index(){
		if(!$this->access) redirect('');
		$isEmptySal = $this->model_trx->isEmptySal()->result();
		$data['logged_in'] = $this->access;

		$this->form_validation->set_rules('InputPulsa','Pulsa', 'trim|required|is_numeric|max_length[8]|xss_clean');
		$this->form_validation->set_rules('InputToped','Tokopedia', 'trim|required|is_numeric|max_length[8]|xss_clean');
		$this->form_validation->set_rules('InputCash','Cash', 'trim|required|is_numeric|max_length[8]|xss_clean');
		$this->form_validation->set_rules('InputBank','Bank', 'trim|required|is_numeric|max_length[8]|xss_clean');
		$this->form_validation->set_rules('InputHut','Hutang', 'trim|required|is_numeric|max_length[8]|xss_clean');

		$this->load->view('includes/admin_header', $data);
		if($this->form_validation->run() == FALSE){
			//Failed setup saldo
			$this->load->view('admin/setup/index',$data);
		} else {
			//Input saldo
			$result = $this->model_trx->setup();
			$isEmptySal = $this->model_trx->isEmptySal()->result();
		}

		foreach ($isEmptySal as $key) {
			foreach ($key as $k) {
				$saldo = $k;
			}
		}
		if($saldo != 0) {
			//redirect('setup/trx');
			redirect('transaction');
			$this->session->msg = "Setup saldo berhasil.";
		}else if(isset($result) && !$result){
			$this->session->war = "Setup saldo gagal.";
			$this->load->view('admin/setup/index',$data);
		}
		
		$this->load->view('includes/footer');
	}
	public function trx(){
		if(!$this->access) redirect('');
		$data['logged_in'] = $this->access;

		$this->load->view('includes/admin_header', $data);
		$this->load->view('admin/setup/trx',$data);
		$this->load->view('includes/footer');
	}
}