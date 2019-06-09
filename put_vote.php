<?php
session_start();

function change_my_vote($id, $filename) {
	$old_id = $_SESSION['my_choice'];
	if ($id == $old_id)
		exit ;
	$_SESSION['my_choice'] = $id;
	if (file_exists($filename))
	{
		$line = "";
		$mas = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$num = $mas[$id];
		$arr = explode(';', $num);
		$arr[0]++;
		$mas[$id] = $arr[0].";".$arr[1];
		$num = $mas[$old_id];
		$arr = explode(';', $num);
		$arr[0]--;
		$mas[$old_id] = $arr[0].";".$arr[1];
		print_r($mas);
		foreach($mas as $value) {
			$line .= $value.PHP_EOL;
		}
		file_put_contents($filename, $line);
	}
	exit ;
}

$filename = 'vote/'.$_SESSION['game_id'].".csv";
$id = $_GET['id'];
if ($_SESSION['num_vote'] == 0)
	change_my_vote($id, $filename);
$_SESSION['num_vote'] = 0;
$_SESSION['my_choice'] = $id;
if (file_exists($filename))
{
	$line = "";
	$mas = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$num = $mas[$id];
	$arr = explode(';', $num);
	$arr[0]++;
	$mas[$id] = $arr[0].";".$arr[1];
	// print_r($mas);
	foreach($mas as $value) {
		$line .= $value.PHP_EOL;
	}
	file_put_contents($filename, $line);
}
?>