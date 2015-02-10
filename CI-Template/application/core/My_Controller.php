<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Controller extends CI_Controller {
	public $body_v = array();
	public $right_v = array(); 
	
	public $_segments		= array();
	public $_currentPage	= 1;
	
	public $login_user = "";
	
	public function __construct($param = array()) {
		// Call the Model constructor
        parent::__construct();
		
        // define for system configuration
        $query = $this->db->get('configurations');
        $configurations = $query->result();
        
        foreach ($configurations as $configuration) {
        	if (defined($configuration->name)) continue;
        	
        	define($configuration->name, $configuration->value);
        }
              
        
        
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        $this->_segments = my_segment_explode($this->uri->uri_string());
        
        $this->load->library('login_manager', array('autologin' => FALSE));
		if (isset($param['required_group'])) {
			$this->login_manager->check_login($param['required_group']);
			
			$this->login_user = $this->login_manager->get_user(); 
			date_default_timezone_set("America/New_York");  
		}
		
		$this->load->library("facebook", array("appId"=>$this->config->item("facebook_app_id"), "secret"=>$this->config->item("facebook_app_secret")));
	}
	
	public function add_right_view($view, $data = array()) {
		$this->right_v[] = array("view"=>$view, "data"=>$data);
	}
	
	public function add_body_view($view, $data = array()) {
		$this->body_v[] = array("view"=>$view, "data"=>$data); 
	}
	
	public function show_page() {
		// include header
		$this->load->view("common/header");
		
		// include body
		for ($i = 0; $i < count($this->body_v); $i ++) {
			if(isset($this->body_v[$i]['data']) && is_array($this->body_v[$i]['data'])) {
				$this->load->view($this->body_v[$i]['view'], $this->body_v[$i]['data']);
			} else {
				$this->load->view($this->body_v[$i]['view']);
			}
		}
		
		// include bottom
		$this->load->view("common/bottom");
	}
	
	public function show_admin_page() {
		// include header
		$this->load->view("admin/common/header");	
		
		// include body
		for ($i = 0; $i < count($this->body_v); $i ++) {
			$this->load->view($this->body_v[$i]['view'], $this->body_v[$i]['data']);
		}
		
		// include bottom
		$this->load->view("admin/common/bottom");
	}
}
?>