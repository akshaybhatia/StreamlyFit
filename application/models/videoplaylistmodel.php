<?php

//model for the video playlist section
class Videoplaylistmodel extends CI_Model
{
	var $playlist_id = '';
	var $playlist_title = '';
	var $user_id = '';
	var $playlist_cr_dt = '';
	var $playlist_status = '';	
	
    function __construct()
	{
    	parent::__construct();
		$this->load->database('default');
		$this->load->library('session');
		
		$this->table_play	= 'evolve_video_playlist';
		$this->table_vids	= 'evolve_video_playlist_videos';
    }
    
	//to get palylist for a user
	function playlist_list_user($params=array())
	{
		$this->db->select('*, (SELECT count(video_id) FROM `evolve_video_playlist_videos` WHERE playlist_id=pl.playlist_id) as total_vids, (SELECT video_image FROM `evolve_videos` v, `evolve_video_playlist_videos` plv WHERE v.video_id=plv.video_id AND plv.playlist_id=pl.playlist_id LIMIT 1) as video_image');
		$this->db->from($this->table_play.' as pl');
		$this->db->where('user_id', $params['user_id']);
		$this->db->order_by('playlist_cr_dt', 'DESC');		
		$result = $this->db->get()->result();
		return $result;
	}
	
	//to get palylist details
	function playlist_details($params=array())
	{
		$this->db->select('*, (SELECT count(video_id) FROM `evolve_video_playlist_videos` WHERE playlist_id=pl.playlist_id) as total_vids, (SELECT video_image FROM `evolve_videos` v, `evolve_video_playlist_videos` plv WHERE v.video_id=plv.video_id AND plv.playlist_id=pl.playlist_id LIMIT 1) as video_image');
		$this->db->from($this->table_play.' as pl');
		$this->db->where('playlist_id', $params['playlist_id']);
		$this->db->order_by('playlist_cr_dt', 'DESC');		
		$result = $this->db->get()->row_object();
		return $result;
	}
	
	//to get palylist video id for a user
	function playlist_list_videos($params=array())
	{
		$this->db->select('video_id');
		$this->db->from($this->table_vids);
		$this->db->where('playlist_id', $params['playlist_id']);
		//$this->db->order_by('playlist_cr_dt', 'DESC');
		$result = $this->db->get()->result();
		$data = array();
		foreach($result as $res)
		{
			$data[] = $res->video_id;
		}
		
		return $data;
	}
	
	//get all the video ids & their sort orders
	function get_all_videos_from_playlist($params=array())
	{
		if ($params['playlist_id']!=''){
			$this->db->select('*');
			$this->db->from($this->table_vids);
			$this->db->where('playlist_id', $params['playlist_id']);
			$result = $this->db->get()->result();
			$data = array();
			foreach($result as $rs)
			{
				$data[$rs->sort_order] = $rs->video_id;
			}
		}else{
			$data = array();	
		}
		return $data;
	}
	
	//to get all the videos in a playlist
	function playlist_list_video($params=array())
	{
		$this->db->select('plv.*, v.video_caption, v.video_image, v.video_url, v.video_sample');
		$this->db->from($this->table_vids.' plv');
		$this->db->where('plv.playlist_id', $params['playlist_id']);
		$this->db->join('evolve_videos v', 'v.video_id='.'plv.video_id AND v.video_status="A"', 'LEFT');
		$result = $this->db->get()->result();
		return $result;
	}
	
	//load videos from the current playlist
	function playlist_list_current_videos($params=array())
	{
		$video_ids = implode(',', $params);
		$sql_query = 'SELECT * FROM evolve_videos WHERE video_id IN ('.$video_ids.')';
		/*$this->db->select('*');
		$this->db->from('evolve_videos');
		$this->db->where_in('video_id1', $video_ids);*/
		$query = $this->db->query($sql_query);
		$result = $query->result();
		return $result;		
	}
	
