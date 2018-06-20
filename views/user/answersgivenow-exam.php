<?php

require_once("../../site-settings.php");
if(isloggedin())
{
$stuid=$_SESSION['userid'];

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

$eid="NULL";
if(!filter_has_var(INPUT_POST,"examtitle")){exit;}
else{$examtitle=mysql_real_escape_string(trim(htmlspecialchars($_POST['examtitle'])));}
if(strlen($examtitle)<3){exit;}
if(!filter_has_var(INPUT_POST,"examdate")){exit;}
else{$examdate=mysql_real_escape_string(trim(htmlspecialchars($_POST['examdate'])));}

	$qu=mysql_query("SELECT * FROM examdetails WHERE date='$examdate'");
	if(mysql_num_rows($qu)>3)
	{
	echo "<h3 style='color:red;'>Already 3 exams for given date is added.Please change the date and post it again.</h3>";	
	exit;
	}


$ExamStartt=1001;
$EndExamt=3359;

if(!filter_has_var(INPUT_POST,"type")){exit;}
else{$type=mysql_real_escape_string(trim(htmlspecialchars($_POST['type'])));}
if($type!="a" && $type!="A" && $type!="1"){exit;}
$options=4;
if(!filter_has_var(INPUT_POST,"questions")){exit;}
else{$questions=mysql_real_escape_string(trim(htmlspecialchars($_POST['questions'])));
}
if($questions<2 || $questions==""){exit;}

if(!filter_has_var(INPUT_POST,"realans")){exit;}
else{$realans=mysql_real_escape_string(trim(htmlspecialchars($_POST['realans'])));}
$ccone=3;
$cwone=1;
if($examtitle=="" || strlen($examtitle)<2 || $examdate=="" || $ExamStartt=="" || $EndExamt=="" || strlen($type)!=1 || strlen($options)!=1 || count(explode("~",$realans))!=$questions || $ccone=="")
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
if(1!=1){echo "Exam Already exists with that name";	}
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
if(mysql_query("INSERT INTO examdetails(eid,tkey,title,filename,filetype,date,startandendtimelimit,display,endat,countdown,type,options,questions,ccone,cwone,answersmode,answers,validations,added_by,addedip,displayinprofile)
               VALUES('$eid','$number','$examtitle','$newf','$ext','$examdate','$startandendlimit','$ExamStartt','$EndExamt','$countdown','$type','$options','$questions','$ccone','$cwone','answersgivenow','$realans','1','$stuid','$ip','1')") or die(mysql_error()))		
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
	<?php
	$date=date("d-m-Y");
	$qu=mysql_query("SELECT * FROM examdetails WHERE date='$date'");
	if(mysql_num_rows($qu)>3)
	{
	echo "<h3 style='color:red;'>Today exam limit is over.Please Upload by changing date.</h3>";
	}
	else
	{?>
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
						  exit;
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
                    <input type="text" class="form-control" id='eid' name='eid'  value="NULL" readonly>
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
				  <label class="col-sm-5 control-label form-label">Option Type</label>
				  </td><td>
                  <div class="col-sm-10">
                   <select class="selectpicker" name='type' id='type'><option value="A">A (Capital)</option><option value="a" >a (Small)</option><option value="1" >1 (Numbers)</option>
                   </select>
                     </div>
                </td>
					</tr>
					
					
                	
                <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">No. of Question (< 48)</label>
				  </td><td>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name='questions'  id='ques' value="" onkeyup="shwinp(this.value)"><br>
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
                <?php } ?>
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
var ques=document.getElementById('ques').value;
var type=document.getElementById('type').value;
if (ques==0 || ques==null  || ques==''){alert('Enter Number of Questions');return false;}

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

if(title!=undefined && title!="" && date!="" && date!=null && date[2]=="-" && date[5]=="-" && date.length==10 && start!="" && start!=null && start[2]==":" && start[5]==" " && start.length==8 &&
   end!="" && end!=null && end[2]==":" && end[5]==" " && end.length==8 && type!="" && ques!="" && options!="" && document.getElementById("ans")!=undefined)
{
if(confirm("Are you sure to Create Exam?"))
{
$("#realans").val(realans);
return true;
}
else
{
return false;
}
}

}

function shwinp(fil)
{
var str="<table><tr><td>";
var cur=0;
for(var i=1;i<=fil;i++)
{
cur++;
str=str+"&nbsp;&nbsp;&nbsp;&nbsp;Que "+i+"&nbsp;<input type='text' id='anns"+i+"' maxlength='1' onkeyup=con('"+i+"',this.value) size='3'></td><td>";	
if(cur%4==0){str=str+"<br><br><br></tr><tr><td>";}
}	
var str=str+"<br></td></tr></table>";
$("#ans").html(str);
}

function con(f,va)
{
$("#anns"+f).val(va);	
}

</script>                
<?php
}
?>
