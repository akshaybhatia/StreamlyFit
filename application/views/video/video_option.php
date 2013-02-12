
	<form action="" method="post" name="video_play_option" id="video_play_option">
		<table width="100%" cellpadding="1" cellspacing="1" border="0" >
			<tr><th>Video Play Options</th></tr>
			<tr><td align="left">
				<label>&nbsp;</label>
				<input type="radio" name="video_option" id="video_option" value="A" checked="checked" /> &nbsp; Play
			</td></tr>
			<tr><td align="left">
				<label>&nbsp;</label>
				<input type="radio" name="video_option" id="video_option" value="WC" /> &nbsp; Play with webcam
			</td></tr>
			<tr><td align="left">
				<label>&nbsp;</label>
				<input type="radio" name="video_option" id="video_option" value="WF" /> &nbsp; Play with webcam and share
			</td></tr>
			<tr><td align="center">
				<label></label>
				<input type="hidden" name="video_id" id="video_id" value="<?php echo $video_id; ?>" />
				<input type="button" name="video_option" id="video_option" value="Choose Option" onclick="submit_play_option();" />
			</td></tr>
		</table>
	</form>