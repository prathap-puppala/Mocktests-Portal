<?php
require_once("../../../site-settings.php");

if(isadminloggedin())
{
if(isset($_POST['uid']) && !empty($_POST['uid']))
{
$uid=mysql_real_escape_string(strip_tags(trim($_POST['uid'])));
if($uid!="")
{
if($teckzitemode)
{
mysql_select_db($teckzitedb,$con);
$q=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$uid'"));
?>
 <table class="table" width="100%">
            <tbody>
              <tr class="active">
                <td>TZID</td>
                <td><b><?php echo $q['tzid'];?></b></td>
              </tr>
              <tr class="success">
                <td>Name</td>
                <td><b><?php echo $q['stuname'];?></b></td>
              </tr>
              <tr class="warning">
                <td>Year</td>
                <td><b><?php echo $q['year'];?></b></td>
              </tr>
              <tr class="danger">
                <td>Branch</td>
                <td><b><?php echo $q['branch'];?></b></td>
              </tr>
              <tr class="info">
                <td>Class</td>
                <td><b><?php echo $q['class'];?></b></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- End Panel -->
    
    <?php
}
else
{
$q=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE stuid='$uid'"));
?>

 <table class="table" width="100%">
            <tbody>
			
              <tr class="success">
                <td>ID</td>
                <td><b><?php echo $uid;?></b></td>
              </tr>
              <tr class="warning">
                <td>Name</td>
                <td><b><?php echo $q['name'];?></b></td>
              </tr>
              <tr class="danger">
                <td>Year</td>
                <td><b><?php echo $q['year'];?></b></td>
              </tr>
              <tr class="info">
                <td>Branch</td>
                <td><b><?php echo $q['branch'];?></b></td>
              </tr>
              <tr class="success">
                <td>Class</td>
                <td><b><?php echo $q['class'];?></b></td>
              </tr>
              
              <tr class="warning">
                <td>status</td>
                <td><b>
					<select id='usta' onchange="changeuserstate('<?php echo $uid;?>')">
					<?php 
                $arr=array("active","blocked","deactivated");
                foreach($arr as $f)
                {
				$se=($q['status']==$f)?"selected":"";
				echo "<option value='".$f."'".$se.">".$f."</option>";	
				}
                ?>
                </select></b></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- End Panel -->
    <?php
}

}	
}
}
?>
