<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {


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
		
	}
// Facebook Login view calling	
	function fb_login()
	{
		$fb_details=$this->util->get_settings();
		$app_id = $fb_details->fb_app_id;
		$app_secret = $fb_details->fb_app_secret;
		$mysite_url = $this->config->item('site_url')."/login/fb_oauth_login";
		
		$dialog_url = "http://www.facebook.com/dialog/oauth?sign=true&response_type=code&client_id=".$app_id."&redirect_uri=".urlencode($mysite_url)."&scope=email,read_stream,user_birthday";
		$data['dialog_url']=$dialog_url;
		$this->load->view('fb_login',$data);
	}


// Open Authorization for using (OAuth protocol 2) Facebook Login 	
	function fb_oauth_login()
	{
		$fb_details=$this->util->get_settings();
		$app_id = $fb_details->fb_app_id;
		$app_secret = $fb_details->fb_app_secret;
		$mysite_url = $this->config->item('site_url')."/login/fb_oauth_login";
		 
		$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=".$app_id."&redirect_uri=".urlencode($mysite_url)."&scope=email,read_stream,user_birthday";
		$data['dialog_url']=$dialog_url;
		$code = $_GET["code"];
		
		$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
        . $app_id . "&redirect_uri=" . urlencode($mysite_url) . "&client_secret="
        . $app_secret . "&code=" . $code;

		$access_token = file_get_contents($token_url);
		
		
		$graph_url = "https://graph.facebook.com/me?" . $access_token;
	
		$user = json_decode(file_get_contents($graph_url));

		foreach($user as $k=>$v)
		 {
			
			if($k=="id"){$oauth_id=$v;}
			if($k=="first_name"){$first_name=$v;}
			if($k=="last_name"){$last_name=$v;}
			if($k=="email"){$email_id=$v;}
			if($k=="username"){$screen_name=$v;}
			if($k=="gender"){$gender=$v;}
			if($k=="birthday"){$birthday=$v;}
			
		}	
		
		if($email_id!='')
		{
			$is_duplicate=$this->login->check_duplicate_email('F',$email_id);
			if($is_duplicate==0)
			{
			
				$gender=strtoupper(substr($gender,0,1));
				$birthday_arr=explode("/",$birthday);
				
				$birthday=$birthday_arr[2]."-".$birthday_arr[0]."-".$birthday_arr[1];
				
				$data=array(
					'oauth_id'=>$oauth_id,
					'email_id'=>$email_id,
					'first_name'=>$first_name,
					'last_name'=>$last_name,
					'screen_name'=>$screen_name,
					'gender'=>$gender,
					'birthday'=>$birthday,
					'signup_type'=>'F',
					'is_verified'=>'Y',
					'access_token'=>$access_token,
					'profile_picture'=>"https://graph.facebook.com/me/picture?".$access_token
				);
				
				
				$user_id=$this->login->insert_users($data);
				
				$this->session->set_userdata('user_id',$user_id);
				$this->session->set_userdata('first_name',$first_name);
				$this->session->set_userdata('last_name',$last_name);
				$this->session->set_userdata('screen_name',$screen_name);
				
				redirect('home');
			}
			elseif($is_duplicate==1) 
			{
				$success=$this->login->oauth_login('F',$email_id);
				redirect('home');
			}
			else
			{
				$message=json_encode("The email id which you have provided that has been already registered.");
				$this->session->set_flashdata('message',$message);
				redirect('home');
			}
		}
		else
		{
			$message=json_encode("The email id is blank.");
			$this->session->set_flashdata('message',$message);
			redirect('home');
		
		}	
	}
	
// Google Login view calling	
	function google_login()
	{
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

		$data['dialog_url']=$dialog_url;
		$this->load->view('google_login',$data);
		
      
	}

// Open Authorization for using (OAuth protocol 2) Google Login 		
	function google_oauth_login()
	{
		$google_details=$this->util->get_settings();
		
		$client_id = $google_details->google_client_id;
		$client_secret = $google_details->google_client_secret;
		
		$mysite_url = $this->config->item('site_url')."/login/google_oauth_login";
		
		
        if(!empty($_GET['code'])) 
        {
			
			if ($this->session->userdata('state') != $_GET['state']) {
                echo "sasa".$this->session->userdata('state')."----------".$_GET['state'];
                exit;
            }

            // get profile info

            $params = array(
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'code' => $_GET['code'],
                'redirect_uri' => $mysite_url,
                'grant_type' => 'authorization_code'
            );
            $url = 'https://accounts.google.com/o/oauth2/token';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $rs = curl_exec($curl);
            curl_close($curl);

            $json = json_decode($rs);
			
			$access_token=$json->access_token;
			
            $url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$json->access_token;
			$user = json_decode(file_get_contents($url));

			foreach($user as $k=>$v)
			 {
			 	if($k=="id"){$oauth_id=$v;}
				if($k=="name"){$name=$v;}
				if($k=="given_name"){$screen_name=$v;}
				if($k=="email"){$email_id=$v;}
				if($k=="gender"){$gender=$v;}
				if($k=="birthday"){$birthday=$v;}
				if($k=="picture"){$picture=$v;}
			}	
			
			if($email_id!='')
			{
				$is_duplicate=$this->login->check_duplicate_email('G',$email_id);
				if($is_duplicate==0)
				{
					$name_arr=explode(" ",$name);
					$first_name=$name_arr[0];
					$last_name=$name_arr[1];
					
					$gender=strtoupper(substr($gender,0,1));
					
					$data=array(
						'oauth_id'=>$oauth_id,
						'email_id'=>$email_id,
						'first_name'=>$first_name,
						'last_name'=>$last_name,
						'screen_name'=>$screen_name,
						'gender'=>$gender,
						'birthday'=>$birthday,
						'signup_type'=>'G',
						'is_verified'=>'Y',
						'access_token'=>$access_token,
						'profile_picture'=>$picture
					);
					
					
					$user_id=$this->login->insert_users($data);
					
					$this->session->set_userdata('user_id',$user_id);
					$this->session->set_userdata('first_name',$first_name);
					$this->session->set_userdata('last_name',$last_name);
					$this->session->set_userdata('screen_name',$screen_name);
					
					redirect('home');
				}
				elseif($is_duplicate==1) 
				{
					$success=$this->login->oauth_login('G',$email_id);
					redirect('home');
				}
				else
				{
					$message=json_encode("The email id which you have provided that has been already registered.");
					$this->session->set_flashdata('message',$message);
					redirect('home');
				}
			}
			else
			{
				$message=json_encode("The email id is blank.");
				$this->session->set_flashdata('message',$message);
				redirect('home');
			}	
        }
	}
	
	
	
	function check_login()
	{
		if($this->session->userdata('user_id'))
			echo 1;
		else
			echo 0;
	}
	
			
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */