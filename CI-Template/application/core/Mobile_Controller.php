<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile_Controller extends CI_Controller {
	public $user	= NULL;

	public $result = array();

	public $request = null;

	public function __construct($check_user = TRUE) {
		// Call the Model constructor
		parent::__construct();
                               
		// define for system configuration		
		$query = $this->db->get('configurations');
		$configurations = $query->result();

		foreach ($configurations as $configuration) {
			if (defined($configuration->name)) continue;
			 
			define($configuration->name, $configuration->value);
		}
                               

		$this->lang->load("mobileservice");

		$this->form_validation->set_error_delimiters('', '\n');
		
		if ($check_user) {
			$validation = array(
					"userid"        => array('rules'=>'trim|required|xss_clean'),
					"appsecurity"	=> array('rules'=>'trim|required|xss_clean'),
			);
			 
			$this->form_validate($validation);
			 
			$this->get_logined_user();
		}
	}

	public function show_result() {
		//ob_start('ob_gzhandler');

		echo json_encode($this->result);
		exit(0);
	}

	public function get_logined_user() {
		$this->user = new User();
		$this->user->get_by_id($this->request->userid);
                               

		if ($this->user->exists() === FALSE || $this->user->security != $this->request->appsecurity) {
			$this->error("You cant`t login in this app.");
		} 
                $timezone = $this->user->timezone;
		date_default_timezone_set("$timezone");                  
                 
		if ( USER_LOCATION_CHECK ) {
			$this->user->ip		= $_SERVER['REMOTE_ADDR'];
			$this->user->agent	= $_SERVER['HTTP_USER_AGENT'];
		}
		
		if ( USER_STATUS_CHECK ) {
			$this->db->query("update users set `status`='offline' where 'logined'<'".(time()-15*60)."' and `status`='online'");
			
			$this->user->logined= time();
			$this->user->status= 'online';
		}
		
		if ( USER_LOCATION_CHECK || USER_STATUS_CHECK ) {
			$this->user->save();
		}
                                
	}

	public function form_validate($validation) {
		$this->request = new stdClass();

		$fileds = array();
		foreach ($validation as $field=>$value) {
				
			$fileds[] = $field;
				
			$rules = $value['rules'];
			$label = $field;
				
			if (isset($value['model']) && $value['model'] != '') {
				$model = $value['model'];
				$this->lang->load("model_".$model);

				$label = $this->lang->line($model."_".$field);
			}
				
			$this->form_validation->set_rules($field, $label, $rules);
				
			$this->request->{$field} = htmlspecialchars($this->input->post($field));
		}

		if ($this->form_validation->run()) {
				
		} else {
			$errors = array();
			for ($i = 0; $i < count($fileds); $i ++) {
				$error = form_error($fileds[$i]);
				if ($error != '') {
					$errors[] = $error;
				}
			}
				
			$this->error($errors);
		}
	}

	public function success($msg="", $result="") {
		$this->result['status'] = "success";

		if ($msg != '')			$this->result['msg']	= $msg;
		if (is_array($result))	$this->result['result']	= $result;

		$this->show_result();
	}
                                                
	public function error($error) {
		$this->result['status'] = "error";
		if (is_array($error)) {
			$this->result['msg']	= implode($error, "\n");
		} else {
			$this->result['msg']	= $error;
		}

		$this->show_result();                            
	}
        
        public function error_mail($error){
            
            my_email_send_error('ronak.k@simform.in', 'Exception Mail',$error);
            
            $this->result['status'] = "error";		
            $this->result['msg'] = "Exception Occured";
		

		$this->show_result(); 
        }
	
	public function get_message( $key, $values = FALSE ) {
		if ( $values === FALSE ) {
			return $this->lang->line( $key );
		} else {
			return sprintf( $this->lang->line( $key ), $values);
		}
	}
}
?>