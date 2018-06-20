<?php
require_once("../../../site-settings.php");

if(isadminloggedin())
{
if(isset($_GET['sno']) && !empty($_GET['sno']) && isset($_GET['vis']) && !empty($_GET['vis']))
{
$sno=mysql_real_escape_string(strip_tags(trim($_GET['sno'])));
$vis=mysql_real_escape_string(strip_tags(trim($_GET['vis'])));
$q="SELECT * FROM examdetails WHERE sno='$sno' and visibility='1'";
if(mysql_num_rows(mysql_query($q))>=1)
{
$we=mysql_fetch_array(mysql_query($q));
if($we['answersmode']!="answersafterexamexcel")
{
if(mysql_query("UPDATE examdetails SET displayinprofile='$vis' WHERE sno='$sno'"))
{
echo "<script>alert('Changes done');window.location='index';</script>";
}
}
}
else
{
echo "No such Exam found";	
}	
}
}
?>
