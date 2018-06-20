<?php
session_start();

//common settings
//error_reporting(0);
//date_default_timezone_set("Asia/Calcutta");
setlocale(LC_ALL,"hu_HU.UTF8");

$ip=$_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
$date=date("d-m-Y");

$fulltime=date("h:i:s A",(mktime(date("H")+3,date("i")+30,date("s")+1,0,0,0)));
$time=date("h:i:s A",mktime(date("h")+3,date("i")+30,date("s")));
$ptime=date("h:i A",(mktime(date("H")+3,date("i")+30,date("s")+1,0,0,0)));
	$Hour=substr($ptime,0,2);
	$Min=substr($ptime,3,2);
	$M=substr($ptime,6,2);
	$Hour+=10;
	if ($M=='PM')
		{
		if ($Hour<22)
		{
		$Hour+=12;
		}
		}
	$ptime=$Hour.$Min;
	$cdate = date("j m Y");
	$ctime = date("h:i A");
	
ini_set('max_execution_time', 6000);


//database variables
$dbhost="localhost";
$dbuser="root";
$dbpass="myaccess@sql";
$dbname="quiz";

//folder where question papers are stored
$mainp="epapersrgukt";


//database connection and settings
$con=mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error());
mysql_select_db($dbname,$con) or die(mysql_error());
mysql_query('SET character_set_results=utf8');
mysql_query('SET NAMES utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_connection=utf8');
mysql_query('SET collation_connection=utf8_general_ci');


//site variables and settings
$title="Mocktests";
$settings=mysql_fetch_array(mysql_query("SELECT * FROM site_settings WHERE field='teckzitemode'"));
$teckzitemode=($settings['value']=='yes')?true:false;        //set this to false for normal exams
$teckzitedb="teckzite2k16"; //(teckzite database in which you want to check login) set this if $teckzitemode is set to true
$passtable="users";         //(passwords table in which you want to check login) set this if $teckzitemode is set to true


//functions
//normal user login checking
function isloggedin(){return (isset($_SESSION['userid']) && !empty($_SESSION['userid']))?true:false;}

//admin login checking
function isadminloggedin(){return (isset($_SESSION['userid']) && !empty($_SESSION['userid']) && isset($_SESSION['admin']) && !empty($_SESSION['admin']))?true:false;}

//function for decoding path
function dataurl($img){
	// Getting data from image file
	$file = file_get_contents($img);
	// Encode binary data to base
	$data = base64_encode($file);
	return $data;
}

//browser and platform info
function pla($plat)
{
	 $viewer = getenv( "HTTP_USER_AGENT" );
   $browser = "An unidentified browser";
   if( preg_match( "/MSIE/i", "$viewer" ) )
   {
      $browser = "Internet Explorer";
   }
   else if(  preg_match( "/Netscape/i", "$viewer" ) )
   {
      $browser = "Netscape";
   }
   else if(  preg_match( "/Mozilla/i", "$viewer" ) )
   {
      $browser = "Mozilla";
   }
   $platform = "An unidentified OS!";
   if( preg_match( "/Windows/i", "$viewer" ) )
   {
      $platform = "Windows!";
   }
   else if ( preg_match( "/Linux/i", "$viewer" ) )
   {
      $platform = "Linux!";
   }
   if($plat=="os"){return $platform;}
   else if($plat=="browser"){return $browser;}
   else{return "";}
}
?>
