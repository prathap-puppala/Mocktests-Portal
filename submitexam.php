<?php

require_once("site-settings.php");
$isl=(isloggedin())?true:false;
if(!$isl)
{
echo "Please Login";
}
else if(isloggedin()){
if(isset($_SESSION['Exam']))
{
if(isset($_POST['sno']) && !empty($_POST['sno']) && isset($_POST['opt']) && !empty($_POST['opt']))
{

$sno=mysql_real_escape_string(trim(htmlspecialchars(strip_tags($_SESSION['Exam']))));
$opt=mysql_real_escape_string(trim(strip_tags($_POST['opt'])));

$puppala=mysql_fetch_array(mysql_query("SELECT * FROM examdetails WHERE visibility='1' and sno='$sno'"));

if($sno!=$_SESSION['Exam']){echo "Invalid Exam";exit;}
$opte=explode("~",$opt);
if(count($opte)!=$puppala['questions']){echo "Number of questions didn't match";exit;}

//getting event ids
$id=$_SESSION['userid'];
$eveids="";
if($teckzitemode)
{
mysql_select_db($teckzitedb,$con);
$userdet=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$id'"));	
$eveids=$userdet['eventids'];
}
mysql_select_db($dbname,$con);

if($teckzitemode)
{
//teckzite mode
mysql_select_db($teckzitedb,$con);
$r=mysql_fetch_array(mysql_query("SELECT * FROM $passtable WHERE stuid='".$_SESSION['userid']."'"));
$ei=array();
$ei=explode("~",$r['eventids']);
mysql_select_db($dbname,$con);
$query=mysql_query("SELECT * from examdetails WHERE visibility='1' and sno='$sno' and eid!='NULL'");

if(mysql_num_rows($query)>=1)
{
//main starts here
$row=mysql_fetch_array($query);
if(!in_array($row['eid'],$ei)){echo "Not Registered";exit;}
	$user=$_SESSION['userid'];
    $Num=$row['tkey'];
	$Examtitle=$row['title'];
	$date=$row['date'];
	$Starttime=$row['display'];
	$Endtime=$row['endat'];
	$Hw=substr($Endtime,0,2);
	$Mw=substr($Endtime,2,2);
	if(((int)$Hw+1)<=34){$Endtime=((int)$Hw+1).$Mw;}
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
	echo "You already submitted this exam.";
	}
	else
	{
	//checking time
	if($Endtime<$ptime)
	{
	echo "Exam Login TimeUp.";
	}
	else if($Starttime>$ptime)
	{
	echo "Exam Display is not available now.";	
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
	echo "your Teammate $suid is writing this exam.";
	}
	else if($submitcount>0 && in_array($sno,$ei))
	{
	echo "your Teammate $suid submitted this exam.";
	}
	else
	{
	mysql_select_db('quiz_exams',$con);
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if($row['answersmode']=="answersafterexamonline")
	{
	if(mysql_query("UPDATE $Num SET options='$opt',Submittime='$time',status='Y' WHERE ID='$user'"))
	{
	unset($_SESSION['Exam']);
	echo "prathap";
	}
	}
	else if($row['answersmode']=="answersgivenow")
	{
	$userans=array();
    $userans=explode("~",$opt);
    $marks=0;
    $correct=0;
    $wrong=0;
	$realans=array();
	$realans=explode("~",$row['answers']);
	for($i=0;$i<$Questions;$i++)
    {
    if($userans[$i]=="prathap"){$marks=$marks;}
    else if($userans[$i]!=$realans[$i]){$wrong++;$marks=$marks-(int)$row['cwone'];}
    else if($userans[$i]==$realans[$i]){$marks=$marks+(int)$row['ccone'];$correct++;}	
    }

	if(mysql_query("UPDATE $Num SET options='$opt',marks='$marks',correct='$correct',wrong='$wrong',Submittime='$time',status='Y' WHERE ID='$user'"))
	{
	unset($_SESSION['Exam']);
	echo "prathap";
	}
	}
	
	else if($row['answersmode']=="answersafterexamexcel")
	{
	$opte=explode("~",$opt);
	for ($i=1;$i<=$Questions;$i++)
	{
	$Question='Q'.$i;
	$Ans=($opte[$i-1]=="prathap")?"":$opte[$i-1];
	if($Ans==""){continue;}
	$result=mysql_query("UPDATE $Num SET $Question='$Ans' WHERE ID='$user'");
	}
    $result=mysql_query("UPDATE $Num SET Submittime='$time' WHERE ID='$user'");
    $result=mysql_query("UPDATE $Num SET status='Y' WHERE ID='$user'");
    unset($_SESSION['Exam']);
    echo "prathap";
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}
}
}
}

}
else
{
//normal mode
mysql_select_db($dbname,$con);
$query=mysql_query("SELECT * from examdetails WHERE visibility='1' and sno='$sno' and eid='NULL'");
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
	$Hw=substr($Endtime,0,2);
	$Mw=substr($Endtime,2,2);
	if(((int)$Hw+1)<=34){$Endtime=((int)$Hw+1).$Mw;}
	$Type=$row['type'];
	$Options=$row['options'];	
	$Questions=$row['questions'];
	$login="";
	$eid=$row['eid'];
	$ip="";
	$submit="";
	$submittime="";
	
mysql_query("UPDATE users SET examswritten=examswritten+1 WHERE stuid='$user'");
	mysql_select_db("quiz_exams",$con);
	$chec=mysql_query("SELECT * FROM $Num WHERE ID='$user' and status='Y'");
	if(mysql_num_rows($chec)>=1)
	{
	//already submitted
	echo "You already submitted this exam.";
	}
	else
	{
	
	//checking time
	if($Endtime<$ptime)
	{
	echo "Exam Login TimeUp.";
	}
	else if($Starttime>$ptime)
	{
	echo "Exam Display is not available now.";		
	} 
	else
	{
	//start exam code	
		mysql_select_db($dbname,$con);
	
	//main exam submit stats here
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
	if($row['answersmode']=="answersafterexamonline")
	{
	mysql_select_db('quiz_exams',$con);
	if(mysql_query("UPDATE $Num SET options='$opt',Submittime='$time',status='Y' WHERE ID='$user'"))
	{
	unset($_SESSION['Exam']);
	echo "prathap";
	}
	}
	else if($row['answersmode']=="answersgivenow")
	{
	$userans=array();
    $userans=explode("~",$opt);
    $marks=0;
    $correct=0;
    $wrong=0;
	$realans=array();
	$realans=explode("~",$row['answers']);
	for($i=0;$i<$Questions;$i++)
    {
    if($userans[$i]=="prathap"){$marks=$marks;}
    else if($userans[$i]!=$realans[$i]){$wrong++;$marks=$marks-(int)$row['cwone'];}
    else if($userans[$i]==$realans[$i]){$marks=$marks+(int)$row['ccone'];$correct++;}	
    }
    mysql_select_db('quiz_exams',$con);
	if(mysql_query("UPDATE $Num SET options='$opt',marks='$marks',correct='$correct',wrong='$wrong',Submittime='$time',status='Y' WHERE ID='$user'"))
	{
	unset($_SESSION['Exam']);
	echo "prathap";
	}
	}
	
	else if($row['answersmode']=="answersafterexamexcel")
	{
	for ($i=1;$i<=$Questions;$i++)
	{
	mysql_select_db('quiz_exams',$con);	
	$Question='Q'.$i;
	$Ans=($opte[$i-1]=="prathap")?"":$opte[$i-1];
	if($Ans==""){continue;}
	$result=mysql_query("UPDATE $Num SET $Question='$Ans' WHERE ID='$user'");
	}
    $result=mysql_query("UPDATE $Num SET Submittime='$time' WHERE ID='$user'");
    $result=mysql_query("UPDATE $Num SET status='Y' WHERE ID='$user'");
    unset($_SESSION['Exam']);
    echo "prathap";
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
	
	
	}
	}
}
}

}
else
{
echo "Error in Passing Answers";
}
}
else
{
echo "Error in Exam Session variable";	
}
}
?>
