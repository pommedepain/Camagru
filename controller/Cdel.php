<?php

require_once('../require.php');

if (isset($_POST["photo"]))
{
	if (!empty($_POST["photo"]))
	{
		$db = new MontageManager();
		$pdo = $db->db_connect();

		if (isset($_SESSION['user']) && !empty($_SESSION['user']))
		{
			$path = "../public/img/photos_user/" . $_POST["photo"];

			if ($res = $db->del_photo_usr($pdo, $_SESSION['user'], $path))
			{
				echo "OK\n";
			}
		}
		else if (!isset($_SESSION['user']) || empty($_SESSION['user']))
			echo "user not loggued ERROR\n";
		else
			echo "del_photo_usr() ERROR\n";
	}
	else
		echo "no photo name ERROR\n";
}
else
	echo "Nb arg ERROR\n";
