// JavaScript Document

/*****************JOBS LIST******************/
function jobs_list(site_url)
{
	$('#prj_job_loading').css('display', 'block');
	show_add_edit_jobs('hide', '', '', '');
	$.ajax({
		url: site_url+'jobs/jobs_list/',
		dataType: 'json',
		success: function (data){
			$('#jobs_list_view').html(data.output);	
		}		
	});
	$('#prj_job_loading').css('display', 'none');
}

function clear_job_fields()
{
	$('#todo_name').val('');
	$('#todo_descr').val('');
	$('#assigned_to').val(0);
	$('#todo_project_id').val(0);
}

function show_add_edit_jobs(option, action, todo_id, site_url)
{
	var edit = 0;
	var project_id = '';
	var member_id = '';
	
	clear_job_fields();
	$('#prj_job_loading').css('display', 'block');
	if(option=='show')
	{
		$('#user_job_add').fadeIn('slow');
		$('#todo_name').focus();
		if (action=='edit')
		{
			$('#todo_action').val('todo_edit');
			$('#todo_id').val(todo_id);
			edit = 1;
			//load_job_projects(edit, site_url);
			$.ajax({
				url: site_url+'jobs/get_job/',
				type: 'POST',
				data: 'todo_id='+todo_id,
				dataType: 'json',
				success: function (data){
					//alert(data.todo_id);
					project_id = data.project_id;
					member_id = data.assigned_to;
					$('#todo_name').val(data.todo_name);
					$('#todo_descr').val(data.todo_descr);
					load_job_projects(edit, site_url, project_id);
					load_job_project_members(project_id, site_url, member_id);
					
					if (data.todo_status!='I')
					{
						$('#assigned_to').attr('disabled', 'true');
						$('#todo_project_id').attr('disabled', 'true');	
					}else{
						$('#assigned_to').removeAttr('disabled');
						$('#todo_project_id').removeAttr('disabled');	
					}
				}
			});
		}else{
			$('#todo_action').val('todo_add');	
		}
		
		load_job_projects(edit, site_url, project_id);
		
		$('#assigned_to').removeAttr('disabled');
		$('#todo_project_id').removeAttr('disabled');	
		
	}else{
		$('#user_job_add').fadeOut('slow');
	}
	$('#prj_job_loading').css('display', 'none');
}

function load_job_projects(edit, site_url, project_id)
{
	
	$.ajax({
		url: site_url+'jobs/project_users_owner/',
		type: 'POST',
		data: 'edit='+edit+'&project_id='+project_id,
		dataType: 'json',
		success: function (data){
			$('#todo_project_id').html(data.output);	
		}		
	});
}

function load_job_project_members(project_id, site_url, member_id)
{
	$.ajax({
		url: site_url+'jobs/project_members/',
		type: 'POST',
		data: 'project_id='+project_id+'&member_id='+member_id,
		dataType: 'json',
		success: function (data){
			$('#assigned_to').html(data.output);
		}		
	});
}


function add_edit_job(site_url)
{
	var flag = 0;
	var errMsg = '';
	var todo_name = '';
	var todo_descr = '';
	var project_id = '';
	var assigned_to = '';	
	var action = $('#todo_action').val();
	var todo_id = $('#todo_id').val();
	
	if ($('#todo_name').val().length<=0)
	{
		errMsg += 'Enter a job name <br>';
		flag = flag + 1;
	}else{
		todo_name = $('#todo_name').val();
	}
	
	if ($('#todo_descr').val().length<=0)
	{
		errMsg += 'Enter a job description <br>';
		flag = flag + 1;
	}else{
		todo_descr = $('#todo_descr').val();
	}
	
	if ($('#todo_project_id').val()==0)
	{
		errMsg += 'Select a project <br>';
		flag = flag + 1;
	}else{
		project_id = $('#todo_project_id').val();
	}
	
	if ($('#assigned_to').val()==0)
	{
		errMsg += 'Select a project member <br>';
		flag = flag + 1;
	}else{
		assigned_to = $('#assigned_to').val();
	}
	
	if (flag==0)
	{
		//add job
		$('#prj_job_loading').css('display', 'block');
		$.ajax({
			url: site_url+'jobs/add_jobs/',
			type: 'POST',
			data: 'todo_name='+todo_name+'&todo_descr='+todo_descr+'&project_id='+project_id+'&assigned_to='+assigned_to+'&todo_id='+todo_id+'&action='+action,
			success: function (data){
				//$('#assigned_to').html(data.output);
				jobs_list(site_url);
				show_add_edit_jobs('hide', '', '', '');
				
				if (action=='todo_add')
				{
					callMsgBox('success', 'Job added successfully');	
				}else{
					callMsgBox('success', 'Job updated successfully');	
				}
			}		
		});
		$('#prj_job_loading').css('display', 'none');
	}else{
		callMsgBox('error', errMsg);	
	}
}

