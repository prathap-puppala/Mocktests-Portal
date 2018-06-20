<?php
require_once("site-settings.php");

$isl=(isloggedin())?true:false;

if(!isset($_SESSION['guestvisited'])){
	mysql_query("UPDATE visits SET value=value+1 WHERE type='Guest'");
	$_SESSION['guestvisited']="yes";
	}

if(!$isl)
{
require_once("views/login.php");
}
else
{
if(isadminloggedin()){require_once("views/admin/dashboard.php");}
else if(isloggedin()){require_once("views/user/dashboard.php");}	
	
 } ?>
  <noscript><style>html:before{content:"Javascript is disabled.";font-size:25px;padding:40%;font-family:Times New Roman;text-align:center;color:red;}html:after{content:"Please contact admin or enable Javascript.";font-size:25px;padding:34%;font-family:Times New Roman;text-align:center;color:green;}body{display:none;}</style></noscript>
