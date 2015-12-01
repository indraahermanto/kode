<?php
class Model_user extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	private $email_code;

	public function add(){
		$username = strtolower($this->input->post('InputUsername'));
		$email = strtolower($this->input->post('InputEmail'));
		$password = sha1($this->config->item('salt'). $this->input->post('InputPassword'));
		$firstname = ucfirst(strtolower($this->input->post('FName')));
		$lastname = ucfirst(strtolower($this->input->post('LName')));
		$group = strtolower($this->input->post('Group'));
		$idnomor = random_string('alnum',4);
		$nomor = $this->input->post('InputNomor');
		
		$sql = "INSERT INTO str_user (user_uid, user_pass, user_fname, user_lname, user_lvl, user_email, user_group, user_stat)
				VALUES ('".$username."', 
					   '".$password."', 
					   ".$this->db->escape($firstname).", 
					   ".$this->db->escape($lastname).", 
					   'cust', 
					   '".$email."', 
					   ".$this->db->escape($group).", 0)";
		$result = $this->db->query($sql);

		$user_id = $this->select_by_uid($username)->row();

		$queryNomor = "INSERT INTO str_nomor (nomor_id, cus_id, nomor, nomor_stat) 
						VALUES (".$this->db->escape($idnomor).", 
								".$user_id->user_id.", 
								".$this->db->escape($nomor).", 1)";
		$rs = $this->db->query($queryNomor);

		if($this->db->affected_rows() === 1){
			$this->set_session($email, $firstname, $lastname, $group);
			$this->send_validation_email();
			return $firstname;
		} else{
			$this->load->library('email');
			$this->email->from($this->config->item('bot_email'),'Siimanto Administrator');
			$this->email->to($this->config->item('admin_email'));
			$this->email->subject('Problem inserting user into database');

			if(isset($email)){
				$this->email->message('Unable to register and insert user with the email of '.$email.' to the database');
			} else {
				$this->email->message('Unable to register and insert user to the database');
			}

			$this->email->send();
			return false;	
		}
	}

	public function validate($email_address, $email_code){
		$sql = "SELECT user_email, user_reg_time, user_fname FROM str_user WHERE user_email = '{$email_address}' LIMIT 1";
		$result = $this->db->query($sql);
		$row = $result->row();

		if($result->num_rows() === 1 && $row->user_fname){
			if(md5((string)$row->user_reg_time) === $email_code){
				$result = $this->activate_account($email_address);
			} else {
				$result = false;
			}
			if($result === true){
				return true;
			} else {
				echo 'There was an error when activating your account. Please contact the admin at '.$this->config->item('admin_email');
				return false;
			}
		} else {
			echo 'There was an error validating your account. Please contact the admin at '.$this->config->item('admin_email');
			return false;
		}
	}

	public function set_session($email, $firstname, $lastname, $group){
		$sql = "SELECT user_uid, user_reg_time, user_lvl FROM str_user WHERE user_email = '".$email."' LIMIT 1";
		$result = $this->db->query($sql);
		$row = $result->row();

		$sess_data = array(
					'user_uid'	 => $row->user_uid,
					'firstname'	 => $firstname,
					'lastname'	 => $lastname,
					'level'	 	 => $row->user_lvl,
					'user_email' => $email,
					'group'	 	 => $group,
					'logged_in'  => 0
			);
		$this->email_code = md5((string)$row->user_reg_time);
		$this->session->set_userdata($sess_data);
	}

	private function send_validation_email(){
		$this->load->library('email');
		$email = $this->session->userdata('user_email');
		$email_code = $this->email_code;

		$this->email->set_mailtype('html');
		$this->email->from($this->config->item('bot_email'), 'Siiimanto Website');
		$this->email->to($email);
		$this->email->subject('Please activate your account at Siimanto Website');

		$message = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; 
					charset=utf-8"/></head><body>';
		$message .= '<p>Dear '.$this->session->userdata('firstname').',</p>';
		$message .= '<p>Thanks for registering on Siimanto Website! Please <strong><a href="'.base_url().'registration/validate/'.$email.'/'.$email_code.'">click here</a></strong> to activate your account. After you have activated your account, you will be able to log into Siimanto Website and start doing bussiness!</p>';
		$message .= '<p>Thank you</p>';
		$message .= '<p>The Team at Siimanto Website</p>';
		$message .= '</body></html>';

		$this->email->message($message);
		$this->email->send();
	}

	private function activate_account($email_address){
		$sql = "UPDATE str_user SET user_stat = 1 WHERE user_email = '".$email_address."' LIMIT 1";
		$this->db->query($sql);
		if($this->db->affected_rows() === 1){
			return true;
		} else {
			echo 'Error when activating your account in the database, please contact '.$this->config->item('admin_email');
			return false;
		}
	}

	public function select_all(){
		$this->db->order_by('user_id', 'asc');
		return $this->db->get('str_user');
	}

	public function select_all_paging($row, $limit){
		$this->db->order_by('user_id', 'asc');
		$this->db->limit($limit, $row);
		return $this->db->get('str_user');
	}

	public function select_by_uid($user_uid){
		$this->db->where('user_uid', $user_uid);
		return $this->db->get('str_user');
	}

	public function get_deposit(){
		$user_uid = $this->session->userdata('user_uid');
		$this->db->select('user_saldo');
		$this->db->where('user_uid', $user_uid);
		return $this->db->get('str_user');
	}

	public function edit($user_uid){
		$email = strtolower($this->input->post('InputEmail'));
		$firstname = ucfirst(strtolower($this->input->post('FName')));
		$lastname = ucfirst(strtolower($this->input->post('LName')));
		$group = strtolower($this->input->post('Group'));
		$level = strtolower($this->input->post('Level'));
	}

	public function update($user_uid){
		$firstname = ucfirst(strtolower($this->input->post('FName')));
		$lastname = ucfirst(strtolower($this->input->post('LName')));
		$group = strtolower($this->input->post('Group'));
		$level = strtolower($this->input->post('Level'));

		$data = array(
               'user_fname' => $firstname,
               'user_lname' => $lastname,
               'user_group' => $group,
               'user_lvl'	=> $level
            );
		$this->db->where('user_uid', $user_uid);
		$this->db->update('str_user', $data);
	}

	public function auto_register($user_uid, $nomor, $prov_id){
		$password = sha1($this->config->item('salt').$user_uid);
		$idnomor = random_string('alnum',4);

		$sql = "INSERT INTO str_user (user_uid, user_pass, user_lvl, user_stat)
				VALUES ('".$user_uid."', 
					   '".$password."', 'cust', 1)";
		$this->db->query($sql);

		$user_id = $this->select_by_uid($user_uid)->row();
		$queryNomor = "INSERT INTO str_nomor (nomor_id, cus_id, opr_id, nomor, nomor_stat) 
						VALUES (".$this->db->escape($idnomor).", 
								".$user_id->user_id.", 
								".$this->db->escape($prov_id).", 
								".$this->db->escape($nomor).", 1)";
		$rs = $this->db->query($queryNomor);
		return true;
	}

	public function add_number($user_id, $prov_id, $nomor){
		$idnomor = random_string('alnum',4);
		$queryNomor = "INSERT INTO str_nomor (nomor_id, cus_id, opr_id, nomor, nomor_stat) 
						VALUES (".$this->db->escape($idnomor).", 
								".$user_id.", 
								".$this->db->escape($prov_id).", 
								".$this->db->escape($nomor).", 1)";
		$rs = $this->db->query($queryNomor);
	}

	public function get_number_id($nomor){
		$this->db->where('nomor',$nomor);
		return $this->db->get('str_nomor')->row();
	}

	public function get_number($nomor_id){
		$this->db->where('nomor_id',$nomor_id);
		return $this->db->get('str_nomor')->row();
	}
}
?>