<?php
require_once("../../../site-settings.php");

if(isadminloggedin())
{
if(isset($_POST['sid']) && !empty($_POST['sid']) && isset($_POST['sno']) && !empty($_POST['sno']))
{
$sid=mysql_real_escape_string(strip_tags(trim($_POST['sid'])));
$sno=mysql_real_escape_string(strip_tags(trim($_POST['sno'])));
$q=mysql_query("SELECT * FROM examdetails WHERE sno='$sno'");
if(mysql_num_rows($q)>=1)
{
$we=mysql_fetch_array($q);
$tab=$we['tkey'];
$que=$we['questions'];
$mode=$we['answersmode'];
    if($mode=="answersgivenow" || $mode=="answersafterexamonline"){
	mysql_select_db("quiz_exams",$con);
	$qw=mysql_query("SELECT * FROM $tab WHERE ID='$sid' and status='Y'");
	if(mysql_num_rows($qw)>=1)
	{
	if(mysql_query("UPDATE $tab SET options='',marks='',correct='',wrong='',status='N',Submittime='' WHERE ID='$sid'")){echo "success";}
	}
	}
	else{
	mysql_select_db("quiz_exams",$con);
	$qw=mysql_query("SELECT * FROM $tab WHERE ID='$sid' and status='Y'");
	if(mysql_num_rows($qw)>=1)
	{
	if(mysql_query("UPDATE $tab SET status='N' WHERE ID='$sid'")){
		$scr="UPDATE $tab SET";
		for($i=1;$i<=$que;$i++)
		{
		$scr=$scr." Q".$i."=NULL,";	
		}
		$scr=$scr."Submittime='' WHERE ID='$sid'";
		if(mysql_query($scr) or die(mysql_error())){echo "success";}
		}
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
