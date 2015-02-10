<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms_contents extends My_Controller {
	
	public $title = "Contents";
	
	function __construct()
	{
		parent::__construct(array("required_group"=>1));
	}
	
	function index() {
		$view_datas = array();
		
		// search cms_content
		$cms_contents = new Cms_contents();
		//$cms_contents->get();
		
		$view_datas['cms_contents'] = $cms_contents;
		
		$this->add_body_view("admin/cms_contents/list", $view_datas);
		
		$this->show_admin_page();
	}
	
	function edit() {
		$cms_contentid = $this->uri->segment(4);
	
		$cms_content = new Cms_contents();
		$cms_content->get_by_id($cms_contentid);
	
		if ($this->input->post('key') !== FALSE) {
			if ($cms_content->exists()) {
				
			} else {
				$cms_content->created = my_datenow();
			}
			$cms_content->updated = my_datenow();
			
			$success = $cms_content->from_array($_POST, array("key", "value"), TRUE);
			if ($success) {
				$this->session->set_flashdata("message", $cms_content->key . ' was successfully updated.');
				redirect("admin/cms_contents");
			}
		}
                
              
		
		$cms_content->load_extension('htmlform');
		$this->add_body_view("admin/cms_contents/edit", array("cms_content"=>$cms_content));
		
		$this->show_admin_page();
	}
	
	function delete() {
		$cms_contentid = $this->uri->segment(4);
		
		$cms_content = new Cms_contents();
		$cms_content->get_by_id($cms_contentid);
		
		if($cms_content->exists()) {
			$cms_contentname = $cms_content->key;
			$cms_content->delete();
			
			$this->session->set_flashdata('message', $cms_contentname . ' was successfully deleted.');
		} else {
			$this->session->set_flashdata("error", $cms_contentid.": Invalid cms_content id.");
		}
		
		redirect("admin/cms_contents");
	}

	function __make_where(&$cms_contents, $type, $status, $user_id) {
		if ($type != '') {
			$cms_contents->where("type", $type);
		}
		if ($status != '') {
			$cms_contents->where("status", $status);
		}
		if ($user_id != '') {
			$cms_contents->where("user_id", $user_id);
		}
	}
}