<?php
require_once("../../../site-settings.php");

if(isloggedin())
{
if(isset($_POST['sid']) && !empty($_POST['sid']) && isset($_POST['sno']) && !empty($_POST['sno']))
{
$sid=mysql_real_escape_string(strip_tags(trim($_POST['sid'])));
$sno=mysql_real_escape_string(strip_tags(trim($_POST['sno'])));

if($sid!=$_SESSION['userid'])
{exit;}
$q=mysql_query("SELECT * FROM examdetails WHERE sno='$sno'");
if(mysql_num_rows($q)>=1)
{
$we=mysql_fetch_array($q);
$tab=$we['tkey'];
$que=$we['questions'];
$realans=array();
$realans=explode("~",$we['answers']);
$ccone=$we['ccone'];
$cwone=$we['cwone'];
$mode=$we['answersmode'];
    if($mode=="answersgivenow" || $mode=="answersafterexamonline"){
	mysql_select_db("quiz_exams",$con);
	$qw=mysql_query("SELECT * FROM $tab WHERE ID='$sid' and status='Y'");
	if(mysql_num_rows($qw)>=1)
	{
	$qwe=mysql_fetch_array($qw);
	$userans=array();
	$userans=explode("~",$qwe['options']);
	if(count($realans)==count($userans))
	{
	$marks=0;
	$crct=0;
	$wrng=0;
	for($i=0;$i<count($userans);$i++)	
	{
	if($userans[$i]=="prathap"){$marks=$marks;}	
	elseif($userans[$i]==$realans[$i]){$marks=$marks+$ccone;$crct++;}	
	elseif($userans[$i]!=$realans[$i]){$marks=$marks-$cwone;$wrng++;}	
	}
	if(mysql_query("UPDATE $tab SET marks='$marks',correct='$crct',wrong='$wrng' WHERE ID='$sid'"))
	{
	$pp=mysql_fetch_array(mysql_query("SELECT * FROM $tab WHERE ID='$sid'"));
	?>
	  <td><?php echo $pp['ID'];?></td>
				  <td><?php echo $que;?></td>
				  <td><?php echo $pp['marks'];?></td>
				  <td><?php echo $pp['Logintime'];?></td>
				  <td><?php echo $pp['status'];?></td>
				  <td><?php echo $pp['Submittime'];?></td>
				  <td>
				    <a class="btn btn-primary" style='cursor:pointer;'  onclick="re('<?php echo $sid;?>','<?php echo $sno;?>')" title="Re-validate"><i class="fa fa-binoculars"></i></a>
   <span id="asd<?php echo $sid;?>"></span>
				  </td>
                <?php	
	}	
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
