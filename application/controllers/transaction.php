<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Transaction extends CI_Controller {
	
	private $logged_in;

	public function __construct(){
		parent::__construct();
		$this->load->model('model_user');
		$this->load->model('model_trx');
		if($this->session->userdata('logged_in') && ($this->session->userdata('level') === 'admin' || $this->session->userdata('level') === 'root'))
			$this->access = true;
		else $this->access = false;
	}

	// bagian pengelolaan agenda
	public function index(){
		if(!$this->access) redirect('');
		$isEmpty = $this->model_trx->isEmpty();
		if($isEmpty) redirect('setup');
		
		if(isset($_POST['submit'])){
			$sess_stat = $this->model_trx->management_saldo();
		}

		if(isset($sess_stat) && substr($sess_stat, 0,6) == "Failed"){
			$this->session->war = $sess_stat;
		}else if(isset($sess_stat)){
			$this->session->msg = $sess_stat;
		}
		$data['logged_in'] = $this->access;
		//$data['saldo'] = $this->model_trx->get_saldo()->result();
		$data['saldo'] = array($this->model_trx->get_saldo_from_trx('pulsa'), $this->model_trx->get_saldo_from_trx('toped'),
								$this->model_trx->get_saldo_from_trx('piutang'), $this->model_trx->get_saldo_from_trx('bank'),
								$this->model_trx->get_saldo_from_trx('cash'), $this->model_trx->get_saldo_from_trx('modal'),
								$this->model_trx->get_saldo_from_trx('untung'));

		$perpage = 20;
		$index = ($this->uri->segment(3, 0)-1)*$perpage;
		if($index === -$perpage) $index = 0;

		if(isset($_GET['submit'])) $search = 1;
		else $search = 0;

		if($this->access){
			$total = $this->model_trx->get_trx($search)->num_rows();
			$data['trx'] = $this->model_trx->get_trx_paging($index, $perpage)->result();
		} else {
			$total = $this->model_trx->get_trx($search)->num_rows();
			$data['trx'] = $this->model_trx->get_trx_paging($index, $perpage)->result();	
		}
		if($total === 0) redirect('setup');
		$config['base_url'] = site_url('transaction/index');
		$config['total_rows'] = $total;
		$config['per_page'] = $perpage;
		$config['num_links'] = 1;
		$config['display_pages'] = FALSE;
		$config['use_page_numbers'] = TRUE;

		$config['last_link'] = '';
		$config['first_link'] = '';
		//class next page
		$config['next_link'] = '<span class="btn btn-primary glyphicon glyphicon-chevron-right"></span>';
		$config['next_tag_open'] = '<div class="pull-right" >';
		$config['next_tag_close'] = '</div>';

		//class prev page
		$config['prev_link'] = '<span class="btn btn-primary glyphicon glyphicon-chevron-left"></span>';
		$config['prev_tag_open'] = '<div class="pull-left" >';
		$config['prev_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		$data['index'] = $index;

		$this->load->view('includes/admin_header', $data);
		$this->load->view('admin/transaction/index', $data);
		$this->load->view('includes/footer');
	}

	public function edit($trx_id){
		$data['logged_in'] = $this->access;

		if(isset($_POST['submit'])){
			$sess_stat = $this->model_trx->edit_transaction();
		}
		if(isset($sess_stat) && $sess_stat == false){
			$this->session->war = $sess_stat;
		}else if(isset($sess_stat) && $sess_stat == 'update'){
			$this->session->msg = 'Update transaksi berhasil.';
		}else if(isset($sess_stat) && $sess_stat == 'cancel'){
			$this->session->msg = 'Cancel transaction success.';
		}

		$data['transaksi'] = $this->model_trx->get_trx_by_trx_id($trx_id)->row();
		if(!$this->access || !isset($trx_id) || !is_numeric($trx_id) || !$data['transaksi']->trx_id)
			redirect('');

		$this->load->view('includes/admin_header', $data);
		$this->load->view('admin/transaction/edit', $data);
		$this->load->view('includes/footer');
	}
}