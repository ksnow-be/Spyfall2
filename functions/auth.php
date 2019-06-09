<?php
function auth($login, $pas)
{
	$data = file_get_contents("../private/passwd");
	$data = unserialize($data);
	$pas = hash('sha512', $pas);
	$i = 0;
	while ($data[$i])
	{
		$arr = $data[$i];
		if ($arr['login'] == $login)
			if ($arr['passwd'] == $pas)
				return (TRUE);
		$i++;
	}
	return (FALSE);
}
?>