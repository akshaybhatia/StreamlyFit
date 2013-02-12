// JavaScript Document

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
		alert('Please accept our terms & conditions!');	
	}
}

//redirect from play option
function redirect_from_play_option(site_url, video_id, play_option)
{
	if (play_option!='WF'){
		window.location = site_url+'video/play/'+video_id+'/'+play_option+'/';
	}else{
		display_buddy_list(site_url, video_id);	
	}
}

//open form to select buddy list
function display_buddy_list(site_url, video_id)
{
	$.ajax({
		cache: false,
		url: site_url+"video/get_buddy_list_popup",
		type: "POST",
		data: "video_id="+video_id,
		success: function(data){
			//alert(data);
			open_messagebox("Choose Buddy List", data);
		}
		
	});
}

//redirect from buddy list in play option
function redirect_from_choose_friend(site_url)
{
	//if ($('input:radio[name=friend_id]:checked')){	
	
	if ($("input[@name=friend_id]:checked").val()>0){
		//alert($("input[@name=friend_id]:checked").val());	
		window.location = site_url+'video/play/'+$('#buddy_video_id').val()+'/WF/'+$("input[@name=friend_id]:checked").val()+'/';
	}else{
		alert('Please select a buddy to view the video');	
	}
	/*if ($('input:radio[name=friend_id]:checked') != "undefined" && $('input:radio[name=friend_id]:checked')){
		//window.location = site_url+'video/play/'+video_id+'/WF/';
		//alert($('input:radio[name=friend_id]:checked').val());
		alert('checked');
	}else{
		alert('Please select a buddy to view the video');	
	}*/
	
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
			//alert(data);
			//$('#playlist_video_display').html(data.form);	
			display_current_playlist(site_url);
			
			if ($('#playlist_play_video_id').val()==video_id){
				$('#video_play').html('play');	
			}
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
			$('#sort_order_'+sort_order).html('<p class="text_top_space">drop video here</p>');
		}
	});
	
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


