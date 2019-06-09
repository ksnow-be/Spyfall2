<?php
function check_me($name)
{
	if ($name == NULL || $name == "")
	{
		header('Refresh:1; url=index.html');
		echo "Зарегистрируйтесь!!!".PHP_EOL;
		exit ;
	}
}
?>