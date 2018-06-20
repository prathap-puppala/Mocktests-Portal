<meta http-equiv="refresh" content="5">
<?php

require_once("../../site-settings.php");
if(isloggedin())
{
if(1==1)
{
if(1==1)
{
?>
<script>

//function for showing options
function shwopt(opt,sid,realans)
{
$("#uid").html(sid+" Options");
var n=new Array();
n=opt.split("~");
var ren=new Array();
ren=realans.split("~");

var cur=0;
var str="<table  class='table display' width='50%'><tr><th>Q.no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your option&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Real Answer</th><tr><td>";
for(var i=0;i<n.length;i++)
{
cur++;
var ann;
if(n[i]=="prathap"){ann="-";}
else{ann=n[i];}
var cu="";
if(ren[i]=="Correct"){cu="<font color='green'>Correct</font>";} else if(ren[i]=="Wrong"){cu="<font color='red'>Wrong</font>";}else{cu="NotAttempted";}
str=str+"<mark>Que "+(i+1)+"</mark>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>"+ann+"</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>"+ren[i]+"</b></td></tr><tr><td>";
}
str=str+"</tr></table>";

$("#opt").html(str);	
}
</script>

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">Results</h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li class="active">Results</li>
      </ol>

    <!-- Start Page Header Right Div -->
    <div class="right">
      <div class="btn-group" role="group" aria-label="...">
        <span style='text-align:left;'>Server Date &nbsp;: <span id="date" style="color:red;"></span>
      <script type="text/javascript">
var auto_refresh = setInterval(
function ()
	{
	$('#date').load('Date.php');
	},1000);
</script>&nbsp;
<br>
        Server Time : <span id="clock" style="color:red;"></span>
      <script type="text/javascript">
var auto_refresh = setInterval(
function ()
	{
	$('#clock').load('Time.php');
	},1000);
</script>
</span>
      </div>
    </div>
    <!-- End Page Header Right Div -->

  </div>
  <!-- End Page Header -->

      
<div class="row">
    <!-- Start Panel -->
    <div class="col-md-12">
      <div class="panel panel-default">
        
        <div class="panel-body table-responsive">
   <table  width="100%" style="text-align:center;" class="table table-bordered table-striped">
                <tbody>
					<tr><th colspan='2'><center>Results</center></th></tr>
			</tbody>
			</table>
            <table id="example" class="table display">
                <thead>
                    <tr>
                        <th>Exam Name</th>
                        <th>Q.Paper</th>
                          <th>Answers</th>
                         <th>Questions</th>
                        <th>Marks</th>
                        <th>Correct Ques</th>
                        <th>Wrong Ques</th>
                         <th>Date</th>
                        <th>Login Time</th>
                        <th>Submit Time</th>
                        <th>More</th>
                    </tr>
                </thead>
             
             
                <tbody>
				<?php
				$q=mysql_query("SELECT * FROM examdetails WHERE displayinprofile='1' ORDER BY sno DESC");
				while($w=mysql_fetch_array($q))
				{
				$sno=$w['sno'];
				$ii=$_SESSION['userid'];
				$tab=$w['tkey'];
        
           $ans=$w['answers'];
           $organs=explode("~",$w['answers']);
           $orgopt=explode("~",$w['answers']);
	   $examdate=$w['date'];
      
				if($w['displayinprofile']=="1")
				{
				mysql_select_db("quiz_exams",$con);
				$qq=mysql_query("SELECT * FROM $tab WHERE status='Y' and ID='".$_SESSION['userid']."'");
				if(mysql_num_rows($qq)>=1)
				  {
					 $r=mysql_fetch_array($qq);
           $useopt=explode("~",$r['options']);     
         	 mysql_select_db($dbname,$con);
           $stat="";
           $gg=0;
           
           for($i=0;$i<count($organs);$i++)
           {
           if($useopt[$i]!="prathap"){if($useopt[$i]==$organs[$i]){$stat=$stat."Correct~";}else{$stat=$stat."Wrong~";}}
           else{$stat=$stat."NotAttempted~";}
           }
           
					?>
					<tr id="qwe<?php echo $w['sno'];?>">
                        <td><?php echo $w['title'];?></td>
                         <td><?php if($examdate<date("d-m-Y")){?><a href="download.php?sno=<?php echo $w['sno'];?>" target="_blank">Click here</a><?php } else{echo "Not available";}?></td>
                         <td><?php if($examdate<date("d-m-Y")){?><a  class='' target="_blank" style='cursor:pointer' href="javascript:void(0);" data-toggle="modal" data-target="#myModal2" onclick=shwopt("<?php  echo $r['options'];  ?>","<?php  echo $r['ID'];  ?>","<?php  echo $ans;  ?>")>Click here</a>&nbsp;<?php } ?></td>
                        <td><?php echo $w['questions'];?></td>
                        <td><mark><?php if($w['answersmode']!="answersafterexamexcel"){echo $r['marks'];}?></mark></td>
                        <td><?php echo $r['correct'];?></td>
                        <td><?php echo $r['wrong'];?></td>
                        <td><?php echo $w['date'];?></td>
                        <td><?php echo $r['Logintime'];?></td>
                        <td><?php echo $r['Submittime'];?></td>
                        <td>
							    <?php if($w['validations']>0 && $w['displayinprofile']>0){?><a class="btn btn-primary" style='cursor:pointer;'  onclick="re('<?php echo $ii;?>','<?php echo $sno;?>')" title="Re-validate"><i class="fa fa-binoculars"></i></a><?php } ?>
   <span id="asd<?php echo $ii;?>"></span>&nbsp;&nbsp;&nbsp;<a  class='btn btn-rounded btn-warning' target="_blank" style='cursor:pointer' href="certificate/examwise.php?sno=<?php echo $sno;?>">Certificate</a></td>
                        
                    </tr>
                    <?php } } } ?>
                </tbody>
            </table>


        </div>

      </div>
    </div>
    <!-- End Panel -->
    </div>
    

            <!-- Modal -->
            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="uid"></h4>
                  </div>
                  <div class="modal-body" id="opt">
                    ...
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

          <!-- End Moda Code -->
          
    
    <script src="js/datatables/datatables.min.js"></script>
    
    <?php } } } ?>
