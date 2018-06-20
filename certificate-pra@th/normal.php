<?php
require("../site-settings.php");
if(!isloggedin()){header("location:../index");exit;}

$stuid=$_SESSION['userid'];
$qu=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$stuid'"));
 require_once("certificate.php");
 $gender=($qu['gender']=="Male")?"his":"her";
 $msg="$gender excellent performace in mocktests";
 fetchCertificate($qu['name'], $msg,"-");
?>
