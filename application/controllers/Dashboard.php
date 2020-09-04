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

class Dashboard extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		security_checking('user'); # to check session -- this function is from file application/helpers/general_helper.php. this is custom helper.
		$this->load->model('loan_m');
	}
	
	public function index()
	{
		$this->data['arr_currency'] = $this->loan_m->list_currency();
		$this->load->view('dashboard_v', $this->data);
	}
	
	public function loan_management()
	{
		$arr_res = array('status' => false, 'msg' => 'no data been post');
		$post = $this->input->post();
		if(is_array($post) && sizeof($post) > 0)
		{
			$arr_res = $this->loan_m->manage_loan_application($post);
			
			if(is_array($arr_res) && sizeof($arr_res) > 0)
			{
				if(isset($arr_res['status']) && $arr_res['status'] == true)
				{
					$data_res = (isset($arr_res['data']) && is_array($arr_res['data']) && sizeof($arr_res['data']) > 0) ? $arr_res['data'] : array();
					$html = $this->load->view('review_loan_details_v', $data_res, true);
					unset($arr_res['data']);
					$arr_res['html'] = $html;
				}
			}
		}
		
		if($this->input->is_ajax_request())
		{
			echo json_encode($arr_res);
		}
		else
			return $arr_res;
	}
	
	public function loan_listing()
	{
		$this->data['arr_data'] = $this->loan_m->loan_listing();
		$this->load->view('loan_listing_v', $this->data);
	}
}
