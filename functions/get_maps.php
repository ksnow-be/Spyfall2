<?php
function get_maps() {
	$filename = 'Maps/MAPS.csv';
	if (file_exists($filename))
	{
		$array = array();
		$mas = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$i = 0;
		while ($mas[$i]) {
			$i++;
		}
		shuffle($mas);
		return ($mas);
	}
	return false;
}
?>