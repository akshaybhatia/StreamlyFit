<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends CI_Controller {


    function __construct()
    {
		parent::__construct();
		$this->load->helper('checklogin');
		check_login();
		
		$this->load->model('utilitymodel','util');
		$this->load->model('Invitationmodel','invitation');
		$this->load->library('fra_lib');
		$this->load->helper('functions');
    }

    

// Open Authorization for using (OAuth protocol 2) Google Login 		
	function google_oauth_import_friend()
	{
		$google_details=$this->util->get_settings();
		
		$client_id = $google_details->google_import_client_id;
		$client_secret = $google_details->google_import_client_secret;
		
		
		
		$mysite_url = $this->config->item('site_url')."/import/google_oauth_import_friend";
		
		 if(!empty($_GET['code'])) 
        {
			
			
			/*if ($this->session->userdata('state') != $_GET['state']) {
                echo "sasa".$this->session->userdata('state')."----------".$_GET['state'];
                exit;
            }*/
			
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
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $rs = curl_exec($curl);
            curl_close($curl);

			$json = json_decode($rs);
			
			$access_token=$json->access_token;
			
			$url = 'https://www.google.com/m8/feeds/contacts/default/full?oauth_token='.$json->access_token;
			$user = file_get_contents($url);

			$xml=  new SimpleXMLElement($user);
			$xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
			$result = $xml->xpath('//gd:email');
			
			$i=0;
			foreach ($result as $title) {
			  
			  $email_id=$title->attributes()->address;
				
			  if(!$this->invitation->check_is_user($email_id))
			  {
				  $data['friends_email'][$i]= $title->attributes()->address;
				  $i++;
			  }
			}
        }
		
		//home controller
		$data['site_title']		= '.:Streamly Fit: - Invite Friend';
		
		$this->load->view('header');
		$this->load->view('friend_list_for_invite',$data);
		$this->load->view('footer_without_playlist');
		
	}
	
	function contact_list()
	{		
		$data['site_title']		= '.:Streamly Fit: - Invite Friend';
			
		$this->load->view('header',$data);
		$this->load->view('create_contact_list');
		$this->load->view('footer_without_playlist');
	}
	
	function load_new_contact($contact_num)
	{
		$data					= array();
		$data['contact_num']	= $contact_num;
		$form 					= $this->load->view('add_new_contact', $data);
		echo $form;
	}
	
	function send_invitation()
	{
		$friends_email=$this->input->post('friends_email');
		
		
		$screen_name=$this->session->userdata('screen_name');
		
		$friends_email_arr=explode("~",$friends_email);
		$tot_invite=0;

		$this->load->library('email');
		
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);
		
		for($i=0;$i<count($friends_email_arr);$i++)
		{
			$email_id=$friends_email_arr[$i];
			if($email_id<>'')
			{
				if(!$this->invitation->check_is_user($email_id))
				{
					$access_token=md5($email_id.time());
					
					$data=array(
					'from_user_id' => $this->session->userdata('user_id'),
					'to_email_id' => $email_id,
					'access_token' => $access_token
					);
					
					$inv_id=$this->invitation->save_invitation($data);
					
					// Send signup invitation Activity
					$log_type_id=27;
					$this->util->update_log($log_type_id,$inv_id);
					
					// Send Invitation Email
					
					$inv_link=base_url()."signup/signup_invitation/".$access_token;
			
					$template=$this->load->view('template/invitation','',true);
					
					$template=str_replace("[INVITATION_LINK]",$inv_link,$template);
					
					
					
					$mailer_details=$this->util->get_settings();
					
					$this->email->from($mailer_details->site_email_id, $mailer_details->site_email_name);
					$this->email->to($email_id);
					
					$this->email->subject($screen_name.' invites you to .:Streamly Fit:');
					$this->email->message($template);
					
					$this->email->send();
					
					$tot_invite++;
				}
			}
			
		}	
		
		$array=array(
			"result"=>$tot_invite
		);
		echo json_encode($array);	
		
	}
			
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */