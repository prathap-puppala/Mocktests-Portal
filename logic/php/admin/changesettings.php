<?php
require_once("../../../site-settings.php");

if(isadminloggedin())
{
if(isset($_POST['sett']) && !empty($_POST['sett']) && isset($_POST['newv']) && !empty($_POST['newv']))
{
$sett=mysql_real_escape_string(strip_tags(trim($_POST['sett'])));
$newv=mysql_real_escape_string(strip_tags(trim($_POST['newv'])));
$arr=array("yes","no");
if(in_array($newv,$arr))
{
if(mysql_query("UPDATE site_settings SET value='$newv' WHERE field='$sett'"))
{
echo "success";
}
}	
}
}
?>
