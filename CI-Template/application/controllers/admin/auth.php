<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends My_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function index() {
		redirect("admin/auth/login");
	}
	
	public function login()
	{
		$user = $this->login_manager->get_user();
		if($user !== FALSE)
		{
			// already logged in, redirect to welcome page
			redirect('admin/home');
		}
		
		$user = new User();
		if($this->input->post('username') !== FALSE)
		{
			// A login was attempted, load the user data
			$user->from_array($_POST, array('username', 'password'));
			
			// get the result of the login request
			$login_redirect = $this->login_manager->process_login($user);
			if($login_redirect)
			{
				if ($user->group_id != 1) {
					$this->login_manager->logout();
					
					$user->error_message('login', $user->localize_label('error_group_admin'));
				} else {
					if($login_redirect === TRUE)
					{
						// if the result was simply TRUE, redirect to the welcome page.
						redirect('admin/home');
					}
					else
					{
						// otherwise, redirect to the stored page that was last accessed. 
						redirect($login_redirect);
					}
				}
			} 
		}
		
		$user->load_extension('htmlform');
		
		$this->load->view("admin/login", array("user"=>$user));
	}
	
	public function logout() {
		$this->login_manager->logout();
		
		redirect("admin/auth/login");
	}
        
        public function verify_email() {
		
         $code = $_REQUEST['code'];
         $user = New User();
         $user->where("verifycode",$code);
         $success = $user->get();
         
         if($success->result_count()>0){
           $user->update("actived", 'Y');
           echo "Thank you for verifying your email address!";
         }
         else{
             echo "Error in verifying your email address!";
         }
     }    
   
}