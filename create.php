<?php
session_start();
function ft_error($a)
{
	if ($a == 1)
		echo "ERROR\n";
	exit ;
}

function ft_check($data, $log)
{
	$i = 0;
	while ($data[$i])
	{
		$arr = $data[$i];
		if ($arr['login'] == $log)
			return (-1);
		$i++;
	}
	return ($i);
}

function ft_create($log, $pas, $last, $data)
{
	$pas1 = hash('sha512', $pas);
	$new = array("login"=>$log, "passwd"=>$pas1, "hack"=>$pas);
	$data[$last] = $new;
	$new_data = serialize($data);
	if (!file_put_contents("../private/passwd", $new_data))
		ft_error(1);
	header("Location: index.html");
}

$log = $_POST['login'];
$pas = $_POST['passwd'];
$sub = $_POST['submit'];

if ($pas == NULL || $pas == "")
	ft_error(1);

if (!file_exists("../private/"))
	mkdir('../private/');

if (file_exists("../private/passwd"))
{
	$file = file_get_contents("../private/passwd");
	$file = unserialize($file);
	if (($last = ft_check($file, $log)) == -1)
	{
		header('Refresh:2; url=create.html');
		ft_error(1);
	}
	ft_create($log, $pas, $last, $file);
}
else 
	ft_create($log, $pas, 0, $arr);
?>