<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends My_Controller {
	
	public $title = "Home";
	
	function __construct()
	{
		parent::__construct(array("required_group"=>1));
	}
	
	public function index() {
		redirect("admin/home/registed_user");
	}
	
	public function registed_user() {
		$chat_data = array(
				'chart_dates'	=> array(),
				'total_users'	=> array(),
				'new_users'		=> array(),
				'login_users'	=> array(),
		); 
		
		if ( isset($_POST['fromday']) && isset($_POST['today']) ) {
			$fromday = $_POST['fromday'];
			$today = $_POST['today'];
		} else {
			$today = date("Y-m-d");
			$fromday = date("Y-m-d", strtotime("-30 day", strtotime($today)));
		}
		
		$logs = $this->db->query("select * from logs where '".$fromday."'<=`day` and `day`<='".$today."'");
		
		foreach ( $logs->result() as $log ) {
			$chat_data['chart_dates'][] = $log->day;
			$chat_data['total_users'][] = (int)$log->total_users;
			$chat_data['new_users'][] = (int)$log->new_users;
			$chat_data['login_users'][] = (int)$log->login_users;
		}
		
		$chat_data['fromday'] = $fromday;
		$chat_data['today'] = $today;
		
		$this->add_body_view("admin/home", $chat_data);
		
		$this->show_admin_page();
	}
}