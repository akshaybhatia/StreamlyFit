<?php
ob_start();
require "lib/config.php";
require "lib/mysql.php";
require "lib/conn.php";

error_reporting(E_ALL ||E_NOTICE|| E_WARNING);
set_time_limit(0);



$is_cron_fire=1;


if($is_cron_fire==1)
{

	/* Fatching result details*/
	/** Check Login*/
	$time_now=mktime(date("H"), date("i"), date("s"), date("n"), date("j"), date("Y"))-30;

	q ("UPDATE evolve_log_login SET is_login='N',duration=end_date-start_date  WHERE end_date< $time_now AND is_login='Y'");
	
	
}
?>