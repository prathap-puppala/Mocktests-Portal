<?php
require_once("site-settings.php");
if(isset($_GET['sno']))
{ 
    $filename = htmlspecialchars(strip_tags(mysql_real_escape_string(htmlentities($_GET['sno'])))); //Get the fileid from the URL
    // Query the file ID
    $query = sprintf("SELECT * FROM examdetails WHERE sno = '$filename'");
    $sql = mysql_query($query);
    if(mysql_num_rows($sql)>0){
      $row = mysql_fetch_array($sql);
      if($row['date']<date("d-m-Y")){
      // Set some headers
      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
      header("Content-Disposition: attachment; filename=".basename($row['filename']).";");
      header("Content-Transfer-Encoding: binary");
      header("Content-Length: ".filesize($mainp."/".$row['filename']));
      @readfile($mainp."/".$row['filename']);
      exit(0);
      }
    }
    else {
      header("Location: /");
      exit(0);
    }
}
else
{
	
}
?>
