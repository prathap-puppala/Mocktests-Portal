<?php
require_once("../../../site-settings.php");

if(isloggedin())
{
if(isset($_POST['cat']) && !empty($_POST['cat']))
{
$cat=mysql_real_escape_string(strip_tags(trim($_POST['cat'])));
if($cat!="like" && $cat!="dislike"){echo "Invalid Type";exit;}
$user=$_SESSION['userid'];

if(mysql_num_rows(mysql_query("SELECT * FROM site_rating WHERE stuid='$user'"))>=1){
if(mysql_query("UPDATE site_rating SET status='$cat' WHERE stuid='$user'"))
{echo "success";}
}
else
{
if(mysql_query("INSERT INTO site_rating(stuid,status,ip) VALUES('$user','$cat','$ip')"))
{echo "success";}
}
	
}
}
?>
