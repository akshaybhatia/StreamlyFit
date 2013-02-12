<?php
 class Utilitymodel extends CI_Model{
     
     function __construct() {
         parent::__construct();
		 
     }
     
     function get_settings()
     {
      	$this->db->select('*');
		$this->db->from('evolve_setting');
		$this->db->where("setting_id",1);
		$query=$this->db->get();
		
		return $query->row();
     }
	 
	 function update_log($log_type_id,$sub_row_id=0)
     {
	 	
	 	$user_id=$this->session->userdata('user_id');
		$login_log_id=$this->session->userdata('login_log_id');
		
		if($user_id)
		{
			$this->db->select('*');
			$this->db->from('evolve_log_login');
			$this->db->where("login_log_id",$login_log_id);
			$query=$this->db->get();
			
			if($query->row()->is_login=='Y')
			{
				$data=array(
					'user_id'=>$user_id,
					'login_log_id'=>$login_log_id,
					'log_type_id'=>$log_type_id,
					'sub_row_id'=>$sub_row_id,
					'log_date'=>time(),
					'ip_addr' => $_SERVER['REMOTE_ADDR']
				);
				
				$this->db->insert('evolve_log',$data);
			}
			else
			{
				redirect('logout/force_logout');
			}
		}
		else
		{
			$visitor_id=$this->session->userdata('visitor_id');
			if(!$visitor_id)
			{
				
				$visitor_id=md5(time());
				$this->session->set_userdata('visitor_id',$visitor_id);
			}
			
			$data=array(
				'user_id'=>0,
				'visitor_id'=>$visitor_id,
				'login_log_id'=>$login_log_id,
				'log_type_id'=>$log_type_id,
				'sub_row_id'=>$sub_row_id,
				'log_date'=>time(),
				'ip_addr' => $_SERVER['REMOTE_ADDR']
			);
			
			$this->db->insert('evolve_log',$data);
			
		}
     }
	 
	 
	 
	
 }

