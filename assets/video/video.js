// JavaScript Document

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
			//alert(data);
			$('#video_invites').html(data);			
		}
	});
	setTimeout("check_video_invites('"+site_url+"')",10000);
}

function accept_video_request(site_url, view_id)
{
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

//function to add videos to playlist
function add_video_playlist(site_url, video_id)
{
	var playlist_id = $('#playlist_id').val();
	var playlist_type = $('#playlist_type').val();
	
	//alert(video_id+' '+playlist_id+' '+playlist_type);
	
	$.ajax({
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
	});
	
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
	
	alert(video_id+' '+playlist_id+' '+playlist_type);
	
	$.ajax({
		cache:false,
		type: "GET",
		data: "playlist_id="+playlist_id+"&playlist_type="+playlist_type+"&video_id="+video_id,
		dataType: "json",
		url: site_url+"video/remove_video_playlist/",
		success: function(data){
			alert(data);
			//$('#playlist_video_display').html(data.form);	
			display_current_playlist(site_url);
			
			if ($('#playlist_play_video_id').val()==video_id){
				$('#video_play').html('play');	
			}
		}
	});
	
}

