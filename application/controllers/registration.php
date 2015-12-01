<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Registration extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('model_user');
		if($this->session->userdata('logged_in')){
			$this->logged_in = true;
		} else {
			$this->logged_in = false;
		}
	}

	public function index(){
		if($this->logged_in)
			redirect('','location');
		else {
			$this->load->view('includes/header', array('logged_in' => $this->logged_in));
			$this->load->view('registration/index');
			$this->load->view('includes/footer');
		}
	}
	public function register(){
		//rules to became a new user
		$this->form_validation->set_rules('InputUsername','Username', 'trim|required|min_length[3]|max_length[14]|is_unique[str_user.user_uid]|xss_clean');
		$this->form_validation->set_rules('InputEmail','Email Address', 'trim|required|min_length[6]|max_length[50]|valid_email|is_unique[str_user.user_email]|xss_clean');
		$this->form_validation->set_rules('InputPassword','Password', 'trim|required|min_length[6]|max_length[32]|matches[InputPasswordConf]|xss_clean');
		$this->form_validation->set_rules('InputPasswordConf','Confirmed Password', 'trim|required|min_length[6]|max_length[32]|xss_clean');
		$this->form_validation->set_rules('FName','First Name', 'trim|required|min_length[3]|max_length[24]|xss_clean');
		$this->form_validation->set_rules('LName','Last Name' , 'trim|required|min_length[3]|max_length[24]|xss_clean');
		$this->form_validation->set_rules('Group','Group', 'required');
		$this->form_validation->set_rules('InputNomor','Phone Number', 'trim|required|numeric|min_length[10]|max_length[13]|is_unique[str_nomor.nomor]|xss_clean');
 		$this->form_validation->set_message('is_unique', 'That %s Already Exists.');

 		$this->load->view('includes/header', array('logged_in' => $this->logged_in));
		if($this->form_validation->run() == FALSE){
			//Failed register
			if(!$this->logged_in)
				$this->load->view('registration/index');
			else redirect('','location');
		} else {
			//success register, get username
			$result = $this->model_user->add();
			if($result){
				if(!$this->logged_in)
					$this->load->view('registration/register_success', array('firstname' => $result));
				else redirect('','location');
			} else {
				echo 'Sorry, there was a problem with the website. Contact admin@siimanto.com and let me them know.';
			}	
		}
		$this->load->view('includes/footer');
	}
	public function validate($email_address, $email_code){
		if(!isset($email_address) || $email_code){
			redirect('','location');
		} else {
			$email_code = trim($email_code);
			$validated = $this->model_user->validate($email_address, $email_code);

			if($validated === true){
				$this->load->view('includes/header', array('logged_in' => $this->logged_in));
				$this->load->view('registration/validated_email', array('email_address' => $email_address));
				$this->load->view('includes/footer');
			} else {
				echo 'Error giving email activated confirmation, please contact '.$this->config->item('admin_email');
			}
		}
	}
}

?>