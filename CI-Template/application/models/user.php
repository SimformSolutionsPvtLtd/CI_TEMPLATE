<?php

/**
 * User Model Class
 */
class User extends DataMapper {
	public function __construct($mobile = FALSE) {
		parent::__construct();
	}
	

	// --------------------------------------------------------------------
	// Relationships
	// --------------------------------------------------------------------
	public $has_many = array();
	
	public $has_one = array('group');
	
	// --------------------------------------------------------------------
	// Validation
	// --------------------------------------------------------------------
	public $validation = array(
		'email' => array(
			'rules' => array('required', 'trim', 'valid_email', 'unique')
		),
		'password' => array(
			'rules' => array('trim', 'min_length' => 3, 'max_length' => 20, 'encrypt'),
			'type' => 'password'
		),
		'confirm_password' => array(
			'rules' => array('encrypt', 'matches' => 'password'),
			'type' => 'password'
		)
	);
	
	// --------------------------------------------------------------------
	function __toString()
	{
		return empty($this->username) ? $this->localize_label('newuser') : $this->username;
	}
	
	/**
	 * Login
	 *
	 * Authenticates a user for logging in.
	 *
	 * @access	public
	 * @return	bool
	 */
	function login($type="username")
	{
		// Create a temporary user object
		$u = new User();
		if ($type == 'username') {
			// backup username for invalid logins
			$uname = $this->username;
			
			// Get this users stored record via their username
			$u->where('username', $uname)->get();
		} elseif ($type == 'email') {
			// backup email for invalid logins
			$email = $this->email;
				
			// Get this users stored record via their email
			$u->where('email', $email)->get();
		}
		
		// Give this user their stored salt
		$this->salt = $u->salt;

		// Validate and get this user by their property values,
		// this will see the 'encrypt' validation run, encrypting the password with the salt
		$this->validate()->get();

		// If the username and encrypted password matched a record in the database,
		// this user object would be fully populated, complete with their ID.

		// If there was no matching record, this user would be completely cleared so their id would be empty.
		if ($this->exists())
		{
			// Login succeeded
			return TRUE;
		}
		else
		{
			// Login failed, so set a custom error message
			$this->error_message('login', $this->localize_label('error_login'));

			if ($type == 'username') {
				// restore username for login field
				$this->username = $uname;
			} elseif ($type == 'email') {
				// restore email for login field
				$this->email = $email;
			}		

			return FALSE;
		}
	}
	 
	// --------------------------------------------------------------------
	
	/**
	 * Encrypt (prep)
	 *
	 * Encrypts this objects password with a random salt.
	 *
	 * @access	private
	 * @param	string
	 * @return	void
	 */
	function _encrypt($field)
	{
		if (!empty($this->{$field}))
		{
			if (empty($this->salt))
			{
				$this->salt = md5(uniqid(rand(), true));
			}

			$this->{$field} = sha1($this->salt . $this->{$field});
		}
	}
	
	public function delete_by_id($id) {
		foreach ($this->has_many as $class=>$params) {
			$model = new $class();
							
			$this->db->where("user_id", $id)->delete($model->table);
		}
		
		return $this->delete();
	}
	
	public function show_data($type='user') {            
              
		$result = array(
				"userid"		=> (string) $this->id,
				"email"			=> (string) $this->email,
				"username"		=> (string) $this->firstname." ".$this->lastname,
				"firstname"		=> (string) $this->firstname,
				"lastname"		=> (string) $this->lastname,
				"avatar"		=> (string) $this->avatar,                               
                "age"			=> $age,                                
                "gender"        => $gender,                                
                "contact"      => $this->phone				
		);

		$result['actived']	= (string) $this->actived;
                
		$result['location']	= array(
				"address"	=> (string) $this->address,
				"latitude"	=> (string) $this->latitude,
				"longitude"	=> (string) $this->longitude,
                                "timezone"	=> (string) $this->timezone
		);
                		                                      
		
		return $result;
	}
               
        
      public function show_details(){
            $result = array(
				"userid"		=> (string) $this->id,				
				"username"		=> (string) $this->firstname." ".$this->lastname,				
				"avatar"		=> (string) $this->avatar,                                                               
		);
            
                return $result;
        }
	
	
	public function fullname() {
		if ( empty($this->firstname) ) return $this->username;
		
		return $this->firstname." ".$this->lastname;
	}
        
        public function shortname(){
                if ( empty($this->firstname) ) return $this->username;
		
		return $this->firstname." ".substr($this->lastname, 0, 1);
        }
}

/* End of file user.php */
/* Location: ./application/models/user.php */