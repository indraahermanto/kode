<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product2 extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('pulsa/produk_model');
		$this->load->model('pulsa/provider_model');
		$this->load->model('model_login');
		if($this->session->userdata('logged_in')){
			$this->logged_in = true;
		} else {
			$this->logged_in = false;
		}
	}

	public function index(){
		$view_product = $this->model_login->level();
		$perpage = 15;

		$index = ($this->uri->segment(3, 0)-1)*$perpage;
		if($index === -$perpage) $index = 0;
		$key = $this->input->get('key');
		if(!isset($key) || $key === ''){
			$config['suffix'] = '';
			$total = $this->produk_model->select_all()->num_rows();
			$daftar_produk = $this->produk_model->select_all_paging($index, $perpage)->result();
			if($total === 0) redirect('product/add');
		} else {
			$config['suffix'] = '?key='.$key;
			$total = $this->produk_model->search($key)->num_rows();
			$daftar_produk = $this->produk_model->search_paging($index, $perpage, $key)->result();
		}

		$config['base_url'] = site_url('product');
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['first_tag_open'] = '<div>';
		$config['first_tag_close'] = '</div>';
		$config['total_rows'] = $total;
		$config['per_page'] = $perpage;
		$config['num_links'] = 1;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		
		$data['index'] = $index;
		$data['daftar_produk'] = $daftar_produk;
		$data['key'] = $key;
		
		$this->load->view('includes/header', array('logged_in' => $this->logged_in));
		$this->load->view($view_product.'index', $data);
		$this->load->view('includes/footer');
	}
	public function add(){
		$view_product = $this->model_login->level();
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
			$this->load->view('includes/header', array('logged_in' => $this->logged_in));
			$this->load->view($view_product.'add', $data);
			$this->load->view('includes/footer');	
		} else {
			if($this->produk_model->add()){
				$this->session->msg  = 'Produk berhasil ditambahkan.';
			}
			$this->load->view('includes/header', array('logged_in' => $this->logged_in));
			$this->load->view($view_product.'add', $data);
			$this->load->view('includes/footer');
		}	
	}

	public function edit($produk_kode){
		if(!isset($produk_kode)) redirect('product');

		$data['daftar_provider'] = $this->provider_model->select_all_ready()->result();
		$data['produk_kode'] = $produk_kode;
		$data['data_produk'] = $this->produk_model->select_by_kode($produk_kode);

		$this->form_validation->set_rules('InputProfit','Profit', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('InputCost','Product Cost', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('InputPrice','Product Price', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('InputStat','Status', 'required');

 		if($this->form_validation->run() === FALSE){
			//Failed add product
			$this->load->view('includes/header', array('logged_in' => $this->logged_in));
			$this->load->view('admin/produk/pulsa/edit', $data);
			$this->load->view('includes/footer');
		} else {
			$this->produk_model->update($produk_kode);
			$data['msg'] = 'Produk berhasil di update';
			$data['data_produk'] = $this->produk_model->select_by_kode($produk_kode);

			$this->load->view('includes/header', array('logged_in' => $this->logged_in));
			$this->load->view('admin/produk/pulsa/edit', $data);
			$this->load->view('includes/footer');
		}
	}

	public function delete($produk_kode){
		if(!isset($produk_kode)) redirect('product');
		$this->produk_model->delete($produk_kode);
		redirect('product');
	}
}

?>