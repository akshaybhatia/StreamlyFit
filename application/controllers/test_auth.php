<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_auth extends CI_Controller {


    function __construct()
    {
		parent::__construct();
		//$this->load->helper('checklogin');
		//check_login();
		$this->load->model('utilitymodel','util');
		$this->load->model('Loginmodel','login');
		$this->load->model('Invitationmodel','invitation');
		$this->load->model('Chatmodel','chat');
		
		
		$this->load->library('fra_lib');
		$this->load->library('AuthnetARB');
		$this->load->helper('functions');
    }
	
	function create_subscription()
	{
		
		$data["amount"]=100;
        $data["refId"]=rand(1,999999);
        $data["name"]="Bhas11";
        $data["length"]=1;
        $data["unit"]='months';
        $data["startDate"]=date("Y-m-d");
        $data["totalOccurrences"]=12;
        $data["trialOccurrences"]=1;
        $data["trialAmount"]=0.00;
        $data["cardNumber"]='370000000000002';
        $data["expirationDate"]='2012-12';
        $data["firstName"]='John';
        $data["lastName"]='Doe';
		$data["city"]='NY';
		$data["state"]='NY';
		$data["address"]='123,test addrees22';
		$data["zip"]='12345678912547';
		$data["country"]='US';
		$auth=new AuthnetARB();
		$result=$auth->create_subscription($data);
		//echo "aa";
		print_r($result);
	
	
	}
	
	function cancel_subscription()
	{
		$auth=new AuthnetARB();
		$data["subscription_id"]=1530206 ; 
		$result=$auth->cancel_subscription($data);
		echo "aa";
		print_r($result);
	
	}

}