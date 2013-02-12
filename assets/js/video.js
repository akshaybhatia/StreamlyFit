// JavaScript Document

/************VIDEO LIST ************/
//load the video list page in home page
function load_home_video_list(site_url)
{
	
	 //alert('aa');
	$.ajax({
		cache: false,
		url: site_url+"video/video_list/",
		success: function(data){
			//alert(data);
			//open_messagebox("Health Waiver Form", data);
			var listing = data+'<div class="clearfix"></div>';
			$('#home_video_list').html('');
			$('#home_video_list').html(listing);
		}
		
	});
}

/****************VIDEO PLAY SECTION ******************/

//open video health waiver form
function open_waiver_form(site_url, video_id){
	$.ajax({
		cache: false,
		url: site_url+"video/video_waiver",
		type: "POST",
		data: "video_id="+video_id,
		success: function(data){
			//alert(data);
			open_messagebox("Health Waiver Form", data);
		}
		
	});
}

//redirect from the health waiver form
function redirect_from_waiver_form(site_url)
{	
	if ($('#accept_terms').is(':checked'))
	{
		var video_id = $('#terms_video_id').val();
		//alert(video_id);
		$.ajax({
			cache: false,
			url: site_url+"myaccount/user_update_health_waiver_status/",			
			success: function(data){
				//alert(data);
				window.location = site_url+'video/play_option/'+video_id+'/';		
			}
		});
				
	}else{
		//alert('Please accept our terms & conditions!');
		open_messagebox("Alert", "Please accept our terms & conditions!");
		
	}
}

//redirect from play option
function redirect_from_play_option(site_url, video_id, play_option)
{
	//alert(video_id+' '+play_option);
	
	//exit(0);
	if (play_option!='WF'){
		$('#play_option_select').val(play_option);
		//alert($('#play_option_select').val());
		//alert($('#action').val());
		//alert($('#video_id').val());
		//alert('Redirect To Play Option Form');
		$('#play_option_form').submit();
		//window.location = site_url+'video/play/'+video_id+'/'+play_option+'/';
	}else{
		display_buddy_list(site_url, video_id, $('#view_type').val());	
	}
}

//open form to select buddy list
function display_buddy_list(site_url, video_id, view_type)
{
	$.ajax({
		cache: false,
		url: site_url+"video/get_buddy_list_popup",
		type: "POST",
		data: "video_id="+video_id+"&view_type="+view_type,
		success: function(data){
			//alert(data);
			open_messagebox("Choose Buddy", data);
		}
		
	});
}

//redirect from buddy list in play option
function redirect_from_choose_friend(site_url)
{
	//if ($('input:radio[name=friend_id]:checked')){	
	
	if ($("input[@name=friend_id]:checked").val()>0){
		//alert($("input[@name=friend_id]:checked").val());
		$('#buddy_id').val($("input[@name=friend_id]:checked").val());
		//alert($('#play_option_select_friend').val());
		//alert($('#action').val());
		//alert($('#buddy_video_id').val());
		//alert($('#buddy_id').val());
		//alert('Redirect To Play Option Form Friend');
		$('#play_option_friend').submit();
		//window.location = site_url+'video/play/'+$('#buddy_video_id').val()+'/WF/'+$("input[@name=friend_id]:checked").val()+'/';
	}else{
		//alert('Please select a buddy to view the video');	
		open_messagebox("Alert", "Please select a buddy to view the video");
	}
	/*if ($('input:radio[name=friend_id]:checked') != "undefined" && $('input:radio[name=friend_id]:checked')){
		//window.location = site_url+'video/play/'+video_id+'/WF/';
		//alert($('input:radio[name=friend_id]:checked').val());
		alert('checked');
	}else{
		alert('Please select a buddy to view the video');	
	}*/
	
}

//fetch buddy list
function get_buddy_list(site_url, video_id, view_id)
{	
	$.ajax({
		cache:false,
		url: site_url+"video/load_buddy_list/"+video_id+"/"+view_id+"/",				
		success: function(data){			
			$('#buddy_list').html(data);
		}
	});	
	setTimeout("get_buddy_list('"+site_url+"', '"+video_id+"', '"+view_id+"')",10000);
}

