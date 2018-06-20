<?php

if($_SERVER['QUERY_STRING']!=""){exit;}

require_once("site-settings.php");
$isl=(isloggedin())?true:false;
if(!$isl)
{
require_once("views/login.php");
}
else if(isloggedin()){
$id=$_SESSION['userid'];
if($teckzitemode)
{
mysql_select_db($teckzitedb,$con);
$userdet=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$id'"));	
$name=$userdet['stuname'];
}
else
{
$userdet=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$id'"));	
$name=$userdet['name'];
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
  <link rel="icon" href="myown/img/user.png">
  <link href="css/root.css" rel="stylesheet">
  <link rel="stylesheet" href="dist/css/Lobibox.min.css"/>
  <script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="logic/js/user/script.js"></script>
  <script src="js/bootstrap/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/plugins.js"></script>
  <script src="js/kode-alert/main.js"></script> 
  <script type="text/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/moment/moment.min.js"></script>
  <script src="dist/js/Lobibox.min.js"></script>
  <script src="myown/js/countdown.js"></script>
  <script src="js/sweet-alert/sweet-alert.min.js"></script>
<link rel="stylesheet" href="myown/css/fbdialog.css" />
<script type="text/javascript" src="myown/js/fbdialog.min.js"></script>
  <noscript><style>html:before{content:"Javascript is disabled.";font-size:25px;padding:40%;font-family:Times New Roman;text-align:center;color:red;}html:after{content:"Please contact admin or enable Javascript.";font-size:25px;padding:34%;font-family:Times New Roman;text-align:center;color:green;}body{display:none;}</style></noscript>
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

function setCookie(cname, cvalue) {
    var d = new Date();
    var exdays=3;
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
} 


function deleteCookie(cname) {
    var d = new Date();
    var exdays=3;
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=; " + expires;
} 

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}</script>
 </head>
 <body onload="hideleftnav()" style="background:#fff;">
	
<?php
if(isset($_SESSION['Exam']))
{
	
if(count($_COOKIE)>0){}else{echo "<div id=\"alerttop\" class=\"kode-alert kode-alert-icon kode-alert-click alert6 kode-alert-top\"><i class=\"fa fa-bullhorn\"></i>Please Enable Cookies for better functioning <a href=\"#\">Click anywhere to close</a></div><script> $(\"#alerttop\").fadeToggle(350);</script>";;}

$sno=mysql_real_escape_string(trim(htmlspecialchars(strip_tags($_SESSION['Exam']))));
$puppala=mysql_fetch_array(mysql_query("SELECT * FROM examdetails WHERE visibility='1' and sno='$sno'"));
if($ptime<$puppala['display'])
{
    echo "<script>Lobibox.alert('warning',{msg:'Exam Display is not available now.'});</script>";			
}
else if($ptime>$puppala['endat'])
{
	echo "<script>Lobibox.alert('error',{msg:'Exam Login TimeUp.'});</script>";
}
else
{
$tab=$puppala['tkey'];
mysql_select_db("quiz_exams",$con);
mysql_query("UPDATE $tab SET pageloadings=pageloadings+1 WHERE ID='".$_SESSION['userid']."'");
mysql_select_db($dbname,$con);
?>
<script> Lobibox.window({
                    title: 'Instructions',
                    width:'500px',
                    content: [
                       "<table width='100%' class='table'><tr><td>You can <mark>deselect</mark> your option using <input type='button' style='border:1px;background-color:maroon;color:yellow;cursor:pointer;' value='X'> icon <i><small>(This option will be displayed only after selecting an option and displayed to the right of Question)</small></i></td></tr><tr><td>If <mark>time</mark>(<span class='label label-info'>not countdown</span>) stops running,it means your  <span class='label label-danger'>connection to server lost</span>.Please fix it and then continue to submit.</td></tr><tr><td>Exam will be <mark>automatically submitted</mark> if time is over.</td></tr><tr><td>All your answers will be saved in <mark>cookies</mark>.So that if any problem persists,you can continue your exam from where you have left.</td></tr><tr><td>You can check <mark>answered</mark> and <mark>not answered</mark> questions in right side of the page.</td></tr><tr><td>Please Check <mark>Submit Status</mark> after Completion of exam.</td></tr><tr><td>If you get blank message while submitting your exam,Please <mark>Login</mark> again.</td></tr><tr><td>If you are not satisfied with your result,you can <mark>Re-validate</mark> your result.(<i><small>This option will be displayed only if admin set the option to be displayed.</small></i>)</td></tr><tr><td>Close this box by pressing <span class='label label-info'>ESC</span> Key.</td></tr></table>"
                       ].join("")
                });</script>
<?php 
if($puppala['cwone']>0){ echo "<script>Lobibox.alert('warning',{msg:'This exam has Negative marking.Please be careful with options.'});</script>";	}
?>
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



    <!-- Start Top Menu -->
    <center>
    <ul class="topmenu">
	<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
	<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
	<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
 <li><a href="javascript:void(0);" style='cursor:pointer;font-size:23px;font-family:Times New Roman;'><?php echo $puppala['title'];?></a></li>
         </ul>
     </center>
     
    <a href="javascript:void(0)" class="sidepanel-open-button"><i class="fa fa-outdent"></i></a>
    <ul class="top-right">

    <li class="dropdown link">
      <a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle profilebox"><img src="myown/img/user.png" alt="img"><b><?php echo $name; ?></b><span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
          <li role="presentation" class="dropdown-header">Profile</li>
          <li><a title="Logout" href="views/logout.php"><i class="fa falist fa-power-off"></i> Logout</a></li>
        </ul>
    </li>

    </ul>
    <!-- End Top Right -->
  </div>
  <!-- END TOP -->
  <div class="content">
    <!-- Start Page Header -->
  <div class="page-header" style="height:50px;padding-top:5px;border-bottom:1px solid #399BFF;">
	  <table width="100%">
	<tr>
     <td>Exam Title : &nbsp;<span style="font-weight:bold;font-size:15px;color:red;text-align:left;"><?php echo $puppala['title'];?></span></td>
     <td>Date : &nbsp;<span style="font-weight:bold;font-size:15px;color:red;text-align:left;"><?php echo $date;?></span></td>
	 <td>Time : <span id="clock" style="font-weight:bold;font-size:15px;color:red;text-align:left;"><?php include("Time.php");?></span>
      <script type="text/javascript">
var auto_refresh = setInterval(
function ()
	{
	$('#clock').load('Time.php');
	},1000);
</script>
</td>
<td>Starts at : &nbsp;<span style="font-weight:bold;font-size:15px;color:red;text-align:left;"><?php  $Starttime=$puppala['display'];
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
	echo $H.':'.$M.' '.$m;
	
	?></span></td>
<td>End at : &nbsp;<span style="font-weight:bold;font-size:15px;color:red;text-align:left;"><?php  $Endtime=$puppala['endat'];
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
	echo $H.':'.$M.' '.$m;
	
	if($puppala['countdown']=="none"){
	$H=substr($Endtime,0,2);
	$M=substr($Endtime,2,2);
    $hr=date("H",(mktime(date("H")+3,0)));
	$mn=date("i",(mktime(date("i")+30)));
	$H-=10;
	$remain=(($H*3600)+($M*60))-(($hr*3600)+(($mn+30)*60));
    }else{$remain=$puppala['countdown']*60;}
	?></span></td>
<td>
<script type="application/javascript">
var timer=<?php echo $remain;?>	
var curti=<?php echo $remain;?>;

<?php
if($puppala['countdown']!="none")
{
?>

if(getCookie("timer<?php echo $sno;?>")=="")
{
setCookie("timer<?php echo $sno;?>","<?php echo $remain;?>");
}
else
{
timer=getCookie("timer<?php echo $sno;?>");	
curti=timer;
}

if(curti<1 || timer<1){Lobibox.alert('error',{msg:'Exam Login TimeUp.'});setTimeout(function(){window.location='views/examsessionend';},3000);}
setInterval(function(){curti=curti-1;if(curti==0){submitexam("automatic");}var newt=getCookie("timer<?php echo $sno;?>")-1;setCookie("timer<?php echo $sno;?>",newt);},1000);

<?php	
}
?>

var myCountdown2 = new Countdown({
									time: timer, 
									width:150, 
									height:40, 
									rangeHi:"<?php if($remain>=3600){echo "hour";}else{echo "minute";}?>"	// <- no comma on last item!
									});
									
									
</script>
</td> 
</tr></table>
      </div>
    </div>
    <!-- End Page Header Right Div -->
</div>
  <!-- End Page Header -->
  <center>
<table width="100%" style="margin:0px;padding:0px;margin-top:-20px;background:#fff;">
<tr>
<td width="80%">
<iframe src="data:application/pdf;base64,<?php echo dataurl($mainp."/".$puppala['filename']);?>" width="100%" height="450px;" frameborder="0" margin="0px" padding="0px"></iframe>
</td>
<td width="20%" style="padding:0px;margin:0px;">
	<!--start of notices and instructions-->
	  <div role="tabpanel" style="border:1px solid #399BFF;padding:0px;margin:0px;">
              <!-- Nav tabs -->
                  <ul class="nav nav-tabs tabcolor5-bg" role="tablist">
                    <li role="presentation" id='notifitab'><a href="#notifi" aria-controls="notifi" role="tab" data-toggle="tab">Notifications
                 <?php 
          mysql_select_db($dbname,$con);
          $g=mysql_num_rows(mysql_query("SELECT * FROM notifications WHERE visibility='1' && added_date='$date'")); if($g>0){?><span class="label label-danger"><?php echo $g;?></span><?php } ?></a></li>
                    <li role="presentation"  class="active" id='instrutab'><a href="#instru" aria-controls="instru" role="tab" data-toggle="tab">Instructions</a></li>
                    </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="notifi">
                      <div id="notificationarea" style="visibility:visible;border:1px solid #399BFF;overflow-y:scroll;" title='Notifications'>
                      <marquee id="notifications"  bgcolor="#fff" scrolldelay="100" onmouseover="this.setAttribute('scrollamount', 0, 0);" onmouseout="this.setAttribute('scrollamount', 3, 0);" direction="up" scrolldelay="100" scrollamount="3"  behavior="alternate" hspace="10%" direction="up" speed="1" style="height:85px;">
                      <div id='notifypage' title='Notifications'>
                       <?php include("views/user/Notifications.php"); ?>
                       </div>
                        </marquee> 
</div>
                    </div>
                    <div role="tabpanel" class="tab-pane active" id="instru"  style="padding:0px;visibility:visible;border:1px solid #399BFF;height:100px;overflow-y:scroll;">
                     
 <marquee  bgcolor="#fff" scrolldelay="100" onmouseover="this.setAttribute('scrollamount', 0, 0);" onmouseout="this.setAttribute('scrollamount', 3, 0);" direction="up" scrolldelay="100" scrollamount="3"  behavior="alternate" hspace="10%" direction="up" speed="1" style="height:85px;">
        <?php include("instructions.php");?>
        </marquee>
                    </div>
                   </div>
                  </div>
                  <!--end of notices and instructions-->
                  <!--start of options view-->
					  <div role="tabpanel" style="z-index:99999;border:1px solid #399BFF;padding:0px;margin:0px;">
              <!-- Nav tabs -->
                  <ul class="nav nav-tabs tabcolor5-bg" role="tablist">
                    <li role="presentation"  class="active"><a href="#allques" aria-controls="allques" role="tab" data-toggle="tab">All</a></li>
                  <li role="presentation"><a href="#answeredques" aria-controls="answeredques" role="tab" data-toggle="tab">Answered</a></li>
                  <li role="presentation"><a href="#notansweredques" aria-controls="notansweredques" role="tab" data-toggle="tab">Not Answered</a></li>
                    </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="allques">
           <?php
           $margin="-140px";
           if($puppala['questions']==1 || $puppala['questions']==2){$margin="-40px";}
           if($puppala['questions']==3 || $puppala['questions']==4){$margin="-40px";}
           if($puppala['questions']>=5 && $puppala['questions']<10){$margin="-90px";}
           if($puppala['questions']==10 || $puppala['questions']==9){$margin="-130px";}
           if($puppala['questions']>=13){$margin="-180px";}
           if($puppala['questions']>=17){$margin="-230px";}
           if($puppala['questions']>=21){$margin="-270px";}
           if($puppala['questions']>=25 && $puppala['questions']<=28){$margin="-320px";}
           if($puppala['questions']>=29 && $puppala['questions']<=32){$margin="-360px";}
           if($puppala['questions']>=33 && $puppala['questions']<=36){$margin="-410px";}
           if($puppala['questions']>=37 && $puppala['questions']<=40){$margin="-450px";}
           if($puppala['questions']>=41 && $puppala['questions']<=44){$margin="-490px";}
           if($puppala['questions']>=45 && $puppala['questions']<=48){$margin="-540px";}
           if($puppala['questions']>=49 && $puppala['questions']<=52){$margin="-580px";}
           if($puppala['questions']>=53 && $puppala['questions']<=56){$margin="-630px";}
           if($puppala['questions']>=57 && $puppala['questions']<=60){$margin="-680px";}
           if($puppala['questions']>=61){$margin="-716px";}
           ?>
                  <div width="100%" style="z-index:999999999999;height:220px;padding:0px;overflow-y:scroll;">
					 <table width="100%" style="">
                  <?php
                  $Questions=$puppala['questions'];
                  $Qtype=$puppala['type'];
                  $Options=$puppala['options'];
                  $Type=array(); 
                  if ($Qtype=="A"){for($i=65;$i<65+$Options;$i++){array_push($Type,chr($i));}}
                  else if ($Qtype=="a"){for($i=97;$i<97+$Options;$i++){array_push($Type,chr($i));}}
                  else if ($Qtype=="1"){for($i=1;$i<1+$Options;$i++){array_push($Type,$i);}}
                  $Quesns=array();
                  for($i=1;$i<=$Questions;$i++){array_push($Quesns,"q".$i);}
                     for($i=1;$i<=$Questions;$i++)
									{
								shuffle($Type);
								echo "<tr>";
								echo "<td>".$i.".</td>";
								for($j=0;$j<count($Type);$j++)
								{
								echo "<td><input type='button' id='q".$i.$Type[$j]."'  onclick=\"change('q".$i.$Type[$j]."','q".$i."','".$Type[$j]."')\" style='font-size:15px;border:1px;background-color:#D8D8D8;'  value='".$Type[$j]."'></td>";	
								}
								
								echo "<td><input type='button'  onclick=deselect('q".$i."') id='deselq$i'style='visibility:hidden;border:1px;background-color:maroon;color:yellow;cursor:pointer;' value='X'></td></tr>";
								
								for($j=0;$j<count($Type);$j++)
								{
									
								echo "
									<input type='radio' id='q$i".$Type[$j]."r' value='".$Type[$j]."'  style='visibility:hidden;' name='q".$i."'>
									";
								}
									}
?>
</tr>
</table>
</div>
</div>


                    <div role="tabpanel" class="tab-pane" id="answeredques">
						
                  <div width="100%" style="height:220px;overflow-y:scroll;">
					 <table width="100%" class="table" style="position:relative;margin-top:0px;" id="answeredquestable">
					</table>
				  </div>
				  </div>
				  	
                    <div role="tabpanel" class="tab-pane" id="notansweredques">
						
                  <div width="100%" style="height:220px;overflow-y:scroll;">
					 <table width="100%" class="table" style="position:relative;margin-top:0px;" id="notansweredquestable">
					</table>
				  </div>
						</div>
                  </div>
                  <!--end of options view-->
</td>
</tr>
<tr style="border-top:1px solid #399BFF;">
	<td colspan='2'>
	<center><table width="100%">
	<tr>
	<td>&nbsp;&nbsp;&nbsp;No.of Questions :&nbsp;&nbsp;<span style="padding:2px;color:green;font-weight:bold;"><?php echo $puppala['questions'];?></span></td>
   <td>&nbsp;&nbsp;&nbsp;Questions Answered :&nbsp;&nbsp;<span style="padding:2px;color:blue;font-weight:bold;font-size:18px;" id="answered">0</span></td>
   <td>&nbsp;&nbsp;&nbsp;Negative Marking :&nbsp;&nbsp;<span style="padding:2px;color:green;font-weight:bold;"><?php if($puppala['cwone']>0){echo "<span style='color:red;'>Yes</span>";}else{echo "No";}?></span></td>
   <td>&nbsp;&nbsp;&nbsp;<a class="btn btn-success" style="padding:4px" style="cursor:pointer;" onclick="submitexam('manual')">Submit Exam</a>&nbsp;&nbsp;&nbsp;&nbsp;<span id='loader'></span></td>
   </tr>
	</table></center>
	</td></tr>
	
<tr style="border-top:1px solid #399BFF;">
<td colspan="2">
<center>Design and Developed by <a name="views/webteam.php" onclick="load_page(this.name)" style='cursor:pointer;'>Prathap Puppala,N130950</a>
</center>
</td>
</tr>
</table> 
</center>
  </div>
  
<div class="test"> <div id='mat'></div> <br/>
</div>
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

<script type="text/javascript">
$(document).ready(function(){
	var cur="instru";
	var oth="notifi";
	setTimeout(function(){
	    var tmp=cur;
		cur=oth;
		oth=tmp;
		$("#"+oth+"tab").removeClass("active");
		$("#"+cur+"tab").addClass("active");
		$("#"+oth).removeClass("tab-pane active");
		$("#"+oth).addClass("tab-pane");
		$("#"+cur).removeClass("tab-pane");
		$("#"+cur).addClass("tab-pane active");

	},30000);
});

var auto_refresh = setInterval(
function ()
	{
	$('#notifypage').load('views/user/ajax-notice.php');
	},10000);
	


function checkCookie(nam) {
    var user=getCookie(""+nam+"");
    if (user != "") {
	   var n=nam,opt=user;
	   n=n.replace("<?php echo $id.$sno;?>prathap~","");
	   opt=opt.replace(n,"");
       change(getCookie(nam),n,opt);
    }
}


function submitexam(cat)
{		
var num=<?php echo $Questions;?>;
var opt="";
var co=1;
for(var i=1;i<=num;i++)
{
if($("input[name=q"+i+"]:checked").val()!=undefined)
{
	opt=opt+$("input[name=q"+i+"]:checked").val();
	co++;
	if(co<=num){opt=opt+"~";}
	
}

else
{
opt=opt+"prathap";	
co++;
if(co<=num){opt=opt+"~";}
}		
}

if(cat=="manual"){
	
Lobibox.confirm({
                    msg: "Are you sure to  submit?",
                    title:"Confirmation",
                    iconClass:"fa fa-question",
                    callback: function ($this, type, ev) {
                        if (type === 'yes') {
					     $("#loader").html("<img src='myown/img/loading6.gif'>");
					     $.post("submitexam.php",{sno:<?php echo $sno;?>,opt:opt},function(data){if(data.indexOf("prathap")!=-1){ Lobibox.alert('success',{msg: "Submitted Successfully"});$("#loader").hide();setTimeout(function(){window.location='index'},2000);}else{Lobibox.alert('error',{msg: ""+data+""});$("#loader").hide();}});

					    }else{return false;} 
                    }
                });
}
else{
	//if it is auto submit
	 $("#loader").html("<img src='myown/img/loading6.gif'>");
     $.post("submitexam.php",{sno:<?php echo $sno;?>,opt:opt},function(data){if(data.indexOf("prathap")!=-1){ alert( "Submitted Successfully");$("#loader").hide();setTimeout(function(){window.location='index'},2000);}else{Lobibox.alert('error',{msg: ""+data+""});$("#loader").hide();}});
}
}		


var answeredopt=new Array();
var answeredanswers=new Array();
var total=[<?php foreach($Quesns as $Prathap){ echo '"'.$Prathap.'",';} ?>];

var complete="";
var count=0;
function change(qtno,qt,ins)
{
	
	var k=0;
	if(complete.search(qt)>=0)
		count=count;
	else
		count++;
	$("#answered").html(count);
	var allopt=[ <?php foreach($Type as $Prathap){ echo '"'.$Prathap.'",';} ?>];
	
	for(k;k<allopt.length;k++)
		{
			$("#"+qt+allopt[k]).css("background-color","#D8D8D8 ");
			$("#"+qt+allopt[k]).css("color","#000");
			
		}
		
	document.getElementById("desel"+qt).style.visibility="visible";
    //adding answered question numbers and answers into array
    var pos=answeredopt.indexOf(qt);
    if(pos==-1)
    {
	answeredopt.push(qt);
	answeredanswers.push(ins);
	}
	else
	{
	answeredanswers[pos]=ins;		
	}
	
	setCookie("<?php echo $id.$sno;?>prathap~"+qt,qtno);
		
	$("#"+qtno).css({"background-color":"#9900FF"});
	$("#"+qtno).css({"color":"yellow"});
	document.getElementById(""+qtno+"r").checked=true;
  complete=complete+qt;
	answeredcal();

}

function answeredcal()
{
var col=new Array("active","success","info","danger");
var cur;
var coln=0;
var str="";
if(answeredopt.length==0)
{
str="<tr><td style='padding:10px;'><br><br><center><img src='myown/img/cross.png'><br><h4 style='color:red'>You haven't answered anything.</h4></center></td></tr>";
}
else
{
for(cur=0;cur<answeredopt.length;cur++)
{
var qtn=answeredopt[cur];
qtn=qtn.replace("q","Que ");
str=str+"<tr><td class='warning' style='text-transform:capitalize;font-weight:bold;'><mark>"+qtn+"</mark></td><td class='"+col[coln]+"' style='font-weight:bold;'>"+answeredanswers[cur]+"</td></tr>";	
coln++;
coln=(coln<4)?coln:0;
}
}
$("#answeredquestable").html(str);
notansweredcal();
}

function notansweredcal()
{
var col=new Array("active","success","info","danger");
var cur;
var num=0;
var coln=0;
var str="<tr>";
if(answeredopt.length==total.length)
{
str="<td style='padding:10px;'><br><br><center><img src='myown/img/info.png'><br><h4 style='color:green'>You answered everything.</h4></center></td>";
}
else
{
for(cur=0;cur<total.length;cur++)
{
if(answeredopt.indexOf(total[cur])!=-1){continue;}
num++;
var qtn=total[cur];
str=str+"<td class='"+col[coln]+"' style='text-transform:uppercase;font-weight:bold;'>"+qtn+"</td>";	
if(num%4==0){str=str+"</tr><tr>";}
coln++;
coln=(coln<4)?coln:0;
}
}
str=str+"</tr>";
$("#notansweredquestable").html(str);
}

$(document).ready(function(){
	for(var i=0;i<total.length;i++)
	{
	var nam="<?php echo $id.$sno;?>prathap~"+total[i];
	checkCookie(nam);

	}
//calling main functions
notansweredcal();
answeredcal();
});

function deselect(qtno)
{
complete=complete.replace(qtno,"");
	var k=0;
	count--;
    $("#answered").html(count);
	var allopt=[<?php foreach($Type as $Prathap){ echo '"'.$Prathap.'",';} ?>];
	for(k;k<allopt.length;k++)
		{
			$("#"+qtno+allopt[k]).css("background-color","#D8D8D8 ");
			$("#"+qtno+allopt[k]).css("color","#000");
			$("#"+qtno+allopt[k]+"r").removeAttr("checked");
			
		}
  document.getElementById("desel"+qtno).style.visibility="hidden";
  deleteCookie("<?php echo $id.$sno;?>prathap~"+qtno);
    var pos=answeredopt.indexOf(qtno);
    if(pos!=-1)
    {
	answeredopt.splice(pos,1);
	answeredanswers.splice(pos,1);
	}
    answeredcal();
}

 $(document).ajaxError(function(e, xhr, opt){
     
        if(opt.url=="submitexam.php" && xhr.status!="200")
        {
		$("#loader").hide();
		Lobibox.alert('error',{msg:'There is no Connection to server.Please fix Connection.'});
		} 
    });
    
    
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
					msg("<?php echo $title;?> alert",'Your session has been expired! Please Login<br><mark>You can continue exam after Re-Login</mark>');
					setTimeout(function(){window.location='index';},5000);
					}
				}
		});
		}
check_session = setInterval(CheckForSession, 8000);

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


</script>
<?php
}
}
else
{
header("location:index");	
}
?>
</body>
</html>
<?php
}
?>

