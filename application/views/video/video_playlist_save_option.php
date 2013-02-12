<table cellpadding="3" cellspacing="1" border="0" width="100%">
	<tr>
    	<td>
    		<label>Playlist Name</label>
		</td>
        <td><input type="text" name="playlist_caption" id="playlist_caption" value="" style="width:250px; padding:5px;" /></td>
    </tr>
    <tr><td height="15">&nbsp;</td><td><span id="errPlaylist" style="color:#F00; font-size:11px; display:none;"></span></td></tr>    
    <tr>
    	<td>&nbsp;</td>
    	<td>
        	<input type="hidden" name="current_playlist_id" id="current_playlist_id" value="<?php echo $this->session->userdata('current_playlist_id'); ?>" />
            <input type="button" name="submit_accept" id="submit_accept" value="Save Playlist" onclick="submit_save_playlist_form('<?php echo $this->config->item('base_url'); ?>');" />
        </td>
    </tr>
</table>