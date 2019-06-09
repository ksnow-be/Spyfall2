<?php
session_start();
include 'functions/check_game_with_me.php';
include 'functions/check_sesion.php';
include 'functions/last_change.php';
include 'functions/get_maps.php';

$filename = '../private/games';
$my_name = $_SESSION['loggued_on_user'];
check_me($my_name);
if (($number = check_game_with_me($filename, $_SESSION['loggued_on_user'])) != 0)
{
	header("Refresh:2; url=lobbi.html?game_id=".$number);
	$_SESSION['game_id'] = $number;
	echo "<h1>Вы уже в игре с ID ".$number."!</h1>".PHP_EOL;
	return ;
}
if (!file_exists($filename))
	$newGame = rand(1000, 9999);
else {
	$data = file_get_contents($filename);
	$games = unserialize($data);
	$newGame = rand(1000, 9999);
}
if (($maps = get_maps()) == false)
	header("Refresh:0; url=main.html");
$players = array('game_id'=>$newGame, $my_name, 'maps'=>$maps, 'current'=>0, 'players'=>1);
$_SESSION['game_id'] = $newGame;
$_SESSION['my_game'] = "true";
if (isset($games))
{
	$i = 0;
	while ($games[$i])
		$i++;
	$games[$i] = $players;
}
else
	$games = array($players);
$games = serialize($games);
file_put_contents($filename, $games);
check();
header("Refresh:0; url=lobbi.html?game_id=".$newGame);
?>