//send video inivitation to user
function send_video_invitation(site_url, video_id, view_id, friend_id)
{
	//alert('send invite');
	$.ajax({
		cache:false,
		url: site_url+"video/invite_buddy/"+view_id+"/"+friend_id+"/",				
		success: function(data){			
			//$('#buddy_list').html(data);
			//alert(data);
			if (data==1){
				alert('Video Invitation Sent');	
			}else{
				alert('Video Invitation Couldnot Be Sent');
			}
		}
	});
}

//alert if buddy is offline
function buddy_offline_alert(buddy_name)
{
	alert(buddy_name+' is offline');
}

//function to check the video invitation
function check_video_invites(site_url)
{
	//alert(site_url);
	$.ajax({
		cache:false,
		url: site_url+"video/check_invites/",				
		success: function(data){
			//alert(data.length);
			//$('#video_invites').html(data);
			if ($.trim(data)!=0){
				open_messagebox("Video Invitation", data);
			}
		}
	});
	setTimeout("check_video_invites('"+site_url+"')", 10000);
}

//function to check the video invitation accepted or declined
function check_invites_notification(site_url)
{
	//alert(site_url);
	$.ajax({
		cache:false,
		url: site_url+"video/sender_notification/",
		dataType: 'json',
		success: function(data){
			//alert(data.length);
			//$('#video_invites').html(data);
			if (data.result!=0)
			{
				open_messagebox("Alert", 'Video invitation accepted by '+data.screen_name);
				update_sender_notification(site_url, data.view_id);
			}
		}
	});
	setTimeout("check_invites_notification('"+site_url+"')", 10000);
}

//function to uncheck the sender notification after the sender is notified
function update_sender_notification(site_url, view_id)
{
	$.ajax({
		cache:false,
		url: site_url+"video/update_sender_notification/",
		type: 'GET',
		data: 'view_id='+view_id,
		success: function(data){
			
		}
	});
}

function accept_video_request(site_url, view_id)
{
	//alert(view_id);
	$.ajax({
		cache:false,
		url: site_url+"video/accept_video_request/"+view_id+"/",				
		success: function(data){
			//alert(data);
			//$('#video_invites').html(data);
			location.href = site_url+'video/invite/'+view_id+'/';
		}
	});
}

//discard the video invitation
function decline_video_request(site_url, view_id)
{
	$.ajax({
		cache:false,
		url: site_url+"video/decline_video_request/"+view_id+"/",				
		success: function(data){
			$('#video_invite_'+view_id).fadeOut('slow');
			//alert(data);
			//$('#video_invites').html(data);
			//location.href = site_url+'video/invite/'+view_id+'/';
		}
	});
}


/***********VIDEO PLAYLIST SECTION***************/

//redirect from the playlist option
function redirect_to_play_option(site_url, playlist_id)
{
	window.location.href = site_url+'video/play_option/'+playlist_id+'/playlist/';
}

//create a new playlist
function create_new_playlist(site_url)
{
	$.ajax({
		cache: false,
		url: site_url+"video/create_new_playlist/",		
		type: 'GET',
		data: '',
		success: function(data){
			//alert(data);
			//location.reload(true);
			/*if (call=='redirect'){
				window.location=site_url+"home/index/playlist";
			}*/
			
			$('#user_playlist_section').html(data);			
			$('#playlist_title').css('display', 'none');
			$('#playlist_caption').val('');
			$('#playlist_title_save').css('display', 'block');	
			$('#playlist_save_button').css('display', 'block');
			$('#playlist_cancel_button').css('display', 'none');
			$('#playlist_rename_button').css('display', 'none');
			$('#create_new_playlist_span').css('display', 'none');
			var js = 'submit_save_playlist_form("'+site_url+'")';
			$('#playlist_save_link').attr('onclick', js);			
			$('#total_videos').val(0);
			$('#count_video').html(0);
			$('#video_duration').html('00:00:00');
			$('#playlist_controls').css('display', 'none');
		}
	});	
}


