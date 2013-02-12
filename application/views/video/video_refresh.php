<!-- Script to install flowplayer -->
			
	<!--<a href="<?php echo $this->config->item('base_url'); ?>assets/video/Seven_Min_Workout_For_Beginners.flv" style="display:block; width:520px; height:330px" id="player"></a>-->	
    <?php if ($view_type=='video'){ ?>
    <a href="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_url; ?>" style="display:block; width:683px; height:584px" id="player"></a>
	<script>
		flowplayer("player", "<?php echo $this->config->item('base_url'); ?>assets/video/flowplayer-3.2.15.swf", {					
			clip:{
				autoPlay: true,
				autoBuffering: true
			}
		});
	</script>
    <?php }elseif ($view_type=='playlist'){ ?>
    <a href="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $playlist_detail->video_url; ?>" style="display:block; width:683px; height:584px" id="player"></a>
	<script>
		flowplayer("player", "<?php echo $this->config->item('base_url'); ?>assets/video/flowplayer-3.2.15.swf", {				
				clip:{
					autoPlay: true,
					autoBuffering: true
				},
				// playlist with five entries
				playlist:[
					<?php
						foreach($video_detail as $vl){
					?>
					{url: '<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php if ($this->session->userdata('membership_type')!='F'){echo $vl->video_url;}else{echo $vl->video_sample; }?>'}, 
					<?php }?>
					/*{url: '<?php echo $this->config->item('base_url'); ?>assets/uploads/video/Kid_Fitness_Video_The_WorkOut_Kid.flv'}, 
					{url: '<?php echo $this->config->item('base_url'); ?>assets/uploads/video/Shoulders_Chest_Routine_Workout.flv'}*/
				]
				
		});
	</script>
    <?php } ?>