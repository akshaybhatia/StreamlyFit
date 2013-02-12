<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {


    function __construct()
    {
		parent::__construct();
		//$this->load->helper('checklogin');
		//check_login();
		$this->load->model('utilitymodel','util');
		$this->load->model('Loginmodel','login');
		$this->load->library('fra_lib');
		$this->load->helper('functions');
    }

    function index()
    {
		$this->load->view('header');
		$this->load->view('signup');
		$this->load->view('footer');
	}	
	
	function get_signup()
	{
		$email_id	=$this->input->post("email_id");
		$user_pwd	=md5($this->input->post("user_pwd"));
		$first_name	=$this->input->post("first_name");
		$last_name	=$this->input->post("last_name");
		$screen_name=$this->input->post("screen_name");
		$gender		=$this->input->post("gender");
		$birthday	=$this->input->post("birthday");
		$access_token=md5($this->input->post("email_id"));
		
		$data=array(
			'oauth_id'=>0,
			'email_id'=>$email_id,
			'user_pwd'=>$user_pwd,
			'first_name'=>$first_name,
			'last_name'=>$last_name,
			'screen_name'=>$screen_name,
			'gender'=>$gender,
			'birthday'=>$birthday,
			'signup_type'=>'S',
			'is_verified'=>'N',
			'access_token'=>$access_token,
			'profile_picture'=>""
		);
		
		$is_duplicate=$this->login->check_duplicate_email('F',$email_id);
		
		if($is_duplicate==0)
			$result=$this->login->insert_users($data);
		else
			$result=0;
		
		if($result<>0)
		{
		
			$acc_link=base_url()."signup/welcome_to_evolve/".$result."/".$access_token;
			
			$template=$this->load->view('template/signup','',true);
			
			$template=str_replace("[SCREENNAME]",$screen_name,$template);
			$template=str_replace("[ACC_LINK]",$acc_link,$template);
				
				
			$this->load->library('email');
			
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			
			$this->email->initialize($config);
			
			$mailer_details=$this->util->get_settings();
			
			$this->email->from($mailer_details->site_email_id, $mailer_details->site_email_name);
			$this->email->to($email_id);
			
			$this->email->subject('Welcome to evolve fitness!');
			$this->email->message($template);
			
			$this->email->send();
			
		}
		
		
		$array=array(
			"result"=>$result
		);
		echo json_encode($array);
	}	
	
	function check_duplicate_email($email_id)
	{
		$is_duplicate=$this->login->check_duplicate_email('F',$email_id);
		echo $is_duplicate;
	}
	
	
	function welcome_to_evolve($user_id,$acccode)
	{
		if($user_id=="" || $acccode=="")
		{
			$this->session->set_flashdata('message',"Invalid URL !");
		}
		else
		{
			$success=$this->login->active_user($user_id,$acccode);
			
			if($success==0)
			{
				$this->session->set_flashdata('message',"Invalid URL !");
			}
			elseif($success==1)
			{
				$this->session->set_flashdata('message',"Welcome to evolve fitness. Please login with your email id. & password");
			}
			elseif($success==2)
			{
				$this->session->set_flashdata('message',"This account is already active!");
			}	
		}
		
		redirect('home');
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */