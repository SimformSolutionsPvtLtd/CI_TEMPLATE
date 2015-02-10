<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {
	
	public function error_404()
	{
		if ($this->uri->segment(1) == 'mobileservice') {
			ob_start('ob_gzhandler');
			
			echo json_encode(array("status"=>"error", "msg"=>"This url can`t access."));
			
			exit(0);
		} else {
			show_error('This url can`t be accessed.<br /><a href="javascript:window.history.back()">back</a>');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */