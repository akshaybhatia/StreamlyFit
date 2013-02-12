

<div id="message"></div>
<div id="friends_email_area">
<?php for($i=0,$j=1;$i<count($friends_email);$i++,$j++){?>
<input type="checkbox" value="<?php echo $friends_email[$i];?>" checked="checked" /><?php echo $friends_email[$i];?><br />
<?php }?>

<input type="submit" name="submit" value="Send Request" onclick="send_invitation()" />


</div>

<script>
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
				window.location='<?php echo site_url("home");?>'
				message=data.result + " invitation has been sent successfully.";
			}
			$("#message").html(message);
			return false;
		},"json");
	}
	
	$("#message").html(message);
	return false;
}

</script>

