<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Fra_lib {
    
    public function genpassword($l)
    {
        $random_id_length = $l; 

        //generate a random id encrypt it and store it in $rnd_id 
        $rnd_id = crypt(uniqid(rand(),1)); 

        //to remove any slashes that might have come 
        $rnd_id = strip_tags(stripslashes($rnd_id)); 

        //Removing any . or / and reversing the string 
        $rnd_id = str_replace(".","",$rnd_id); 
        $rnd_id = strrev(str_replace("/","",$rnd_id)); 

        //finally I take the first 10 characters from the $rnd_id 
        $rnd_id = substr($rnd_id,0,$random_id_length); 

        return $rnd_id;
    }
    


public function htmlspecialchars_deep($mixed, $quote_style = ENT_QUOTES, $charset = 'UTF-8')
{
    if (is_array($mixed)) {
        foreach($mixed as $key => $value) {
            $mixed[$key] = htmlspecialchars_deep($value, $quote_style, $charset);
        }
    } elseif (is_string($mixed)) {
        $mixed = htmlspecialchars(htmlspecialchars_decode($mixed, $quote_style), $quote_style, $charset);
    }
    return $mixed;
}

    public function  Change_Format($date,$format='M d, Y',$fieldtype='datetime',$show_time=1)
    {
        
		if($fieldtype=='datetime')
		{
			$d = explode("-",substr($date, 0, 10));
			$t = explode(":",substr($date, 11, 19)); 
			if($show_time==1)
				$newdate=date ( $format,mktime(0,0,0,$d[1],$d[2],$d[0]) )." at ".date ( "g:i:s a",mktime($t[0],$t[1],$t[2]));  
			else
				$newdate=date ( $format,mktime(0,0,0,$d[1],$d[2],$d[0]) );  	
		   
			// return date_format($date,'Y-m-d H:i:s');      
		}
		elseif($fieldtype=='date')
		{
			
			$d = explode("-",$date);
			$newdate=date ( $format,mktime(0,0,0,$d[1],$d[2],$d[0]) );  	
		   
			// return date_format($date,'Y-m-d H:i:s');      
			
		}
		elseif($fieldtype=='time')
		{
			
			$t = explode(":",$date);
			$newdate=date ( $format,mktime($t[0],$t[1],$t[2]) );  	
		   
			// return date_format($date,'Y-m-d H:i:s');      
			
		}

        return $newdate;       
    }
	
	
	public function convert_to_time($secs)
	{
		//echo $secs;
		if($secs<0)
		{
			$secs=($secs*-1);
		}
		
		$hh = (int)($secs / 3600);	
		$mmt = $secs - ($hh * 3600);	
		$mm = (int)($mmt / 60);	
		$ss = $mmt - ($mm * 60);	
			
		if ($ss < 10) { $ss = str_pad($ss,2,"0", STR_PAD_LEFT); }	
		if ($mm < 10) { $mm = str_pad($mm,2,"0", STR_PAD_LEFT); }	
		if ($hh < 10) { $hh = str_pad($hh,2,"0", STR_PAD_LEFT); }

		return ($hh.":".$mm.":".$ss); 
	}
    
    public function  week_start_date($w, $y, $first = 0, $format = 'd-m-Y')
    {
      	/*$wk_ts  = strtotime('+' . $wk_num . ' weeks', strtotime($yr . '0101'));
		echo $y = date("Y", time())."<br>";
        
		$mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts);
		echo date($format, $mon_ts)."<br>";
        return date($format, $mon_ts);  */
		//$y = date("Y", time());
		$o = 6; // week starts from sunday by default
	
		$days = ($w - 1) * 7 + $o;
	
		$firstdayofyear = getdate(mktime(0,0,0,1,1,$y));
		if ($firstdayofyear["wday"] == 0) $firstdayofyear["wday"] += 7;
		# in getdate, Sunday is 0 instead of 7
		$firstmonday = getdate(mktime(0,0,0,1,1-$firstdayofyear["wday"]+1,$y));
		$calcdate = getdate(mktime(0,0,0,$firstmonday["mon"], $firstmonday["mday"]+$days,$firstmonday["year"]));
	
		$sday = $calcdate["mday"];
		$smonth = $calcdate["mon"];
		$syear = $calcdate["year"];
	   
		   
		$timestamp['start_timestamp'] =  mktime(0, 0, 0, $smonth, $sday, $syear);
		$timestamp['end_timestamp'] =  $timestamp['start_timestamp'] + (60*60*24*7);
	
		 return date($format, $timestamp['start_timestamp']);

    }
    
    public function  week_end_date($w, $y, $first = 0, $format = 'd-m-Y')
    {
        
        /*$wk_ts  = strtotime('+' . $wk_num . ' weeks', strtotime($yr . '0101'));
        $mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts);
        $sStartDate=date($format, $mon_ts); 
        
        return date($format, strtotime('+6 days', strtotime($sStartDate)));*/

		$o = 6; // week starts from sunday by default
	
		$days = ($w - 1) * 7 + $o;
	
		$firstdayofyear = getdate(mktime(0,0,0,1,1,$y));
		if ($firstdayofyear["wday"] == 0) $firstdayofyear["wday"] += 7;
		# in getdate, Sunday is 0 instead of 7
		$firstmonday = getdate(mktime(0,0,0,1,1-$firstdayofyear["wday"]+1,$y));
		$calcdate = getdate(mktime(0,0,0,$firstmonday["mon"], $firstmonday["mday"]+$days,$firstmonday["year"]));
	
		$sday = $calcdate["mday"];
		$smonth = $calcdate["mon"];
		$syear = $calcdate["year"];
	   
		   
		$timestamp['start_timestamp'] =  mktime(0, 0, 0, $smonth, $sday, $syear);
		$timestamp['end_timestamp'] =  $timestamp['start_timestamp'] + (60*60*24*7);
	
		return date($format, $timestamp['end_timestamp']);
    }
    
    public function setStarRating($value=5)
    {
        
        
        if ($value>=1)
                $star = "rate/1star.gif" ;
        
        if ($value>=1.5)
                $star = "rate/15star.gif" ;
        
        if ($value>=2)
                $star = "rate/2star.gif" ;
        if ($value>=2.5)
                $star = "rate/25star.gif" ;
        
        if ($value>=3)
                $star = "rate/3star.gif" ;
        
        if ($value>=3.5)
                $star = "rate/35star.gif" ;
        
        if ($value >= 4)
                $star = "rate/4star.gif" ;

        if ($value >= 4.5)
                $star = "rate/45star.gif" ;
        
        if ($value >= 5)
                $star = "rate/5star.gif" ;
        
        if ($value<=0)
                $star = "rate/00star.gif" ;
        
        return $star;
    }
    
    function ChangeDate_YMD($date)
    {
        $data=explode('-',$date);
        $new_date=$data[1].'-'.$data[2].'-'.$data[0];
        return $new_date;
    }
}

