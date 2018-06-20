<?php
require_once("../../../site-settings.php");

if(isloggedin())
{
if(isset($_POST['msg']) && !empty($_POST['msg']))
{
$msg=mysql_real_escape_string(strip_tags(trim($_POST['msg'])));
$user=$_SESSION['userid'];
if($msg==""){echo "Please Enter Something";exit;}
if(mysql_query("INSERT INTO messages(eid,sender,receiver,matter,sendertype,ip,date) VALUES('NULL','$user','Admin','$msg','student','$ip','$date')"))
{
echo "success";
}	
}
}
?>
