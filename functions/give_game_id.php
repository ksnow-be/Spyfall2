<?php
session_start();
if ($_SESSION['game_id'])
	echo $_SESSION['game_id'];
else
	echo 'false';
?>