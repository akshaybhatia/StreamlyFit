<?php //print_r($friend_request);?>
<div class="chatlist_name">
    <div class="chat_search_name1">
    	<div style="float:left; width:142px; padding-top:4px; padding-left:10px;"><strong>New Invitation</strong></div>
        <div style="float:right; width:66px; padding-top:3px; padding-right:3px;"><a href='javascript:close_chat_subfunction();'><img src="<?php echo $this->config->item("site_url")?>/assets/images/close_window.png" align="right" alt="Close" title="Close"/></a></div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="chat_overflow_area">
<?php foreach($friend_request as $row){?>

    <div class="chatlist_name">
        <div class="chat_request_name"><?php echo $row->from_name;?></div>
        <div class="chat_request_action">
            <div class="chat_icon_space">
            <img style="cursor:pointer" src="<?php echo $this->config->item("site_url")?>/assets/images/allow_btn.png" alt="Allow" title="Allow" onclick="allow_friend_request('<?php echo $row->friend_list_id;?>')" />
            <img style="cursor:pointer" src="<?php echo $this->config->item("site_url")?>/assets/images/decline_btn.png" alt="Decline" title="Decline" onclick="decline_friend_request('<?php echo $row->friend_list_id;?>')" />
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
   

<?php }?>
</div>
