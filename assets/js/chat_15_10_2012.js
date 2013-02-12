/*

Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)

This script may be used for non-commercial purposes only. For any
commercial purposes, please contact the author at 
anant.garg@inscripts.com

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/

var windowFocus = true;
var username;
var chatHeartbeatCount = 0;
var minChatHeartbeat = 2000;
var maxChatHeartbeat = 2000;
var chatHeartbeatTime = minChatHeartbeat;
var originalTitle;
var blinkOrder = 0;

var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var chatBoxes = new Array();

$(document).ready(function(){
	/*originalTitle = document.title;
	startChatSession();

	$([window, document]).blur(function(){
		windowFocus = false;
	}).focus(function(){
		windowFocus = true;
		document.title = originalTitle;
	});*/
});

function restructureChatBoxes() {
	align = 0;
	for (x in chatBoxes) {
		chatuser_id = chatBoxes[x];

		if ($("#chatbox_"+chatuser_id).css('display') != 'none') {
			if (align == 0) {
				$("#chatbox_"+chatuser_id).css('right', '20px');
			} else {
				width = (align)*(225+7)+20;
				$("#chatbox_"+chatuser_id).css('right', width+'px');
			}
			align++;
		}
	}
}

function chatWith(chatuser_id,chatuser) {
	if($("#my_chat_status").html()!=4)
	{
	createChatBox(chatuser_id,chatuser);
	$("#chatbox_"+chatuser_id+" .chatboxtextarea").focus();
	}
	else
	{
		alert("Please online your chat status for chating.");	
	}
}

function createChatBox(chatuser_id,chatboxtitle,minimizeChatBox) {
	if ($("#chatbox_"+chatuser_id).length > 0) {
		if ($("#chatbox_"+chatuser_id).css('display') == 'none') {
			$("#chatbox_"+chatuser_id).css('display','block');
			restructureChatBoxes();
		}
		$("#chatbox_"+chatuser_id+" .chatboxtextarea").focus();
		return;
	}

	$(" <div />" ).attr("id","chatbox_"+chatuser_id)
	.addClass("chatbox")
	.html('<div class="chatboxhead"><div class="chatboxtitle">'+chatboxtitle+'</div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+chatuser_id+'\',\''+chatboxtitle+'\')">-</a> <a href="javascript:void(0)" onclick="javascript:closeChatBox(\''+chatuser_id+'\',\''+chatboxtitle+'\')">X</a></div><br clear="all"/></div><div class="chatboxcontent"></div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatuser_id+'\',\''+chatboxtitle+'\');"></textarea></div>')
	.appendTo($( "body" ));
			   
	$("#chatbox_"+chatuser_id).css('bottom', '0px');
	
	chatBoxeslength = 0;

	for (x in chatBoxes) {
		if ($("#chatbox_"+chatBoxes[x]).css('display') != 'none') {
			chatBoxeslength++;
		}
	}

	if (chatBoxeslength == 0) {
		$("#chatbox_"+chatuser_id).css('right', '20px');
	} else {
		width = (chatBoxeslength)*(225+7)+20;
		$("#chatbox_"+chatuser_id).css('right', width+'px');
	}
	
	chatBoxes.push(chatuser_id);

	if (minimizeChatBox == 1) {
		minimizedChatBoxes = new Array();

		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}
		minimize = 0;
		for (j=0;j<minimizedChatBoxes.length;j++) {
			if (minimizedChatBoxes[j] == chatuser_id) {
				minimize = 1;
			}
		}

		if (minimize == 1) {
			$('#chatbox_'+chatuser_id+' .chatboxcontent').css('display','none');
			$('#chatbox_'+chatuser_id+' .chatboxinput').css('display','none');
		}
	}

	chatboxFocus[chatuser_id] = false;

	$("#chatbox_"+chatuser_id+" .chatboxtextarea").blur(function(){
		chatboxFocus[chatuser_id] = false;
		$("#chatbox_"+chatuser_id+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function(){
		chatboxFocus[chatuser_id] = true;
		newMessages[chatuser_id] = false;
		$('#chatbox_'+chatuser_id+' .chatboxhead').removeClass('chatboxblink');
		$("#chatbox_"+chatuser_id+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	$("#chatbox_"+chatuser_id).click(function() {
		if ($('#chatbox_'+chatuser_id+' .chatboxcontent').css('display') != 'none') {
			$("#chatbox_"+chatuser_id+" .chatboxtextarea").focus();
		}
	});

	$("#chatbox_"+chatuser_id).show();
}


function chatHeartbeat(){

	
	var itemsfound = 0;
	if (windowFocus == false) {
 
		var blinkNumber = 0;
		var titleChanged = 0;
		for (x in newMessagesWin) {
			if (newMessagesWin[x] == true) {
				++blinkNumber;
				if (blinkNumber >= blinkOrder) {
					document.title = x+' says...';
					titleChanged = 1;
					break;	
				}
			}
		}
		
		if (titleChanged == 0) {
			document.title = originalTitle;
			blinkOrder = 0;
		} else {
			++blinkOrder;
		}

	} else {
		
		for (x in newMessagesWin) {
			newMessagesWin[x] = false;
		}
	}

	
	
	for (x in newMessages) {
		
		if (newMessages[x] == true) {
			if (chatboxFocus[x] == false) {
				//FIXME: add toggle all or none policy, otherwise it looks funny
				$('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
			}
		}
	}
	
	
	
		  
	$.ajax({
	  url: "chat/chatHeartbeat",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
		$.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug
				var return_arr = item.split('~');

				
				id=return_arr[0];
				
				chatuser_id=return_arr[1];
				chatboxtitle=return_arr[2];
				message=return_arr[3];
				sent_at=return_arr[4];
				
				if ($("#chatbox_"+chatuser_id).length <= 0) {
					createChatBox(chatuser_id,chatboxtitle);
				}
				if ($("#chatbox_"+chatuser_id).css('display') == 'none') {
					$("#chatbox_"+chatuser_id).css('display','block');
					restructureChatBoxes();
				}
				
				
				
				/*if (item.s == 1) {
					item.f = username;
				}*/
				newMessages[chatuser_id] = true;
				newMessagesWin[chatboxtitle] = true;
				
				$("#chatbox_"+chatuser_id+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+chatboxtitle+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+message+'</span></div>');

				if (sent_at != '') {
					$("#chatbox_"+chatuser_id+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+sent_at+'</span></div>');
				}
				
				$("#chatbox_"+chatuser_id+" .chatboxcontent").scrollTop($("#chatbox_"+chatuser_id+" .chatboxcontent")[0].scrollHeight);
				itemsfound += 1;
				
				$.post("chat/update_message_state", { id: id} , function(data){	
																		 
				});
				
				
				
				
			}
		});

		chatHeartbeatCount++;

		/*if (itemsfound > 0) {
			chatHeartbeatTime = minChatHeartbeat;
			chatHeartbeatCount = 1;
		} else if (chatHeartbeatCount >= 10) {
			chatHeartbeatTime *= 2;
			chatHeartbeatCount = 1;
			if (chatHeartbeatTime > maxChatHeartbeat) {
				chatHeartbeatTime = maxChatHeartbeat;
			}
		}*/
		
		setTimeout('chatHeartbeat();',chatHeartbeatTime);
	}});
}

function closeChatBox(chatuser_id,chatboxtitle) {

	$('#chatbox_'+chatuser_id).css('display','none');
	restructureChatBoxes();

	/*$.post("chat/closechat", { chatbox: chatuser_id} , function(data){	
	});*/

}

function toggleChatBoxGrowth(chatuser_id,chatboxtitle) {
	if ($('#chatbox_'+chatuser_id+' .chatboxcontent').css('display') == 'none') {  
		
		var minimizedChatBoxes = new Array();
		
		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}

		var newCookie = '';

		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != chatboxtitle) {
				newCookie += chatboxtitle+'|';
			}
		}

		newCookie = newCookie.slice(0, -1)


		$.cookie('chatbox_minimized', newCookie);
		$('#chatbox_'+chatuser_id+' .chatboxcontent').css('display','block');
		$('#chatbox_'+chatuser_id+' .chatboxinput').css('display','block');
		$("#chatbox_"+chatuser_id+" .chatboxcontent").scrollTop($("#chatbox_"+chatuser_id+" .chatboxcontent")[0].scrollHeight);
	} else {
		
		var newCookie = chatboxtitle;

		if ($.cookie('chatbox_minimized')) {
			newCookie += '|'+$.cookie('chatbox_minimized');
		}


		$.cookie('chatbox_minimized',newCookie);
		$('#chatbox_'+chatuser_id+' .chatboxcontent').css('display','none');
		$('#chatbox_'+chatuser_id+' .chatboxinput').css('display','none');
	}
	
}

