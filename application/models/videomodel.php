<?php

//model for the video section
class Videomodel extends CI_Model
{
	/*
	var $video_id = '';
	var $video_caption = '';
	var $video_url = '';
	var $video_sample = '';
	var $video_image = '';
	var $video_cr_dt = '';
	var $video_status = '';	
	var $table_name = '';*/
	
    function __construct()
	{
    	parent::__construct();		
		$this->table_name		= 'evolve_videos';
    }
    
	//video list for dance workouts
	function video_list()
	{
		$this->db->select('*');
		$this->db->from($this->table_name);
		/*$this->db->where('video_category', '1');*/
		$this->db->where('video_status', 'A');
		$this->db->order_by('video_cr_dt', 'DESC');
		$result = $this->db->get()->result();
		return $result;
	}
	
	//get videos for different category
	function video_list_for_categories($params=array())
	{
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('video_category', $params['video_category']);
		$this->db->where('video_status', 'A');
		$this->db->order_by('video_cr_dt', 'DESC');
		$result = $this->db->get()->result();
		return $result;
	}
	
	//get a video details
	function video_detail($params=array())
	{
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->where('video_id', $params['video_id']);
		$result = $this->db->get()->row_object();
		return $result;
	}
	
	//get total video duration
	function video_total_duration($params=array())
	{
		$video_ids = $this->session->userdata('current_playlist_videos');
		$total_duration = 0;
		if (!empty($video_ids))
		{
			/*$sql_query = 'SELECT SUM(video_duration) as total_duration FROM `evolve_videos` WHERE video_id IN('.implode(',', $video_ids).')';
			$query = $this->db->query($sql_query);
			$result = $query->row_object();
			return $result->total_duration;*/
			/*$this->db->select('SUM(video_duration) as total_duration');
			$this->db->from('evolve_videos');
			$this->db->where_in('video_id', $this->session->userdata('current_playlist_videos'));
			$result = $this->db->get()->row_object();
			return $result->total_duration;*/
			
			foreach ($this->session->userdata('current_playlist_videos') as $video)
			{
				$this->db->select('video_duration');
				$this->db->from('evolve_videos');
				$this->db->where('video_id', $video);
				$result = $this->db->get()->row_object();
				$total_duration += $result->video_duration;
			}
			return $total_duration;
		}else{
			return 0;
		}
	}
	
	//save details when user views a video
	function video_view_user_save($params=array())
	{		
		//echo '<pre>';
		//print_r($params);
		//echo '</pre>';
		$is_playlist = '';
		if ($params['view_type']=='video'){$is_playlist='N';}else{$is_playlist='Y';}
		
		$this->db->set('vid_id', $params['video_id']);
		$this->db->set('view_mode', $params['view_mode']);
		$this->db->set('viewer_id', $this->session->userdata('user_id'));
		$this->db->set('vid_sess_id', $params['vid_sess_id']);		
		$this->db->set('buddy_id', $params['friend_id']);
		$this->db->set('view_dt', 'NOW()', FALSE);
		$this->db->set('is_buddy_in', 'N');
		$this->db->set('is_playlist', $is_playlist);
		$this->db->insert('evolve_view_videos');
		//$this->db->query("INSERT INTO `evolve_view_videos` (`vid_id`, `view_mode`, `viewer_id`, `vid_sess_id`, `buddy_id`, `view_dt`, `is_buddy_in`) VALUES ('5', 'WF', '2', '1_MX4xNzM0ODYxMn4xOTIuMTY4LjAuNjF-VGh1IE9jdCAxMSAwNjo1OTowOCBQRFQgMjAxMn4wLjEyODA5MjUzfg', '4', NOW(), 'N')");
		
		return $this->db->insert_id();		
	}
	
	//update view video status, when video invite is sent
	function video_invite_buddy($params=array())
	{
		$this->db->set('buddy_id', $params['friend_id']);
		$this->db->where('view_id', $params['view_id']);
		$this->db->update('evolve_view_videos');
		$error = $this->db->_error_number();
		
		if ($error>0)
		{
			return 0;
		}else{
			return 1;
		}
	}
	
	//check the video inivitation
	function video_invite_check($params=array())
	{
		$this->db->select('*, evolve_user.screen_name, evolve_user.first_name, evolve_user.last_name');
		$this->db->from('evolve_view_videos');
		$this->db->where('buddy_id', $params['user_id']);
		$this->db->where('DATE_FORMAT(view_dt, "%Y-%m-%d") = ', date('Y-m-d'));
		$this->db->where('is_buddy_in', 'N');
		$this->db->where('buddy_discard_invite', 'N');
		$this->db->join('evolve_user', 'evolve_user.user_id=evolve_view_videos.viewer_id', 'LEFT');
		$result = $this->db->get()->result();
		return $result;
	}	
	
