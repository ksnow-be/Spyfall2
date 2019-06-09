<?php
session_start();
$game_id = $_GET['game_id'];
$filename = '../private/games';
$data = file_get_contents($filename);
$data = unserialize($data);
$i = 0;
$arr = NULL;
while ($data[$i]) {
	if ($data[$i]['game_id'] == $game_id)
	{
		$arr = $data[$i];
		break ;
	}
	$i++;
}
if ($arr == NULL)
	echo "Ошибка!".PHP_EOL;
else {
	$j = 0;
	while ($arr[$j])
	{
		echo "<p>".($j + 1).") ".$arr[$j]."</p>".PHP_EOL;
		$j++;
	}
}
?>