<div onmouseout="hideremove('<?php echo $sort_order; ?>');" onmouseover="showremove('<?php echo $sort_order; ?>');" id="main_play_div_<?php echo $sort_order; ?>">    
        <div id="over_cross_<?php echo $sort_order; ?>" class="over_cross" style="display: none;">
        	<a onclick="remove_video_current_playlist('<?php echo $this->config->item('base_url'); ?>', '<?php echo $video_id; ?>', '<?php echo $sort_order; ?>');" href="javascript:void(0);" ><img alt="" src="<?php echo $this->config->item('base_url');?>assets/images/mouseover_cross.png"></a>
        </div>        
        <div>
        	<a <?php if ($this->session->userdata('user_id')!='' && strcmp($this->session->userdata('membership_type'), 'F')!=0 && strcmp($this->session->userdata('health_waiver_form'), 'N')==0){?>href="<?php echo $this->config->item('base_url'); ?>video/play_option/<?php echo $video_id; ?>/video/" <?php }elseif ($this->session->userdata('user_id')!='' && $this->session->userdata('membership_type')!='F' && $this->session->userdata('health_waiver_form')=='Y'){?> href="<?php echo $this->config->item('base_url'); ?>video/play_option/<?php echo $video_id; ?>" <?php }elseif ($this->session->userdata('user_id')==''){?> href="javascript:login_play_video_alert();" <?php }else{?>href="<?php echo $this->config->item('base_url'); ?>video/play_sample/<?php echo $video_id; ?>" <?php } ?> >
        		