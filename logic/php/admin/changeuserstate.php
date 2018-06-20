<?php
require_once("../../../site-settings.php");

if(isadminloggedin())
{
if(isset($_POST['state']) && !empty($_POST['state']) && isset($_POST['uid']) && !empty($_POST['uid']))
{
$state=mysql_real_escape_string(strip_tags(trim($_POST['state'])));
$uid=mysql_real_escape_string(strip_tags(trim($_POST['uid'])));
$arr=array("active","deactivated","blocked");
if(in_array($state,$arr))
{
mysql_select_db($dbname,$con);
if(mysql_query("UPDATE users SET status='$state' WHERE stuid='$uid'"))
{
echo "success";
}
}	
}
}
?>
