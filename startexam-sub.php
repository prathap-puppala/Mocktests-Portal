<?php

require_once("site-settings.php");
$isl=(isloggedin())?true:false;

if(!$isl)
{
require_once("views/login.php");
}
else if(isloggedin()){
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
  <link rel="stylesheet" href="dist/css/Lobibox.min.css"/>
  <script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="js/plugins.js"></script>
<script src="js/kode-alert/main.js"></script>
<script type="text/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/moment/moment.min.js"></script>
<script src="dist/js/Lobibox.min.js"></script>
  
 </head>
 <body>
	<?php
if(isset($_SESSION['Exam'])){header("location:startexam.php");}

$id=$_SESSION['userid'];
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
}
mysql_select_db($dbname,$con);

echo "<title>".$title."</title>";

if(isset($_GET['sno']))
{
$date=date("d-m-Y");
$sno=mysql_real_escape_string(trim(htmlspecialchars(strip_tags($_GET['sno']))));
$qwe=mysql_query("SELECT * FROM examdetails WHERE visibility='1' and date='$date' and sno='$sno'");

if(mysql_num_rows($qwe)>=1)
{
if(!$teckzitemode)
{
//normal mode
$date=date("d-m-Y");
mysql_select_db($dbname,$con);
$query=mysql_query("SELECT * from examdetails WHERE visibility='1' and date='$date' and sno='$sno' and eid='NULL'");
if(mysql_num_rows($query)>=1)
{
//main starts here
$row=mysql_fetch_array($query);

	$user=$_SESSION['userid'];
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
	$chec=mysql_query("SELECT * FROM $Num WHERE ID='$user' and status='Y'");
	if(mysql_num_rows($chec)>=1)
	{
	//already submitted
	echo "<script>Lobibox.alert('success',{msg:'You already submitted this exam.'});</script>";
	}
	else
	{
	
	//checking time
	if($Endtime<$ptime)
	{
	echo "<script>Lobibox.alert('error',{msg:'Exam Login TimeUp.'});</script>";
	}
	else if($Starttime>$ptime)
	{
	echo "<script>Lobibox.alert('warning',{msg:'Exam Display is not available now.'});</script>";		
	} 
	else
	{
	//start exam code	
		mysql_select_db('quiz_exams',$con);
	$upd=mysql_query("SELECT * FROM $Num WHERE ID='$user'");
	if($subcount==0 && $submitcount==0 && mysql_num_rows($upd)<1)
	{$ip=$_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
    $res=mysql_query("INSERT INTO ".$Num." (ID,IP,Logintime,status) VALUES ('".$user."','".$ip."','".$time."','N')");
	if (!$res){echo mysql_error();}
    }	
	//main exam display stats here
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if(!isset($_SESSION['Exam']))
	{
	$_SESSION['Exam']=$sno;
    }
	echo "<center><h1>Redirecting to exam.....</h1></center>";
    header("location:startexam.php");
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
	
	
	}
	}
}
}
else
{
//teckzite mode
mysql_select_db($teckzitedb,$con);
$r=mysql_fetch_array(mysql_query("SELECT * FROM $passtable WHERE stuid='".$_SESSION['userid']."'"));
$ei=array();
$ei=explode("~",$r['eventids']);
mysql_select_db($dbname,$con);
$date=date("d-m-Y");
$query=mysql_query("SELECT * from examdetails WHERE visibility='1' and date='$date' and sno='$sno' and  and eid!='NULL'");
if(mysql_num_rows($query)>=1)
{

//main starts here
$row=mysql_fetch_array($query);
if(!in_array($row['eid'],$ei)){exit;}
	$user=$_SESSION['userid'];
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
	$chec=mysql_query("SELECT * FROM $Num WHERE ID='$user' and status='Y'");
	if(mysql_num_rows($chec)>=1)
	{
	//already submitted
	echo "<script>Lobibox.alert('success',{msg:'You already submitted this exam.'});</script>";
	}
	else
	{
	mysql_select_db($dbname,$con);
	//checking time
	if($Endtime<$ptime)
	{
	echo "<script>Lobibox.alert('error',{msg:'Exam Login TimeUp.'});</script>";
	}
	else if($Starttime>$ptime)
	{
	echo "<script>Lobibox.alert('warning',{msg:'Exam Display is not available now.'});</script>";	
	} 
	else
	{
	//start exam code	
	$subcount=0;
	$submitcount=0;
	mysql_select_db($teckzitedb,$con);
	$det=mysql_fetch_array(mysql_query("SELECT * FROM event_registrations WHERE eid='$eid' and ids LIKE '%$user%'"));
	$ids=array();
	$ids=explode("~",$det['ids']);
	mysql_select_db("quiz_exams",$con);
	for($i=0;$i<count($ids);$i++)
	{
	$suid=$ids[$i];
	if($suid==$user){continue;}
	if(mysql_num_rows(mysql_query("SELECT * FROM $Num WHERE ID='$suid' && status='N'"))>=1){$subcount++;break;}
	if(mysql_num_rows(mysql_query("SELECT * FROM $Num WHERE ID='$suid' && status='Y'"))>=1){$submitcount++;break;}
	}
	
	mysql_select_db($dbname,$con);
	if($subcount>0 && in_array($sno,$ei))
	{
	echo "<script>Lobibox.alert('info',{msg:'your Teammate $suid is writing this exam.'});</script>";
	}
	else if($submitcount>0 && in_array($sno,$ei))
	{
	echo "<script>Lobibox.alert('success',{msg:'your Teammate $suid submitted this exam.'});</script>";
	}
	else
	{
	mysql_select_db('quiz_exams',$con);
	$upd=mysql_query("SELECT * FROM $Num WHERE ID='$user'");
	if($subcount==0 && $submitcount==0 && mysql_num_rows($upd)<1)
	{$ip=$_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
    $res=mysql_query("INSERT INTO ".$Num." (ID,IP,Logintime,status) VALUES ('".$user."','".$ip."','".$time."','N')");
	if (!$res){echo mysql_error();}
    }	
	//main exam display stats here
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if(!isset($_SESSION['Exam']))
	{
	$_SESSION['Exam']=$sno;
    }
	echo "<center><h1>Redirecting to exam.....</h1></center>";
    header("location:startexam.php");
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}
	}
	
	

	}
	
}
else
{
echo "Not available";
}	
}
}	
}
?>
</body>
</html>
<?php
}
?>

