<?php
/**
 * @package				My Loan Application
 * @author				Haiqal halim <mohdhaiqalhalim@gmail.com> (016-2242127)
 * @date				4 Sept 2020
 * @copyright			Copyright (c) Mohamad Haiqal halim
 * @modified by			Haiqal halim <mohdhaiqalhalim@gmail.com> (016-2242127)
 * @modified date		4Sept 2020
 */
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Crm extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		security_checking('superadmin'); # to check session -- this function is from file application/helpers/general_helper.php. this is custom helper.
		$this->load->model('loan_m');
	}
	
	public function index()
	{
		redirect('crm/loan_listing');
	}
	
	public function loan_listing()
	{
		$this->data['arr_data'] = $this->loan_m->loan_listing();
		$this->load->view('loan_listing_v', $this->data);
	}
	
	public function manage_approval()
	{
		if($this->input->post())
		{
			$post = $this->input->post();
			$rs = $this->loan_m->loan_approval($post);
			
			if($this->input->is_ajax_request())
			{
				echo json_encode($rs);
			}
			else
				return $rs;
		}
	}
}