function checkChatBoxInputKey(event,chatboxtextarea,chatuser_id,chatboxtitle) {
	 
	if(event.keyCode == 13 && event.shiftKey == 0)  {
		
		message = $(chatboxtextarea).val();
		message = message.replace(/^\s+|\s+$/g,"");

		$(chatboxtextarea).val('');
		$(chatboxtextarea).focus();
		$(chatboxtextarea).css('height','44px');
		
		if (message != '') {
			//alert(message+'--'+chatuser_id+'--'+chatboxtitle);
			
			$.post("chat/sendchat", {to_id: chatuser_id,to: chatboxtitle, message: message} , function(data){
				message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
				$("#chatbox_"+chatuser_id+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+username+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+message+'</span></div>');
				$("#chatbox_"+chatuser_id+" .chatboxcontent").scrollTop($("#chatbox_"+chatuser_id+" .chatboxcontent")[0].scrollHeight);
			});
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			$(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} else {
		$(chatboxtextarea).css('overflow','auto');
	}
	 
}

function startChatSession(){  
	
	$.ajax({
	  url: "chat/startchatsession",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
 
		username = data.username;
		
		$.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug

				chatboxtitle = item.f;

				if ($("#chatbox_"+chatuser_id).length <= 0) {
					createChatBox(chatuser_id,1);
				}
				
				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					$("#chatbox_"+chatuser_id+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					$("#chatbox_"+chatuser_id+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.f+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}
			}
		});
		
		for (i=0;i<chatBoxes.length;i++) {
			chatuser_id = chatBoxes[i];
			$("#chatbox_"+chatuser_id+" .chatboxcontent").scrollTop($("#chatbox_"+chatuser_id+" .chatboxcontent")[0].scrollHeight);
			setTimeout('$("#chatbox_"+chatuser_id+" .chatboxcontent").scrollTop($("#chatbox_"+chatuser_id+" .chatboxcontent")[0].scrollHeight);', 100); // yet another strange ie bug
		}
	
	setTimeout('chatHeartbeat();',chatHeartbeatTime);
		
	}});
}

/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};