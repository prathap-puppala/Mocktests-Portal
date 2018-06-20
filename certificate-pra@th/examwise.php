<?php
require("../site-settings.php");
if(!isloggedin()){header("location:../index");exit;}
$stuid=$_SESSION['userid'];
if(isset($_GET['sno']) && !empty($_GET['sno']))
{
$sno=mysql_real_escape_string(trim(strip_tags($_GET['sno'])));
$qu=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$stuid'"));
$exa=mysql_fetch_array(mysql_query("SELECT * FROM examdetails WHERE sno='$sno'"));
$tab=$exa['tkey'];
mysql_select_db("quiz_exams",$con);
$q=mysql_query("SELECT * FROM $tab WHERE ID='".$qu['stuid']."' and status='Y'");
if(mysql_num_rows($q)>=1)
{
 require_once("certificate.php");
 $gender=($qu['gender']=="Male")?"his":"her";
 $msg="$gender excellent performace in mocktests";
 fetchCertificate($qu['name'], $msg,$exa['title']);
}
}
?>
