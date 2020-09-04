<?php  
/**
 * @package				My Loan Application
 * @author				Haiqal halim <mohdhaiqalhalim@gmail.com> (016-2242127)
 * @date				2 Sept 2020
 * @copyright			Copyright (c) Mohamad Haiqal halim
 * @modified by			Haiqal halim <mohdhaiqalhalim@gmail.com> (016-2242127)
 * @modified date		2 Sept 2020
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Array debug
 *
 * @access	public
 * @param	string
 * @return	string
 */
if(!function_exists("ad")) {
	function ad($data, $write = false){
		//Array Debug.
		if($write) {
			ob_start();
			print_r($data);
			$output = ob_get_contents();
			ob_end_clean();

			$myFile = "C:/testFile.txt";
			$fh = fopen($myFile, 'a') or die("can't open file");

			$date = date("d-m-Y H:i:s") . "\n";
			fwrite($fh, $date);
			fwrite($fh, $output);
			fclose($fh);
		}
		else {
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Set message for display to browser. Useful for confirming certain process.
 *
 * @access	public
 * @param	string
 * @return	string
 */
if(!function_exists("set_message")) {
	 function set_message($feedback, $type = 'info')
	{
		#save notice.
		#Message Type: error, info

		$obj =& get_instance();
		$obj->session->set_userdata('system-message', $feedback);
		$obj->session->set_userdata('message-type', $type);
	}
}


// ------------------------------------------------------------------------

/**
 * Display message to browser.
 *
 * @access	public
 * @param	string
 * @return	string
 */
if(!function_exists("get_message")) {
	function get_message()
	{
		$obj =& get_instance();

		//Display notice.
		if($obj->session->userdata('system-message') != '')
		{
			$message_type = $obj->session->userdata('message-type');

			#For backward compatiblity.
			if($message_type == 'error')
				$message_type = 'danger';

			echo '<div class="col-lg-12"><div class="alert alert-' . $message_type . ' alert-dismissible fade show" role="alert">
				' . $obj->session->userdata('system-message') . '
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true" style="font-size:25px;">&times;</span>
				</button>
			</div></div>';

			$obj->session->unset_userdata('system-message');
			$obj->session->unset_userdata('message-type');
		}
	}
}

/*
 * Security Checking.
 *
 * @access	public
 * @param	string
 * @return	true or false
 * group 1 => admin
 * group 2 => user
 */	

if(!function_exists("security_checking")) {
	function security_checking($group = false) {
		$obj =& get_instance();
		
		#If group is being specified
		if($group !== false) {
			if(is_array($group)) {
				$found = false;
				foreach($group AS $key => $value) {
					if($obj->session->userdata('usertype') == $value)
						$found = true;
				}
			}
			else
				$found = ($obj->session->userdata('usertype') == $group) ? true : false;
				
			if($found == true AND $obj->session->userdata('logged_in') == true)
				return true;
			else  {
				if($obj->session->userdata('logged_in') == true){
					if($obj->session->userdata('usertype') == 'user')
						redirect('dashboard/');
					elseif($obj->session->userdata('usertype') == 'superadmin')
						redirect('crm/');
				}
				else
					redirect('login/sayonara');
				
				exit();
			}
		}
		#General checking for already logged in without specifying group type
		else {
			if($obj->session->userdata('logged_in') == true AND $obj->session->userdata('usertype') != '')
				return true;
			else {
				redirect('login/sayonara');
				exit();
			}
		}
	}
}


/**
 * Use for Audit Trail
 */
if(!function_exists("audit_trail")) {
	function audit_trail($sql = null, $filename = null, $function = null, $comment = null, $username = "")
	{
		$CI =& get_instance();

		$sql = $CI->db->escape($sql);
		$filename = $CI->db->escape($filename);
		$function = $CI->db->escape($function);
		$comment = $CI->db->escape($comment);
		$ip_address = $CI->db->escape($_SERVER['REMOTE_ADDR']);
		$username = $CI->db->escape($username);

		$sql = "INSERT INTO `ci_audit_trail` SET `sql_str` = $sql, `filename` = $filename, `function` = $function, `comment` = $comment, `ip_address` = $ip_address, `username` = $username, insert_date = NOW()";
		$query = $CI->db->query($sql);

		return false;
	}
}

if(!function_exists("jquerydate2mysql")) {
	function jquerydate2mysql($jquerydate)
	{
		$jquerydate_arr = explode(' ', trim($jquerydate));
		if(sizeof($jquerydate_arr) == 3) {
			#Due to the fact that jquery calendar passes month in short annotation, we then need to translate it for DB.
			$date_arr = array(
				'Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04', 'May' => '05', 'Jun' => '06',
				'Jul' => '07', 'Aug' => '08', 'Sep' => '09', 'Oct' => '10', 'Nov' => '11', 'Dec' => '12'
			);

			return $jquerydate_arr[2] . '-' . $date_arr[$jquerydate_arr[1]] . '-' . str_pad($jquerydate_arr[0], 2, "0", STR_PAD_LEFT);
		}

		return $jquerydate;
	}
}

if(!function_exists("datepicker2mysql")) {
	//dd/mm/yyyy -> yyyy-mm-dd
	function datepicker2mysql($js_date){
		$CI =& get_instance();
		$tmp_date = explode("/", $js_date);
		if(sizeof($tmp_date) != 3){
			return "";
		}
		$sql_date = $tmp_date[2] . "-" . $tmp_date[1] . "-" . $tmp_date[0];
		return $sql_date;
	}
}

if(!function_exists("mysql2datepicker")) {
	//yyyy-mm-dd-->dd/mm/yyyy ->
	function mysql2datepicker($mysql_date){
		$CI =& get_instance();
		$tmp_date = explode("-", $mysql_date);
		if(sizeof($tmp_date) != 3){
			return "";
		}
		$js_date = $tmp_date[2] . "/" . $tmp_date[1] . "/" . $tmp_date[0];
		return $js_date;
	}
}

/**
* Description: To convert/encode the string using base64 encoding special for url because its remove the padding character or invalid character to be put in url string.
* Comment: For anyone interested in the 'base64url' variant encoding, you can use this pair of functions (base64url_encode(), base64url_decode()):
*/
function base64url_encode2($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/**
* Description: Decoding the bae64 encoding that encoded by base64url_encode() function
* Comment: For anyone interested in the 'base64url' variant encoding, you can use this pair of functions (base64url_encode(), base64url_decode()):
*/
function base64url_decode2($data) {
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

?>
