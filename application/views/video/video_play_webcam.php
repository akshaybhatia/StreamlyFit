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
    	  
</script>

<div id="video_invites" style="width:100%; border:0px solid #666666;"></div>

<div class="mirror_body_area">
	<div class="body_main_area">
    	<div class="big_video_area">
        	<div class="big_video">
            	<!--<img src="<?php echo $this->config->item('base_url'); ?>assets/images/big_video.jpg" alt="" />-->
                <?php if ($this->session->userdata('user_id')==''){ ?>                      
            <a href="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_sample; ?>" style="display:block; width:591px; height:333px; " id="player">
			<img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_image; ?>" alt="<?php echo $video_detail->video_caption; ?>" height="333" width="591" />	
			</a>
            <?php }elseif ($this->session->userdata('user_id')!='' && $this->session->userdata('membership_type')=='F'){?>            
            <a href="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_sample; ?>" style="display:block; width:591px; height:333px; " id="player">
			<img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_image; ?>" alt="<?php echo $video_detail->video_caption; ?>" height="333" width="591" />	
			</a>
            <?php }else{?>            
       		<a href="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_url; ?>" style="display:block; width:591px; height:333px; " id="player">
			<img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_detail->video_image; ?>" alt="<?php echo $video_detail->video_caption; ?>" height="333" width="591" />	
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
            </div>
        </div>
        <!--More Video Area-->
        <div class="more_video_area">
        	<div id="links" style="width:400px;">
					<a id ="disconnectLink" href="javascript:void(0);" onClick="javascript:disconnect()" style="display:none">Close Session</a> &nbsp;
			</div>
        	<div class="morevideo_morea_area">
            	<div class="friend_video" id="myCamera">
                	<!--<img src="<?php echo $this->config->item('base_url'); ?>assets/images/video_friend.jpg" alt="" />-->
                </div>
                <!--<div class="friend_video" id="subscribers"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/video_friend.jpg" alt="" /></div>-->
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- End More Video Area-->
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