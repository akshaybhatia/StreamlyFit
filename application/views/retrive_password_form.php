<?php
$attributes = array('id' => 'retrivePasswordForm','onSubmit'=>'return retrive_password();');
echo form_open('', $attributes);
?>
	
		<div style="float:left; color:#999999; font-weight:bold">Retrive Password</div>
        <br />
    	<div id="message" style="float:left; text-align:left; font-size:12px; padding-top:5px; color:#FF0000; padding-left:0px; padding-top:0px; font-weight:bold;"></div>
        <br /><br />
        <fieldset>
            <label for="email" style="text-align:left;">Email Address</label>
            <input type="text" name="email_id" id="email_id" />
        </fieldset>
        <input type="hidden" name="refer_page" id="refer_page" value="<?php echo $refer_page; ?>" />
        <input type="submit" id="login" value="Retrive" />
	
    
	
    
<?php echo form_close();?>





<script>


function retrive_password()
{
	var email_id		=$("#email_id").val();
	
	
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
		var js={'email_id':email_id};
		var refer_page = $('#refer_page').val();
		$.post("<?php echo site_url("login/retrive_password");?>",js,function(data){
			message=data.result;
			
			
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