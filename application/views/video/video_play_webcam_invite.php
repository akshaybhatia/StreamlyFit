
<link rel="stylesheet" href="<?php echo $this->config->item('base_url'); ?>assets/chat/style.css" type="text/css" />
<!--Tokbox Main JS-->
<!--<script src="http://staging.tokbox.com/v0.91/js/TB.min.js" type="text/javascript" charset="utf-8"></script>-->
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/video/tokbox.js"></script>
<!--Load tokbox helper functions-->
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/video/tokbox_config.js" charset="utf-8" ></script>
<script type="text/javascript" charset="utf-8">
	
	tokbox_init('<?php echo $api_key; ?>', '<?php echo $vid_sess_id; ?>', '<?php echo $session_token; ?>');
	
	function open_cam(frnd_id)
	{
		$("vid_frnd_id").value=frnd_id;
		$("vid_receiver_id").value=frnd_id;
		$("vid_"+frnd_id).update("Connecting...");
		connect();			
	}
       
</script>




<div id="main">

	<div id="page">
		
		<h1>Fitness Video Play</h1>
		<p>&nbsp;</p>
		<!--<a href="<?php echo $this->config->item('base_url'); ?>assets/video/Seven_Min_Workout_For_Beginners.flv" style="display:block; width:520px; height:330px" id="player"></a>-->
		<a href="<?php echo $this->config->item('base_url'); ?>assets/video/<?php echo $video_file_name; ?>" style="display:block; width:520px; height:330px" id="player">		
		</a>
		
		
		<div id="chat_wrapper" style="width:850px; float:left;" > 
			<div id="vid" style="width:400px; float:left;">
				<div id="vid_chat_invitation" style="font-weight:bold; color:#CC3300; font-size:14px; width:400px;"></div>
				
				<br />
				<div id="opentok_console" style="float:left; width:400px;"></div>
				<div id="links" style="width:400px;">
					<a id ="disconnectLink" href="javascript:void(0);" onClick="javascript:disconnect()" style="display:none">Close Session</a> &nbsp;
				</div>
				<!-- Start Video Chat -->
				<div style="width:700px; height:auto; border:0px solid #000; border-width:0px;">
					<div style="width:350px; height:auto; float:left;" id="myCamera" class="publisherContainer">
					</div>
					<div style="width:350px; height:auto; float:left;" id="subscribers" class="publisherContainer"></div>
					<div style="clear:both"></div>
				</div>
				<!-- End Start Video Chat -->
<!--				<div id="myCamera" style="border:1px solid #000; border-width:1px;" class="publisherContainer" style="float:left;" ></div>
				<div id="subscribers"  style="border:1px solid #000; border-width:1px;" style="float:left;">1</div>
-->			
				<input type="hidden" id="vid_frnd_id" value=""  />
			
			</div>
			
		</div>
		
		<?php if (strcmp($view_mode, 'WF')==0){ ?>
		
        <div style="margin-top:40px; padding-top:15px;">		
			<h3>Invite your Buddy to Join</h3>
			<div id="buddy_list" style="border:1px solid #333333;" >
			
				<div style="float:left; height:50px; width:50px; border:0px solid #009999; padding:5px; margin-left:10px;" >
					<a href="javascript:void(0);" title="Click to invite buddy for webcam chat">
					<img src="<?php echo $this->config->item('base_url'); ?>assets/images/online_user.png" height="" width="" /><br />
					Jhon Doe
					</a>
				</div>
				
				<div style="float:left; height:50px; width:50px; border:0px solid #009999; padding:5px; margin-left:10px; " >
					<img src="<?php echo $this->config->item('base_url'); ?>assets/images/offline_user.png" height="" width="" /><br />
					David Gill
				</div>
				
				<div style="float:left; height:50px; width:50px; border:0px solid #009999; padding:5px; margin-left:10px; " >
					<img src="<?php echo $this->config->item('base_url'); ?>assets/images/offline_user.png" height="" width="" />
					Akshay Bhatia
				</div>
				
				
			</div>
		</div>
		<?php } ?>
		
		
		
		
		<!-- Script to install flowplayer -->
		<script>
			flowplayer("player", "<?php echo $this->config->item('base_url'); ?>assets/video/flowplayer-3.2.15.swf", {
				
			  		clip:{
				  		autoPlay: true,
				  		autoBuffering: true
			  		}
			});
		</script>
		
		<!--Script to check the user preference before opening a video-->
		<script type="text/javascript">
			$(document).ready(function(){
				connect();
				update_buddy_status();
			});
			
			//update buddy status to start video simultaneously
			function update_buddy_status()
			{
				$.ajax({
					url: "<?php echo $this->config->item('base_url'); ?>video/update_buddy_status/<?php echo $view_id; ?>/",
					success: function(data){
						if (data==1)
						{
							//start the video
							change_vid_div();
						}
					}
				
				});
			}
			
			//start the video if buddy accepts the invitation
			function change_vid_div()
			{
				$.ajax({
					url: "<?php echo $this->config->item('base_url'); ?>video/refresh/<?php echo $video_file_name; ?>/",					
					success: function (data){
						$('#video_play').html(data);
					}
				});
			}
			
		</script>	
		<!-- 
			after this line is purely informational stuff. 
			does not affect on Flowplayer functionality 
		-->
		
	</div>
</div>
<style>
#opentok_console {
	float: right;
	width: 400px;
	font-family: 'courier', monospace;
	font-size: 12px;
}

#links {
	float: top;
}

#links a, input {
	display: none;
}

#sessionControls {
	float: top;
}

#pubControls input {
	display: inline;
}

#publishForm {
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
}

#deviceManagerControls {
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
}
	
#action a {
	display:none;
}

#localview {
	float: left;	
	width: 250px;
}

div.controls {
	width:220px;
	padding:10 0 10 0;
	font-size: 14px;
}

.videobar {
	float: top;
}

.videobar-left {
	float: left;	
	width: 250px;
}

.smalltype {
	font-size: 80%;
	padding-bottom: 6px;
}

.description {
	font-size: 90%;
	padding-top: 6px;
}

#controls {
	float: left;
	text-align: left;
	padding-right: 10px;
}

#publisherControls {
	display: none;
}

#push-to-talk {
	display: none;
}

#manageDevicesBtn {
	display:none;
}

#manageDevicesDiv {
	display:none;
	position:absolute;
	width:200px;
	left:280px;
	background-color:DDD;
	padding:10px;
	border:4px;
}

#manageDevicesDiv h1{
     font-size:18px;
 }
 #manageDevicesDiv label{
    width:100%;
    display: block;
    margin-top:-4px;
 }
 #manageDevicesDiv img{
     display: block;
     margin:auto;
 }
 #manageDevicesDiv a{
     font-size: small;
     display: block;
     margin-top:-12px;
 }
 #manageDevicesDiv input{
     margin-top:2px;
 }
 #gainControl{
     width:30px;
     margin-top:20px;
 }
 #manageDevicesDiv .volume{
     display:inline-block;
     position: relative;
     vertical-align:top;
     height:20px;
     width:0;
     height:10px;
     background-color:lime;
     margin-top:10px;
 }

#devicePanelContainer {
	position: absolute;
	left: 250px;
	top: 10px;
	display:none;
}

#devicePanelCloseButton {
	position: relative;
	z-index: 10;
	margin-left: 285px;
	margin-right: 12px;
	padding: 3px;
	text-align: center;
	font-size: 11px;
	background-color: lightgrey;
}

#devicePanelBackground {
	background-color: lightgrey;
	width: 340px;
	height: 230px;
}

#devicePanelInset #devicePanel {
	position: relative;
	top: -74px;
	left: -9px;
}

a.settingsClose:link,
a.settingsClose:visited,
a.settingsClose:hover {
	text-decoration: none;
	cursor: pointer;
}

table {
	clear: both;
}

td {
	vertical-align: top;
	padding-right: 15px;
}

.publisherContainer {
	float: left;
}

.subscriberContainer {
	width: 264px;
	margin-left: 4px;
	float:left;
}

#login {
	background-color:#999;
	border:thin solid #000;
	width:400px;
	padding:5px;
}

#login input {
	display: inline;
	border: thin solid #000;
}

#connectionsContainer {
	clear:both;
	background-color:#CCC;
	width:400px;
}

.swfContainer {
	float:left;
	width: 320;
	margin-left: 5px;
}

#recorderElement {
	clear:both;
	float:left;
}

#playerElement {
	clear:both;
	float:left;
}
</style>