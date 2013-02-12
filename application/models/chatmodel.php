<?php
 class Chatmodel extends CI_Model{
     
     function __construct() {
         parent::__construct();
     }
     
	function get_friend_list()
	{
		$user_id=$this->session->userdata('user_id');
		$where="friend_status = 'A' AND (from_user_id = '$user_id' OR to_user_id = '$user_id')";
		
		$this->db->select('*');
		$this->db->from('evolve_friend_list');
		$this->db->where($where);
		//echo $this->db->show_query();
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}   
	
	function count_new_friend_request()
	{
		$user_id=$this->session->userdata('user_id');
		
		$this->db->select('count(*) as to_request');
		$this->db->from('evolve_friend_list');
		$this->db->where('friend_status',R);
		$this->db->where('to_user_id',$user_id);
		
		
		$query=$this->db->get();
		return $query->row()->to_request;
	} 
	
	
	function get_friend_request()
	{
		$user_id=$this->session->userdata('user_id');
		
		$this->db->select('*,(SELECT screen_name FROM evolve_user WHERE evolve_user.user_id=evolve_friend_list.from_user_id) as from_name');
		$this->db->from('evolve_friend_list');
		$this->db->where('friend_status',R);
		$this->db->where('to_user_id',$user_id);
		
		
		$query=$this->db->get();
		return $query->result();
	} 
	
	function get_friend_details($friend_id) 
	{
		$this->db->select('screen_name,(SELECT count(login_log_id) FROM evolve_log_login WHERE evolve_log_login.user_id=evolve_user.user_id AND is_login=\'Y\') as log_count');
		$this->db->from('evolve_user');
		$this->db->where('user_id',$friend_id);
		
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $query->row();
	}
	
	function get_chat_status($friend_id=0)
	{
		if($friend_id!=0)
		{
			$this->db->select('chat_status');
			$this->db->from('evolve_log_login');
			$this->db->where('user_id',$friend_id);
			$this->db->where('is_login',Y);
			$this->db->order_by('login_log_id','DESC');
			
			$query=$this->db->get();
			//echo $this->db->last_query();
			
			if($query->num_rows()==0)
				return 4;	
			else
				return $query->row()->chat_status;
		}
		else
		{
			$login_log_id=$this->session->userdata('login_log_id');
			
			
			$this->db->select('chat_status');
			$this->db->from('evolve_log_login');
			$this->db->where('login_log_id',$login_log_id);
			
			$query=$this->db->get();
			
			
			
			if($query->num_rows()==0)
			{
				return 4;	
			}
			else
			{	return $query->row()->chat_status;
			}
		}
	}
	
	function update_my_chat_status($chat_status)
	{
		$login_log_id=$this->session->userdata('login_log_id');
		
		
		$this->db->set('chat_status',$chat_status);
		$this->db->where('login_log_id',$login_log_id);
		$this->db->update('evolve_log_login');
	}
	
	function save_chatlist($data)
	{
	 //print_r($data);
		$this->db->insert('evlove_chat_list',$data);
	}
	
	function get_final_chatlist()
	{
		$user_id=$this->session->userdata('user_id');
		
		$this->db->select('*');
		$this->db->from('evlove_chat_list');
		$this->db->where('user_id',$user_id);
		$this->db->order_by('chat_status');
		$this->db->order_by('friend_name');
		
		
		$query=$this->db->get();
		
		$this->db->where('user_id',$user_id);
		$this->db->delete('evlove_chat_list');
		
		
		return $query->result();
	}
	
	function save_chatdata($data)
	{
		$this->db->insert('evolve_chat',$data);
		
		return $this->db->insert_id();
	}
	
	function allow_friend_request($friend_list_id)
	{
		$this->db->set('friend_status','A');
		$this->db->where('friend_list_id',$friend_list_id);
		$this->db->update('evolve_friend_list');
	}
	
	function decline_friend_request($friend_list_id)
	{
		$this->db->where('friend_list_id',$friend_list_id);
		$this->db->delete('evolve_friend_list');
	}
	
	function search_friend($friend_name)
	{
		$user_id=$this->session->userdata('user_id');
		$where="user_id <> $user_id AND (screen_name like '$friend_name%' OR first_name like '$friend_name%' OR last_name like '$friend_name%')";
		$this->db->select('*');
		$this->db->from('evolve_user');
		$this->db->where($where);
		
		
		$query=$this->db->get();
		return $query->result();
		
	}
	
	function get_friendsihp_status($friend_id)
	{
		$user_id=$this->session->userdata('user_id');
		
		$sql=$this->db->query("SELECT friend_status FROM evolve_friend_list WHERE (from_user_id=".$user_id." AND to_user_id=".$friend_id.") OR (from_user_id=".$friend_id." AND to_user_id=".$user_id.")");
		if($sql->num_rows()==0)
		{
			return 'N';
		}
		else
		{
			$row=$sql->row_array();
			return $row['friend_status'];
		}
	}
	
	
	
	function send_friend_request($data)
	{
		
		
		$this->db->insert('evolve_friend_list',$data);
		return $this->db->insert_id();
	}
	
	function get_chat_histry($user_id)
	{
		$this->db->select('*,(SELECT screen_name FROM evolve_user WHERE evolve_user.user_id=evolve_chat.from_id) as from_name');
		$this->db->from('evolve_chat');
		$this->db->where('to_id',$user_id);
		$this->db->where('recd',N);
		
		$query=$this->db->get();
		return $query->result();
	}
	
	function update_message_state($id)
	{
		$this->db->set('recd','Y');
		$this->db->where('id',$id);
		$this->db->update('evolve_chat');
		
		
	}
         
 }

