<?php

require_once("../../site-settings.php");
if(isadminloggedin())
{
if(isset($_GET['sno']))
{
$sno=mysql_real_escape_string(trim(htmlspecialchars(strip_tags($_GET['sno']))));
$prathap=mysql_query("SELECT * FROM messages WHERE sno='$sno' and sendertype='student'");
if(mysql_num_rows($prathap)>=1)
{
$puppala=mysql_fetch_array($prathap);

?>
 
 !-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">Mailbox</h1>
      <ol class="breadcrumb">
        <li class="active">You have <?php $g=mysql_num_rows(mysql_query("SELECT * FROM messages WHERE replysend='0' && sendertype='student'")); if($g>0){?><span class="label label-danger"><?php echo $g;?></span><?php } ?> unread messages</li>
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

$r=mysql_query("SELECT * FROM messages WHERE replysend='0' && sendertype='student' and sno!='$sno'");
while($rr=mysql_fetch_array($r))
{
	?>
            <li>
              <a name="views/admin/viewmsg.php?sno=<?php echo $rr['sno'];?>" style="cursor:pointer;" onclick="load_page(this.name)" class="item clearfix">
                <img src="img/profileimg.png" alt="img" class="img">
                <span class="from"><?php echo $rr['sender'];?></span>
                <?php echo $rr['matter'];?>
                <span class="date"><?php echo $rr['date'];?></span>
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
            <h1><?php echo $puppala['sender'];?> <small>( student )</small></h1>
            <p><b>To:</b> <?php echo $puppala['receiver'];?></p>
             
          </div>
          <!-- End Title -->

          <!-- Start Conv -->
          <ul class="conv">
       <?php
      $sender=$puppala['sender'];
       $tt=mysql_query("SELECT * FROM messages WHERE sender='$sender' || receiver='$sender'");
       while($t=mysql_fetch_array($tt))
       {
       ?>
              <?php
              if($t['sender']==$sender)
              {
				  ?>
			
              <li>
              <img src="myown/img/user.png" alt="img" class="img">
              <p class="ballon color1"><?php echo $t['matter'];?></p><br>
              </li>
              <?php
              if($t['reply']!=""){
				  ?>
              <li>
              <img src="myown/img/prathap.jpg" alt="img" class="img">
              <p class="ballon color2"><?php echo $t['reply'];?></p></li><?php } ?><br>
		 
              <?php
		  }
		  else
		  {?>
		  <li>
		     <img src="myown/img/prathap.jpg" alt="img" class="img">
             <p class="ballon color2"><?php echo $t['matter'];?></p>
             <br>
              </li>
		  <?php } ?>

<?php } ?>

          </ul>
          <!-- End Conv -->

          <div class="write">
              <form class="margin-b-20">
                <p><textarea class="textarea form-control wysihtml5-textarea" id="msg" placeholder="Enter text ..."  style="height:200px; width:100%;"></textarea></p>

                <a style='cursor:pointer;' class="btn btn-default" onclick="sendmsg()">Send</a>
                <span id="asd<?php echo $sno;?>"></span>
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
var sno=<?php echo $sno;?>;
$("#asd"+sno).html("<img src='myown/img/loading8.gif'>");	
if(confirm("Are you sure to send?")){
	$.post("logic/php/admin/sendmsguser.php",{sno:sno,msg:msg},function(data){if(data.indexOf("success")!=-1){alert("Sent!!");load_page("views/admin/viewmsg.php?sno="+sno);}else{alert(data);}});
}
}
</script>
 <?php
}
}
}
?>
