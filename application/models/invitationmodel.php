<?php
 class Invitationmodel extends CI_Model{
     
     function __construct() {
         parent::__construct();
     }
     
	function check_is_user($email_id)
	{
		$where="email_id = '$email_id'";
		$this->db->select('*');
		$this->db->from('evolve_user');
		$this->db->where($where);
		
		$query=$this->db->get();
		
		if($query->num_rows()>0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	function save_invitation($data)
	{
		$this->db->insert('evolve_invitation',$data);
		$inv_id=$this->db->insert_id();
		return $inv_id;
	}
	
	function find_invitation($inv_token)
	{
		$this->db->select('*');
		$this->db->from('evolve_invitation');
		$this->db->where('access_token',$inv_token);
		
		$query=$this->db->get();
		
		return $query->row();
	}
	
	function update_invitation_status($inv_token)
	{
		$this->db->set('is_accept',Y);
		$this->db->where('access_token',$inv_token);
		$this->db->update('evolve_invitation');
	}
	
	 
	
	 
	 
     
         
 }

