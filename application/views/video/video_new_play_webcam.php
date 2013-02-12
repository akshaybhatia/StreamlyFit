<!-- Body Area -->
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/video/flowplayer-3.2.11.min.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('base_url'); ?>assets/video/style.css" >

<!--Tokbox Main JS-->
<!--<script src="http://staging.tokbox.com/v0.91/js/TB.min.js" type="text/javascript" charset="utf-8"></script>-->
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/video/tokbox.js"></script>
<!--Load tokbox helper functions-->
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/video/tokbox_config.js" charset="utf-8" ></script>
<script type="text/javascript" charset="utf-8">
	
	tokbox_init('<?php echo $api_key; ?>', '<?php echo $vid_sess_id; ?>', '<?php echo $session_token; ?>', 404, 275);
	connect();
	function open_cam(frnd_id)
	{
		$("vid_frnd_id").value=frnd_id;
		$("vid_receiver_id").value=frnd_id;
		$("vid_"+frnd_id).update("Connecting...");
		connect();			
	}
    	  
</script>


<div class="body_landing_page_video_area">
	<div class="show_strip">
    	<div class="strip_bar"></div>
        <div class="drop_arrow" id="slide_control">&nbsp;</div>
    </div>
	<div class="body_main_area">
		<div class="big_landing_video_area">
        	<?php
				
            	/*echo '<pre>';
				print_r($view_type);
				echo '</pre>';
				
				echo '<pre>';
				print_r($video_list);
				echo '</pre>';
				
				echo '<pre>';
				print_r($video_detail);
				echo '</pre>';
				
				echo '<pre>';
				print_r($playlist_id);
				echo '</pre>';
				
				echo '<pre>';
				print_r($playlist_detail);
				echo '</pre>';*/
				
			?>  
        
			<div class="big_video_border">
            <!--<img src="<?php echo $this->config->item('base_url'); ?>assets/images/big_video.jpg" alt="" />-->
            <?php if ($view_type=='video'){ ?>
				<?php if ($this->session->userdata('user_id')==''){ ?>                      
                <a href="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_sample; ?>" style="display:block; width:683px; height:584px; " id="player">
                <img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_image; ?>" alt="<?php echo $video_detail->video_caption; ?>" height="584" width="683" />	
                </a>
                <?php }elseif ($this->session->userdata('user_id')!='' && $this->session->userdata('membership_type')=='F'){?>            
                <a href="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_sample; ?>" style="display:block; width:683px; height:584px; " id="player">
                <img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_image; ?>" alt="<?php echo $video_detail->video_caption; ?>" height="584" width="683" />	
                </a>
                <?php }else{?>            
                <a href="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_url; ?>" style="display:block; width:683px; height:584px; " id="player">
                <img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_image; ?>" alt="<?php echo $video_detail->video_caption; ?>" height="584" width="683" />	
                </a>     
                <?php }?>
                
                <script>
                flowplayer("player", "<?php echo $this->config->item('base_url'); ?>assets/video/flowplayer-3.2.15.swf", {				
                        clip:{
                            autoPlay: true,
                            autoBuffering: true
                        }
                });
                </script>
			<?php }elseif ($view_type=='playlist'){ ?>            
            	<?php if ($this->session->userdata('user_id')==''){ ?>                      
                <a href="javascript:void(0);" style="display:block; width:683px; height:584px; " id="player">
                <img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $playlist_detail->video_image; ?>" alt="<?php echo $playlist_detail->playlist_title; ?>" height="584" width="683" />	
                </a>
                <?php }elseif ($this->session->userdata('user_id')!='' && $this->session->userdata('membership_type')=='F'){?>            
                <a href="javascript:void(0);" style="display:block; width:683px; height:584px; " id="player">
                <img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $playlist_detail->video_image; ?>" alt="<?php echo $playlist_detail->playlist_title; ?>" height="584" width="683" />	
                </a>
                <?php }else{?>            
                <a href="javascript:void(0);" style="display:block; width:683px; height:584px; " id="player">
                <img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $playlist_detail->video_image; ?>" alt="<?php echo $playlist_detail->playlist_title; ?>" height="584" width="683" />	
                </a>     
                <?php }?>
                
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
            </div>
		</div>
		<div class="small_landing_video_area">
			<div class="small_video_area1 small_video_space" id="myCamera"></div>
			<!--<div class="small_video_area1"></div>-->
		</div>
		<div class="clearfix"></div>
	</div>
    <div id="links" style="width:316px; height:50px;">
				<a id ="disconnectLink" href="javascript:void(0);" onClick="javascript:disconnect()" style="display:none"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/close_session.png"  /></a>
			</div>
</div>
<div class="clearfix"></div>
<!-- End Body Area -->