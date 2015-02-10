<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH."core/Mobile_Controller.php";

class Auth extends Mobile_Controller {

	public function __construct() {
		parent::__construct(FALSE);
	}

	public function create_account()
	{
		$validation = array(
				"name"		=> array('rules'=>'required|trim|xss_clean'),
				"email"		=> array('rules'=>'required|trim|xss_clean'),
				"password"	=> array('rules'=>'required|trim|xss_clean'),
				"os"		=> array('rules'=>'trim|xss_clean'),
				"device"	=> array('rules'=>'trim|xss_clean'),
				"timezone"	=> array('rules'=>'trim|xss_clean')
		);

		$this->form_validate($validation);
		
		$this->user->username	= $this->request->name;
		$this->user->firstname	= $this->request->firstname;
		$this->user->lastname	= $this->request->lastname;
		$this->user->email		= $this->request->email;
		$this->user->password	= $this->request->password;
		$this->user->group_id	= 2;
		$this->user->actived	= "Y";
		$this->user->status		= "online";	
		$this->user->avatar     = $this->request->avatar;
		
		$this->user->timezone	= $this->request->timezone;
		$this->user->os			= $this->request->os;
		$this->user->device		= $this->request->device;
		
		/*

		if (isset($_FILES['avatar']) && $_FILES['avatar']['tmp_name'] != '') {
		} else {
			$this->error("Select avatar file.");
		}
		
		$this->load->config("upload");

		$config = $this->config->item('attache');
		$this->load->library('upload', $config);
		if ( $this->upload->do_upload("avatar") ) {
			$attache = $this->upload->data();
			
			$avatar = my_finish_upload_file($attache['full_path']);
			
			
		} else {
			$this->error("Failed upload avatar file.");
		}
		*/
		$success = $this->user->save();

		$this->user->trans_complete();
		if ($success === FALSE) {
			$this->error($this->user->error->all);
		}
		
		$today = date('Y-m-d');
		$log = new Log();
		$log->get_by_day($today);
		if ( !$log->exists() ) {
			$log->day			= $today;
			$log->new_users		= 0;
			$log->login_users	= 0;
		}
		$_user = new User();
		$log->new_users	++;
		$log->login_users ++;
		$log->total_users = $_user->where("group_id", 2)->count();
		$log->save();
		
		if ( $this->request->device != '' ) {
			$this->db->query("update users set device='' where device='".$this->request->device."' and `id`<>'".$this->user->id."'");	
		}				
		
		$result = array();
		$result['userid']		= (string)$this->user->id;	
		$result['userinfo']		= $this->user->show_data();
		
		$this->success("Successfully created account", $result);
	}
	/*
	public function verifyemail() {
		$verifycode = $this->uri->segment(4);
		
		if ( $verifycode == '' ) {
			die("<h1>Failed verify your email.</h1>");
		}
		
		$user = new User();
		$user->where("verifycode", $verifycode);
		if ( $user->count() != 1 ) {
			die("<h1>Failed verify your email.</h1>");
		} else {
			$user->where("verifycode", $verifycode);
			$user->get();
			
			$user->verifycode 	= my_create_security( false );
			$user->actived		= "Y";
			$user->save();

			die("<h1>Successfully verify your email.</h1>");
		}
	}*/

	public function login()
	{


		$validation = array(
				"email"		=> array('rules'=>'required|trim|xss_clean'),
				"password"	=> array('rules'=>'required|trim|xss_clean'),
				"os"		=> array('rules'=>'trim|xss_clean'),
				"device"	=> array('rules'=>'trim|xss_clean'),
				"timezone"	=> array('rules'=>'trim|xss_clean')
		);

		$this->form_validate($validation);
		
		$this->user->where("group_id", 2);
		$this->user->where("email", $this->request->email);
		$this->user->get();
		
		if ( !$this->user->exists() ) {
			$this->error("Failed email address.");
		}
		
		if ( sha1($this->user->salt . $this->request->password) != $this->user->password ) {
			$this->error("Failed password.");
		}
		
		if ( $this->user->actived == 'N' ) {
			$this->error("Your account was blocked");
		}
		

		$this->user->status		= "online";;
		$this->user->os			= $this->request->os;
		$this->user->device		= $this->request->device;		

		$success = $this->user->save();

		$this->user->trans_complete();
		if ($success === FALSE) {
			$this->error("Login failed");
		}
	
		$today = date('Y-m-d');
		$log = new Log();
		$log->get_by_day($today);
		if ( !$log->exists() ) {
			$log->day			= $today;
			$log->new_users		= 0;
			$log->login_users	= 0;
		}

		$_user = new User();
		$log->login_users ++;
		$log->total_users = $_user->where("group_id", 2)->count();
		$log->save();

		if ( $this->request->device != '' ) {
			$this->db->query("update users set device='' where device='".$this->request->device."' and `id`<>'".$this->user->id."'");	
		}

		$result = array();
		$result['userid']		= (string)$this->user->id;		
		$result['userinfo']		= $this->user->show_data();
		
		$this->success("Successfull login", $result);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */