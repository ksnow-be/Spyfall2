<?php
session_start();
$game_id = $_SESSION['game_id'];
$filename = '../private/games';
$data = file_get_contents($filename);
$data = unserialize($data);
$i = 0;
$filename1 = 'vote/'.$game_id.".csv";
if (!file_exists($filename1)) {
	while ($data[$i]) {
		if ($data[$i]['game_id'] == $game_id)
		{
			$arr = $data[$i];
			$data[$i]['ok'] = 'error';
			$j = 0;
			while ($arr[$j]) {
				file_put_contents($filename1, "0;".$arr[$j].PHP_EOL, FILE_APPEND);
				$j++;
			}
			break ;
		}
		$i++;
	}
}
$data1 = serialize($data);
$data = json_encode($data);
file_put_contents($filename, $data1);
print ($data);
return ($data);
?>