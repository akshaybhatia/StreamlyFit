// JavaScript Document

/*********CURRENT DATE VIEW FOR TIME LOG**********/
function load_time_log(site_url)
{
	var date = $('#time_date').val();
	var flag = 0;
	var errMsg = '';
	
	if (date.length<=0)
	{
		errMsg += 'Enter a date first';
		flag += 1;
	}
	
	if (flag==0)
	{
		//callMsgBox('success', 'Loading data please wait');
		$('#time_log_loading').show();
		$.ajax({
			url: site_url+'timelog/home',
			type: 'POST',
			data: 'entry_date='+date,
			dataType: 'json',
			success: function(data){
				//$('#time_log_view').css('display', 'none');
				$('#time_log_view').html(data.output);
				$('#time_log_date').html('<i>'+data.dateview+'</i>');
				//$('#time_log_view').show('slow');
			}
		});
		$('#time_log_loading').hide();
	}else{
		callMsgBox('error', errMsg);	
	}		
}

/*********CURRENT DATE VIEW FOR TIME LOG**********/

/*********CURRENT MONTH VIEW FOR TIME LOG**********/
function load_time_log_month(site_url)
{
	var month = $('#select_month').val();
	var flag = 0;
	var errMsg = '';
	
	if (month==0)
	{
		errMsg += 'Select a month first';
		flag += 1;
	}
	
	if (flag==0)
	{
		//callMsgBox('success', 'Loading data please wait');
		$('#time_log_loading_month_2').show();
		$.ajax({
			url: site_url+'timelog/monthly_report',
			type: 'POST',
			data: 'month='+month,
			dataType: 'json',
			success: function(data){
				//$('#time_log_view_month').css('display', 'none');
				$('#time_log_view_month').html(data.output);
				//$('#time_log_view_month').show('slow');
				$('#date_view_month').html('<i>'+data.monthview+'</i>');
			}
		});
		$('#time_log_loading_month_2').hide();
	}else{
		callMsgBox('error', errMsg);	
	}		
}

function load_time_log_current_month(site_url, month)
{
	$('#select_month').val(0);
	$('#time_log_loading_month').show();
	$.ajax({
		url: site_url+'timelog/monthly_report',
		type: 'POST',
		data: 'month='+month,
		dataType: 'json',
		success: function(data){
			//$('#time_log_view_month').css('display', 'none');
			$('#time_log_view_month').html(data.output);
			//$('#time_log_view_month').show('slow');
			//$('#time_log_date').html('<i>'+data.dateview+'</i>');
		}
	});
	$('#time_log_loading_month').hide();
}

/*********CURRENT MONTH VIEW FOR TIME LOG**********/