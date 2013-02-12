// JavaScript Document

//javascript functions for the project module

function display_exchange_box(currency_value)
{
	//alert(currency_value);
	if (currency_value=='D')
	{
		$('#exchange_rate').fadeIn('slow');
	}else{
		$('#exchange_rate').fadeOut('slow');
	}
}

function project_add_submit_check()
{			
	var flag		= 1;
	var errMsg		= '';
	var chk			= document.getElementsByName('project_category[]');
	var len 		= chk.length;
	var cnt			= 0;						
	
	if ($('#project_name').val().length<=0)
	{
		errMsg		+= 'Enter project name <br>';
		flag		= 0;
	}
	
	if ($('#project_descr').val().length<=0)
	{
		errMsg		+= 'Enter project description <br>';
		flag		= 0;
	}
	
	//checkbox validation
	for(i=0; i<len; i++)
	{
		if (chk[i].checked)
		{
			cnt++;
		}
	}
	
	if (cnt<=0)
	{
		errMsg		+= 'Select a project category <br>';
		flag		= 0;
	}
	
	if ($('#currency').val()=='D' && $('#project_exchange_rate').val().length<=0)
	{
		errMsg		+= 'Enter currency exchange rate <br>';
		flag		= 0;
	}
	
	if ($('#project_revenue').val().length<=0)
	{
		errMsg		+= 'Enter project revenue <br>';
		flag		= 0;
	}
	
	if (flag==0)
	{
		callMsgBox('error', errMsg);
		return false;
	}else{
		return true;
	}
}

function show_hide_project_details(option)
{
	if (option=='show')
	{		
		$('#project_details_edit').hide('slow');
		$('#project_details_view').show('slow');
	}else{		
		$('#project_details_view').hide('slow');
		$('#project_details_edit').show('slow');
	}
}

/****************PROJECT MILESTONES***********************/
function show_hide_project_milestone(option, action, project_id, milestone_id)
{
	//show_hide_project_milestone_edit('hide', '', '');
	clear_milestone_fields();
	$('#project_milestone_edit').hide('slow');
	//alert(option+' '+action+' '+project_id);
	if (option=='show')
	{		
		$('#project_milestone_add').show('slow');
		if (action=='edit')
		{
			$('#mile_action').val('milestone_edit');	
		}else{
			$('#mile_action').val('milestone_add');	
		}				
		$('#mile_project_id').val(project_id);
		$('#milestone_id').val(milestone_id);		
	}else{		
		$('#project_milestone_add').hide('slow');		
	}
}

function clear_milestone_fields()
{
	$('#milestone_dt').val('');	
	$('#milestone_descr').val('');	
	$('#mile_project_id').val('');
	$('#milestone_id').val('');	
}

function load_project_milestones(project_id, url)
{
	$.ajax({
		url: url+"projects/milestones/"+project_id,		
		type: "POST",
		dataType: "json",
		success: function(data){
			//alert(data.result);
			$('#project_milestone_list').html(data.result);
			show_hide_project_milestone_edit('hide', '', '');
		}
	});
}

function milestone_add_submit_check(site_url)
{
	var flag = 1;
	var errMsg = '';
	var milestone_dt = '';
	var milestone_descr = '';
	var num_milestone = parseInt($('#num_milestone').val());
	
	//alert(num_milestone);
	if ($('#milestone_dt').val().length<=0)
	{
		errMsg		+= 'Enter milestone date <br>';
		flag		= 0;
	}else{
		milestone_dt = $('#milestone_dt').val();
	}
	
	if ($('#milestone_descr').val().length<=0)
	{
		errMsg		+= 'Enter milestone description <br>';
		flag		= 0;
	}else{
		milestone_descr = $('#milestone_descr').val();
	}	
	var project_id		= $('#mile_project_id').val();
	var action			= $('#mile_action').val();
	var milestone_id	= $('#milestone_id').val();
	
	if (flag==1)
	{
		//alert('Submit');
		$.ajax({
			url: site_url+"projects/add_milestone/",
			type: "POST",
			data: "milestone_dt="+milestone_dt+"&milestone_descr="+milestone_descr+"&project_id="+project_id+"&milestone_id="+milestone_id+"&action="+action,
			dataType: "json",
			success: function(data)
			{
				if (data.result==1)
				{
					if (num_milestone==0)
					{
						$('#no_milestone').remove();
					}
					show_hide_project_milestone('hide', '', '', '');
					var content = $('#project_milestone_list').html();
					content = content+data.output;
					$('#mile_'+data.milestone_id).css('display', 'none');
					$('#project_milestone_list').html(content);
					$('#mile_'+data.milestone_id).show('slow');
					num_milestone = num_milestone+1;
					$('#num_milestone').val(num_milestone);
				}
			}				   
		});		
	}else{
		callMsgBox('error', errMsg);		
	}
		
}

function show_hide_project_milestone_edit(option, url, milestone_id)
{
	
	show_hide_project_milestone('hide', '', '', '');
	
	if (option=='show')
	{		
		$('#project_milestone_edit').show('slow');
		$.ajax({
			url: url+"projects/get_milestone/",
			type: "POST",
			data: "milestone_id="+milestone_id,
			dataType: "json",
			success: function(data){
				$('#milestone_dt_edit').val(data.milestone_dt);
				$('#milestone_descr_edit').val(data.milestone_descr);
				$('#milestone_id_edit').val(data.milestone_id);
			}
		});
		
	}else{
		//$('[name=is_achieved]').prop('checked', false);
		//$('[name=is_achieved][value=N]').prop('checked', false);
		//$("input:radio").removeAttr("checked");
		$('#project_milestone_edit').hide('slow');	
	}
}

