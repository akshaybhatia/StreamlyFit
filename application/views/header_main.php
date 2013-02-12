<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cage Sentry</title>
<link href="<?php echo $this->config->item("site_url")?>/css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->config->item('site_url');?>/js/jquery-1.4.2.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->config->item("site_url")?>/js/jquery.simplemodal.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("site_url")?>/js/common.js"></script>

<script>
$(document).ready(function() {
//setTimeout("update_clock()",1000); 
})

function update_clock()
{
	$("#clock").load('<?php echo base_url().$this->config->item('index_page');?>home/update_clock/');
	setTimeout("update_clock()",1000); 
}
</script>
</head>

<body>

<!-- Header Area-->
<div class="header_area">
    <div class="header_main_area">
    	<div class="logo_place"><img src="<?php echo $this->config->item("site_url")?>/images/logo.jpg" alt=""/></div>
        <div class="header_text_place">Cage Sentry &nbsp;<font class="logout"><a class="orange" href="<?php echo site_url("logout");?>">Logout</a></font> <span id="clock"><?php echo date("l F d, Y   g:i:s A");?> </span> </div>
		<div class="clear"></div>
    </div>
</div>
<!--End Header Area-->

<div class="main_area">
    <!-- Body Area-->
    <div class="body_area">
    	<!-- Dynamic Tab Area -->
        <div class="dynamick_tab">
			<div <?php if($menu_index==1){?>class="dynamick_tab_area_active"<?php }else{?>class="dynamick_tab_area"<?php }?>><a href="<?php echo site_url("main");?>">Main Menu</a></div>
			<div <?php if($menu_index==2){?>class="dynamick_tab_area_active"<?php }else{?>class="dynamick_tab_area"<?php }?>><a href="<?php echo site_url("main/bank_activity");?>">Bank Activity</a></div>
			<div <?php if($menu_index==3){?>class="dynamick_tab_area_active"<?php }else{?>class="dynamick_tab_area"<?php }?>><a href="<?php echo site_url("transaction_activity");?>">Transaction Activity</a></div>
			<?php
			$is_supervisor=$this->session->userdata('is_supervisor'); 
			if($is_supervisor=="Y")
			{
			?>
			<div <?php if($menu_index==4){?>class="dynamick_tab_area_active"<?php }else{?>class="dynamick_tab_area"<?php }?>><a href="<?php echo site_url("supervisor");?>">Supervisor Console</a></div>
		  <?php }?>		
		</div>
    	
        <!-- End Dynamic Tab Area-->
        <!-- Dynamic Content Area-->
        <div class="dynamic_content_area">
        	<div class="curve_top"><img src="<?php echo $this->config->item("site_url")?>/images/curve_left.jpg" alt="" style="float:left" /><img src="<?php echo $this->config->item("site_url")?>/images/curve_right.jpg" alt="" style="float:right" /></div>
            <div class="dynamic_content_bg">
		
            	<!-- dynamic content body part -->
                <div class="content_body_area">
				<div style="text-align:right; width:100%"><a href="javascript:void()" title="Refresh Screen" onclick="refresh_screen()"><img src="<?php echo $this->config->item("site_url")?>/images/refresh_screen_btn.png" alt="Refresh Screen"  /></a></div>
				
				
				<script  type="text/javascript">
				 function refresh_screen()
				 {
				 	window.location.reload();
				 }
				</script>