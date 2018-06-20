<?php

require_once("../../site-settings.php");
if(isadminloggedin())
{
?>

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">Delete Notice</h1>
      <ol class="breadcrumb">
        <li><a href="index">Dashboard</a></li>
        <li><a href="#">Delete</a></li>
        <li class="active">Notice</li>
      </ol>
      </div>
      
<div class="row">

    <!-- Start Panel -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-title">
          <b style='color:red;'>Notices</b>
                  </div>
        <div class="panel-body table-responsive">

            <table id="Noticeple" class="table display">
                <thead>
                    <tr>
                        <th>Notice ID</th>
                        <th>Title</th>
                        <th>sd/-</th>
                        <th>views</th>
                        <th>Posted</th>
                        <th>Delete</th>
                    </tr>
                </thead>
             
             
                <tbody>
				<?php
				$q=mysql_query("SELECT * FROM notifications WHERE visibility='1'");
			    
				while($w=mysql_fetch_array($q))
				{
				$sno=$w['nid'];
					?>
                    <tr id="qwe<?php echo $w['nid'];?>">
                        <td><?php echo $w['nid'];?></td>
                        <td><?php echo $w['title'];?></td>
                        <td><?php echo $w['sd'];?></td>
                        <td><?php echo $w['views'];?></td>
                        <td><?php echo $w['time'];?></td>
                       
                        <td>
                        <a class="btn btn-primary" style='cursor:pointer;' onclick="del('<?php echo $sno;?>')"><i class="fa fa-scissors"></i>Delete</a>
                        <span id="asd<?php echo $sno;?>"></span>
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
    
        
    
    <script src="js/datatables/datatables.min.js"></script>
    
    <?php } ?>
