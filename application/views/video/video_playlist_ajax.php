<?php 
	/*$this->session->unset_userdata('current_playlist_id'); 
	$this->session->unset_userdata('current_playlist_type');
	$this->session->unset_userdata('current_playlist_videos');*/
?>
<?php 
	//check if user is logged in or not to drag & drop videos into the playlist
	$user_id=$this->session->userdata('user_id');
	if($user_id<>""){
?>
<script type="text/javascript">
    $(function() {
		//$( "#draggable" ).draggable({ revert: "valid" });
		//$( ".picture_border" ).draggable({ revert: "invalid" });
		 var video_id='';
		 var total_videos = parseInt($('#total_videos').val());
		 var video_image = '';
		 var sort_order = '';
		 //alert(total_videos);
		 $(".draggable").draggable({
                revert: false,
                helper: 'clone',
				snap: true,
				snapMode: "inner",
				appendTo: "body",
                start: function (event, ui) {
					//alert($(this).attr('value'));
					video_id = $(this).attr('value');
                },
                stop: function (event, ui) {
                	
                }
            });

		$( ".dropvideo_area" ).droppable({
			//activeClass: "ui-state-hover",
			//hoverClass: "ui-state-active",
			drop: function( event, ui ) {
					//alert(video_id);
					var option = 0;
					var hours, mins, sec;
					sort_order = $(this).attr('sort_order');
					//alert($(this).html());
					//alert(trim11($(this).html()));
					if ($.trim($(this).html())=='<p class="text_top_space">drop video here</p>'){
						video_image = add_video_playlist('<?php echo $this->config->item('base_url'); ?>', video_id, sort_order);
						var data = json_decode(video_image);
						
						/*if (data.result==0){
							//alert(data.msg);	
							open_messagebox("Alert", data.msg);
						}else{
							total_videos = parseInt($('#total_videos').val());
							total_videos = total_videos + 1;
							
							if (total_videos>0 && $('#playlist_type').val()=='current')
							{
								//alert(total_videos+' '+$('#playlist_type').val());
								if (check_user_log_in()==1){
									$('#playlist_save_button').css('display', 'block');
								}
							}
							
							$('#total_videos').val(total_videos);
							$('#count_video').html(total_videos);
							//alert(data.play_link);
							var div = data.play_link+'<img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/'+data.data.video_image+'" height="89" width="136" />'+'</a></div></div>';						
							$(this).html(div);
						}*/
						
						if (data.result==0){
							option = add_video_to_playlist_option('<?php echo $this->config->item('base_url'); ?>', 'display', video_id, sort_order);
							
							if (option==1)
							{
								video_image = add_video_playlist_override('<?php echo $this->config->item('base_url'); ?>', video_id, sort_order);
								var data = json_decode(video_image);
								
								total_videos = parseInt($('#total_videos').val());
								total_videos = total_videos + 1;
								var duration = json_decode(get_video_duration());
								
								if (total_videos>0 && $('#playlist_type').val()=='current')
								{
									//alert(total_videos+' '+$('#playlist_type').val());
									if (check_user_log_in()==1){
										$('#playlist_save_button').css('display', 'block');										
									}
								}
								
								$('#total_videos').val(total_videos);
								$('#count_video').html(total_videos);
								$('#video_duration').html(duration['h']+":"+duration['m']+":"+duration['s']);
								//alert(data.play_link);
								var div = data.play_link+'<img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/'+data.data.video_image+'" height="89" width="136" />'+'</a></div></div>';						
								$(this).html(div);
							}
						}else{
							
							total_videos = parseInt($('#total_videos').val());
							total_videos = total_videos + 1;
							if (data.total_videos>1)
							{
								var duration = json_decode(get_video_duration());
								//alert(duration);
								
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
								
								
							}else{
								
								if (data.duration['h']<=9){
									hours = '0'+data.duration['h'];
								}else{
									hours = duration['h'];
								}
								if (data.duration['m']<=9){
									mins = '0'+data.duration['m'];
								}else{
									mins = data.duration['m'];
								}
								
								if (data.duration['s']<=9){
									sec = '0'+data.duration['s'];
								}else{
									sec = data.duration['s'];
								}
								
								$('#video_duration').html(hours+":"+mins+":"+sec);
							}
							
							if (total_videos>0 && $('#playlist_type').val()=='current')
							{
								//alert(total_videos+' '+$('#playlist_type').val());
								if (check_user_log_in()==1){
									$('#playlist_save_button').css('display', 'block');
									open_save_current_playlist_form('<?php echo $this->config->item('base_url'); ?>');
								}
							}
							
							$('#total_videos').val(data.total_videos);
							$('#count_video').html(data.total_videos);
							
							
							//alert(data.total_videos);
							var div = data.play_link+'<img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/'+data.data.video_image+'" height="89" width="136" />'+'</a></div></div>';
							
							//alert(data.video_ids);
							//alert(div);
							
							$(this).html(div);
							
						}
						
					}else{
						open_messagebox("Alert", "Place Holder Not Empty!");
						//alert('Place Holder Not Empty!');	
					}
					//alert($(this).html())
					//$("#player_small_1").show()						

			}
		});
		
		
	
	});
	
</script>
<?php }?>
<script language="javascript">

