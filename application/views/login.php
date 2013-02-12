<?php
$attributes = array('id' => 'loginForm','onSubmit'=>'return submit_login();');
echo form_open('', $attributes);

?>
	
    <fieldset id="body">
    	<div id="message" style="float:left; font-size:11px; color:#FF0000; padding-left:0px; padding-top:0px; font-weight:bold;"></div>
        <br />
        <fieldset>
            <label for="email" style="text-align:left;">Email Address</label>
            <input type="text" name="email_id" id="email_id" />
        </fieldset>
        <fieldset>
            <label for="password" style="text-align:left;">Password</label>
            <input type="password" name="user_pwd" id="user_pwd" />
        </fieldset>
        <input type="hidden" name="refer_page" id="refer_page" value="<?php echo $refer_page; ?>" />
        <input type="submit" id="login" value="Sign in" />
        
        <div style="float:left; padding-top:7px;"><a href="<?php echo $facebook_url; ?>"><img id="fb_icon" src="<?php echo urldecode($fb_img_url); ?>" alt="Facebook" title="Facebook" style="cursor:pointer" /></a></div>
        <div style="float:left; padding-top:7px; padding-left:10px;"><a href="<?php echo $google_url;?>"><img id="gp_icon" src="<?php echo urldecode($g_img_url); ?>" alt="Google Plus" title="Google Plus" style="cursor:pointer" /></a></div>
        <div style="clear:both"></div>

    </fieldset>
	
    <font class="forgot_password"><p style="margin-top:5px; margin-bottom:5px; text-align:center;"><a href="javascript:show_retrive_password_form()">Forgot your password?</a></p></font>
<?php echo form_close();?>





<script>

$(document).ready(function(){
	$('#fb_icon').attr('src', '<?php echo urldecode($fb_img_url); ?>');
	$('#gp_icon').attr('src', '<?php echo urldecode($g_img_url); ?>');
});

function submit_login()
{
	var email_id		=$("#email_id").val();
	var user_pwd		=$("#user_pwd").val();
	
	var valid	= 1;
	var message	= "";
	var birthday="";
	email_id= $.trim(email_id);
	
	
	
	if(valid==1)
	{
		if(email_id=="")
		{
			message="Please enter a valid email id. ";
			valid=0;
		}
		else
		{
			if(!is_email(email_id))
			{
				message="Please check and enter a valid email.";
				valid=0;
			}
		}
	}
	
	
	if(valid==1)
	{
		if(user_pwd=="")
		{
			message="Password field cannot be blank.";
			valid=0;
		}
	}	
	
		
	if(valid==1)
	{
		var js={'email_id':email_id,'user_pwd':user_pwd};
		var refer_page = $('#refer_page').val();
		$.post("<?php echo site_url("login/get_login");?>",js,function(data){
			if(data.result==0)
			{
				message="Invalid login details.";
			}
			else if(data.result==1)
			{
				
				//window.location='<?php echo site_url("home");?>'
				if(refer_page=='<?php echo site_url("/signup");?>/')
					window.location='<?php echo site_url("home");?>'
				else
					window.location = refer_page;
			}
			else if(data.result==2)
			{
				message="Your account has been blocked by administrator.";
			}
			else if(data.result==4)
			{
				window.location='<?php echo site_url("signup/upgrade_membership");?>'
				
			}
			
			$("#message").html(message);
			return false;
			
		},"json");
	}
	
	$("#message").html(message);
	return false;
}

function is_email(emailaddressVal)
{
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if(!emailReg.test(emailaddressVal)) {
		return false;
	}
	else
	{
		return true;
	}
}
</script>