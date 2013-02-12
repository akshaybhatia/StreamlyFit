<?php
 class Loginmodel extends CI_Model{
     
     function __construct() {
		 $this->load->database('default');
		 $this->load->library('session');
         parent::__construct();
     }
     
	function find_user_type()
	{
	}
	
	function get_card_type()
	{
		$this->db->select('*');
		$this->db->from('evolve_card_type');
		$query=$this->db->get();
		
		return $query->result();
		 
	}
	 
	function check_duplicate_email($signup_type,$email_id)
	{
		$this->db->select('*');
		$this->db->from('evolve_user');
		$this->db->where('email_id', $email_id);
		$query=$this->db->get();
		
		if($query->num_rows()>0)
		{
			if($query->row()->signup_type==$signup_type)
				return 1;
			else
				return 2;
		}
		else
		{
			return 0;
		}
	}
	
	function change_password($email_id,$password)
	{
		$this->db->set('user_pwd',$password);
		$this->db->where('email_id',$email_id);
		$this->db->update('evolve_user');
		
	}
	
	function insert_users($data)
	{
		$this->db->insert('evolve_user',$data);
		$user_id=$this->db->insert_id();
		return $user_id;
	}
	
	function insert_users_card_details($data)
	{
		$this->db->insert('evolve_user_card_detail',$data);
		return $this->db->insert_id();
	}
	
	
	
	function active_user($user_id,$acccode)
	{
		$this->db->select('*');
		$this->db->from('evolve_user');
		$this->db->where('user_id',$user_id);
		$query=$this->db->get();
		
		if($query->row()->access_token==$acccode)
		{
			if($query->row()->is_verified=='Y')
			{
				return 2;
			}
			else
			{
				$data=array();
				$data['is_verified']="Y";
				
				$this->db->where('user_id',$user_id);
				$this->db->update('evolve_user',$data);
				
				return 1;
			}
		
		}
		else
		{
			return 0;
		}
	}
	
	 
	function oauth_login($signup_type,$email_id)
	{
		 $this->db->select('*');
         $this->db->from('evolve_user');
         $this->db->where("email_id",$email_id);
		 
         $result=$this->db->get();
         $result_arr=$result->row_array();
         
         if($result->num_rows()==0) 
         {
             return 0;
         }
         else
         {
			 $this->db->select('*');
             $this->db->from('evolve_user');
             $this->db->where("user_id",$result_arr['user_id']);
             $this->db->where("is_active",'Y');
         
             $r=$this->db->get();
             
            if($r->num_rows()==1)
            {
				$this->session->set_userdata('user_id',$result_arr['user_id']);
				$this->session->set_userdata('screen_name',$result_arr['screen_name']);
				$this->session->set_userdata('first_name',$result_arr['first_name']);
				$this->session->set_userdata('last_name',$result_arr['last_name']);
				$this->session->set_userdata('email_id',$result_arr['email_id']);
				$this->session->set_userdata('membership_type', $result->membership_type);
				$this->session->set_userdata('health_waiver_form', $result->health_waiver_form);
				
				$this->start_login_log();
				
				return 1;
             }
             else
             {
                 return 2;
             }
         }
	}
	
	
	 
    function check_login($email_id="",$user_pwd="")
    {
         
		$this->db->select('*');
		$this->db->from('evolve_user');
		$this->db->where("email_id",$email_id);
		$this->db->where("user_pwd",md5($user_pwd));
		
		//$this->db->where("user_pwd",md5($user_pwd));
		
		$query=$this->db->get();
		$result=$query->row();
		
			if($query->num_rows()==0)
			{
				return 0;
			}
			else
			{
				if($result->is_active=='Y')
				{
					
					
					$this->session->set_userdata('user_id',$result->user_id);
					$this->session->set_userdata('first_name',$result->first_name);
					$this->session->set_userdata('last_name',$result->last_name);
					$this->session->set_userdata('screen_name',$result->screen_name);
					$this->session->set_userdata('email_id',$result->email_id);
					$this->session->set_userdata('membership_type', $result->membership_type);
					$this->session->set_userdata('health_waiver_form', $result->health_waiver_form);
					
					$this->start_login_log();
					if($result->membership_type=="F")
					{
						return 4;
					}	
					else
					{
						return 1;
					}
				}
				else
				{
					return 2;
				}
			}
     }
	 
	 
	 function start_login_log()
	 {
	 	$now=time();
		
		$this->db->select('*');
		$this->db->from('evolve_log_login');
		$this->db->where("user_id", $this->session->userdata('user_id'));
		$this->db->where("is_login", 'Y');
		$this->db->order_by("login_log_id",'asc');
		
		$query=$this->db->get();
		
		$last_chat_status=1;
		
		if($query->num_rows()!=0)
		{
			$result=$query->row();
			foreach($result as $row)
			{
				
				$end_date=$row->end_date;
				$last_chat_status=$row->chat_status;
				
				if($now-$end_date >300)
				{
					$login_log_id=$row->login_log_id;
					$duration=$row->end_date-$row->start_date;
					
					
					$data = array(
				   'duration' => $duration,
				   'is_login' => 'N'
					);
		
					$this->db->where('login_log_id', $login_log_id); 
					$this->db->update('evolve_log_login', $data);				
				}
			}
		}
		else
		{
			$this->db->select('*');
			$this->db->from('evolve_log_login');
			$this->db->where("user_id",$user_id);
			$this->db->order_by("login_log_id",'desc');
			$this->db->limit(1);
			
			$query=$this->db->get();
			
			$last_chat_status=1;
			if($query->num_rows()!=0)
			{	
				$result=$query->row();
				$last_chat_status=$row->chat_status;
			}
			
		}
		
		$user_id=$this->session->userdata('user_id');
		$start_date=time();
		
		$visitor_id=$this->session->userdata('visitor_id');
		if(!$visitor_id)
			$visitor_id=0;
		else
			$this->session->unset_userdata('visitor_id');
		
		
		$last_chat_status=1;
			
	 	$data = array(
		   'user_id' => $user_id ,
		   'visitor_id' => $visitor_id ,
		   'start_date' => $start_date ,
		   'is_login'=>'Y', 
		   'chat_status'=>$last_chat_status, 
		   'ip_addr' => $_SERVER['REMOTE_ADDR']
		);

		$this->db->insert('evolve_log_login', $data);
		$login_log_id=$this->db->insert_id();
		$this->session->set_userdata('login_log_id',$login_log_id);
		
		
		
	 }
	 
	 function update_login_log()
	 {
	 	$user_id=$this->session->userdata('user_id');
		$login_log_id=$this->session->userdata('login_log_id');
		
	 	$this->db->select('*');
		$this->db->from('evolve_log_login');
		$this->db->where("user_id",$user_id);
		$this->db->where("is_login",Y);
		$this->db->where("login_log_id >",$login_log_id);
		
		$query=$this->db->get();
		
		if($query->num_rows()>=1)
		{
			 return 0;
		}
		else
		{
			
			
			$end_date=time();
			
			//$duration=$end_date-$start_date;
			
			$data = array(
			   'end_date' => $end_date
			);
	
			$this->db->where('login_log_id', $login_log_id); 
			$this->db->update('evolve_log_login', $data); 
			
			 return 1;
		}
	 }
	 
	  function close_login_log()
	 {
	 	
	 	$login_log_id=$this->session->userdata('login_log_id');
		
	 	$this->db->select('*');
		$this->db->from('evolve_log_login');
		$this->db->where("login_log_id",$login_log_id);
		
		$query=$this->db->get();
		$result=$query->row();
		
		$start_date=$result->start_date;
		$end_date=$result->end_date;
		
		$duration=$end_date-$start_date;
		
	 	$data = array(
		   'duration' => $duration,
		   'is_login' => 'N'
		);

		$this->db->where('login_log_id', $login_log_id); 
		$this->db->update('evolve_log_login', $data);
	 }
	 
	 
     
         
 }

