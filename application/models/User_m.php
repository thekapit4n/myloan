<?php

/**
 * @package				My Loan Application
 * @author				Haiqal halim <mohdhaiqalhalim@gmail.com> (016-2242127)
 * @date				2 Sept 2020
 * @copyright			Copyright (c) Mohamad Haiqal halim
 * @modified by			Haiqal halim <mohdhaiqalhalim@gmail.com> (016-2242127)
 * @modified date		2 Sept 2020
 */
class User_m extends CI_Model
{
	public $default_per_page, $calibri_path;
	function __construct()
	{
		parent::__construct();
		$this->default_per_page = 50;
	}

	function register_user($post = array())
	{
		if(is_array($post) && sizeof($post) > 0)
		{
			$Dbdata = array(
				'fullname' =>trim(preg_replace('!\s+!', ' ', $post['fullname'])),
				'username' =>trim(preg_replace('!\s+!', ' ', $post['username'])),
			);
			
			if($Dbdata['fullname'] == '')
			{
				$arr_error[] = "Please enter fullname";
			}
			
			if($Dbdata['username'] == '')
			{
				$arr_error[] = "Please enter username";
			}
			
			$checkUsername = $this->get_user('row', array('username' => $Dbdata['username']));
			if(is_object($checkUsername) && isset($checkUsername->id) && $checkUsername->id > 0)
			{
				$arr_error[] = "The username not available. Please try again"; 
			}
			
			if(!isset($post['password']) || $post['password'] == '')
			{
				$arr_error[] = "Please enter password"; 
			}
			
			if(!isset($post['confirm_password']) || $post['confirm_password'] == '')
			{
				$arr_error[] = "Please enter confirm password"; 
			}
			
			if($post['password'] != $post['confirm_password']) {
				$arr_error[] = "Confirm passwords and password do not match each other, please try again.";
			}
			
			if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}\S+$/", $post['password'])) {
				$arr_error[] = "Password must contain at least 1 upper case, 1 lower case, 1 digit,1 special character and the minimum length should be 8.";
			}
			
			if(isset($arr_error) && is_array($arr_error) && sizeof($arr_error) > 0)
			{
				$msg = "<ul>";
				foreach($arr_error as $valerror)
				{
					$msg .= "<li>" . $valerror . "</li>";
				}
				$msg .= "</ul>";
				
				set_message($msg, 'danger');
				return false;
			}
			else
			{
				$Dbdata['password'] = md5(trim($post['password']));
				$Dbdata['usertype'] = trim('user');
				$Dbdata['created_date'] = trim(date('Y-m-d H:i:s'));
				$this->db->insert('myloan_user', $Dbdata);
				audit_trail($this->db->last_query(), 'user_m.php', 'register_user', 'register new user for myloan system', $Dbdata['username']);
				
				set_message("Successfully create an account for myloan system", 'success');
				return true;
			}
		}
		else
		{
			set_message('No data has been posted', 'danger');
			return false;
		}
	}
	
	function verify_user($post = array())
	{
		if(is_array($post) && sizeof($post) > 0)
		{
			$username = trim($post['username']);
			$password = trim($post['password']);
			
			if (empty($username) || empty($password)) {
				set_message('Please fill all the fields', 'danger');
				return false;
			}
			
			$row = $this->get_user('row', array('username' => $username , 'password' => md5($password)));
			if(is_object($row) && isset($row->id) && $row->id > 0)
			{
				$this->session->set_userdata(
					array(
						'username' => $row->username, 
						'userid' => $row->id, 
						'fullname' => $row->fullname, 
						'usertype' => $row->usertype, 
						'logged_in' => true, 
					)
				);
				
				return true;
			}
			else
			{
				set_message('Username and password is invalid. Please try again', 'danger');
				return false;
			}
		}
		else
		{
			set_message('No data has been posted', 'danger');
			return false;
		}
	}
	
	#Function to return info of user.
	function get_user($return_type = "query", $condition = array()) {
		$where = "";
		if(is_array($condition)){
			if(sizeof($condition) > 0){
				foreach($condition as $column_name => $column_value){
					$where .= ($where == "" ? " WHERE " : " AND ") . $this->db->protect_identifiers($column_name) . " = " . $this->db->escape($column_value);
				}
			}
		}
		else{
			#Condotion in string contains where condition
			$where = $condition;
		}
		
		$limit = "";
		if(in_array($return_type, array('row'))){
			$limit = " LIMIT 1 ";
		}
		
		$sql = "SELECT * FROM `myloan_user`" . $where . $limit;
		$query = $this->db->query($sql);
		if($return_type == "row"){
			if($query->num_rows() > 0){
				return $query->row();
			}
			
			return new stdClass();
		}

		return $query;
	}
	
	function logout()
	{
		$unsetdata = array('username', 'userid', 'fullname', 'usertype', 'logged_in');
		$this->session->unset_userdata($unsetdata);
		
		set_message("You succesffully logout. Have a nice day.", 'info');
	}
}
