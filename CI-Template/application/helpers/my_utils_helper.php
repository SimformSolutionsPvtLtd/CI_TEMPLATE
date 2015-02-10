<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if( ! function_exists('my_show_message')) {
	function my_show_message($msg = "") {
		if ($msg != '') {
			echo '<h4 class="alert_info">'.$msg.'</h4>';
		}
	}
}

if( ! function_exists('my_show_error')) {
	function my_show_error($msg = "") {
		if ($msg != '') {
			echo '<h4 class="alert_error">'.$msg.'</h4>';
		}
	}
}

if( ! function_exists('my_img_url')) {
	function my_img_url($img) {
		return WEBSITE_ROOT."static/images/".$img;
	}
}

if( ! function_exists('my_icon')) {
	function my_icon($name, $alt = 'icon', $size = 16) {
		$alt = htmlspecialchars($alt);
		return '<img src="' . my_img_url("icons/$size/$name.png") . "\" width=\"$size\" height=\"$size\" alt=\"$alt\" title=\"$alt\" />";
	}
}

if( ! function_exists('my_cut_str')) {
	function my_cut_str($str, $len=20, $suffix="…") {
		$s = substr(strip_tags($str), 0, $len);
		$cnt = 0;
		for ($i=0; $i<strlen($s); $i++)
		if (ord($s[$i]) > 127)
		$cnt++;

		$s = substr($s, 0, $len - ($cnt % 3));

		if (strlen($s) >= strlen($str))
		$suffix = "";
		return $s . $suffix;
	}
}

if( ! function_exists('my_segment_explode')) {
	function my_segment_explode($seg) {
		$len = strlen($seg);
		if(substr($seg, 0, 1) == '/') {
			$seg = substr($seg, 1, $len);
		}
		$len = strlen($seg);
		if(substr($seg, -1) == '/') {
			$seg = substr($seg, 0, $len-1);
		}
		$seg_exp = explode("/", $seg);
		return $seg_exp;
	}
}

if( ! function_exists('my_get_param')) {
	function my_get_param($seg, $key, $default = "") {
		if(in_array($key, $seg)) {
			$arr_key = array_keys($seg, $key);
			$arr_val = $arr_key[0] + 1;
			if(@$seg[$arr_val]){
				return $seg[$arr_val];
			} else {
				return $default;
			}
		} else {
			return $default;
		}
	}
}

if( ! function_exists('my_switch_param')) {
	function my_switch_param($seg, $key, $value="") {
		if(in_array($key, $seg)) {
			$arr_key = array_keys($seg, $key);
			$arr_val = $arr_key[0] + 1;
			if(@$seg[$arr_val]){
				if ($value == "") {
					unset($seg[$arr_val - 1]);
					unset($seg[$arr_val]);
				} else {
					$seg[$arr_val] = $value;
				}
			} else {
				if ($value == "") {
					unset($seg[$arr_val - 1]);
				} else {
					$seg[$arr_val] = $value;
				}
			}
		} elseif ($value != "") {
			$seg[] = $key;
			$seg[] = $value;
		}

		return site_url(implode('/', $seg));
	}
}

if( ! function_exists('my_ext_param')) {
	function my_ext_param($seg, $index) {
		$ext_params = "";
		for ($i = $index; $i < count($seg); $i ++) {
			$ext_params.=("/".$seg[$i]);
		}

		return $ext_params;
	}
}

if( ! function_exists('my_datenow')) {
	function my_datenow() {
		return date('Y-m-d H:i:s');
	}
}

if( ! function_exists('my_get_format_datetime')) {
	function my_get_format_datetime($time, $timezone='', $format = 'm/d/Y H:i:s') {
		if ($timezone != '') {
			if ( substr($timezone, 0, 1) == "+" ) {
				$timezone = "-".substr($timezone, 1);
			} elseif ( substr($timezone, 0, 1) == "-" ) {
				$timezone = "+".substr($timezone, 1);
			}

			return date($format, strtotime($timezone, $time));
		} else {
			return date($format, $time);
		}
	}
}

if( ! function_exists('my_get_after_time')) {
	function my_get_after_time($regtime, $timezone='', $format = 'm/d, h:i A') {
		$diff = time() - $regtime + 1; //Find the number of seconds
		$day_difference = ceil($diff / (60*60*24)) ;  //Find how many days that is
		$hour_difference = ceil($diff / (60*60)) ;
		$minute_difference = ceil($diff / 60) ;

		$after_date = "";
		if($day_difference <= 1) {
			if ($hour_difference <= 1) {
				$after_date = $minute_difference." minutes ago";
			} else {
				$after_date = $hour_difference." hours ago";
			}
		} /*elseif($day_difference <= 7) {
		$after_date = $day_difference." ";
		}*/ else {
		$after_date = my_get_format_datetime($regtime, $timezone, $format);
		}

		return $after_date;
	}
}

if( ! function_exists('my_get_chat_time')) {
	function my_get_chat_time($chattime, $timezone='') {
		$diff = time() - $chattime + 1; //Find the number of seconds
		$day_difference = ceil($diff / (60*60*24)) ;  //Find how many days that is
		$hour_difference = ceil($diff / (60*60)) ;
		$minute_difference = ceil($diff / 60) ;

		$after_date = "";
		if($day_difference <= 1) {
			$after_date = my_get_format_datetime($chattime, $timezone, "h:i A");
		} elseif($day_difference <= 7) {
			$after_date = my_get_format_datetime($chattime, $timezone, "D, h:i A");
		} else {
			$after_date = my_get_format_datetime($chattime, $timezone, 'm/d, h:i A');
		}

		return $after_date;
	}
}

if( ! function_exists('my_finish_upload_file')) {
	function my_finish_upload_file($file_path) {
		/*$year = date('Y');
		$month = date('m');
		$day = date('d');

		$upload_dir = $year."-".$month."-".$day."/";*/
        $upload_dir = "multipart/";
		$upload_root = DIR_DOCUMENT_ROOT."upload/";

		@chmod($upload_root, 0755);

		if (!is_dir($upload_root.$upload_dir)) {
			if (@mkdir($upload_root.$upload_dir, 0755)) {
			} else {
				@unlink($file_path);
				return FALSE;
			}
		}

		$post_file	= pathinfo($file_path);
		$file_name	= url_title($post_file['filename']);
		$file_type	= $post_file['extension']!=''?(".".$post_file['extension']):"";

		while (file_exists($upload_root.$upload_dir.$file_name.$file_type)) {
			$file_name .= rand(100, 999);
		}

		$file_name.= $file_type;

		if (@rename($file_path, $upload_root.$upload_dir.$file_name) === FALSE) {
			@unlink($file_path);
			return FALSE;
		} else {
			return $upload_dir.urlencode($file_name);
		}
	}
}

if( ! function_exists('my_download_file_from_url')) {
	function my_download_file_from_url($url) {
		$upload_dir = date("Y-m-d")."/";
		$upload_root = DIR_DOCUMENT_ROOT."upload/";

		@chmod($upload_root, 0777);

		if (!is_dir($upload_root.$upload_dir)) {
			if (@mkdir($upload_root.$upload_dir, 0755)) {
			} else {
				return FALSE;
			}
		}

		$_file		= pathinfo($url);
		$file_name	= $_file['filename'];
		$file_type	= "";
		if (isset($_file['extension'])) {
			$file_type	= ".".$_file['extension'];
		}

		while (file_exists($upload_root.$upload_dir.$file_name.$file_type)) {
			$file_name .= rand(10000, 99999);
		}

		$file_name.= $file_type;

		if (@file_put_contents($upload_root.$upload_dir.$file_name, @fopen($url, "r"))) {
			return $upload_dir.urlencode($file_name);
		} else {
			return FALSE;
		}
	}
}

if( ! function_exists('my_get_html_data_from_dbdata')) {
	function my_get_html_data_from_dbdata($str) {
		$result = str_replace("\"", '"', $str);
		$result = str_replace("\'", "'", $result);
		$result = str_replace("\n", "<br/>", $result);
		return $result;
	}
}

if( ! function_exists('my_get_search_url')) {
	function my_get_search_url($basic_url, $params) {
		for ($i = 0; $i < count($params); $i ++) {
			if (!isset($_POST[$params[$i]])) continue;

			$value = htmlspecialchars($_POST[$params[$i]]);
			if ($value == "") continue;

			$basic_url.=("/".$params[$i]."/".$value);
		}

		return $basic_url;
	}
}

if( ! function_exists('my_get_long_length')) {
	function my_get_long_length($latitude, $longitude, $lat_length=111000) {
		$lng_length = abs($lat_length * cos($latitude));

		return $lng_length;
	}
}

if( ! function_exists('my_get_length_by_itude')) {
	function my_get_length_by_itude($lat1, $lng1, $lat2, $lng2, $lat_len=111000) {
		$lng_len = my_get_long_length($lat1, $lat2, $lat_len);

		return round(sqrt(pow(($lat2-$lat1)*$lat_len, 2) + pow(($lng2-$lng1)*$lng_len, 2)));
	}
}

