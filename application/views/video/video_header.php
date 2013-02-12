<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_title; ?></title>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/chat.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/simple-modal.css" rel="stylesheet" type="text/css" />

<!--[if IE 6]>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if IE 9]>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/ie9.css" rel="stylesheet" type="text/css" />
<![endif]-->

<script src="<?php echo $this->config->item('base_url'); ?>assets/js/jquery-1.7.2.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item("base_url")?>assets/js/jquery.simplemodal.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("base_url")?>assets/js/video.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("base_url")?>assets/js/chat.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item("base_url")?>assets/js/common.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$("#tabs li").click(function() {
	$("#tabs li").removeClass('active');
	$(this).addClass("active");
	$(".tab_content").hide();
		var selected_tab = $(this).find("a").attr("href");
		$(selected_tab).fadeIn();
		return false;
	});
});
</script>

<!--<script type="text/javascript" language="javascript" src="<?php echo $this->config->item('base_url'); ?>assets/js/jquery.carouFredSel-5.6.4-packed.js"></script>-->

<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/js/jquery.carouFredSel-6.0.5.js"></script>

<script src="<?php echo $this->config->item('base_url'); ?>assets/js/jquery.ui.core.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url'); ?>assets/js/jquery.ui.widget.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url'); ?>assets/js/jquery.ui.mouse.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url'); ?>assets/js/jquery.ui.draggable.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url'); ?>assets/js/jquery.ui.droppable.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />

<script type="text/javascript" language="javascript">
	
	check_video_invites('<?php echo $this->config->item('base_url'); ?>');
	check_invites_notification('<?php echo $this->config->item('base_url'); ?>');
</script>
<script>
	$(function() {
		//$( "#draggable" ).draggable({ revert: "valid" });
		//$( ".picture_border" ).draggable({ revert: "invalid" });
		
		
		var button = $('#loginButton');
		var box = $('#loginBox');
		var form = $('#loginForm');
		button.removeAttr('href');
		button.mouseup(function(login) {
			box.toggle();
			button.toggleClass('active');
			
			
			$.ajax({
				cache:false,
				url: '<?php echo base_url().$this->config->item('index_page');?>login',
				success: function(data){
						box.html(data);
					}
				});
		});
		
		form.mouseup(function() { 
			return false;
		});
		
		$(this).mouseup(function(login) {
			
			if(!($(login.target).parent('#loginButton').length > 0)) {
				button.removeClass('active');
				//box.hide();
			}
		});
	
	
	});
	
</script>

<!--Show placeholder javascript-->
<script language="javascript">
	  function show_pass(id_show,id_hide)
		{
		  
		  $("#"+id_show).show();
		  $("#"+id_show).focus();
		  $("#"+id_hide).hide();
		}	
	 function show_txt(id_show,id_hide)
	 {
		  if($("#"+id_show).val()=="")
		{
		  $("#"+id_show).hide();
		  $("#"+id_hide).show(); 
		 // $("#"+id_hide).val(txt); 
		}
	 
	 }	
</script>
<!--Show placeholder javascript-->

<script type="text/javascript" language="javascript">
	$(function() {

		//	Basic carousel + timer
		$('#foo1').carouFredSel({
			auto: {
				pauseOnHover: 'resume',
				duration:1200
				}
				
		});
		
		var is_up=0;
		$("#slide_control").click(function() {
			  $(".video_landing_page_header_area").slideToggle('slow');
			 // alert(is_up);
			  if(is_up==0)
			  {
			  	$("#slide_control").addClass('up_arrow');
			  	is_up=1;
			  }
			  else
			  {
			  	$("#slide_control").removeClass('up_arrow');
			  	is_up=0;
			  }
		});

	});
</script>


</head>

<body id="body_html">
<!--header Area-->
<div class="video_landing_page_header_area">
	<div class="header_main_area">
    	<div class="logo_area"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/logo.jpg" alt="Streamly Fit" title="Streamly Fit" onclick="location.href='<?php echo $this->config->item('base_url'); ?>'" style="cursor:pointer" /></div>
        <div class="tab_area">
        	<div class="toptab_area">
			<?php 
			if($this->session->userdata('user_id')<>''){?>
            	<div class="login_user_name">Hello &nbsp;<?php echo $this->session->userdata('screen_name');?> !</div>
			<?php }?>	
            	<ul>
                	<li><a href="#">FAQ</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Help</a></li>
                    <?php
						//print_r($this->session->all_userdata());
                    	if($this->session->userdata('user_id')==''){
					?>
                    <div id="loginContainer">
                    <li><a href="<?php echo $this->config->item('base_url'); ?>login/" id="loginButton"><span>Login</span></a></li>
                    
                    <!--Login Pop down area-->
                    <div id="loginBox">                
                        
                    </div>
                    <!--End-->
                    </div>
                    <?php
						}else{
					?>
                    <li><a href="<?php echo $this->config->item('base_url'); ?>logout/">Logout</a></li>
                    <?php } ?>
                </ul>
            </div>
            
            
                
            <div class="bottomtab_area">
            	<div class="main_tab_area">
                    <ul>
                        <li><a href="#">Studio</a></li>
                        <li><a href="#">Locker Room</a></li>
                        <li><a href="#">Me!</a></li>
                    </ul>
                </div>
                <?php
					//print_r($this->session->all_userdata());
				if($this->session->userdata('user_id')==''){
				?>
				<div class="signup_area"><a href="<?php echo $this->config->item('base_url'); ?>signup/">Sign Up</a></div>
				<?php }
				else{ ?>
                <div class="signup_area1"><?php //echo $this->session->userdata('screen_name');?></div>
                <?php  }?>
				
                <div class="search_area">
                    <div class="search_fill">
                        <input type="text" class="search_input" value="" id="site_search" name="site_search" onblur="show_txt('site_search','text_site_search')" style="display:none" />
                        <input type="text" class="search_input" value="Search site" id="text_site_search" name="text_site_search"  onfocus="show_pass('site_search','text_site_search')" onclick="show_pass('site_search','text_site_search')"   />
                    </div>
                    <div class="search_button"><input type="image" src="<?php echo $this->config->item('base_url'); ?>assets/images/search_btn.png" /></div>
                </div>
            </div>
             <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="clearfix"></div>

<!-- End Header Area-->