<?
global $page_no;
//error_reporting(E_ALL);
//error_reporting(E_ALL && ~E_NOTICE);

function dt_dmy($get_date)
{
	return substr($get_date,8,2)."/". substr($get_date,5,2)."/". substr($get_date,0,4);
}
function dt_dmy_small($get_date)
{
	return substr($get_date,8,2)."/". substr($get_date,5,2)."/". substr($get_date,2,2);
}

function type_IMG($mime)
{
	switch($mime)
	{	
		case "image/jpeg":
			return "jpg";
		case "image/pjpeg":
			return "jpg";
		case "image/png":
			return "png";		
		case "image/gif":
			return "gif";
	}
	return "";
}

function type_HTML($mime)
{
	switch($mime)
	{	
		case "text/html":
			return "html";	
	}
	return "";
}



function checkEmail($email) 
{
   
   if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
   {
      return FALSE;
   }
//  WHEN UPLOAD TO THE SERVER UNQUOTE THE FOLLOWING LINES
   /*list($Username, $Domain) = split("@",$email);

   if(getmxrr($Domain, $MXHost)) 
   {
      return TRUE;
   }
   else 
   {
      if(fsockopen($Domain, 25, $errno, $errstr, 30)) 
      {
         return TRUE; 
      }
      else 
      {
         return FALSE; 
      }
   }
   */
   else
   {
      return TRUE;
	  }
   
}

function trim_desc ($s,$length) {
// limit the length of the given string to $MAX_LENGTH char
// If it is more, it keeps the first $MAX_LENGTH-3 characters 
// and adds "..."
// It counts HTML char such as &aacute; as 1 char.
//
// $MAX_LENGTH = 22;
 $str_to_count = html_entity_decode($s);
 if (strlen($str_to_count) <= $length) {
   return $s;
 }
 $s2 = substr($str_to_count, 0, $length - 3);
 $s2 .= "...";
 return htmlentities($s2);
}
		






function changeDate_YMD($date)
{
		if(CAL_DF=='%d-%m-%Y')
		{
			$y=explode('-',$date);
			$a=$y[0];
			$b=$y[1];
			$c=$y[2];
			
			$z=array($c,$b,$a);
			$k=implode("-",$z);

			return $k; 
		}
}

function changeDate_DMY($date)
{
			$date = substr($date, 0, 10);
			$y=explode('-',$date);
			$a=$y[0];
			$b=$y[1];
			$c=$y[2];
			
			$z=array($c,$b,$a);
			$k=implode("-",$z);

			return $k; 

}

function changeDate_MDY($date)
{
			$date = substr($date, 0, 10);
			$y=explode('-',$date);
			$a=$y[0];
			$b=$y[1];
			$c=$y[2];
			
			$z=array($b,$c,$a);
			$k=implode("-",$z);

			return $k; 

}

function changeDate_ADV($date)
{
	
	$month=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$date = substr($date, 0, 10);
	$date=explode('-',$date);
	
	$y=$date[0];
	$m=$month[$date[1]-1];
	$d=$date[2];	
	
	/*if($d==1 || $d==21 || $d==31)
	{
		$d=$d." <sup>st</sup>";
	}
	
	if($d==2 || $d==22)
	{
		$d=$d." <sup>nd</sup>";
	}
	
	if($d==3 || $d==23)
	{
		$d=$d." <sup>rd</sup>";
	}
	
	if(($d>=4 && $d<=20) || ($d>=24 && $d<=30))
	{
		$d=abs($d)." <sup>th</sup>";
	}*/
	return $m." ".$d.", ".$y; 
}
function pickname($Table,$scerchBy,$scerchItem,$key)
{
	//echo "select ".$scerchItem." from ".$Table." where ".$scerchBy."='".$key."'";
	$quary=q("select ".$scerchItem." from ".$Table." where ".$scerchBy."='".$key."'");
	$tot_rec=(int)nr($quary);
	$returnName='';
	if($tot_rec<>0)
	{
		$fatch_quary=f($quary);
		$returnName=$fatch_quary[0];
	}
	return $returnName;
}

function changeDate_ADVTXT($date)
{
	
	$month=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$date = substr($date, 0, 10);
	$date=explode('-',$date);
	
	$y=$date[0];
	$m=$month[$date[1]-1];
	$d=$date[2];	
	
	
	return $m." ".$d.", ".$y; 
}

function date_differencep($dateto,$bidid){
	 $dateto = strtotime($dateto,0);
	 $datefrom = strtotime(date('Y-m-d H:i:s'),0);
	 $result =  $dateto-$datefrom;
	return $result;
   }

?>