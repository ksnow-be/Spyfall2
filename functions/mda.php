<?php
session_start();
$adm = $_SESSION['my_game'];
if ($adm == "true")
	echo "true";
return ;
?>