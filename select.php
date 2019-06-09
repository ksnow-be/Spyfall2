<?php
session_start();
function check_ok($arr) {
	if ($arr['ok'] == NULL || $arr['ok'] == "")
		return ;
	echo "true";
	exit ;
}
$game_id = $_SESSION['game_id'];
$filename = '../private/games';
if (file_exists($filename))
{
	$array = array();
	$mas = file_get_contents($filename);
	$mas = unserialize($mas);
	if ($mas) {
		$i = 0;
		while ($mas[$i])
		{
			if ($mas[$i]['game_id'] == $game_id)
			{
				$arr = $mas[$i];
				check_ok($arr);
				unset($arr['game_id']);
				unset($arr['maps']);
				unset($arr['current']);
				break;
			}
			$i++;
		}
	}
	if ($arr)
		echo json_encode($arr);
	else
		echo "false";
}
?>