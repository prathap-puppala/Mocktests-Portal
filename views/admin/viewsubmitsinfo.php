<?php

require_once("../../site-settings.php");
$isl=(isloggedin())?true:false;

if(!$isl)
{
require_once("views/login.php");
}
else if(isadminloggedin()){

$id=$_SESSION['userid'];
$userdet=mysql_fetch_array(mysql_query("SELECT * FROM admin WHERE stuid='$id'"));	
?>

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">View Submits Info</h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li class="active">View Submits Info</li>
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
              <form class="form-horizontal" method="post" action="javascript:void(0)" onsubmit="return sea()">
                <table class="table table-bordered">
					<tr><td  class="warning">
                  User ID
                  </td><td  class="success">
                  <div class="col-sm-10" >
                    <div class="radio radio-info radio-inline">
                        <input type="text" class="form-control" id="uid" value="" name="radioInline">
                      </div>&nbsp;
                      
                      <input type="submit" name="submit" value="search" class="btn btn-primary">
                                    </div>
                </td></tr>
                <!--start of div Give now option-->
                <tr><td colspan='2' id='subp' style='display:none;'>
                </td></tr>
                <!--end of div Give now option-->
                
                
                </table>
</form>
</div>
    
</div>
</div>
</div>
<script>

//function for searching user exams
function sea()
{
var uid=$("#uid").val();
$("#subp").slideDown().html("<center><br><br><img src='myown/img/loading8.gif'><br>Loading...<br></center>").load("logic/php/admin/searchstudent.php?uid="+uid);	
}
</script>
<?php

}
?>
