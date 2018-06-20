<meta http-equiv="refresh" content="5">
<?php

require_once("../../site-settings.php");
if(isloggedin())
{
if(1==1)
{
if(1==1)
{
?>
  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">Notifications</h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li class="active">Notifications</li>
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
					<tr><th colspan='2'><center>Notifications</center></th></tr>
			</tbody>
			</table>
            <table id="example" class="table display">
                <thead>
                    <tr>
                        <th>Notice ID</th>
                        <th>Title</th>
                        <th>sd/-</th>
                        <th>Views</th>
                        <th>Time</th>
                    </tr>
                </thead>
             
             
                <tbody>
				<?php
				$q=mysql_query("SELECT * FROM notifications WHERE visibility='1' ORDER BY nid DESC");
				while($w=mysql_fetch_array($q))
				{
					?>
					<tr>
                        <td><?php echo $w['nid'];?></td>
                        <td><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal2" onclick=shwno("<?php echo $w['nid'];?>")>
                    <?php echo $w['title'];if($w['added_date']==$date){echo "&nbsp;&nbsp;&nbsp;<span class='label label-danger'>New</span>";}?></a></td>
                        <td><?php echo $w['sd'];?></td>
                        <td><mark><?php echo $w['views'];?></mark></td>
                        <td><?php echo $w['time'];?></td>
                        
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
