<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once dirname(__FILE__)."/twitter-client.php";

/**
 * Extends the BaseFacebook class with the intent of using
 * PHP sessions to store user ids and access tokens.
 */
class Twitter extends TwitterApiClient {
	
	protected $YOUR_CONSUMER_KEY = "";
	protected $YOUR_CONSUMER_SECRET = "";
	protected $APP_NAME = "";
	protected $TAG_NAME = "";
	
	protected $error = "";
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->config("twitter");
	
		$config = $this->CI->config->item("twitter");
	
		$this->YOUR_CONSUMER_KEY	= $config['consumer_key'];  
		$this->YOUR_CONSUMER_SECRET = $config['consumer_secret'];
		$this->APP_NAME 			= $config['app_name'];
		$this->TAG_NAME 			= $config['tag_name'];
	}
	
	public function set_error($error) {
		$this->error = $error;
	}
	
	public function get_error() {
		return $this->error;
	}
	
	public function tw_api($auth_token, $auth_token_secret, $path, $params = array(), $method = "GET") {
		$this->set_oauth($this->YOUR_CONSUMER_KEY, $this->YOUR_CONSUMER_SECRET, $auth_token, $auth_token_secret);
	
		try {
			$data = $this->call( $path, $params, $method );
	
			if ( is_array($data) ) {
				return json_decode(json_encode($data), FALSE);
			} else {
				return $data;
			}
		} catch (Exception $e) {
			$this->set_error((String) $e);
	
			return FALSE;
		}
	}
	
	public function get_user_profile($auth_token, $auth_token_secret) {
		$account = $this->tw_api($auth_token, $auth_token_secret, 'account/settings' );
		if ( !$account ) return FALSE;
		
		return $this->tw_api($auth_token, $auth_token_secret, 'users/show', array ( 'screen_name' => $account->screen_name ) );
	}
	
	public function get_friends($auth_token, $auth_token_secret, $user_id) {
		$result = $this->tw_api($auth_token, $auth_token_secret, 'friends/list', array ( 'user_id' => $user_id) );
		if ( $result ) {
			return $result->users;
		} else {
			return FALSE;
		}
	}
	
	public function post($auth_token, $auth_token_secret, $media) {
		$postdata = array();
		
		$message = (string)$media;
		$note = " #".$this->TAG_NAME." ".site_url("medias/".$media->id);
		$status = my_cut_str($message, 140 - strlen($note), "").$note; 
		$postdata['status'] = $status;
		if ( !is_null($media->location) ) {
			$place = $this->get_reverse_geocode($auth_token, $auth_token_secret, $media->latitude, $media->longitude);
			if ( $place ) {
				$postdata['lat'] = $media->latitude;
				$postdata['long'] = $media->longitude;
				$postdata['place_id'] = $place->id;
				$postdata['display_coordinates'] = true;
			}
		}
		
		$result = $this->tw_api($auth_token, $auth_token_secret, 'statuses/update', $postdata, "POST" );
		
		if ( $result && isset($result->id_str) ) {
			return $result->id_str;
		} else {
			return FALSE;
		}
	}
	
	public function get_reverse_geocode($auth_token, $auth_token_secret, $lat, $long) {
		$params = array("lat"=>$lat, "long"=>$long);
		
		$result = $this->tw_api($auth_token, $auth_token_secret, 'geo/reverse_geocode', $params );
		
		if ( $result && isset($result->result->places) ) {
			if ( count($result->result->places) > 0 ) {
				return $result->result->places[0];
			}
		} else {
			return FALSE;
		}
	}
}