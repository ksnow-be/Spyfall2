<?php
function check_game_with_me($filename, $name) {
	if (!file_exists($filename))
		return (0);
	$data = file_get_contents($filename);
	$data = unserialize($data);
	$i = 0;
	while ($data[$i]) {
		foreach ($data[$i] as $val)
			if ($val === $name) {
				return ($data[$i]['game_id']);
			}
		$i++;
	}
}
?>