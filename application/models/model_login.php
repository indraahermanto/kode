<?php
class Model_login extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	public function login_user(){
		$username = $this->input->post('InputUsername');
		$password = $this->input->post('InputPassword');

		$sql = "SELECT user_uid, user_pass, user_fname, user_lname, user_lvl, user_email, user_group, user_stat FROM str_user WHERE user_uid = '{$username}' LIMIT 1";
		$result = $this->db->query($sql);
		$row = $result->row();

		if($result->num_rows() === 1){
			if($row->user_stat){
				if($row->user_pass === sha1($this->config->item('salt').$password)){
					$session_data = array(
						'user_uid'	 => $row->user_uid,
						'firstname'	 => $row->user_fname,
						'lastname'	 => $row->user_lname,
						'level'	 	 => $row->user_lvl,
						'user_email' => $row->user_email,
						'group'	 	 => $row->user_group,
						'logged_in'	 => 1,
						);
					$this->set_session($session_data);
					return 'logged_in';
				} else {
					return 'incorrect_password';
				}
			} else {
				return 'not_activated';
			}
		} else {
			return 'username_not_found';
		}
	}

	public function logout_user(){
		$session_data = array('logged_in' => 0);
		$this->set_session($session_data);
	}

	private function set_session($session_data){
		$sess_data = array(
					'user_uid'	 => $session_data['user_uid'],
					'firstname'	 => $session_data['firstname'],
					'lastname'	 => $session_data['lastname'],
					'level'		 => $session_data['level'],
					'user_email' => $session_data['user_email'],
					'group'	 	 => $session_data['group'],
					'logged_in'  => $session_data['logged_in']
			);
		$this->session->set_userdata($sess_data);
	}
}
?>