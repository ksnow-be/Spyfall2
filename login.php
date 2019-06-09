<?php
session_start();
include 'functions/auth.php';
include 'functions/last_change.php';
$login = $_POST['login'];
$passw = $_POST['passwd'];
if (!file_exists("../private/passwd"))
{
	header("Refresh:2; url=index.html");
	echo "<h1>Registr plis!</h1>";
	exit ;
}
if (auth($login, $passw) == TRUE)
{
	$_SESSION['loggued_on_user'] = $login;
	check();
	header("Refresh:0; url=main.html");
}
else
{
	$_SESSION['loggued_on_user'] = "";
	header("Refresh:2; url=index.html");
	echo "<h1>Not right login or password</h1>"."\nlogin = ".$login.";\npasswd = ".$passw;
}
?>