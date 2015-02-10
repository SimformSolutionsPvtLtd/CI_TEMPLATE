<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {
	
	public $test_appid = "1000000001";
	public $test_appsecurity = "a";
	
	//public $test_appid = "1000001216";
	//public $test_appsecurity = "79d4cbb2dc2554331bf92004285196ea";
	
	public function index()
	{
		$action = $this->uri->segment(2);
		if ($this->uri->segment(3) != '') {
			$action.= "/".$this->uri->segment(3);
		}
		
		if ($action == '') $action = "index";
		
		$this->load->view("test/".$action, array("action"=>$action));
	} 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */