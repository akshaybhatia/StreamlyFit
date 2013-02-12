<div class="chatlist_name">
    <div class="chat_search_name"><strong>Send Invitation</strong></div>
    <div class="clearfix"></div>
</div>

<?php foreach($friend_request as $row){?>
<div class="chatlist_name">
    <div class="chat_request_name"><?php echo $row->from_name;?></div>
    <div class="chat_request_action"><input type="button" name="allow" value="Allow" onclick="allow_friend_request('<?php echo $row->friend_list_id;?>')" /><input type="button" name="decline" value="Decline"  onclick="decline_friend_request('<?php echo $row->friend_list_id;?>')" /></div>
    <div class="clearfix"></div>
</div>
<?php }?>


<a href='javascript:close_chat_subfunction();'><img src="<?php echo $this->config->item("site_url")?>/assets/images/close.png" alt="" align="right" style="margin-top:5px" /></a>