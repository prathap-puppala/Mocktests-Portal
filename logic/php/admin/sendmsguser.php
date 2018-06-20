<?php
require_once("../../../site-settings.php");

if(isadminloggedin())
{
if(isset($_POST['sno']) && !empty($_POST['sno']) && isset($_POST['msg']) && !empty($_POST['msg']))
{
$sno=mysql_real_escape_string(strip_tags(trim($_POST['sno'])));
$msg=mysql_real_escape_string(strip_tags(trim($_POST['msg'])));
$qw=mysql_query("SELECT * FROM messages WHERE sno='$sno' and sendertype='student'");
if(mysql_num_rows($qw)>=1)
{
$rt=mysql_fetch_array($qw);
$student=$rt['sender'];
if(mysql_query("UPDATE messages SET reply='$msg',replysend='1' WHERE sender='$student'"))
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
