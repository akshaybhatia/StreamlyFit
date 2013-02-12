<ul id="dance">
    <?php
		//echo $this->session->userdata('membership_type');
		//exit;
        if (!empty($video_list)){
            foreach($video_list as $vl){
    ?>
    
    <li class="space_right">
        <div class="small_video_area" id="video_<?php echo $vl->video_id; ?>" <?php if ($this->session->userdata('user_id')=='' || ($this->session->userdata('user_id')!='' && $this->session->userdata('membership_type')=='F')){?>onmouseover="show_effects('<?php echo $vl->video_id; ?>');" onmouseout="hide_effects('<?php echo $vl->video_id; ?>');"<?php }?> >
        
        	<!--Div to display modal if user not logged in-->
        	<div  class="small_video_blureffect" id="login_alert_div_<?php echo $vl->video_id; ?>" style="cursor:pointer; display:none;" <?php if ($this->session->userdata('user_id')==''){?> onclick="javascript:redirect_to_signup();" <?php }elseif ($this->session->userdata('user_id')!='' && $this->session->userdata('membership_type')=='F'){?> onclick="javascript:window.location.href='<?php echo $this->config->item('base_url'); ?>signup/upgrade_membership/';" <?php } ?> >
                <h1 class="watch_video">
                	<?php if ($this->session->userdata('user_id')==''){?>
                	<a href="<?php echo $this->config->item('base_url'); ?>signup/">Sign up to watch the video</a>
                    <?php
						}elseif ($this->session->userdata('user_id')!='' && $this->session->userdata('membership_type')=='F'){
					?>
                    <a href="<?php echo $this->config->item('base_url'); ?>signup/upgrade_membership/">Upgrade membership to watch the video</a>
                    <?php
						}
					?>
                </h1>
            </div>
        
        <!--Click on the link to display the video health waiver form-->
        <a <?php  if ($this->session->userdata('user_id')!='' && strcmp($this->session->userdata('membership_type'), 'F')!=0 && strcmp($this->session->userdata('health_waiver_form'), 'N')==0){?> href="<?php echo $this->config->item('base_url'); ?>video/play_option/<?php echo $vl->video_id; ?>/video/" <?php }elseif ($this->session->userdata('user_id')!='' && $this->session->userdata('membership_type')!='F' && $this->session->userdata('health_waiver_form')=='Y'){?> href="<?php echo $this->config->item('base_url'); ?>video/play_option/<?php echo $vl->video_id; ?>/video/" <?php }elseif ($this->session->userdata('user_id')==''){?> href="<?php echo $this->config->item('base_url'); ?>signup/" <?php }else{?>href="<?php echo $this->config->item('base_url'); ?>video/play_sample/<?php echo $vl->video_id; ?>" <?php } ?> >
        <img id="video_<?php echo $vl->video_id; ?>" value="<?php echo $vl->video_id; ?>" class="draggable" src="<?php echo $this->config->item('base_url'); ?>assets/uploads/video/<?php echo $vl->video_image; ?>" alt="<?php echo $vl->video_caption; ?>" width="184" height="121" /></a>
        <!--Click on the link to display the video health waiver form-->
        
        </div>
        
        <div class="video_content">
        	<div class="yoga_starter">
            <a <?php   if ($this->session->userdata('user_id')!='' && strcmp($this->session->userdata('membership_type'), 'F')!=0 && strcmp($this->session->userdata('health_waiver_form'), 'N')==0){?> href="<?php echo $this->config->item('base_url'); ?>video/play_option/<?php echo $vl->video_id; ?>/video/" <?php }elseif ($this->session->userdata('user_id')!='' && $this->session->userdata('membership_type')!='F' && $this->session->userdata('health_waiver_form')=='Y'){?> href="<?php echo $this->config->item('base_url'); ?>video/play_option/<?php echo $vl->video_id; ?>/video/" <?php }elseif ($this->session->userdata('user_id')==''){?> href="javascript:void(0);" <?php }else{?>href="javascript:void(0);" <?php  } ?> ><?php echo $vl->video_caption; ?></a>
           <!-- <br>
            <a  href="javascript:void(0);" style="font-size:10px; color:#000; z-index:10000;" class="">Add to playlist</a>-->
            
            </div>
            <div class="rating_area">
                <div class="overall_area_new overall_space">
                    <div class="overall_area_left_col">Overall</div>
                    <div class="overall_area_right_col">
                        <?php
                            $video_overall_rating = '';
                            switch($vl->video_overall_rating){
                                case 5:
                                    $video_overall_rating = '5star.png';
                                    break;
                                case 4:
                                    $video_overall_rating = '4star.png';
                                    break;
                                case 3:
                                    $video_overall_rating = '3star.png';
                                    break;
                                case 2:
                                    $video_overall_rating = '2star.png';
                                    break;
                                case 1:
                                    $video_overall_rating = '1star.png';
                                    break;
                                default:
                                    $video_overall_rating = 'blank-star.png';
                                    break;
                            }
                        ?>
                    
                        <div class="star_icon">                                                
                        <img src="<?php echo $this->config->item('base_url'); ?>assets/star/<?php echo $video_overall_rating; ?>" alt="" /></div>
                        
                        <div class="clearfix"></div> 	
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="overall_area_new overall_space">
                    <div class="overall_area_left_col">Complexity</div>
                    <div class="overall_area_right_col">
                        <?php
                            $video_complexity_rating = '';
                            switch($vl->video_complexity_rating){
                                case 5:
                                    $video_complexity_rating = '5gear.png';
                                    break;
                                case 4:
                                    $video_complexity_rating = '4gear.png';
                                    break;
                                case 3:
                                    $video_complexity_rating = '3gear.png';
                                    break;
                                case 2:
                                    $video_complexity_rating = '2gear.png';
                                    break;
                                case 1:
                                    $video_complexity_rating = '1gear.png';
                                    break;
                                default:
                                    $video_complexity_rating = 'blank-gear.png';
                                    break;
                            }
                        ?>
                    
                        <div class="complexity_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/gear/<?php echo $video_complexity_rating; ?>" alt="" /></div>                                                
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="overall_area_new overall_space">
                    <div class="overall_area_left_col">Intensity</div>
                    <div class="overall_area_right_col">
                        <?php
                            $video_intensity_rating = '';
                            switch($vl->video_intensity_rating){
                                case 5:
                                    $video_intensity_rating = '5intensity.png';
                                    break;
                                case 4:
                                    $video_intensity_rating = '4intensity.png';
                                    break;
                                case 3:
                                    $video_intensity_rating = '3intensity.png';
                                    break;
                                case 2:
                                    $video_intensity_rating = '2intensity.png';
                                    break;
                                case 1:
                                    $video_intensity_rating = '1intensity.png';
                                    break;
                                default:
                                    $video_intensity_rating = 'blank-intensity.png';
                                    break;
                            }
                        ?>
                        <div class="intencity_icon"><img src="<?php echo $this->config->item('base_url'); ?>assets/intensity/<?php echo $video_intensity_rating; ?>" alt="" /></div>
                      
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </li>
    
    <?php }}else{?>
    No videos found
    <?php }?>
  
</ul>

<script type="text/javascript">
	$(function() {
		$('#dance').carouFredSel({
			prev: '#prev',
			next: '#next',
			auto: false
		});		
	});
</script>

<script language="javascript">

	function redirect_to_signup()
	{
		window.location.href='<?php echo $this->config->item('base_url'); ?>signup/';	
	}

	function show_effects(video_id)
	{
		//alert(video_id);
		//$(".small_video_blureffect").show()
		$('#login_alert_div_'+video_id).show();
		
	}
	
	function hide_effects(video_id){
		//alert(video_id);
		//$(".small_video_blureffect").hide()
		$('#login_alert_div_'+video_id).hide();
	}

</script>


	
