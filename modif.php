<?php

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
			return ($i);
		$i++;
	}
	return (-1);
}

function ft_update($usr, $old_pas, $new_pas)
{
	$old_pas = hash('sha512', $old_pas);
	if ($usr['passwd'] != $old_pas)
		ft_error(1);
	$new_pas = hash('sha512', $new_pas);
	$usr['passwd'] = $new_pas;
	return ($usr);
}

$log = $_POST['login'];
$old_pas = $_POST['oldpw'];
$new_pas = $_POST['newpw'];
$sub = $_POST['submit'];

if ($sub != "OK" || $new_pas == NULL || $new_pas == "" || $old_pas == NULL || $old_pas == "")
	ft_error(1);

$data = file_get_contents("../private/passwd");
$data = unserialize($data);
if (($num = ft_check($data, $log)) == -1)
	ft_error(1);

$data[$num] = ft_update($data[$num], $old_pas, $new_pas);
$new_data = serialize($data);
if (!file_put_contents("../private/passwd", $new_data))
	ft_error(1);
header("Location: index.html");
// header("Refresh:2; url=index.html");
// echo "OK";
?>