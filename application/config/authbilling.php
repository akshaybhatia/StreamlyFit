<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/*
|--------------------------------------------------------------------------
| Authorize.Net
|--------------------------------------------------------------------------
|
| All of the stuff we need to connect with Authorize.Net
|
|
*/
 
$config['loginname']            = "92rKJ47vw4";
$config['transactionkey']       = "69nr2V26ncMvrA3Y";
$config['host']                 = "apitest.authorize.net"; //change to api.authorize.net in Live mode
$config['path']                 = "/xml/v1/request.api";
 
/*
|--------------------------------------------------------------------------
| Free trial period
|--------------------------------------------------------------------------
|
| How long (in months) should a new paid account have as a free trial?
|
|
*/
$config['trial_period'] = 1;
 
?>