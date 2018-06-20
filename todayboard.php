<?php
require("site-settings.php");
if(!isloggedin()){echo "Please Login";exit;}
?><table   width="90%" style="text-align:center;border-radius:20px;" class="table table-bordered table-striped" >
<tr class="success" style="border-radius:20px;">
<th colspan="5">
<center id="avail">Leader Board</center>
</th>
</tr>
<tr class="warning">
<th width="10%" style='text-align:center;' >Student ID</th>
<th width="10%" style='text-align:center;' >Rank</th>
<th width="25%" style='text-align:center;' >Name</th>
<th width="17%" style='text-align:center;' >Year</th>
<th width="17%" style='text-align:center;' >Class</th>
</tr>
<tr>
<?php
$def=0;
$query=mysql_query("SELECT * from examdetails WHERE displayinprofile='1' and date='$date' ORDER BY sno DESC");
while($query_fet=mysql_fetch_array($query))
{
$tab=$query_fet['tkey'];
mysql_select_db("quiz_exams",$con);
$def=$def+mysql_num_rows(mysql_query("SELECT * FROM $tab WHERE status='Y'"));
}

if($def>0)
{
$marksarr=array();
mysql_select_db($dbname,$con);
$sss=mysql_query("SELECT * FROM users");
while($tty=mysql_fetch_array($sss))
{
$id=$tty['stuid'];
$totalmarks=0;
$credits=0;
mysql_select_db($dbname,$con);

mysql_select_db($dbname,$con);
$date=date("d-m-Y");
$qee=mysql_query("SELECT * from examdetails WHERE displayinprofile='1' and date='$date' ORDER BY sno DESC");
while($qwe=mysql_fetch_array($qee))
{
$tab=$qwe['tkey'];
$que=$qwe['questions'];
$ccone=$qwe['ccone'];
mysql_select_db("quiz_exams",$con);
$rr=mysql_query("SELECT * FROM $tab WHERE ID='$id' and status='Y' ORDER BY Submittime DESC");	
if(mysql_num_rows($rr)>0)
{
$credits=$credits+($que*$ccone);
$fr=mysql_fetch_array($rr);
$marks=$fr['marks'];
$marks=($marks<0)?0:$marks;
$totalmarks=$totalmarks+$marks;
}
}	
array_push($marksarr,array($id,$totalmarks,$credits));
}                    
$high=-200;
$rank=1;
for($i=0;$i<count($marksarr);$i++)
{
if($marksarr[$i][1]>$high){$high=$marksarr[$i][1];}
}
for($j=0;$j<count($marksarr);$j++)
{
for($i=0;$i<count($marksarr);$i++)
{
if($marksarr[$i][1]==$high){
	mysql_select_db($dbname,$con);
	$ffe=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='".$marksarr[$i][0]."'"));
	echo "<tr><td>".$marksarr[$i][0]."</td><td><mark>$rank</mark></td><td>".$ffe['name']."</td><td>".$ffe['year']."-".$ffe['branch']."</td><td>".$ffe['class']."</td></tr>";
	$rank++;
	}

}
$high--;
}
}
else
{
echo "<tr><td colspan='5'><center>No one has written today exams/there are no exams for today</center></td></tr>";
}
?>
</table>

