<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//error_reporting(E_ALL);

//Controller for the user myaccount section
class Myaccount extends CI_Controller 
{	
	var $data = array();
	
	function __construct()
	{
		parent::__construct();
				
		$this->load->helper('checklogin');
		$this->load->helper('url');				
		$this->load->model('utilitymodel','util');
		$this->load->library('fra_lib');
	}

	function index()
	{	
		//redirect to video list page
		redirect($this->config->item('base_url').'');		
	}
	
	//method to update health waiver status of the user
	function user_update_health_waiver_status()
	{
		$this->data['user_id']			= $this->session->userdata('user_id');
		
		//load the user model
		$this->load->model('usermodel', 'user');
		$this->data['result']			= $this->user->update_health_waiver_status($this->data);
		
		$this->session->set_userdata('health_waiver_form', 'Y');
		
		echo 1;
	}
	
	//method to get the membership type of the user
	function user_membership_type()
	{
		$membership_type				= $this->session->userdata('membership_type');
		
		if ($membership_type=='F')
		{
			echo 0;	
		}else{
			echo 1;	
		}
	}
}

?>