function showremove(video_id)
{
	//$(".over_cross").fadeIn('slow');
	$('#over_cross_'+video_id).fadeIn('slow');
}

function hideremove(video_id)
{
	//$(".over_cross"). fadeOut('slow');	
	$('#over_cross_'+video_id).fadeOut('slow');
}
	
</script>
<div class="playlist_area" id="current_playlist">
		
		<input type="hidden" name="playlist_id" id="playlist_id" value="<?php echo $this->session->userdata('current_playlist_id'); ?>" />
		<input type="hidden" name="playlist_type" id="playlist_type" value="<?php if ($this->session->userdata('current_playlist_type')!=''){echo $this->session->userdata('current_playlist_type');}else{echo 'current';} ?>" />
        <div class="playlist_area_center">
            <div class="main_playlist_area">
                <div class="playlist_left_arrow"><a href="#" id="prev1"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/leftplaylist_arrow.jpg" alt="" /></a></div>
               
                <div class="playlist_center">
                	 <div id="dance1">
                
                	<?php //print_r($cur_play); ?>
                    
                    <?php						
						$count = 0;
                    	for($keys=0; $keys<20; $keys++){
							//echo $keys;
							
					?>
                    <div class="dropvideo_area <?php if ($keys==0){?>drop_space<?php }else{?>drop_space1<?php }?>" id="sort_order_<?php echo $keys; ?>" sort_order="<?php echo $keys; ?>">
                    		
						<?php
                        	if (isset($cur_play[$keys]->video_id)){
								//print_r($cur_play[$keys]);
								$count++;
						?>
                        <div id="main_play_div_<?php echo $keys; ?>" onmouseover="showremove('<?php echo $keys; ?>');" onmouseout="hideremove('<?php echo $keys; ?>');">
                        
                            <div class="over_cross" id="over_cross_<?php echo $keys; ?>">
                            	<a href="javascript:void(0);" onclick="remove_video_current_playlist('<?php echo $this->config->item('base_url'); ?>', '<?php echo $cur_play[$keys]->video_id; ?>', '<?php echo $keys; ?>');"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/mouseover_cross.png" alt="" /></a>
                            </div>
                            <div>
                            	<a <?php if ($this->session->userdata('user_id')!='' && strcmp($this->session->userdata('membership_type'), 'F')!=0 && strcmp($this->session->userdata('health_waiver_form'), 'N')==0){?>href="javascript:void(0);" onclick="open_waiver_form('<?php echo $this->config->item('base_url'); ?>', '<?php echo $cur_play[$keys]->video_id; ?>');" <?php }elseif ($this->session->userdata('user_id')!='' && $this->session->userdata('membership_type')!='F' && $this->session->userdata('health_waiver_form')=='Y'){?> href="<?php echo $this->config->item('base_url'); ?>video/play_option/<?php echo $cur_play[$keys]->video_id; ?>" <?php }elseif ($this->session->userdata('user_id')==''){?> href="javascript:login_play_video_alert();" <?php }else{?>href="<?php echo $this->config->item('base_url'); ?>video/play_sample/<?php echo $cur_play[$keys]->video_id; ?>" <?php } ?> >
                            	<img src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $cur_play[$keys]->video_image; ?>" height="89" width="136" /></a>
                            </div>
                       </div>
                      	  <!--<a href="javascript:void(0);" onclick="remove_video_current_playlist('<?php echo $this->config->item('base_url'); ?>', '<?php echo $cur_play[$keys]->video_id; ?>', '<?php echo $keys; ?>')" style="color:#000; text-decoration:none; font-size:10px;" >Remove From Playlist</a>-->
						<?php }else{?>
                    	<p class="text_top_space">drop video here</p>
                        <?php }?>
                    </div>
                    <?php
						}
					?>
                    <!--<div class="dropvideo_area drop_space1" id="sort_order_1" sort_order="1"><p class="text_top_space">drop video here</p></div>
                    <div class="dropvideo_area drop_space1" id="sort_order_2" sort_order="2"><p class="text_top_space">drop video here</p></div>
                    <div class="dropvideo_area drop_space1" id="sort_order_3" sort_order="3"><p class="text_top_space">drop video here</p></div>
                    <div class="dropvideo_area drop_space1" id="sort_order_4" sort_order="4"><p class="text_top_space">drop video here</p></div>
                    <div class="dropvideo_area drop_space1" id="sort_order_5" sort_order="5"><p class="text_top_space">drop video here</p></div>-->
                   </div>
                   <div class="clearfix"></div>
                
                
                </div>
                
                <div class="playlist_right_arrow"><a href="#" id="next1"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/rightplaylist_arrow.jpg" alt="" /></a></div>
            </div>
            
            <div class="clearfix"></div>
        </div>
</div>
<script type="text/javascript" language="javascript">
	$(function() {
		
		$('#dance1').carouFredSel({
			prev: '#prev1',
			next: '#next1',
			auto: false
		});
	});
</script>