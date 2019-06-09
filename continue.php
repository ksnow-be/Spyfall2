<?php
session_start();
$game_id = $_SESSION['game_id'];
$filename = '../private/games';
$data = file_get_contents($filename);
$data = unserialize($data);
$i = 0;
while ($data[$i])
{
	if ($data[$i]['game_id'] == $game_id)
	{
		$data[$i]['ok'] = 'ok';
		$data[$i]['current']++;
		unset($data[$i]['roles']);
		break ;
	}
	$i++;
}
if (file_exists('vote/'.$game_id.".csv"))
	unlink('vote/'.$game_id.".csv");
// print_r($data);
$data = serialize($data);
file_put_contents($filename, $data);
header("Refresh:0; url=start.php");
?>