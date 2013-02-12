<?php	
	if (count($result)>0){
		foreach($result as $res){
?>
		<div id="video_invite_<?php echo $res->view_id; ?>" style="clear:both; padding-bottom:5px; margin-left:15px;">
        	Invitation To Workout From <?php echo $res->screen_name; ?> &nbsp;
            
			<a href="javascript:void(0);" onclick="accept_video_request('<?php echo $this->config->item('base_url'); ?>', '<?php echo $res->view_id; ?>'); " style="text-decoration:none; color:#037EA0; font-weight:bold;" ><img src="<?php echo $this->config->item('base_url'); ?>assets/images/popup_accept_btn.png" align="top" /> </a> &nbsp;
            
            <a href="javascript:void(0);" onclick="decline_video_request('<?php echo $this->config->item('base_url'); ?>', '<?php echo $res->view_id; ?>'); " style="text-decoration:none; color:#C45C11; font-weight:bold;" ><img src="<?php echo $this->config->item('base_url'); ?>assets/images/popup_decline_btn.png" align="top" /></a>
            
		</div>
<?php 
		}
	}
?>

