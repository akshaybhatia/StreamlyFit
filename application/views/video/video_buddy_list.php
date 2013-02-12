<?php
	//print_r($friend_list);
	$cnt=0;
	if (!empty($friend_list)){
		foreach($friend_list as $fl)
		{
			if ($fl['log_count']>0){
				$cnt++;
?>
	<div class="online_user_area">
		<div class="online_user_area_left"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/status_online.png" alt="" /></div>
		<div class="online_user_area_right" style="text-align:left;"><a href="javascript:void(0);" title="Click to invite buddy for webcam chat" onclick="send_video_invitation('<?php echo $this->config->item('base_url'); ?>', '<?php echo $video_id; ?>', '<?php echo $view_id; ?>', '<?php echo $fl['friend_id']; ?>')" ><?php echo $fl['friend_name']; ?></a></div>
		<div class="clearfix"></div>
	</div>                    
<?php 	
			}				
		}
		if ($cnt<=0){echo 'None of your buddies are online';}
}else{?>
<div class="online_user">
	No buddies found.
</div>
<?php }?>