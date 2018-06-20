<meta http-equiv="refresh" content="5">
<?php

require_once("../../site-settings.php");
if(isadminloggedin())
{
if(isset($_GET['mode']))
{
$mode=mysql_real_escape_string(strip_tags(trim($_GET['mode'])));
$allowed=array("answersafterexamonline","answersafterexamexcel");
if(in_array($mode,$allowed))
{
$viewn=($mode=="answersafterexamonline")?"Answers After Exam Online":"Answers After Exam Excel";

?>
  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title"><b style='color:red;'><?php echo $viewn."</b> Mode Results Validation view";?></h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li><a href="#">Result</a></li>
        <li class="active">Result view</li>
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

    <!-- Start Panel -->
    <div class="col-md-12">
      <div class="panel panel-default">
        
        <div class="panel-body table-responsive">
   <table  width="100%" style="text-align:justify;" class="table table-bordered table-striped">
                <tbody>
					<tr><th colspan='2'><center>Answers <b style='color:red;'><?php echo $viewn;?> </b> Validation mode</center></th></tr>
			</tbody>
			</table>
            <table id="example" class="table display">
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Display</th>
                        <th>End</th>
                        <th>Logins</th>
                        <th>Submits</th>
                        <th>Validate</th>
                    </tr>
                </thead>
             
             
                <tbody>
				<?php
				if($teckzitemode)
				{
				$q=mysql_query("SELECT * FROM examdetails WHERE eid!='NULL' and visibility='1' and answersmode='$mode' and validations='0'");
			    }
			    else
			    {
				$q=mysql_query("SELECT * FROM examdetails WHERE eid='NULL' and visibility='1' and answersmode='$mode' and validations='0'");
			    }
				while($w=mysql_fetch_array($q))
				{
				$tab=$w['tkey'];
					?>
                    <tr id="qwe<?php echo $w['sno'];?>">
                        <td><?php if($w['eid']!='NULL'){$eid=$w['eid'];mysql_select_db($teckzitedb,$con);$h=mysql_fetch_array(mysql_query("SELECT * FROM events WHERE eid='$eid'"));echo $h['branch']." - ".$h['eventname'];}else{echo "NULL";}
                        $Starttime=$w['display'];
	                   $endtime=$w['endat'];
                   	  if($ptime>$Starttime && $ptime<$endtime){echo "&nbsp;&nbsp;<mark>Online</mark>";}
                        ?></td>
                        <td><?php mysql_select_db($dbname,$con);echo $w['title'];?></td>
                        <td><?php echo $w['date'];?></td>
                        <td><?php 
    $starttime=$w['display'];                    
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
	$startt=$H.':'.$M.' '.$m;
	echo $startt;
                        ?></td>
                        <td><?php 
    $starttime=$w['endat'];                    
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
	$startt=$H.':'.$M.' '.$m;
	echo $startt;

                        ?></td>
                        <td><?php mysql_select_db("quiz_exams",$con); echo mysql_num_rows(mysql_query("SELECT * FROM $tab"));?></td>
                <td><?php mysql_select_db("quiz_exams",$con); echo mysql_num_rows(mysql_query("SELECT * FROM $tab WHERE status='Y'"));?></td>
               
                       <td>
	<?php
	if($mode=="answersafterexamonline")
	{
		?>
	<a class="btn btn-success" style='cursor:pointer;' name="views/admin/validateexam.php?valida=validate&sno=<?php echo $w['sno'];?>" onclick="load_page(this.name)"><i class="fa fa-check-square-o"></i>Validate</a>
     	
		<?php
	}
	else
	{
		?>
				
     <a class="btn btn-primary" style='cursor:pointer;' href="logic/php/admin/downloadexcel.php?sno=<?php echo $w['sno'];?>" target="_blank"><i class="fa fa-check-square-o"></i>Validate</a>
          <?php } ?>             
                       </td>
                        
                    </tr>
                    <?php } ?>
                </tbody>
            </table>


        </div>

      </div>
    </div>
    <!-- End Panel -->
    </div>
    

    
    <script src="js/datatables/datatables.min.js"></script>
    
    <?php } } } ?>
