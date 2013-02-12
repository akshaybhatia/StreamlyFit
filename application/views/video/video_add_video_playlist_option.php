<table cellpadding="3" cellspacing="1" align="center" width="100%">
	<tr>
    	<td colspan="2" width="100%">The video already exist in your playlist. Do you still want to add it to your playlist?</td>
    </tr>    
    <tr>
    	<td colspan="2" align="center">
        	<input type="hidden" name="add_video_id" id="add_video_id" value="<?php echo $video_id; ?>" />
            <input type="hidden" name="add_sort_order" id="add_sort_order" value="<?php echo $sort_order; ?>" />
            <input type="hidden" name="add_playlist_id" id="add_playlist_id" value="<?php echo $playlist_id; ?>" />
            <input type="hidden" name="add_playlist_type" id="add_playlist_type" value="<?php echo $playlist_type; ?>" />
        	<a href="javascript:void(0);" onclick="add_video_playlist_anyway('<?php echo $this->config->item('base_url'); ?>');" >
            	<img src="<?php echo $this->config->item('base_url'); ?>assets/images/add_anyway.png" alt="" />
            </a>
            &nbsp;&nbsp;
            <a href="javascript:void(0);" onclick="close_video_playlist_anyway();" >
            	<img src="<?php echo $this->config->item('base_url'); ?>assets/images/cancel.png" alt="" />
            </a>
        </td>
    </tr>
</table>