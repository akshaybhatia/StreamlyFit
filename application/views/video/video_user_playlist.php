<ul id="user_play">
    <?php
		
        if (!empty($result)){
            foreach($result as $vl){
    ?>
    
    <li class="space_right">
    	
        <div class="small_video_area" onmouseover="showremoveplay('<?php echo $vl->playlist_id; ?>');" onmouseout="hideremoveplay('<?php echo $vl->playlist_id; ?>');">
        	<div class="over_cross_remove" id="over_cross_play_<?php echo $vl->playlist_id; ?>">
                 <a href="javascript:void(0);" onclick="remove_playlist('<?php echo $this->config->item('base_url'); ?>', '<?php echo $vl->playlist_id; ?>', '<?php echo $vl->playlist_title; ?>');"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/mouseover_cross.png" alt="" /></a>
        </div>
        <!--Click on the link to display the video health waiver form-->
        <?php
        	if (empty($vl->video_image)){
				$video_image = 	'small_video.jpg';
			}else{
				$video_image = 	$vl->video_image;
			}
		
		?>
        
        <!--<a  href="javascript:void(0);" onClick="load_single_playlist('<?php echo $this->config->item('base_url'); ?>', '<?php echo $vl->playlist_id; ?>', '<?php echo $vl->playlist_title; ?>', 'redirect');">-->
        <a href="javascript:void(0);" onClick="redirect_to_play_option('<?php echo $this->config->item('base_url'); ?>', '<?php echo $vl->playlist_id; ?>');" >            
        	<img id="" src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $video_image; ?>" alt="<?php echo $vl->playlist_title; ?>" width="184" height="121" />
        </a>
        <!--Click on the link to display the video health waiver form-->
        
        </div>
        <div class="video_content">
            <div class="yoga_starter">
           <!-- <br>
            <a  href="javascript:void(0);" style="font-size:10px; color:#000; z-index:10000;" class="">Add to playlist</a>-->
            	<?php echo $vl->playlist_title; ?>
                <br>
                <?php 
					echo $vl->total_vids; 
					if ($vl->total_vids>1)
					{
						echo ' videos';	
					}else{
						echo ' video';	
					}
				?>
            </div>
            
        </div>
    </li>
    
    <?php }}else{?>
    No playlist found
    <?php }?>
  
</ul>

<div class="clearfix"></div>

<script type="text/javascript">
	$(function() {
		$('#user_play').carouFredSel({
			prev: '#prev',
			next: '#next',
			auto: false
		});
	});
</script>
<script language="javascript">

function showremoveplay(video_id)
{
	//$(".over_cross").fadeIn('slow');
	$('#over_cross_play_'+video_id).fadeIn('slow');
}

function hideremoveplay(video_id)
{
	//$(".over_cross"). fadeOut('slow');
	$('#over_cross_play_'+video_id).fadeOut('slow');
}
	
</script>