	//update buddy status, when buddy accepts the video invitation
	function video_update_buddy_status($params=array())
	{
		$this->db->set('is_buddy_in', 'Y');
		$this->db->where('view_id', $params['view_id']);
		$this->db->update('evolve_view_videos');
		return 1;
	}
	
	//update buddy status, when buddy rejects the video invitation
	function video_update_buddy_decline_invite($params=array())
	{
		$this->db->set('buddy_discard_invite', 'Y');
		$this->db->set('is_buddy_in', 'Y');
		$this->db->where('view_id', $params['view_id']);
		$this->db->update('evolve_view_videos');
		return 1;
	}
	
	//update the video view status, when the sender clicks on the video
	function update_view_status($params=array())
	{
		$this->db->set('sender_viewed', 'Y');
		//$this->db->set('video_play', 'N');
		$this->db->where('view_id', $params['view_id']);
		$this->db->update('evolve_view_videos');
		return 1;
	}
	
	//update sender view status
	function update_sender_play_status($params=array())
	{
		//$this->db->set('sender_viewed', 'Y');
		$this->db->set('video_play', 'Y');
		$this->db->where('view_id', $params['view_id']);
		$this->db->update('evolve_view_videos');
		return 1;
	}
	
	//update the video view status, when the sender clicks on the video
	function check_view_status($params=array())
	{
		$this->db->select('*');
		$this->db->where('sender_viewed', 'Y');
		$this->db->where('video_play', 'N');
		$this->db->where('view_id', $params['view_id']);
		$this->db->from('evolve_view_videos');
		$result = $this->db->get()->num_rows();
		if ($result>0)
		{
			return 1;
		}else{
			return 0;
		}
	}
	
	//send user notofication on user accept or decline invitation
	function sender_notification()
	{
		if ($this->session->userdata('user_id')!='')
		{
			$this->db->select('v.*, u.screen_name');
			$this->db->from('evolve_view_videos v');
			$this->db->where('viewer_id', $this->session->userdata('user_id'));
			$this->db->where('sender_notified', 'N');
			$this->db->where('DATE_FORMAT(view_dt, "%Y-%m-%d") = ', date('Y-m-d'));
			$this->db->where('view_mode', 'WF');
			$this->db->where_in('is_buddy_in', 'Y');
			$this->db->join('evolve_user u', 'u.user_id=v.buddy_id', 'left');
			$this->db->limit(1);
			$result = $this->db->get()->row_object();
			if ($result->view_id!='')
			{
				return $result;		
			}else{
				return 0;		
			}		
		}else{
			return 0;
		}
	}
	
	//update user notification 
	function update_sender_notification($params=array())
	{
		$this->db->set('sender_notified', 'Y');
		$this->db->where('view_id', $params['view_id']);
		$this->db->update('evolve_view_videos');
		return 1;
	}
	
	//get the view details
	function get_view_details($params=array())
	{		
		$this->db->select('*');
		$this->db->from('evolve_videos');
		$this->db->join('evolve_view_videos', 'evolve_view_videos.vid_id=evolve_videos.video_id');
		$this->db->where('video_id IN (SELECT vid_id FROM evolve_view_videos WHERE view_id="'.$params['view_id'].'")', NULL, FALSE);
		$result = $this->db->get()->row_object();
		return $result;
	}
	
	//function to get the view details
	function get_view_video($params=array())
	{
		$this->db->select('*');
		$this->db->from('evolve_view_videos');
		$this->db->where('view_id', $params['view_id']);
		return $this->db->get()->row_object();
	}
	
	//check for buddy status
	function video_check_buddy_status($params=array())
	{
		$this->db->select('*');
		$this->db->from('evolve_view_videos');
		$this->db->where('view_id', $params['view_id']);
		$result = $this->db->get()->row_object();
		if ($result->is_buddy_in=='N'){
			return 0;
		}elseif ($result->is_buddy_in=='Y' && $result->buddy_status=='0'){
			$this->db->set('buddy_status', '1');		
			$this->db->where('view_id', $params['view_id']);
			$this->db->update('evolve_view_videos');
			return 1;
		}elseif ($result->is_buddy_in=='Y' && $result->buddy_status=='1')
		{
			return 0;
		}
	}
	
	
 }