//load videos from playlist
function load_video_playlist(site_url, playlist_id)
{	
	if (playlist_id!=0){
		$.ajax({
			cache:false,
			url: site_url+"video/load_playlist/"+playlist_id+"/",
			success: function(data){
				//alert(data);
				$('#playlist_video').html(data);
			}
		});
	}else{
		$('#playlist_video').html('Please select a playlist.');
	}
}

//load videos from playlist
function load_video_playlist2(site_url, playlist_id)
{	
	if (playlist_id!=0){
		$.ajax({
			cache:false,
			url: site_url+"video/load_playlist2/"+playlist_id+"/",
			success: function(data){
				//alert(data);
				//$('#playlist_video').html(data);
				$('#playlist_video_display').html(data);
				$('#playlist_id').val(playlist_id);
				$('#playlist_type').val('playlist');
				
			}
		});
	}else{
		$('#playlist_video_display').html('Please select a playlist.');
	}
}

//loads the selected video from the playlist
function play_video_playlist(site_url, video_id)
{	
	$.ajax({
		cache:false,
		url: site_url+"video/playlist_video/"+video_id+"/",				
		success: function(data){
			//alert(data);
			$('#video_play').html(data);
		}
	});	
}

//function to get the total video duration
function get_video_duration()
{
	var result = $.ajax({
		async:false,
		cache:false,
		type: "GET",
		data: "",
		dataType: "json",
		url: site_url+"video/video_duration/"		
	}).responseText;
	
	//alert(result);
	return result;	
}

//function to add videos to playlist
function add_video_playlist(site_url, video_id, sort_order)
{
	var playlist_id = $('#playlist_id').val();
	var playlist_type = $('#playlist_type').val();
	
	//alert(video_id+' '+playlist_id+' '+playlist_type+' '+sort_order);
	
	/*$.ajax({
		cache:false,
		type: "GET",
		data: "video_id="+video_id+"&playlist_id="+playlist_id+"&playlist_type="+playlist_type,
		dataType: "json",
		url: site_url+"video/add_video_playlist/",
		success: function(data){			
			if (data.result==0)
			{
				alert(data.msg);	
			}else{
				//alert(data.form);
			}
			$('#playlist_video_display').html(data.form);			
		}
	});*/
	
	var result = $.ajax({
		async:false,
		cache:false,
		type: "GET",
		data: "video_id="+video_id+"&playlist_id="+playlist_id+"&playlist_type="+playlist_type+"&sort_order="+sort_order,
		dataType: "json",
		url: site_url+"video/add_video_playlist/"		
	}).responseText;
	
	//alert(result);
	return result;
}

//function to display the add to playlist option
function add_video_to_playlist_option(site_url, option, video_id, sort_order)
{
	var playlist_id = $('#playlist_id').val();
	var playlist_type = $('#playlist_type').val();
	
	if (option=='display')
	{
		var disp = $.ajax({
			async:false,
			cache:false,
			type: "POST",
			data: "video_id="+video_id+"&playlist_id="+playlist_id+"&playlist_type="+playlist_type+"&sort_order="+sort_order,
			dataType: "json",
			url: site_url+"video/add_video_playlist_option/"		
		}).responseText;
		open_messagebox("Confirm Video Addition", disp);
		return 0;
	}
}

