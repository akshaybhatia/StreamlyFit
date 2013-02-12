<?php
class Usermodel extends CI_Model
{
     
	function __construct()
	{
		parent::__construct();
		
		$this->load->database('default');
		$this->load->library('session');		
	}
	
	//method to update health waiver status of the user
	function update_health_waiver_status($params=array())
	{
		$this->db->set('health_waiver_form', 'Y');
		$this->db->where('user_id', $params['user_id']);
		$this->db->update('evolve_user');				
		return 1;		
	}
	
	function get_user_details($user_id)
	{
	 //echo $user_id;
		$this->db->select('*');
		$this->db->where('user_id',$user_id);
		$this->db->from('evolve_user');
		$result=$this->db->get()->row_object();
		return $result;
		
		
	
	}
	
	function update_auth_subscription($user_id="",$subscription_id="")
	{
	
		if($user_id<>"" && $subscription_id<>"" )
		{
				$this->db->set('auth_subscription_id',$subscription_id); // save subscription id
				$this->db->set('membership_type','T'); // set membership type to Trial
				$this->db->set('health_waiver_form','Y'); // set health_waiver_form to Y
				$this->db->where('user_id',$user_id);
				$this->db->update('evolve_user');	
				$this->session->unset_userdata('membership_type');
				$this->session->unset_userdata('health_waiver_form');
				$this->session->set_userdata('membership_type', "T");
				$this->session->set_userdata('health_waiver_form',"Y");
					
						
				return 1;	
		}
	
	
	}
}
 
?>