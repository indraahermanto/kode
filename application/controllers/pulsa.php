<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pulsa extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('pulsa/produk_model');
		$this->load->model('pulsa/provider_model');
		$this->load->model('model_login');
		$this->load->model('model_trx');
		$this->load->model('model_user');
		if($this->session->userdata('logged_in')) $this->logged_in = true;
		else $this->logged_in = false;
		if($this->session->userdata('logged_in') && ($this->session->userdata('level') === 'admin' || $this->session->userdata('level') === 'root'))
			$this->access = true;
		else $this->access = false;
	}

	public function index(){
		$data['user_dep'] = $this->model_user->get_deposit()->result();
		$data['logged_in'] = $this->logged_in;

		$perpage = 6;
		$index = ($this->uri->segment(3, 0)-1)*$perpage;
		if($index === -$perpage) $index = 0;

		if($this->access){
			$total = $this->provider_model->select_all()->num_rows();
			$data['providers'] = $this->provider_model->select_all_paging($index, $perpage)->result();
		} else {
			$total = $this->provider_model->select_all_ready()->num_rows();
			$data['providers'] = $this->provider_model->select_all_ready_paging($index, $perpage)->result();	
		}
		if($total === 0) redirect('provider/add');
		
		$config['base_url'] = site_url('pulsa/index');
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

		$a = 0;
		if($this->access){
			$this->load->view('includes/admin_header', $data);
			foreach ($data['providers'] as $provider) {
				$data['produk_detail'][$a] = $this->produk_model->select_by_prov($provider->opr_id)->result();
				$a++;
			}
			$this->load->view('admin/produk/pulsa/index', $data);
		}
		else { 
			$this->load->view('includes/header', $data);
			$this->load->view('produk/pulsa/index', $data);
		}
		$this->load->view('includes/footer');
	}
	public function add(){
		$data['user_dep'] = $this->model_user->get_deposit()->result();
		$data['logged_in'] = $this->logged_in;
		$data['daftar_provider'] = $this->provider_model->select_all_ready()->result();
		
		$this->form_validation->set_rules('InputCode','Product Code', 'trim|required|min_length[2]|max_length[6]|is_unique[str_product.produk_kode]|xss_clean');
		$this->form_validation->set_rules('InputProv','Provider', 'required');
		$this->form_validation->set_rules('InputNom','Nominal', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('InputProfit','Profit', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('InputCost','Product Cost', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('InputPrice','Product Price' , 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('InputStat','Status', 'required');
		$this->form_validation->set_message('is_unique', 'That %s Already Exists.');

 		
 		if($this->form_validation->run() === FALSE){
			//Failed add product
			if($this->access){
				$this->load->view('includes/admin_header', $data);
				$this->load->view('admin/produk/pulsa/add', $data);
			}
			else redirect('pulsa');
		} else {
			$prov_kode	= $this->input->post('InputProv');
			$prov_id 	= $this->provider_model->select_by_kode($prov_kode);
			if($this->produk_model->add($prov_id->opr_id)){
				$this->session->msg  = 'Produk berhasil ditambahkan.';
			}
			if($this->access){
				$this->load->view('includes/admin_header', $data);
				$this->load->view('admin/produk/pulsa/add', $data);
			}
			else redirect('pulsa');
		}
		$this->load->view('includes/footer');
	}

	public function edit($produk_id){
		$data['user_dep'] = $this->model_user->get_deposit()->result();
		$data['logged_in'] = $this->logged_in;
		if(!isset($produk_id)) redirect('pulsa');

		$data['daftar_provider'] = $this->provider_model->select_all_ready()->result();
		$data['produk_id'] = $produk_id;
		$data['data_produk'] = $this->produk_model->select_by_id($produk_id);

		$this->form_validation->set_rules('InputProfit','Profit', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('InputCost','Product Cost', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('InputPrice','Product Price', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('InputStat','Status', 'required');

 		if($this->form_validation->run() === FALSE){
			//Failed add product
			if($this->access){
				$this->load->view('includes/admin_header', $data);
				$this->load->view('admin/produk/pulsa/edit', $data);
			}
			else redirect('pulsa');
		} else {
			$this->produk_model->update($produk_id);
			$this->session->msg = 'Produk berhasil di update';
			$data['data_produk'] = $this->produk_model->select_by_id($produk_id);
			if($this->access){
				$this->load->view('includes/admin_header', $data);
				$this->load->view('admin/produk/pulsa/edit', $data);
			}
			else redirect('pulsa');
		}
		$this->load->view('includes/footer');
	}

	public function delete($produk_id){
		$data['user_dep'] = $this->model_user->get_deposit()->result();
		$data['logged_in'] = $this->logged_in;
		if(!isset($produk_id) || !$this->access) redirect('pulsa');
		else
			$this->produk_model->delete($produk_id);
		redirect('pulsa');
	}

	public function buy(){
		if(!$this->access) redirect('');
		$data['logged_in'] = $this->access;
		$data['daftar_provider'] = $this->provider_model->select_all_ready()->result();

		$this->load->view('includes/admin_header', $data);
		if(isset($_POST['submit']) && $_POST['submit'] == 'Process'){
			$trx = $this->model_trx->buy_pulsa();
			if($trx == false)
				$this->session->war = 'Failed : Not enough saldo pulsa, please deposit first.';
			else $this->session->msg = 'Success : '.$trx;
		}
		$this->load->view('admin/produk/pulsa/buy', $data);
		$this->load->view('includes/footer');
	}
}

?>