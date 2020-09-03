<?php

/**
 * @package				My Loan Application
 * @author				Haiqal halim <mohdhaiqalhalim@gmail.com> (016-2242127)
 * @date				3 Sept 2020
 * @copyright			Copyright (c) Mohamad Haiqal halim
 * @modified by			Haiqal halim <mohdhaiqalhalim@gmail.com> (016-2242127)
 * @modified date		3 Sept 2020
 */

class Loan_m extends CI_Model
{
	public $default_per_page, $calibri_path;
	function __construct()
	{
		parent::__construct();
		$this->default_per_page = 3;
	}

	public function list_currency()
	{
		/**
		* If faced a problem related to SOAP undefined -- 
		* enable the extension=php_soap.dll OR extension=soap[PHP version: 7.4.9] in file php/php.ini. and restart the apache
		*
		*/
		$arr_currency = array();
		$WSDL = "http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso";

		$soap_options = array(
			'uri' => 'http://www.w3.org/2003/05/soap-envelope',
			'style' => SOAP_RPC,
			'use' => SOAP_ENCODED,
			'soap_version' => SOAP_1_2,
			'cache_wsdl' => WSDL_CACHE_NONE,
			'connection_timeout' => 30,
			'trace' => true,
			'encoding' => 'UTF-8',
			'location' => $WSDL
		);
		
		$soap_request = '<?xml version="1.0" encoding="utf-8"?>
						<soap12:Envelope xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
						  <soap12:Body>
							<ListOfCurrenciesByName xmlns="http://www.oorsprong.org/websamples.countryinfo">
							</ListOfCurrenciesByName>
						  </soap12:Body>
						</soap12:Envelope>';

		try {
			$soap_client = new SoapClient(NULL, $soap_options);
			$responseSoap = $soap_client->__doRequest($soap_request, $WSDL, "run", NULL);
			$clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:', 'env:', 'm:'], '', $responseSoap);
			$xml = simplexml_load_string($clean_xml);
			$array_xml = json_decode(json_encode((array)$xml),true);
			
			if(is_array($array_xml) && sizeof($array_xml) > 0 && isset($array_xml['Body']) && is_array($array_xml['Body']) && sizeof($array_xml['Body']) > 0)
			{
				if(isset($array_xml['Body']['ListOfCurrenciesByNameResponse']['ListOfCurrenciesByNameResult']) && is_array($array_xml['Body']['ListOfCurrenciesByNameResponse']['ListOfCurrenciesByNameResult']) && sizeof($array_xml['Body']['ListOfCurrenciesByNameResponse']['ListOfCurrenciesByNameResult']) > 0)
				{
					if(isset($array_xml['Body']['ListOfCurrenciesByNameResponse']['ListOfCurrenciesByNameResult']['tCurrency']) && is_array($array_xml['Body']['ListOfCurrenciesByNameResponse']['ListOfCurrenciesByNameResult']['tCurrency']) && sizeof($array_xml['Body']['ListOfCurrenciesByNameResponse']['ListOfCurrenciesByNameResult']['tCurrency']) > 0)
					$arr_currency = $array_xml['Body']['ListOfCurrenciesByNameResponse']['ListOfCurrenciesByNameResult']['tCurrency'];
				}
			}
			
			return $arr_currency;
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function manage_loan_application($post = array())
	{
		if(is_array($post) && sizeof($post) > 0)
		{
			$userid = (isset($post['userid']) && is_numeric($post['userid']) && $post['userid'] > 0) ? $post['userid'] : 0; 
			$loan_terms = (isset($post['loan_terms']) && is_numeric($post['loan_terms']) && $post['loan_terms'] > 0) ? $post['loan_terms'] : 0; 
			$currency = (isset($post['currency']) && $post['currency'] != '') ? $post['currency'] : ""; 
			$currency_desc = (isset($post['currency_desc']) && $post['currency_desc'] != '') ? $post['currency_desc'] : ""; 
			$total_amount_loan = (isset($post['total_amount_loan']) && $post['total_amount_loan'] != '') ? $post['total_amount_loan'] : ""; 
			$start_date_loan = (isset($post['start_date_loan']) && $post['start_date_loan'] != '') ? datepicker2mysql($post['start_date_loan']) : ""; 
			$loan_terms_types = (isset($post['loan_terms_types']) && $post['loan_terms_types'] != '') ? $post['loan_terms_types'] : ""; 
			$typeprocess = (isset($post['typeprocess']) && $post['typeprocess'] != '') ? $post['typeprocess'] : ""; 
			$amount_loan = (float)str_replace(",", "", $total_amount_loan);
			
			if($userid == '' || $userid <= 0)
			{
				$error_msg[] = "User id not set. Please login before proceed";
			}
			
			if($loan_terms == '' || !is_numeric($loan_terms) || $loan_terms <= 0)
			{
				$error_msg[] = "Loan terms must be in numeric value and minimum is 1";
			}
			
			if($loan_terms_types == '')
			{
				$error_msg[] = "Please select loan terms type";
			}
			
			if($currency == '')
			{
				$error_msg[] = "Please select currency for loan";
			}
			
			if($currency_desc == '')
			{
				$error_msg[] = "Currency description empty. Please select currency for loan";
			}
			
			if($start_date_loan == '')
			{
				$error_msg[] = "Please select start date for loan";
			}
			
			if($amount_loan == '' || !is_numeric($amount_loan) || $amount_loan <= 0)
			{
				$error_msg[] = "Total amount to loan must be in numeric value and more than 0";
			}
			
			if($typeprocess == '')
			{
				$error_msg[] = "Type process not set";
			}
			
			if(isset($error_msg) && is_array($error_msg) && sizeof($error_msg) > 0)
			{
				$msg = "<ul>";
				foreach($error_msg as $valmsg)
				{
					$msg .= "<li>" . $valmsg ."</li>";
				}
				$msg .= "</ul>";
				$arr_res = array('status' => false, 'msg' => $msg , 'data' => array());
			}
			else
			{
				$end_date_loan = date('Y-m-d', strtotime($start_date_loan . "+ " . $loan_terms . " " . $loan_terms_types));
				$date1 = new DateTime($start_date_loan);
				$date2 = new DateTime($end_date_loan);
				$total_weeks = $date1->diff($date2)->days / 7;
				$total_weeks = floor($total_weeks);
				$total_paid_by_weeks = $amount_loan/$total_weeks;
				$total_paid_by_weeks = (float)number_format($total_paid_by_weeks, 2, ".", "");
				$total_paid_secondlastweek = ($total_weeks - 1) * $total_paid_by_weeks;
				$total_paid_last = $amount_loan - $total_paid_secondlastweek;
				
				$DBdata = array(
					'loan_status' => trim('pending'),
					'userid' =>trim($userid),
					'total_amount_loan' => trim($amount_loan),
					'total_paid_by_weeks' =>trim($total_paid_by_weeks),
					'total_paid' =>trim(0),
					'total_balance' =>trim($amount_loan),
					'total_weeks' =>trim($total_weeks),
					'total_paid_forlast' =>trim($total_paid_last),
					'current_no_weeks' =>trim(1),
					'currency' =>trim(preg_replace('!\s+!', ' ', $currency)),
					'currency_desc' =>trim(preg_replace('!\s+!', ' ', $currency_desc)),
					'loan_terms' =>trim($loan_terms),
					'loan_terms_types' =>trim($loan_terms_types),
					'start_date_loan' =>trim($start_date_loan),
					'end_date_loan' =>trim($end_date_loan),
					'applied_date' =>trim(date('Y-m-d H:i:s')),
					'applied_by' =>trim($this->session->userdata('userid')),
				);
				
				if($typeprocess == 'review')
					$arr_res = array('status' => true, 'msg' => 'ok' , 'data' => array('row' => (object)$DBdata));
				elseif($typeprocess == 'apply')
				{
					unset($DBdata['total_paid_forlast']);
					$this->db->insert('loan_details', $DBdata);
					audit_trail($this->db->last_query(), 'loan_m.php', 'manage_loan_application', 'apply loan', $this->session->userdata('username'));
					$arr_res = array('status' => 'applied', 'msg' => 'ok');
				}
			}
		}
	
		return $arr_res;
	}
	
	
	function loan_listing()
	{
		$data = array();
		if($this->session->has_userdata('usertype') && $this->session->userdata('usertype')  == 'user' && $this->session->has_userdata('userid') && $this->session->userdata('userid') > 0)
		{
			$sqlcount = "SELECT COUNT(`id`) AS total FROM `loan_details` WHERE `userid` = " . $this->db->escape($this->session->userdata('userid'));
			$query = $this->db->query($sqlcount)->row();
			$data['total_rows'] = $query->total;
			$config['base_url'] = base_url() . 'dashboard/loan_listing';
			$config['uri_segment'] = 3;
			$config['total_rows'] = $data['total_rows'];
			$config['per_page'] = $this->default_per_page;
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();

			$limit = '';
			if ($data['total_rows'] > 0) {
				if ($this->uri->segment($config['uri_segment']) && is_numeric($this->uri->segment($config['uri_segment']))) {
					$limit = ' LIMIT ' . $this->uri->segment($config['uri_segment']) . ', ' . $config['per_page'];
				} else {
					$limit = ' LIMIT 0, ' . $config['per_page'];
				}
			}

			$sql = "SELECT * FROM `loan_details` WHERE `userid` = " . $this->db->escape($this->session->userdata('userid')) . $limit;
			$query = $this->db->query($sql);

			$data['query'] = $query->num_rows() > 0 ? $query : false;
			if ($data['query'] != false) {
				$start_form  = $this->uri->segment($config['uri_segment']);
				$data['starting_row'] = $data['query']->num_rows() > 0 ? $start_form + 1 : 0;
				$data['stoping_row'] = $start_form + $data['query']->num_rows();
			}

			if ($data['total_rows'] == 0) {
				$data['starting_row'] = 0;
				$data['stoping_row'] = 0;
			}
		}
		
		return $data;
	}
}
