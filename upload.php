<?php
require("site-settings.php");
if(!isloggedin()){header("location:index");}
date_default_timezone_set("Asia/Calcutta");
setlocale(LC_ALL,"hu_HU.UTF8");
$time=(strftime("%Y, %B %d, %A."))." ".date("h:i:sa");

$status="<u><big>Instructions</big></u><br><ol style='text-align:left;'><li>Question paper should be in <font color='blue'>odt</font> or <font color='blue'>docx</font> format.</li><li>Answers for questions should be in txt file.</li><li>You have to <font color='blue'>ZIP</font> both Question and answer files and have to upload it.</li><li>At the bottom of Question paper write your ID Number and Name.</li><li>Number of Questions should not exceed 50.</li></ol>";

if(isset($_POST['submit']))
{
if(($_FILES['file']['name'])=="")
{
$status="<font color='red'>Please select a file</font>";	
}	
else
{
	$stud=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='".$_SESSION['userid']."'"));
	$gg=mysql_query("SELECT * FROM uploaded_papers WHERE stuid='".$_SESSION['userid']."'");
	$ff=mysql_num_rows($gg);
	$ff=(int)$ff+1;
	$extension=pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
	$allowed=array("zip","rar","ZIP","RAR");
	$filename=$_FILES['file']['name'];
	$random = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
    $newf=$_SESSION['userid']."_".$stud['year']."_".$ff."_".$random.".".$extension;
    if(!is_dir("uploadedques_sdcacmock")){mkdir("uploadedques_sdcacmock");}
   
    if(in_array($extension,$allowed)){
	if(file_exists("uploadedques_sdcacmock/".$newf))
	{
$status="<font color='red'>File with same name already exists</font>";
	}
	else
	{
	if(move_uploaded_file($_FILES['file']['tmp_name'],"uploadedques_sdcacmock/".$newf))
	{
		$msg="Thank you for uploading such a nice  Question paper.We will message you before it get posted.";
		mysql_query("INSERT INTO messages(eid,sender,receiver,matter,sendertype,replysend,ip,date) VALUES('NULL','Admin','".$_SESSION['userid']."','$msg','admin','1','$ip','$date')");
		if(mysql_query("INSERT INTO uploaded_papers(stuid,filename,uploaded_ip) VALUES('".$_SESSION['userid']."','$newf','$ip')")){
		$status="<font color='green'><img src='like.png'><br><h4>File has been Uploaded successfully.....</h3><h6>File Name : ".$filename."<br>File Size : ".$_FILES['file']['size']."<br>File Format:".$extension."<br>Uploaded from : ".$ip."<br>Uploaded time : ".$time."</h4></font>";
	}
	}
    }
    }
    else
    {
	$status="<font color='red'>Only ZIP or RAR file is allowed.</font>";
	}

}
}
?>
<title>File Uploader</title>
<style>
body
{
background:#f0f0f0;
}
#frm
{
background:#fff;
width:675px;
}
.uploads
{
border:0;
}
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
   width:100%;
    border-collapse: collapse;
}

#customers td, #customers th {
    font-size: 1em;
    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;
}

#customers th {
    font-size: 1.1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #A7C942;
    color: #ffffff;
    text-align:center;
}

#customers tr:nth-child(2n) {
    color: #000000;
    background-color: #EAF2D3;
}
</style>
<center>

<form enctype="multipart/form-data" method="post" action="" id='frm'>
<table id="customers">
  <tr>
    <th colspan="2">Question Paper Uploader</th>
</tr>
<tr><td>Select file</td><td>
	<input type="file" name="file" id="file" ></td></tr>
<tr><td colspan="2"><center><?php echo $status;?></center></td></tr>
<tr>
<td colspan="2">
<center><input type="submit" name="submit" value="submit"></center>
</td></tr>

</table>
</form>
<p><small>All rights Reserved @ SDCAC</small></p>
</center>
