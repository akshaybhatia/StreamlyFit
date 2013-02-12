<!-- Body Area -->
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/video/flowplayer-3.2.11.min.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('base_url'); ?>assets/video/style.css" >

<!--Tokbox Main JS-->
<!--<script src="http://staging.tokbox.com/v0.91/js/TB.min.js" type="text/javascript" charset="utf-8"></script>-->
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/video/tokbox.js"></script>
<!--Load tokbox helper functions-->
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/video/tokbox_config.js" charset="utf-8" ></script>
<script type="text/javascript" charset="utf-8">
	
	tokbox_init('<?php echo $api_key; ?>', '<?php echo $vid_sess_id; ?>', '<?php echo $session_token; ?>', 413, 220);
	connect();
	function open_cam(frnd_id)
	{
		$("vid_frnd_id").value=frnd_id;
		$("vid_receiver_id").value=frnd_id;
		$("vid_"+frnd_id).update("Connecting...");
		connect();			
	}
	
	//update_buddy_status('<?php echo $this->config->item('base_url'); ?>', '<?php echo $view_id?>');
		
    
</script>
<script type="text/javascript">
	$(document).ready(function(){
		poll_buddy_status();
		setInterval('poll_buddy_status()', 2000);
		
		load_buddy_list('<?php echo $this->config->item('base_url'); ?>', '<?php echo $video_detail->video_id; ?>', '<?php echo $view_id; ?>');
	});
	
	//check buddy status to start video simultaneously
	function poll_buddy_status()
	{
		$.ajax({
			url: "<?php echo $this->config->item('base_url'); ?>video/check_buddy_status/<?php echo $view_id; ?>/",
			success: function(data){
				if (data==1)
				{
					change_vid_div('<?php echo $view_id; ?>');
				}
			}
		
		});
	}
	
	//start the video if buddy accepts the invitation
	function change_vid_div(view_id)
	{
		$.ajax({
			url: "<?php echo $this->config->item('base_url'); ?>video/refresh/"+view_id+"/",					
			success: function (data){
				$('#video_play').html(data);
			}
		});
	}
</script>

<div id="video_invites" style="width:100%; border:0px solid #666666;"></div>

<div class="friend_body_area">
	<div class="body_main_area">
    	<div class="big_video_area">
        	<div class="big_video" id="video_play">
            	<!--<img src="images/big_video.jpg" alt="" />-->
            
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
        <!--More Video Area-->
        <div class="more_video_area">
        	<div class="morevideo_morea_area">
            	<div id="links" style="width:400px;">
					<a id ="disconnectLink" href="javascript:void(0);" onClick="javascript:disconnect()" style="display:none">Close Session</a> &nbsp;
				</div>
            	<div class="friend_video" id="myCamera">
                	<!--<img src="<?php echo $this->config->item('base_url'); ?>assets/images/video_friend.jpg" alt="" />-->
                </div>
                <div class="friend_video" id="subscribers">
                	<!--<img src="<?php echo $this->config->item('base_url'); ?>assets/images/video_friend.jpg" alt="" />-->
                </div>
                <div class="clearfix"></div>
            </div>
            <!--Display Buddy List-->
           	<div class="morevideo_morea_area">
            	<h1 style="text-align:left; padding-bottom:25px;">Invite your Buddy to Join</h1>
                
                <div class="clearfix"></div>
            </div>
            <!--Display Buddy List-->
            
        </div>
        <!-- End More Video Area-->
		<div class="clearfix"></div>
        <!--Display Buddy List Who Are Online-->
        <div class="invite_friend_area" id="buddy_list">
                <?php
                	//print_r($friend_list);
					if (!empty($friend_list)){
						foreach($friend_list as $fl)
						{
							if ($fl['log_count']>0){
				?>
            	
                    <div class="online_user_area">
                        <div class="online_user_area_left"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/status_online.png" alt="" /></div>
                        <div class="online_user_area_right" style="text-align:left;"><a href="javascript:void(0);" title="Click to invite buddy for webcam chat" onclick="send_video_invitation('<?php echo $this->config->item('base_url'); ?>', '<?php echo $video_detail->video_id; ?>', '<?php echo $view_id; ?>', '<?php echo $fl['friend_id']; ?>')" ><?php echo $fl['friend_name']; ?></a></div>
                        <div class="clearfix"></div>
                    </div>                    
                <?php }}}else{?>
                <div class="online_user">
                	No buddies found.
                </div>
                <?php }?>
                </div>
		
    </div>
    <!-- Video Playlist Area-->
    <div class="videoplaylist_area">
    	<div class="videoplaylistmain_area bigvideo_top_space">
			<div class="left_arrow"><a href="#" id="prev"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/left_arrow.jpg" alt="" /></a></div>
			<div class="right_arrow"><a href="#" id="next"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/right_arrow.jpg" alt="" /></a></div>
			
            <div id="tabs_wrapper">
                <div id="tabs_container">
                    
                </div>
                <div id="tabs_content_container">
                    <div id="tab1" class="tab_content" style="display: block;">
                    	<div class="slides">
                        	<div class="list_carousel">
                        	<?php echo $video_list_page; ?>
                    <div class="clearfix"></div>
                    </div>
                        
                        </div>
                    </div>
                    <div id="tab2" class="tab_content">Yoga Tab</div>
                    <div id="tab3" class="tab_content">Breaks Tab</div>
                    <div id="tab4" class="tab_content">Add Playlist</div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Video Playlist Area-->
</div>
<div class="clearfix"></div>
<!-- End Body Area -->

<!--Play list Area-->
    <?php echo $playlist_page; ?>
<!--End Play List Area-->