if( ! function_exists('my_get_length_by_itude_mile')) {
	function my_get_length_by_itude_mile($lat1, $lon1, $lat2, $lon2) {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;           
            return round($miles,1)." Miles";
       }
}

if( ! function_exists('my_get_length_by_itude_mi')) {
	function my_get_length_by_itude_mil($lat1, $lon1, $lat2, $lon2) {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;           
            return round($miles,1)." Mi";
       }
}

if( ! function_exists('my_get_sql_by_itude')) {
	function my_get_sql_by_itude($v_lat, $v_lng, $f_lat="latitude", $f_lng="longitude", $lat_len=111000) {
		//$lng_len = my_get_long_length($v_lat, $v_lng, $lat_len);

		//return "round(sqrt(pow((`".$f_lat."`-".$v_lat.")*".$lat_len.", 2) + pow((`".$f_lng."`-".$v_lng.")*".$lng_len.", 2)))";
                return "( 3959 * acos( cos( radians( $v_lat ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($v_lng ) ) + sin( radians( $v_lat )) * sin( radians( latitude ) ) ) )";
	}
}

if( ! function_exists('my_get_username_from_email')) {
	function my_get_username_from_email($email) {
		$temp = explode("@", $email);
		return $temp[0];
	}
}

if( ! function_exists('my_get_username_from_id')) {
	function my_get_username_from_id($id) {
		$user = new User();
                $user->get_by_id($id);
            
		return $user->username;
	}
}

if( ! function_exists('my_check_following')) {
	function my_check_following($follower_id, $following_id) {
		$following = new Following();
		$following->where("follower_id", $follower_id);
		$following->where("following_id", $following_id);

		return $following->count() == 0 ? FALSE : TRUE;
	}
}

if( ! function_exists('my_get_followers')) {
	function my_get_followers($userid, $string=FALSE) {
		$following = new Following();
		$following->where("following_id", $userid);
		$following->get();

		$followers = array();
		foreach ($following as $f) {
			$followers[] = $f->follower_id;
		}

		if ( $string ) {
			if ( count($followers) == 0 ) {
				return "";
			}
			return implode(",", $followers);
		} else {
			return $followers;
		}
	}
}

if( ! function_exists('my_get_followings')) {
	function my_get_followings($userid, $string=FALSE) {
		$following = new Following();
		$following->where("follower_id", $userid);
		$following->get();

		$followings = array();
		foreach ($following as $f) {
			$followings[] = $f->following_id;
		}

		if ( $string ) {
			if ( count($followings) == 0 ) {
				return "";
			}
			return implode(",", $followings);
		} else {
			return $followings;
		}
	}
}

if( ! function_exists('my_get_newsfeed')) {
	function my_get_newsfeed($userid, $action, $minid, $maxid, $keyword, $limit=10) {
		$followers = my_get_followers($userid);
		$followers[] = $userid;
		//if ( count($followers) == 0 ) return FALSE;

		$resay_posts = array();

		/*$resays = new Media_resay();
		 $resays->where_in("user_id", $followers);
		 $resays->get();

		 foreach ($resay_posts as $r) {
		 $resay_posts[] = $r->media_id;
		 }*/

		$sql = "select `id`, `media_id` from user_medias where ";
		$sql.= "user_id in (".implode(",", $followers).")";
		/*if ( count($resay_posts) > 0 ) {
			$sql.= " or `id` in (".implode(",", $resays).")";
			}
			$sql.= ")";*/
		if ( $keyword != '') {
			$sql.= " and contents like ('".$keyword."')";
		}
		//$sql.= " and visibility='public'";

		if ( $action == 'after' && $minid > 0 ) {
			$sql.=" and `id` < '".$minid."' order by `id` desc";
		} elseif ( $action == 'before' && $maxid > 0 ) {
			$sql.=" and `id` > '".$maxid."' order by `id` asc";
		} else {
			$sql.=" order by `id` desc";
		}
		$sql.= " limit ".$limit;

		return $sql;
	}
}

if( ! function_exists('my_get_file_url')) {
	function my_get_file_url($image) {
		if ( strlen($image) == 0 ) return "";

		return WEB_UPLOAD_PATH.$image;
	}
}

//if( ! function_exists('my_get_username_from_email')) {
//	function my_get_username_from_email($email) {
//		$info = explode("@", $email);
//		return $infop[0];
//	}
//}

