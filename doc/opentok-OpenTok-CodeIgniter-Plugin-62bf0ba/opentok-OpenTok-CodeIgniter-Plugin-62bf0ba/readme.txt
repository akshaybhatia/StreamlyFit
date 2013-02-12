OpenTok (0.91) plugin for CodeIgniter
By Eli Luberoff, November 11, 2010
Update by Melih Onvural, November 30, 2011

Step 1: Copy the entire OpenTok directory into "libraries" in your CodeIgniter installation
Step 2: Fill in API_Config.php with your API_KEY and API_SECRET (optional-- you can also fill these in when instantiating)



Sample Controller Code:


	function openTok($sessionId = null) {
		$this->load->library("OpenTok/OpenTok");
		
		//arguments not necessary if you've set the API key in API_config.php in API_Config.php
		$OT = new OpenTok($your_api_key, $your_api_secret);

		if ($sessionId) {
			$OT->set_session_id($sessionId);
		} else {
			$OT->generate_session_id();
		}
		
		$OT->generate_token();
		
		echo "Api Key: " . $OT->apiKey;
		echo "<br>Session Id: " . $OT->sessionId;
		echo "<br>token: " . $OT->token;
	}



