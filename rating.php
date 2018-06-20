<?php 
require("site-settings.php");
if(isloggedin()){
mysql_select_db($dbname,$con);$q=mysql_query("SELECT * FROM site_rating WHERE stuid='".$_SESSION['userid']."'");?>
<center>
<span id='ratel'></span>
<table>
<tr><td>
<img src="myown/img/like.png" width="100px" style="cursor:pointer;" onclick="dorating('like')">
&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;
<img src="myown/img/dislike.png" width="123px" style="cursor:pointer;" onclick="dorating('dislike')">
</td></tr>
<tr><td>
<center><h5 style="font-weight:bold;font-family:Arial;"><?php echo mysql_num_rows(mysql_query("SELECT * FROM site_rating WHERE status='like'"))." Likes";?></h5><center>
</td><td>
<center><h5 style="font-weight:bold;font-family:Arial;"><?php echo mysql_num_rows(mysql_query("SELECT * FROM site_rating WHERE status='dislike'"))." Dislikes";?></h5><center>

</td></tr></table>
</center>
<?php } ?>
