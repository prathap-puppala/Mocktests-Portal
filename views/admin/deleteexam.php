<?php

require_once("../../site-settings.php");
if(isadminloggedin())
{
?>

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">Delete Exam</h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li><a href="#">Delete</a></li>
        <li class="active">Exam</li>
      </ol>
      </div>
      
<div class="row">

    <!-- Start Panel -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-title">
          Answers <b style='color:red;'>Given Now </b> mode
        </div>
        <div class="panel-body table-responsive">

            <table id="example" class="table display">
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Title</th>
                        <th>Table</th>
                        <th>Date</th>
                        <th>Display</th>
                        <th>End</th>
                        <th>Delete</th>
                    </tr>
                </thead>
             
             
                <tbody>
				<?php
				if($teckzitemode)
				{
				$q=mysql_query("SELECT * FROM examdetails WHERE eid!='NULL' and visibility='1' and answersmode='answersgivenow'");
			    }
			    else
			    {
				$q=mysql_query("SELECT * FROM examdetails WHERE eid='NULL' and visibility='1' and answersmode='answersgivenow'");
			    }
				while($w=mysql_fetch_array($q))
				{
					?>
                    <tr id="qwe<?php echo $w['sno'];?>">
                        <td><?php if($w['eid']!='NULL'){$eid=$w['eid'];mysql_select_db($teckzitedb,$con);$h=mysql_fetch_array(mysql_query("SELECT * FROM events WHERE eid='$eid'"));echo $h['branch']." - ".$h['eventname'];}else{echo "NULL";}?></td>
                        <td><?php mysql_select_db($dbname,$con);echo $w['title'];?></td>
                        <td><?php echo $w['tkey'];?></td>
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
                        <td>
                        <a class="btn btn-primary" style='cursor:pointer;'  onclick=deleteexam(<?php echo $w['sno'];?>,'answersgivenow')><i class="fa fa-scissors"></i>Delete</a>
                        <span id="asd<?php echo $w['sno'];?>"></span>
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
    

<!--second one-->
  
<div class="row">

    <!-- Start Panel -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-title">
          <b style='color:red;'>answers after exam online </b> mode
        </div>
        <div class="panel-body table-responsive">

            <table id="example" class="table display">
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Title</th>
                        <th>Table</th>
                        <th>Date</th>
                        <th>Display</th>
                        <th>End</th>
                        <th>Delete</th>
                    </tr>
                </thead>
             
             
                <tbody>
				<?php
				if($teckzitemode)
				{
				$q=mysql_query("SELECT * FROM examdetails WHERE eid!='NULL' and visibility='1' and answersmode='answersafterexamonline'");
			    }
			    else
			    {
				$q=mysql_query("SELECT * FROM examdetails WHERE eid='NULL' and visibility='1' and answersmode='answersafterexamonline'");
			    }
				while($w=mysql_fetch_array($q))
				{
					?>
                    <tr id="qwe<?php echo $w['sno'];?>">
                        <td><?php if($w['eid']!='NULL'){$eid=$w['eid'];mysql_select_db($teckzitedb,$con);$h=mysql_fetch_array(mysql_query("SELECT * FROM events WHERE eid='$eid'"));echo $h['branch']." - ".$h['eventname'];}else{echo "NULL";}?></td>
                        <td><?php mysql_select_db($dbname,$con);echo $w['title'];?></td>
                        <td><?php echo $w['tkey'];?></td>
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
                        <td>
                        <a class="btn btn-primary" style='cursor:pointer;' onclick=deleteexam(<?php echo $w['sno'];?>,'answersafterexamonline')><i class="fa fa-scissors"></i>Delete</a>
                        <span id="asd<?php echo $w['sno'];?>"></span>
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
        
        
        
<!--second one-->
  
<div class="row">

    <!-- Start Panel -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-title">
          <b style='color:red;'>answers after exam excel </b> mode
        </div>
        <div class="panel-body table-responsive">

            <table id="example" class="table display">
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Title</th>
                        <th>Table</th>
                        <th>Date</th>
                        <th>Display</th>
                        <th>End</th>
                        <th>Delete</th>
                    </tr>
                </thead>
             
             
                <tbody>
				<?php
				if($teckzitemode)
				{
				$q=mysql_query("SELECT * FROM examdetails WHERE eid!='NULL' and visibility='1' and answersmode='answersafterexamexcel'");
			    }
			    else
			    {
				$q=mysql_query("SELECT * FROM examdetails WHERE eid='NULL' and visibility='1' and answersmode='answersafterexamexcel'");
			    }
				while($w=mysql_fetch_array($q))
				{
					?>
                    <tr  id="qwe<?php echo $w['sno'];?>">
                        <td><?php if($w['eid']!='NULL'){$eid=$w['eid'];mysql_select_db($teckzitedb,$con);$h=mysql_fetch_array(mysql_query("SELECT * FROM events WHERE eid='$eid'"));echo $h['branch']." - ".$h['eventname'];}else{echo "NULL";}?></td>
                        <td><?php mysql_select_db($dbname,$con);echo $w['title'];?></td>
                        <td><?php echo $w['tkey'];?></td>
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
                        <td>
                        <a class="btn btn-primary" style='cursor:pointer;' onclick=deleteexam(<?php echo $w['sno'];?>,'answersafterexamexcel')><i class="fa fa-scissors"></i>Delete</a>
                        <span id="asd<?php echo $w['sno'];?>"></span></td>
                        
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
    
    <?php } ?>
