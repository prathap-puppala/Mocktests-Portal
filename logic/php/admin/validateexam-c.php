<?php
require_once("../../../site-settings.php");

if(isadminloggedin())
{
if(isset($_POST['realans']) && !empty($_POST['realans']) && isset($_POST['sno']) && !empty($_POST['sno']))
{
$real=mysql_real_escape_string(strip_tags(trim($_POST['realans'])));
$sno=mysql_real_escape_string(strip_tags(trim($_POST['sno'])));
$q=mysql_query("SELECT * FROM examdetails WHERE sno='$sno'");
if(mysql_num_rows($q)>=1)
{
mysql_query("UPDATE examdetails SET validations=validations+1,answers='$real' WHERE sno='$sno'");
$we=mysql_fetch_array($q);
$tab=$we['tkey'];
$que=$we['questions'];
$realans=array();
$realans=explode("~",$real);
$ccone=$we['ccone'];
$cwone=$we['cwone'];
$mode=$we['answersmode'];
    if($mode=="answersafterexamonline" || $mode=="answersgivenow"){
	mysql_select_db("quiz_exams",$con);
	$qw=mysql_query("SELECT * FROM $tab WHERE status='Y'");
while($qwe=mysql_fetch_array($qw))
	{
	$id=$qwe['ID'];
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
	mysql_query("UPDATE $tab SET marks='$marks',correct='$crct',wrong='$wrng' WHERE ID='$id'");	
    }
	}
	//printing winners and link
	$high=mysql_fetch_array(mysql_query("SELECT MAX(marks) AS mar from $tab"));
	$hig=$high['mar'];
	$qqd=mysql_query("SELECT * FROM $tab WHERE marks='$hig'");
	?>
	<table  width="100%" style="text-align:justify;" class="table table-bordered table-striped">
                <tbody>
					<tr><th colspan='4'><center>Winners List</center></th></tr>
					<tr><td colspan="4">Top Marks : <b style='color:red;'><?php echo $hig;?></b></td></tr>
					<tr><td><b style='color:blue;'>User ID</b></td><td><b style='color:blue;'>Marks</b></td><td><b style='color:blue;'>Correct</b></td><td><b style='color:blue;'>Wrong</b></td></tr>
					<?php
					while($qw=mysql_fetch_array($qqd))
					{
					echo "<tr><td>".$qw['ID']."</td><td>".$qw['marks']."</td><td>".$qw['correct']."</td><td>".$qw['wrong']."</td></tr>";	
					}
					
					?>
					<tr><td colspan='4'><center><a title="View Result" class="btn btn-warning" name="logic/php/admin/viewresult?sno=<?php echo $sno;?>" onclick="load_page(this.name)" style='cursor:pointer;'>View Full Results</a></center></td></tr>
					</table>
	
	<?php
	}
	
}
else
{
echo "No such Exam found";	
}	
}
}
?>
