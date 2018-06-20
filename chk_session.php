<?php
require_once("site-settings.php");

if(isloggedin())
{
	//session expired
	echo "0";
} else {
	//session not expired
    echo "1";
}
?>
