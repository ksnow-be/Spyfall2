<?php
session_start();
function check() {
	$filename = '../private/games';
	if (file_exists($filename))
		$_SESSION['last_change'] = filemtime($filename);
	else
	{
		header('Refresh:0; url=main.html');
		// echo "Нет файла с играми! проверьте ../private/games".PHP_EOL;
		exit ;
	}
}
?>