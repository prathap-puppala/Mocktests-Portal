<?php

require_once("site-settings.php");
$isl=(isloggedin())?true:false;

if(!$isl)
{
require_once("views/login.php");
}
else if(isadminloggedin()){

$id=$_SESSION['userid'];
$userdet=mysql_fetch_array(mysql_query("SELECT * FROM admin WHERE stuid='$id'"));	
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title;?></title>
  <!-- ========== Css Files ========== -->
  <link href="css/root.css" rel="stylesheet">
  </head>
  <body onload="hideleftnav()">
  <!-- Start Page Loading -->
  <div class="loading"><img src="img/loading.gif" alt="loading-img"></div>
  <!-- End Page Loading -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
  <!-- START TOP -->
  <div id="top" class="clearfix">

    <!-- Start App Logo -->
    <div class="applogo">
      <a href="index" class="logo"><img src='myown/img/logo.png' width='30px'>&nbsp;<?php echo $title;?></a>
    </div>
    <!-- End App Logo -->

    <!-- Start Sidebar Show Hide Button -->
    <a href="#" class="sidebar-open-button"><i class="fa fa-bars"></i></a>
    <a href="#" class="sidebar-open-button-mobile"><i class="fa fa-bars"></i></a>
    <!-- End Sidebar Show Hide Button -->

    <!-- Start Searchbox -->
    <form class="searchform">
      <input type="text" class="searchbox" id="searchbox" placeholder="Search">
      <span class="searchbutton"><i class="fa fa-search"></i></span>
    </form>
    <!-- End Searchbox -->

    <!-- Start Sidepanel Show-Hide Button -->
    <a href="#sidepanel" class="sidepanel-open-button"><i class="fa fa-outdent"></i></a>
    <!-- End Sidepanel Show-Hide Button -->

    <!-- Start Top Right -->
    <ul class="top-right">

    <li class="dropdown link">
      <a href="#" data-toggle="dropdown" class="dropdown-toggle hdbutton">Create <span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-list">
          <li><a style="cursor:pointer;" title="Create New Exam" name="views/admin/newexam.php" onclick="load_page(this.name)"><i class="fa falist fa-paper-plane-o"></i>Exam</a></li>
          <li><a style="cursor:pointer;" title="Create New Exam" name="views/admin/newnotice.php" onclick="load_page(this.name)"><i class="fa falist fa-font"></i>Notification</a></li>
        </ul>
    </li>
    <li class="dropdown link">
      <a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle profilebox"><img src="myown/img/user.png" alt="img"><b><?php echo $userdet['name'];?></b><span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
          <li role="presentation" class="dropdown-header">Profile</li>
          <li><a  title="Settings"  onclick="shwsettings()" style='cursor:pointer;'><i class="fa falist fa-wrench"></i>Settings</a></li>
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
<!-- START SIDEBAR -->
<div class="sidebar clearfix">

<ul class="sidebar-panel nav">
  <li class="sidetitle">MAIN</li>
  <li><a href="index"><span class="icon color5"><i class="fa fa-home"></i></span>Dashboard</a></li>
  
  <li><a href="javascript:void(0)"  name="views/admin/viewexamsinfo.php" onclick="load_page(this.name)" style='cursor:pointer;'><span class="icon color7"><i class="fa fa-database"></i></span>View Exams info</a>
  <li><a href="javascript:void(0)"  name="views/admin/viewsubmitsinfo.php" onclick="load_page(this.name)" style='cursor:pointer;'><span class="icon color7"><i class="fa fa-database"></i></span>View Submits info</a>
 
  <li><a href="javascript:void(0)"><span class="icon color7"><i class="fa fa-copy"></i></span>Create<span class="caret"></span></a>
    <ul>
      <li><a title="Create Exam" name="views/admin/newexam.php" onclick="load_page(this.name)" style='cursor:pointer;'>Exam</a></li>
      <li><a title="Create Notification" name="views/admin/newnotice.php" onclick="load_page(this.name)" style='cursor:pointer;'>Notification</a></li>
    </ul>
  </li>

  <li><a href="javascript:void(0)"><span class="icon color7"><i class="fa fa-indent"></i></span>Edit<span class="caret"></span></a>
    <ul>
      <li><a title="Edit Exam" name="views/admin/editexam.php" onclick="load_page(this.name)" style='cursor:pointer;'>Exam</a></li>
      <li><a title="Edit Notification" name="views/admin/editnotice.php" onclick="load_page(this.name)" style='cursor:pointer;'>Notification</a></li>
    </ul>
  </li> 
  
  
  <li><a href="javascript:void(0)"><span class="icon color7"><i class="fa fa-scissors"></i></span>Delete<span class="caret"></span></a>
    <ul>
      <li><a title="Delete Exam" name="views/admin/deleteexam.php" onclick="load_page(this.name)" style='cursor:pointer;'>Exam</a></li>
      <li><a title="Delete Notification" name="views/admin/deletenotice.php" onclick="load_page(this.name)" style='cursor:pointer;'>Notification</a></li>
    </ul>
  </li> 
  <li><a href="javascript:void(0)"><span class="icon color5"><i class="fa fa-key"></i></span>Result<span class="caret"></span></a>
    <ul>
      <li><a title="View Result" name="views/admin/viewresult.php?mode=answersgivenow" onclick="load_page(this.name)" style='cursor:pointer;'>View Result(Give Now Mode)</a></li>
      <li><a title="View Result" name="views/admin/viewresult.php?mode=answersafterexamonline" onclick="load_page(this.name)" style='cursor:pointer;'>View Result(Online Mode)</a></li>
      <li><a title="View Result" name="views/admin/viewexcelmoderesult.php" onclick="load_page(this.name)" style='cursor:pointer;'>View Result(Excel Mode)</a></li>
      <li><a title="Validate Result Online" name="views/admin/validateresult.php?mode=answersafterexamonline" onclick="load_page(this.name)" style='cursor:pointer;'>Validate Result(Online)</a></li>
      <li><a title="Validate Result Excel" name="views/admin/validateresult.php?mode=answersafterexamexcel" onclick="load_page(this.name)" style='cursor:pointer;'>Validate Result(Excel)</a></li>
      <li><a title="ReValidate Result(Online)" name="views/admin/revalidategivenowresult.php" onclick="load_page(this.name)" style='cursor:pointer;'>Re-Validate Result(Give Now)</a></li>
      <li><a title="ReValidate Result(Online)" name="views/admin/revalidateresult.php?mode=answersafterexamonline" onclick="load_page(this.name)" style='cursor:pointer;'>Re-Validate Result(Online)</a></li>
      <li><a title="ReValidate Result(Online)" name="views/admin/revalidateexcelresult.php" onclick="load_page(this.name)" style='cursor:pointer;'>Re-Validate Result(Excel)</a></li>
      <li><a title="Send Result as Messages" name="views/admin/sendresasmsgs.php" onclick="load_page(this.name)" style='cursor:pointer;'>Send Result as Messages</a></li>
      <li><a title="Set Visibility" name="views/admin/resdisinprofile.php" onclick="load_page(this.name)" style='cursor:pointer;'>Set Results Visibility</a></li>
    </ul>
  </li> 
 
</ul>
</div>
<!-- END SIDEBAR -->
<!-- //////////////////////////////////////////////////////////////////////////// --> 

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTENT -->
<div class="content" id="pag_load">
  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title"><?php echo $title;?> Admin Panel</h1>
      <ol class="breadcrumb">
        <li class="active">Rajiv Gandhi University of Knowledge Technologies,Nuzvid.</li>
    </ol><br>
    <!-- Start Page Header Right Div -->
    <div class="right">
      <div class="btn-group" role="group" aria-label="...">
        <a style="cursor:pointer;" onclick="hideleftnav()" class="btn btn-light">Click here for Navigation Bar</a><br><br>
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

  <!-- Start Top Stats -->
  <div class="col-md-12">
  <ul class="topstats clearfix">
	  
    <li class="arrow"></li>
    <li class="col-xs-6 col-lg-2">
      <span class="title"><i class="fa fa-dot-circle-o"></i>Total Exams</span>
      <h3><?php echo mysql_num_rows(mysql_query("SELECT * FROM examdetails"));?></h3>
      <span class="diff"><b class="color-down"></b> (conducted till now)</span>
    </li>
    <li class="col-xs-6 col-lg-2">
      <span class="title"><i class="fa fa-calendar-o"></i> New Exams</span>
      <h3><?php echo mysql_num_rows(mysql_query("SELECT * FROM examdetails WHERE date='$date'"));?></h3>
      <span class="diff">(Posted Today)</span>
    </li>
    <li class="col-xs-6 col-lg-2">
      <span class="title"><i class="fa fa-shopping-cart"></i> Available Exams</span>
      <h3 class="color-up">
      <?php
       $count=0;
      if($teckzitemode)
      {
		$date=date("d-m-Y");
	$res=mysql_query("SELECT * FROM examdetails WHERE visibility='1' and date='$date' and eid!='NULL'");
     
     while($row=mysql_fetch_array($res))
		{
		$eid=$row['eid'];
		$s=$row['startandendtimelimit'];
	mysql_select_db($teckzitedb,$con);
	if($s=="1" && mysql_num_rows(mysql_query("SELECT * FROM events WHERE eid='$eid'"))>=1)
	{ 	
	
	mysql_select_db($dbname,$con);
	if($row['date']==$date)
	{
	$Starttime=$row['display'];
	$endtime=$row['endat'];
	if($ptime>$Starttime && $ptime<$endtime){$count++;}
}
}
else
{
$count++;
}
		}
			
	  }
	  else
	  {
$date=date("d-m-Y");
      $res=mysql_query("SELECT * FROM examdetails WHERE  date='$date' && eid='NULL'");
     
     while($row=mysql_fetch_array($res))
		{
	if($row['startandendtimelimit']=="1")
	{ 	
	
	if($row['date'])
	{
	$Starttime=$row['display'];
	$endtime=$row['endat'];
	if($ptime>$Starttime && $ptime<$endtime){$count++;}
}
}
else
{
$count++;
}
		}
	}
      echo $count;
      
      ?>
      </h3>
      <span class="diff">(available to write)</span>
    </li>
    <li class="col-xs-6 col-lg-2">
      <span class="title"><i class="fa fa-eye"></i> Visits</span>
      <h3><?php mysql_select_db($dbname,$con); $r=mysql_fetch_array(mysql_query("SELECT SUM(value) AS val from visits"));echo $r['val'];?></h3>
      <span class="diff">(Guest+User+Admin)</span>
    </li>
    <li class="col-xs-6 col-lg-2">
      <span class="title"><i class="fa fa-users"></i>Users</span>
      <h3 class="color-up">
      <?php
      if($teckzitemode)
     {
	mysql_select_db($teckzitedb,$con);
      echo mysql_num_rows(mysql_query("SELECT * FROM $passtable"));	
     }
     else
     {
	 echo mysql_num_rows(mysql_query("SELECT * FROM users")); 
	 }
      ?>
      </h3>
      <span class="diff">(write exams)</span>
    </li>
    <li class="col-xs-6 col-lg-2">
      <span class="title"><i class="fa fa-clock-o"></i> Notifications</span>
      <h3 class="color-down"><?php mysql_select_db($dbname,$con); echo mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE visibility='1'"));?></h3>
      <span class="diff"> (till now)</span>
    </li>
  </ul>
  </div>
  <!-- End Top Stats -->


  <!-- Start First Row -->
  <div class="row">


    <!-- Start Chart Daily -->
        <div class="col-md-12 col-lg-3">
      <div class="panel panel-widget">
        <div class="panel-title">
          Login Stats
          <ul class="panel-tools panel-tools-hover">
            <li><a class="icon"><i class="fa fa-refresh"></i></a></li>
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
            <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>
        <div class="panel-body">

          <ul class="basic-list">
            <li>Guest Logins<span class="right label label-default"><?php mysql_select_db($dbname,$con); $q=mysql_fetch_array(mysql_query("SELECT * FROM visits WHERE type='Guest'"));echo $q['value']?></span></li>
            <li>User Logins<span class="right label label-danger"><?php $q=mysql_fetch_array(mysql_query("SELECT * FROM visits WHERE type='User'"));echo $q['value']?></span></li>
            <li>Admin Logins<span class="right label label-success"><?php $q=mysql_fetch_array(mysql_query("SELECT * FROM visits WHERE type='Admin'"));echo $q['value']?></span></li>
          </ul>

        </div>
      </div>
      
      <div class="panel panel-widget">
        <div class="panel-title">
          SITE SETTINGS
          <ul class="panel-tools panel-tools-hover">
            <li><a class="icon"><i class="fa fa-refresh"></i></a></li>
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
            <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>
        <div class="panel-body">

          <ul class="basic-list">
		<?php 
	  $g=mysql_query("SELECT * FROM site_settings");
		while($w=mysql_fetch_array($g))
		{
		echo "<li>".ucfirst($w['field'])."<span class='right label label-default'>".ucfirst($w['value'])."</span></li>";	
		}
		?>
          </ul>

        </div>
      </div>
    </div>

    <!-- End Chart Daily -->


    <!-- Start Files -->
    <div class="col-md-12 col-lg-6">
      <div class="panel panel-widget" style="height:450px;">
        <div class="panel-title">
          Ongoing Exams <?php if($count>0){ echo "<span class='label label-danger'>$count</span>";}?>
          <ul class="panel-tools">
            <li><a class="icon"><i class="fa fa-refresh"></i></a></li>
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>
        <div class="panel-body table-responsive">

          <table class="table table-dic table-hover ">
            <tbody>
			<?php	
		
       $count=0;
      if($teckzitemode)
      {
		$date=date("d-m-Y");
	$res=mysql_query("SELECT * FROM examdetails WHERE visibility='1' and date='$date' and eid!='NULL'");
     
     while($row=mysql_fetch_array($res))
		{
		$eid=$row['eid'];
		$tab=$row['tkey'];
		$star=$row['startandendtimelimit'];
	mysql_select_db($teckzitedb,$con);
	if($star=="1" && mysql_num_rows(mysql_query("SELECT * FROM events WHERE eid='$eid'"))>=1)
	{ 	
	
	mysql_select_db($dbname,$con);
	if($row['date']==$date)
	{
	$Starttime=$row['display'];
	$endtime=$row['endat'];
	if($ptime>$Starttime && $ptime<$endtime){
				$tab=$row['tkey'];

		?>
		
		       <tr>
                <td><i class="fa fa-edit"></i><?php echo $row['title'];?></td>
                <td><?php mysql_select_db("quiz_exams",$con); echo mysql_num_rows(mysql_query("SELECT * FROM $tab"))." Logins";?></td>
                <td><?php mysql_select_db("quiz_exams",$con); echo mysql_num_rows(mysql_query("SELECT * FROM $tab WHERE status='Y'"))." Submits";?></td>
               <!-- <td class="text-r"><?php // echo $starttime." - ".$endtime; ?></td>-->
              </tr>
     
     <?php
		}
}
}
else
{
	
			$tab=$row['tkey'];

?>
       <tr>
                <td><i class="fa fa-edit"></i><?php echo $row['title'];?></td>
                <td><?php mysql_select_db("quiz_exams",$con); echo mysql_num_rows(mysql_query("SELECT * FROM $tab"))." Logins";?></td>
                <td><?php mysql_select_db("quiz_exams",$con); echo mysql_num_rows(mysql_query("SELECT * FROM $tab WHERE status='Y'"))." Submits";?></td>
               <!-- <td class="text-r"><?php // echo $starttime." - ".$endtime; ?></td>-->
              </tr>
     
     <?php
}
		}
			
	  }
	  else
	  {$date=date("d-m-Y");
      $res=mysql_query("SELECT * FROM examdetails WHERE visibility='1' and date='$date' and eid='NULL' ORDER BY sno DESC");
     
     while($row=mysql_fetch_array($res))
		{
	if($row['startandendtimelimit']=="1")
	{ 	
	$tab=$row['tkey'];
	if($row['date'])
	{
	$Starttime=$row['display'];
	$endtime=$row['endat'];
	if($ptime>$Starttime && $ptime<$endtime){
				$tab=$row['tkey'];

		?>
		       <tr>
                <td><i class="fa fa-edit"></i><?php echo $row['title'];?></td>
                <td><?php mysql_select_db("quiz_exams",$con); echo mysql_num_rows(mysql_query("SELECT * FROM $tab"))." Logins";?></td>
                <td><?php mysql_select_db("quiz_exams",$con); echo mysql_num_rows(mysql_query("SELECT * FROM $tab WHERE status='Y'"))." Submits";?></td>
               <!-- <td class="text-r"><?php // echo $starttime." - ".$endtime; ?></td>-->
              </tr>
     
     <?php }
}
}
else
{

mysql_select_db($dbname,$con);
	$tab=$row['tkey'];
	?>
	       <tr>
                <td><i class="fa fa-edit"></i><?php echo $row['title'];?></td>
                <td><?php mysql_select_db("quiz_exams",$con); echo mysql_num_rows(mysql_query("SELECT * FROM $tab"))." Logins";?></td>
                <td><?php mysql_select_db("quiz_exams",$con); echo mysql_num_rows(mysql_query("SELECT * FROM $tab WHERE status='Y'"))." Submits";?></td>
               <!-- <td class="text-r"><?php // echo $starttime." - ".$endtime; ?></td>-->
              </tr>
     
     <?php
}
		}
	}
	
	mysql_select_db($dbname,$con);
      ?>
          </tbody>
          </table>          

        </div>
      </div>
    </div>
    <!-- End Files -->


    <!-- Start Inbox -->
    <div class="col-md-12 col-lg-3">
      <div class="panel panel-widget">
        <div class="panel-title">
          Inbox <?php $g=mysql_num_rows(mysql_query("SELECT * FROM messages WHERE replysend='0' && sendertype='student'")); if($g>0){?><span class="label label-danger"><?php echo $g;?></span><?php } ?>
          <ul class="panel-tools">
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
            <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>
        <div class="panel-body">

        <ul class="mailbox-inbox">
<?php

$g=mysql_query("SELECT * FROM messages WHERE replysend='0' && sendertype='student' LIMIT 5");
while($w=mysql_fetch_array($g))
{
	?>
	
	    <li>
              <a href="javascript:void(0)" name="views/admin/viewmsg.php?sno=<?php echo $w['sno'];?>" onclick="load_page(this.name)" style='cursor:pointer;' class="item clearfix">
                <img src="myown/img/user.png" alt="img" class="img">
                <span class="from"><?php echo $w['sender'];?></span>
                <?php echo $w['matter'];?>
                <span class="date"><?php echo $w['date'];?></span>
              </a>
            </li>

	<?php } ?>
        
        </ul>

        </div>
      </div>
    </div>
    <!-- End Inbox -->

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


<!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START SIDEPANEL -->
<div role="tabpanel" class="sidepanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#today" aria-controls="today" role="tab" data-toggle="tab">Instructions</a></li>
    <li role="presentation"><a href="#tasks" aria-controls="tasks" role="tab" data-toggle="tab">Settings</a></li>
    <li role="presentation"><a href="#chat" aria-controls="chat" role="tab" data-toggle="tab">Users</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">

    <!-- Start Today -->
    <div role="tabpanel" class="tab-pane active" id="today">

    </div>
    <!-- End Today -->

    <!-- Start Tasks -->
    <div role="tabpanel" class="tab-pane" id="tasks">

      <div class="sidepanel-m-title">
        Site Settings
        <span class="left-icon"><a href="#"><i class="fa fa-pencil"></i></a></span>
        <span class="right-icon"><a href="#"><i class="fa fa-trash"></i></a></span>
      </div>

      <div class="gn-title">TODAY</div>

      <ul class="todo-list">
		 <?php
		 $f=mysql_query("SELECT * FROM site_settings");
		 $h=0;
		 while($r=mysql_fetch_array($f))
		 {
		$h++;
		$n='yes';
		if($r['value']=='yes'){$n='no';}
		 ?>
        <li class="checkbox checkbox-primary">
          <input id="checkboxside<?php echo $h;?>" type="checkbox" onclick='changeset("<?php echo $r['field'];?>","<?php echo $n;?>")' <?php if($r['value']=='yes'){echo "checked";}?>><label for="checkboxside<?php echo $h;?>"><?php echo $r['field'];?></label>
        </li>
        <?php } ?>
      </ul>

    </div>    
    <!-- End Tasks -->

    <!-- Start Chat -->
    <div role="tabpanel" class="tab-pane" id="chat">

      <div class="sidepanel-m-title">
        <?php echo $title;?> Users
        <span class="left-icon"><a href="#"><i class="fa fa-pencil"></i></a></span>
        <span class="right-icon"><a href="#"><i class="fa fa-trash"></i></a></span>
      </div>
      <div class="gn-title">TOTAL USERS (
      <?php
      if(!$teckzitemode){
		  $q=mysql_query("SELECT * FROM users");
           }
           else
           {
		  mysql_select_db($teckzitedb,$con);
		  $q=mysql_query("SELECT * FROM users");
		  }
		mysql_select_db($dbname,$con);
	echo mysql_num_rows($q);
      ?>
      )</div>
    <div id="aftrser" width="100%"></div>
<form class="search" onsubmit="shwuser()">
        <input type="text" class="form-control" id="uid" placeholder="Search a User...">
      </form>
    

      </div>
    <!-- End Chat -->

  </div>

</div>
<!-- END SIDEPANEL -->
<!-- //////////////////////////////////////////////////////////////////////////// --> 
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="logic/js/admin/prathap.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="js/plugins.js"></script>
<script type="text/javascript" src="js/bootstrap-select/bootstrap-select.js"></script>
<script type="text/javascript" src="js/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.min.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script src="js/sweet-alert/sweet-alert.min.js"></script>
<script src="js/kode-alert/main.js"></script>
<script type="text/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/moment/moment.min.js"></script>

</body>
</html>
<?php } ?>
