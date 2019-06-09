<?php
session_start();
function give_map($arr, $name) {
$output = array();
$filename = $arr['maps'][$arr['current']];
if (file_exists($filename))
{
	$array = array();
	$mas = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	if ($mas) {
		foreach($mas as $value) {
			$lol = explode(';', $value);
			$array[$lol[0]] = $lol[1];
		}
		$output += ['img'=>$array['img']];
		$output += ['loc'=>$array['name']];
	}
}
$j = 0;
while ($arr[$j]) {
	if ($arr[$j] == $name) {
		if ($arr['roles'][$j] == 'Шпион') {
			$output['img'] = 'pics/LOGO.png';
			unset($output['loc']);
		}
		$output += ['role'=>$arr['roles'][$j]];
		echo json_encode($output);
		exit ;
	}
	$j++;
}
echo "not_found";
exit ;
}
?>