<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//error_reporting(E_ALL);

//Controller for the video section
class Video extends CI_Controller 
{
	var $video_view = '';
	var $data = array();
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('utilitymodel','util');
		
		//$this->load->library('session');
		$this->load->helper('checklogin');
		$this->load->helper('url');
		$this->video_view	= 'video';
		//check_login();
		//$this->load->model('utilitymodel','util');
		//$this->load->library('fra_lib');
	}

	function index()
	{	
		//redirect to video list page
		redirect($this->config->item('base_url').'');		
	}
	
	//get all video listing from a page
	function video_list($call='ajax')
	{
		//load video model
		$this->load->model('videomodel', 'vid');
		$this->data['video_list']		= $this->vid->video_list();
		
		$form = $this->load->view('video/video_list', $this->data, true);
		if ($call=='ajax'){
			echo $form;
		}else{
			return $form;	
		}
		
	}
	
	//return all the video details from the playlist
	function get_all_video_from_current_playlist_play_option($call='local')
	{
		//$video_ids				= $this->session->userdata('current_playlist_videos');
		
		//load video playlist model
		$this->load->model('videoplaylistmodel', 'vidpl');
		
		//get all the videos from the playlist
		if ($this->session->userdata('current_playlist_type')=='playlist'){
			$this->data['playlist_id']	= $this->session->userdata('current_playlist_id');
			$video_ids					= $this->vidpl->get_all_videos_from_playlist($this->data);
			$this->session->set_userdata('current_playlist_type', 'playlist');
			
			//echo 'Playlist';
			//die('Playlist');
		}else{
			$video_ids					= $this->vidpl->get_current_playlist_video();
			$this->session->set_userdata('current_playlist_type', 'current');
			
			//echo 'Current';
			//die('Current');
		}
		
		$this->session->unset_userdata('current_playlist_videos');
		$this->session->set_userdata('current_playlist_videos', $video_ids);
		
		$result					= array();
		$keys					= array();
		$this->load->model('videomodel', 'vid');
		
		/*echo '<pre>';
		print_r($video_ids);
		echo '</pre>';*/
		
		$keys					= @array_keys($video_ids);
		
		/*echo '<pre>';
		print_r($keys);
		echo '</pre>';*/
		//echo count($keys);
		//die();
		
		for($i=0; $i<count($keys); $i++)
		{
			$this->data['video_id']	= $video_ids[$keys[$i]];
			$result[$keys[$i]]		= $this->vid->video_detail($this->data);
		}
		
		if (strcmp($call, 'local')==0){
			return $result;
		}else{
			echo json_encode($result);	
		}
	}
		
	//video play option
	function play_option($video_id, $view_type)
	{
		//echo $video_id;
		if (!empty($video_id))
		{
			//echo $video_id;
			$this->data['video_copy_id']	= $video_id;
			$this->data['view_type']		= $view_type;
			
			// Click video from listing Activity
			$log_type_id=14;
			$this->util->update_log($log_type_id,$video_id);
							
			//home controller
			$this->data['site_title']		= '.:Streamly Fit - Play Option:.';
			
			//load video model
			/*$this->load->model('videomodel', 'vid');
			$this->data['video_list']		= $this->vid->video_list();*/
			
			//load video model
			$this->load->model('videomodel', 'vid');
			$this->data['video_list']		= $this->vid->video_list();			
			$this->data['cur_play']			= $this->get_all_video_from_current_playlist_play_option();
			
			//print_r($this->data);
			
			$this->load->view('header', $this->data);
			$this->data['video_list_page']	= $this->load->view('video/video_list', $this->data, true);
			$this->data['playlist_page']	= $this->load->view('video/video_playlist', $this->data, true);
			$this->load->view('video/video_play_option', $this->data);
			$this->load->view('video/video_footer', $this->data);
		}else{
			redirect($this->config->item('base_url'));	
		}
		
		
	}
	
	//play sample video
	function play_sample($video_id)
	{
		if (!empty($video_id)){
			$this->data['video_id']			= $video_id;
			
			// View sample video Activity
			$log_type_id=31;
			$this->util->update_log($log_type_id,$video_id);
			
			//home controller
			$this->data['site_title']		= '.:Streamly Fit - Play Sample:.';
			
			//load video model
			/*$this->load->model('videomodel', 'vid');
			$this->data['video_detail']		= $this->vid->video_detail($this->data);		
			$this->data['video_list']		= $this->vid->video_list();*/
			//load video model
			$this->load->model('videomodel', 'vid');
			$this->load->model('videoplaylistmodel', 'vidpl');
			
			/*if ($this->data['view_type']=='video'){*/
				$this->data['video_detail']		= $this->vid->video_detail($this->data);		
				$this->data['video_list']		= $this->vid->video_list();
			/*}else{
				$this->data['playlist_id']		= $this->input->post('video_id');
				$this->data['playlist_detail']	= $this->vidpl->playlist_details($this->data);
				$this->data['video_detail']		= $this->vidpl->playlist_list_video($this->data);
			}*/
			
			$this->load->view('video/video_header', $this->data);
			$this->data['video_list_page']	= $this->load->view('video/video_list', $this->data, true);
			$this->data['playlist_page']	= $this->load->view('video/video_playlist', $this->data, true);
			$this->load->view('video/video_play', $this->data);
			$this->load->view('video/video_footer', $this->data);
		}else{
			redirect($this->config->item('base_url'));
		}
	}
	
	//start playing the video, when friend accepts the video invititation
	function refresh($view_id)
	{
		$this->data['view_id']				= $view_id;
		
		//load video model
		$this->load->model('videomodel', 'vid');
		$this->load->model('videoplaylistmodel', 'vidpl');
		
		
		//update the sender play status
		$this->vid->update_sender_play_status($this->data);
		
		$this->data['result']				= $this->vid->get_view_video($this->data);
		$this->data['video_list']			= $this->vid->video_list();
		
		$this->data['video_id']				= $this->data['result']->vid_id;		
		
		//get the video details & view details for video invite or playlist invite		
		
		if ($this->data['result']->is_playlist=='N'){
			$this->data['view_type']		= 'video';
		}else{
			$this->data['view_type']		= 'playlist';
		}
		
		if ($this->data['result']->is_playlist=='N'){
			$this->data['video_detail']		= $this->vid->video_detail($this->data);		
			$this->data['video_list']		= $this->vid->video_list();
		}else{
			$this->data['playlist_id']		= $this->data['video_id'];
			$this->data['playlist_detail']	= $this->vidpl->playlist_details($this->data);
			$this->data['video_detail']		= $this->vidpl->playlist_list_video($this->data);
		}
		
		$form = $this->load->view('video/video_refresh', $this->data, true);
		echo $form;
	}
	
	//display video waiver form
	function video_waiver()
	{
		$this->data['video_id']			= $this->input->post('video_id');
		
		$form							= $this->load->view('video/video_terms_conditions', $this->data, true);
		echo $form;
		
	}
	
	//video play
	function play()
	{								
		if (!empty($_POST)){
			$this->data['action']			= $this->input->post('action');
			$this->data['video_id']			= $this->input->post('video_id');
			$this->data['view_mode']		= $this->input->post('play_option_select');
			//$this->data['view_type']		= $this->input->post('view_type');
			$this->data['friend_id']		= $this->input->post('buddy_id');
			$this->data['user_id']			= $this->session->userdata('user_id');		
			
			if ($this->input->post('view_type')==''){
				$this->data['view_type']	= 'video';
			}else{
				$this->data['view_type']	= $this->input->post('view_type');
			}
						
			//load video model
			$this->load->model('videomodel', 'vid');
			$this->load->model('videoplaylistmodel', 'vidpl');
			
			if ($this->data['view_type']=='video'){
				$this->data['video_detail']		= $this->vid->video_detail($this->data);		
				$this->data['video_list']		= $this->vid->video_list();
			}else{
				$this->data['playlist_id']		= $this->input->post('video_id');
				$this->data['playlist_detail']	= $this->vidpl->playlist_details($this->data);
				$this->data['video_detail']		= $this->vidpl->playlist_list_video($this->data);
			}
			
			//load video playlist model
			//$this->load->model('videoplaylistmodel', 'vidpl');
			//$this->data['video_playlist']	= $this->vidpl->playlist_list_user($this->data);
			
			if ($this->data['view_mode']=='A')
			{	
				// Just the video Activity
				$log_type_id=15;
				$this->util->update_log($log_type_id, $this->data['video_id']);
				
						
				$this->data['site_title']	= '.:Streamly Fit - Video Play:.';
				//play video alone without webcam
				$this->data['vid_sess_id']	= '';
				$this->data['view_id']		= $this->vid->video_view_user_save($this->data);
							
				//exit();
				$this->load->view('video/video_header', $this->data);
				$this->data['video_list_page']	= $this->load->view('video/video_list', $this->data, true);
				$this->data['playlist_page']	= $this->load->view('video/video_playlist', $this->data, true);
				$this->load->view('video/video_new_play', $this->data);
				$this->load->view('video/video_footer');
				
			}elseif ($this->data['view_mode']=='WC')
			{
				
				// With a mirror Activity
				$log_type_id=17;
				$this->util->update_log($log_type_id, $this->data['video_id']);
				
				
				//play video with webcam
				$this->data['site_title']			= '.:Streamly Fit - Video Play With Webcam:.';
				
				//get tokbox api, session, token
				$data 								= $this->openTok($this->session->userdata('tokbox_session_id'));
				
				//save token/session
				$this->data['vid_sess_id']			= htmlentities($data['session_id']);
				
				//save user view data in database
				$this->data['view_id']				= $this->vid->video_view_user_save($this->data);
				
				//initialise session tokens for use with tokbox
				$this->data['api_key']				= $data['api_key'];
				$this->data['session_token']		= $data['session_token'];
				$this->data['vid_sess_id']			= $data['session_id'];						
				
				$this->load->view('video/video_header', $this->data);
				$this->data['video_list_page']	= $this->load->view('video/video_list', $this->data, true);
				$this->data['playlist_page']	= $this->load->view('video/video_playlist', $this->data, true);
				//$this->load->view('video/video_play_webcam', $this->data);
				$this->load->view('video/video_new_play_webcam', $this->data);
				$this->load->view('video/video_footer');			
				
			}elseif ($this->data['view_mode']=='WF')
			{
			
				// With a friend Activity
				$log_type_id=16;
				$this->util->update_log($log_type_id, $this->data['video_id']);
				
				
				//play video with webcam or invite buddy
				$this->data['site_title']			= '.:Streamly Fit - Video Play With Friend:.';
				
				//get tokbox api, session, token
				$data 								= $this->openTok($this->session->userdata('tokbox_session_id'));
				
				//save token/session
				$this->data['vid_sess_id']			= htmlentities($data['session_id']);
				
				//save user view data in database
				$this->data['view_id']				= $this->vid->video_view_user_save($this->data);
				
				//initialise session tokens for use with tokbox
				$this->data['api_key']				= $data['api_key'];
				$this->data['session_token']		= $data['session_token'];
				$this->data['vid_sess_id']			= $data['session_id'];
				
				//load chat model to get the friend list
				$this->load->model('chatmodel', 'chat');
				$friend_list						= $this->chat->get_friend_list();
				
				$i = 0;
				foreach($friend_list as $row)
				{								
					if ($row->from_user_id==$this->session->userdata('user_id'))
					{
						$friend_details									= $this->chat->get_friend_details($row->to_user_id);
						$this->data['friend_list'][$i]['friend_id']		= $row->to_user_id;
						$this->data['friend_list'][$i]['friend_name']	= $friend_details->screen_name;
						$this->data['friend_list'][$i]['log_count'] 	= $friend_details->log_count;
					} else{
						$friend_details									= $this->chat->get_friend_details($row->from_user_id);
						$this->data['friend_list'][$i]['friend_id']		= $row->from_user_id;
						$this->data['friend_list'][$i]['friend_name']	= $friend_details->screen_name;
						$this->data['friend_list'][$i]['log_count']		= $friend_details->log_count;
					}
					$i++;
					
				}
				
				$this->load->view('video/video_header', $this->data);
				$this->data['video_list_page']	= $this->load->view('video/video_list', $this->data, true);
				$this->data['playlist_page']	= $this->load->view('video/video_playlist', $this->data, true);
				$this->load->view('video/video_new_play_friend', $this->data);
				$this->load->view('video/video_footer');
			}
			
		}else{
			redirect($this->config->item('base_url'));	
		}
	}
	
	//get all the buddy list in the popup form for invite
	function get_buddy_list_popup()
	{
		$this->data['video_id']				= $this->input->post('video_id');
		$this->data['view_type']			= $this->input->post('view_type');
		
		//load chat model to get the friend list
		$this->load->model('chatmodel', 'chat');
		$friend_list						= $this->chat->get_friend_list();
		
		$i = 0;
		foreach($friend_list as $row)
		{								
			if ($row->from_user_id==$this->session->userdata('user_id'))
			{
				$friend_details									= $this->chat->get_friend_details($row->to_user_id);
				$this->data['friend_list'][$i]['friend_id']		= $row->to_user_id;
				$this->data['friend_list'][$i]['friend_name']	= $friend_details->screen_name;
				$this->data['friend_list'][$i]['log_count'] 	= $friend_details->log_count;
			} else{
				$friend_details									= $this->chat->get_friend_details($row->from_user_id);
				$this->data['friend_list'][$i]['friend_id']		= $row->from_user_id;
				$this->data['friend_list'][$i]['friend_name']	= $friend_details->screen_name;
				$this->data['friend_list'][$i]['log_count']		= $friend_details->log_count;
			}
			$i++;
			
		}
		
		$form = $this->load->view('video/video_buddy_list_popup', $this->data, true);
		echo $form;
	}
	
	//send invite to buddy for video sharing for ajax call
	function invite_buddy($view_id, $friend_id)
	{
		
		//initialise the view id & friend id
		$this->data['view_id']				= $view_id;
		$this->data['friend_id']			= $friend_id;
		
		//load the video model
		$this->load->model('videomodel', 'vid_view');
		$result								= $this->vid_view->video_invite_buddy($this->data);
		
		// Invite buddy for workout Activity
		$log_type_id=32;
		$this->util->update_log($log_type_id, $this->data['view_id']);
				
		echo $result;
	}
	
	//check the video updates
	function check_invites()
	{
		if ($this->session->userdata('user_id')!=''){
			$this->data['user_id']				= $this->session->userdata('user_id');
					
			//load video model
			$this->load->model('videomodel', 'vid');
			$this->data['result']				= $this->vid->video_invite_check($this->data);
			
			$form								= $this->load->view('video/video_load_invites', $this->data, true);
			echo $form;
		}else{
			echo 0;	
		}
		
	}
	
	//update buddy status when buddy accepts the video invitation
	function accept_video_request($view_id)
	{
		$this->data['view_id']				= $view_id;
		
		//save view data of user
		$this->load->model('videomodel', 'vid_view');
		$result								= $this->vid_view->video_update_buddy_status($this->data);
		
		// Invite buddy for workout Activity
		$log_type_id=33;
		$this->util->update_log($log_type_id, $this->data['view_id']);
		
		
		echo $result;	
	}
	
	//update buddy status when buddy declines the video invitation
	function decline_video_request($view_id)
	{
		$this->data['view_id']				= $view_id;
		
		//save view data of user
		$this->load->model('videomodel', 'vid_view');
		$result								= $this->vid_view->video_update_buddy_decline_invite($this->data);
		
		// Decline video request for workout Activity
		$log_type_id=34;
		$this->util->update_log($log_type_id, $this->data['view_id']);
		
		
		echo 1;
	}
	
	//check for sender notofication for accept/decline video
	function sender_notification()
	{
		//load the video view model
		$this->load->model('videomodel', 'vid_view');
		$result								= $this->vid_view->sender_notification();
		
		if ($result!=0)
		{
			$this->data['result']			= 1;
			$this->data['buddy_id']			= $result->buddy_id;
			$this->data['view_id']			= $result->view_id;
			$this->data['screen_name']		= $result->screen_name;
		}else{
			$this->data['result']			= 0;
		}
		
		echo json_encode($this->data);
	}
	
	//update the sender notification
	function update_sender_notification()
	{
		$this->data['view_id']				= $this->input->get('view_id');
		
		//load the video view model
		$this->load->model('videomodel', 'vid_view');
		$result								= $this->vid_view->update_sender_notification($this->data);
		echo $result;
	}
	
	//update sender view video status
	function update_view_status()
	{
		$this->data['view_id']				= $this->input->get('view_id');
		
		//load the video view model
		$this->load->model('videomodel', 'vid_view');
		$result								= $this->vid_view->update_view_status($this->data);
		echo $result;
		
	}
	
	//check the sender video view status
	function check_view_status()
	{
		$this->data['view_id']				= $this->input->get('view_id');
		
		//load the video view model
		$this->load->model('videomodel', 'vid_view');
		$result								= $this->vid_view->check_view_status($this->data);
		echo $result;
	}
	
	//invite buddy to share video
	function invite($view_id)
	{
		//play video with webcam or invite buddy
		$this->data['site_title']			= '.:Streamly Fit - Video Play Invitation:.';
			
		$this->data['view_id']				= $view_id;
				
		//save view data of user
		$this->load->model('videomodel', 'vid_view');		
		$this->data['result']				= $this->vid_view->get_view_video($this->data);
		$this->data['video_list']			= $this->vid_view->video_list();
		
		$this->data['video_id']				= $this->data['result']->vid_id;						
		
		//get the video details & view details for video invite or playlist invite
		//load video model
		$this->load->model('videomodel', 'vid');
		$this->load->model('videoplaylistmodel', 'vidpl');
		
		if ($this->data['result']->is_playlist=='N'){
			$this->data['view_type']		= 'video';
		}else{
			$this->data['view_type']		= 'playlist';
		}				
		
		if ($this->data['result']->is_playlist=='N'){
			$this->data['video_detail']		= $this->vid->video_detail($this->data);
			$this->data['video_list']		= $this->vid->video_list();
		}else{
			$this->data['playlist_id']		= $this->data['video_id'];
			$this->data['playlist_detail']	= $this->vidpl->playlist_details($this->data);
			$this->data['video_detail']		= $this->vidpl->playlist_list_video($this->data);
		}
		
		//generate tokbox token with the session id
		$session_id							= $this->data['result']->vid_sess_id;
		$data								= $this->openTok($session_id);
		
		//initialise session tokens for use with tokbox
		$this->data['api_key']				= $data['api_key'];
		$this->data['session_token']		= $data['session_token'];
		$this->data['vid_sess_id']			= $data['session_id'];		
		
		//code need to be written
		
		
		$this->load->view('video/video_header', $this->data);
		$this->data['video_list_page']	= $this->load->view('video/video_list', $this->data, true);
		$this->data['playlist_page']	= $this->load->view('video/video_playlist', $this->data, true);
		$this->load->view('video/video_new_play_invites', $this->data);
		$this->load->view('video/video_footer');
		
	}
	
	//create new playlist
	function create_new_playlist()
	{		
		//load video playlist model
		$this->load->model('videoplaylistmodel', 'vidpl');
		$video_ids					= $this->vidpl->get_all_videos_from_playlist($this->data);
		$this->data['video_ids']	= $video_ids;
		
		$this->session->unset_userdata('current_playlist_id');
		$this->session->set_userdata('current_playlist_id', '');
		
		$this->session->unset_userdata('current_playlist_videos');
		$this->session->set_userdata('current_playlist_videos', $video_ids);
		
		$this->session->unset_userdata('current_playlist_type');
		$this->session->set_userdata('current_playlist_type', "current");
		
		$this->session->unset_userdata('current_playlist_name');
		$this->session->set_userdata('current_playlist_name', '');
		
		$this->session->unset_userdata('current_playlist_duration');
		$this->session->set_userdata('current_playlist_duration', '');
		
		$this->data['cur_play']		= '';
		
		$form = $this->load->view('video/video_playlist', $this->data, true);
		echo $form;		
	}
	
	//get total video duration
	function video_duration($video_ids=array())
	{
		if (!empty($video_ids)){
			$this->data['video_ids']		= $video_ids;
		}else{
			$this->data['video_ids']		= $this->session->userdata('current_playlist_videos');
		}
		
		$this->load->model('videomodel', 'vid');
		$this->load->model('videoplaylistmodel', 'vidpl');
		
		/*if ($this->session->userdata('current_playlist_id')=='current')
		{
			$this->data['type']					= 'current';
			$this->data['current_playlist_id']	= $this->session->userdata('current_playlist_id');
			$this->data['video_ids']			= $this->vidpl->get_current_playlist_video();
		}elseif ($this->session->userdata('current_playlist_id')=='playlist'){
			$this->data['type']					= 'playlist';
			$this->data['playlist_id']			= $this->session->userdata('current_playlist_id');
			$this->data['video_ids']			= $this->vidpl->get_all_videos_from_playlist($this->data);
		}*/
		
		
		//print_r($this->data);
		//die();
		
		$result = $this->vid->video_total_duration($this->data);		
		
		$data = json_decode($this->secondsToTime($result));
		
		$this->session->unset_userdata('current_playlist_duration');
		$this->session->set_userdata('current_playlist_duration', $data);
		
		//print_r($data);
		/*if (!empty($video_ids))
		{
			return $data;
		}else{
			echo json_encode($data);
		}*/
		echo json_encode($data);
	}
	
	//add videos to playlist to display in the current playlist
	function add_video_playlist()
	{
		$video_ids						= array();
		$video_details					= array();
		
		$this->data['video_id']			= $this->input->get('video_id');
		$this->data['playlist_id']		= $this->input->get('playlist_id');
		$this->data['playlist_type']	= $this->input->get('playlist_type');
		$this->data['sort_order']		= $this->input->get('sort_order');
		
		//load video playlist model
		$this->load->model('videoplaylistmodel', 'vidpl');
		
		if (!empty($this->data['playlist_id']) && $this->session->userdata('user_id')!='' && $this->data['playlist_type']=='playlist'){
			//load all videos from the playlist into temp array
			$video_ids					= $this->vidpl->playlist_list_videos($this->data);
			if (in_array($this->data['video_id'], $video_ids))
			{
				$this->data['result']	= 0;
				$this->data['msg']		= 'Video Already In Playlist';
			}else{
				//add the video in the playlist
				$this->vidpl->playlist_add_video($this->data);
				//$video_ids					= $this->vidpl->playlist_list_videos($this->data);
			}
			$video_ids					= $this->vidpl->playlist_list_videos($this->data);
			$this->data['video_ids']	= $video_ids;
			$this->session->set_userdata('current_playlist_videos', $video_ids);
			$this->session->set_userdata('current_playlist_type', "playlist");
		}else{
			if ($this->session->userdata('current_playlist_id')!='')
			{
				//$video_ids				= $this->session->userdata('current_playlist_videos');
				$video_ids				= $this->vidpl->get_current_playlist_video();
								
			}else{
				//$hash					= md5(time().uniqid()); //create a random hash
				//$this->session->set_userdata('current_playlist_id', $hash);
				$video_ids				= $this->session->userdata('current_playlist_videos');				
			}
			
			if (@in_array($this->data['video_id'], $video_ids))
			{
				$this->data['result']	= 0;
				$this->data['msg']		= 'Video Already In Playlist';
			}else{
				$video_ids[$this->data['sort_order']]		= $this->data['video_id'];
				ksort($video_ids);
				
				$this->data['video_ids']= $video_ids;
				
				//add the array in the current playlist table
				$current_playlist_id	= $this->vidpl->video_add_current_playlist($this->data);
				
				//get all the videos from the playlist				
				$video_ids				= $this->vidpl->get_current_playlist_video();
				$this->data['video_ids']= $video_ids;
				
				$this->session->unset_userdata('current_playlist_id');
				$this->session->set_userdata('current_playlist_id', $current_playlist_id);
				
				$this->session->unset_userdata('current_playlist_videos');
				$this->session->set_userdata('current_playlist_videos', $video_ids);
			}
			$this->session->set_userdata('current_playlist_type', "current");
		}
		
		//get the whole playlist
		//$this->data['form']				= $this->load_videos_current_playlist($video_ids);
		
		//get the total video duration
		/*$data							= $this->video_duration($video_ids);
		
		$this->session->unset_userdata('current_playlist_duration');
		$this->session->set_userdata('current_playlist_duration', $data);*/
		
		//print_r($video_ids);
		
		$this->data['video_ids']		= $this->session->userdata('current_playlist_videos');
		
		$this->data['play_link']		= $this->load->view('video/video_add_to_playlist', $this->data, true);
		$this->data['total_videos']		= count($video_ids);
		
		$this->load->model('videomodel', 'vid');
		$this->data['data'] 			= $this->vid->video_detail($this->data);
		
		if ($this->data['total_videos']==1)
		{
			$this->data['duration']		= json_decode($this->secondsToTime($this->data['data']->video_duration));
		}
		
		
		echo json_encode($this->data);
		
	}	
	
	//add video in the playlist anyway
	function add_video_playlist_override()
	{
		$video_ids						= array();
		$video_details					= array();
		
		$this->data['video_id']			= $this->input->get('video_id');
		$this->data['playlist_id']		= $this->input->get('playlist_id');
		$this->data['playlist_type']	= $this->input->get('playlist_type');
		$this->data['sort_order']		= $this->input->get('sort_order');
		
		//load video playlist model
		$this->load->model('videoplaylistmodel', 'vidpl');
		
		if (!empty($this->data['playlist_id']) && $this->session->userdata('user_id')!='' && $this->data['playlist_type']=='playlist'){
			//load all videos from the playlist into temp array
			$video_ids					= $this->vidpl->playlist_list_videos($this->data);
						
			//add the video in the playlist
			$this->vidpl->playlist_add_video($this->data);
			$video_ids					= $this->vidpl->playlist_list_videos($this->data);
			$this->session->set_userdata('current_playlist_videos', $video_ids);
			$this->session->set_userdata('current_playlist_type', "playlist");
		}else{
			if ($this->session->userdata('current_playlist_id')!='')
			{
				//$video_ids				= $this->session->userdata('current_playlist_videos');
				$video_ids				= $this->vidpl->get_current_playlist_video();
								
			}else{
				//$hash					= md5(time().uniqid()); //create a random hash
				//$this->session->set_userdata('current_playlist_id', $hash);
				$video_ids				= $this->session->userdata('current_playlist_videos');				
			}
						
			$video_ids[$this->data['sort_order']]		= $this->data['video_id'];
			ksort($video_ids);
			
			$this->data['video_ids']= $video_ids;
			
			//add the array in the current playlist table
			$current_playlist_id	= $this->vidpl->video_add_current_playlist($this->data);
						
			//get all the videos from the playlist				
			$video_ids				= $this->vidpl->get_current_playlist_video();
			$this->data['video_ids']= $video_ids;
			
			$this->session->unset_userdata('current_playlist_id');
			$this->session->set_userdata('current_playlist_id', $current_playlist_id);
			
			$this->session->unset_userdata('current_playlist_videos');
			$this->session->set_userdata('current_playlist_videos', $video_ids);
			
			$this->session->set_userdata('current_playlist_type', "current");
		}
		
		//get the whole playlist
		//$this->data['form']				= $this->load_videos_current_playlist($video_ids);
		
		//get the total video duration
		/*$data							= $this->video_duration($video_ids);
		
		$this->session->unset_userdata('current_playlist_duration');
		$this->session->set_userdata('current_playlist_duration', $data);*/
		
		$this->data['play_link']		= $this->load->view('video/video_add_to_playlist', $this->data, true);
		$this->data['total_videos']		= count($video_ids);
		
		$this->load->model('videomodel', 'vid');
		$this->data['data'] 			= $this->vid->video_detail($this->data);		
		echo json_encode($this->data);
		
	}
	
	//display the video option during video addition if there is any duplicate video
	function add_video_playlist_option()
	{
		$this->data['video_id']			= $this->input->post('video_id');
		$this->data['playlist_id']		= $this->input->post('playlist_id');
		$this->data['sort_order']		= $this->input->post('sort_order');
		$this->data['playlist_type']	= $this->input->post('playlist_type');
		
		$form = $this->load->view('video/video_add_video_playlist_option', $this->data, true);
		echo $form;
	}
	
	//remove a video from current playlist
	function remove_video_current_playlist()
	{
		$video_ids						= array();
		$video_details					= array();
		
		$this->data['video_id']			= $this->input->get('video_id');
		$this->data['playlist_id']		= $this->input->get('playlist_id');
		$this->data['playlist_type']	= $this->input->get('playlist_type');
		$this->data['sort_order']		= $this->input->get('sort_order');
		
		//$video_ids						= $this->session->userdata('current_playlist_videos');
		
		//load video playlist model
		$this->load->model('videoplaylistmodel', 'vidpl');
		
		//get all the videos from the playlist
		if ($this->session->userdata('current_playlist_type')=='current'){
			$video_ids				= $this->vidpl->get_current_playlist_video();
			$this->data['video_ids']= $video_ids;
		}else{
			$this->data['playlist_id']	= $this->session->userdata('current_playlist_id');
			$video_ids					= $this->vidpl->get_all_videos_from_playlist($this->data);
			$this->data['video_ids']	= $video_ids;
		}
		$tmp = array();				
		
		//$key = array_search($this->data['video_id'], $video_ids);
		
		if ($this->data['video_id']==$video_ids[$this->data['sort_order']]){
			//echo $video_ids[$this->data['sort_order']];
			unset($video_ids[$this->data['sort_order']]);
		}
		
		
		$this->data['video_ids']= $video_ids;
				
		//add the array in the current playlist table
		if ($this->session->userdata('current_playlist_type')=='current'){
			$current_playlist_id	= $this->vidpl->video_add_current_playlist($this->data);
			//get all the videos from the playlist				
			$video_ids				= $this->vidpl->get_current_playlist_video();
			$this->session->unset_userdata('current_playlist_id');
			$this->session->set_userdata('current_playlist_id', $current_playlist_id);	
		}else{
			
		}
		
		if ($this->data['playlist_type']=='playlist')
		{
			$this->load->model('videoplaylistmodel', 'vidpl');
			$this->vidpl->playlist_remove_video($this->data);
			
			$video_ids					= $this->vidpl->get_all_videos_from_playlist($this->data);
			$this->data['video_ids']	= $video_ids;	
		}
		
		//get the total video duration
		/*$data							= $this->video_duration($video_ids);
		
		$this->session->unset_userdata('current_playlist_duration');
		$this->session->set_userdata('current_playlist_duration', $data);*/
		
		$this->session->unset_userdata('current_playlist_videos');
		$this->session->set_userdata('current_playlist_videos', $video_ids);
		
		$this->data['total_videos']		= count($video_ids);
		
		echo json_encode($this->data['total_videos']);
	}
	
	//return all the video details from the playlist
	function get_all_video_from_current_playlist($call='local')
	{
		$video_ids				= $this->session->userdata('current_playlist_videos');
		$result					= array();
		$keys					= array();
		$this->load->model('videomodel', 'vid');
		
		$keys					= array_keys($video_ids);
		
		for($i=0; $i<count($keys); $i++)
		{
			$this->data['video_id']	= $video_ids[$i];
			$result[$i]				= $this->vid->video_detail($this->data);
		}
		
		if (strcmp($call, 'local')==0){
			return $result;
		}else{
			echo json_encode($result);	
		}
	}
	
	//get the form to save a new playlist for ajax call
	function save_new_playlist_form()
	{
		$form = $this->load->view('video/video_playlist_save_option', '', true);
		echo $form;
	}
	
	//check to see if playlist exist or not
	function check_playlist_name_exist()
	{
		$this->data['playlist_title']		= $this->input->get('playlist_caption');
		
		//load video playlist model
		$this->load->model('videoplaylistmodel', 'vidpl');
		$result = $this->vidpl->check_playlist_name_exist($this->data);
		
		if ($result==0)
		{
			echo 0;	
		}else{
			echo 1;	
		}
	}
	
	//save the current playlist form
	function save_new_playlist_form_data()
	{
		$this->data['playlist_title']		= $this->input->get('playlist_caption');
		
		//load video playlist model
		$this->load->model('videoplaylistmodel', 'vidpl');
		$this->data['playlist_id']			= $this->vidpl->save_new_playlist_form($this->data);
		
		// Create playlist Activity
		$log_type_id=18;
		$this->util->update_log($log_type_id, $this->data['playlist_id']);
		
		
		//get all the videos from the playlist				
		$video_ids							= $this->vidpl->get_current_playlist_video();
		$this->session->unset_userdata('current_playlist_videos');
		$this->session->set_userdata('current_playlist_videos', $video_ids);
		
		$keys								= @array_keys($video_ids);
		
		for($i=0; $i<count($keys); $i++)
		{
			$this->data['video_id']			= $video_ids[$keys[$i]];
			$this->data['sort_order']		= $keys[$i];
			$result							= $this->vidpl->playlist_add_video($this->data);
		}
		
		$this->session->unset_userdata('current_playlist_id');
		$this->session->set_userdata('current_playlist_id', $this->data['playlist_id']);
		
		$this->session->unset_userdata('current_playlist_videos');
		$this->session->set_userdata('current_playlist_videos', $video_ids);
		
		$this->session->unset_userdata('current_playlist_type');
		$this->session->set_userdata('current_playlist_type', "playlist");
		
		$this->session->set_userdata('current_playlist_name', $this->data['playlist_title']);
		
		echo $this->data['playlist_id'];
	}
	
	//rename playlist title
	function rename_playlist_title()
	{
		$this->data['playlist_title']		= $this->input->get('playlist_caption');
		$this->data['playlist_id']			= $this->input->get('playlist_id');
		
		//load the plylist model
		$this->load->model('videoplaylistmodel', 'vidpl');
		$result = $this->vidpl->rename_playlist_title($this->data);
		
		$this->session->set_userdata('current_playlist_name', $this->data['playlist_title']);		
		echo $result;		
	}
	
	//get the playlist of the user
	function load_all_user_playlist()
	{
		$this->data['user_id']		= $this->session->userdata('user_id');
		
		//load the playlist model
		$this->load->model('videoplaylistmodel', 'vidpl');
		$this->data['result'] 		= $this->vidpl->playlist_list_user($this->data);						
		
		$form = $this->load->view('video/video_user_playlist', $this->data, true);
		echo $form;
	}
	
	//load a single playlist
	function load_single_user_playlist()
	{
		$this->data['playlist_id']		= $this->input->get('playlist_id');
		$this->data['playlist_title']	= $this->input->get('playlist_title');
		
		//load video playlist model
		$this->load->model('videoplaylistmodel', 'vidpl');
		$video_ids					= $this->vidpl->get_all_videos_from_playlist($this->data);
		$this->data['video_ids']	= $video_ids;
		
		$this->session->unset_userdata('current_playlist_id');
		$this->session->set_userdata('current_playlist_id', $this->data['playlist_id']);
		
		$this->session->unset_userdata('current_playlist_videos');
		$this->session->set_userdata('current_playlist_videos', $video_ids);
		
		$this->session->unset_userdata('current_playlist_type');
		$this->session->set_userdata('current_playlist_type', "playlist");
		
		$this->session->unset_userdata('current_playlist_name');
		$this->session->set_userdata('current_playlist_name', $this->data['playlist_title']);
		
		$result					= array();
		$keys					= array();
		
		//load the video model
		$this->load->model('videomodel', 'vid');
		
		$keys					= array_keys($video_ids);
		
		for($i=0; $i<count($keys); $i++)
		{
			$this->data['video_id']	= $video_ids[$i];
			$result[$i]				= $this->vid->video_detail($this->data);
		}
		
		$this->data['cur_play']		= $result;
		
		$form = $this->load->view('video/video_playlist', $this->data, true);
		echo $form;		
	}
	
	//delete user playlist
	function remove_user_playlist()
	{
		$this->data['playlist_id']		= $this->input->get('playlist_id');	
		//load the video playlist
		$this->load->model('videoplaylistmodel', 'vidpl');
		$result							= $this->vidpl->remove_playlist($this->data);
		echo $result;
	}
	
	
	//delete an existing playlist
	function delete_playlist()
	{
		$this->data['playlist_id']	= $this->input->post('playlist_id');
		
		//load the video playlist
		$this->load->model('videoplaylistmodel', 'vidpl');
		$result						= $this->vidpl->remove_playlist($this->data);
		
		if ($this->session->set_userdata('current_playlist_id')==$this->data['playlist_id']){
			$this->session->unset_userdata('current_playlist_id');			
			
			$this->session->unset_userdata('current_playlist_videos');			
			
			$this->session->unset_userdata('current_playlist_type');			
			
			$this->session->unset_userdata('current_playlist_name');			
		}
		
		
		echo 1;
	}
	
	//get the current videos in the current playlist
	function current_playlist()
	{
		echo '<pre>';	
		print_r($this->session->userdata('current_playlist_videos'));
		echo '</pre>';
	}
	
	//poll to check the buddy status
	function check_buddy_status($view_id)
	{
		$this->data['view_id']				= $view_id;
		
		//save view data of user
		$this->load->model('videomodel', 'vid_view');
		$result								= $this->vid_view->video_check_buddy_status($this->data);
		echo $result;		
	}
		
	
	//load the buddy list for ajax call
	function get_buddy_list()
	{
		$this->data['video_id']				= $this->input->post('video_id');
		$this->data['view_id']				= $this->input->post('view_id');
		
		//load chat model to get the friend list
		$this->load->model('chatmodel', 'chat');
		$friend_list						= $this->chat->get_friend_list();
		
		$i = 0;
		foreach($friend_list as $row)
		{								
			if ($row->from_user_id==$this->session->userdata('user_id'))
			{
				$friend_details									= $this->chat->get_friend_details($row->to_user_id);
				$this->data['friend_list'][$i]['friend_id']		= $row->to_user_id;
				$this->data['friend_list'][$i]['friend_name']	= $friend_details->screen_name;
				$this->data['friend_list'][$i]['log_count'] 	= $friend_details->log_count;
			} else{
				$friend_details									= $this->chat->get_friend_details($row->from_user_id);
				$this->data['friend_list'][$i]['friend_id']		= $row->from_user_id;
				$this->data['friend_list'][$i]['friend_name']	= $friend_details->screen_name;
				$this->data['friend_list'][$i]['log_count']		= $friend_details->log_count;
			}
			$i++;
			
		}
		
		$form = $this->load->view('video/video_buddy_list', $this->data, true);
		echo $form;
	}
	
	//initialise the tokbox
	function openTok($sessionId = null)
	{
		//load tokbox helper file
		$this->load->library("OpenTok/OpenTok");
		
		//initialise tokbox api
		$api_key		= '17348612';
		$secret_key		= 'cb1a8cf2f8a16ceed44860ada451ef40a33ae7dc';
		
		//arguments not necessary if you've set the API key in API_config.php in API_Config.php
		$OT = new OpenTok($api_key, $secret_key);
		
		if ($sessionId) {
			$OT->set_session_id($sessionId);
		} else {
			$OT->generate_session_id();
		}
		
		$OT->generate_token();
		
		$data = array();
		
		$data["api_key"] = $OT->apiKey;
		$data["session_id"] = $OT->sessionId;
		$data["session_token"] = $OT->token;
		return $data;
		
	}
	
	//convert time from seconds to h:m:s
	function secondsToTime($seconds)
	{
		// extract hours
		$hours = floor($seconds / (60 * 60));
	 
		// extract minutes
		$divisor_for_minutes = $seconds % (60 * 60);
		$minutes = floor($divisor_for_minutes / 60);
	 
		// extract the remaining seconds
		$divisor_for_seconds = $divisor_for_minutes % 60;
		$seconds = ceil($divisor_for_seconds);
	 
		// return the final array
		$obj = array(
			"h" => (int) $hours,
			"m" => (int) $minutes,
			"s" => (int) $seconds,
		);
		return json_encode($obj);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */