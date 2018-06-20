<?php

require_once("../../../site-settings.php");
$isl=(isloggedin())?true:false;
if(!$isl && $teckzitemode==false)
{
if(isset($_POST['uid']) && isset($_POST['uname']) && isset($_POST['passwd']) && isset($_POST['cpasswd']) && isset($_POST['email']) && isset($_POST['seckey']))
{
$uid=mysql_real_escape_string(htmlspecialchars(addslashes($_POST['uid'])));
$uname=mysql_real_escape_string(htmlspecialchars(addslashes($_POST['uname'])));
$passwd=mysql_real_escape_string(htmlspecialchars(addslashes($_POST['passwd'])));
$cpasswd=mysql_real_escape_string(htmlspecialchars(addslashes($_POST['cpasswd'])));
$email=mysql_real_escape_string(htmlspecialchars(addslashes($_POST['email'])));
$seckey=mysql_real_escape_string(htmlspecialchars(addslashes($_POST['seckey'])));

if($uid==""){echo "Enter University ID";}
else if($uname==""){echo "Enter Your Name";}
else if($passwd==""){echo "Enter Your Password";}
else if($cpasswd==""){echo "Enter Confirm Password";}
else if($passwd!=$cpasswd){echo "Password and Confirm Password didn't match";}
else if($email==""){echo "Enter Email Address";}
else if(filter_var($email,FILTER_VALIDATE_EMAIL)==false){echo "Enter Valid Email Address";}
else if($seckey==""){echo "Enter Security Key";}
else{
$query1 = mysql_query("select * from data where id='$uid'") or die(mysql_error());

if(mysql_num_rows($query1)>=1)
{
$dup=mysql_query("SELECT * FROM users WHERE stuid='$uid'");
if(mysql_num_rows($dup)>0)
{
print "Already Registered";
}
else
{
$det=mysql_fetch_array($query1);
$passwd=md5($passwd);
$inser=mysql_query("INSERT INTO users (stuid,name,enteredname,passwd,gender,year,branch,class,email,seccode,reg_ip) VALUES ('$uid','".$det['name']."','$uname','$passwd','".$det['gender']."','".$det['year']."','".$det['branch']."','".$det['class']."','$email','$seckey','$ip')");
if($inser)
{
print "success";
}
}
}
else
{
echo "Invalid University ID";
}
}
}
}
?>