//function to add the video if user chooses yes
function add_video_playlist_anyway(site_url)
{
	var video_id = $('#add_video_id').val();
	var playlist_id = $('#add_playlist_id').val();
	var playlist_type = $('#add_playlist_type').val();
	var sort_order = $('#add_sort_order').val();
	//alert('Add Anyway');
	
	$.ajax({
		cache:false,
		type: "GET",
		data: "video_id="+video_id+"&playlist_id="+playlist_id+"&playlist_type="+playlist_type+"&sort_order="+sort_order,
		dataType: "json",
		url: site_url+"video/add_video_playlist_override/",
		success: function(data){
			var hours, mins, sec;
			var total_videos = parseInt($('#total_videos').val());
			total_videos = total_videos + 1;
			
			if (total_videos>0 && $('#playlist_type').val()=='current')
			{
				//alert(total_videos+' '+$('#playlist_type').val());
				if (check_user_log_in()==1){
					$('#playlist_save_button').css('display', 'block');
					open_save_current_playlist_form(site_url);
				}
			}
			
			var duration = json_decode(get_video_duration());			
			
			if (duration['h']<=9){
				hours = '0'+duration['h'];
			}else{
				hours = duration['h'];
			}
			if (duration['m']<=9){
				mins = '0'+duration['m'];
			}else{
				mins = duration['m'];
			}
			
			if (duration['s']<=9){
				sec = '0'+duration['s'];
			}else{
				sec = duration['s'];
			}
			
			//alert(duration['h'].length+' '+duration['m'].length+' '+duration['s']);			
			//alert(hours+' '+mins+' '+sec);
			
			$('#video_duration').html(hours+":"+mins+":"+sec);
			
			if (data.total_videos>1 || data.total_videos==0)
			{
				var span_video = ' Videos';	
			}else{
				var span_video = ' Video';	
			}
			$('#total_videos').val(data.total_videos);
			$('#count_video').html(data.total_videos+span_video);
			//alert(data.play_link);
			var div = data.play_link+'<img src="'+site_url+'assets/uploads/video/'+data.data.video_image+'" height="89" width="136" />'+'</a></div></div>';
			$('#sort_order_'+sort_order).html(div);
			
			//closeBox();
			
			
			//alert(playlist_type);
			if (playlist_type=='playlist')
			{
				open_messagebox("Alert", "Video added to playlist!");
			}else if (playlist_type=='current'){
				open_messagebox("Alert", "Video added to current playlist!");
			}
			setTimeout("closeBox()", 2000);
			
			//$('#playlist_video_display').html(data.form);			
		}
	});
}

//function to close popup if user chooses no
function close_video_playlist_anyway()
{
	closeBox();
}

//function to add video to playlist by manual override even if the video exist in the playlist
function add_video_playlist_override(site_url, video_id, sort_order)
{
	var playlist_id = $('#playlist_id').val();
	var playlist_type = $('#playlist_type').val();
	
	//alert(video_id+' '+playlist_id+' '+playlist_type+' '+sort_order);		
	
	var result = $.ajax({
		async:false,
		cache:false,
		type: "GET",
		data: "video_id="+video_id+"&playlist_id="+playlist_id+"&playlist_type="+playlist_type+"&sort_order="+sort_order,
		dataType: "json",
		url: site_url+"video/add_video_playlist_override/"		
	}).responseText;
	
	//alert(result);
	return result;
}

//function to display current playlist videos
function display_current_playlist(site_url)
{
	$.ajax({
		cache:false,
		type: "GET",
		data: "",
		dataType: "json",
		url: site_url+"video/disp_current_playlist/",
		success: function(data){			
			$('#playlist_video_display').html(data.form);			
		}
	});
}

//to remove a video from playlist
function remove_video_playlist(site_url, video_id)
{
	var playlist_id = $('#playlist_id').val();
	var playlist_type = $('#playlist_type').val();
	
	//alert(video_id+' '+playlist_id+' '+playlist_type);
	
	$.ajax({
		cache:false,
		type: "GET",
		data: "playlist_id="+playlist_id+"&playlist_type="+playlist_type+"&video_id="+video_id,
		dataType: "json",
		url: site_url+"video/remove_video_playlist/",
		success: function(data){
			//alert(json_decode(data.video_ids));
			//$('#playlist_video_display').html(data.form);	
			display_current_playlist(site_url);
			
			/*if ($('#playlist_play_video_id').val()==video_id){
				$('#video_play').html('play');	
			}*/
		}
	});
	
}