if( ! function_exists('my_create_security')) {
	function my_create_security( $unique = FALSE ) {
		/*$security = md5(uniqid(rand(), true));

		if ( $unique ) {
		$_user = new User();
		do {
		if ( $_user->where("security", $security)->count() == 0 ) {
		break;
		}

		$security = md5(uniqid(rand(), true));
		} while( true );
		}
		return $security;*/

		return "a";
	}
}

if( ! function_exists('my_email_send')) {
	function my_email_send($toemail, $subject, $email_template, $params, $fromemail="", $fromname="") {		
                $CI = get_instance();
		$body = $CI->load->view('emails/'.$email_template, $params, TRUE);
		
                $CI->load->library('email');
                $config['protocol'] = "smtp";
                $config['smtp_host'] = "";
                $config['smtp_port'] = "";
                $config['smtp_user'] = ""; 
                $config['smtp_pass'] = "";
                $config['charset'] = "utf-8";
                $config['mailtype'] = "html";
                $config['newline'] = "\r\n";

                $CI->email->initialize($config);
                
                if ( $fromemail == '' ) $fromemail = CONTACT_EMAIL;
		if ( $fromname == '' ) $fromname = SITE_TITLE;
                
                $CI->email->from($fromemail, $fromname);               
                $CI->email->to($toemail);
                $CI->email->reply_to($fromemail);
                $CI->email->subject($subject);
                $CI->email->message($body);
                $result = $CI->email->send();
                
                return $result;
	
	}
}

if( ! function_exists('my_email_send_error')) {
	function my_email_send_error($toemail, $subject,$error) {		
                $CI = get_instance();		
		
                $CI->load->library('email');
                $config['protocol'] = "smtp";
                $config['smtp_host'] = "";
                $config['smtp_port'] = "";
                $config['smtp_user'] = ""; 
                $config['smtp_pass'] = "";
                $config['charset'] = "utf-8";
                $config['mailtype'] = "html";
                $config['newline'] = "\r\n";

                $CI->email->initialize($config);
                             
                
                $CI->email->from('ronak.k@simform.in', 'Ronak Kotecha');               
                $CI->email->to($toemail);
                $CI->email->reply_to("ronak.k@simform.in");
                $CI->email->subject($subject);
                $CI->email->message("$error");
                $result = $CI->email->send();              
              
                return $result;

	
	}
}

if ( !function_exists("my_generator_password")) {
	function my_generator_password($pw_length = 8, $user_en = true, $use_caps = true, $use_numeric = true, $use_specials = true) {
		if ( !$user_en && !$use_caps && !$use_numeric && !$use_specials ) {
			$user_en = true;
		}
		$chars = array();
		$caps = array();
		$numbers = array();
		$num_specials = 0;
		$reg_length = $pw_length;
		$pws = array();
		if ($user_en) for ($ch = 97; $ch <= 122; $ch++) $chars[] = $ch; // create a-z
		if ($use_caps) for ($ca = 65; $ca <= 90; $ca++) $caps[] = $ca; // create A-Z
		if ($use_numeric) for ($nu = 48; $nu <= 57; $nu++) $numbers[] = $nu; // create 0-9
		$all = array_merge($chars, $caps, $numbers);
		if ($use_specials) {
			$reg_length =  ceil($pw_length*0.75);
			$num_specials = $pw_length - $reg_length;
			if ($num_specials > 5) $num_specials = 5;
			for ($si = 33; $si <= 47; $si++) $signs[] = $si;
			$rs_keys = array_rand($signs, $num_specials);
			foreach ($rs_keys as $rs) {
				$pws[] = chr($signs[$rs]);
			}
		}
		$rand_keys = array_rand($all, $reg_length);
		foreach ($rand_keys as $rand) {
			$pw[] = chr($all[$rand]);
		}
		$compl = array_merge($pw, $pws);
		shuffle($compl);
		return implode('', $compl);
	}
}

if ( !function_exists("my_encrypt")) {
	function my_encrypt($data) {
		$str = "";
		if ( is_array($data) ) {
			$str = json_encode($data);
		} else {
			$str = $data;
		}

		$s_key = my_generator_password(16, true, true, true, false);
		$s_vector_iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB), MCRYPT_RAND);

		$en_str = mcrypt_encrypt(MCRYPT_3DES, $s_key, $str, MCRYPT_MODE_ECB, $s_vector_iv);

		$result = base64_encode($en_str);
		//$result = bin2hex($en_str);

		return substr($result, 0, 16) . $s_key . substr($result, 16);
	}
}

