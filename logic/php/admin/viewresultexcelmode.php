<meta http-equiv="refresh" content="5">
<?php

require_once("../../../site-settings.php");
if(isadminloggedin())
{
if(isset($_GET['sno']))
{
$sno=mysql_real_escape_string(strip_tags(trim($_GET['sno'])));
$q=mysql_query("SELECT * FROM examdetails WHERE sno='$sno' and answersmode='answersafterexamexcel'");

if(mysql_num_rows($q)>=1)
{
$gg=mysql_fetch_array($q);
?>
  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title"><b style='color:red;'><?php echo $gg['title']."</b> Results view";?></h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li><a href="#">Result</a></li>
        <li class="active">Result view</li>
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

      
<div class="row">

    <!-- Start Panel -->
    <div class="col-md-12">
      <div class="panel panel-default">
        
        <div class="panel-body table-responsive">
   <table  width="100%" style="text-align:justify;" class="table table-bordered table-striped">
                <tbody>
					<tr><th colspan='2'><center> <b style='color:red;'><?php echo $gg['title']." Results View";?> </b> </center></th></tr>
			</tbody>
			</table>
            
             <table  width="100%" style="text-align:justify;" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Questions</th>
                        <th>Attempted</th>
                        <th>Not Attempted</th>
                        <th>Login Time</th>
                        <th>Status</th>
                        <th>Submit Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                
                <tbody>
				<?php
					$tab=$gg['tkey'];
					$que=$gg['questions'];
					mysql_select_db("quiz_exams",$con);
					$t=mysql_query("SELECT * FROM $tab WHERE status='Y'");
					$h=0;
					while($pp=mysql_fetch_array($t))
					{
					$h++;
					$ii=$pp['ID'];
					?>
				<tr id="qwe<?php echo $ii;?>">        
				  <td><?php echo $pp['ID'];?></td>
				  <td><?php echo $que;?></td>
				  <td><?php 
				  $atem=0;
				  $noatem=0;
				   $dd=mysql_fetch_array(mysql_query("SELECT * FROM $tab WHERE ID='$ii'"));
				  
				  for($i=1;$i<=$que;$i++)
				  {
					if($dd['Q'.$i]!=NULL){$atem++;}
					else{$noatem++;}
					}
				echo $atem;
				  ?></td>
				  <td><?php echo $noatem;?></td>
				  <td><?php echo $pp['Logintime'];?></td>
				  <td><?php echo $pp['status'];?></td>
				  <td><?php echo $pp['Submittime'];?></td>
				  <td>
				    <a class="btn btn-primary" style='cursor:pointer;'  onclick="rm('<?php echo $ii;?>','<?php echo $sno;?>')" title="Remove"><i class="fa fa-scissors"></i></a>
				  <?php if($gg['validations']>0){?>  <a class="btn btn-primary" style='cursor:pointer;'  onclick="re('<?php echo $ii;?>','<?php echo $sno;?>')" title="Re-validate"><i class="fa fa-binoculars"></i></a><?php } ?>
   <span id="asd<?php echo $ii;?>"></span>
				  </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>


        </div>

      </div>
    </div>
    <!-- End Panel -->
    </div>
    
    
            <!-- Modal -->
            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="uid"></h4>
                  </div>
                  <div class="modal-body" id="opt">
                    ...
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

          <!-- End Moda Code -->
          
    <script src="js/datatables/datatables.min.js"></script>
    
    <?php } } } ?>
