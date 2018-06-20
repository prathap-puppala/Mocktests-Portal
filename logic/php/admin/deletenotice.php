<?php
require_once("../../../site-settings.php");

if(isadminloggedin())
{
if(isset($_POST['sno']) && !empty($_POST['sno']))
{
$sno=mysql_real_escape_string(strip_tags(trim($_POST['sno'])));
if(mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE nid='$sno'"))>=1)
{
if(mysql_query("UPDATE notifications SET visibility='0' WHERE nid='$sno'"))
{
echo "success";
}
}
else
{
echo "No such Exam found";	
}	
}
}
?>