//to remove a video from playlist
function remove_video_current_playlist(site_url, video_id, sort_order)
{
	var playlist_id = $('#playlist_id').val();
	var playlist_type = $('#playlist_type').val();
	
	//alert(video_id+' '+playlist_id+' '+playlist_type+' '+sort_order);
	
	$.ajax({
		cache:false,
		type: "GET",
		data: "playlist_id="+playlist_id+"&playlist_type="+playlist_type+"&video_id="+video_id+"&sort_order="+sort_order,
		dataType: "json",
		url: site_url+"video/remove_video_current_playlist/",
		success: function(data){
			//alert(data);
			//$('#playlist_video_display').html(data.form);	
			var hours, mins, sec;
			var total_videos = parseInt($('#total_videos').val());
			total_videos = total_videos - 1;
			
			if (data>1 || data==0)
			{
				var span_video = ' Videos';	
			}else{
				var span_video = ' Video';	
			}
			
			$('#total_videos').val(data);
			$('#count_video').html(data+span_video);
			
			var duration = json_decode(get_video_duration());
			if (duration['h']<=9){
				hours = '0'+duration['h'];
			}else{
				hours = duration['h'];
			}
			if (duration['m']<=9){
				mins = '0'+duration['m'];
			}else{
				mins = duration['m'];
			}
			
			if (duration['s']<=9){
				sec = '0'+duration['s'];
			}else{
				sec = duration['s'];
			}
			
			$('#video_duration').html(hours+":"+mins+":"+sec);
			
			var temp_sort = parseInt(sort_order)+1;
			
			$('#sort_order_'+sort_order).html('<p class="text_top_space">drop video <br>'+temp_sort+' here</p>');
			if (data<=0 && playlist_type=='current')
			{
				//alert(data);
				$('#create_new_playlist_span').css('display', 'none');
				$('#playlist_save_button').css('display', 'none');
				cancel_save_current_playlist_form(site_url);				
				$('#playlist_controls').css('display', 'none');
			}
			
			if (playlist_type=='playlist')
			{
				open_messagebox("Alert", "Video removed from playlist!");
			}else if (playlist_type=='current'){
				open_messagebox("Alert", "Video removed from current playlist!");
			}
			setTimeout("closeBox()", 2000);
			//location.reload(true);
		}
	});
	
}

//open playlist save option before submitting the form
function open_save_current_playlist_form(site_url)
{	
	/*$.ajax({
		cache: false,
		url: site_url+"video/save_new_playlist_form/",
		success: function(data){			
			open_messagebox("Save A Playlist", data);
		}		
	});*/		
	
	$('#playlist_title').css('display', 'none');
	//$('#playlist_caption').val('');
	$('#playlist_title_save').css('display', 'block');
	$('#playlist_caption').focus();
	$('#playlist_cancel_button').css('display', 'none');
	var js = 'submit_save_playlist_form("'+site_url+'")';
	$('#playlist_save_link').attr('onclick', js);
	$('#create_new_playlist_span').css('display', 'block');
	
}

//save a playlist
function cancel_save_current_playlist_form(site_url)
{	
	/*$.ajax({
		cache: false,
		url: site_url+"video/save_new_playlist_form/",
		success: function(data){			
			open_messagebox("Save A Playlist", data);
		}		
	});*/
		
	$('#playlist_title_save').css('display', 'none');
	$('#playlist_title').css('display', 'block');
	$('#playlist_title').html('Untitled');
	//$('#playlist_save_button').css('display', 'none');
	var js = 'open_save_current_playlist_form("'+site_url+'")';
	$('#playlist_save_link').attr('onclick', js);
	$('#playlist_cancel_button').css('display', 'none');
	$('#create_new_playlist_span').css('display', 'none');
	
}


