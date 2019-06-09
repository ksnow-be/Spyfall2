<?php
session_start();
include 'functions/last_change.php';
$filename = "../private/games";
$last = $_SESSION['last_change'];
$now = filemtime($filename);
if ($now != $last)
{
	echo "true";
	check();
	return ;
}
echo "false";
?>