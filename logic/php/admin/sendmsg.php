<?php

require_once("../../../site-settings.php");
$isl=(isloggedin())?true:false;

if(!$isl)
{
require_once("views/login.php");
}
else if(isadminloggedin()){

$id=$_SESSION['userid'];
$userdet=mysql_fetch_array(mysql_query("SELECT * FROM admin WHERE stuid='$id'"));	
if(isset($_GET['sno']))
{
$sno=mysql_real_escape_string(trim(htmlspecialchars($_GET['sno'])));
$qu=mysql_query("SELECT * FROM examdetails WHERE sno='$sno' and (answersmode='answersgivenow' or answersmode='answersafterexamonline') and validations>0");
if(mysql_num_rows($qu)>=1)
{
$fff=mysql_fetch_array($qu);
?>

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">Send Results as Messages</h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li class="active">Send Results as Messages</li>
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
    <div class="col-md-12">
      <div class="panel panel-default">

                <div class="panel-body">
              <form class="form-horizontal">
                <table class="table table-bordered">
		
                <!--start of div Give now option-->
                <tr><td colspan='2' id='subp'>
				<center>
				<h1 style='color:blue;'>Sending............</h1><br>
				<h6>Sending <b style='color:red;'><?php $tab=$fff['tkey']; echo $fff['title'];?></b> Results as Messages for <b style='color:red;'><?php mysql_select_db("quiz_exams",$con); echo mysql_num_rows(mysql_query("SELECT * FROM $tab WHERE status='Y'")); mysql_select_db($dbname,$con); ?></b> Students..</h6>
				</center> 
                </td></tr>
                <!--end of div Give now option-->
                
                
                </table>
                <?php
                $eid=$fff['eid'];
                $sender="Admin";
                $receiver="";
                $send=0;
                $tab=$fff['tkey'];
                $sendertype="admin";
                mysql_query("UPDATE examdetails SET resultssendasmsgs=resultssendasmsgs+1 WHERE sno='$sno'");
                mysql_select_db("quiz_exams",$con); 
                $qq=mysql_query("SELECT * FROM $tab WHERE status='Y'");
                while($r=mysql_fetch_array($qq))
                {
				mysql_select_db("quiz_exams",$con); 
                $receiver=$r['ID'];
				$matter="<table id=customers><tr><th colspan=5><center>Your Results for <b style=color:yellow;>".$fff['title']."</b></center></th></tr><tr class=alt><td>Questions</td><td>Not Attempted</td><td>Marks</td><td>Correct</td><td>Wrong</td></tr><tr><td>".$fff['questions']."</td><td>".($fff['questions']-($r['correct']+$r['wrong']))."</td><td>".$r['marks']."</td><td>".$r['correct']."</td><td>".$r['wrong']."</td></tr></table>";	
				mysql_select_db($dbname,$con);	
				if(mysql_query("INSERT INTO messages(eid,sender,receiver,matter,replysend,sendertype,ip,date) VALUES('$eid','$sender','$receiver','$matter','1','admin','$ip','$date')") or die(mysql_error())){$send++;}
				}
				echo "<tr><td><br><br><center><h1 style='color:green'>Sent</h1><br><h6>Sent to <b style='color:red;'>".$send."</b> Students.</h6></center></td></tr>";
                ?>
</form>
</div>
    
</div>
</div>
</div>
<?php
}
}
}
?>