//submit the playlist save form
function submit_save_playlist_form(site_url)
{
	var playlist_caption = $('#playlist_caption').val();
	
	if (playlist_caption.length<=0){
		open_messagebox("Alert", "<span style=\"color:#F00;\">Enter Playlist Name!</span>");
		setTimeout("closeBox()", 4000);
	}else{
		var total_videos = $('#total_videos').val();
		if (total_videos<=0)
		{
			//alert(total_videos);
			open_messagebox("Alert", "<span style=\"color:#F00;\">No videos in the playlist!</span>");
			setTimeout("closeBox()", 4000);
		}else{
			//alert(total_videos);
			
			var result = check_if_playlist_exist(site_url, playlist_caption);
			if (result==1){
				open_messagebox("Alert", "<span style=\"color:#F00;\">Playlist Name Already Exist!</span>");
				setTimeout("closeBox()", 4000);
			}else{
				var save = save_current_playlist_form(site_url, playlist_caption);
				$('#playlist_id').val(save);
				$('#playlist_type').val('playlist');
				$('#playlist_title').html(playlist_caption);
				$('#playlist_title_save').css('display', 'block');
				$('#playlist_rename_button').css('display', 'block');
				$('#playlist_title').css('display', 'none');	
				$('#playlist_title').html(playlist_caption);
				$('#playlist_save_button').css('display', 'none');
				$('#playlist_cancel_button').css('display', 'none');
				$('#playlist_rename_button').css('display', 'block');
				$('#create_new_playlist_span').css('display', 'block');
				open_messagebox("Alert", "<span style=\"color:#F00;\">Playlist Saved!</span>");
				setTimeout("closeBox()", 3000);
			}
		}
	}
	/*var flag = 0;
	var result = check_if_playlist_exist(site_url, playlist_caption);
	
	if (result==1)
	{
		$('#errPlaylist').hide();
		$('#errPlaylist').html('Playlist Name Already Exist');
		$('#errPlaylist').fadeIn('slow');
	}else{
		//alert('Playlist Saved');
		$('#errPlaylist').hide();
		$('#errPlaylist').html('Playlist Saved');
		$('#errPlaylist').fadeIn('slow');
		$('#playlist_title').html(playlist_caption);
		var save = save_current_playlist_form(site_url, playlist_caption);		
		$('#playlist_id').val(save);
		$('#playlist_type').val('playlist');
		
	}*/
	
}

function rename_playlist_title(site_url)
{
	var playlist_caption = $('#playlist_caption').val();
	var playlist_id = $('#playlist_id').val();
	
	if (playlist_caption.length<=0){
		open_messagebox("Alert", "<span style=\"color:#F00;\">Enter Playlist Name!</span>");
		setTimeout("closeBox()", 3000);
	}else{
		var result = check_if_playlist_exist(site_url, playlist_caption);
		if (result==1){
			open_messagebox("Alert", "<span style=\"color:#F00;\">Playlist Name Already Exist!</span>");
			setTimeout("closeBox()", 3000);
		}else{
			
			//var save = rename_current_playlist_title(site_url, playlist_caption, playlist_id);			
			var del = delete_current_playlist(site_url, playlist_id);
			if (del==1)
			{
				var save = save_current_playlist_form(site_url, playlist_caption);
				$('#playlist_id').val(save);
				$('#playlist_type').val('playlist');
				$('#playlist_type').val('playlist');
				$('#playlist_title').html(playlist_caption);
				$('#playlist_title_save').css('display', 'block');
				$('#playlist_rename_button').css('display', 'block');
				$('#playlist_title').css('display', 'none');	
				$('#playlist_title').html(playlist_caption);
				$('#playlist_save_button').css('display', 'none');
				$('#playlist_cancel_button').css('display', 'none');
				$('#playlist_rename_button').css('display', 'block');
				open_messagebox("Alert", "<span style=\"color:#F00;\">Playlist Saved!</span>");
				setTimeout("closeBox()", 2000);
			}else{
				open_messagebox("Alert", "<span style=\"color:#F00;\">Playlist Couldnot Be Saved!</span>");
				setTimeout("closeBox()", 2000);
			}
		}
	}
	/*var flag = 0;
	var result = check_if_playlist_exist(site_url, playlist_caption);
	
	if (result==1)
	{
		$('#errPlaylist').hide();
		$('#errPlaylist').html('Playlist Name Already Exist');
		$('#errPlaylist').fadeIn('slow');
	}else{
		//alert('Playlist Saved');
		$('#errPlaylist').hide();
		$('#errPlaylist').html('Playlist Saved');
		$('#errPlaylist').fadeIn('slow');
		$('#playlist_title').html(playlist_caption);
		var save = save_current_playlist_form(site_url, playlist_caption);		
		$('#playlist_id').val(save);
		$('#playlist_type').val('playlist');
		
	}*/	
}


