<div id="message"></div>
<div>
Email id :<input type="text" name="email_id" id="email_id" />
</div>

<div id="err_email_id"></div>

<div>
Password :<input type="text" name="user_pwd" id="user_pwd" />
</div>
<div id="err_password_id"></div>

<div>
Confirm Password :<input type="text" name="conf_user_pwd" id="conf_user_pwd" />
</div>

<div>
Name :<input type="text" name="user_name" id="user_name" />
</div>
<!--<div>
First Name :<input type="text" name="first_name" id="first_name" />Last Name :<input type="text" name="last_name" id="last_name" />
</div>-->

<!--<div>
Screen Name :<input type="text" name="screen_name" id="screen_name" />
</div>-->

<!--<div>
Gender :<select name="gender" id="gender">
			<option value="M">Male</option>
            <option value="F">Female</option>
		</select>
</div>

<div>
Birthday :
<select name="dob_dd" id="dob_dd">
	<option value="0" selected="selected">Day</option>
	<?php for($i=1;$i<=31;$i++){?>
    <option value="<?php echo $i;?>"><?php echo $i;?></option>
    <?php }?>
</select>

<select name="dob_mm" id="dob_mm">
	<option value="0" selected="selected">Month</option>
    <option value="1">January</option>
    <option value="2">February</option>
    <option value="3" >March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
</select>
<select name="dob_yy" id="dob_yy">
	<option value="0" selected="selected">Year</option>
	<?php for($i=date("Y");$i>=1960;$i--){?>
    <option value="<?php echo $i;?>"><?php echo $i;?></option>
    <?php }?>
</select>

</div>-->

<div>
<input type="submit" name="submit" value="Save" onclick="submit_signup()" />
</div>

<script>


function submit_signup()
{
	var email_id		=$("#email_id").val();
	var user_pwd		=$("#user_pwd").val();
	var conf_user_pwd	=$("#conf_user_pwd").val();
	
	/*var first_name		=$("#first_name").val();
	var last_name		=$("#last_name").val();*/
	var screen_name		=$("#screen_name").val();
	/*var gender			=$("#gender").val();
	
	var dob_dd			=$("#dob_dd").val();
	var dob_mm			=$("#dob_mm").val();
	var dob_yy			=$("#dob_yy").val();*/
	
	
	
	var valid	= 1;
	var message	= "";
	var birthday="";
	email_id= $.trim(email_id);
	
	
	
	if(valid==1)
	{
		if(email_id=="")
		{
			message="Email id field cannot be blank. Please enter a valid email id. ";
			valid=0;
		}
		else
		{
			if(!is_email(email_id))
			{
				message="This is an invalid email id. Please check and enter a valid email.";
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
		else
		{
			if($("#user_pwd").val().length<8)
			{
				message="Password should be greater than 8 character.";
				valid=0;
			}
			else
			{
				if(user_pwd != conf_user_pwd)
				{
					message="Please retype confirm password.";
					valid=0;
				}	
			}
		}
	}	
	
		
	/*if(first_name=="" && valid==1)
	{
	   	message="First name field cannot be blank.";
		valid=0;
	}
	
	if(last_name=="" && valid==1)
	{
	   	message="Last name field cannot be blank.";
		valid=0;
	}*/
	
	if(screen_name=="" && valid==1)
	{
	   	message="Screen name field cannot be blank.";
		valid=0;
	}
	
	
	/*if((dob_dd==0 || dob_mm==0 || dob_yy==0) && valid==1)
	{
		message="Birthdate field cannot be blank.";
		valid=0;
	}
	else
	{
		birthday=dob_yy+"-"+dob_mm+"-"+dob_dd;
	}
	
	if(gender=='' && valid==1)
	{
		message="Gender field cannot be blank.";
		valid=0;
	}*/
	
	if(valid==1)
	{
		var js={'email_id':email_id,'user_pwd':user_pwd,'first_name':first_name,'last_name':last_name,'screen_name':screen_name,'gender':gender,'birthday':birthday};

		$.post("<?php echo site_url("signup/get_signup");?>",js,function(data){
			
			if(data.result==0)
			{
				message="The email id which you have provided that has been already registered.";
			}
			else if(data.result==1)
			{
				message="Data has been saved successfully.";
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