<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{
	var $data = array();
	
    function __construct()
    {
		parent::__construct();
		//$this->load->helper('checklogin');
		//check_login();
		$this->load->model('utilitymodel','util');
		
		$this->load->library('fra_lib');
    }
	
    function index($uri_seg = '')
    {	
		// Visit Home page
		$log_type_id=30;
		$this->util->update_log($log_type_id);
		//echo "aaa".$this->session->userdata('membership_type');
		//die();
		
		//home controller
		$this->data['site_title']		= '.:Streamly Fit:.';		
		$this->data['uri_seg']			= $uri_seg;
		
		//load video model
		$this->load->model('videomodel', 'vid');
		$this->data['video_category']	= 1;
		//$this->data['video_list']		= $this->vid->video_list();
		$this->data['video_list']		= $this->vid->video_list_for_categories($this->data);
		$this->data['cur_play']			= $this->get_all_video_from_current_playlist();
		
		//print_r($this->data['cur_play']);
		//die();
		
		$this->load->view('header', $this->data);
		$this->data['video_list_page']	= $this->load->view('video/video_list', $this->data, true);
		$this->data['playlist_page']	= $this->load->view('video/video_playlist', $this->data, true);
		$this->load->view('content', $this->data);
		$this->load->view('footer', $this->data);
	}
	
	//get all different category videos
	function category($cat_id, $cat_name)
	{
		// Visit Home page
		$log_type_id=30;
		$this->util->update_log($log_type_id);
		//echo "aaa".$this->session->userdata('membership_type');
		//die();
		
		//home controller
		$this->data['site_title']		= '.:Streamly Fit:.';		
		$this->data['uri_seg']			= $cat_name;
		
		//load video model
		$this->load->model('videomodel', 'vid');
		$this->data['video_category']	= $cat_id;
		//$this->data['video_list']		= $this->vid->video_list();
		$this->data['video_list']		= $this->vid->video_list_for_categories($this->data);
		
		$this->data['cur_play']			= $this->get_all_video_from_current_playlist();
		
		//print_r($this->data['cur_play']);
		//die();
		
		$this->load->view('header', $this->data);
		
		if ($cat_name=='yoga'){
			$this->data['video_list_page_yoga']		= $this->load->view('video/video_list', $this->data, true);
		}elseif ($cat_name=='breaks'){
			$this->data['video_list_page_breaks']	= $this->load->view('video/video_list', $this->data, true);
		}else{
			$this->data['video_list_page']			= $this->load->view('video/video_list', $this->data, true);
		}
		
		
		$this->data['playlist_page']	= $this->load->view('video/video_playlist', $this->data, true);
		$this->load->view('content', $this->data);
		$this->load->view('footer', $this->data);
	}
	
	//return all the video details from the playlist
	function get_all_video_from_current_playlist($call='local')
	{
		//$video_ids				= $this->session->userdata('current_playlist_videos');
		
		//load video playlist model
		$this->load->model('videoplaylistmodel', 'vidpl');
		
		//get all the videos from the playlist
		if ($this->session->userdata('current_playlist_type')=='playlist'){
			$this->data['playlist_id']	= $this->session->userdata('current_playlist_id');
			$video_ids					= $this->vidpl->get_all_videos_from_playlist($this->data);
			$this->session->set_userdata('current_playlist_type', 'playlist');			
		}else{
			$video_ids					= $this->vidpl->get_current_playlist_video();
			$this->session->set_userdata('current_playlist_type', 'current');						
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