//function to delete the complete playlist
function delete_current_playlist(site_url, playlist_id)
{
	var result = $.ajax({
		async:false,
		cache:false,
		type: "GET",
		data: "playlist_id="+playlist_id,		
		url: site_url+"video/remove_user_playlist/"
	}).responseText;
	
	//alert(result);
	return result;	
}

//check to see if any playlist exist with same name for a user
function check_if_playlist_exist(site_url, playlist_caption)
{
	var result = $.ajax({
		async:false,
		cache:false,
		type: "GET",
		data: "playlist_caption="+playlist_caption,		
		url: site_url+"video/check_playlist_name_exist/"		
	}).responseText;
	
	return result;
}

//save the playlist form
function save_current_playlist_form(site_url, playlist_caption)
{
	var result = $.ajax({
		async:false,
		cache:false,
		type: "GET",
		data: "playlist_caption="+playlist_caption,		
		url: site_url+"video/save_new_playlist_form_data/"		
	}).responseText;
	
	return result;
}

//rename the playlist title
function rename_current_playlist_title(site_url, playlist_caption, playlist_id)
{
	var result = $.ajax({
		async:false,
		cache:false,
		type: "GET",
		data: "playlist_caption="+playlist_caption+"&playlist_id="+playlist_id,
		url: site_url+"video/rename_playlist_title/"		
	}).responseText;	
	return result;
}

//load all playlists of the user
function load_all_user_playlist(site_url)
{	
	$.ajax({
		url: site_url+"video/load_all_user_playlist",
		cache: false,
		success: function(data){			
			if (check_user_log_in()==1)
			{
				if (user_membership_type(site_url)==1){
					$('#display_user_playlist').html(data);
				}else{
					//open_messagebox("Alert", "<span style=\"color:#F00;\">Please upgrade your account view playlist!</span>");
					$('#display_user_playlist').html("Please upgrade your account to view playlist!");
				}
			}else{
				$('#display_user_playlist').html("Please Login To View Your Playlist");
			}
		}
	});
}

//get membership type of a user
function user_membership_type(site_url)
{
	var result = $.ajax({
		async:false,
		cache:false,
		type: "GET",
		data: "",
		url: site_url+"myaccount/user_membership_type/"
	}).responseText;	
	return result;
}

//load a single playlist in the home page
function load_single_playlist(site_url, playlist_id, playlist_title, call)
{
	//alert(playlist_id);
	if (call=='')
	{
		call='redirect';	
	}
	
	$.ajax({
		url: site_url+"video/load_single_user_playlist",
		cache: false,
		type: 'GET',
		data: 'playlist_id='+playlist_id+'&playlist_title='+playlist_title,
		success: function(data){
			//alert(data);
			//location.reload(true);
			if (call=='redirect'){
				window.location=site_url+"home/index/playlist";
			}
			
			$('#user_playlist_section').html(data);
			$('#playlist_title_save').css('display', 'none');
			$('#playlist_save_button').css('display', 'none');
			$('#playlist_title').html(playlist_title);
			$('#playlist_title').css('display', 'block');
		}
	});
}

//delete a playlist
function remove_playlist(site_url, playlist_id, playlist_title)
{
	//alert(site_url+' '+playlist_id+' '+playlist_title);
	$.ajax({
		url: site_url+"video/delete_playlist/",
		cache: false,
		type: 'POST',
		data: 'playlist_id='+playlist_id,
		success: function(data){
			//alert(data);
			//location.reload(true);
			if (data==1){
				open_messagebox("Alert", "<span style=\"color:#F00;\">Playlist Deleted!</span>");
				//load all user playlist
				load_all_user_playlist(site_url);
			}else{
				open_messagebox("Alert", "<span style=\"color:#F00;\">Playlist Couldnot Be Deleted!</span>");
			}
			
			//load the existing playlist
			//load_single_playlist(site_url, playlist_id, playlist_title, 'ajax');
		}
	});
	//window.location=site_url+"home/index/playlist";
}


//show message if user is not logged in
function login_play_video_alert()
{
	open_messagebox("Alert", "<span style=\"color:#F00;\">Please Login To View The Video!</span>");
}


