    <div class="chatlist_name">
    <div class="chat_search_name1">
    	<div style="float:left; width:142px; padding-top:4px; padding-left:10px;"><strong>Search Result</strong></div>
        <div style="float:right; width:66px; padding-top:3px; padding-right:3px;"><a href='javascript:close_chat_subfunction();'><img src="<?php echo $this->config->item("site_url")?>/assets/images/close_window.png" align="right" alt="Close" title="Close"/></a></div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="chat_overflow_area">
	<?php foreach($search_friend_list as $row){
	
		switch($row->friend_status)
		{
			case 'A': $status="<a href='javascript:void();'><img src='".$this->config->item("site_url")."/assets/images/allready_friend.png' alt='Already a friend' /></a>"; break;
			case 'R': $status="<a href='javascript:void();'><img src='".$this->config->item("site_url")."/assets/images/request_send.png' alt='Request sent' /></a>"; break;
			case 'B': $status="<a href='javascript:void();'><img src='".$this->config->item("site_url")."/assets/images/blocked.png' alt='Request sent' /></a>"; break;
			case 'N': $status="<a href='javascript:send_Request(".$row->user_id.")'><img src='".$this->config->item("site_url")."/assets/images/invite_chat.jpg' alt='' /></a>"; break;
			
		}
	?>
    

    <div class="chatlist_name">
        <div class="chat_search_name" title="<?php echo $row->first_name." ".$row->last_name;?>" ><?php echo $row->screen_name;?></div>
        <div class="chat_invite_area" id="<?php echo $row->user_id;?>_status"><?php echo $status;?></div>
        <div class="clearfix"></div>
    </div>
    

    
    
    <?php }?>
    
    </div>
</div>

<span id="chat_search_result"></span>
<script>

function send_Request(friend_id)
{
	var js={'friend_id':friend_id};

		$.post("<?php echo site_url("chat/send_friend_request");?>",js,function(data){
			$("#"+friend_id+"_status").html(data.result);
			//return false;
			
		},"json");
}
</script>