if ( !function_exists("my_decrypt")) {
	function my_decrypt($data) {
		$s_vector_iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB), MCRYPT_RAND);

		$s_key = substr($data, 16, 16);

		$str = substr($data, 0, 16).substr($data, 32);
		//$de_str = pack("H*", $str);
		$de_str = base64_decode($str);

		return trim(mcrypt_decrypt(MCRYPT_3DES, $s_key, $de_str, MCRYPT_MODE_ECB, $s_vector_iv));
	}
}

if ( !function_exists("my_file_get_contents")) {
	function my_file_get_contents( $url ) {
		if ( defined("SYSTEM_PROXY_SERVER") ) {
			$aContext = array(
				"http"	=> array("proxty"=>"tcp://".SYSTEM_PROXY_SERVER, "request_fulluri"=>true),
			);

			$cxContext = stream_context_create($aContext);
		} else {
			$cxContext = stream_context_create();
		}

		return file_get_contents($url, FALSE, $cxContext);
	}
}

if( ! function_exists('my_send_notification')) {
	function my_send_notification($sender, $receivers, $message, $type, $link_id) {
                                               
		if ( $receivers === FALSE ) return;
		
		$CI = & get_instance();
		
		$iphones = array();
		$androids = array();
		
		foreach ( $receivers as $receiver ) {
			$notification = array(
				"type"		=> $type,
				"sender_id"	=> $sender === FALSE ? 0 : $sender->id,
				"receiver_id"   => $receiver->id,
				"registed"	=> time(),
				"message"	=> $message,
				"link_id"	=> $link_id
			);
                        
                        $receiver_id = $receiver->id;
			
			if ( $CI->db->insert('notifications', $notification) ) {
                            
                            $sql="UPDATE notification_badge SET badge_count=badge_count+1 where user_id=$receiver->id";
                            $CI->db->query($sql);    
                            
				if ( strlen($receiver->device) > 0 ) {
					if ( $receiver->os == 'ios' ) {
						$iphones[] = $receiver->device;
					} elseif ( $receiver->os == 'android' ) {
						$androids[] = $receiver->device;
					}
				}
			}			
		}
		
		$ext_params = array("type"=>$type, "link_id"=>$link_id);
		if ( count($iphones) > 0 ) {
			my_iphone_push_notification( $iphones, $message, $ext_params,$receiver_id);
		} elseif ( count($androids) > 0 ) {
			my_andoid_push_notification( $androids, $message, $ext_params,$receiver_id );
		}
	}
}

if( ! function_exists('my_iphone_push_notification')) {
	function my_iphone_push_notification($devices, $msg, $ext_params=FALSE,$receiver) {
		$CI = & get_instance();		
		$CI->load->config("push");

		$config = $CI->config->item("push");
		$config = $config['iphone'];
                
                $sql="SELECT badge_count FROM `notification_badge` WHERE user_id=$receiver";
                $badge_count = $CI->db->query($sql)->row(0)->{"badge_count"};  
                $badge_count = (int) $badge_count;
                
		try {
			require_once APPPATH.'libraries/ApnsPHP/Autoload.php';
				
			$apns_message = new ApnsPHP_Message();
			$apns_message->setCustomIdentifier("Message-Badge-3");
			$apns_message->setText($msg);
			if ( is_array($ext_params) ) {
				foreach ($ext_params as $key => $value) {
					$apns_message->setCustomProperty($key, $value);
				}
			}
			$apns_message->setSound('Sounds.caf');
                        $apns_message->setBadge($badge_count);

			for ( $i = 0; $i < count($devices); $i ++ ) {
				$apns_message->addRecipient($devices[$i]);
			}

			if ( $apns_message->getRecipientsNumber() > 0 ) {
				$push = new ApnsPHP_Push(
					$config['push_type'],
					APPPATH.$config['certfile']
				);
				$push->setRootCertificationPassword($config['certpwd']);
				$push->connect();
					
				$push->add($apns_message);
					
				$push->send();
				$push->disconnect();
			}
			
			return TRUE;
		} catch ( Exception $e ) {
			print_r( $e );
			
			return FALSE;
		}
	}
}

if( ! function_exists('my_andoid_push_notification')) {
	function my_andoid_push_notification($devices, $msg, $ext_params=FALSE,$receiver) {
		$CI = & get_instance();
                                               
		try {
			$CI->load->library("pushAndroid");

			$ext_params["message"] = $msg;
                          
			$CI->pushandroid->send_notification($devices, $ext_params);
		} catch ( Exception $e ) {
			print_r( $e );
		}
	}
}   

