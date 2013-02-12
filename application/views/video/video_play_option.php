<!-- Body Area -->
<div class="body_area">
	<div class="body_main_area">
    	<!--Header Animated Area-->
        <form name="play_option_form" id="play_option_form" action="<?php echo $this->config->item('base_url'); ?>video/play/" method="POST">
            <div class="header_animated_area">
                <div class="video_landing_area">
                    <div class="video_landing_heading">Choose how you want to watch:</div>
                    <div class="video_box_area">
                        <a href="javascript:void(0);" onclick="redirect_from_play_option('<?php echo $this->config->item('base_url'); ?>', '<?php echo $video_copy_id; ?>', 'A');" ><div class="fistbox box_space">1. Just the Video</div></a>
                        
                        <a href="javascript:void(0);" onclick="redirect_from_play_option('<?php echo $this->config->item('base_url'); ?>', '<?php echo $video_copy_id; ?>', 'WF');"><div class="fistbox box_space">2. With a Friend</div></a>
                        
                        <a href="javascript:void(0);" onclick="redirect_from_play_option('<?php echo $this->config->item('base_url'); ?>', '<?php echo $video_copy_id; ?>', 'WC');"><div class="fistbox">3. With a Mirror</div></a>
                    </div>
                </div>
            </div>
            <input type="hidden" name="play_option_select" id="play_option_select" value="" />
            <input type="hidden" name="view_type" id="view_type" value="<?php echo $view_type; ?>" />
            <input type="hidden" name="action" id="action" value="play_option" />
            <input type="hidden" name="video_id" id="video_id" value="<?php echo $video_copy_id; ?>" />
        	<input type="submit" name="play_option_submit" id="play_option_submit" value="submit123" style="display:none;" />
        </form>
        <!-- End Header Animated Area-->
    </div>
</div>
<div class="clearfix"></div>
<!-- End Body Area -->