<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends My_Controller {
	
	public $title = "Users";
	
	function __construct()
	{
		parent::__construct(array("required_group"=>1));
	}
	
	public function index() {
		$user = $this->login_manager->get_user();
		
		$user->load_extension('htmlform');
		$this->add_body_view("admin/profile", array("user"=>$user));
		
		$this->show_admin_page();
	}
	
	public function edit() {
		$user = new User();
		
		if ($this->input->post('username') !== FALSE) {
			$user->get_by_id($this->login_user->id);
			
			$user->trans_start();
			
			$success = $user->from_array($_POST, array("username", "email"), TRUE);
			if ($success) {
				$user->trans_complete();
				
				$this->session->set_flashdata("message", "Your profile successfully updated.");
				redirect("admin/profile");
			}
		}
		
		$user->load_extension('htmlform');
		$this->add_body_view("admin/profile", array("user"=>$user));
		
		$this->show_admin_page();
	}
	
	public function password() {
		$user = new User();
	
		if ($this->uri->segment(4) == 'save') {
			$user->get_by_id($this->login_user->id);
				
			$user->trans_start();
				
			$success = $user->from_array($_POST, array("password", "confirm_password"), TRUE);
			
			if ($success) {
				$user->trans_complete();
			
				$this->session->set_flashdata("message", "Your password successfully changed.");
				redirect("admin/profile/password");
			}
		}
		
		$user->load_extension('htmlform');
		$this->add_body_view("admin/change_password", array("user"=>$user));
	
		$this->show_admin_page();
	}
}