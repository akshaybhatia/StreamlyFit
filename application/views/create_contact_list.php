<div class="signup_body_area">
	<div class="body_main_area">
    		
            <div class="signup_main_area_center">
        	<!-- First Step -->
            <div class="signup_page_area">
            	<div class="signup_heading2">Create Invitation List</div>
                <div id="message" style=" color:#FF0000; padding-left:350px; padding-top:8px; font-weight:bold;"></div>
				<div class="signup_form_area">
					<div class="signup_leftbar"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/signup_women.png" alt="" /></div>
					<div class="signup_rightbar">
                    	<div class="add_contact"><a href="javascript:void(0);" onClick="add_new_contact();" style="margin-left:250px;"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/add_contact.png" alt="" /></a></div>
						 <div class="gmail_box_area" id="contacts">
                         	<input type="hidden" name="total_contacts" id="total_contacts" value="1" />
							<div class="gmail_friend_area" id="contact_div_1">
                            	<div class="gmail_friend_name_area gmail_friend_space">Contact Email:</div>
                                <div class="gmail_friend_name_area"><input type="text" name="contact_id_1" id="contact_id_1" class="input_border" /></div>
                                <div class="clearfix"></div>
                            </div>
						 </div>
                     <div class="send_request"><a href="javascript:submit_contact();">Send Invitation</a></div>
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

<script type="text/javascript">
function cancel_invite()
{
	window.location='<?php echo site_url("home");?>'
}
	//add new box for the contact list
	function add_new_contact()
	{
		var total_contacts = parseInt($('#total_contacts').val());
		var valid=1;
		//alert(total_contacts);
		
		total_contacts += 1;
		
		//alert(total_contacts);
		
		$.ajax({			
			url: "<?php echo $this->config->item('base_url'); ?>import/load_new_contact/"+total_contacts+"/",
			success: function(data){
				//alert(data);
				var myArray=new Array();
				var i=0;
				$("input[id^=contact_id_]").each(function(){
					myArray[i]=$(this).val();
					i=i+1;
				});
				//$("#sub_heading_area").html(data);
				var html = $('#contacts').html();
				html += data;
				$('#contacts').html(html);
				for(i=0,j=1;i<myArray.length;i++,j++)
				{
					$("#contact_id_"+j).val(myArray[i]);
				}
				
				
			}
		});
				
		$('#total_contacts').val(total_contacts);
		
	}
	
	function remove_contact(contact_num)
	{
		//alert(contact_num);
		var div_id = 'contact_div_'+contact_num;
		$('#'+div_id).remove();
		
		contact_num -= 1;
		//alert(contact_num);
		$('#total_contacts').val(contact_num);		
	}
	
	function submit_contact()
	{
		var total_contacts = parseInt($('#total_contacts').val());
		//alert(total_contacts);
		
		var friends_email = '';
		var email_id=''
		var valid=1;
		var message="";
		
		for(var i=1; i<=total_contacts; i++)
		{
			var div_id = 'contact_id_'+i;
			//alert(div_id);
			email_id=$('#'+div_id).val();
			
			if(email_id!='')
			{
				if(is_email(email_id))
					friends_email=friends_email+"~"+email_id;
			}
			
		}
		
		
		
		
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
					message="The email address you entered has already in our system.";
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