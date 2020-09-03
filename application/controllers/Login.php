<?php
/**
 * @package				My Loan Application
 * @author				Haiqal halim <mohdhaiqalhalim@gmail.com> (016-2242127)
 * @date				2 Sept 2020
 * @copyright			Copyright (c) Mohamad Haiqal halim
 * @modified by			Haiqal halim <mohdhaiqalhalim@gmail.com> (016-2242127)
 * @modified date		2 Sept 2020
 */
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public $data;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_m');
	}
	
	public function index()
	{
		#if already login
		if($this->session->userdata('logged_in') === true){
			redirect('dashboard');
		}
		
		$arrPost = $this->session->flashdata('postitem');
		if(is_array($arrPost) && sizeof($arrPost) > 0)
		{
			$this->data['row'] = (object)$arrPost;
		}
	
		$this->load->view('login_v', $this->data);
	}
	
	public function verify()
	{
		$post = $this->input->post();
		$rs = $this->user_m->verify_user($post);
		if($rs == false)
		{
			$this->session->set_flashdata('postitem', $post);
			redirect('login/');
		}
		else
		{
			if($this->session->has_userdata('usertype') && $this->session->has_userdata('logged_in') && $this->session->userdata('logged_in') == true)
			{
				if($this->session->userdata('usertype') == 'user')
					redirect('dashboard/');
				else
					echo "indevelopment";
			}
		}
	}
	
	public function register()
	{
		$arrPost = $this->session->flashdata('postitem');
		if(is_array($arrPost) && sizeof($arrPost) > 0)
		{
			$this->data['row'] = (object)$arrPost;
		}
		
		$this->load->view('register_v', $this->data);
	}
	
	public function manage_registration()
	{
		$post = $this->input->post();
		$rs = $this->user_m->register_user($post);
		if($rs == false)
		{
			$this->session->set_flashdata('postitem', $post);
			redirect('login/register');
		}
		else
		{
			redirect('login/');
		}
	}
	
	public function sayonara() 
	{
		$this->user_m->logout();		
		redirect('login');
	}
}
