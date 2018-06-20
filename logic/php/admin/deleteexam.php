<?php
require_once("../../../site-settings.php");

if(isadminloggedin())
{
if(isset($_POST['sno']) && !empty($_POST['sno']) && isset($_POST['mode']) && !empty($_POST['mode']))
{
$sno=mysql_real_escape_string(strip_tags(trim($_POST['sno'])));
$mode=mysql_real_escape_string(strip_tags(trim($_POST['mode'])));
if(mysql_num_rows(mysql_query("SELECT * FROM examdetails WHERE sno='$sno' and answersmode='$mode'"))>=1)
{
if(mysql_query("UPDATE examdetails SET visibility='0' WHERE sno='$sno' and answersmode='$mode'"))
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
