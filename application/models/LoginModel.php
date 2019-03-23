<?php
/*
 Author  		: Shaikh Khamaroddin 
 Start Date 	: 20 April 2018
 Last Modified 	: 22 April 2018
 File Name 		: LoginModel.php 
 Purpose 		: Model for user authentication.			 
*/
class LoginModel extends CI_Model
{
// Schoolmodel for school data CRUD
	function __construct()
	{

		// Call the Model constructor
		parent::__construct();
		$this->load->database();
		if (session_id() == "") session_start();
		
	}

// Login function for user authentication
	function login_user($user, $pass)				
	{
		$array = array(
			'username' => $user
		);
		$this->db->select('password,srno,name,status');
		$this->db->from(TBL_SCHOOLDATA);
		$this->db->where($array);
		$query = $this->db->get()->row_array();
		if (!empty($query))
		{
			if (md5($pass) == $query['password']&& $query['status'] ==TRUE )
			{
				unset($query['password']);
				return $query;
			}
			else
			{
				return FALSE;
			}
		}
	}
	
// Function to Check auth for user access
	function checkAuth()					
	{
	
		if ( isset($_SESSION['userid']))
		{
			return True;
		}
		else
		{
			
			redirect(site_url('logincontroller'));
		}
	}
}	// End of model 'LoginModel'