<!-- Footer Area-->
<div class="clearfix"></div>
<div class="footer_area">
	<div class="footer_main_area">
    	
        <!--Div to display the video save playlist option start--> 
        <?php //print_r($this->session->userdata('current_playlist_videos')); ?>
        <div id="playlist_controls" style="display:<?php if($this->session->userdata('user_id')!='' && ($this->session->userdata('current_playlist_videos')!='' && count($this->session->userdata('current_playlist_videos'))>0)){?>block;<?php }else{?>none<?php }?>;">
        <?php
			$save_button_show = 'none';
			$rename_button_show = 'none';
			$name_playlist_show = 'none';
			$input_playlist_name_show = 'none';
			
			if ($this->session->userdata('user_id')!='' && $this->session->userdata('current_playlist_videos')!='' && $this->session->userdata('current_playlist_type')=='current'){
				/*echo sizeof($this->session->userdata('current_playlist_videos'));
				print_r($this->session->userdata('current_playlist_videos'));*/
				$name_playlist_show = 'none';
				$input_playlist_name_show = 'block';
				$save_button_show = 'block';
				$rename_button_show = 'none';
			}else if ($this->session->userdata('user_id')!='' && $this->session->userdata('current_playlist_type')=='playlist'){
				$save_button_show = 'none';
				$rename_button_show = 'block';
				$name_playlist_show = 'none';
				$input_playlist_name_show = 'block';
			}
		?>
        
        <!--Div to display playlist name-->
        <div class="workout_area workspace" style="display:<?php echo $name_playlist_show; ?>;" id="playlist_title"><?php if ($this->session->userdata('current_playlist_name')!=''){echo $this->session->userdata('current_playlist_name'); }else{?>Untitled Workout<?php }?></div>
        
        <!--Div to save the playlist and input the playlist name-->
        <div class="workout_area workspace" id="playlist_title_save" style="display:<?php echo $input_playlist_name_show; ?>; width:280px;">
        	<input type="text" name="playlist_caption" id="playlist_caption" value="<?php if ($this->session->userdata('user_id')!='' && $this->session->userdata('current_playlist_type')=='playlist'){echo $this->session->userdata('current_playlist_name'); }else{echo "Enter Playlist Name"; } ?>"  rel="Enter Playlist Name" style="width:250px; padding:2px; color:#999;" />        
        </div>
        
       	<!--Display the save playlist button-->
         <div class="saveplay_button" style="display:<?php echo $save_button_show; ?>" id="playlist_save_button">
         	<!--<a href="javascript:void(0);" id="playlist_save_link" style="text-decoration:none; width:77px;" title="Click to save the playlist" onclick="open_save_current_playlist_form('<?php echo $this->config->item('base_url'); ?>');" >Save Playlist</a>-->
            
            <a href="javascript:void(0);" id="playlist_save_link" style="text-decoration:none; width:77px;" title="Click to save the playlist" onclick="submit_save_playlist_form('<?php echo $this->config->item('base_url'); ?>');" >Save Playlist</a>
            
         </div>
         
         <div class="saveplay_button" style="display:<?php echo $rename_button_show; ?>" id="playlist_rename_button">
         	<a href="javascript:void(0);" id="playlist_rename_link" style="text-decoration:none; width:77px;" title="Click to rename the playlist" onclick="rename_playlist_title('<?php echo $this->config->item('base_url'); ?>');" >Save Playlist</a>
         </div>
         
         <!--Display the cancel playlist button-->
         <div class="cancel_button" style="display:none;" id="playlist_cancel_button">
         	<a href="javascript:void(0);" onclick="cancel_save_current_playlist_form('<?php echo $this->config->item('base_url'); ?>');" >Cancel</a>
         </div>
         
         <?php
         	if($this->session->userdata('user_id')!='' ){
		 ?>
         <!--Display the create new playlist button-->
         <div class="saveplay_button" style="display:block;" id="create_new_playlist_span">
         	<a href="javascript:void(0);" onclick="create_new_playlist('<?php echo $this->config->item('base_url'); ?>'); " title="Click to create a new playlist" >New Playlist</a>
         </div>
         <?php } ?>
        </div>
        
        
        
        <div class="work_length">
        	<input type="hidden" id="total_videos" value="<?php if ($this->session->userdata('current_playlist_videos')!=''){echo count($this->session->userdata('current_playlist_videos'));}else{ echo 0;} ?>" />
        	<h1>Workout Length: </h1>
            <h2><span id="count_video">
			<?php 
				if ($this->session->userdata('current_playlist_videos')!=''){
					echo count($this->session->userdata('current_playlist_videos'));
					
					if (count($this->session->userdata('current_playlist_videos'))>1 || count($this->session->userdata('current_playlist_videos'))<=0){
						echo ' Videos';
					}else{
						echo ' Video';
					}
				}else{ 
					echo '0'.' Videos';
				}
			?>
            </span> (<span id="video_duration">
			<?php 
				if ($this->session->userdata('current_playlist_duration')!='')
				{
					$hours = '0';
					$mins = '0';
					$sec = '0';
					if ($this->session->userdata('current_playlist_duration')->h<=9)
					{
						$hours = '0'.$this->session->userdata('current_playlist_duration')->h;
					}else{
						$hours = $this->session->userdata('current_playlist_duration')->h;
					}
					
					if ($this->session->userdata('current_playlist_duration')->m<=9)
					{
						$mins = '0'.$this->session->userdata('current_playlist_duration')->m;
					}else{
						$mins = $this->session->userdata('current_playlist_duration')->m;
					}
					
					if ($this->session->userdata('current_playlist_duration')->s<=9)
					{
						$sec = '0'.$this->session->userdata('current_playlist_duration')->s;
					}else{
						$sec = $this->session->userdata('current_playlist_duration')->s;
					}
					//echo $this->session->userdata('current_playlist_duration')->h.':'.$this->session->userdata('current_playlist_duration')->m.':'.$this->session->userdata('current_playlist_duration')->s;
					echo $hours.':'.$mins.':'.$sec;
				}else{
					echo '00:00:00';
				}
			?>
			</span>)</h2>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- End Footer Area-->
