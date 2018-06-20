<?php

require_once("../../site-settings.php");
if(isadminloggedin())
{


if(isset($_POST['submit']))
	{
$sno=mysql_real_escape_string(trim($_POST['sno']));
$evename=mysql_real_escape_string(trim($_POST['evename']));
$catego=mysql_real_escape_string(trim($_POST['catego']));
$notetitle=mysql_real_escape_string(trim($_POST['notetitle']));
$notesd=mysql_real_escape_string(trim($_POST['notesd']));
$valid_folder=0;
$valid_extension=0;
$fileyes=0;


		if(1==1)
		{
			//adding notice without attachment
			 if(mysql_query("UPDATE notifications SET eid='$evename',title='$notetitle',description='$catego',sd='$notesd',added_date='$date',ip='$ip' WHERE nid='$sno'") or die(mysql_error()))
		{
	echo "<script>alert('Notice has been Updated');window.location='../../index.php';</script>";
		}
		

		}

}

if(isset($_GET['sno']))
{
$sno=mysql_real_escape_string(trim(htmlspecialchars(strip_tags($_GET['sno']))));
$prathap=mysql_query("SELECT * FROM notifications WHERE nid='$sno' and visibility='1'");
if(mysql_num_rows($prathap)>=1)
{
$puppala=mysql_fetch_array($prathap);

?>
  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">Edit Notice</h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li><a href="#">Edit</a></li>
        <li class="active">Notice</li>
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

<center>
					<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" onsubmit="return filevalid()" >

                <table  width="100%" style="text-align:justify;" class="table table-bordered table-striped">
                <tbody>
					<tr><th colspan='2'><center>Fill Details to Edit Notice</center></th></tr>
					
					<tr>
					<td>
				  <label for="eid" class="col-sm-5 control-label form-label">Exam ID</label>
				  </td><td>
                  <div class="col-sm-10">
					  <input type='hidden' name='sno' value='<?php echo $sno;?>'>
                    <input type="text" class="form-control" id='evename' name='evename' value="<?php echo $puppala['eid'];?>" readonly>
                    
                  </div>
                </td>
					</tr>
					
					

                <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Title</label>
				  </td><td>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id='notetitle' name='notetitle' value="<?php echo $puppala['title'];?>"><br>
                     <span id='ans'></span>
                    </div>
                </td>
					</tr>

          <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Notice</label>
				  </td><td>
                  <div class="col-sm-10">
					  <textarea class="textarea form-control wysihtml5-textarea" name="catego" id="catego" placeholder="Enter text ..."  style="height:200px; width:100%;"><?php echo $puppala['description'];?></textarea>
                     </div>
                </td>
					</tr>

          <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Sd/-</label>
				  </td><td>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id='notesd' name='notesd' value="<?php echo $puppala['sd'];?>"><br>
                     <span id='ans'></span>
                    </div>
                </td>
					</tr>
					
					
					<tr><td colspan="2"><center><input type="submit" name="submit" value="Edit" class="btn btn-rounded btn-primary"></center></td></tr>
                </tbody>
                </table>               
                </form>
                </center>
                <script>
function getinputdata(field)
{
return document.getElementById(field).value;
}


function filevalid()
{
var evename=getinputdata("evename");
var notetitle=getinputdata("notetitle");
var catego=getinputdata("catego");
var notesd=getinputdata("notesd");

	if(evename=="")
	{
	return false;
	}
	else if(notetitle=="")
	{
	alert("Please Enter Title");
	return false;
	}
	else if(catego=="")
	{
	alert("Please Enter Description");
	return false;
	}
	else if(notesd=="")
	{
	alert("Please Enter Sd/-");
	return false;
	}
else
	{
	return true;
	}
}
</script>

<script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.min.js"></script>
<!-- bootstrap file -->
<script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
	
  $('.textarea').wysihtml5();
</script>
<?php
}
}
}
?>
