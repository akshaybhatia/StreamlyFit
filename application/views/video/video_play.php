<!-- Body Area -->
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/video/flowplayer-3.2.11.min.js" ></script>
<div class="body_landing_page_video_area">
	<div class="show_strip">
    	<div class="strip_bar"></div>
        <div class="drop_arrow" id="slide_control">&nbsp;</div>
    </div>
	<div class="body_main_area">
		<div class="video_play_list">        	
        	
        
			<div class="big_video_playlist">
            <!--<img src="images/big_video.jpg" alt="" />-->
            
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
				
            
            <?php
            	/*echo '<pre>';print_r($video_detail);echo '</pre>';
				echo '<pre>';print_r($playlist_detail);echo '</pre>';*/
				
			?>
            
            </div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<!-- End Body Area -->