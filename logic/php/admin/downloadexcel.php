<?php
require_once("../../../site-settings.php");

if(isadminloggedin())
{


if ((isset($_GET['sno'])) && (empty($_GET['sno'])!=true))
{ 
  $sno=mysql_real_escape_string(htmlspecialchars(trim($_GET['sno'])));
  if(mysql_num_rows(mysql_query("SELECT * FROM examdetails WHERE sno='$sno' and answersmode='answersafterexamexcel'"))<1)
	{
	exit;	
	}
	mysql_query("UPDATE examdetails SET validations=validations+1 WHERE sno='$sno'");
	$tt=mysql_fetch_array(mysql_query("SELECT * FROM examdetails WHERE sno='$sno' and answersmode='answersafterexamexcel'"));
	$Num=$tt['tkey'];
	$script='<table style="text-align:center;">
	<tr style="text-align:center;border:1px solid #999;">
	<th>S.No</th>
	<th>ID</th>';
	$Title='Unknown';
	$result=mysql_query("SELECT * FROM examdetails WHERE tkey='$Num'");
	while($row=mysql_fetch_array($result))
	{
	$Questions=$row['questions'];
	$Title=$row['title'];
	$Subject=$title;
	$Branch="";
	$Date=$row['date'];
	}
	if ($Questions)
	{
	$i=1;
	while ($i<=$Questions)
	{
	$script=$script.'<th>Q'.($i).'</th>';
	$i+=1;
	}
	$script=$script."<th>IP</th><th>Login Time</th><th>Submit Time</th><th>Submit Status</th><th> </th>";
	$i=1;
	while ($i<=$Questions)
	{
	$script=$script.'<th>Q'.($i).'M</th>';
	$i+=1;
	}
	$script=$script."<th></th><th>Total Marks</th></tr>
	<tr style='text-align:center;border:1px solid #1199ff;color:green;'><td>0</td><td>Key</td>";
	$i=1;
	while($i<=(($Questions*2)+6))
		{
		$script.="<td></td>";
		$i++;
		}
	$script=$script. "</tr>";
	}
	mysql_select_db('quiz_exams');
	$result=mysql_query("SELECT * FROM $Num");
	$SNo=1;
	while ($row=mysql_fetch_array($result))
	{
	$ID=$row['ID'];
	$IP=$row['IP'];
	$LoginTime=$row['Logintime'];
	$SubmitTime=$row['Submittime'];
	$SubmitStatus=$row['status'];
	$script.="<tr style='text-align:center;border:1px solid #999;'><td align='center'>$SNo</td><td align='center'>$ID</td>";
	$i=1;
	while($i<=$Questions)
		{
		$Ans=$row["Q".$i];
		$script.="<td align='center'>$Ans</td>";
		$i++;
		}
	$script.="<td align='center' >$IP</td><td align='center'>$LoginTime</td><td align='center'>$SubmitTime</td><td align='center'>$SubmitStatus</td><td></td>";
	$l=1;
	while($l<=$Questions)
		{
		while($l<=$Questions)
		{
			$i=$l+66;
			$c="";
			if ($i>90)
			{
				$c.=chr((($i-90)/26)+65);
				$c.=chr((($i-90)%26)+64);
			}
			else
			{
				$c.=chr($i);
			}
			$script=$script."<td>=if(".$c."2=".$c.($SNo+2).",1,0)</td>";
			$l++;
		}
		}
		$sta=($Questions)+7+65;
		$e=$sta+$Questions-1;
		$star="";
		$en="";
		if ($sta>90)
		{
		$star.=chr((($sta-90)/26)+65);
		$star.=chr((($sta-90)%26)+64);
		}
		else
		{
		$star.=chr($sta);
		}
		if ($e>90)
		{
		$en.=chr((($e-90)/26)+65);
		$en.=chr((($e-90)%26)+64);
		}
		else
		{
		$en.=chr($e);
		}
	$script.="<td></td><td>=SUM(".$star.($SNo+2).":".$en.($SNo+2).")</td></tr>";
	$SNo+=1;
	}
	$script.='</table>';
if($Branch!=""){$xlsbranch="_".$Branch;}else{$xlsbranch="";}
$xlsname=$Title.$xlsbranch.'_'.$Subject.'_'.$Date;
$xlsname= strtoupper(str_replace(' ', '', $xlsname));
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=".$xlsname.".xls");
header("Content-Transfer-Encoding: binary ");
echo strip_tags("$script",'<table><th><tr><td>'); 
}
}
?>
