<?php

require_once("site-settings.php");
$isl=(isloggedin())?true:false;

if(!$isl)
{
require_once("views/login.php");
}
else if(isloggedin()){

$date=date("d-m-Y");
$result = mysql_query("SELECT * FROM notifications WHERE visibility='1' ORDER BY nid DESC") or die(mysql_error());
echo "\n<table width='100%' class='table'>";
while ($row = mysql_fetch_array($result)) 
	{
	$n=$row['nid'];
	$a="<a href=\"javascript:void(0)\" data-toggle=\"modal\" data-target=\"#myModal2\" onclick=shwno(\"$n\")>";
	$new=($row['added_date']==$date)?"<span class='label label-danger'>New</span>":"";
	$notification=$row['title'];
	echo "\n\t<tr title='Posted at ".$row['time']."' ><td ";
	echo " id='notify'  width='100%'>".$a.$notification."  ".$new."</a></td>";
	echo "</tr>";
	}
	echo "\n</table>";
}
?>
