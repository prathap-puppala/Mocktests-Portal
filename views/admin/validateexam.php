<meta http-equiv="refresh" content="5">
<?php

require_once("../../site-settings.php");
if(isadminloggedin())
{
if(isset($_GET['valida']) && isset($_GET['sno']) && !empty($_GET['sno']))
{
$mode="answersafterexamonline";
$sno=mysql_real_escape_string(trim(strip_tags($_GET['sno'])));
$allowed=array("answersafterexamonline","answersafterexamexcel");
if(trim(mysql_real_escape_string($_GET['valida']))=="validate")
{
$wer=mysql_query("SELECT * FROM examdetails WHERE sno='$sno' && answersmode='$mode' and validations='0'");
}
else
{
$wer=mysql_query("SELECT * FROM examdetails WHERE sno='$sno' && answersmode='$mode' and validations>0");
}
if(in_array($mode,$allowed) && mysql_num_rows($wer))
{
$qqq=mysql_fetch_array($wer);
$viewn=($mode=="answersafterexamonline")?"Answers After Exam Online":"Answers After Exam Excel";

?>
  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title"><b style='color:red;'><?php echo $qqq['title']."</b> Results Re-Validation view";?></h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li><a href="#">Result</a></li>
        <li class="active">Result Validation</li>
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
        
        <div class="panel-body table-responsive" id='ree'>
   <table  width="100%" style="text-align:justify;" class="table table-bordered table-striped">
                <tbody>
					<tr><th colspan='2'><center> <b style='color:red;'><?php echo $qqq['title'];?> </b> Validation View</center></th></tr>
			</tbody>
			</table>
            <table id="example" class="table display">
                <thead>
                    <tr>
                        <th>Quesn</th>
                        <th>Answer</th>
                    </tr>
                </thead>
             
             
                <tbody>
				<?php
				if($teckzitemode)
				{
				
if(trim(mysql_real_escape_string($_GET['valida']))=="validate")
{
				$q=mysql_query("SELECT * FROM examdetails WHERE eid!='NULL' and visibility='1' and answersmode='$mode' and validations='0'");
}
else
{
			$q=mysql_query("SELECT * FROM examdetails WHERE eid!='NULL' and visibility='1' and answersmode='$mode' and validations>0");
}
			    }
			    else
			    {
if(trim(mysql_real_escape_string($_GET['valida']))=="validate")
{
				$q=mysql_query("SELECT * FROM examdetails WHERE eid='NULL' and visibility='1' and answersmode='$mode' and validations='0'");
}
else
{
			$q=mysql_query("SELECT * FROM examdetails WHERE eid='NULL' and visibility='1' and answersmode='$mode' and validations>0");
}
			    }
				$w=mysql_fetch_array($q);
				for($i=1;$i<=$w['questions'];$i++)
				{
				echo "<tr><td><mark>Que".$i."</mark></td><td><input type='text' class='form-control'  id=anns".$i." maxlength='1' onkeyup=con('".$i."',this.value) size='3'>	</td></tr>";	
				}
				?>
                  <tr><td colspan="2"><center>
                  <a class="btn btn-success" style='cursor:pointer;'  onclick=validateexam("<?php echo $sno;?>","<?php echo $w['questions'];?>")><i class="fa fa-check-square-o"></i>Validate</a>
      <span id='loader'></span>
                  </center></td></tr>  
                </tbody>
            </table>


        </div>

      </div>
    </div>
    <!-- End Panel -->
    </div>
    
<script>

function validateexam(sno,ques)
{
var realans="";
var c=1;
for(var i=1;i<=ques;i++)
{
if($("#anns"+i).val()=="")
{
alert("Please Enter answer for "+i+" Question");
return false;
break;

}
else
{
if(c<ques){realans=realans+$("#anns"+i).val()+"~";}	
else{realans=realans+$("#anns"+i).val();}	
}	
c++;
}



$("#loader").html("<img src='myown/img/loading8.gif'>");	
if(confirm("Are you sure?")){
	$.post("logic/php/admin/validateexam-c.php",{realans:realans,sno:sno},function(data){$("#ree").html(data);});
}

}

function con(f,va)
{
$("#anns"+f).val(va);	
}
</script>
    
    <script src="js/datatables/datatables.min.js"></script>
    
    <?php } } } ?>
