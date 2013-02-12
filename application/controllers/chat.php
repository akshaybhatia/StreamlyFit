<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {


    function __construct()
    {
		parent::__construct();
		$this->load->helper('checklogin');
		check_login();
		
		$this->load->model('utilitymodel','util');
		$this->load->model('Chatmodel','chat');
		$this->load->library('fra_lib');
		$this->load->helper('functions');
    }

    function index()
    {
		$user_id=$this->session->userdata('user_id');
		$return_arr=$this->chat->get_friend_list();
		
		$my_chat_status=$this->chat->get_chat_status();
		
		
		if($my_chat_status==4)
		{
			echo "Chat (0)";
			
		}
		else
		{
			$friend_list=array();
			$i=0;
			
			$no_of_user_online=0;
			//print_r($return_arr);
			$friend_list=array();
			foreach($return_arr as $row)
			{
				
				
				$friend_list['user_id']=$user_id;
				
				if($row->from_user_id==$user_id)
				{
				
					$friend_details=$this->chat->get_friend_details($row->to_user_id);
					
					if($friend_details->log_count>=1)
					{
					 
						if($this->chat->get_chat_status($row->to_user_id)!=4)
						$no_of_user_online++;
					}
					$friend_list['log_count']=$friend_details->log_count;
				}else{
					
					$friend_details=$this->chat->get_friend_details($row->from_user_id);
					//echo $friend_details->log_count;
					if($friend_details->log_count>0)
					{
						if($this->chat->get_chat_status($row->from_user_id)!=4)
						$no_of_user_online++;
					}
				}
			}
			
			
			echo "Chat (".$no_of_user_online.")";
		}
	}
	
	function get_chat_area()
	{
		$user_id=$this->session->userdata('user_id');
		$return_arr=$this->chat->get_friend_list();
		
		$friend_list=array();
		$i=0;
		
		
		
		foreach($return_arr as $row)
		{
			$friend_list=array();
			
			$friend_list['user_id']=$user_id;
			
			if($row->from_user_id==$user_id){
				$friend_details=$this->chat->get_friend_details($row->to_user_id);
				
				$friend_list['friend_id']=$row->to_user_id;
				$friend_list['friend_name']=$friend_details->screen_name;
				$friend_list['log_count']=$friend_details->log_count;
			}else{
				$friend_details=$this->chat->get_friend_details($row->from_user_id);
				
				$friend_list['friend_id']=$row->from_user_id;
				$friend_list['friend_name']=$friend_details->screen_name;
				$friend_list['log_count']=$friend_details->log_count;
			}
			
			if($friend_list['log_count']==0)
			{
				$friend_list['chat_status']=4;
			}
			else
			{
				$friend_list['chat_status']=$this->chat->get_chat_status($friend_list['friend_id']);
			}
			
			$i++;
			
			
			$this->chat->save_chatlist($friend_list);
		}
		
		$data['friend_list']=$this->chat->get_final_chatlist();
		
		//$data['friend_request']=$this->chat->get_friend_request();
		
		$data['new_request']=$this->chat->count_new_friend_request();
		
		
		
		
		
		$array=array(
			"list_area"=>$this->load->view('friend_list',$data,true)
			);
			
			
		echo json_encode($array);
	}
	
	function search_friend()
	{
		$user_id=$this->session->userdata('user_id');
		$friend_name=$this->input->post('friend_name');
		
		$data['search_friend_list']=$this->chat->search_friend($friend_name);
		
		foreach($data['search_friend_list'] as $row)
		{
			$friend_status=$this->chat->get_friendsihp_status($row->user_id);
			$row->friend_status=$friend_status;
		}
		
		$array=array(
			"friend_list_search_result"=>$this->load->view('friend_list_search_result',$data,true)
			);
			
		echo json_encode($array);
	}
	
	function send_friend_request()
	{

		$friend_id=$this->input->post('friend_id');
		
		$user_id=$this->session->userdata('user_id');
		
		$data=array(
			'from_user_id'=>$user_id,
			'to_user_id'=>$friend_id
		);
		
		$success=$this->chat->send_friend_request($data);
		if($success>0)
		{
			$img="<a href='javascript:void();'><img src='".$this->config->item("site_url")."/assets/images/request_send.png' alt='Request sent' /></a>";
		}
		$array=array(
			"result"=>$img
			);
		echo json_encode($array);	
	}
	
	function get_friend_list()
	{
		$user_id=$this->session->userdata('user_id');
		$return_arr=$this->chat->get_friend_list();
		
		
		$my_chat_status=$this->chat->get_chat_status();
		//echo $my_chat_status;
		
		$friend_list=array();
		$i=0;
		
		
		
		foreach($return_arr as $row)
		{
			$friend_list=array();
			
			$friend_list['user_id']=$user_id;
			
			if($row->from_user_id==$user_id){
				$friend_details=$this->chat->get_friend_details($row->to_user_id);
				
				$friend_list['friend_id']=$row->to_user_id;
				$friend_list['friend_name']=$friend_details->screen_name;
				$friend_list['log_count']=$friend_details->log_count;
			}else{
				$friend_details=$this->chat->get_friend_details($row->from_user_id);
				
				$friend_list['friend_id']=$row->from_user_id;
				$friend_list['friend_name']=$friend_details->screen_name;
				$friend_list['log_count']=$friend_details->log_count;
			}
			
			if($friend_list['log_count']==0)
			{
				$friend_list['chat_status']=4;
			}
			else
			{
				if($my_chat_status==4)	// If my status is offline then all of my friend show as offline
					$friend_list['chat_status']=4;
				else
					$friend_list['chat_status']=$this->chat->get_chat_status($friend_list['friend_id']);
			}
			
			$i++;
			
			
			$this->chat->save_chatlist($friend_list);
		}
		
		
		
		$data['friend_list']=$this->chat->get_final_chatlist();
		
		
		
		
		switch($my_chat_status)
		{
			case 1: 
				$status_img="online.png"; 
				break;
			case 2: 
				$status_img="away.png"; 
				break;
			case 3: 
				$status_img="busy.png"; 
				break;
			case 4: 
				$status_img="offline.png"; 
				break;
				
			default: 
				$status_img="offline.png"; 
				break;	
		}
		//echo $status_img;
		
		$data['my_chat_status']=$my_chat_status;
		$data['my_chat_status_img']=$status_img;
		
		
		
		$this->load->view('friend_list',$data);
	}
	
	function count_new_friend_request()
	{
		echo $new_request=$this->chat->count_new_friend_request();
	}
	
	function get_friend_request()
	{
		$user_id=$this->session->userdata('user_id');
		$data['friend_request']=$this->chat->get_friend_request();
		$this->load->view('friend_request',$data);
	}
	
	function get_input_option()
	{
		/**************************** IMPORT friend list from google**********/
		
		$google_details=$this->util->get_settings();
		
		$client_id = $google_details->google_import_client_id;
		$client_secret = $google_details->google_import_client_secret;
		
		
		$mysite_url = $this->config->item('site_url')."/import/google_oauth_import_friend";
		
			
			
		$state = sha1(uniqid(mt_rand(), true));
		$this->session->set_userdata('state',$state);
		
		$params = array(
			'client_id' => $client_id,
			'redirect_uri' => $mysite_url,
			'state' => $state,
			'approval_prompt' => 'force',
			'scope' => 'https://www.google.com/m8/feeds/',
			'response_type' => 'code'
		);
		$dialog_url = "https://accounts.google.com/o/oauth2/auth?".http_build_query($params);

		$data['dialog_url']=$dialog_url;
		
		/********************* end***************************************/
		
		$this->load->view('friend_invitation_option',$data);
	}
	
	function update_my_chatstatus($chat_status)
	{
		$this->chat->update_my_chat_status($chat_status);
		
	}
	
	function check_open_chat_status($frnd_id="")
	{
		
		$frnd_chat_status=$this->chat->get_chat_status($frnd_id);
		
		
		
		
	}
	
	
	function allow_friend_request($friend_list_id)
	{
		
		$this->chat->allow_friend_request($friend_list_id);
	}
	
	function decline_friend_request($friend_list_id)
	{
		
		$this->chat->decline_friend_request($friend_list_id); 
	}
	
	
	function chatHeartbeat() 
	{
	
		$user_id = $this->session->userdata('user_id');
		$chat_histry=$this->chat->get_chat_histry($user_id);
		
		$items = '';
		
		$message_arr = array();
		$i=0;
		foreach($chat_histry as $row)
		{
			$message=$row->message;
			$from_id=$row->from_id;
			$from_name=$row->from_name;
			$id=$row->id;
			//$frnd_chat_status=$this->chat->get_chat_status($from_id);
			
			$now = time();
			$sent_time = $row->sent;
			
			$sent_at='';
			if($now-$sent_time>120)
			{
				$time= date('g:iA M dS', $sent_time);
				$sent_at = "Sent at $time";
			}
			
			$message_arr[$i]=$id."~".$from_id."~".$from_name."~".$message."~".$sent_at."~".$frnd_chat_status;
			
			$i++;
		}
			
		$array1=array(
			"items"=>$message_arr
			);
			
		echo json_encode($array1);
	}
	
	function update_message_state()
	{
		$id=$this->input->post('id');
		$this->chat->update_message_state($id);
		
		$array=array(
			"return"=>1
			);
			
		echo json_encode($array);
	}

	
	function startchatsession()
	{
		
		$items = '';
		$array=array(
			"user_id"=>$this->session->userdata('user_id'),
			"username"=>$this->session->userdata('screen_name'),
			"items"=>''
		);
		echo json_encode($array);
		
	}
	
	function sendChat() 
	{
	
		$user_id = $this->session->userdata('user_id');
		$to_id = $this->input->post('to_id');
		$message = $this->input->post('message');


		$data=array(
			'from_id'=>$user_id,
			'to_id'=>$to_id,
			'message'=>$message,
			'sent'=>time()
		);
		
		$chat_id=$this->chat->save_chatdata($data);
		
		
		$array=array(
				"result"=>1
			);
		echo json_encode($array);	
	
	}
	
	
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */