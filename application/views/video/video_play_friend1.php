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

<div class="friend_body_area">
	<div class="body_main_area">
    	<div class="big_video_area">
        	<div class="big_video">
            	<!--<img src="images/big_video.jpg" alt="" />-->
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
            	<h1>Invite your Buddy to Join</h1>
                <?php
                	//print_r($friend_list);
					if (!empty($friend_list)){
						foreach($friend_list as $fl)
						{
							if ($fl['log_count']>0){
				?>
            	<!--<div class="online_user">
                	<div>
                    	<img src="<?php echo $this->config->item('base_url'); ?>assets/images/online_user.png" />
                    </div>
                    <div class="online_user_name">                    	
                    	<a title="Click to invite buddy for webcam chat" onclick="send_video_invitation('<?php echo $this->config->item('base_url'); ?>', '<?php echo $video_id; ?>', '<?php echo $view_id; ?>', '<?php echo $fl['friend_id']; ?>')" href="javascript:void(0);"><?php echo $fl['friend_name']; ?></a>
                    </div>
                </div>-->
				
                <?php }}}else{?>
                <div class="online_user">
                	No buddies found.
                </div>
                <?php }?>
                <div class="clearfix"></div>
            </div>
			
			
            <!--Display Buddy List-->
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
                        	<ul id="dance">
                          <?php
                            	if (!empty($video_list)){
									foreach($video_list as $vl){
							?>
                        	
                            <li class="space_right">
                                <div class="small_video_area">
                                
                                
                                
                                <!--Click on the link to display the video health waiver form-->
                                <a <?php if ($this->session->userdata('user_id')!='' && $this->session->userdata('membership_type')!='F'){?>href="javascript:void(0);" onclick="open_waiver_form('<?php echo $this->config->item('base_url'); ?>', '<?php echo $vl->video_id; ?>');" <?php }else{?>href="<?php echo $this->config->item('base_url'); ?>video/play_sample/<?php echo $vl->video_id; ?>" <?php } ?> >
                                <img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $vl->video_image; ?>" alt="<?php echo $vl->video_caption; ?>" width="184" height="121" /></a>
                                <!--Click on the link to display the video health waiver form-->
                                
                                </div>
                                <div class="video_content">
                                	<div class="yoga_starter"><a <?php if ($this->session->userdata('user_id')!='' && $this->session->userdata('membership_type')!='F'){?>href="javascript:void(0);" onclick="open_waiver_form('<?php echo $this->config->item('base_url'); ?>', '<?php echo $vl->video_id; ?>');" <?php }else{?>href="<?php echo $this->config->item('base_url'); ?>video/play_sample/<?php echo $vl->video_id; ?>" <?php } ?> ><?php echo $vl->video_caption; ?></a></div>
                                    <div class="rating_area">
                                    	<div class="overall_area_new overall_space">
                                        	<div class="overall_area_left_col">Overall</div>
                                            <div class="overall_area_right_col">
                                            	<?php
													$video_overall_rating = '';
                                                	switch($vl->video_overall_rating){
														case 5:
															$video_overall_rating = '5star.png';
															break;
														case 4:
															$video_overall_rating = '4star.png';
															break;
														case 3:
															$video_overall_rating = '3star.png';
															break;
														case 2:
															$video_overall_rating = '2star.png';
															break;
														case 1:
															$video_overall_rating = '1star.png';
															break;
														default:
															$video_overall_rating = 'blank-star.png';
															break;
													}
												?>
                                            
                                                <div class="star_icon">                                                
                                                <img src="<?php echo $this->config->item('base_url'); ?>assets/star/<?php echo $video_overall_rating; ?>" alt="" /></div>
                                                
                                                <div class="clearfix"></div> 	
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="overall_area_new overall_space">
                                        	<div class="overall_area_left_col">Complexity</div>
                                            <div class="overall_area_right_col">
                                            	<?php
													$video_complexity_rating = '';
                                                	switch($vl->video_complexity_rating){
														case 5:
															$video_complexity_rating = '5gear.png';
															break;
														case 4:
															$video_complexity_rating = '4gear.png';
															break;
														case 3:
															$video_complexity_rating = '3gear.png';
															break;
														case 2:
															$video_complexity_rating = '2gear.png';
															break;
														case 1:
															$video_complexity_rating = '1gear.png';
															break;
														default:
															$video_complexity_rating = 'blank-gear.png';
															break;
													}
												?>
                                            
                                                <div class="complexity_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/gear/<?php echo $video_complexity_rating; ?>" alt="" /></div>                                                
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="overall_area_new overall_space">
                                        	<div class="overall_area_left_col">Intensity</div>
                                            <div class="overall_area_right_col">
                                            	<?php
													$video_intensity_rating = '';
                                                	switch($vl->video_intensity_rating){
														case 5:
															$video_intensity_rating = '5intensity.png';
															break;
														case 4:
															$video_intensity_rating = '4intensity.png';
															break;
														case 3:
															$video_intensity_rating = '3intensity.png';
															break;
														case 2:
															$video_intensity_rating = '2intensity.png';
															break;
														case 1:
															$video_intensity_rating = '1intensity.png';
															break;
														default:
															$video_intensity_rating = 'blank-intensity.png';
															break;
													}
												?>
                                                <div class="intencity_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/intensity/<?php echo $video_intensity_rating; ?>" alt="" /></div>
                                              
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            <?php }}else{?>
                            No videos found
                            <?php }?>
                           
                        </ul>
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
<div class="playlist_area">
	<div class="playlist_area_center">
    	<div class="main_playlist_area">
        	<div class="playlist_left_arrow"><img src="images/leftplaylist_arrow.jpg" alt="" /></div>
            <div class="playlist_center">
            	<div class="dropvideo_area drop_space">drop video here</div>
                <div class="dropvideo_area drop_space1">drop video here</div>
                <div class="dropvideo_area drop_space1">drop video here</div>
                <div class="break_area drop_space1">15 sec<br /> Break</div>
                <div class="drop_video drop_space2"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/drop_video.jpg" alt="" /></div>
                <div class="drop_video_rating drop_space3">
                	<h1>Yoga Starter</h1>
                    <div class="yogastarter_area">
                    	<div class="overall_area">
                        	<div class="overall_text">Overall</div>
                            <div class="overall_rating">
                            	<div class="star_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/star.png" alt="" /></div>
                                <div class="star_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/star.png" alt="" /></div>
                                <div class="star_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/star.png" alt="" /></div>
                                <div class="star_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/star.png" alt="" /></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="overall_area">
                        	<div class="overall_text">Complexity</div>
                            <div class="overall_rating overall_rating_space">
                            	<div class="complexity_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/complexity_icon.png" alt="" /></div>
                                <div class="complexity_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/complexity_icon.png" alt="" /></div>
                                <div class="complexity_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/complexity_icon.png" alt="" /></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="overall_area">
                        	<div class="overall_text">Intensity</div>
                            <div class="overall_rating overall_rating_space">
                            	<div class="intencity_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/intensity_icon.png" alt="" /></div>
                                <div class="intencity_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/intensity_icon.png" alt="" /></div>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="playlist_right_arrow"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/rightplaylist_arrow.jpg" alt="" /></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!--End Play List Area-->