function milestone_edit_submit_check(site_url)
{
	var flag = 1;
	var errMsg = '';
	var milestone_dt = '';
	var milestone_descr = '';
	var is_achieved = $('#is_achieved').val();	
	var milestone_id = $('#milestone_id_edit').val();
	
	var num_milestone = parseInt($('#num_milestone').val());
	
	//alert(num_milestone);
	if ($('#milestone_dt_edit').val().length<=0)
	{
		errMsg		+= 'Enter milestone date <br>';
		flag		= 0;
	}else{
		milestone_dt = $('#milestone_dt_edit').val();
	}
	
	if ($('#milestone_descr_edit').val().length<=0)
	{
		errMsg		+= 'Enter milestone description <br>';
		flag		= 0;
	}else{
		milestone_descr = $('#milestone_descr_edit').val();
	}
	
	var action		= $('#mile_action_edit').val();
	
	
	if (flag==1)
	{
		//alert('Submit');
		$.ajax({
			url: site_url+"projects/edit_milestone/",
			type: "POST",
			data: "milestone_dt="+milestone_dt+"&milestone_descr="+milestone_descr+"&milestone_id="+milestone_id+"&is_achieved="+is_achieved+"&action="+action,
			dataType: "json",
			success: function(data)
			{											
				show_hide_project_milestone_edit('hide', '', '', '');										
				$('#mile_'+data.milestone_id).html(data.output);
				$('#num_milestone').val(num_milestone);			
			}
		});		
	}else{
		callMsgBox('error', errMsg);		
	}		
}

function delete_project_milestone(site_url, milestone_id)
{
	var con = confirm('Are you sure?');
	if (con){
		$.ajax({
			url: site_url+"projects/delete_milestone/",
			type: "POST",
			data: "milestone_id="+milestone_id,		
			success: function(data)
			{			
				$('#mile_'+milestone_id).remove();			
			}
		});
	}
}

/*****************PROJECT MILESTONES*****************/

/*****************PROJECT PAYMENT SCHEDULES****************/
function load_project_payment_schedules(project_id, url)
{
	$.ajax({
		url: url+"projects/payment_schedules/",		
		type: "POST",
		data: "project_id="+project_id,
		dataType: "json",
		success: function(data){
			//alert(data.result);
			$('#project_payment_milestone_list').html(data.output);
			show_hide_project_payment_schedules('hide', '', '', '', '');
		}
	});
}

function clear_payment_fields()
{
	$('#sch_dt').val('');	
	$('#payment_amt').val('');	
	$('#sch_descr').val('');	
}

function show_hide_project_payment_schedules(option, action, project_id, payment_sch_id, site_url)
{
	//show_hide_project_milestone_edit('hide', '', '');
	clear_payment_fields();
	$('#project_payment_schedule_edit').hide('slow');
	//alert(option+' '+action+' '+project_id);
	if (option=='show')
	{	
		if (action=='edit')
		{
			$('#sch_action').val('payment_edit');
			$.ajax({
				url: site_url+"projects/get_payment_schedule/",		
				type: "POST",
				data: "payment_sch_id="+payment_sch_id,
				dataType: "json",
				success: function(data){
					//alert(data.result);
					//$('#project_payment_milestone_list').html(data.output);
					$('#sch_dt').val(data.sch_dt);
					$('#payment_amt').val(data.payment_amt);
					$('#sch_descr').val(data.sch_descr);					
					$('#sch_project_id').val(data.project_id);
					$('#prj_payment_curr').html(data.project_currency);
				}
			});
			
			
		}else{
			$('#sch_action').val('payment_add');
			$.ajax({
				url: site_url+"projects/get_currency/",		
				type: "POST",
				data: "project_id="+project_id,
				dataType: "json",
				success: function(data){
					//alert(data.result);
					//$('#project_payment_milestone_list').html(data.output);					
					$('#prj_payment_curr').html(data.project_currency);
				}
			});
		}
		$('#project_payment_schedule_add').show('slow');
		$('#sch_project_id').val(project_id);
		$('#payment_sch_id').val(payment_sch_id);
	}else{
		$('#project_payment_schedule_add').hide('slow');		
	}
}

