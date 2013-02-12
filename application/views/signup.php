<!-- Body Area -->

<script language="javascript">

 function show_div()
{
	$(".2nd_step").show('slow');
	$(".signup_page_area").hide(300);
}

</script>

<!--Show placeholder javascript-->
<script language="javascript">
	  function show_pass(id_show,id_hide)
		{
		  
		  $("#"+id_show).show();
		  $("#"+id_show).focus();
		  $("#"+id_hide).hide();
		}	
	 function show_txt(id_show,id_hide)
	 {
		  if($("#"+id_show).val()=="")
		{
		  $("#"+id_show).hide();
		  $("#"+id_hide).show(); 
		 // $("#"+id_hide).val(txt); 
		}
	 
	 }	
</script>
<!--Show placeholder javascript-->


<div class="signup_body_area">
	<div class="body_main_area">
    	<div class="signup_main_area_center">
        	
        	<!-- First Step -->            
           <div class="signup_page_area">
            	<div class="signup_heading2"> Not ready to sign up, that's OK, you can still give it a try....</div>
				<div class="signup_form_area">
					<div class="signup_leftbar"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/signup_women.png" alt="" /></div>
					<div class="signup_rightbar">
						<div class="step_one1">
                       		<div id="message" style="float:left; color:#FF0000; padding-left:350px; padding-top:8px; font-weight:bold;"></div>
                        	<div style="clear:both;"></div>
                        </div>
                        
						 <div class="f_m_area">
						 	<div class="face_area">
								<div class="facebook_button"><a href="<?php echo $facebook_url;?>"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/facebook_button.png" alt="" /></a></div>
								<div class="googleplus_button"><a href="<?php echo $google_url;?>"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/googleplus_button.png" alt="" /></a></div>
								<div class="social_text">It's fast and easy. We promise never to post anything without your permission.</div>
							</div>
							<div class="or_area"></div>
                           
                            <?php
							$attributes = array('id' => 'login_form','onSubmit'=>'return submit_signup();');
							echo form_open('', $attributes);
							?>
							<input type="hidden" name="inv_id" id="inv_id" value="<?php echo $inv_id;?>" />
							<input type="hidden" name="from_user_id" id="from_user_id" value="<?php echo $from_user_id;?>" />
							<input type="hidden" name="inv_token" id="inv_token" value="<?php echo $inv_token;?>" /> 
							<div class="form_area">
								<div class="input_area new_inputspace_area">
                             	   <input type="text" class="signup_input_area_border" value="" name="first_name" id="first_name" onblur="show_txt('first_name','txt_name')" style="display:none"   />
                                   <input type="text" class="signup_input_area_border" value="First Name" name="txt_name" id="txt_name" onfocus="show_pass('first_name','txt_name')" onclick="show_pass('first_name','txt_name')" />
                                </div>
                                
                                <div class="input_area new_inputspace_area">
                                	<input type="text" class="signup_input_area_border" value="" name="last_name" id="last_name" onblur="show_txt('last_name','txt_last_name')" style="display:none" />
                                    <input type="text" class="signup_input_area_border" value="Last Name" name="txt_last_name" id="txt_last_name" onfocus="show_pass('last_name','txt_last_name')" onclick="show_pass('last_name','txt_last_name')" />
                                 </div>
								<div class="input_area new_inputspace_area">
                                	<input type="text" class="signup_input_area_border" name="email_id_signup" id="email_id_signup" value="<?php echo $email_id;?>" onblur="show_txt('email_id_signup','txt_email_signup')" style="display:none" />
                                    <input type="text" class="signup_input_area_border" name="txt_email" id="txt_email_signup" value="Email"   onfocus="show_pass('email_id_signup','txt_email_signup')" onclick="show_pass('email_id_signup','txt_email_signup')" />
                                    
                                </div>
								<div class="input_area">
                                	<input type="password" class="signup_input_area_border" name="user_pwd_signup" id="user_pwd_signup" value="" onblur="show_txt('user_pwd_signup','txt_pass_signup')" style="display:none"  />
                                    <input type="text" class="signup_input_area_border" value="Password" name="txt_pass_signup" id="txt_pass_signup" onfocus="show_pass('user_pwd_signup','txt_pass_signup')" onclick="show_pass('user_pwd_signup','txt_pass_signup')"   />
                                </div>
                                <div class="input_area">
                                	<input type="password" class="signup_input_area_border" value="" name="conf_user_pwd" id="conf_user_pwd" onblur="show_txt('conf_user_pwd','text_retype')" style="display:none" />
                                    <input type="text" class="signup_input_area_border" value="Retype Password" name="text_retype" id="text_retype" onfocus="show_pass('conf_user_pwd','text_retype')" onclick="show_pass('conf_user_pwd','text_retype')" />
                                </div>
								<div class="signup_next_btn">
                                    <div class="already_member"><a href="javascript:open_login_form()">Already a member</a></div>
                                    <div style="float:right; padding-right:90px;"><input type="image" src="<?php echo $this->config->item('base_url'); ?>assets/images/next_btn1.png" /></div>
                                    <div class="clearfix"></div>
                                </div>
                                
                                
							</div>
                            
                            <?php echo form_close();?>
							<div class="clearfix"></div>
						 </div>
					</div>
					<div class="clearfix"></div>
				</div>
				
            </div>
            <!--Emd Frist Step-->
			
			<!-- 2nd Step -->
            <div class="2nd_step" style="display:none;">
            	<div class="signup_heading3">Complete access to all content for 30 Days Free!</div>
				<div class="signup_heading1">We will not charge your card for 30 days. If you change your mind cancel by: <br />
				<?php echo date('m-d-Y', strtotime("+30 days"));?> to never be charged. And, you can cancel anytime...</div>
               <div class="step_one">
               		<div id="message2" style="float:left; color:#FF0000; padding-left:350px; padding-top:8px; font-weight:bold;"></div>
                    <div style="clear:both;"></div>		
               </div>
				<!--<form action="<?php echo site_url('signup/save_payment_option')?>" method="post">-->
                <div class="signup_center">
                    <div class="signup_main_left_area" style="float:left;">
                        <div class="input_area inputspace_area2">
                        	<input type="text" class="input_area_border1" value=""  name="billing_addr_1" id="billing_addr_1" onblur="show_txt('billing_addr_1','text_billing1')" style="display:none" />
                            <input type="text" class="input_area_border1" value="Billing Address Line 1"  name="text_billing1" id="text_billing1" onfocus="show_pass('billing_addr_1','text_billing1')" onclick="show_pass('billing_addr_1','text_billing1')"/>
                            
                         </div>
                        <div class="input_area">
                            <input type="text" class="input_area_border1" value="" name="billing_addr_2" id="billing_addr_2" onblur="show_txt('billing_addr_2','text_billing2')" style="display:none" />
                            <input type="text" class="input_area_border1" value="Billing Address Line 2" name="text_billing2" id="text_billing2" onfocus="show_pass('billing_addr_2','text_billing2')" onclick="show_pass('billing_addr_2','text_billing2')"  />
                        </div>
                    </div>
                     <div class="signup_main_left_area" style="float:left;">
                        <div class="input_area inputspace_area2">
                            <input type="text" class="input_area_border1" value=""  name="city" id="city" onblur="show_txt('city','text_city')" style="display:none" />
                            <input type="text" class="input_area_border1" value="City" name="text_city" id="text_city" onfocus="show_pass('city','text_city')" onclick="show_pass('city','text_city')" />

                        </div>
                        <div class="input_area">
							
                            <input type="text" class="input_area_border1" value=""  id="state" name="state" onblur="show_txt('state','text_state')" style="display:none"  />
                            <input type="text" class="input_area_border1" value="State" id="text_state" name="text_state" onfocus="show_pass('state','text_state')" onclick="show_pass('state','text_state')" />

                        </div>
                    </div>
					<div class="clearfix"></div>
					<div style="height:7px"></div>
                    
					
                    <input type="text" class="city_fill1" value="" id="zip_code" name="zip_code" onblur="show_txt('zip_code','text_zip_code')" style="display:none" />
                    <input type="text" class="city_fill1" value="Zip Code" id="text_zip_code" name="text_zip_code" onfocus="show_pass('zip_code','text_zip_code')" onclick="show_pass('zip_code','text_zip_code')" />

                   <!-- <input type="text" class="city_fill1" value="" id="country" name="country" onblur="show_txt('country','text_country')" style="display:none" />
                    <input type="text" class="city_fill1" value="Country" id="text_country" name="text_country" onfocus="show_pass('country','text_country')" onclick="show_pass('country','text_country')"  />
					-->
					<select class="country_area" name="country" id="country">
								<option value="">Country </option>
                               	<option value="US">USA</option>
								<option value="CA">CANADA</option>
                    </select>
                    <input type="text" class="phone_area" value="" id="phone_no" name="phone_no" onblur="show_txt('phone_no','text_phone_no')" style="display:none"/>
                    <input type="text" class="phone_area" value="Phone" id="text_phone_no" name="text_phone_no" onfocus="show_pass('phone_no','text_phone_no')" onclick="show_pass('phone_no','text_phone_no')" />

					<div class="clearfix"></div>
					<div style="height:7px"></div>
					<!--<div class="signup_main_form_area">
						<div class="signup_main_form_area_left_new">
							<input type="text" class="card_number_fill1" value="" id="card_no" name="card_no" onblur="show_txt('card_no','text_card_no')" style="display:none; width:192px;" maxlength="16" />
                            <input type="text" style="width:192px;" class="card_number_fill1" value="Card Number" id="text_card_no" name="text_card_no" onfocus="show_pass('card_no','text_card_no')" onclick="show_pass('card_no','text_card_no')"   />
                        </div>
						<div class="clearfix"></div>
					</div>-->
					<div class="signup_main_form_area" style="margin-top:10px;">
                    	<div style="width:202px; float:left;">
                            <input type="text" class="card_number_fill1" value="" id="card_no" name="card_no" onblur="show_txt('card_no','text_card_no')" style="display:none; width:192px;" maxlength="16" />
                            <input type="text" style="width:192px;" class="card_number_fill1" value="Card Number" id="text_card_no" name="text_card_no" onfocus="show_pass('card_no','text_card_no')" onclick="show_pass('card_no','text_card_no')"   />
                        </div>
						<div class="signup_col" style="margin-left:10px;">
							<select name="exp_month" id="exp_month" class="month_area_new">
								<option value="">Month</option>
                                <option value="01">Jan</option>
                                <option value="02">Feb</option>
                                <option value="03">Mar</option>
                                <option value="04">Apr</option>
                                <option value="05">May</option>
                                <option value="06">Jun</option>
                                <option value="07">Jul</option>
                                <option value="08">Aug</option>
                                <option value="09">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
							</select>
						</div>
						<div class="signup_col">
							<select name="exp_year" id="exp_year" class="month_area_new">
								<option value="">Year</option>
                                <?php for($i=date("Y");$i<=date("Y")+10;$i++){?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php }?>
							</select>
						</div>
						<div style="float:left;">
							<input type="text" class="city_fill1_new" value="" id="sec_code" name="sec_code" onblur="show_txt('sec_code','text_sec_code')" style="display:none" maxlength="4" />
                            <input type="text" class="city_fill1_new" value="Security Code" id="text_sec_code" name="text_sec_code"  onfocus="show_pass('sec_code','text_sec_code')" onclick="show_pass('sec_code','text_sec_code')"   />
						</div>
						<div class="clearfix"></div>
                        
					</div>
					<div class="signup_main_form_area" style="margin-top:10px;">
						<div class="signup_col" style="padding-top:3px;"><input type="checkbox" value="" name="terms_conditions" id="terms_conditions" /></div>
						<div class="terms_conditions">I agree to <a href="#">Terms & Conditions</a></div>
						<div style="float:left; margin-right:10px; padding-top:3px;"><input type="checkbox" value="" name="health_waiver" id="health_waiver" /></div>
						<div class="terms_conditions">I agree to the <a href="#">Health Waiver</a></div>
						<div class="clearfix"></div>
					</div>
                    <div class="clearfix"></div>
                    <div class="next_btn1"><input type="image"   src="<?php echo $this->config->item('base_url'); ?>assets/images/submit_btn.png" align="right" onclick="submit_payment_option()" /></div>
               <!-- </form>-->
                </div>
                
            </div>
            <!--Emd 2nd Step-->
            
            
			
        </div>
    </div>
