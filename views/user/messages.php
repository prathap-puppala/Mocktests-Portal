<?php

require_once("../../site-settings.php");

if(isloggedin())
{
if(1==1)
{
$user=$_SESSION['userid'];
$prathap=mysql_query("SELECT * FROM messages WHERE sender='$user'");
if(1==1)
{
$puppala=mysql_fetch_array($prathap);

?>
 
  <div class="page-header">
    <h1 class="title">Messages</h1>
      <ol class="breadcrumb">
        <li class="active"><?php $g=mysql_num_rows(mysql_query("SELECT * FROM messages WHERE sender='$user' && replysend!='1'")); if($g>0){?><span class="label label-danger"><?php echo $g;?></span> pending messages<?php } ?> </li>
      </ol>

  </div>
  <!-- End Page Header -->

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="container-mail">



<!-- Start Mailbox -->
<div class="mailbox clearfix">

  <!-- Start Mailbox Menu -->
  <div class="mailbox-menu">
    <ul class="menu">
      <li><a href="#"><i class="fa fa-inbox"></i> Inbox</a></li>
    </ul>
    
  </div>
  <!-- End Mailbox Menu -->

  <!-- Start Mailbox Container -->
  <div class="container-mailbox">

        <!-- Start Mailbox Inbox -->
        <div class="col-lg-3 col-md-4 padding-0">
        <ul class="mailbox-inbox">

            <li class="search">
              <form action="javascript:void(0)" method="post" onsubmit="return sendmsg()">
                <input type="text" class="mailbox-search" id="mailboxsearch" placeholder="Search">
                <span class="searchbutton"><i class="fa fa-search"></i></span>
              </form>
            </li>
<?php

$r=mysql_query("SELECT * FROM admin");
while($rr=mysql_fetch_array($r))
{
	?>
            <li>
              <a href="#" class="item clearfix">
                <img <?php if($rr['stuid']=="N130950"){echo "src=\"myown/img/prathap.jpg\"";}else{echo "src=\"img/profileimg.png\"";}?> alt="img" class="img">
                <span class="from"><?php echo $rr['name'];?></span>
                <?php echo $rr['stuid'];?>
              </a>
            </li>
<?php } ?>
        </ul>
        </div>
        <!-- End Mailbox Inbox -->

        <!-- Start Chat -->
        <div class="chat col-lg-9 col-md-8 padding-0">

          <!-- Start Title -->
          <div class="title">
            <h1><?php echo $user;?> <small>( student )</small></h1>
            <p><b>To:</b> Admin</p>
             
          </div>
          <!-- End Title -->

          <!-- Start Conv -->
          <ul class="conv" style="word-wrap: break-word;">
       <?php
       $tt=mysql_query("SELECT * FROM messages WHERE sender='$user' || receiver='$user'");
       while($t=mysql_fetch_array($tt))
       {
       ?>
              <?php
              if($t['sender']==$user)
              {
				  ?>
             
              <li style="word-wrap: break-word;">			
              <img src="myown/img/user.png" alt="img" class="img">
              <p class="ballon color1" style="word-wrap: break-word;"><?php echo $t['matter'];?></p><br>
              </li>
              <?php
              if($t['reply']!=""){
				  ?><li style="word-wrap: break-word;">
              <img src="myown/img/prathap.jpg" alt="img" class="img">
              <p class="ballon color2"><?php echo $t['reply'];?></p></li><br>
		 <?php } ?>
              <?php
		  }
		  else
		  {?>
		   <li style="word-wrap: break-word;">
		     <img src="myown/img/prathap.jpg" alt="img" class="img">
             <p class="ballon color2"  style="word-wrap: break-word;"><?php echo $t['matter'];?></p><br>
              </li>
		  <?php } ?>
<?php } ?>

          </ul>
          <!-- End Conv -->

          <div class="write">
              <form class="margin-b-20">
                <p><textarea class="textarea form-control wysihtml5-textarea" id="msg" placeholder="Enter text ..."  style="height:200px; width:100%;"></textarea></p>

                <a style='cursor:pointer;' class="btn btn-default" onclick="sendmsg()">Send</a>
                <span id="asd"></span>
                <button type="reset" class="btn margin-l-5">Clear</button>
              </form>
          </div>


        </div>
        <!-- End Chat -->

  </div>
  <!-- End Mailbox Container -->

</div>
<!-- End Mailbox -->
 <script type="text/javascript" src="js/bootstrap-wysihtml5/wysihtml5-0.3.0.min.js"></script>
<!-- bootstrap file -->
<script type="text/javascript" src="js/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script>
	
  $('.textarea').wysihtml5();
</script>
<script>
function sendmsg()
{
var msg=$("#msg").val();
$("#asd").html("<img src='myown/img/loading8.gif'>");	
 if (confirm("Are you sure to send?")) {
 $.post("logic/php/user/sendmsgadmin.php",{msg:msg},function(data){if(data.indexOf("success")!=-1){  Lobibox.notify('success', {msg: 'Message successfully sent'});load_page("views/user/messages.php");}else{alert(data);}});					   
   } 
 



}
</script>
 <?php
}
}
}
?>
