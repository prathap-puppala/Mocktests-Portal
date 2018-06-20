<?php

require_once("../../site-settings.php");
$isl=(isloggedin())?true:false;

if(!$isl)
{
require_once("views/login.php");
}
else if(isloggedin()){

if(isset($_POST['nid']))
{
$nid=mysql_real_escape_string(trim(strip_tags(htmlspecialchars($_POST['nid']))));
mysql_query("UPDATE notifications SET views=views+1 WHERE nid='$nid'");
$result = mysql_query("SELECT * FROM notifications WHERE visibility='1' and nid='$nid'") or die(mysql_error());

    $row = mysql_fetch_array($result);
	$notification=$row['description'];
	echo "".$notification."<br><br>".$row['attachments']."";
	}
}
?>
