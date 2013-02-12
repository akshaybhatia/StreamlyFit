
    <div class="chatlist_name">
    <div class="chat_search_name1">
    	<div style="float:left; width:142px; padding-top:4px; padding-left:10px;"><strong>Friend List</strong></div>
        <div style="float:right; width:66px; padding-top:3px; padding-right:3px;">
        
        	<ul id="nav" style="right:100px;">
		<li>
			<div style="width:50px; margin-left:40px; margin-bottom:15px;">
            	<span id="my_chat_status" style="display:none"><?php echo $my_chat_status;?></span>
                
                <div style="float:left; padding-top:5px;"><img id="my_chat_status_img" src="<?php echo $this->config->item("site_url")?>/assets/images/<?php echo $my_chat_status_img;?>" align="left"  /></div>
                
                <div style="float:left;"><a href="#"><img src="<?php echo $this->config->item("site_url")?>/assets/images/drow_arrow.jpg" align="left"/></a></div>
            </div>
			<ul>
            	<li class="chat_chat_border"><a href="javascript:change_status('4');"><img src="<?php echo $this->config->item("site_url")?>/assets/images/offline.png" alt="" /> Offline</a></li>
				<li class="chat_chat_border"><a href="javascript:change_status('1');"><img src="<?php echo $this->config->item("site_url")?>/assets/images/online.png" alt="" /> Online</a></li>
				<li class="chat_chat_border"><a href="javascript:change_status('2');"><img src="<?php echo $this->config->item("site_url")?>/assets/images/away.png" alt="" /> Away</a></li>
                <li class="chat_chat_border1"><a href="javascript:change_status('3');"><img src="<?php echo $this->config->item("site_url")?>/assets/images/busy.png" alt="" /> Busy</a></li>
                
			</ul>
		</li>
	</ul>
        
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="chat_overflow_area">

<?php foreach($friend_list as $row){

 //echo "aaa".$row->chat_status;
	switch($row->chat_status)
	{
		case 1: 
			$status_img="online.png"; 
			$chat_link="javascript:chatWith('".$row->friend_id."','".$row->friend_name."');";
			break;
		case 2: 
			$status_img="away.png"; 
			$chat_link="javascript:chatWith('".$row->friend_id."','".$row->friend_name."');";
			break;
		case 3: 
			$status_img="busy.png"; 
			$chat_link="javascript:chatWith('".$row->friend_id."','".$row->friend_name."');";
			break;
		case 4: 
			$status_img="offline.png"; 
			$chat_link="javascript:void(0);";
			break;
		default: 
			$status_img="offline.png"; 
			$chat_link="javascript:void(0);";
			break;
		
		
	}
?>


    <div class="chatlist_name" id="<?php echo $row->friend_id;?>_row">
        <div class="chat_online_area" id="<?php echo $row->friend_id;?>_status"><img src="<?php echo $this->config->item("site_url")?>/assets/images/<?php echo $status_img;?>" alt="" /></div>
        <div class="chat_online_name"><a href="<?php echo $chat_link;?>"><?php echo $row->friend_name;?></a></div>
        <div class="clearfix"></div>
    </div>
    




<?php }?>
<span id="chat_friend_list"></span>
</div>
<script>
$(function() {
	
 setTimeout("update_friend_status()",10000)
 
 
});


</script>