<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	var $data = array();
	function __construct()
    {
		parent::__construct();
		//$this->load->helper('checklogin');
		//check_login();
		$this->load->model('utilitymodel','util');
		$this->load->model('Loginmodel','login');
		$this->load->library('fra_lib');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('functions');
		$this->load->library('user_agent');
    }

    function index()
    {
		$this->data['site_title']		= '.:Streamly Fit - Login:.';
		
		if ($this->agent->referrer()){
			$data['refer_page']	= $this->agent->referrer();
		}else{
			$data['refer_page']	= $this->config->item('base_url').'home/';
		}
		
		/************************* Facebook Login			*******************/
		
		$fb_details=$this->util->get_settings();
		$app_id = $fb_details->fb_app_id;
		$app_secret = $fb_details->fb_app_secret;
		$mysite_url = $this->config->item('site_url')."/login/fb_oauth_login";
		
		$dialog_url = "http://www.facebook.com/dialog/oauth?sign=true&response_type=code&client_id=".$app_id."&redirect_uri=".urlencode($mysite_url)."&scope=email,read_stream,user_birthday";
		$data['facebook_url']=$dialog_url;
		
		/************************* Google Login	*******************/
		
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
		
		$data['fb_img_url']=urlencode("http://www.trackbee.com/evolvefinal/assets/images/facebook_icon.jpg");
		$data['g_img_url']=urldecode("http://www.trackbee.com/evolvefinal/assets/images/gplus_icon.jpg");
		
		$form = $this->load->view('login', $data, true);		
		echo $form;
		//$this->load->view('login', $data);
	}
	
	function get_login()
	{
		$email_id	=$this->input->post("email_id");
		$user_pwd	=$this->input->post("user_pwd");
		
		$success=$this->login->check_login($email_id,$user_pwd);
		
		if($success==1 || $sucess==4)
		{
			// Login Activity
			$log_type_id=4;
			$this->util->update_log($log_type_id);	
		}
		
		$array=array(
			"result"=>$success
		);
		
		echo json_encode($array);
	}
	
	function retrive_password_form()
	{
		$this->load->view('retrive_password_form', $data);
	}
	
	function retrive_password()
	{
		//$email_id="a@k.com";
		$email_id=$this->input->post('email_id');
		$is_found=$this->login->check_duplicate_email('S',$email_id);
		
		switch($is_found)
		{
			case 0:
				$message="Email Id. not found.";
				break;
				
			case 1:
				
				$new_password=$this->fra_lib->genpassword(8);
				
				
				$en_new_password=md5($new_password);
				
				$this->login->change_password($email_id,$en_new_password);
				
				$template=$this->load->view('template/retrive_password','',true);
				
				$template=str_replace("[EMAIL]",$email_id,$template);
				$template=str_replace("[PASSWORD]",$new_password,$template);
					
					
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
				
				$message="We have sent your password.<br>Please check your mail.";
				break;	
			
			case 2:
				$message="Please login with facebook Or Google.";
				break;
		}
		
		$array=array(
			"result"=>$message
		);
		echo json_encode($array);
		
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
		
		//echo $this->input->get("code");
		
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
				$this->session->set_userdata('email_id',$email_id);
				$this->session->set_userdata('membership_type',"F");
				
				$this->login->start_login_log();
				
				// Facebook Login Activity
				$log_type_id=2;
				$this->util->update_log($log_type_id);
				redirect('home');
				
				$message=json_encode("Thank you registering in this site.");
				$this->session->set_flashdata('message',$message);
				
				redirect('home');
			}
			elseif($is_duplicate==1) 
			{
				$success=$this->login->oauth_login('F',$email_id);
				
				// Facebook Login Activity
				$log_type_id=2;
				$this->util->update_log($log_type_id);
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
					$this->session->set_userdata('email_id',$email_id);
					$this->session->set_userdata('membership_type',"F");
				
					$this->login->start_login_log();
					
					// Google Login Activity
					$log_type_id=3;
					$this->util->update_log($log_type_id);
				
					$message=json_encode("Thank you registering in this site.");
					$this->session->set_flashdata('message',$message);
					
					redirect('home');
				}
				elseif($is_duplicate==1) 
				{
					$success=$this->login->oauth_login('G',$email_id);
					
					// Google Login Activity
					$log_type_id=3;
					$this->util->update_log($log_type_id);
					
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
	
	function my_contact()
	{
		$url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=ya29.AHES6ZTDy_9uLOnHbr0EGS60uiUOnop4PDoyY753_jm-7Qc';
		$user = json_decode(file_get_contents($url));
		
		foreach($user as $k=>$v)
		 {
		 	echo $k."----".$v."<br>";
		}	
		//print_r($user);
	}
	
	
	
	function check_login()
	{
		if($this->session->userdata('user_id'))
			echo 1;
		else
			echo 0;
	}
	
	function update_login_log()
	{
		if($this->session->userdata('user_id'))
			echo $this->login->update_login_log();
	}
	
			
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */