<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	
	private $logged_in;

	public function __construct(){
		parent::__construct();
		$this->load->model('model_user');
		if($this->session->userdata('logged_in')) $this->logged_in = true;
		else $this->logged_in = false;

		if($this->session->userdata('level') === 'admin' || $this->session->userdata('level') === 'root')
			$this->access = true;
		else $this->access = false;
	}

	// bagian pengelolaan agenda
	public function index(){
		$data['user_dep'] = $this->model_user->get_deposit()->result();
		$data['logged_in'] = $this->logged_in;
		if($this->access){
			$this->load->view('includes/admin_header', $data);
			$this->load->view('admin/main/index', $data);
		}
		else {
			$this->load->view('includes/header', $data);
			$this->load->view('main/index', $data);
		}
		$this->load->view('includes/footer');
	}
}

?>