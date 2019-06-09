<?php
session_start();
include 'functions/give_map.php';
$name = $_SESSION['loggued_on_user'];
$game_id = $_GET['game_id'];
$filename = '../private/games';
$data = file_get_contents($filename);
$data = unserialize($data);
$i = 0;
while ($data[$i]) {
	if ($data[$i]['game_id'] == $game_id) {
		give_map($data[$i], $name);
	}
	$i++;
}
?>