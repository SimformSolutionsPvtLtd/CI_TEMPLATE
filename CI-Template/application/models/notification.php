<?php

/**
 * Notification DataMapper Model
 */
class Notification extends DataMapper {

	// Insert related models that Template can have just one of.
	var $has_one = array();

	// Insert related models that Template can have more than one of.
	var $has_many = array();

	/**
	 * Constructor: calls parent constructor
	 */
    function __construct($id = NULL)
	{
		parent::__construct($id);
    }

    var $default_order_by = array('id' => 'desc');
    
	public function show_data() {
		$result = array(
			"id"	=>  $this->id,
			"type"	=>  $this->type,
                        "sender_id" => $this->sender_id,
                        "receiver_id"=> $this->receiver_id,
                        "message" => $this->message,
			"link_id"	=> $this->link_id,
                        "read_flag"	=> $this->read_flag,
		);
		
		return $result;
	}
}

/* End of file template.php */
/* Location: ./application/models/template.php */
