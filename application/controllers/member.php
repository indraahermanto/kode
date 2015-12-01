<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

	private $logged_in;

	public function __construct(){
		parent::__construct();
		$this->load->model('model_login');
		if($this->session->userdata('logged_in')){
			$this->logged_in = true;
		} else {
			$this->logged_in = false;
		}
	}
	public function index(){
		if($this->logged_in === true){
			$this->load->view('includes/header', array('logged_in' => $this->logged_in));
			$this->load->view('member/index');
			$this->load->view('includes/footer');
		} else {
			$this->load->view('includes/header', array('logged_in' => $this->logged_in));
			$this->load->view('member/login');
			$this->load->view('includes/footer');
		}
	}
	public function login(){
		if($this->logged_in === true){
			$this->load->view('includes/header', array('logged_in' => $this->logged_in));
			$this->load->view('member/index');
			$this->load->view('includes/footer');
		} else {
			$this->form_validation->set_rules('InputUsername','Username', 'trim|required|min_length[3]|max_length[14]|xss_clean');
			$this->form_validation->set_rules('InputPassword','Password', 'trim|required|min_length[6]|max_length[32]|xss_clean');

			if($this->form_validation->run() == FALSE){
				//Failed register
				$this->load->view('includes/header', array('logged_in' => $this->logged_in));
				$this->load->view('member/login');
				$this->load->view('includes/footer');
			} else {
				$result = $this->model_login->login_user();
				switch ($result) {
					case 'logged_in':
						redirect('','location');
						break;
					case 'incorrect_password':
						$this->load->view('includes/header', array('logged_in' => $this->logged_in));
						$this->load->view('member/login', array('logged_in' => 'incorrect_password'));
						$this->load->view('includes/footer');
						break;
					case 'not_activated':
						$this->load->view('includes/header', array('logged_in' => $this->logged_in));
						$this->load->view('member/login', array('logged_in' => 'not_activated'));
						$this->load->view('includes/footer');
						break;
					case 'username_not_found':
						$this->load->view('includes/header', array('logged_in' => $this->logged_in));
						$this->load->view('member/login', array('logged_in' => 'not_found'));
						$this->load->view('includes/footer');
						break;
				}
			}
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('');
	}
}

?>