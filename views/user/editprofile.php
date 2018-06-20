<meta http-equiv="refresh" content="5">
<?php

require_once("../../site-settings.php");
if(isloggedin() && $teckzitemode==false)
{
if(1==1)
{
if(1==1)
{
$user=$_SESSION['userid'];
$qwe=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$user'"));
?>
  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">EDIT PROFILE</h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li><a href="javascript:void(0)">Profile</a></li>
        <li class="active">EDIT PROFILE</li>
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

      <div class="container-widget">

	<center>
<div class="row">
    <!-- Start Panel -->
    <div class="col-md-12">
      <div class="panel panel-default">
        
        <div class="panel-body table-responsive">
   <table  width="100%" style="text-align:justify;" class="table table-bordered table-striped">
                <tbody>
					<tr><th colspan='2'><center>EDIT PROFILE</center></th></tr>
					<tr><th colspan='2'><marquee><font color='red'>We have disabled edit profile option Temporarily.</font></marquee></th></tr>
			</tbody>
			</table>
            <table id="example" width="80%" class="table table-bordered table-striped">
               
             
             
                <tbody>
				<tr><td width="10%">User ID</td><td> <input type="text" id="uid" class="form-control" value="<?php echo $qwe['stuid'];?>" readonly></td></tr>
				<tr><td width="10%">Name</td><td> <input type="text" id="uid" class="form-control" value="<?php echo $qwe['name'];?>" readonly><br>Original Name is <mark><?php echo $qwe['name'];?></mark></td></tr>
				<tr><td width="10%">Gender</td><td> <input type="text" id="uid" class="form-control" value="<?php echo $qwe['gender'];?>" readonly></td></tr>
				<tr><td width="10%">Year</td><td> <input type="text" id="uid" class="form-control" value="<?php echo $qwe['year'];?>" readonly></td></tr>
				<tr><td width="10%">Branch</td><td> <input type="text" id="uid" class="form-control" value="<?php echo $qwe['branch'];?>" readonly></td></tr>
				<tr><td width="10%">Class</td><td> <input type="text" id="uid" class="form-control" value="<?php echo $qwe['class'];?>" readonly></td></tr>
				<tr><td width="10%">Email</td><td> <input type="text" id="uid" class="form-control" value="<?php echo $qwe['email'];?>" readonly></td></tr>
				<tr><td width="10%">Secrete Key</td><td> <mark><?php echo $qwe['seccode'];?></mark></td></tr>
				</tbody>
            </table>


        </div>

      </div>
    </div>
    <!-- End Panel -->
 </div>
   </center>    
</div>
    <?php } } } ?>
