<?php
error_reporting(0);
require_once("../site-settings.php");
$isl=(isloggedin())?true:false;

if($isl)
{
header("location:../index");
}
else
{
$logins=mysql_fetch_array(mysql_query("SELECT * FROM site_settings WHERE field='site forgotpass'"));
if($logins['value']=='yes' && $teckzitemode==false)
{

?><!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title;?></title>
 <link rel="icon" href="myown/img/logo.png">
  <!-- ========== Css Files ========== -->
  <link href="../css/root.css" rel="stylesheet">
  <noscript><style>html:before{content:"Javascript is disabled.";font-size:25px;padding:40%;font-family:Times New Roman;text-align:center;color:red;}html:after{content:"Please contact admin or enable Javascript.";font-size:25px;padding:34%;font-family:Times New Roman;text-align:center;color:green;}body{display:none;}</style></noscript>  
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/plugins.js"></script>
<script src="../js/sweet-alert/sweet-alert.min.js"></script>
<script src="../js/kode-alert/main.js"></script>


  <link rel="stylesheet" href="../dist/css/Lobibox.min.css"/>
  <script src="../dist/js/Lobibox.min.js"></script>
  <script type="text/javascript">
function shwer(prathap)
{Lobibox.notify('error', {
                    icon: false,
                    msg:prathap,
                    soundPath:"../dist/sounds/",
                    soundExt:".ogg",
                    sound:"sound4",
          
                });
			}
			
function prathap(){
      var uid=$('#uid').val();
      var passwd=$('#passwd').val();
      var cpasswd=$('#cpasswd').val();
      var email=$('#email').val();
      var seckey=$('#seckey').val();
      var atpos=email.indexOf("@");
      var dotpos=email.lastIndexOf(".");


      if(uid==undefined || uid==""){shwer("Please Enter University ID");}
      else if(email==undefined || email==""){shwer("Please Enter Email");}
      else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length){shwer("Please Enter Valid Email");}
      else if(seckey==undefined || seckey==""){shwer("Please Enter Secrete Key");}
      else if(passwd==undefined || passwd==""){shwer("Please Enter Password");}
      else if(cpasswd==undefined || cpasswd==""){shwer("Please Enter Confirm Password");}
      else if(passwd!=cpasswd){shwer("Password and Confirm password do not match");}
	  else
	  {
      var dataString = 'uid='+uid+'&passwd='+passwd+'&cpasswd='+cpasswd+'&email='+email+'&seckey='+seckey;
      
      $.ajax({
      type: "POST",
      url: "../logic/php/user/forgot.php",
      data: dataString,
      cache: false,
      beforeSend:function(){$("#loader").show();},
      success: function(result){
		       $("#loader").hide();
               var result=trim(result);
               if(result=='success'){
                     Lobibox.alert('success', {
                    msg: "Password Changed Successfully"
                });
                window.location="../";
               }else{
                     Lobibox.alert('error', {
                    msg: result
                });
               }
      }
      });
  }
}

function trim(str){
     var str=str.replace(/^\s+|\s+$/,'');
     return str;
}
</script>


  <style type="text/css">
    body{background: #F5F5F5;}
  </style>
  </head>
  <body>

    <div class="login-form">
       <form method="post"  action="javascript:void(0);">
        <div class="top">
          <h1><?php echo $title;?> Password Recovery</h1>
        </div>
        <div class="form-area">
          <div class="group">
            <input type="text" id="uid" class="form-control" placeholder="University ID"  data-container="body" data-toggle="popover" data-placement="right" data-content="Enter your University ID.">
            <i class="fa fa-user"></i>
          </div>
         <div class="group">
            <input type="text" id="email" class="form-control" placeholder="Email" data-container="body" data-toggle="popover" data-placement="right" data-content="Enter your EMAIL which you entered at the time of Registration.">
            <i class="fa fa-envelope"></i>
          </div>
          <div class="group">
            <input type="password" id="seckey" class="form-control" placeholder="Secrete Key" data-container="body" data-toggle="popover" data-placement="right" data-content="Enter your SECRETE KEY which you entered at the time of Registration.">
            <i class="fa fa-key"></i>
          </div>
           <div class="group">
            <input type="password" id="passwd" class="form-control" placeholder="New Password" data-container="body" data-toggle="popover" data-placement="right" data-content="Enter New Password.">
            <i class="fa fa-key"></i>
          </div>
          <div class="group">
            <input type="password" id="cpasswd" class="form-control" placeholder="Password again" data-container="body" data-toggle="popover" data-placement="right" data-content="Re-enter Password.">
            <i class="fa fa-key"></i>
          </div>
          <center><span id="loader" style="display:none;"><img src='../myown/img/loading6.gif'></span></center>
          <button type="submit" class="btn btn-default btn-block" onclick="prathap()">RECOVER</button>
          
        </div>
      </form>
      <?php
      
		 echo '
      <div class="footer-links row">
        <div class="col-xs-6"><a href="register"><i class="fa fa-lock"></i> Register</a></div>
        <div class="col-xs-6 text-right"><a href="../"><i class="fa fa-lock"></i> Login</a></div>
      </div>
      ';
  
      ?><br>
      <center><p><b>&copy; Prathap Puppala, N130950</b></p></center>
    </div>
  

</body>
</html>
<?php
}
else
{
?>
  <link href="../css/root.css" rel="stylesheet">
<div class='content'>
  <!-- Start Presentation -->
  <div class="row presentation">

    <div class="col-lg-8 col-md-6 titles">
      <span class="icon color10-bg"><i class="fa fa-exclamation-triangle"></i></span>
      <h1>Password Recovery is disabled</h1>
      <h4>Admin disabled Password Recovery.<br>Please Contact Admin</h4>
    </div>

  </div>
  <!-- End Presentation -->
</div>
<?php

 } 
 }
 ?>
