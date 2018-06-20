<style>
#customers {
	text-align:center;
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
}

#customers tr th{
	text-align:center;
}
#customers td, #customers th {
    font-size: 1em;
    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;
}

#customers th {
    font-size: 1.1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #A7C942;
    color: #ffffff;
}

#customers tr.alt td {
    color: #000000;
    background-color: #EAF2D3;
}
</style>

<?php
require_once("../../../site-settings.php");

if(isadminloggedin())
{
if(isset($_GET['uid']) && !empty($_GET['uid']))
{
$uid=mysql_real_escape_string(strip_tags(trim($_GET['uid'])));
if($uid!="")
{
$q=mysql_query("SELECT * FROM examdetails WHERE visibility='1'");
echo "<table id='customers'><tr><th>Exam Title</th><th>Date</th><th>Login Time</th><th>Submit Time</th><th>Status</th><th>Ip</th><th>Action</th></tr>";
$nu=0;
while($qw=mysql_fetch_array($q))
{
$sno=$qw['sno'];
$tab=$qw['tkey'];
$title=$qw['title'];
$date=$qw['date'];
mysql_select_db("quiz_exams",$con);
$w=mysql_query("SELECT * FROM $tab WHERE ID='$uid' && status='Y'");
if(mysql_num_rows($w)>=1)
{
$nu++;
$cl=($nu%2==0)?"alt":"";
$rr=mysql_fetch_array($w);
echo "<tr class=".$cl." id='qwe".$nu."'><td>".$title."</td><td>".$date."</td><td>".$rr['Logintime']."</td><td>".$rr['Submittime']."</td><td>".$rr['status']."</td><td>".$rr['IP']."</td><td><a onclick=rem('".$uid."','".$sno."','".$nu."') class='btn btn-danger' style='cursor:pointer;'><i class='fa fa-scissors'></i>Delete</a><span id='asd".$nu."'></span></td></tr>";
}
}
echo "</table";
}	
}
}
?>