function delete_job(site_url, todo_id)
{
	var con = confirm('Are you sure?');	
	if (con)
	{
		$.ajax({
			url: site_url+'jobs/delete_jobs/',
			type: 'POST',
			data: 'todo_id='+todo_id,
			success: function (data){
				//$('#assigned_to').html(data.output);
				jobs_list(site_url);
				callMsgBox('success', 'Job deleted successfully');				
			}		
		});
	}
}

function start_job(site_url, todo_id, project_id)
{
	//var con = confirm('Are you sure?');
	$('#prj_job_loading').css('display', 'block');
	$.ajax({
		url: site_url+'jobs/start_job/',
		type: 'POST',
		data: 'todo_id='+todo_id+'&project_id='+project_id,
		dataType: 'json',
		success: function (data){
			jobs_list(site_url);
			$('#prj_job_loading').css('display', 'none');
			callMsgBox(data.status, data.message);		
		}
	});
	$('#prj_job_loading').css('display', 'none');
}

function stop_job(site_url, todo_id, project_id)
{
	//var con = confirm('Are you sure?');
	$('#prj_job_loading').css('display', 'block');
	$.ajax({
		url: site_url+'jobs/stop_job/',
		type: 'POST',
		data: 'todo_id='+todo_id+'&project_id='+project_id,		
		success: function (data){
			jobs_list(site_url);
			$('#prj_job_loading').css('display', 'none');
			callMsgBox('success', 'Job stopped successfully');		
		}
	});
	$('#prj_job_loading').css('display', 'none');
}

function close_job(site_url, todo_id, project_id)
{
	var con = confirm('Are you sure?');
	if (con){
		$('#prj_job_loading').css('display', 'block');
		$.ajax({
			url: site_url+'jobs/close_job/',
			type: 'POST',
			data: 'todo_id='+todo_id+'&project_id='+project_id,		
			success: function (data){
				jobs_list(site_url);
				$('#prj_job_loading').css('display', 'none');
				if (data==1)
				{
					callMsgBox('success', 'Job closed successfully');
				}else{
					callMsgBox('error', 'Job couldnot be closed now. Please try again later!');
				}
					
			}
		});
		$('#prj_job_loading').css('display', 'none');
	}
}

/*****************JOBS LIST******************/

/*****************JOBS REPORT******************/
function load_job_report_projects(site_url)
{
	$.ajax({
		url: site_url+'jobs/project_report_users_owner/',		
		dataType: 'json',
		success: function (data){
			$('#job_project_id').html(data.output);
			$('#jobs_report_job_view').html('');
		}		
	});
	
	//open_messagebox('Hello Dear');
	
}

function job_report_project(site_url)
{
	var project_id = '';
	var flag = 0;
	var errMsg = '';
	
	if ($('#job_project_id').val()==0)
	{
		errMsg += 'Select a project <br>';
		flag += 1;
	}else{
		project_id = $('#job_project_id').val();	
	}
	
	if (flag==0)
	{
		$('#prj_job_loading2').css('display', 'block');
		$.ajax({
			url: site_url+'jobs/job_report_list/',
			type: 'POST',
			data: 'project_id='+project_id,
			dataType: 'json',
			success: function (data){
				$('#jobs_report_job_view').html(data.output);
			}
		});
		//open_messagebox('Generating report....Please wait!');
		$('#prj_job_loading2').css('display', 'none');
	}else{
		callMsgBox('error', errMsg);	
	}
}

function job_details_view(todo_id, site_url)
{
	$('#prj_job_loading2').css('display', 'block');
	$.ajax({
		url: site_url+'jobs/job_details/',
		type: 'POST',
		data: 'todo_id='+todo_id,
		dataType: 'json',
		success: function (data){
			open_messagebox('Job Details', data.output);
		}
	});
	$('#prj_job_loading2').css('display', 'none');
}

function display_job_report_details(todo_id, site_url)
{			
	$('#fade').css('display', 'block');
	$('#jobReportDetails').show('slow');
	$('#prj_job_loading3').css('display', 'block');
	//get the div at the center of the screen
	$('#jobReportDetails').css({
    	position:'absolute',
    	left: ($(window).width() - $('#jobReportDetails').outerWidth())/2,
    	//top: ($(window).height() - $('#jobReportDetails').outerHeight())/2
  	});
	
	$.ajax({
		url: site_url+'jobs/get_work_details/',
		data: 'todo_id='+todo_id,
		type: 'POST',
		dataType: 'json',
		success: function (data){
			$('#job_report_details_view').html(data.output);
			
		}
	});
	$('#prj_job_loading3').css('display', 'none');
	
}

function close_job_report_details()
{
	$('#prj_job_loading3').css('display', 'none');
	$('#fade').css('display', 'none');
	$('#jobReportDetails').hide('slow');	
}

/*****************JOBS REPORT******************/