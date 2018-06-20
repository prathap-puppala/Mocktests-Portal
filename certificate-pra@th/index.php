<?php
require("../site-settings.php");
if(!isloggedin()){header("location:../index");exit;}

 require_once("certificate.php");
 fetchCertificate($_POST['name'], $_POST['recognition'], $_POST['your-name']);
?>
