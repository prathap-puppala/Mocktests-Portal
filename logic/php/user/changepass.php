<?php
error_reporting(0);
require_once("../../../site-settings.php");
$isl=(isloggedin())?true:false;

//checking whether loggedin or not
if($isl)
{
$stuid=$_SESSION['userid'];
if(isset($_POST['opasswd']) && !empty($_POST['opasswd']) && isset($_POST['passwd']) && !empty($_POST['passwd']) && isset($_POST['cpasswd']) && !empty($_POST['cpasswd']))
{
//function for sanitizing variable values
function prathap($field)
{
$prathap=trim($_POST[$field]);	
$prathap=strip_tags($prathap);	
$prathap=htmlspecialchars($prathap);	
$prathap=mysql_real_escape_string($prathap);	
return $prathap;
}

//variables
$opasswd=prathap("opasswd");
$passwd=prathap("passwd");
$cpasswd=prathap("cpasswd");

$data=mysql_query("SELECT * FROM users WHERE stuid='$stuid'");
if(mysql_num_rows($data)>=1)
{
if($opasswd=="")
{
echo "Please Enter Old Password";
}
elseif($passwd=="")
{
echo "Please Enter New Password";
}
elseif($cpasswd=="")
{
echo "Please Enter Confirm Password";	
}
elseif($cpasswd!=$passwd)
{
echo "New Password and Confirm Password are not same";	
}
else
{	
$det=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$stuid'"));
if(md5($opasswd)==$det['passwd'])
{

mysql_query("UPDATE users SET passwd=md5('$passwd') WHERE stuid='$stuid'");
echo "success";	
}	
else
{
	
echo "Update Failed";	
	}

		
	

}
}
else
{
echo "Invalid Old Password";
}
}
}
else
{
echo "Please Login";	
}
?>

