<? ob_start();
//error_reporting(E_ALL ||E_NOTICE|| E_WARNING);
error_reporting(E_ALL);
ini_set("MAX_EXECUTION_TIME","0");
define("UPLOAD_SIZE",5120000);
define("UPLOAD_SIZE_TXT","500 kb");
define("ROOT","tutor/");
define("WEBDIR","http://asani1/");
define("PHY_ROOT",$_SERVER['DOCUMENT_ROOT'].'/tutor/');
define("NEWSLETTER_PATH","newsletter/");
date_default_timezone_set('Asia/Kolkata');
global $db_host,$db_login,$db_pswd,$db_name,$connected;



$db_host = 'asani1';
$db_login= 'root';
$db_pswd = '';
$db_name = 'evolve';

?>