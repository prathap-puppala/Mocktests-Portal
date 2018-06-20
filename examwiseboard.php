<?php
require("site-settings.php");
if(!isloggedin()){echo "Please Login";exit;}
?>
<table width="100%" border="1">
<tr><td>
<?php
$cat=0;
$qq=mysql_query("SELECT * FROM examdetails WHERE  displayinprofile='1' ORDER BY sno DESC");
while($rr=mysql_fetch_array($qq))
{
$cat++;
$tab=$rr['tkey'];
$name=$rr['title'];	
    mysql_select_db("quiz_exams",$con);
                     $qu=mysql_fetch_array(mysql_query("SELECT MAX(marks) as high from $tab WHERE status='Y'"));
                     $hii=$qu['high'];
                     $tt=mysql_query("SELECT * FROM $tab WHERE status='Y' and marks='$hii'");
                             
?>
<div style="width:430px;height:430px;overflow-x:hidden;">
<table   width="90%" style="text-align:center;border-radius:20px;" class="table table-bordered table-striped" >
<tr class="success" style="border-radius:20px;">
<th colspan="3">
<center id="avail"><?php echo $name;?></center>
</th>
</tr>
<tr class="warning">
<th width="10%" style='text-align:center;' >ID</th>
<th width="10%" style='text-align:center;' >Marks</th>
<th width="25%" style='text-align:center;' >Name</th>
</tr>
<?php
         if(mysql_num_rows($tt)<1){echo "<tr><td style='height:20px;' colspan='5'>No one has submitted</td></tr>";}
                     else{
                     while($ty=mysql_fetch_array($tt))
                     {
                     $ti=$ty['ID'];
                     mysql_select_db("quiz",$con);
                    
                     $rry=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$ti'"));
              
                     echo "<tr><td style='height:20px;'>".$ty['ID']."</td><td style='height:20px;font-weight:bold;font-size:16px;'>".$hii."</td><td style='height:20px;'>".$rry['name']."</td></tr>";
                     }
                     }  
                     ?>
</table>
</div>
</td><td><?php if($cat%2==0){echo "</td></tr><tr><td>";}?>
<?php } ?>
</table>
