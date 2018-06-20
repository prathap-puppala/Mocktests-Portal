<?php
session_start();
if(isset($_SESSION['Exam']) && !empty($_SESSION['Exam']))
{
unset($_SESSION['Exam']);
}

echo "<center><h2>Your Personal Time for this exam is Over</h2></center>";

?>
