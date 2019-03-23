<?php
/*
 Author  		: Shaikh Khamaroddin 
 Start Date 	: 20 April 2018
 Last Modified 	: 1 june 2018
 File Name 		: LoginController.php 
 Purpose 		: Used for user authentication.			 
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class LoginController extends CI_Controller
{
	// Constructor
	function __construct()								
	{
		parent::__construct();
		if (session_id() == "") session_start();
		
		$this->load->model('LoginModel');
	}
	
// function to load Login page
	public	function index() 							
	{	
		if (isset($_SESSION['userid']))
		{
			$data['viewFile']='body/stdinfo';
			$this->load->view('home',$data);
		}
		else
		{
			$this->load->view('loginView');
		}
	}
	
// User login function
	function login()										
	{
				
		$user = $this->input->post('email');
		$pass = $this->input->post('password');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[25]','required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email','required');
		if ($user != "" && $pass != "")
		{
			if ($this->form_validation->run() == FALSE)
			{
					
					return validation_errors();
			}
			$res = $this->LoginModel->login_user($user, $pass);
		
			if ($res)
			{
				// adding data to session
				$_SESSION['userid'] = $res['srno'];
				$_SESSION['name'] = $res['name'];
				$_SESSION['logged_in'] = TRUE;
				redirect(site_url('stdcontroller/'));
			}
			else
			{
				$_SESSION['error'] = 'Incorrect Username or Password!';
				redirect(site_url('logincontroller/'));
			}
		}
		else
		{
			$_SESSION['error'] = 'Username or Password is Blank!';
			echo '<script>console.log("blank username or password")</script>';
			redirect(site_url('logincontroller/'));
		}
	}
	
// Logout function
	function logout()										
	{
		session_destroy();
		redirect(site_url('logincontroller'));
	}
}	//End of class 'LoginController'