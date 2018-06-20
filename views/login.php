<?php
error_reporting(0);
require_once("site-settings.php");
$isl=(isloggedin())?true:false;

if($isl)
{
header("location:index");
}
else
{
$logins=mysql_fetch_array(mysql_query("SELECT * FROM site_settings WHERE field='site login'"));
if($logins['value']=='yes')
{
$cat="";
if(isset($_GET['page']) && trim(mysql_real_escape_string($_GET['page']))=="admin"){$cat="admin";}

?><!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title;?></title>
  <link rel="icon" href="myown/img/user.png">
  <!-- ========== Css Files ========== -->
  <link href="css/root.css" rel="stylesheet">
    <noscript><style>html:before{content:"Javascript is disabled.";font-size:25px;padding:40%;font-family:Times New Roman;text-align:center;color:red;}html:after{content:"Please contact admin or enable Javascript.";font-size:25px;padding:34%;font-family:Times New Roman;text-align:center;color:green;}body{display:none;}</style></noscript>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="js/plugins.js"></script>
<script src="js/sweet-alert/sweet-alert.min.js"></script>
<script src="js/kode-alert/main.js"></script>


  <link rel="stylesheet" href="dist/css/Lobibox.min.css"/>
  <script src="dist/js/Lobibox.min.js"></script>

  <style type="text/css">
    body{background: #F5F5F5;}
  </style>
  <script>
	function shwer(prathap)
{Lobibox.notify('error', {
                    icon: false,
                    msg:prathap,
                    soundPath:"dist/sounds/",
                    soundExt:".ogg",
                    sound:"sound4",
          
                });
			}

  function getdata(field)
  {
	return document.getElementById(field).value;  
  }
  
  function isvalid()
  {
  var userid=getdata("userid");	  
  var userpass=getdata("userpass");	  
  
  if(userid="" || userid==undefined || userpass=="" || userpass==undefined){
	  
        $("#alertbottomleft").html("<i class='fa fa-envelope-o'></i>*All fields are required").fadeToggle(350);
         shwer("Please enter all fields");
        return false;}
  else{document.getElementById('logbut').innerHTML='Authenticating.....';return true;}

  }
  </script>
  </head>
  <body>

    <div class="login-form">
      <form method="post" onsubmit="return isvalid()" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <div class="top">
          <h1><?php echo $title." ".ucfirst($cat)." Login";?></h1>
          <h4 style="color:red;">Please <a href="views/register">Register</a> to Login</h4>
          </div>
        <div class="form-area">
          <div class="group">
			 
            <input type="text" class="form-control" placeholder="Username" data-container="body" data-toggle="popover" data-placement="right" data-content="Enter your Login Username.  Eg:N130950" name="userid" id="userid">
            <i class="fa fa-user"></i>
          </div>
          <div class="group">
            <input type="password" class="form-control" autocomplete="off" placeholder="Password" data-container="body" data-toggle="popover" data-placement="right" data-content="Enter your Login Password." name="userpass" id="userpass">
            <i class="fa fa-key"></i>
          </div>
          <input type="hidden" value="<?php echo $cat;?>" name="cate">
          <input type="submit" class="btn btn-default btn-block" id="logbut" name="submit" value="LOGIN">
        </div>
      </form>
      <?php
      if(!$teckzitemode)
      {
		 echo '
      <div class="footer-links row">
        <div class="col-xs-6"><a href="views/register"><i class="fa fa-external-link"></i> Register Now</a></div>
        <div class="col-xs-6 text-right"><a href="views/forgot"><i class="fa fa-lock"></i> Forgot password</a></div>
      </div>
      ';
  }
      ?><br>
      <center><p><b>&copy; Prathap Puppala, N130950</b></p></center>
    </div>
    <!-- Start an Alert -->
          <div id="alertbottomleft" class="kode-alert kode-alert-icon kode-alert-click alert6 kode-alert-bottom-left">
            <i class="fa fa-user"></i>
            <!--msg goes here-->
          </div>
          <!-- End an Alert -->


</body>
</html>
<?php
//login code

if(isset($_SERVER['REQUEST_METHOD'])=="POST")
{
if(isset($_POST['submit']))
{
if(isset($_POST['userid']) && !empty($_POST['userid']) && isset($_POST['userpass']) && !empty($_POST['userpass']))
{
$userid=trim(mysql_real_escape_string(strip_tags($_POST['userid'])));
$userpass=trim(mysql_real_escape_string(strip_tags($_POST['userpass'])));
$cate=trim(mysql_real_escape_string(strip_tags($_POST['cate'])));
if($userid!="" && $userpass!="")
{
if($cate=="admin")
{
$query=mysql_query("SELECT * FROM admin WHERE stuid='$userid' && passwd=md5('$userpass')");
if(mysql_num_rows($query)>=1){$_SESSION['userid']=$userid;$_SESSION['admin']="yes";if(!isset($_SESSION['adminvisited'])){mysql_query("UPDATE visits SET value=value+1 WHERE type='Admin'");$_SESSION['adminvisited']="yes";}mysql_query("INSERT INTO log_history (user,type,time,date,ip) values ('$userid','admin','$ctime','$cdate','$ip')");header("location:index.php");}
else{echo "<div id='alertbottomleft' style='display:block;' class='kode-alert kode-alert-icon kode-alert-click alert6 kode-alert-bottom-left'><i class='fa fa-envelope-o'></i> Invalid Credentials</div><script>Lobibox.alert('error', { msg: \"Invalid Credentials\"});</script> ";}

}
else
{
if($teckzitemode)
{	
mysql_select_db($teckzitedb,$con);
$query=mysql_query("SELECT * FROM $passtable WHERE stuid='$userid' && passwd=md5('$userpass')");
if(mysql_num_rows($query)>=1){$_SESSION['userid']=$userid;mysql_select_db($dbname,$con);if(!isset($_SESSION['uservisited'])){mysql_query("UPDATE visits SET value=value+1 WHERE type='User'");$_SESSION['uservisited']="yes";}mysql_query("INSERT INTO log_history (user,type,time,date,ip) values ('$userid','student','$ctime','$cdate','$ip')");header("location:index.php");}
else{echo "<div id='alertbottomleft' style='display:block;' class='kode-alert kode-alert-icon kode-alert-click alert6 kode-alert-bottom-left'><i class='fa fa-envelope-o'></i> Invalid Credentials</div><script>Lobibox.alert('error', { msg: \"Invalid Credentials\"});</script> ";}
}
else
{
$query=mysql_query("SELECT * FROM users WHERE stuid='$userid' && passwd=md5('$userpass')");
if(mysql_num_rows($query)>=1){$g=mysql_fetch_array($query);if($g['status']!='blocked'){$_SESSION['userid']=$userid;if(!isset($_SESSION['uservisited'])){mysql_query("UPDATE visits SET value=value+1 WHERE type='User'");$_SESSION['uservisited']="yes";}mysql_query("INSERT INTO log_history (user,type,time,date,ip) values ('$userid','student','$ctime','$cdate','$ip')");header("location:index.php");}else{header("location:views/blocked.php");echo "<div id='alertbottomleft' style='display:block;' class='kode-alert kode-alert-icon kode-alert-click alert6 kode-alert-bottom-left'><i class='fa fa-envelope-o'></i>Your account is Blocked</div> ";}}
else{echo "<div id='alertbottomleft' style='display:block;' class='kode-alert kode-alert-icon kode-alert-click alert6 kode-alert-bottom-left'><i class='fa fa-envelope-o'></i> Invalid Credentials</div><script>Lobibox.alert('error', { msg: \"Invalid Credentials\"});</script> ";}
}
}

}
}
}
}
}
else
{
?>
  <link href="css/root.css" rel="stylesheet">
<div class='content'>
  <!-- Start Presentation -->
  <div class="row presentation">

    <div class="col-lg-8 col-md-6 titles">
      <span class="icon color10-bg"><i class="fa fa-exclamation-triangle"></i></span>
      <h1>Logins are disabled</h1>
      <h4>Admin disabled Logging into this site.<br>Please Contact Admin</h4>
    </div>

  </div>
  <!-- End Presentation -->
</div>
<?php
}
 } ?>
