<?php

if($_SERVER['QUERY_STRING']!=""){exit;}

require_once("site-settings.php");
$isl=(isloggedin())?true:false;

if(!$isl)
{
require_once("views/login.php");
}
else if(isloggedin()){
if($_SERVER['QUERY_STRING']!=""){exit;}	
if(isset($_SESSION['Exam'])){header("location:startexam.php");}
    
$id=$_SESSION['userid'];
$examswritten=0;
if($teckzitemode)
{
mysql_select_db($teckzitedb,$con);
$userdet=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$id'"));	
$name=$userdet['stuname'];
$eveids=$userdet['eventids'];
}
else
{
$userdet=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$id'"));	
$name=$userdet['name'];
$examswritten=$userdet['examswritten'];
}
mysql_select_db($dbname,$con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title;?></title>
  <!-- ========== Css Files ========== -->
  <link href="css/root.css" rel="stylesheet">
  <link rel="icon" href="myown/img/user.png">
<style>
#avail{font-size:16px;font-family:Times New Roman;}
</style>
<link rel="stylesheet" href="css/flipclock.css">

  <noscript><style>html:before{content:"Javascript is disabled.";font-size:25px;padding:40%;font-family:Times New Roman;text-align:center;color:red;}html:after{content:"Please contact admin or enable Javascript.";font-size:25px;padding:34%;font-family:Times New Roman;text-align:center;color:green;}body{display:none;}</style></noscript>
  </head>
  <body onload="hideleftnav()" id="bdy" style="background:#f5f5f5;">
  <!-- Start Page Loading -->
  <div class="loading"><img src="img/loading.gif" alt="loading-img"></div>
  <!-- End Page Loading -->
  <!-- START TOP -->
  <div id="top" class="clearfix">

    <div class="applogo">
      <a href="index" class="logo"><img src='myown/img/logo.png' width='30px'>&nbsp;<?php echo $title;?></a>
    </div>

    <!-- Start Sidebar Show Hide Button -->
    <a href="#" class="sidebar-open-button"><i class="fa fa-bars"></i></a>
    <a href="#" class="sidebar-open-button-mobile"><i class="fa fa-bars"></i></a>
    <!-- End Sidebar Show Hide Button -->

    <!-- Start Searchbox -->
    <form class="searchform" method="post" action="javascript:void(0)">
      <input type="text" class="searchbox" id="searchbox" placeholder="Search">
      <span class="searchbutton"><i class="fa fa-search"></i></span>
    </form>
    <!-- End Searchbox -->


    <!-- Start Top Menu -->
    <ul class="topmenu">
 <li><a title="Notifications" name="views/user/notices.php" onclick="load_page(this.name)" style='cursor:pointer;'>Notifications<sup><?php $date=date("d-m-Y");$g=mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE added_date='$date' && visibility='1'")); if($g>0){?><span class="label label-danger"><?php echo $g;?></span><?php } ?></sup></a></li>
 <li><a title="messages" name="views/user/messages.php" onclick="load_page(this.name)" style='cursor:pointer;'>Messages</a></li>
 <li><a title="Results" name="views/user/results.php" onclick="load_page(this.name)" style='cursor:pointer;'>Results</a></li>
 <li><a href="views/logout" style='cursor:pointer;'>Logout</a></li>
         </ul>
    <!-- End Top Menu -->
    <!-- Start Sidepanel Show-Hide Button -->
    <a href="#sidepanel" class="sidepanel-open-button"><i class="fa fa-outdent"></i></a>
    <!-- End Sidepanel Show-Hide Button -->

    <!-- Start Top Right -->
    <ul class="top-right">

    <li class="dropdown link">
      <a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle profilebox"><img src="myown/img/user.png" alt="img"><b><?php echo $name; ?></b><span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
          <li role="presentation" class="dropdown-header">Profile</li>
          <?php if($teckzitemode==false){?>
          <li><a  title="Edit Profile" name="views/user/editprofile.php" onclick="load_page(this.name)" style='cursor:pointer;'><i class="fa falist fa-wrench"></i>Edit Profile</a></li>
          <li><a  title="Change Password" name="views/user/changepasswd.php" onclick="load_page(this.name)" style='cursor:pointer;'><i class="fa falist fa-wrench"></i>Change Password</a></li>
          <?php } ?>
          <li class="divider"></li>
          <li><a title="Logout" href="views/logout.php"><i class="fa falist fa-power-off"></i> Logout</a></li>
        </ul>
    </li>

    </ul>
    <!-- End Top Right -->

  </div>
  <!-- END TOP -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 


<!-- //////////////////////////////////////////////////////////////////////////// --> 

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTENT -->
<div class="content" id="pag_load">
  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">Welcome <b style='color:green;'><?php if($teckzitemode){echo $userdet['stuname'];}else{echo $userdet['name'];} ?></b></h1>
      <ol class="breadcrumb">
        <li class="active">Rajiv Gandhi University of Knowledge Technologies,Nuzvid.</li>
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

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="container-widget">


  <!-- Start First Row -->
  <div class="row">


    <!-- Start Files -->
    <div class="col-md-12 col-lg-9">
      <div class="panel panel-widget"  style="padding:0px;height:400px;border:1px dotted #399BFF;">
        <div class="panel-body table-responsive">
	
                
<div role="tabpanel" style="border:1px solid #399BFF;padding:0px;height:398px;margin:0px;">
              <!-- Nav tabs -->
                  <ul class="nav nav-tabs tabcolor5-bg" role="tablist">
                    <li role="presentation" class="active" style="border:0.4px solid #399BFF;"><a href="#exa" aria-controls="exa" role="tab" data-toggle="tab">Available Exams<span id='ccou'></span></a></li>
                    <li role="presentation" style="border:0.4px solid #399BFF;"><a href="#leaderboard" aria-controls="leaderboard" role="tab" data-toggle="tab">Leader Board</a></li>
                    <li role="presentation" style="border:0.4px solid #399BFF;"><a href="#weektoppers" aria-controls="weektoppers" role="tab" data-toggle="tab">This week Ranks</a></li>

                    <li role="presentation" style="border:0.4px solid #399BFF;"><a href="#currentday" aria-controls="currentday" role="tab" data-toggle="tab">Today Ranks</a></li>
                    <li role="presentation" style="border:0.4px solid #399BFF;"><a href="#examwisetoppers" aria-controls="examwisetoppers" role="tab" data-toggle="tab">Exam wise Toppers</a></li>
                    <li role="presentation" style="border:0.4px solid #399BFF;"><a href="#examprocedure" aria-controls="examprocedure" role="tab" data-toggle="tab">Exams Procedure</a></li>
 <li role="presentation" style="border:0.4px solid #399BFF;"><a href="#rankingprocedure" aria-controls="rankingrocedure" role="tab" data-toggle="tab">About Ranking</a></li>

                    </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active"  style="height:314px;overflow-x:hidden;" id="exa">
               <center><a onclick="load_page('views/user/answersgivenow-exam.php')" style="font-size:18px;text-decoration:underline;color:red;cursor:pointer;">Create Exam</a></center>
               <center><a href="javascript:void(0);" style="font-size:14px;text-decoration:none;color:green;">Credits for each Correct Answer : <big><mark>3</mark></big> &nbsp;Credits for each Wrong Answer : <big><mark>-1</mark></big></a></center>
<div>
            <table   width="90%" style="text-align:center;border-radius:20px;" class="table table-bordered table-striped" >
<tr class="success" style="border-radius:20px;">
<th colspan="7">
<center id="avail">Available Exams</center>
</th>
</tr>
<tr class="warning">
<th width="21%" style='text-align:center;' >Title</th>
<th width="15%" style='text-align:center;' >Close Time</th>
<th width="7%" style='text-align:center;' >Logins</th>
<th width="7%" style='text-align:center;' >Submits</th>
<th width="15%" style='text-align:center;' >Login</th>
<th width="15%" style='text-align:center;' >Submit</th>
<th width="17%" style='text-align:center;' >Status</th>
</tr>
<?php
$ecou=0;
if($teckzitemode==false)
{
$radioid=1;
$c=1;

	mysql_select_db("quiz_exams",$con);
	$user=$_SESSION['userid'];
	mysql_select_db($dbname,$con);
$date=date("d-m-Y");
	$result=mysql_query("SELECT * FROM examdetails WHERE visibility='1' and date='$date' and eid='NULL' ORDER BY sno DESC");
	$count=0;
	while($row=mysql_fetch_array($result))
	{
	$c+=1;
	$p=($c%2);
	$count+=1;
	$sno=$row['sno'];
	$Num=$row['tkey'];
	$Examtitle=$row['title'];
	$date=$row['date'];
	$Starttime=$row['display'];
	$Endtime=$row['endat'];
	$Type=$row['type'];
	$Options=$row['options'];	
	$Questions=$row['questions'];
	$login="";
	$ip="";
	$submit="";
	$submittime="";
	mysql_select_db("quiz_exams",$con);
	$res=mysql_query("SELECT * FROM ".$Num." WHERE ID='".$user."'");
	
	$totallog=mysql_num_rows(mysql_query("SELECT * FROM $Num"));
	$totalsub=mysql_num_rows(mysql_query("SELECT * FROM $Num WHERE status='Y'"));
	while ($row=mysql_fetch_array($res))
		{
		$login=$row['Logintime'];
		$submit=$row['status'];
		$submittime=$row['Submittime'];
		$ip=$row['IP'];
		}
	if ($ip==null)
	{
	$ip='Take Exam';
	}
	else
	{
	$ip='Taken Exam From IP '.$ip;
	}
	$H=substr($Endtime,0,2);
	$M=substr($Endtime,2,2);
	$m='AM';
	$H-=10;
	if ($H>=12)
		{
		$m='PM';
		}
	if ($H>12)
		{

		$H=$H-12;
		}
	if ($H<10)
		{
		$H='0'.$H;
		}
	$Close=$H.':'.$M.' '.$m;
	if ($submit=="Y")
	{
	echo "<tr title='".$ip."'><td><mark>".$Examtitle."</mark></td><td>$Close</td><td>$totallog</td><td>$totalsub</td><td>".$login."</td><td>".$submittime."</td><td><input type='button' class='btn btn-rounded btn-success' onclick=\"msg('$title Alert','$user already submitted this exam.')\" value='Submitted' /></td></tr>\n";
	}
	else
	{
	if ($Endtime<$ptime)
	{
	
	echo "<tr title='".$ip."'><td>".$Examtitle."</td><td>$Close</td><td>$totallog</td><td>$totalsub</td><td>".$login."</td><td>".$submittime."</td><td><input type='button' class='btn btn-rounded btn-danger' onclick=\"msg('$title Alert','Exam Login Timeup.')\" value='Time Up' /></td></tr>\n";
	}
	else if ($Starttime>$ptime)
	{
	$H=substr($Starttime,0,2);
	$M=substr($Starttime,2,2);
	$m='AM';
	$H-=10;
	if ($H>=12)
		{
		$m='PM';
		}
	if ($H>12)
		{
		$H=$H-12;
		}
	if ($H<10)
		{
		$H='0'.$H;
		}
	$ctime=$H.':'.$M.' '.$m;
	echo "<tr title='".$ip."'><td>".$Examtitle."</td><td>$Close</td><td>$totallog</td><td>$totalsub</td><td>".$login."</td><td>".$submittime."</td><td><input type='button' class='btn btn-rounded btn-option2' onclick=\"msg('$title Alert','Exam Display Visible at $ctime.')\"  value='Time to Exam' /></td></tr>\n";
	}
	else
	{
	$ecou++;
	echo "<tr title='".$ip."'><td>".$Examtitle."</td><td>$Close</td><td>$totallog</td><td>$totalsub</td><td>".$login."</td><td>".$submittime."</td><td><a class='btn btn-rounded btn-primary' style='cursor:pointer' onclick=startexam('".$sno."')>Take Exam</a></form></td></tr>\n";
	$radioid+=1;
	}
	}
	
	}
	echo "<tr><td colspan='6'></td></tr>
</table>
</div>
	
	";
}
else
{
mysql_select_db($teckzitedb,$con);
$ei=array();
$ei=explode("~",$eveids);
$radioid=1;
$c=1;

	mysql_select_db("quiz_exams",$con);
	$user=$_SESSION['userid'];
	mysql_select_db($dbname,$con);
	$result=mysql_query("SELECT * FROM examdetails WHERE visibility='1' and date='$date'  and eid!='NULL' ORDER BY endat ASC");
	$count=0;
	while($row=mysql_fetch_array($result))
	{
	$c+=1;
	$p=($c%2);
	$count+=1;
	$sno=$row['sno'];
	$Num=$row['tkey'];
	$Examtitle=$row['title'];
	$date=$row['date'];
	$Starttime=$row['display'];
	$Endtime=$row['endat'];
	$Type=$row['type'];
	$Options=$row['options'];	
	$Questions=$row['questions'];
	$login="";
	$eid=$row['eid'];
	$ip="";
	$submit="";
	$submittime="";
	mysql_select_db("quiz_exams",$con);
	$res=mysql_query("SELECT * FROM ".$Num." WHERE ID='".$user."'");

	$totallog=mysql_num_rows(mysql_query("SELECT * FROM $Num"));
	$totalsub=mysql_num_rows(mysql_query("SELECT * FROM $Num WHERE status='Y'"));
                
	while ($row=mysql_fetch_array($res))
		{
		$login=$row['Logintime'];
		$submit=$row['status'];
		$submittime=$row['Submittime'];
		$ip=$row['IP'];
		}
	$ip='';
	
	$H=substr($Endtime,0,2);
	$M=substr($Endtime,2,2);
	$m='AM';
	$H-=10;
	if ($H>=12)
		{
		$m='PM';
		}
	if ($H>12)
		{

		$H=$H-12;
		}
	if ($H<10)
		{
		$H='0'.$H;
		}
	$Close=$H.':'.$M.' '.$m;
	$subcount=0;
	$submitcount=0;
	mysql_select_db($teckzitedb,$con);
	$det=mysql_fetch_array(mysql_query("SELECT * FROM event_registrations WHERE eid='$eid' and ids LIKE '%$user%'"));
	$ids=array();
	$stid=$user;
	$ids=explode("~",$det['ids']);
	mysql_select_db("quiz_exams",$con);
	for($i=0;$i<count($ids);$i++)
	{
	$suid=$ids[$i];
	if($suid==$user){continue;}
	if(mysql_num_rows(mysql_query("SELECT * FROM $Num WHERE ID='$suid' && status='N'"))>=1){$stid=$suid;$subcount++;break;}
	if(mysql_num_rows(mysql_query("SELECT * FROM $Num WHERE ID='$suid' && status='Y'"))>=1){$stid=$suid;$submitcount++;break;}
	}
	
	mysql_select_db($dbname,$con);
	if($subcount>0 && in_array($eid,$ei))
	{
	mysql_select_db("quiz_exams",$con);
	$ll=mysql_fetch_array(mysql_query("SELECT * FROM $Num WHERE ID='$stid'"));
	$login=$ll['Logintime'];
	$submittime=$ll['Submittime'];
	
	echo "<tr title='".$ip."'><td><mark>".$Examtitle."</mark></td><td>$totallog</td><td>$totalsub</td><td>$Close</td><td>".$login."</td><td>".$submittime."</td><td><input type='button' class='btn btn-rounded btn-warning' onclick=\"msg('$title Alert','Your Teammate $suid is writing this exam.')\" value='Friend is writing' /></td></tr>\n";
	}
	else if($submitcount>0 && in_array($eid,$ei))
	{
	mysql_select_db("quiz_exams",$con);
	$ll=mysql_fetch_array(mysql_query("SELECT * FROM $Num WHERE ID='$stid'"));
	$login=$ll['Logintime'];
	$submittime=$ll['Submittime'];

	echo "<tr title='".$ip."'><td><mark>".$Examtitle."</mark></td><td>$Close</td><td>$totallog</td><td>$totalsub</td><td>".$login."</td><td>".$submittime."</td><td><input type='button' class='btn btn-rounded btn-success' onclick=\"msg('$title Alert','Your Teammate $suid submitted this exam.')\" value='Friend submitted' /></td></tr>\n";
	}
	else
	{
	mysql_select_db($dbname,$con);
	if ($submit=="Y" && in_array($eid,$ei))
	{
	echo "<tr title='".$ip."'><td><mark>".$Examtitle."</mark></td><td>$Close</td><td>$totallog</td><td>$totalsub</td><td>".$login."</td><td>".$submittime."</td><td><input type='button' class='btn btn-rounded btn-success' onclick=\"msg('$title Alert','$user already submitted this exam.')\" value='Submitted' /></td></tr>\n";
	}
	else
	{
	if ($Endtime<$ptime && in_array($eid,$ei))
	{
	
	echo "<tr title='".$ip."'><td>".$Examtitle."</td><td>$Close</td><td>$totallog</td><td>$totalsub</td><td>".$login."</td><td>".$submittime."</td><td><input type='button' class='btn btn-rounded btn-danger' onclick=\"msg('$title Alert','Exam Login Time Up.')\" value='Time Up' /></td></tr>\n";
	}
	else if ($Starttime>$ptime && in_array($eid,$ei))
	{
	$H=substr($Starttime,0,2);
	$M=substr($Starttime,2,2);
	$m='AM';
	$H-=10;
	if ($H>=12)
		{
		$m='PM';
		}
	if ($H>12)
		{
		$H=$H-12;
		}
	if ($H<10)
		{
		$H='0'.$H;
		}
	$ctime=$H.':'.$M.' '.$m;
	echo "<tr title='".$ip."'><td>".$Examtitle."</td><td>$Close</td><td>".$login."</td><td>".$submittime."</td><td><input type='button' class='btn btn-rounded btn-option2' onclick=\"msg('$title Alert','Exam Display Visible at $ctime.')\" value='Time to Exam' /></td></tr>\n";
	}
	else
	{
	if(in_array($eid,$ei))
	{
	$ecou++;
	echo "<tr title='".$ip."'><td>".$Examtitle."</td><td>$Close</td><td>".$login."</td><td>".$submittime."</td><td><a class='btn btn-rounded btn-primary' style='cursor:pointer' onclick=startexam('".$sno."')>Take Exam</a></form></td></tr>\n";
	$radioid+=1;}
	}
	}
   }
	}
	echo "<tr><td colspan='6'></td></tr>
</table>
	</div>
	";
	
}
if($ecou>0){?><script type="text/javascript">document.getElementById("ccou").innerHTML="&nbsp;<span class='label label-danger'><?php echo $ecou;?></span>";</script><?php }
?>
</div>
                    <div role="tabpanel" class="tab-pane" id="leaderboard">
			<div style="width:100%;height:310px;overflow-x:hidden;" id="leaderb"><center><br>Loading...</center></div>
						</div>
						
						
                    <div role="tabpanel" class="tab-pane" id="weektoppers">
			<div style="width:100%;height:310px;overflow-x:hidden;" id="weekboard"><center><br>Loading...</center></div>
						</div>
						
						
                    <div role="tabpanel" class="tab-pane" id="currentday">
			<div style="width:100%;height:310px;overflow-x:hidden;" id="currentdaycou"><center><br>Loading...</center></div>
						</div>
						

                    <div role="tabpanel" class="tab-pane" id="examwisetoppers">
			<div style="width:100%;height:310px;overflow-x:hidden;" id="todayboard"><center><br>Loading...</center></div>
						</div>


                    <div role="tabpanel" class="tab-pane" id="examprocedure">
			<div style="width:100%;height:310px;overflow-x:hidden;"><center><span style="text-align:justify;"><br><b><u>Procedure of Mocktests:</u></b><br><br><ul><li>Every day 3 exams will be conducted.</li><li>Results and Ranks will be displayed after completion of exam.</li><li>Answers will be displayed on next day.</li></span></center></div>
						</div>
					
                    <div role="tabpanel" class="tab-pane" id="rankingprocedure">
			<div style="width:100%;height:310px;overflow-x:hidden;"><center><span style="text-align:justify;"><br><b><u>Procedure of Ranking:</u></b><br><br><li>Ranks will be calculated on following factors:</li></ul><span><ol><li>Marks.</li><li>Submission Time.</li><li>Number of Page Refreshes for each exam.</li><li>Number of exams written.</li></ol><br></span></center></div>
						</div>
					
						
						</div>
</div>
        </div>
      </div>
    </div>
    <!-- End Files -->

<div class="test"> <div id='mat'></div> <br/>
</div>

    <!-- Start Inbox -->
    
    <!-- Start Inbox -->
    <div class="col-md-12 col-lg-3">
      
<div role="tabpanel" style="border:1px solid #399BFF;padding:0px;margin:0px;">
              <!-- Nav tabs -->
                  <ul class="nav nav-tabs tabcolor5-bg" role="tablist">
                    <li role="presentation" class="active" id='notifitab'><a href="#notifi" aria-controls="notifi" role="tab" data-toggle="tab">Updates
                 <?php 
          mysql_select_db($dbname,$con);
          $date=date("d-m-Y");
          $g=mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE visibility='1' && added_date='$date'")); if($g>0){?><span class="label label-danger"><?php echo $g;?></span><?php } ?></a></li>
                    <li role="presentation"   id='acctab'><a href="#acc" aria-controls="acc" role="tab" data-toggle="tab">Papers By</a></li>
                    <li role="presentation"   id='instrutab'><a href="#instru" aria-controls="instru" role="tab" data-toggle="tab">Instructions</a></li>
                    </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="notifi">
                      <div id="notificationarea" style="visibility:visible;height:160px;border:1px solid #399BFF;overflow-y:scroll;" title='Notifications'>
                      <marquee id="notifications"  bgcolor="#fff" scrolldelay="100" onmouseover="this.setAttribute('scrollamount', 0, 0);" onmouseout="this.setAttribute('scrollamount', 3, 0);" direction="up" scrolldelay="100" scrollamount="3"  behavior="alternate" hspace="10%" direction="up" speed="1" style="height:160px;">
                      <div id='notifypage' title='Notifications'>
                       <?php include("views/user/Notifications.php"); ?>
                       </div>
                        </marquee> 
</div>
                    </div>
                    
                    
                    <div role="tabpanel" class="tab-pane" id="acc"  style="padding:0px;visibility:visible;border:1px solid #399BFF;height:160px;overflow-y:scroll;">
                     <!--acc-->
                     <marquee  bgcolor="#fff" scrolldelay="100" onmouseover="this.setAttribute('scrollamount', 0, 0);" onmouseout="this.setAttribute('scrollamount', 3, 0);" direction="up" scrolldelay="100" scrollamount="3"  behavior="alternate" hspace="10%" direction="up" speed="1" style="height:160px;">
                      <table class="table" width="100%">
                     <?php
                     $que=mysql_query("SELECT * FROM uploaded_papers WHERE visivility='1' && conducted='1'");
                     while($det=mysql_fetch_array($que))
                     {
					echo "<tr><td>".$det['stuid']."</td></tr>";	 
					 }
                     ?>
                     </table></marquee>
                     <br>
                    </div>


                    <div role="tabpanel" class="tab-pane" id="instru"  style="padding:0px;visibility:visible;border:1px solid #399BFF;height:160px;overflow-y:scroll;">
                     
 <marquee  bgcolor="#fff" scrolldelay="100" onmouseover="this.setAttribute('scrollamount', 0, 0);" onmouseout="this.setAttribute('scrollamount', 3, 0);" direction="up" scrolldelay="100" scrollamount="3"  behavior="alternate" hspace="10%" direction="up" speed="1" style="height:160px;">
          <?php include("instructions.php");?></marquee>
                    </div>
                   </div>
                  </div>
      
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
	{
	$('#notifypage').load('views/user/ajax-notice.php');
	},10000);
</script>
  </div>
    <!-- End Inbox -->
 <!-- End Inbox -->
 <div class="col-md-12 col-lg-3">
 
<div role="tabpanel" style="border:1px solid #399BFF;padding:0px;margin:0px;">
                  <ul class="nav nav-tabs tabcolor5-bg" role="tablist">
<li role="presentation" class="active"><a href="#rating" aria-controls="rating" role="tab" data-toggle="tab">Website Rating</a></li>
<li role="presentation"><a href="#cert" aria-controls="cert" role="tab" data-toggle="tab">Certificate</a></li>
                    </ul>

                  <div class="tab-content">

                    <div role="tabpanel" class="tab-pane active" id="rating">
				<center>Loading....</center>
						</div>

                    <div role="tabpanel" class="tab-pane" id="cert">
					<!--<a href="certificate/normal.php" target="_blank"><img src="certificate.jpg" width="270px"></a>-->
						</div>
                  
                    
						</div>
</div>

  </div>  
  

  <!-- End First Row -->





</div>
<!-- END CONTAINER -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 

<!-- Start Footer -->
<div class="row footer">
  <div class="col-md-6 text-left">
  Copyright © 2015 <a href="javascript:void(0)">RGUKT Nuzvid</a> All rights reserved.
  </div>
  <div class="col-md-6 text-right">
    Design and Developed by <a name="views/webteam.php" onclick="load_page(this.name)" style='cursor:pointer;'>Prathap Puppala,N130950</a>
  </div> 
</div>
<!-- End Footer -->


</div>
<!-- End Content -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 

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


</body>
<!-- //////////////////////////////////////////////////////////////////////////// --> 
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="logic/js/user/script.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="js/plugins.js"></script>
<script type="text/javascript" src="js/bootstrap-select/bootstrap-select.js"></script>
<script type="text/javascript" src="js/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.min.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script src="js/kode-alert/main.js"></script>
<script src="js/sweet-alert/sweet-alert.min.js"></script>
<script type="text/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/moment/moment.min.js"></script>
<script type="text/javascript" src="myown/js/fbdialog.min.js"></script>
<link rel="stylesheet" href="myown/css/fbdialog.css" />
 <script src="dist/js/Lobibox.min.js"></script>
  <link rel="stylesheet" href="demo/demo.css"/>
  <link rel="stylesheet" href="dist/css/Lobibox.min.css"/>
  
		<script src="js/flipclock/libs/base.js"></script>
		<script src="js/flipclock/flipclock.js"></script>
		<script src="js/flipclock/faces/counter.js"></script>
<style>

.show-dialog {
padding: 0 8px;
background: #f9f9f9;
border: #666 1px solid;
-webkit-border-radius: 2px;
border-radius: 2px;
-moz-border-radius: 2px;
line-height: 22px;
cursor: pointer;
}
.test {
display: none;
}
</style>
<script>
	var check_session;
function CheckForSession() {

		var str="chklogout=true";
		jQuery.ajax({
				type: "POST",
				url: "chk_session.php",
				data: str,
				cache: false,
				success: function(res){
					if(res == "1") {
					msg("<?php echo $title;?> alert",'Your session has been expired!');
				setTimeout(function(){window.location='index';},3000);
					}
				}
		});
		}
check_session = setInterval(CheckForSession, 5000);

function msg(title,matter)
{
	$("#mat").html(matter);
	            $(".test").fbdialog({
            title: title,
            cancel: "Cancel",
            okay: "Okay",
            okaybutton: true,
            cancelbutton: false,
            buttons: true,
            opacity: 0.5, 
            dialogtop: ""
            }); 
       
       Lobibox.notify('info', {
		            size: 'mini',
                    iconClass:'fa fa-envelope',
                    msg: matter,
                    soundPath:"dist/sounds/",
                    soundExt:".ogg",
                    sound:"sound4",
                });
}
$(document).ready(function(){
/*
	var cur="uinfo";
	var oth="visis";
	setInterval(function(){
	    var tmp=cur;
		cur=oth;
		oth=tmp;
		$("#"+oth+"tab").removeClass("active");
		$("#infotab").removeClass("active");
		$("#"+cur+"tab").addClass("active");
		$("#"+oth).removeClass("tab-pane active");
		$("#info").removeClass("tab-pane active");
		$("#"+oth).addClass("tab-pane");
		$("#info").addClass("tab-pane");
		$("#"+cur).removeClass("tab-pane");
		$("#"+cur).addClass("tab-pane active");

	},5000);
});
*/

</script>
<?php
$qq=mysql_fetch_array(mysql_query("SELECT SUM(value) as vis from visits"));
?>
   <script type="text/javascript">

	 
       $('#rating').load('rating.php');
	$('#leaderb').load('leaderboard.php');
	 $('#weekboard').load('weekboard.php');
	 $('#currentdaycou').load('todayboard.php');
	 $('#todayboard').load('examwiseboard.php');
	 
	
</script>&nbsp;
<script type="text/javascript">
			var clock;

			$(document).ready(function() {

				// Instantiate a counter
				clock = $('.clock').FlipClock(<?php echo $qq['vis'];?>, {
					clockFace: 'Counter'
				});

				// Attach a click event to a button a increment the clock
				$('button').click(function() {
					clock.increment();

					// Or you could decrease the clock
					// clock.decrement();

					// Or set it to a specific value
					// clock.setValue(x);
				});
			});
		</script>
</html>
<?php } ?>
