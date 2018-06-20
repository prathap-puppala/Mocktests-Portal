<?php

require_once("../../../site-settings.php");
$isl=(isloggedin())?true:false;
if(!$isl && $teckzitemode==false)
{
if(isset($_POST['uid']) && isset($_POST['passwd']) && isset($_POST['cpasswd']) && isset($_POST['email']) && isset($_POST['seckey']))
{
$uid=mysql_real_escape_string(htmlspecialchars(addslashes($_POST['uid'])));
$passwd=mysql_real_escape_string(htmlspecialchars(addslashes($_POST['passwd'])));
$cpasswd=mysql_real_escape_string(htmlspecialchars(addslashes($_POST['cpasswd'])));
$email=mysql_real_escape_string(htmlspecialchars(addslashes($_POST['email'])));
$seckey=mysql_real_escape_string(htmlspecialchars(addslashes($_POST['seckey'])));

if($uid==""){echo "Enter University ID";}
else if($passwd==""){echo "Enter Your Password";}
else if($cpasswd==""){echo "Enter Confirm Password";}
else if($passwd!=$cpasswd){echo "Password and Confirm Password didn't match";}
else if($email==""){echo "Enter Email Address";}
else if(filter_var($email,FILTER_VALIDATE_EMAIL)==false){echo "Enter Valid Email Address";}
else if($seckey==""){echo "Enter Security Key";}
else{
$query1 = mysql_query("select * from users where stuid='$uid'") or die(mysql_error());

if(mysql_num_rows($query1)>=1)
{
$det=mysql_fetch_array($query1);
if($det['email']!=$email || $det['seccode']!=$seckey)
{
print "Invalid Details";
}
else
{
$inser=mysql_query("UPDATE users SET passwd=md5('$passwd') WHERE stuid='$uid'");
if($inser)
{
print "success";
}
}
}
else
{
echo "There is no account with that User ID";
}
}
}
}
?>
