<?php

require_once("../../site-settings.php");
if(isadminloggedin())
{

if(isset($_POST['submit']))
	{
$evename=mysql_real_escape_string(trim($_POST['evename']));
$catego=mysql_real_escape_string(trim($_POST['catego']));
$notetitle=mysql_real_escape_string(trim($_POST['notetitle']));
$notesd=mysql_real_escape_string(trim($_POST['notesd']));
$valid_folder=0;
$valid_extension=0;
$fileyes=0;
if(($_FILES['file']['name'])=="")
{
	$fileyes=0;
}
else
{
	$fileyes=1;
	$extension=pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
	$allowed=array("zip","doc","pdf","ppt");
	$filename=$_FILES['file']['name'];
	$filename="".$filename."_".$evename.".".$extension."";
	
	$filepat="<a href=notice_files/".$filename." target=_blank>Click here to View attachment</a>";
	
if(!in_array($extension,$allowed))
		{
     echo "<script>alert('File is not allowed to upload...');</script>";
		}
		else
		{
			$valid_extension=1;
		}
 if(is_dir("../../notice_files"))
		{
      
			$valid_folder=1;
			
		}
		else
		{

		mkdir("../../notice_files");
		
       
			$valid_folder=1;
			
		}

}

if($fileyes==1)
		{
	//adding notice with attachment
if($valid_folder==1 && $valid_extension==1)
		{
		if(move_uploaded_file($_FILES['file']['tmp_name'],"../../notice_files/".$filename))
	{
 if(mysql_query("INSERT INTO notifications(eid,title,description,attachments,sd,added_by,added_date,ip) VALUES ('$evename','$notetitle','$catego','$filepat','$notesd','".$_SESSION['userid']."','$date','$ip')") or die(mysql_error()))
		{
	echo "<script>alert('Notice has been added');window.location='../../index.php';</script>";
		}
		
	}
		}
		}
		else
		{
			//adding notice without attachment
			 if(mysql_query("INSERT INTO notifications(eid,title,description,sd,added_by,added_date,ip) VALUES ('$evename','$notetitle','$catego','$notesd','".$_SESSION['userid']."','$date','$ip')") or die(mysql_error()))
		{
	echo "<script>alert('Notice has been added');window.location='../../index.php';</script>";
		}
		

		}

}

?>
  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">Create Notice</h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li><a href="#">Create</a></li>
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
					<tr><th colspan='2'><center>Fill Details to Create Notice</center></th></tr>
					
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
	
		echo "<select class='selectpicker' id='evename' name='evename'><option value=''>Select</option>";
		  while($branch_cat=mysql_fetch_array($settings)){
			 echo "<option value='".$branch_cat['eid']."'>".$branch_cat['branch']."~".$branch_cat['eventname']."</option>"; 
		   }
		   echo "</select>";
					  }
					  else
					  {
						  mysql_select_db($dbname,$con);
						  ?>
                    <input type="text" class="form-control" id='evename' name='evename' value="NULL" readonly>
                    <?php } ?>
                  </div>
                </td>
					</tr>
					
					

                <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Title</label>
				  </td><td>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id='notetitle' name='notetitle' value=" "><br>
                     <span id='ans'></span>
                    </div>
                </td>
					</tr>

          <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Notice</label>
				  </td><td>
                  <div class="col-sm-10">
					  <textarea class="textarea form-control wysihtml5-textarea" name="catego" id="catego" placeholder="Enter text ..."  style="height:200px; width:100%;"></textarea>
                     </div>
                </td>
					</tr>

          <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">Sd/-</label>
				  </td><td>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id='notesd' name='notesd' value="Admin"><br>
                     <span id='ans'></span>
                    </div>
                </td>
					</tr>
					
					
					
          <tr>
					<td>
				  <label class="col-sm-5 control-label form-label">File</label>
				  </td><td>
                  <div class="col-sm-10">
                     <input id="file" name="file" type="file" ><br>
                     <span id='ans'></span>
                    </div>
                </td>
					</tr>
					<tr><td colspan="2"><center><input type="submit" name="submit" value="Create" class="btn btn-rounded btn-primary"></center></td></tr>
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
?>