</div>
<div class="clearfix"></div>
<!-- End Body Area -->



<script>

function submit_payment_option()
{
	
	
	var billing_addr_1	=$("#billing_addr_1").val();
	var billing_addr_2	=$("#billing_addr_2").val();
	var country			=$("#country").val();
	var state			=$("#state").val();
	var city			=$("#city").val();
	
	var zip_code		=$("#zip_code").val();
	var phone_no		=$("#phone_no").val();
	//var card_type_id	=$("#card_type_id").val();
	var card_no			=$("#card_no").val();
	var exp_month		=$("#exp_month").val();
	var exp_year		=$("#exp_year").val();
	var sec_code		=$("#sec_code").val();
	
	var valid	= 1;
	var message	= "";
	billing_addr_1= $.trim(billing_addr_1);
	billing_addr_2= $.trim(billing_addr_2);
	
	
	
	
	if(billing_addr_1=="" && valid==1)
	{
	   	message="Billing address 1 field cannot be blank.";
		valid=0;
	}
	
	if(country=="" && valid==1)
	{
	   	message="Country field cannot be blank.";
		valid=0;
	}
	
	if(state=="" && valid==1)
	{
	   	message="State field cannot be blank.";
		valid=0;
	}
	
	if(city=="" && valid==1)
	{
	   	message="City field cannot be blank.";
		valid=0;
	}
	
	if(zip_code=="" && valid==1)
	{
	   	message="Zip code field cannot be blank.";
		valid=0;
	}
	
	if(!isNumeric(zip_code) && valid==1)
	{
	   	message="Please enter valid zip code.";
		valid=0;
	}
	
	if(phone_no=="" && valid==1)
	{
	   	message="Phone no. field cannot be blank.";
		valid=0;
	}
	
	if(!isNumeric(phone_no) && valid==1)
	{
	   	message="Please enter valid phone no.";
		valid=0;
	}
	/*if(card_type_id=="" && valid==1)
	{
	   	message="Card type field cannot be blank.";
		valid=0;
	}*/
	
	if(valid==1)
	{
		if(card_no=="")
		{
			message="Card number field cannot be blank.";
			valid=0;
		}
		else
		{
			if(!isCreditCard(card_no))
			{
				message="Please enter valid card number.";
				valid=0;
			}
		}
	}
	
	if(exp_month=="" && valid==1)
	{
	   	message="Month field cannot be blank.";
		valid=0;
	}
	
	if(exp_year=="" && valid==1)
	{
	   	message="Year field cannot be blank.";
		valid=0;
	}
	
	
	if(valid==1)
	{
		if(sec_code=="")
		{
			message="Security code field cannot be blank.";
			valid=0;
		}
		else
		{
			if(!isNumeric(sec_code))
			{
				message="Please enter valid security code.";
				valid=0;
			}
		}
	}
	
	
	
	if(!$('#terms_conditions').is(':checked') && valid==1)
	{
		message="Please confirm that you are agree to Terms & Conditions.";
		valid=0;
	}
	
	if(!$('#health_waiver').is(':checked') && valid==1)
	{
		message="Please confirm that you are agree to the health waiver.";
		valid=0;
	}
	
	
	
	if(valid==1)
	{
		var js={'billing_addr_1':billing_addr_1,'billing_addr_2':billing_addr_2,'country':country,'state':state,'city':city,'zip_code':zip_code,'phone_no':phone_no,'card_no':card_no,'exp_month':exp_month,'exp_year':exp_year,'sec_code':sec_code};
	
		
		$.post("<?php echo site_url("signup/save_payment_option");?>",js,function(data){
			//alert(data);
			if(data.result==0)
			{
				message="Sorry! But your card is not processed!";
			}
			else
			{
				window.location='<?php echo site_url("signup/success_signup");?>'
			}
			$("#message2").html(message);
			//return false;
		},"json");
	}
	
	$("#message2").html(message);
	//return false;
	
	
}
function submit_signup()
{
	//show_div();
	//return false;
	
	
	var from_user_id	=$("#from_user_id").val();
	var inv_token		=$("#inv_token").val();
	var email_id		=$("#email_id_signup").val();
	var user_pwd_signup	=$("#user_pwd_signup").val();
	var conf_user_pwd	=$("#conf_user_pwd").val();
	
	var first_name		=$("#first_name").val();
	var last_name		=$("#last_name").val();
	
	var valid	= 1;
	var message	= "";
	var birthday="";
	//email_id= $.trim(email_id_signup);
	
	//alert(user_pwd_signup);
	
	if(first_name=="" && valid==1)
	{
	   	message="First name field cannot be blank.";
		valid=0;
	}
	
	if(last_name=="" && valid==1)
	{
	   	message="Last name field cannot be blank.";
		valid=0;
	}
	
	
	if(valid==1)
	{
		if(email_id=="")
		{
			message="Email id field cannot be blank. ";
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
		if(user_pwd_signup=="")
		{
			message="Password field cannot be blank.";
			valid=0;
		}
		else
		{
			if($("#user_pwd_signup").val().length<8)
			{
				message="Password should be greater than 8 character.";
				valid=0;
			}
			else
			{
				if(user_pwd_signup != conf_user_pwd)
				{
					message="Please retype confirm password.";
					valid=0;
				}	
			}
		}
	}	
	
	
	
	
	if(valid==1)
	{
		var js={'from_user_id':from_user_id,'inv_token':inv_token,'email_id':email_id,'user_pwd':user_pwd_signup,'first_name':first_name,'last_name':last_name};

		$.post("<?php echo site_url("signup/get_signup");?>",js,function(data){
			
			if(data.result==0)
			{
				message="The email id which you have provided that has been already registered.";
			}
			else
			{
				show_div();
				//window.location='<?php echo site_url("signup/success_signup");?>'
				//message="Data has been saved successfully.";
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

function isCreditCard( CC )
 {                        
      if (CC.length > 19)
           return (false);

      sum = 0; mul = 1; l = CC.length;
      for (i = 0; i < l; i++)
      {
           digit = CC.substring(l-i-1,l-i);
           tproduct = parseInt(digit ,10)*mul;
           if (tproduct >= 10)
                sum += (tproduct % 10) + 1;
           else
                sum += tproduct;
           if (mul == 1)
                mul++;
           else
                mul--;
      }
	  
      if ((sum % 10) == 0)
           return (true);
      else
           return (false);
 }


function isPhoneNumber(PP)
{
var regEx = /^(\+\d)*\s*(\(\d{3}\)\s*)*\d{3}(-{0,1}|\s{0,1})\d{2}(-{0,1}|\s{0,1})\d{2}$/;
$("#call_form").bind("submit", function() {
       var val = PP;
       if (!val.match(regEx))
            return false;
		else
			return true;
});
}

function isNumeric(val)
{
	if(val.match('^(0|[1-9][0-9]*)$'))
		return true;
	else
		return false;

}


</script>