<!-- Footer Area-->
<div class="clearfix"></div>
<div class="footer_area">
	<div class="footer_main_area">
    	<div class="workout_area workspace">Untitled Workout</div>
        <div class="work_length">
        	<h1>Workout Length: </h1>
            <h2>5  Videos (12min)</h2>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- End Footer Area-->

<!--Simple Modal JS Start-->
<script type="text/javascript">
	//modal window functions
	function closeBox()
	{
		$.modal.close();
	}
	
	function open_messagebox(title, message)
	{
		if(title.length<=0)
		{
			title = 'Alert';
		}
		$("#popup_title").html(title);
		$("#basic-modal-content").modal({escClose:false,focus:true,opacity :30});
		$("#pop_form_area").html(message);
	}
	
</script>
<!--Simple Modal JS End-->

<!--Popup Box DIV-->
<div id="basic-modal-content" style="display: none; min-width:300px; min-height:200px">
    <div class="popup_mainbox">
            <div class="popup_header" >
            
                <div style="float:left; padding-top:3px; padding-left:10px;" id="popup_title"></div>
                <div style="float:right; padding-top:1px;"><a href="javascript:closeBox()" id=""><img src="<?php echo $this->config->item('base_url'); ?>assets/video/cross.png" alt="Close" /></a></div>
                <div class="clear"></div>
            </div>
            <div class="pop_body_area" id="pop_form_area" >
                
            </div>
    </div>
</div>
<!--End Popup Box DIV-->


<div class="chat_area">
	<div class="chat_header">
        <div class="chat_icon">
            <img src="<?php echo $this->config->item("site_url")?>/assets/images/chat_icon.jpg" />
        </div>
        <div class="chat_icon_text">
            Chat (3)
        </div>
    </div>
    
    
</div>  

<div class="chat_body">
    	
        <div class="chat_box_area" style="display:none">
        
        </div>
        
        <div class="chat_search_area" style="display:none">
        
        </div>
</div> 


<script>
function closeBox()
{
	$.modal.close();
}    

$(function() {

	$(".chat_header").click(function() {
		
		if($(".chat_area").css("right")=="0px")
		{
			
			$(".chat_area").css("right","-230px");
			$(".chat_box_area").hide();
		}
		else
		{
			$(".chat_area").css("right","0px");
			
			$.ajax({
			cache:false,
			url: '<?php echo base_url().$this->config->item('index_page');?>chat',
			dataType: "json",
			success: function(data){
			
				//alert(data.chat_area);
				$(".chat_body").show();
				$(".chat_body").html(data.chat_area);
				$(".chat_box_area").show();
				$.ajax({
					cache:false,
					url: '<?php echo base_url().$this->config->item('index_page');?>chat/get_chat_area',
					dataType: "json",
					success: function(data){
						
						$(".chat_search").html(data.search_area);
						$(".chatlist_area").html(data.list_area);
						$(".chatrequest_area").html(data.request_area);
						},
					  error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					  }
				
					},"json");
				
				},
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			  }
		
			},"json");
			
			
		}
		
	});
 
 
});
</script>  
</body>
</html>