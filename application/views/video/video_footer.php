<!-- Footer Area-->
<div class="clearfix"></div>
<div class="footer_area">
	<div class="footer_main_area">
    	<div class="workout_area workspace" id="playlist_title" style="border:none;" >&nbsp;</div>
        
        <div class="work_length">
        	
        	<h1>&nbsp;</h1>
            <h2>&nbsp;</h2>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- End Footer Area-->



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

<?php if($this->session->userdata('user_id')){?>

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