//update buddy status to start video simultaneously
function update_buddy_status(site_url, view_id)
{
	$.ajax({
		url: site_url+"video/update_buddy_status/"+view_id+"/",
		success: function(data){
			if (data==1)
			{
				//start the video
				change_vid_div(site_url, view_id);
			}
		}
	
	});
	setTimeout("update_buddy_status('"+site_url+"', '"+view_id+"')", 2000);
}

//start the video if buddy accepts the invitation
/*function change_vid_div(site_url, view_id)
{
	//alert(view_id);
	$.ajax({
		url: site_url+"video/refresh/"+view_id+"/",
		success: function (data){
			$('#video_play').html(data);
		}
	});
}*/

//load the buddy list to invite friend for workout
function load_buddy_list(site_url, video_id, view_id)
{
	//alert(video_id+' '+view_id);
	$.ajax({
		url: site_url+"video/get_buddy_list/",
		data: "video_id="+video_id+"&view_id="+view_id,
		type: "POST",
		success: function (data){
			$('#buddy_list').html(data);
		}
	});
	setTimeout("load_buddy_list('"+site_url+"', '"+video_id+"', '"+view_id+"')", 5000);	
}

//load the current playlist
function load_current_playlist(site_url)
{
	$.ajax({
		cache:false,
		url: site_url+"video/load_current_playlist/",
		success: function (data){
			$('#buddy_list').html(data);
		}
	});
}

//convert json_encode data
function json_decode (str_json) {
  // http://kevin.vanzonneveld.net
  // +      original by: Public Domain (http://www.json.org/json2.js)
  // + reimplemented by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +      improved by: T.J. Leahy
  // +      improved by: Michael White
  // *        example 1: json_decode('[\n    "e",\n    {\n    "pluribus": "unum"\n}\n]');
  // *        returns 1: ['e', {pluribus: 'unum'}]
/*
    http://www.JSON.org/json2.js
    2008-11-19
    Public Domain.
    NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.
    See http://www.JSON.org/js.html
  */

  var json = this.window.JSON;
  if (typeof json === 'object' && typeof json.parse === 'function') {
    try {
      return json.parse(str_json);
    } catch (err) {
      if (!(err instanceof SyntaxError)) {
        throw new Error('Unexpected error type in json_decode()');
      }
      this.php_js = this.php_js || {};
      this.php_js.last_error_json = 4; // usable by json_last_error()
      return null;
    }
  }

  var cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;
  var j;
  var text = str_json;

  // Parsing happens in four stages. In the first stage, we replace certain
  // Unicode characters with escape sequences. JavaScript handles many characters
  // incorrectly, either silently deleting them, or treating them as line endings.
  cx.lastIndex = 0;
  if (cx.test(text)) {
    text = text.replace(cx, function (a) {
      return '\\u' + ('0000' + a.charCodeAt(0).toString(16)).slice(-4);
    });
  }

  // In the second stage, we run the text against regular expressions that look
  // for non-JSON patterns. We are especially concerned with '()' and 'new'
  // because they can cause invocation, and '=' because it can cause mutation.
  // But just to be safe, we want to reject all unexpected forms.
  // We split the second stage into 4 regexp operations in order to work around
  // crippling inefficiencies in IE's and Safari's regexp engines. First we
  // replace the JSON backslash pairs with '@' (a non-JSON character). Second, we
  // replace all simple value tokens with ']' characters. Third, we delete all
  // open brackets that follow a colon or comma or that begin the text. Finally,
  // we look to see that the remaining characters are only whitespace or ']' or
  // ',' or ':' or '{' or '}'. If that is so, then the text is safe for eval.
  if ((/^[\],:{}\s]*$/).
  test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, '@').
  replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
  replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

    // In the third stage we use the eval function to compile the text into a
    // JavaScript structure. The '{' operator is subject to a syntactic ambiguity
    // in JavaScript: it can begin a block or an object literal. We wrap the text
    // in parens to eliminate the ambiguity.
    j = eval('(' + text + ')');

    return j;
  }

  this.php_js = this.php_js || {};
  this.php_js.last_error_json = 4; // usable by json_last_error()
  return null;
}


