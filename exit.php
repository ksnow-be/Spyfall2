<?php
session_start();
include 'functions/last_change.php';
$filename = '../private/games';
$game_id = $_SESSION['game_id'];
$my_name = $_SESSION['loggued_on_user'];
$data = file_get_contents($filename);
$data = unserialize($data);
$i = 0;
while ($data[$i])
{
	if ($data[$i]['game_id'] == $game_id)
	{
		if ($_SESSION['my_game'] == "true")
		{
			unset($data[$i]);
			$data = array_values($data);
			unset($_SESSION['my_game']);
			if (file_exists('vote/'.$game_id.".csv"))
				unlink('vote/'.$game_id.".csv");
		}
		else
		{
			$j = 0;
			$k = -1;
			$lol = 0;
			while ($data[$i][$j])
			{
				if ($lol == 1)
				{
					$data[$i][$k] = $data[$i][$j];
					unset($data[$i][$j]);
				}
				if ($data[$i][$j] == $my_name)
				{
					$lol = 1;
					unset($data[$i][$j]);
				}
				$j++;
				$k++;
			}
			$data[$i]['players']--;
		}
		$data = serialize($data);
		file_put_contents($filename, $data);
		header('Refresh:0; url=main.html');
		check();
		$_SESSION['game_id'] = "";
		return ;
	}
	$i++;
}
echo "Ошибка!".PHP_EOL;
?>