	//add video in a playlist
	function playlist_add_video($params=array())
	{
		$this->db->set('playlist_id', $params['playlist_id']);
		$this->db->set('video_id', $params['video_id']);
		$this->db->set('sort_order', $params['sort_order']);
		$this->db->set('date_added', 'NOW()', FALSE);
		$this->db->set('playlist_video_status', 'Y');
		$this->db->insert($this->table_vids);
		return 1;
	}
	
	//set playlist to current
	function set_playlist_current($params=array())
	{
		$this->db->set('playlist_type', '0');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->update($this->table_play);
				
		$this->db->set('playlist_type', '1');
		$this->db->where('playlist_id', $params['playlist_id']);
		$this->db->update($this->table_play);
		return 1;
	}
	
	//get current playlist
	function get_current_playlist()
	{
		$this->db->select('playlist_id');
		$this->db->from($this->table_play);
		$this->db->where('playlist_type', '1');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$result = $this->db->get()->row_object();
		
		if ($result->playlist_id!='')
		{
			return $result->playlist_id;
		}else{
			return 0;
		}		
	}
	
	//remove video from playlist
	function playlist_remove_video($params=array())
	{
		$this->db->where('playlist_id', $params['playlist_id']);
		$this->db->where('video_id', $params['video_id']);
		$this->db->where('sort_order', $params['sort_order']);
		$this->db->delete($this->table_vids);
		return 1;
	}
	
	//function to add current playlist in the table
	function video_add_current_playlist($params=array())
	{
		if ($this->session->userdata('current_playlist_type')=='current' && $this->session->userdata('current_playlist_id')!='')
		{
			$this->db->set('user_id', $this->session->userdata('user_id'));
			$this->db->set('video_id', serialize($params['video_ids']));
			$this->db->set('sort_order', 0);
			$this->db->set('parent_id', 0);
			$this->db->set('last_updated', 'NOW()', FALSE);
			$this->db->where('current_playlist_id', $this->session->userdata('current_playlist_id'));
			$this->db->update('evolve_current_playlist');
			return $this->session->userdata('current_playlist_id');
		}else{		
			$this->db->set('user_id', $this->session->userdata('user_id'));
			$this->db->set('video_id', serialize($params['video_ids']));
			$this->db->set('sort_order', 0);
			$this->db->set('parent_id', 0);
			$this->db->set('last_updated', 'NOW()', FALSE);
			$this->db->insert('evolve_current_playlist');
			return $this->db->insert_id();
		}
	}
	
	//get all the vidoes from the current playlist
	function get_current_playlist_video()
	{
		$this->db->select('*');
		$this->db->from('evolve_current_playlist');
		$this->db->where('current_playlist_id', $this->session->userdata('current_playlist_id'));
		$result = $this->db->get()->row_object();
		return unserialize($result->video_id);
	}
	
	//check to see if a playlist exist or not
	function check_playlist_name_exist($params=array())
	{
		$this->db->select('*');
		$this->db->from('evolve_video_playlist');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->where('playlist_title', $params['playlist_title']);
		$result = $this->db->get()->num_rows();
		return $result;
	}
	
	//save the playlist form
	function save_new_playlist_form($params=array())
	{
		$this->db->set('playlist_title', $params['playlist_title']);
		$this->db->set('user_id', $this->session->userdata('user_id'));
		$this->db->set('playlist_cr_dt', 'NOW()', FALSE);
		$this->db->set('playlist_type', '0');
		$this->db->set('playlist_status', '1');
		$this->db->insert('evolve_video_playlist');
		return $this->db->insert_id();
	}
	
	//rename the playlist title
	function rename_playlist_title($params=array())
	{
		$this->db->set('playlist_title', $params['playlist_title']);
		$this->db->where('playlist_id', $params['playlist_id']);
		$this->db->update('evolve_video_playlist');
		return 1;
	}
	
	//delete the playlist
	function remove_playlist($params=array())
	{
		//delete the playlist
		$this->db->where('playlist_id', $params['playlist_id']);
		$this->db->delete('evolve_video_playlist');
		
		//remove all videos in the playlist
		$this->db->where('playlist_id', $params['playlist_id']);
		$this->db->delete('evolve_video_playlist_videos');
		
		return 1;
	}
 }