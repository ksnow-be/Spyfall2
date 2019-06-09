<?php
session_start();
include 'functions/check_sesion.php';
include 'functions/last_change.php';
include 'functions/check_game_with_me.php';
$filename = '../private/games';
function add_me($arr, $name, $l, $filename)
{
	$j = 0;
	while ($arr[$l][$j])
	{
		if ($arr[$l][$j] == $name)
			return ;
		$j++;
	}
	$arr[$l][$j] = $name;
	$arr[$l]['players']++;
	$arr = serialize($arr);
	file_put_contents($filename, $arr);
	check();
}
$game_id = $_GET['game_id'];
$name = $_SESSION['loggued_on_user'];
check_me($name);
if (($number = check_game_with_me($filename, $_SESSION['loggued_on_user'])) != 0)
{
	header("Refresh:2; url=lobbi.html?game_id=".$number);
	$_SESSION['game_id'] = $number;
	print($_SESSION['loggued_on_user']);
	echo "<h1>Вы уже в игре с ID asdfasdf".$number."!</h1>".PHP_EOL;
	return ;
}
if (!file_exists($filename))
{
	header("Refresh:2; url=main.html");
	echo "<h1>asdfasdfНет игры с таким ID! ID = ".$game_id."</h1>".PHP_EOL;
	return ;
}
$data = file_get_contents($filename);
$data = unserialize($data);
$i = 0;
while ($data[$i])
{
	if ($data[$i]['game_id'] == $game_id)
	{
		add_me($data, $name, $i, $filename);
		header('Refresh: 0; url=lobbi.html?game_id='.$game_id);
		$_SESSION['game_id'] = $game_id;
		return ;
	}
	$i++;
}
header('Refresh: 2; url=main.html');
echo "<h1>312312312Нет игры с таким ID! ID = ".$game_id."</h1>".PHP_EOL;
?>