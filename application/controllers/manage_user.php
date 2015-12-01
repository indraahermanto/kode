<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manage_user extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('model_user');
		$this->load->model('model_login');
		if($this->session->userdata('logged_in')) $this->logged_in = true;
		else $this->logged_in = false;

		if($this->session->userdata('level') === 'admin' || $this->session->userdata('level') === 'root')
			$this->access = true;
		else $this->access = false;
	}

	public function index(){
		$perpage = 15;
		$index = ($this->uri->segment(3, 0)-1)*$perpage;
		if($index === -$perpage) $index = 0;

		$total = $this->model_user->select_all()->num_rows();
		$daftar_user = $this->model_user->select_all_paging($index, $perpage)->result();
		
		$config['base_url'] = site_url('user/index');
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

		$data['users'] = $daftar_user;
		$data['user_dep'] = $this->model_user->get_deposit()->result();
		$data['logged_in'] = $this->logged_in;
		
		if($this->access){
			$this->load->view('includes/admin_header', $data);
			$this->load->view('admin/user/index', $data);
		}
		else {
			$this->load->view('includes/header', $data);
			$this->load->view('main/index', $data);	
		} 
		$this->load->view('includes/footer');
	}
	public function edit($user_uid){
		$data['users'] = $this->model_user->select_by_uid($user_uid)->result();
		if(!isset($user_uid) || !$this->access) redirect('');
		else {
			$data['user_dep'] = $this->model_user->get_deposit()->result();
			$data['logged_in'] = $this->logged_in;
		}

		$this->form_validation->set_rules('FName','First Name', 'trim|required|min_length[3]|max_length[24]|xss_clean');
		$this->form_validation->set_rules('LName','Last Name' , 'trim|required|min_length[3]|max_length[24]|xss_clean');
		$this->form_validation->set_rules('Group','Group', 'required');
		$this->form_validation->set_rules('Level','Group', 'required');

		$this->load->view('includes/admin_header', $data);

		if($this->form_validation->run() === FALSE){
			//Failed add product
			if($this->access && isset($user_uid)){
				$data['user_uid'] = $user_uid;
				$this->load->view('admin/user/edit', $data);
			}
			else $this->load->view('main/index', $data);	
		} else {
			$this->model_user->update($user_uid);
			$this->session->msg = 'Update user berhasil';
			$data['users'] = $this->model_user->select_by_uid($user_uid)->result();

			if($this->access && isset($user_uid)){
				$data['user_uid'] = $user_uid;
				$this->load->view('admin/user/edit', $data);
			}
		}
		
		$this->load->view('includes/footer');
	}	
}