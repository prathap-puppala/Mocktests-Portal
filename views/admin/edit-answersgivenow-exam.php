<?php

require_once("../../site-settings.php");
if(isadminloggedin())
{

if(isset($_POST['submit']) && !empty($_POST['submit']))
{
mysql_select_db($dbname,$con);


if(!filter_has_var(INPUT_POST,"sno")){exit;}
else{$sno=mysql_real_escape_string(trim(htmlspecialchars($_POST['sno'])));
}
mysql_select_db($dbname,$con);

$puppala=mysql_fetch_array(mysql_query("SELECT * FROM examdetails WHERE sno='$sno'"));


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

$number=$puppala['tkey'];



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

if(!filter_has_var(INPUT_POST,"realans")){exit;}
else{$realans=mysql_real_escape_string(trim(htmlspecialchars($_POST['realans'])));}


if(!filter_has_var(INPUT_POST,"ccone")){exit;}
else{$ccone=mysql_real_escape_string(trim(htmlspecialchars($_POST['ccone'])));}


if(!filter_has_var(INPUT_POST,"cwone")){exit;}
else{$cwone=mysql_real_escape_string(trim(htmlspecialchars($_POST['cwone'])));}

if($examtitle=="" || strlen($examtitle)<2 || $examdate=="" || $ExamStartt=="" || $EndExamt=="" || strlen($type)!=1 || strlen($options)!=1 || $ccone=="" || $cwone=="" || (int)$cwone>(int)$ccone)
{
echo "<script>alert('Please check all details')</script>";
exit;	
}
$newf=$puppala['filename'];
$ext=$puppala['filetype'];

if($_FILES['file']['name']!="")
{
$filename=$_FILES['file']['name'];
$filesize=$_FILES['file']['size'];
if(!is_dir("../../".$mainp)){mkdir("../../".$mainp);}
$allowed=array("pdf");
$ext=pathinfo($filename,PATHINFO_EXTENSION);

if(in_array($ext,$allowed))
{
$random = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 5);
$newf=$examtitle."_".$random.".".$ext;
move_uploaded_file($_FILES['file']['tmp_name'],"../../".$mainp."/".$newf);
}
}

if(1==1)
{
//exam addition starts here
if(1==1){
	$startandendlimit=1;
	

if($type!=$puppala['type'] || $options!=$puppala['options'] || $questions!=$puppala['questions'])
{
mysql_select_db("quiz_exams",$con);
mysql_query("TRUNCATE $number") or die(mysql_error());
}	

mysql_select_db($dbname,$con);



if(mysql_query("UPDATE examdetails SET eid='$eid',tkey='$number',title='$examtitle',filename='$newf',countdown='$countdown',filetype='$ext',date='$examdate',answers='$realans',display='$ExamStartt',endat='$EndExamt',type='$type',options='$options',questions='$questions',ccone='$ccone',cwone='$cwone',addedip='$ip' WHERE sno='$sno'") or die(mysql_error()))		
	{
	echo "<script>alert('Exam Successfully Updated');document.write('<center><h1>Redirecting to Mainpage...</h1></center>');window.location='../../index';</script>";
	}	
}	
}
}
if(isset($_GET['sno']))
{
$sno=mysql_real_escape_string(trim(htmlspecialchars(strip_tags($_GET['sno']))));
$prathap=mysql_query("SELECT * FROM examdetails WHERE sno='$sno'  and answersmode='answersgivenow'");
if(mysql_num_rows($prathap)>=1)
{
$puppala=mysql_fetch_array($prathap);

?>

<center>
					<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" onsubmit="return newexam()" >

                <table  width="100%" style="text-align:justify;" class="table table-bordered table-striped">
                <tbody>
					<tr><th colspan='2'><center>Fill Details to Modify Exam</center></th></tr>
					<input type="hidden" name="sno" value="<?php echo $sno;?>">
					<tr>
					<td>
				  <label for="eid" class="col-sm-5 control-label form-label">Exam ID</label>
				  </td><td>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id='eid' name='eid' value="<?php echo $puppala['eid'];?>">
                    
                  </div>
                </td>
					</tr>
					
					
					<tr>
					<td>
				  <label for="etitle" class="col-sm-5 control-label form-label">Exam Title</label>
				  </td><td>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id='etitle' name='examtitle' value="<?php echo $puppala['title'];?>">
                  </div>
                </td>
					</tr>
					
					
                <tr>
					<td>
				  <label for="examdate" class="col-sm-5 control-label form-label">Exam Date</label>
				  </td><td>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='examdate' id="examdate" value="<?php echo $puppala['date'];?>">
                  </div>
                </td>
					</tr>
					
					
				
                <tr>
					<td>
				  <label for="start" class="col-sm-5 control-label form-label">Time to Login</label>
				  </td><td>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='start'  id='start' value="<?php 
    $starttime=$puppala['display'];               
	$H=substr($starttime,0,2);
	$M=substr($starttime,2,2);
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
	echo $H.':'.$M.' '.$m;?>">
                  </div>
                </td>
					</tr>


                <tr>
					<td>
				  <label for="end" class="col-sm-5 control-label form-label">Expire Time</label>
				  </td><td>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='end'  id='end' value="<?php 
    $starttime=$puppala['endat'];               
	$H=substr($starttime,0,2);
	$M=substr($starttime,2,2);
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
	echo $H.':'.$M.' '.$m;?>">
                  </div>
                </td>
					</tr>

                <tr>
					<td>
				  <label for="countdown" class="col-sm-5 control-label form-label">Countdown</label>
				  </td><td>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='countdown'  id='countdown' value="<?php echo $puppala['countdown'];?>">Minutes
                  </div>
                </td>
					</tr>



                <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Option Type</label>
				  </td><td>
                  <div class="col-sm-10">
                   <select class="selectpicker" name='type' id='type'><option value="A" <?php if($puppala['type']=="A"){echo "selected";}?>>A (Capital)</option><option value="1" <?php if($puppala['type']=="1"){echo "selected";}?>>1 (Numbers)</option>
                   </select>
                     </div>
                </td>
					</tr>
					
					
                <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Maximum No. of Options</label>
				  </td><td>
                  <div class="col-sm-10">
                   <select name='options' class="selectpicker" id='options'><option value='3' <?php if($puppala['options']=="3"){echo "selected";}?>>3</option><option value='4' <?php if($puppala['options']=="4"){echo "selected";}?>>4</option><option value='5' <?php if($puppala['options']=="5"){echo "selected";}?>>5</option><option value='6' <?php if($puppala['options']=="6"){echo "selected";}?>>6</option><option value='7' <?php if($puppala['options']=="7"){echo "selected";}?>>7</option><option value='8' <?php if($puppala['options']=="8"){echo "selected";}?>>8</option></select>
                     </div>
                </td>
					</tr>
					
					
                <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">No. of Question (< 48)</label>
				  </td><td>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name='questions'  id='ques'  onkeyup="shwinp(this.value)" value="<?php echo $puppala['questions'];?>"><br>
                     <span id='ans'>
                     <?php
                     $nn=array();
                     $nn=explode("~",$puppala['answers']);
                     echo "<table><tr><td>";
                     $cur=0;
                     for($i=0;$i<count($nn);$i++)
                     {
						$cur++;
						?>
					<input type='text' class='form-control' value=<?php echo $nn[$i];?>  id=anns<?php echo ($i+1);?> maxlength='1' onkeyup=con('<?php echo $i+1;?>',this.value) size='3'>	 
					 <?php
					 if($cur%4==0){echo "<br><br><br></tr><tr><td>";}
					 }
					echo "<br></td></tr></table>";
                     ?>
                     </span>
                   
                    </div>
                </td>
					</tr>

                    
					
          <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Credits for Correct one</label>
				  </td><td>
                  <div class="col-sm-10">               
                    <input type="text" class="form-control" name='ccone'  id='ccone' value="<?php echo $puppala['ccone'];?>"><br>
<br>
                    </div>
                </td>
					</tr>

          <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Credits for Wrong one</label>
				  </td><td>
                  <div class="col-sm-10">
					   <input type="text" class="form-control" name='cwone'  id='cwone' value="<?php echo $puppala['cwone'];?>"><br>
					
					<br>
                    </div>
                </td>
					</tr>

					
					
          <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Question paper</label>
				  </td><td>
                  <div class="col-sm-10">
                     <input id="file" name="file" type="file" ><br>
                     
                    </div>
                </td>
					</tr>
<input type="hidden" id="realans" name="realans" value="<?php echo $puppala['answers'];?>">

					<tr><td colspan="2"><center><input type="submit" name="submit" value="Modify" class="btn btn-rounded btn-primary"></center></td></tr>
                </tbody>
                </table>               
                </form>
                </center>
<script>
	
var tit = document.getElementById('etitle');

tit.onkeyup = function(){
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
var file=document.getElementById('file').value;

if (ques==0 || ques==null  || ques==''){alert('Enter Number of Questions');return false;}

if (ccone=="" || ccone==null || isNaN(ccone)==true){alert('Please Check Correct Credits value');return false;}
if (cwone=="" || cwone==null || isNaN(cwone)==true){alert('Please Check Wrong Credits value');return false;}

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

$("#realans").val(realans);
if(title!=undefined && title!="" && date!="" && date!=null && date[2]=="-" && date[5]=="-" && date.length==10 && start!="" && start!=null && start[2]==":" && start[5]==" " && start.length==8 &&
   end!="" && end!=null && end[2]==":" && end[5]==" " && end.length==8 && type!="" && ques!="" && options!="" && document.getElementById("ans")!=undefined)
{
if(ques!=<?php echo $puppala['questions'];?>){if(!confirm("Changing Number of questions will delete all data.\n\nAre you sure to continue?")){return false;}}
if(type!=<?php echo $puppala['type'];?>){if(!confirm("Changing Options type will delete all data.\n\nAre you sure to continue?")){return false;}}
if(options!=<?php echo $puppala['options'];?>){if(!confirm("Changing Number of Options will delete all data.\n\nAre you sure to continue?")){return false;}}
if(file!=""){if(!confirm("Are you sure to change file?")){return false;}}

return true;
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
}
}
?>
