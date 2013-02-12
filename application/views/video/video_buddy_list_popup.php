<form action="<?php echo $this->config->item('base_url'); ?>video/play/" method="post" name="play_option_friend" id="play_option_friend" >
<table cellpadding="3" cellspacing="1" border="0" width="100%">
	<tr><td>
    	<div style="height:50px; overflow:auto;">
       		<?php
				$fr = 0;
				//print_r($friend_list);
				if (!empty($friend_list)){
					foreach($friend_list as $fl){
						if ($fl['log_count']>0){
							$fr++;
			?>
            <p style="margin-left:25px;">
            	<input type="radio" name="friend_id" id="friend_id" value="<?php echo $fl['friend_id']; ?>" >&nbsp;<?php echo $fl['friend_name']; ?>
            </p>            
            <?php 
						}
					}
					if ($fr<=0){echo '<p>None of the buddies are online.</p>';}
				}else{
			?>
            <p>No buddies found</p>
            <?php } ?>
		</div>
	</td></tr>
    <tr><td height="15">&nbsp;</td></tr> 
	<?php if($fr>0){?>   
    <tr>
    	<td>
        	<input type="hidden" name="video_id" id="buddy_video_id" value="<?php echo $video_id; ?>" />
            <input type="button" name="submit_accept" id="submit_accept" value="Choose Friend" onclick="redirect_from_choose_friend('<?php echo $this->config->item('base_url');?>');" />
            <input type="hidden" name="play_option_select" id="play_option_select_friend" value="WF" />
            <input type="hidden" name="buddy_id" id="buddy_id" value="" />
            <input type="hidden" name="view_type" id="buddy_view_type" value="<?php echo $view_type; ?>" />
            <input type="hidden" name="action" id="action" value="play_option" />            
        	<input type="submit" name="play_option_submit_friend" id="play_option_submit_friend" value="submit123" style="display:none;" />
        </td>
    </tr>
	<?php }?>
</table>
</form>