<?php
/**
 * @property Loginmodel $lm
 */
class Logout extends CI_Controller{
    
    function __construct() {
        parent::__construct();
		$this->load->model('utilitymodel','util');
    }
    
    function index()
    {
		$this->load->model('Loginmodel','login');
		
		// Logout Activity
		$log_type_id=5;
		$this->util->update_log($log_type_id);	
		
		$this->login->close_login_log();
		
		$this->session->sess_destroy();
		redirect('home');
    }
	
	function force_logout()
    {
		$this->load->model('Loginmodel','login');
		
		$this->session->sess_destroy();
		redirect('home');
    }
    
}
