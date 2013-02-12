<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {


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
		$this->load->helper('functions');
    }

    function index()
    {
		$data['from_user_id']=0;
		
		
		
		/************************* Facebook Login			*******************/
		
		$fb_details=$this->util->get_settings();
		$app_id = $fb_details->fb_app_id;
		$app_secret = $fb_details->fb_app_secret;
		$mysite_url = $this->config->item('site_url')."/login/fb_oauth_login";
		
		$dialog_url = "http://www.facebook.com/dialog/oauth?sign=true&response_type=code&client_id=".$app_id."&redirect_uri=".urlencode($mysite_url)."&scope=email,read_stream,user_birthday";
		$data['facebook_url']=$dialog_url;
		
		/************************* Google Login			*******************/
		
		$google_details=$this->util->get_settings();
		
		$client_id = $google_details->google_client_id;
		$client_secret = $google_details->google_client_secret;
		
		$mysite_url = $this->config->item('site_url')."/login/google_oauth_login";
		
		
			
			
		$state = sha1(uniqid(mt_rand(), true));
		$this->session->set_userdata('state',$state);

		$params = array(
			'client_id' => $client_id,
			'redirect_uri' => $mysite_url,
			'state' => $state,
			'approval_prompt' => 'force',
			'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
			'response_type' => 'code'
		);
		$dialog_url = "https://accounts.google.com/o/oauth2/auth?".http_build_query($params);

		$data['google_url']=$dialog_url;
		
		//home controller
		$data['site_title']		= '.:Streamly Fit: - Signup';
		
		$data['card_type']		= $this->login->get_card_type();
				
		$this->load->view('header',$data);
		$this->load->view('signup',$data);
		$this->load->view('footer_without_playlist');
	}
	
	/*********Upgrade membership**********/
	function upgrade_membership()
	{
		/************************* Facebook Login			*******************/
		
		$fb_details=$this->util->get_settings();
		$app_id = $fb_details->fb_app_id;
		$app_secret = $fb_details->fb_app_secret;
		$mysite_url = $this->config->item('site_url')."/login/fb_oauth_login";
		
		$dialog_url = "http://www.facebook.com/dialog/oauth?sign=true&response_type=code&client_id=".$app_id."&redirect_uri=".urlencode($mysite_url)."&scope=email,read_stream,user_birthday";
		$data['facebook_url']=$dialog_url;
		
		/************************* Google Login			*******************/
		
		$google_details=$this->util->get_settings();
		
		$client_id = $google_details->google_client_id;
		$client_secret = $google_details->google_client_secret;
		
		$mysite_url = $this->config->item('site_url')."/login/google_oauth_login";
		
		
			
			
		$state = sha1(uniqid(mt_rand(), true));
		$this->session->set_userdata('state',$state);

		$params = array(
			'client_id' => $client_id,
			'redirect_uri' => $mysite_url,
			'state' => $state,
			'approval_prompt' => 'force',
			'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
			'response_type' => 'code'
		);
		$dialog_url = "https://accounts.google.com/o/oauth2/auth?".http_build_query($params);

		$data['google_url']=$dialog_url;
		
		//home controller
		$data['site_title']		= '.:Streamly Fit: - Upgrade Membership';
		
		$data['card_type']		= $this->login->get_card_type();
				
		$this->load->view('header',$data);
		$this->load->view('upgrade_membership',$data);
		$this->load->view('footer_without_playlist');
	}
	/*********Upgrade membership**********/
	
	function signup_invitation($inv_token)
    {
		$ret_arr=$this->invitation->find_invitation($inv_token);
		
		
		if($ret_arr->access_token==$inv_token)
		{
			$data['inv_id']=$ret_arr->inv_id;
			$data['email_id']=$ret_arr->to_email_id;
			$data['from_user_id']=$ret_arr->from_user_id;
			$data['inv_token']=$ret_arr->access_token;
			
			$is_duplicate=$this->login->check_duplicate_email('S',$ret_arr->to_email_id);
			
			if($is_duplicate>0)
			{
				$message=json_encode("The email id (".$ret_arr->to_email_id.") has been registered already.");
				$this->session->set_flashdata('message',$message);
				redirect('home');
			}
			$this->load->view('header',$data);
			$this->load->view('signup',$data);
			$this->load->view('footer');
		}
		else
			redirect('home');
	}	
	
	
	function get_signup()
	{
		$inv_id			=$this->input->post("inv_id");
		$email_id		=$this->input->post("email_id");
		$user_pwd		=md5($this->input->post("user_pwd"));
		$first_name		=$this->input->post("first_name");
		$last_name		=$this->input->post("last_name");
		$access_token	=md5($this->input->post("email_id").time());
		$from_user_id 	=$this->input->post("from_user_id");
		$inv_token 		=$this->input->post("inv_token");
		
		if($from_user_id==0)
			$is_verified='N';
		else
			$is_verified='Y';
			
		
		$screen_name=$first_name;
		
		$data=array(
			'oauth_id'=>0,
			'email_id'=>$email_id,
			'user_pwd'=>$user_pwd,
			'first_name'=>$first_name,
			'last_name'=>$last_name,
			'screen_name'=>$screen_name,
			'signup_type'=>'S',
			'is_verified'=>$is_verified,
			'access_token'=>$access_token,
			'profile_picture'=>""
		);
		
		
		$is_duplicate=$this->login->check_duplicate_email('S',$email_id);
		
		if($is_duplicate==0)
		{
			$result=$this->login->insert_users($data);
			
			// Site Signup Activity
			$log_type_id=1;
			$this->util->update_log($log_type_id);
			
			// Add to friend list after signup.
			if($from_user_id<>0)
			{
				$data=array(
					'from_user_id'=>$from_user_id,
					'to_user_id'=>$result,
					'friend_status' => 'A'
				);
				
				$success=$this->chat->send_friend_request($data);
				
				$this->invitation->update_invitation_status($inv_token);
				
				// Accept signup invitation  Activity
				$log_type_id=29;
				$this->util->update_log($log_type_id,$inv_id);
			}
			
		}
		else
			$result=0;
		
		if($result<>0)
		{
		
			/*$acc_link=base_url()."signup/welcome_to_evolve/".$result."/".$access_token;
			
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
			
			$this->email->send();*/
			
			
			$this->session->set_userdata('user_id',$result);
			$this->session->set_userdata('first_name',$first_name);
			$this->session->set_userdata('last_name',$last_name);
			$this->session->set_userdata('screen_name',$screen_name);
			$this->session->set_userdata('email_id',$email_id);
			$this->session->set_userdata('membership_type',"F");
			
			$this->login->start_login_log();
			
			// Login Activity
			$log_type_id=4;
			$this->util->update_log($log_type_id);
		}
		
		
		$array=array(
			"result"=>$result
		);
		echo json_encode($array);
	}	
	
	
	function save_payment_option()
	{
	
		$this->load->library('AuthnetARB');
		$this->load->model('usermodel','user');
		$billing_addr_1		= $this->input->post("billing_addr_1");
		$billing_addr_2		= $this->input->post("billing_addr_2");
		$country			= $this->input->post("country");
		$state				= $this->input->post("state");
		$city				= $this->input->post("city");
		$zip_code			= $this->input->post("zip_code");
		$phone_no 			= $this->input->post("phone_no");
		$card_type_id 		= $this->input->post("card_type_id");
		$card_no 			= $this->input->post("card_no");
		$exp_month 			= $this->input->post("exp_month");
		$exp_year 			= $this->input->post("exp_year");
		$sec_code 			= $this->input->post("sec_code");
		
		$user_id=$this->session->userdata('user_id');
		$user_details=$this->user->get_user_details($user_id);
		//print_r($user_details);
		//echo "aa".$user_details->first_name;
		/*$data=array(
			'user_id'=>$this->session->userdata('user_id'),
			'billing_addr_1'=>$billing_addr_1,
			'billing_addr_2'=>$billing_addr_2,
			'country'=>$country,
			'state'=>$state,
			'city'=>$city,
			'zip_code'=>$zip_code,
			'phone_no'=>$phone_no,
			'card_type_id'=>$card_type_id,
			'card_no'=>$card_no,
			'exp_month'=>$exp_month,
			'exp_year'=>$exp_year,
			'sec_code'=>$sec_code
		);*/
		
		//$result=$this->login->insert_users_card_details($data);
		//echo $exp_year."-".$exp_month;
		$data["amount"]=100;
        $data["refId"]=rand(1,999999);
        $data["length"]=1;
        $data["unit"]='months';
        $data["startDate"]=date("Y-m-d");
        $data["totalOccurrences"]=12;
        $data["trialOccurrences"]=1;
        $data["trialAmount"]=0.00;
        $data["cardNumber"]=$card_no;
        $data["expirationDate"]=$exp_year."-".$exp_month;
        $data["firstName"]=$user_details->first_name;
        $data["lastName"]=$user_details->last_name;
		$data["city"]=$city;
		$data["state"]=$state;
		$data["address"]=$billing_addr_1." ".$billing_addr_2;
		$data["zip"]=$zip_code;
		$data["country"]=$country;
		
		
		/*$data["amount"]=100;
        $data["refId"]=rand(1,999999);
        $data["name"]="Bhas11";
        $data["length"]=1;
        $data["unit"]='months';
        $data["startDate"]='2012-10-23';
        $data["totalOccurrences"]=12;
        $data["trialOccurrences"]=1;
        $data["trialAmount"]=0.00;
        $data["cardNumber"]='370000000000002';
        $data["expirationDate"]='2012-12';
        $data["firstName"]='Bhaskar111';
        $data["lastName"]='Basu';
		$data["city"]='NY';
		$data["state"]='NY';
		$data["address"]='btest asa ';
		$data["zip"]='12345678912547';
		$data["country"]='US';*/
		
		$auth=new AuthnetARB();
		$result=$auth->create_subscription($data);
		//print_r($result);
		if($result["success"]==1)
		{
			$subscription_id=$result["subscription_id"];
			//echo $subscription_id;
			//update subscription 
			
			$update_user=$this->user->update_auth_subscription($user_id,$subscription_id);
			
			$result=1;
		}
		else
		{
		 	$result=0;
		}
	//	$result1=$result['text'];
		
		$array=array(
			"result"=>$result
		);
		echo json_encode($array);
		
	}
	
	
	
	function success_signup()
	{
		if($this->session->userdata('user_id'))
		{
			$message=json_encode("Thank you registering in this site.");
			
			$this->session->set_flashdata('message',$message);
			
			
		}
		
		redirect('home');
		
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