<script type="text/javascript">
var default_value = 'Enter Playlist Name';

$("#playlist_caption").live("blur", function(){
	var default_value = $(this).attr("rel");
	if ($(this).val() == ""){
		$(this).val(default_value);
	}
}).live("focus", function(){
	var default_value = $(this).attr("rel");
	if ($(this).val() == default_value){
		$(this).val("");
	}
});

$(document).ready(function() {

    $("#playlist_caption11").keydown(function(event) {

    // Allow only backspace and delete and negative sign
		//alert(event.keyCode);
		var playlist_type = $('#playlist_type').val();
		var playlist_id = $('#playlist_id').val();
		
		if (playlist_type=='playlist' && playlist_id!='' && event.keyCode==13)
		{
			rename_playlist_title('<?php echo $this->config->item('base_url'); ?>');
		}
        /*if (event.keyCode == 46 || event.keyCode == 8  || event.keyCode == 9 || event.keyCode == 109 ||event.keyCode == 110) {

                // let it happen, don't do anything

            }

            else {

                // Ensure that it is a number and stop the keypress

                if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)) {

 

                }

                else {

                    event.preventDefault();

                }

            }*/

    });
});
</script>


<!--Popup Box DIV-->
<div id="basic-modal-content" style="display: none; min-width:300px; min-height:200px">
    <div class="popup_mainbox">
            <div class="popup_header" >
                <div style="float:left; padding-top:3px; padding-left:10px;" id="popup_title"></div>
                <div style="float:right; padding-top:1px;"><a href="javascript:closeBox()" id=""><img src="<?php echo $this->config->item('base_url'); ?>assets/video/cross.png" alt="Close" /></a></div>
                <div class="clear"></div>
            </div>
            <div class="pop_body_area" id="pop_form_area" >
                
            </div>
    </div>
</div>
<!--End Popup Box DIV-->

<?php if($this->session->userdata('user_id') && $this->session->userdata('membership_type')<>'F'){?>

<div class="chat_area">
	<div class="chat_header">
        <div class="chat_icon">
            <img src="<?php echo $this->config->item("site_url")?>/assets/images/chat_icon.jpg" />
        </div>
        <div class="chat_icon_text">
            
        </div>
    </div>
    
    
</div>  

<div class="chat_body">
    	
        <div class="chat_box_area">
        
        </div>
        
        <div class="chat_search_area">
        	<div class="chat_search_area_message"></div>
            <div class="search_box_area">
                <div class="chat_search_fill">
                		<input type="text"  name="friend_name" value="" id="friend_name" class="chat_text_input" onblur="show_txt('friend_name','text_friend_name')" style="display:none"  />
                        <input type="text"  value="Find Buddies" name="text_friend_name" id="text_friend_name" class="chat_text_input" onfocus="show_pass('friend_name','text_friend_name')" onclick="show_pass('friend_name','text_friend_name')"/>
                    </div>
                <div class="chat_search_btn"><input type="image" src="<?php echo $this->config->item("site_url")?>/assets/images/search_btn1.jpg" onclick="search_friend();" /></div>
                <div class="clearfix" ></div>
            </div>
            
            <div class="invite_friend" style="border:0px solid #000;" onclick="show_input_option()"></div>
            <div class="new_request" style="border:0px solid #000;" onclick="show_friend_request();"></div>
            
            
            <div class="clearfix"></div>
        </div>
</div> 

<? }?>



</body>
</html>