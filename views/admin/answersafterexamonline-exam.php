<?php

require_once("../../site-settings.php");
if(isadminloggedin())
{
if(isset($_POST['submit']) && !empty($_POST['submit']))
{
mysql_select_db($dbname,$con);
function Check()
{
	
	$random = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
	
	$check=mysql_query("SELECT * FROM examdetails WHERE tkey='$random'");
	$count=0;
	while($row = mysql_fetch_array($check))
		{
		$count+=1;
		}
	if ($count!=0)
		{
		Check();
		}
	else
		{
		return $random;
		}
}

$number=Check();




if(!filter_has_var(INPUT_POST,"eid")){exit;}
else{$eid=mysql_real_escape_string(trim(htmlspecialchars($_POST['eid'])));
}

if(!filter_has_var(INPUT_POST,"examtitle")){exit;}
else{$examtitle=mysql_real_escape_string(trim(htmlspecialchars($_POST['examtitle'])));}

if(!filter_has_var(INPUT_POST,"examdate")){exit;}
else{$examdate=mysql_real_escape_string(trim(htmlspecialchars($_POST['examdate'])));}

if(!filter_has_var(INPUT_POST,"start")){exit;}
else{
$ExamStart=htmlspecialchars($_POST['start']);
$Hour=substr($ExamStart,0,2);
$Min=substr($ExamStart,3,2);
$M=substr($ExamStart,6,2);
$Hour+=10;
if ($M=='PM')
	{
	if ($Hour<22)
	{
	$Hour+=12;
	}
	}
$ExamStartt=$Hour.$Min;
}

if(!filter_has_var(INPUT_POST,"end")){exit;}
else{
	$EndExam=htmlspecialchars($_POST['end']);
$Hour=substr($EndExam,0,2);
$Min=substr($EndExam,3,2);
$M=substr($EndExam,6,2);
$Hour+=10;
if ($M=='PM')
	{
	if ($Hour<22)
	{
	$Hour+=12;
	}
	}
$EndExamt=$Hour.$Min;
}

if(!filter_has_var(INPUT_POST,"countdown")){exit;}
else{$countdown=mysql_real_escape_string(trim(htmlspecialchars($_POST['countdown'])));}


if(!filter_has_var(INPUT_POST,"type")){exit;}
else{$type=mysql_real_escape_string(trim(htmlspecialchars($_POST['type'])));}

if(!filter_has_var(INPUT_POST,"options")){exit;}
else{$options=mysql_real_escape_string(trim(htmlspecialchars($_POST['options'])));}

if(!filter_has_var(INPUT_POST,"questions")){exit;}
else{$questions=mysql_real_escape_string(trim(htmlspecialchars($_POST['questions'])));
}

$realans="";

if(!filter_has_var(INPUT_POST,"ccone")){exit;}
else{$ccone=mysql_real_escape_string(trim(htmlspecialchars($_POST['ccone'])));}


if(!filter_has_var(INPUT_POST,"cwone")){exit;}
else{$cwone=mysql_real_escape_string(trim(htmlspecialchars($_POST['cwone'])));}

if($examtitle=="" || strlen($examtitle)<2 || $examdate=="" || $ExamStartt=="" || $EndExamt=="" || strlen($type)!=1 || strlen($options)!=1 || $ccone=="")
{
echo "<script>alert('Please check all details')</script>";
exit;	
}

$filename=$_FILES['file']['name'];
$filesize=$_FILES['file']['size'];
if($filename=="")
{

echo "<script>alert('Please Enter file Name');</script>";	
header("location:../../index");	
exit;
}

$qu=mysql_query("SELECT * FROM examdetails WHERE title='$examtitle'  and visibility='1'");
if(mysql_num_rows($qu)>=1){echo "Exam Already exists with that name";	}
else
{
//exam addition starts here
if(!is_dir("../../".$mainp)){mkdir("../../".$mainp);}
$allowed=array("pdf");
$ext=pathinfo($filename,PATHINFO_EXTENSION);
if(in_array($ext,$allowed))
{
$random = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 5);
$newf=$examtitle."_".$random.".".$ext;
if(move_uploaded_file($_FILES['file']['tmp_name'],"../../".$mainp."/".$newf))
{
	$startandendlimit=1;
mysql_select_db("quiz_exams",$con);
	$script="CREATE TABLE $number 
	(ID varchar(50),
	PRIMARY KEY(ID),
	IP varchar(50),
	options varchar(700),
	marks int(5),
	correct int(5),
	wrong int(5),
	Logintime varchar(50),
	status varchar(1),
	pageloadings int(5) DEFAULT 0,
	Submittime varchar(50))";
	$rest=mysql_query($script);
	if (!$rest)
		{
		echo "Error Occured on Creating Table :: ".$number."<br>Error is ".mysqL_error();
		exit;
		unlink("../../".$mainp."/".$newf);
		}
    else
    {
mysql_select_db($dbname,$con);
if(mysql_query("INSERT INTO examdetails(eid,tkey,title,filename,filetype,date,startandendtimelimit,display,endat,countdown,type,options,questions,ccone,cwone,answersmode,answers,addedip)
               VALUES('$eid','$number','$examtitle','$newf','$ext','$examdate','$startandendlimit','$ExamStartt','$EndExamt','$countdown','$type','$options','$questions','$ccone','$cwone','answersafterexamonline','$realans','$ip')") or die(mysql_error()))		
	{
	echo "<script>alert('Exam Successfully Created');document.write('<center><h1>Redirecting to Mainpage...</h1></center>');window.location='../../index';</script>";
	}	
}	
}
}	
}
}
?>

<center>
					<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" onsubmit="return newexam()" >

                <table  width="100%" style="text-align:justify;" class="table table-bordered table-striped">
                <tbody>
					<tr><th colspan='2'><center>Fill Details to Create Exam</center></th></tr>
					
					<tr>
					<td>
				  <label for="eid" class="col-sm-5 control-label form-label">Exam ID</label>
				  </td><td>
                  <div class="col-sm-10">
					  <?php
					  if($teckzitemode)
					  {
						mysql_select_db($teckzitedb,$con);
				$settings=mysql_query("SELECT * FROM events");
	
		echo "<select class='selectpicker' name='eid' id='eid'><option value=''>Select</option>";
		  while($branch_cat=mysql_fetch_array($settings)){
			 echo "<option value='".$branch_cat['eid']."'>".$branch_cat['branch']."~".$branch_cat['eventname']."</option>"; 
		   }
		   echo "</select>";
					  }
					  else
					  {
						  mysql_select_db($dbname,$con);
						  ?>
                    <input type="text" class="form-control" id='eid' name='eid' value="NULL" readonly>
                    <?php } ?>
                  </div>
                </td>
					</tr>
					
					
					<tr>
					<td>
				  <label for="etitle" class="col-sm-5 control-label form-label">Exam Title</label>
				  </td><td>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id='etitle' name='examtitle'>
                  </div>
                </td>
					</tr>
					
					
                <tr>
					<td>
				  <label for="examdate" class="col-sm-5 control-label form-label">Exam Date</label>
				  </td><td>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='examdate' id="examdate" value="<?php echo date("d-m-Y");?>">
                  </div>
                </td>
					</tr>
					
					
				
                <tr>
					<td>
				  <label for="start" class="col-sm-5 control-label form-label">Time to Login</label>
				  </td><td>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='start'  id='start' value="<?php echo date('h:00 A',mktime(date("H")+3,date("i")+30,0,0,0)); ?>">
                  </div>
                </td>
					</tr>


                <tr>
					<td>
				  <label for="end" class="col-sm-5 control-label form-label">Expire Time</label>
				  </td><td>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='end'  id='end' value="<?php echo date('h:00 A',mktime(date("H")+6,date("i")+30,0,0,0)); ?>">
                  </div>
                </td>
					</tr>

                <tr>
					<td>
				  <label for="countdown" class="col-sm-5 control-label form-label">Countdown</label>
				  </td><td>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='countdown'  id='countdown' value="none">Minutes
                  </div>
                </td>
					</tr>



                <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Option Type</label>
				  </td><td>
                  <div class="col-sm-10">
                   <select class="selectpicker" name='type' id='type'><option value="A">A (Capital)</option><option value="1" >1 (Numbers)</option>
                   </select>
                     </div>
                </td>
					</tr>
					
					
                <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Maximum No. of Options</label>
				  </td><td>
                  <div class="col-sm-10">
                   <select name='options' class="selectpicker" id='options'><option value='3'>3</option><option value='4' selected='selected'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option></select>
                     </div>
                </td>
					</tr>
					
					
                <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">No. of Question (< 48)</label>
				  </td><td>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name='questions'  id='ques' value=""><br>
                     <span id='ans'></span>
                    </div>
                </td>
					</tr>

          <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Credits for Correct one</label>
				  </td><td>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name='ccone'  id='ccone' value="1"><br>
                     <span id='ans'></span>
                    </div>
                </td>
					</tr>

          <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Credits for Wrong one</label>
				  </td><td>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name='cwone'  id='cwone' value="0"><br>
                     <span id='ans'></span>
                    </div>
                </td>
					</tr>
					
					
					
          <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Question paper</label>
				  </td><td>
                  <div class="col-sm-10">
                     <input id="file" name="file" type="file" ><br>
                     <span id='ans'></span>
                    </div>
                </td>
					</tr>
<input type="hidden" id="realans" name="realans">

					<tr><td colspan="2"><center><input type="submit" name="submit" value="Create" class="btn btn-rounded btn-primary"></center></td></tr>
                </tbody>
                </table>               
                </form>
                </center>
<script>
var tit = document.getElementById('etitle');

tit.onkeyup = function(){
    this.value = this.value.toUpperCase();
}
var sub = document.getElementById('esub');

sub.onkeyup = function(){
    this.value = this.value.toUpperCase();
}
function newexam()
{
var eid=document.getElementById('eid').value;
if (eid=="" || eid==null){alert('Enter Exam ID');return false;}
var title=document.getElementById('etitle').value;
if (title=="" || title==null){alert('Enter Title');return false;}
var date=document.getElementById('examdate').value;
if (date=="" || date==null || date[2]!="-" || date[5]!="-" || date.length!=10){alert('Enter Date in Correct Format.\ni.e., dd-mm-yyyy');return false;}
var start=document.getElementById('start').value;
if (start=="" || start==null || start[2]!=":" || start[5]!=" " || start.length!=8){alert('Enter Start Time in Correct Format.\ni.e., hh:mm AA');return false;}
var end=document.getElementById('end').value;
if (end=="" || end==null || end[2]!=":" || end[5]!=" " || end.length!=8){alert('Enter Ending Time in Correct Format.\ni.e., hh:mm AA');return false;}
var ques=document.getElementById('ques').value;
var type=document.getElementById('type').value;
var options=document.getElementById('options').value;
var ccone=document.getElementById('ccone').value;
var cwone=document.getElementById('cwone').value;
if (ques==0 || ques==null || ques==''){alert('Enter Number of Questions.');return false;}

if (ccone=="" || ccone==null || isNaN(ccone)==true){alert('Please Check Correct Credits value');return false;}
if (cwone=="" || cwone==null || isNaN(cwone)==true){alert('Please Check Wrong Credits value');return false;}

var realans="";
var c=1;


if(title!=undefined && title!="" && date!="" && date!=null && date[2]=="-" && date[5]=="-" && date.length==10 && start!="" && start!=null && start[2]==":" && start[5]==" " && start.length==8 &&
   end!="" && end!=null && end[2]==":" && end[5]==" " && end.length==8 && type!="" && ques!="" && options!="" && document.getElementById("ans")!=undefined)
{

if(confirm("Are you sure to Create Exam?"))
{
return true;
}
else
{
return false;
}
}

}


</script>                
<?php
}
?>
