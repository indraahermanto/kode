<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Payment extends CI_Controller {

	private $logged_in;

	public function __construct(){
		parent::__construct();
		$this->load->model('model_user');
		$this->load->model('model_trx');
		if($this->session->userdata('logged_in') && ($this->session->userdata('level') === 'admin' || $this->session->userdata('level') === 'root'))
			$this->access = true;
		else $this->access = false;
	}

	public function index(){
		if(!$this->access) redirect('');

		if($this->input->post('submit') == 'Pay'){
			$pay = $this->model_trx->payment_payable();
			if($pay == true)
				$this->session->msg = "Payment success. Thank you.";
			else $this->session->war = $pay;
		}

		$data['logged_in'] = $this->access;
		$data['piutang'] = $this->model_trx->get_saldo_from_trx('piutang');
		//$data['saldo'] = $this->model_trx->get_saldo()->result();
		$data['trx_hut'] = $this->model_trx->select_trx_hut_all()->result();

		$a = 1;
		foreach ($data['trx_hut'] as $hutang) {
			$id = $hutang->user_id;
			$data['hut'][$a] = $this->model_trx->select_trx_hut_price($id)->row();
			$data['hut_detail'][$a] = $this->model_trx->select_trx_hut_price_detail($id)->result();
			$a++;
		}

		$this->load->view('includes/admin_header', $data);
		$this->load->view('admin/payment/index', $data);
		$this->load->view('includes/footer');
	}
}