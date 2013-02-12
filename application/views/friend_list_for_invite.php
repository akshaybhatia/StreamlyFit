<div class="signup_body_area">
	<div class="body_main_area">
    		
            <div class="signup_main_area_center">
        	<!-- First Step -->
           <div class="signup_page_area">
            	<div class="signup_heading2">Invite From Gmail Contact List</div>
                <div id="message" style=" color:#FF0000; padding-left:350px; padding-top:8px; font-weight:bold;"></div>
				<div class="signup_form_area">
					<div class="signup_leftbar"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/signup_women.png" alt="" /></div>
					<div class="signup_rightbar">
						 <div class="gmail_box_area">
                         	<?php for($i=0,$j=1;$i<count($friends_email);$i++,$j++){?>
							<div class="gmail_friend_area">
                            	<div class="gmail_friend_name_area"><input type="checkbox" value="<?php echo $friends_email[$i];?>" checked="checked" /></div>
                                <div class="gmail_friend_name_area"><?php echo $friends_email[$i];?></div>
                                <div class="clearfix"></div>
                            </div>
                            <?php }?>
                            
						 </div>
                     <div class="send_request"><a href="javascript:send_invitation();">Send Request</a></div>
                     <div class="send_request"><a href="javascript:cancel_invite();">Cancel</a></div>
					</div>
					<div class="clearfix"></div>
				</div>
				
            </div>
            <!--Emd Frist Step-->
        </div>
    </div>
</div>
<div class="clearfix"></div>
<!-- End Body Area -->









<script>

function cancel_invite()
{
	window.location='<?php echo site_url("home");?>'
}

function send_invitation()
{
	
	var friends_email = "";
	var valid=1;
	
     $('#friends_email_area :checked').each(function() {
       friends_email=friends_email+"~"+$(this).val();
     });
	 
	 if(friends_email=="")
	 {
	 	message="No email id found.";
		valid=0;
	 }
	 
	if(valid==1)
	{
		var js={'friends_email':friends_email};

		$.post("<?php echo site_url("import/send_invitation");?>",js,function(data){
			if(data.result==0)
			{
				message="Sorry, no invitation has sent.";
			}
			else
			{
				//window.location='<?php echo site_url("home");?>'
				message=data.result + " invitation has been sent successfully.";
			}
			$("#message").html(message);
			//return false;
		},"json");
	}
	
	$("#message").html(message);
	//return false;
}

</script>

