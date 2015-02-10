<?php

/**
 * Log Model Class
 */
class Log extends DataMapper {
	public function __construct($mobile = FALSE) {
		parent::__construct();
		
		if ($mobile === TRUE) {
			$this->error_prefix = "";
			$this->error_suffix = "";
		}
	}
	
	public $new_users	= 0;
	public $login_users = 0;
	public $new_medias	= 0;
}

/* End of file user.php */
/* Location: ./application/models/user.php */