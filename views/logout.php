<?php
session_start();
if(isset($_SESSION['userid']) && !empty($_SESSION['userid']))
{
unset($_SESSION['userid']);
if(isset($_SESSION['admin']) && !empty($_SESSION['admin']))
{
unset($_SESSION['admin']);
}
if(isset($_SESSION['Exam']) && !empty($_SESSION['Exam']))
{
unset($_SESSION['Exam']);
}
session_destroy();
}

echo "<center><h2>Redirecting to Home page....</h2></center>";
header("location:../index");
?>