function payment_add_submit_check(site_url)
{
	var flag = 1;
	var errMsg = '';
	var sch_dt = '';
	var payment_amt = '';
	var sch_descr = '';
	var num_payment = parseInt($('#num_payment').val());
	
	//alert(num_milestone);
	if ($('#sch_dt').val().length<=0)
	{
		errMsg		+= 'Enter payment date <br>';
		flag		= 0;
	}else{
		sch_dt 		= $('#sch_dt').val();
	}
	
	if ($('#payment_amt').val().length<=0)
	{
		errMsg		+= 'Enter payment amount <br>';
		flag		= 0;
	}else{
		payment_amt	= $('#payment_amt').val();
	}
	
	if ($('#sch_descr').val().length<=0)
	{
		errMsg		+= 'Enter payment description <br>';
		flag		= 0;
	}else{
		sch_descr 	= $('#sch_descr').val();
	}
	
	var project_id		= $('#sch_project_id').val();
	var action			= $('#sch_action').val();
	var payment_sch_id	= $('#payment_sch_id').val();
	
	if (flag==1)
	{
		//alert('Submit');
		$.ajax({
			url: site_url+"projects/add_payment_schedules/",
			type: "POST",
			data: "payment_sch_id="+payment_sch_id+"&project_id="+project_id+"&payment_amt="+payment_amt+"&sch_descr="+sch_descr+"&sch_dt="+sch_dt+"&action="+action,
			dataType: "json",
			success: function(data)
			{				
				if (data.result==1)
				{
					if (num_payment==0)
					{
						$('#no_payment').remove();
					}
					if (action=='payment_add')
					{
						show_hide_project_payment_schedules('hide', '', '', '', '');
						var content = $('#project_payment_milestone_list').html();					
						content = content+data.output;					
						$('#project_payment_milestone_list').html(content);
						$('#pay_'+data.payment_sch_id).css('display', 'none');
						$('#pay_'+data.payment_sch_id).show('slow');
						num_payment = num_payment+1;
						$('#num_payment').val(num_payment);
					}else if(action=='payment_edit')
					{
						$('#pay_'+payment_sch_id).html(data.output);
						show_hide_project_payment_schedules('hide', '', '', '', '');
					}
				}
			}				   
		});		
	}else{
		callMsgBox('error', errMsg);		
	}		
}

function delete_project_payment(site_url, payment_sch_id)
{	
	var con = confirm('Are you sure?');
	if (con){
		$.ajax({
			url: site_url+"projects/delete_payment/",
			type: "POST",
			data: "payment_sch_id="+payment_sch_id,		
			success: function(data)
			{			
				$('#pay_'+payment_sch_id).remove();			
			}
		});
	}
}

/********************PROJECT PAYMENT SCHEDULES********************/


/********************PROJECT MEMBERS********************/
function load_project_members(project_id, site_url)
{
	$.ajax({
		url: site_url+"projects/project_members/",		
		type: "POST",
		data: "project_id="+project_id,
		dataType: "json",
		success: function(data){
			//alert(data.result);
			$('#project_members_list').html(data.output);
			show_hide_project_member_add('hide', '', '', '', '');
		}
	});
}

function clear_member_add_fields()
{
	$('#rate_per_hour').val('');	
}

function show_hide_project_member_add(option, action, project_id, prj_user_id, site_url)
{
	//show_hide_project_milestone_edit('hide', '', '');
	clear_member_add_fields();
	var user_id = '';
	
	if (option=='show')
	{						
		$('#project_members_add').show('slow');
		$('#mem_project_id').val(project_id);
		$('#prj_user_id').val(prj_user_id);
		
		$.ajax({
			url: site_url+"projects/get_currency/",		
			type: "POST",
			data: "project_id="+project_id,
			dataType: "json",
			success: function(data){
				//alert(data.result);
				//$('#project_payment_milestone_list').html(data.output);					
				$('#prj_member_cur').html(data.project_currency);
			}
		});
		
		if (action=='edit')
		{
			$('#mem_action').val('member_edit');
			$.ajax({
				url: site_url+"projects/project_member_detail/",		
				type: "POST",
				data: "prj_user_id="+prj_user_id,
				dataType: "json",
				success: function(data){
					//alert(data.result);
					//$('#project_members_list').html(data.output);
					user_id = data.prj_mem_user_id;
					$('#rate_per_hour').val(data.rate_per_hour);
					$('#mem_action').val('member_edit');
				}
			});
			$("#prj_mem_user_id").attr('disabled', 'true');
		}else{			
			$('#mem_action').val('member_add');
			$("#prj_mem_user_id").removeAttr('disabled');
			$("#prj_mem_user_id").load(site_url+"projects/project_load_members/"+project_id+"/"+user_id);
		}
				
		
	}else{
		$('#project_members_add').hide('slow');		
	}
}

function project_member_add(site_url)
{
	var flag = 1;
	var errMsg = '';
	var prj_mem_user_id = '';
	var rate_per_hour = '';
	var prj_user_id = $('#prj_user_id').val();
	var project_id = $('#mem_project_id').val();
	var action = $('#mem_action').val();
	var num_members = parseInt($('#num_members').val());
	
	//alert(num_milestone);
	if ($('#prj_mem_user_id').val()==0 && action=='member_add')
	{
		errMsg		+= 'Select a member <br>';
		flag		= 0;
	}else{
		prj_mem_user_id 	= $('#prj_mem_user_id').val();
	}
	
	if ($('#rate_per_hour').val().length<=0)
	{
		errMsg		+= 'Enter member rate per hour <br>';
		flag		= 0;
	}else{
		rate_per_hour 		= $('#rate_per_hour').val();
	}
		
	if (flag==1)
	{
		$.ajax({
			url: site_url+"projects/project_add_members/",		
			type: "POST",
			data: "project_id="+project_id+"&prj_mem_user_id="+prj_mem_user_id+"&rate_per_hour="+rate_per_hour+"&prj_user_id="+prj_user_id+"&action="+action,
			dataType: "json",
			success: function(data){
				//alert(data.result);
				if (action=='member_add')
				{
					if (num_members==0)
					{
						$('#no_proj_members').remove();
					}
					var content = $('#project_members_list').html();
					content = content+data.output;
					$('#project_members_list').html(content);
					$('#member_'+data.prj_user_id).css('display', 'none');
					$('#member_'+data.prj_user_id).show('slow');
					num_members = num_members+1;
					$('#num_members').val(num_members);
					show_hide_project_member_add('hide', '', '', '', '');
					callMsgBox('success', 'Member successfully added to project');
				}else if (action=='member_edit')
				{
					var rate = parseFloat(data.rate_per_hour);
					$('#member_rate_'+prj_user_id).html(rate.toFixed(3));
					callMsgBox('success', 'Member rate per hour updated successfully');
				}
			}
		});
		
	}else{
		callMsgBox('error', errMsg);
	}
}

