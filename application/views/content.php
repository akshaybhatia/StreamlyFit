<!-- Body Area -->

<div class="body_area">
	<div class="body_main_area">
    	<!--Header Animated Area-->
        <div class="header_animated_area">
            <!--First Slide-->
            <div id="foo1">
            	<div style="width:1200px; height:666px;">
                    <div class="first_slide">
                    <div class="first_slide_left"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/tree.png" alt="" /></div>
                    <div class="first_slide_center"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/video_frame.jpg" alt="" /></div>
                    <div class="first_slide_right">
                        <h1>Finally!</h1>
                        <h2>“I love this song” <br />
                            comes to the <br />
                            home workout.
                        </h2>
                        <h3>
                            rem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eeu libero viverra fermentum. Integer iaculis lectus non dui 
                        </h3>
                    </div>
                </div>
            	</div>
                <?php  if(!$this->session->userdata('user_id')){?>
                <div style="width:1200px; height:666px;">
                    <div class="second_slide">
                    <div class="second_slide_left_area"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/second_slide_women.png" alt="" /></div>
                    <div class="second_slide_center_content">
                        <h1>Create your perfect <span style="text-decoration:line-through">playlist</span> workout!</h1>
                        <h2>rem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eeu libero viverra fermentum. Integer iaculis lectus non dui bibendum et</h2>
                        <div class="signup_main_area">
                            <div class="signup_main_left_area">
                                <div class="input_area inputspace_area"><input type="text" class="input_area_border" placeholder="Your Name" /></div>
                                <div class="input_area"><input type="text" class="input_area_border" placeholder="Email Address" /></div>
                            </div>
                            <div class="signup_main_right_area"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/offer.png" alt="" /></div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="signup_main_area inputspace_area1">
                            <div class="signup_button_area"><input type="image" src="<?php echo $this->config->item('base_url'); ?>assets/images/signup_btn.png" alt="" /></div>
                            <div class="signup_text_area">or   <a href="#">Learn More</a></div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="yoga_floor_area">
                             <div class="secondslide_floor"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/floor.png" alt="" /></div>
                        </div>
                    </div>
                    <div class="second_slide_right_bar"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/2ndslide_rightimage.png" alt="" /></div>
                    <div class="clearfix"></div>
                </div>
            	</div>
                <?php }?>
                <div style="width:1200px; height:666px;">
                    <div class="third_slide">
                    <div class="third_left_bar">
                	<h1>Anytime, anywhere, <br />
					   join your friends working out online
                    </h1>
                    <h2>rem ipsum dolor sit amet, consectetur adipiscing elit. </h2>
                    <div class="third_picture_area"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/video_pic.png" alt="" /></div>
                </div>
               <div  class="clearfix"></div>
                 </div>
             	</div>
                <div style="width:1200px; height:666px;">
                    <div class="forth_slide">
                    <div class="forth_left_bar"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/4th_yogawomen.png" alt="" /></div>
                    <div class="forth_center_bar">
                        <h1>If you sign on now and help us improve our site </h1>
                        <h2>we will give you your first month free <br />
                            and this great t-shirt!
                        </h2>
                        <h3>(No strings attached. You can cancel anytime, but you won’t).</h3>
                        <?php  if(!$this->session->userdata('user_id')){?>
                        <div class="fourth_signup_main_area">
                            <div class="signup_button_area">
                            	<a href="<?php echo $this->config->item('base_url'); ?>signup/"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/signup_btn.png" title="Sign Up" alt="Sign Up" /></a>
                            </div>
                            <div class="signup_text_area">or   <a href="#">Learn More</a></div>
                            <div class="clearfix"></div>
                        </div>
                    	<?php }?>
                    </div>
                    <div class="forth_right_bar"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/bamboo.png" alt="" /></div>
                    <div class="clearfix"></div>
                 </div>
            	</div>
            </div>
            <!--End First Slide-->
            
            <!--End First Slide-->
        </div>
        <!-- End Header Animated Area-->
    </div>
    <!-- Video Playlist Area-->
    <div class="videoplaylist_area">
    	<div class="videoplaylistmain_area top_space">
			<div class="left_arrow"><a href="#" id="prev"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/left_arrow.jpg" alt="" /></a></div>
			<div class="right_arrow"><a href="#" id="next"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/right_arrow.jpg" alt="" /></a></div>


            <div id="tabs_wrapper">
                <div id="tabs_container">
                    <ul id="tabs">
                        <!--<li <?php if (empty($uri_seg)){?> class="active"<?php }?> ><a href="#tab1" onclick="load_home_video_list('<?php echo $this->config->item('base_url'); ?>'); ">Dance Workouts</a></li>-->
                        <li <?php if (empty($uri_seg) || $uri_seg=='dance'){?> class="active"<?php }?> ><a href="#tab1" onclick="javascript:window.location.href='<?php echo $this->config->item('base_url').'home/category/1/dance/'; ?>';" >Dance Workouts</a></li>
                        <li <?php if (!empty($uri_seg) && $uri_seg=='yoga'){?> class="active"<?php }?> ><a href="#tab2" onclick="javascript:window.location.href='<?php echo $this->config->item('base_url').'home/category/2/yoga/'; ?>';" >Yoga</a></li>
                        <li <?php if (!empty($uri_seg) && $uri_seg=='breaks'){?> class="active"<?php }?> ><a href="#tab3" onclick="javascript:window.location.href='<?php echo $this->config->item('base_url').'home/category/3/breaks/'; ?>';" >Breaks</a></li>
                        <li <?php if (!empty($uri_seg) && $uri_seg=='playlist'){?>class="active" <?php }?> ><a href="#tab4" onclick="load_all_user_playlist('<?php echo $this->config->item('base_url'); ?>');">Playlist</a></li>
                        
                    </ul>
                </div>
                <div id="tabs_content_container">
                    <div id="tab1" class="tab_content" <?php if (empty($uri_seg) || $uri_seg=='dance'){?> style="display:block;"<?php }else{?>style="display:none;" <?php }?>>                    	
                    	<div class="slides">
                        	<div class="list_carousel" id="home_video_list" >
                        		<?php echo $video_list_page; ?>
                    			<div class="clearfix"></div>
                    		</div>                        
                        </div>
                    </div>
                    
                    <div id="tab2" class="tab_content" <?php if (!empty($uri_seg) && $uri_seg=='yoga'){?> style="display:block;"<?php }?> >
                    	<div class="slides">
                        	<div class="list_carousel" id="home_video_list_yoga" >
                        		<?php echo $video_list_page_yoga; ?>
                    			<div class="clearfix"></div>
                    		</div>                        
                        </div>
                    </div>
                    <div id="tab3" class="tab_content" <?php if (!empty($uri_seg) && $uri_seg=='breaks'){?> style="display:block;"<?php }?> >
                    	<div class="slides">
                        	<div class="list_carousel" id="home_video_list_breaks" >
                        		<?php echo $video_list_page_breaks; ?>
                    			<div class="clearfix"></div>
                    		</div>                        
                        </div>
                    </div>
                    <div id="tab4" class="tab_content"  <?php if (!empty($uri_seg) && $uri_seg=='playlist'){?> style="display:block;" <?php }?> >
                    	<?php if ($this->session->userdata('user_id')!=''){ ?>
                    	<span id="create_new_playlist_span"><a href="javascript:void(0);" onclick="create_new_playlist('<?php echo $this->config->item('base_url'); ?>'); " ><img src="<?php echo $this->config->item('base_url'); ?>assets/images/create_new_playlist.png" align="right" style="padding-top:5px; padding-right:14px;" alt="Create New Playlist" /></a></span>
                        <?php } ?>
                    	<div class="slides">
                        	<div class="list_carousel" id="display_user_playlist">
                        		
                                
                                
                    			
                    		</div>                        	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Video Playlist Area-->
</div>
<div class="clearfix"></div>
<!-- End Body Area -->

<!--Play list Area-->
	<div id="user_playlist_section">
    	<?php echo $playlist_page; ?>
    </div>
    <?php
    	if (!empty($uri_seg) && $uri_seg=='playlist'){
	?>
    <script type="text/javascript">
		$(document).ready(function(){
			//window.scroll(500, 800);
			load_all_user_playlist('<?php echo $this->config->item('base_url'); ?>');
						
			
		});
		
		
		
	</script>
    <?php } ?>
<!--End Play List Area-->