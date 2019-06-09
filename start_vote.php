<?php
session_start();
$filename = 'vote/'.$_SESSION['game_id'].".csv";
if (file_exists($filename)) {
	$array = array();
	$mas = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$i = 0;
	if ($mas) {
		while ($mas[$i]) {
			$arr = explode(';', $mas[$i]);
			$lol = array($arr[0], $arr[1]);
			$array[$i] = $arr;
			$i++;
		}
	}
	echo json_encode($mas);
	return ;
}
echo "Ошибка!!!";
// header("Refresh:0 url=game.html")
?>