function delete_project_member(site_url, prj_user_id)
{
	var con = confirm('Are you sure?');
	if (con)
	{
		$.ajax({
			url: site_url+"projects/project_member_delete/",
			type: "POST",
			data: "prj_user_id="+prj_user_id,		
			success: function(data){				
				$('#member_'+prj_user_id).remove();
				callMsgBox('success', 'Member successfully deleted from project');
			}
		});
	}
}

function set_observer(site_url, prj_user_id)
{
	var con = confirm('Are you sure?');
	if (con)
	{
		$.ajax({
			url: site_url+"projects/project_set_observer/",
			type: "POST",
			data: "prj_user_id="+prj_user_id,
			success: function(data){		
				$('#member_'+prj_user_id).remove();
				callMsgBox('success', 'Member successfully added as observer for the project');
			}
		});
	}
}

/********************PROJECT MEMBERS********************/

/********************PROJECT OBSERVERS********************/
function load_project_observers(project_id, site_url)
{
	$.ajax({
		url: site_url+"projects/project_observers/",		
		type: "POST",
		data: "project_id="+project_id,
		dataType: "json",
		success: function(data){
			//alert(data.result);
			$('#project_observers_list').html(data.output);
		}
	});
}

function delete_project_observer(site_url, prj_obs_id)
{
	var con = confirm('Are you sure?');
	if (con)
	{
		$.ajax({
			url: site_url+"projects/project_observer_delete/",
			type: "POST",
			data: "prj_obs_id="+prj_obs_id,		
			success: function(data){				
				$('#observer_'+prj_obs_id).remove();
				num_observers = parseInt($('#num_observers').val());
				num_observers = num_observers-1;
				$('#num_observers').val(num_observers);
				if (num_observers==0)
				{
					$('#project_observers_list').html('<div id="no_proj_observers" style="clear:both;"><div class="mile_content1" style="width:100%;">No Observers Addded</div></div>');
				}
				callMsgBox('success', 'Observer successfully deleted from project');
			}
		});	
	}
}

/********************PROJECT OBSERVERS********************/

/********************PROJECT DOCUMENTS********************/

function load_project_docs_list(project_id, site_url)
{
	$.ajax({
		url: site_url+"projects/project_docs_list/",
		type: "POST",
		data: "project_id="+project_id,
		dataType: "json",
		success: function(data){
			//alert(data.result);
			$('#project_docs_list').html(data.output);
			show_hide_project_doc_add('hide', '', '', '', '');
		}
	});
}

function clear_project_doc_fields()
{
	$('#fileToUpload').val('');
	$('#file_descr').val('');
}

