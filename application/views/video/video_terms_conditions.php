<table cellpadding="3" cellspacing="1" border="0" width="100%">
	<tr><td>
    	<div style="height:150px; overflow:auto;">
        <p>
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
		</p>
        <p>
        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
        </p>
		</div>
	</td></tr>
    <tr><td height="15">&nbsp;</td></tr>
    <tr>
    	<td>
        	<input type="checkbox" name="accept_terms" id="accept_terms" value="1" /> &nbsp;I accept the terms & conditions            
        </td>
    </tr>
    <tr>
    	<td>
        	<input type="hidden" name="video_id" id="terms_video_id" value="<?php echo $video_id; ?>" />
            <input type="button" name="submit_accept" id="submit_accept" value="Accept" onclick="redirect_from_waiver_form('<?php echo $this->config->item('base_url');?>');" />
        </td>
    </tr>
</table>
