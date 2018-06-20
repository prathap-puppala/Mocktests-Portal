<meta http-equiv="refresh" content="5">
<?php

require_once("../../site-settings.php");
if(isloggedin() && $teckzitemode==false)
{
if(1==1)
{
if(1==1)
{
$user=$_SESSION['userid'];
$qwe=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$user'"));
?>
  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">CHANGE PASSWORD</h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li><a href="javascript:void(0)">Profile</a></li>
        <li class="active">CHANGE PASSWORD</li>
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

      <div class="container-widget">

	<center>
<div class="row">
    <!-- Start Panel -->
    <div class="col-md-12">
      <div class="panel panel-default">
        
        <div class="panel-body table-responsive">
   <table  width="100%" style="text-align:justify;" class="table table-bordered table-striped">
                <tbody>
					<tr><th colspan='2'><center>CHANGE PASSWORD</center></th></tr>
					<tr><th colspan='2'><marquee><font color='color:green;'>If any problem persists,please contact us through message panel.</font></marquee></th></tr>
			</tbody>
			</table>
            <table id="example" class="table table-bordered table-striped">
               
             
             
                <tbody>
				<tr><td width="15%">Current Password</td><td> <input type="password" id="opasswd" class="form-control" placeholder="Current Password"></td></tr>
				<tr><td width="15%">New Password</td><td> <input type="password" id="passwd" class="form-control"  placeholder="New Password"></td></tr>
				<tr><td width="15%">Confirm Password</td><td> <input type="password" id="cpasswd" class="form-control"  placeholder="Confirm Password"></td></tr>
				<tr><td colspan="2"> <center><span id="loader" style="display:none;"><img src='myown/img/loading6.gif'></span></center></td></tr>
				<tr><td colspan="2"> <center><button type="submit" class="btn btn-default btn-block" onclick="changepass()" width="10%">CHANGE</button></center> </td></tr>
				</tbody>
            </table>


        </div>

      </div>
    </div>
    <!-- End Panel -->
 </div>
   </center>    
</div>

  <script type="text/javascript">
function shwer(prathap)
{Lobibox.notify('error', {
                    icon: false,
                    msg:prathap,
                    soundPath:"dist/sounds/",
                    soundExt:".ogg",
                    sound:"sound4",
          
                });
			}
			
function changepass(){
      var opasswd=$('#opasswd').val();
      var passwd=$('#passwd').val();
      var cpasswd=$('#cpasswd').val();
      

      if(opasswd==undefined || opasswd==""){shwer("Please Enter Old Password");}
      else if(passwd==undefined || passwd==""){shwer("Please Enter New Password");}
      else if(cpasswd==undefined || cpasswd==""){shwer("Please Enter Confirm Password");}
      else if(passwd!=cpasswd){shwer("Password and Confirm password do not match");}
	  else
	  {
      var dataString = 'opasswd='+opasswd+'&passwd='+passwd+'&cpasswd='+cpasswd;
      
      $.ajax({
      type: "POST",
      url: "logic/php/user/changepass.php",
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
                location.reload();
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

    <?php } } } ?>