function ajaxFileUpload(site_url, project_id)
{
	if ($('#fileToUpload').val().length<=0)
	{
		callMsgBox('error', 'Select a file to upload');
	}else{
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
		
		var file_descr = $('#file_descr').val();
		$.ajaxFileUpload
		(
			{			
				url: site_url+'projects/project_doc_upload/'+project_id+'/'+file_descr+'/',
				/*secureuri: false,*/
				fileElementId: 'fileToUpload',
				dataType: 'json',
				data: "project_id="+project_id,
				type: "POST",
				success: function (data, status)
				{
					if (data.is_error==0)
					{
						load_project_docs_list(project_id, site_url);
						show_hide_project_doc_add('hide', '', '', '', '');
						callMsgBox('success', data.msg);						
					}else if (data.is_error==1)
					{
						callMsgBox('error', data.error);
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
	}
	return false;
}

function delete_project_doc(doc_id, site_url)
{
	var con = confirm('Are you sure?');
	if (con)
	{
		$.ajax({
			url: site_url+"projects/project_doc_delete",
			type: "POST",
			data: "doc_id="+doc_id,
			success: function(data){
				$('#doc_'+doc_id).remove();
				var num_doc = parseInt($('#num_docs').val());
				num_doc = num_doc-1;
				if (num_doc==0)
				{
					$('#project_docs_list').html('<div id="no_docs" style="clear:both;"><div class="mile_content1" style="width:100%;">No Documents Addded</div></div>');						
				}
				$('#num_docs').val(num_doc);
			}
		});	
	}
}

function show_hide_project_doc_add(option, action, project_id, doc_id, site_url)
{
	clear_project_doc_fields();
	if (option=='show')
	{
		$('#project_docs_add').show('slow');
	}else{
		$('#project_docs_add').hide('slow');
	}
}

function download(site_url, doc_id)
{
	$.ajax({
		url: site_url+"projects/download_project_doc",
		type: "POST",
		data: "doc_id="+doc_id,
		success: function(data){
			//code to do on success
			//alert(data);
		}
	});	
}


/********************PROJECT DOCUMENTS********************/


/********************PROJECT CLIENT********************/
function load_project_client(project_id, site_url)
{	
	$.ajax({
		url: site_url+"projects/project_client_view/",
		type: "POST",
		data: "project_id="+project_id,
		dataType: "json",
		success: function(data){
			$('#project_client_view').html(data.output);
			show_add_edit_project_client('hide', '', '', '', '');
			//$('#add_client_link').show();
			//$('#edit_client_link').hide();
		}
	});	
}

function show_add_edit_project_client(option, action, project_id, client_id, site_url)
{
	clear_client_fields();
	if (option=='show')
	{		
		$('#project_client_edit').show('slow');
		$('#client_project_id').val(project_id);	
		$('#client_id').val(client_id);
		
		if (action=='add')
		{
			$('#clint_project_action').val('client_add');	
		}else if (action=='edit')
		{
			$('#clint_project_action').val('client_edit');
			$.ajax({
				url: site_url+"projects/project_client_info/",
				data: "client_id="+client_id,
				type: "POST",
				dataType: "json",
				success: function(data){					
					$('#client_name').val(data.output.client_name);
					$('#client_manager_name').val(data.output.client_manager_name);
					$('#client_email').val(data.output.client_email);
					$('#client_contact_no').val(data.output.client_contact_no);
					$('#client_alt_email').val(data.output.client_alt_email);
					$('#client_alt_contact_no').val(data.output.client_alt_contact_no);
				}
			});
		}
		
	}else{
		$('#project_client_edit').hide('slow');
	}
}

function clear_client_fields()
{
	$('#client_name').val();
	$('#client_manager_name').val();
	$('#client_email').val();
	$('#client_contact_no').val();
	$('#client_alt_email').val();
	$('#client_alt_contact_no').val();
}

function add_edit_client(site_url)
{
	var action = $('#clint_project_action').val();
	var project_id = $('#client_project_id').val();
	var client_id = $('#client_id').val();
	var client_name = '';
	var client_manager_name = '';
	var client_email = '';
	var client_contact_no = '';
	var client_alt_email = '';
	var client_alt_contact_no = '';
	var flag = 0;
	var errMsg = '';
	
	if ($('#client_name').val().length<=0)
	{
		errMsg += 'Enter Client Name <br>';
		flag = flag+1;
	}else{
		client_name = $('#client_name').val();
	}
	
	if ($('#client_manager_name').val().length<=0)
	{
		errMsg += 'Enter Client Manager Name <br>';
		flag = flag+1;
	}else{
		client_manager_name = $('#client_manager_name').val();
	}
	
	if ($('#client_email').val().length<=0)
	{
		errMsg += 'Enter Client Email <br>';
		flag = flag+1;
	}else{
		if (IsEmail($('#client_email').val()))
		{
			client_email = $('#client_email').val();
		}else{
			errMsg += 'Enter Valid Email Id <br>';
			flag = flag+1;
		}
	}
	
	client_contact_no = $('#client_contact_no').val();
	client_alt_email = $('#client_alt_email').val();
	client_alt_contact_no = $('#client_alt_contact_no').val();
	
	if (flag==0)
	{
		$.ajax({
			url: site_url+"projects/project_client_add/",
			type: "POST",
			data: "action="+action+"&project_id="+project_id+"&client_id="+client_id+"&client_name="+client_name+"&client_manager_name="+client_manager_name+"&client_email="+client_email+"&client_contact_no="+client_contact_no+"&client_alt_email="+client_alt_email+"&client_alt_contact_no="+client_alt_contact_no,
			dataType: "json",
			success: function(data){
				load_project_client(project_id, site_url);
				show_add_edit_project_client('hide', '', '', '', '');
			}
		});
	}else{
		callMsgBox('error', errMsg);	
	}
	
}

/********************PROJECT CLIENT********************/

//validate email id
function IsEmail(email) 
{
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}



/********************PROJECT INTERNAL COST********************/
function load_internal_cost(project_id, site_url)
{
	$('#prj_int_cost_loading').show();
	$.ajax({
		url: site_url+"projects/project_internal_cost_list/",
		type: "POST",
		data: "project_id="+project_id,
		dataType: "json",
		success: function(data){
			$('#project_internal_cost_view').html(data.output);
			//show_add_edit_project_client('hide', '', '', '', '');
			//$('#add_client_link').show();
			//$('#edit_client_link').hide();
		}
	});
	
	$.ajax({
		url: site_url+"projects/project_member_cost/",
		type: "POST",
		data: "project_id="+project_id,
		dataType: "json",
		success: function(data){
			$('#project_internal_resource_cost_view').html(data.output);
			//show_add_edit_project_client('hide', '', '', '', '');
			//$('#add_client_link').show();
			//$('#edit_client_link').hide();
		}
	});
	
	$('#prj_int_cost_loading').hide();
}

function show_add_edit_project_owner(option, action, project_id, int_cost_id, site_url)
{
	$('#prj_int_cost_loading').show();
	if (option=='show')
	{			
		$('#project_internal_cost_add').show('slow');
		$('#rate_per_hr').focus();
		$('#rate_per_hr').val('');
		$('#number_of_hr').val('');
		$('#int_project_id').val(project_id);	
		$('#int_cost_id').val(int_cost_id);
		
		$.ajax({
			url: site_url+"projects/get_currency/",		
			type: "POST",
			data: "project_id="+project_id,
			dataType: "json",
			success: function(data){
				//alert(data.result);
				//$('#project_payment_milestone_list').html(data.output);					
				$('#prj_owner_curr').html(data.project_currency);
			}
		});		
		
		if (action=='add')
		{
			$('#int_action').val('owner_add');	
		}else if (action=='edit')
		{
			$('#int_action').val('owner_edit');
			$.ajax({
				url: site_url+"projects/project_get_owner_cost_info/",
				data: "int_cost_id="+int_cost_id,
				type: "POST",
				dataType: "json",
				success: function(data){					
					$('#number_of_hr').val(data.number_of_hr);
					$('#rate_per_hr').val(data.rate_per_hr);					
				}
			});
		}
		
	}else{
		$('#project_internal_cost_add').hide('slow');
	}
	$('#prj_int_cost_loading').hide();
}

function project_owner_cost_add(site_url)
{
	var flag = 1;
	var errMsg = '';
	var number_of_hr = '';
	var rate_per_hr = '';	
	var project_id = $('#int_project_id').val();
	var int_cost_id = $('#int_cost_id').val();
	var action = $('#int_action').val();
	var num_owner_cost = parseInt($('#num_owner_cost').val());
	
	//alert(num_milestone);
	if ($('#rate_per_hr').val().length<=0)
	{
		errMsg		+= 'Enter rate per hour <br>';
		flag		= 0;
	}else{
		rate_per_hr 	= $('#rate_per_hr').val();
	}
	
	if ($('#number_of_hr').val().length<=0)
	{
		errMsg		+= 'Enter number of hours <br>';
		flag		= 0;
	}else{
		number_of_hr 		= $('#number_of_hr').val();
	}
		
	if (flag==1)
	{
		$('#prj_int_cost_loading').show();
		$.ajax({
			url: site_url+"projects/project_add_owner_cost/",		
			type: "POST",
			data: "project_id="+project_id+"&number_of_hr="+number_of_hr+"&rate_per_hr="+rate_per_hr+"&int_cost_id="+int_cost_id+"&action="+action,
			dataType: "json",
			success: function(data){
				//alert(data.result);
				load_internal_cost(project_id, site_url);
				if (action=='owner_add')
				{					
					show_add_edit_project_owner('hide', '', '', '', '');
					callMsgBox('success', 'Owner cost successfully added to project');
				}else if (action=='owner_edit')
				{					
					show_add_edit_project_owner('hide', '', '', '', '');
					callMsgBox('success', 'Owner cost updated updated successfully');
				}
			}
		});
		$('#prj_int_cost_loading').hide();
	}else{
		callMsgBox('error', errMsg);
	}
}

function delete_project_owner_cost(project_id, int_cost_id, site_url)
{
	var con = confirm('Are you sure?');
	if (con)
	{
		$.ajax({
			url: site_url+"projects/project_delete_owner_cost",
			type: "POST",
			data: "int_cost_id="+int_cost_id,
			success: function(data){
				load_internal_cost(project_id, site_url);
			}
		});	
	}
}

function internal_cost_user_report_view(site_url, project_id, user_id)
{
	$('#fade').show();
	$('#jobReportDetails').show('slow');
	get_internal_cost_details(site_url, project_id, user_id);
	
	
}

function internal_cost_user_report_hide()
{
	$('#fade').hide();
	$('#jobReportDetails').hide('slow');
}

function get_internal_cost_details(site_url, project_id, user_id)
{
	$('#prj_job_loading3').css('display', 'block');
	$.ajax({
		url: site_url+'jobs/get_jobs_internal_cost_first_stage',
		type: 'POST',
		data: 'project_id='+project_id+'&user_id='+user_id,
		dataType: 'json',
		success: function (data){
			$('#job_report_details_view').html(data.output);
			//alert('success');
		}
	});
	$('#prj_job_loading3').css('display', 'none');
	
}

function get_job_report_details(site_url, todo_id)
{
	//alert(todo_id);
	$('#prj_job_loading3').css('display', 'block');
	$.ajax({
		url: site_url+'jobs/get_jobs_internal_cost_second_stage',
		type: 'POST',
		data: 'todo_id='+todo_id,
		dataType: 'json',
		success: function (data){
			//$('#job_report_details_view').html(data.output);
			$('#job_report_details_'+todo_id).css('display', 'none');
			$('#job_report_details_'+todo_id).html(data.output);
			$('#job_report_details_'+todo_id).fadeIn('slow');
			$('#disp_details_'+todo_id).css('display', 'none');
			$('#hide_details_'+todo_id).css('display', 'block');
			//alert('success');
		}
	});
	$('#prj_job_loading3').css('display', 'none');
}

function hide_job_report_details(todo_id)
{
	$('#job_report_details_'+todo_id).fadeOut('slow');
	$('#hide_details_'+todo_id).css('display', 'none');
	$('#disp_details_'+todo_id).css('display', 'block');
}


/********************PROJECT INTERNAL COST********************/

/********************PROJECT EXTERNAL COST********************/
function load_external_cost(project_id, site_url)
{
	$('#prj_ext_cost_loading').show();
	$.ajax({
		url: site_url+"projects/project_external_cost_list/",
		type: "POST",
		data: "project_id="+project_id,
		dataType: "json",
		success: function(data){
			$('#project_external_cost_view').html(data.output);
			//show_add_edit_project_client('hide', '', '', '', '');
			//$('#add_client_link').show();
			//$('#edit_client_link').hide();
		}
	});
	
	$('#prj_ext_cost_loading').hide();
}

function show_add_edit_project_external(option, action, project_id, vendor_id, site_url)
{
	$('#prj_ext_cost_loading').show();
	clear_external_cost_fields();
	if (option=='show')
	{			
		$('#project_external_cost_add').show('slow');
		$('#vendor_name').focus();
		$('#ext_project_id').val(project_id);	
		$('#vendor_id').val(vendor_id);
		
		$.ajax({
			url: site_url+"projects/get_currency/",		
			type: "POST",
			data: "project_id="+project_id,
			dataType: "json",
			success: function(data){
				//alert(data.result);
				//$('#project_payment_milestone_list').html(data.output);					
				$('#prj_external_curr').html(data.project_currency);
			}
		});
		
		if (action=='add')
		{
			$('#ext_action').val('external_add');	
		}else if (action=='edit')
		{
			$('#ext_action').val('external_edit');
			$.ajax({
				url: site_url+"projects/project_external_cost_info/",
				data: "vendor_id="+vendor_id,
				type: "POST",
				dataType: "json",
				success: function(data){					
					$('#vendor_name').val(data.output.vendor_name);
					$('#vendor_type').val(data.output.vendor_type);					
					if (data.output.vendor_type=='C')
					{
						$('#consultant_nature').css('display', 'block');
						$('#nature_of_job_con').val(data.output.job_nature);
						
						if (data.output.job_nature=='other')
						{
							$('#other_cost_txt').css('display', 'block');
							$('#other_cost').val(data.output.other_nature);
						}
					}else if(data.output.vendor_type=='M')
					{
						$('#material_nature').css('display', 'block');
						$('#nature_of_job_mat').val(data.output.job_nature);
						
						if (data.output.job_nature=='other')
						{
							$('#other_cost_txt').css('display', 'block');
							$('#other_cost').val(data.output.other_nature);
						}
					}
					$('#rate').val(data.output.rate);
					$('#hrs').val(data.output.hrs);
					$('#cost').val(data.output.cost);					
				}
			});
		}
		
	}else{
		$('#project_external_cost_add').hide('slow');
	}
	$('#prj_ext_cost_loading').hide();
}

function clear_external_cost_fields()
{
	$('#vendor_name').val('');
	$('#vendor_type').val('sel');
	$('#consultant_nature').css('display', 'none');
	$('#material_nature').css('display', 'none');
	$('#other_cost_txt').css('display', 'none');
	$('#other_cost').val('');
	$('#rate').val('');
	$('#hrs').val('');
	$('#cost').val('');	
}


function display_vendor_nature(vendor_type)
{
	if (vendor_type=='sel')	
	{
		$('#consultant_nature').fadeOut();	
		$('#material_nature').fadeOut();
		$('#other_cost_txt').fadeOut();
	}else if (vendor_type=='C')
	{
		$('#material_nature').fadeOut('slow');
		$('#other_cost_txt').fadeOut();
		$('#consultant_nature').fadeIn('slow');
		$('#nature_of_job_con').val('consulting');
	}else if (vendor_type=='M')
	{
		$('#consultant_nature').fadeOut('slow');
		$('#other_cost_txt').fadeOut();
		$('#material_nature').fadeIn('slow');
		$('#nature_of_job_mat').val('printing');
	}
}

function display_other_box(job_nature)
{
	if (job_nature=='other')
	{
		$('#other_cost_txt').fadeIn('slow');
		$('#other_cost').focus();
	}else{
		$('#other_cost_txt').fadeOut('slow');	
	}
}

function calculate_total_cost()
{
	var rate = 0.00;
	
	if ($('#rate').val()!='')
	{
		rate = parseFloat($('#rate').val());	
	}	
	var hrs = 0.00;
	if ($('#hrs').val()!='')
	{
		hrs = parseFloat($('#hrs').val());	
	}	
	var cost = (hrs*rate);
	$('#cost').val(cost.toFixed(2));
}

function add_edit_external_cost(site_url)
{
	var project_id = $('#ext_project_id').val();
	var vendor_id = $('#vendor_id').val();
	var ext_action = $('#ext_action').val();
	var flag = 0;
	var errMsg = '';
	var vendor_name = '';
	var vendor_type = '';
	var job_nature = '';
	var other_nature = '';
	var rate = '';
	var hrs = '';
	var cost = '';
	
	if ($('#vendor_name').val().length<=0)
	{
		errMsg		+= 'Enter vendor name <br>';
		flag		+= 1;
	}else{
		vendor_name = $('#vendor_name').val();
	}
	
	if ($('#vendor_type').val().length<=0)
	{
		errMsg		+= 'Select vendor type <br>';
		flag		+= 1;
	}else{
		vendor_type = $('#vendor_type').val();
	}
	
	if ($('#vendor_type').val()=='sel')
	{
		errMsg		+= 'Select vendor type <br>';
		flag		+= 1;
	}else{
		vendor_type = $('#vendor_type').val();
	}
	
	if (vendor_type=='C')
	{
		job_nature = $('#nature_of_job_con').val();	
	}else if (vendor_type=='M')
	{
		job_nature = $('#nature_of_job_mat').val();	
	}
	
	if (job_nature=='other' && $('#other_cost').val().length<=0)
	{
		errMsg		+= 'Enter other cost <br>';
		flag		+= 1;
	}else{
		other_nature = $('#other_cost').val();
	}
	
	if ($('#rate').val().length<=0)
	{
		errMsg		+= 'Enter rate per unit <br>';
		flag		+= 1;
	}else{
		rate = $('#rate').val();
	}
	
	if ($('#hrs').val().length<=0)
	{
		errMsg		+= 'Enter total hours or num of units <br>';
		flag		+= 1;
	}else{
		hrs = $('#hrs').val();
	}
	
	if ($('#cost').val().length<=0)
	{
		errMsg		+= 'Enter total cost <br>';
		flag		+= 1;
	}else{
		cost = $('#cost').val();
	}
	
	if (flag==0)
	{
		$.ajax({
			url: site_url+'projects/project_external_cost_add/',
			type: 'POST',
			data: 'project_id='+project_id+'&vendor_id='+vendor_id+'&action='+ext_action+'&vendor_name='+vendor_name+'&vendor_type='+vendor_type+'&job_nature='+job_nature+'&other_nature='+other_nature+'&rate='+rate+'&hrs='+hrs+'&cost='+cost,
			dataType: 'json',
			success: function(data){
				load_external_cost(project_id, site_url);
				show_add_edit_project_external('hide', '', '', '', '');
			}
		});
	}else{
		callMsgBox('error', errMsg);	
	}	
}

function delete_project_external_cost(vendor_id, project_id, site_url)
{
	var con = confirm('Are you sure?');
	
	if (con)
	{
		$.ajax({
			url: site_url+'projects/project_external_cost_delete/',
			type: 'POST',
			data: 'vendor_id='+vendor_id,			
			success: function(data)
			{
				load_external_cost(project_id, site_url);				
			}
		});
	}
}

/********************PROJECT EXTERNAL COST********************/


/********************PROJECT OTHER COST********************/
function load_other_cost(project_id, site_url)
{
	$('#prj_other_cost_loading').show();
	$.ajax({
		url: site_url+"projects/project_other_cost_list/",
		type: "POST",
		data: "project_id="+project_id,
		dataType: "json",
		success: function(data){
			$('#project_other_cost_view').html(data.output);
			//show_add_edit_project_client('hide', '', '', '', '');
			//$('#add_client_link').show();
			//$('#edit_client_link').hide();
		}
	});
	
	$('#prj_other_cost_loading').hide();
}

function show_hide_project_other_cost_add(option, action, project_id, other_cost_id, site_url)
{
	$('#prj_other_cost_loading').show();
	clear_other_cost_fields();
	
	clear_external_cost_fields();
	if (option=='show')
	{	
		$('#project_other_cost_add').show('slow');
		$('#cost_descr').focus();
		$('#other_project_id').val(project_id);	
		$('#other_cost_id').val(other_cost_id);
		
		$.ajax({
			url: site_url+"projects/get_currency/",		
			type: "POST",
			data: "project_id="+project_id,
			dataType: "json",
			success: function(data){
				//alert(data.result);
				//$('#project_payment_milestone_list').html(data.output);					
				$('#prj_other_curr').html(data.project_currency);
			}
		});
		
		if (action=='add')
		{
			$('#other_action').val('other_add');	
		}else if (action=='edit'){
			$('#other_action').val('other_edit');
			
			$.ajax({
				url: site_url+'projects/project_other_cost_info/',
				type: 'POST',
				data: 'other_cost_id='+other_cost_id,
				dataType: 'json',
				success: function(data)
				{
					$('#cost_descr').val(data.output.cost_descr);
					$('#extern_intern').val(data.output.extern_intern);
					$('#cost_type').val(data.output.cost_type);
					$('#is_paid_by_client').val(data.output.is_paid_by_client);
					$('#other_costs').val(data.output.cost);
					//load_external_cost(project_id, site_url);				
				}
			});
			
		}
		
	}else{
		$('#project_other_cost_add').hide('slow');
	}
	$('#prj_other_cost_loading').hide();
}

function clear_other_cost_fields()
{
	$('#cost_descr').val('');
	$('#extern_intern').val('I');
	$('#cost_type').val('food');
	$('#is_paid_by_client').val('N');	
	$('#other_costs').val('');
}

function add_edit_other_cost(site_url)
{
	var project_id = $('#other_project_id').val();
	var other_cost_id = $('#other_cost_id').val();
	var other_action = $('#other_action').val();
	var flag = 0;
	var errMsg = '';
	var extern_intern = '';
	var cost_descr = '';
	var cost_type = '';
	var is_paid_by_client = '';	
	var cost = '';
	
	if ($('#cost_descr').val().length<=0)
	{
		errMsg		+= 'Enter cost description <br>';
		flag		+= 1;
	}else{
		cost_descr = $('#cost_descr').val();
	}
	
	extern_intern = $('#extern_intern').val();
	cost_type = $('#cost_type').val();
	is_paid_by_client = $('#is_paid_by_client').val();		
	
	if ($('#other_costs').val().length<=0)
	{
		errMsg		+= 'Enter total cost <br>';
		flag		+= 1;
	}else{
		cost = $('#other_costs').val();
	}
	
	if (flag==0)
	{
		$.ajax({
			url: site_url+'projects/project_other_cost_add/',
			type: 'POST',
			data: 'project_id='+project_id+'&other_cost_id='+other_cost_id+'&action='+other_action+'&cost_descr='+cost_descr+'&extern_intern='+extern_intern+'&cost_type='+cost_type+'&is_paid_by_client='+is_paid_by_client+'&cost='+cost,
			dataType: 'json',
			success: function(data){
				load_other_cost(project_id, site_url);
				show_hide_project_other_cost_add('hide', '', '', '', '');
			}
		});
	}else{
		callMsgBox('error', errMsg);	
	}	
}

function delete_project_other_cost(other_cost_id, project_id, site_url)
{
	var con = confirm('Are you sure?');
	if (con)
	{
		$.ajax({
			url: site_url+'projects/project_other_cost_delete/',
			type: 'POST',
			data: 'other_cost_id='+other_cost_id,			
			success: function(data)
			{
				load_other_cost(project_id, site_url);				
			}
		});	
	}
}

/********************PROJECT OTHER COST********************/
