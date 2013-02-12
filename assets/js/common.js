// JavaScript Document

//var site_url = 'http://asani1/evolvefinal/';   
var site_url = 'http://www.trackbee.com/evolvefinal/';

function open_messagebox(title, message)
{
	if(title.length<=0)
	{
		title = 'Alert';
	}
	$("#popup_title").html(title);
	$("#basic-modal-content").modal({escClose:false,focus:true,opacity :30});
	$("#pop_form_area").html(message);
}
	
	
	
function closeBox()
{
	$.modal.close();
}	




function trim11 (str) 
{
	str = str.replace(/^\s+/, '');
	for (var i = str.length - 1; i >= 0; i--) {
		if (/\S/.test(str.charAt(i))) {
			str = str.substring(0, i + 1);
			break;
		}
	}
	return str;
}

/*******Check if user logged in or not************/
function check_user_log_in()
{
	var result = $.ajax({
		async:false,
		cache:false,
		url: site_url+"login/check_login"
	}).responseText;	
	return result;
}

/**************************************************/


    

$(function() {

	//alert($("#body_html").html());
	
	$.ajax({
		cache:false,
		url: site_url+"login/check_login",
		success: function(result){
			if(result==0)
			{
				//fb_login_show();
				//google_login_show();
			}
			else
			{
			
				
				
				
				originalTitle = document.title;
				startChatSession();
			
				$([window, document]).blur(function(){
					windowFocus = false;
				}).focus(function(){
					windowFocus = true;
					document.title = originalTitle;
				});
				
				update_login_log()
			}
		}
	});
	
	$(".chat_header").mouseover(function() {
		if($(".chat_body").css('display')=='none')
			
			$(".chat_area").css("right","-100px");
			
			$.ajax({
				cache:false,
				url: site_url+'chat',
				success: function(data){
					
					$(".chat_icon_text").html(data)
					},
				  error: function (xhr, ajaxOptions, thrownError) {
					//alert(xhr.status);
					//alert(thrownError);
				  }
			
				});
	});
	
	$(".chat_header").mouseout(function() {
		
		if($(".chat_body").css('display')=='none')
		{
			$(".chat_area").css("right","-230px");
			$(".chat_body").hide();
		}
	});
	
	$(".chat_header").click(function() {
		
		if($(".chat_area").css("right")=="0px")
		{
			$(".chat_area").css("right","-230px");
			$("#friend_name").val('');
			
			$(".chat_body").hide();
			$(".new_request").hide();
		}		
		else
		{
			update_friend_request()
			$(".chat_area").css("right","0px");
			
				//alert(data.chat_area);
				$(".chat_body").show();
				
				
				
				
			$.ajax({
				cache:false,
				url: site_url+'chat/get_friend_list',
				success: function(data){
					
					$(".chat_box_area").html(data);
					},
				  error: function (xhr, ajaxOptions, thrownError) {
					//alert(xhr.status);
					//alert(thrownError);
				  }
			
				},"json");
			}
	});
	 
	
});


function show_retrive_password_form()
{
	var box = $('#body');
	
	$.ajax({
		cache:false,
		url: site_url+'login/retrive_password_form',
		success: function(data){
				
				box.html(data);
				$(".forgot_password").html('');
			}
		});
}

function search_friend()
{
	var friend_name		=$("#friend_name").val();
	var valid	= 1;
	var message ='';
	friend_name= $.trim(friend_name);

	if(friend_name=="")
	{
		message="Please enter friend name. ";
		valid=0;
	}
		
	if(valid==1)
	{
		$(".chatlist_area").hide('slow');
		$(".search_friend_result").show('slow');
		
		var js={'friend_name':friend_name};

		$.post(site_url+"chat/search_friend",js,function(data){

			$(".chat_box_area").html(data.friend_list_search_result);
			
			return false;
			
		},"json");
	}
	
	$(".chat_search_area_message").html(message);
	return false;
}

function close_chat_subfunction()
{
	$("#friend_name").val('');
	$.ajax({
		cache:false,
		url: site_url+'chat/get_friend_list',
		success: function(data){
			$(".chat_box_area").html(data);
			},
		  error: function (xhr, ajaxOptions, thrownError) {
			//alert(xhr.status);
			//alert(thrownError);
		  }
	
		},"json");
}

function invite_friends()
{
	window.location= site_url+'import'
}

function update_friend_status()
{
	if($(".chatlist_area").html()=='')
		$(".chatlist_area").html('Loading....');
	
	if($("#chat_friend_list").length==1){
	
	
	
	$.ajax({
		cache:false,
		url: site_url+'chat/get_friend_list',
		success: function(data){
			$(".chat_box_area").html(data);
			},
		  error: function (xhr, ajaxOptions, thrownError) {
			//alert(xhr.status);
			//alert(thrownError);
		  }
	
		},"json");
	}
}

function update_friend_request()
{
	$.ajax({
	cache:false,
	url: site_url+'chat/count_new_friend_request',
	success: function(data){
		if(data>0)
			{
				$(".new_request").show();
				$(".new_request").html(data);
			}
			else
			{
				$(".new_request").html('');
				$(".new_request").hide();
			}
		
		}
	});
	
	setTimeout("update_friend_request()",10000)
}

function show_friend_request()
{
	$.ajax({
		cache:false,
		url: site_url+'chat/get_friend_request',
		success: function(data){
			
			$(".chat_box_area").html(data);
			},
		  error: function (xhr, ajaxOptions, thrownError) {
			//alert(xhr.status);
			//alert(thrownError);
		  }
	
		},"json");
}

function show_input_option()
{
	$.ajax({
		cache:false,
		url: site_url+'chat/get_input_option',
		success: function(data){
			
			$(".chat_box_area").html(data);
			},
		  error: function (xhr, ajaxOptions, thrownError) {
			//alert(xhr.status);
			//alert(thrownError);
		  }
	
		},"json");
}

function allow_friend_request(friend_list_id)
{
	$.ajax({
	cache:false,
	url: site_url+'chat/allow_friend_request/'+friend_list_id,
	success: function(data){
		show_friend_request();
		update_friend_request();
			
		}
	});
}

function decline_friend_request(friend_list_id)
{
	$.ajax({
	cache:false,
	url: site_url+'chat/decline_friend_request/'+friend_list_id,
	success: function(data){
			show_friend_request();
			update_friend_request();
		}
	});
}



function change_status(chat_status)
{
	var status_img="";
	
	switch(chat_status)
	{
		case '1': 
			status_img="online.png"; 
			break;
		case '2': 
			status_img="away.png"; 
			break;
		case '3': 
			status_img="busy.png"; 
			break;
		case '4': 
			status_img="offline.png"; 
			break;
		default: 
			status_img="offline.png"; 
			break;
	}
	
	$("#my_chat_status").html(chat_status);
	$("#my_chat_status_img").attr('src',site_url+'/assets/images/'+status_img);
	
		
	$.ajax({
	cache:false,
	url: site_url+'chat/update_my_chatstatus/'+chat_status,
	success: function(data){
			update_friend_status();
		}
	});
}

function update_login_log()
{
	$.ajax({
		cache:false,
		url: site_url+"login/update_login_log",
		success: function(result){
			if(result==0)
				window.location= site_url+'logout'	
		
		}
	});
	setTimeout("update_login_log()",10000)
}
