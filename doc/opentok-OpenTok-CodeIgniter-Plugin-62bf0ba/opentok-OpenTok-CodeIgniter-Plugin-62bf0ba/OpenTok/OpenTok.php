<?php
/*
* OpenTok PHP Library v0.90.0
* http://www.tokbox.com/
*
* Copyright 2010, TokBox, Inc.
*
* Date: November 05 14:50:00 2010
*
* CodeIgniter Plugin by Eli Luberoff
* November 10, 2010
*/


require_once dirname(__FILE__) . '/OpenTokSDK.php';


class OpenTok {

	protected $CI;
	protected $apiObj = null;
	public $sessionId;
	public $token;

	public $apiKey;
	protected $apiSecret;

	public function __construct($apiKey = null, $apiSecret = null)
	{
		$this->CI = &get_instance();
		$this->apiKey = ($apiKey ? $apiKey : API_Config::API_KEY);
		$this->apiSecret = ($apiSecret ? $apiSecret : API_Config::API_SECRET);
	
		if ($this->apiKey && $this->apiSecret) {
			$this->apiObj = new OpenTokSDK($this->apiKey, $this->apiSecret);
		}
	}

	public function set_session_id($sessionId) {
		$this->sessionId = $sessionId;
	}

	public function generate_session_id() {
		if (!$this->apiObj)
			return null;
			
        $session = $this->apiObj->create_session($_SERVER["REMOTE_ADDR"]);
        $this->sessionId = $session->getSessionId();
        return $this->sessionId;
    }
    
	public function generate_token($sessionId = '', $role = '') {
		if (!$this->apiObj)
			return null;
		$this->token = $this->apiObj->generate_token($sessionId, $role);
		return $this->token;
	}
}
