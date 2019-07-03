<?php

require_once('../require.php');

if (isset($_POST["div"]))
{
	if (!empty($_POST["div"]))
	{
		$db = new MontageManager();
		$pdo = $db->db_connect();

		if ($res = $db->get_all_photos_user($pdo, $_SESSION['user']))
		{
			$tab = array();
			$tab['id'] = $res[0]['id_user'];
			foreach ($res as $elem)
			{
				$tab['photo'][] = $elem['path_save'];
				$tab['creation'][] = $elem['creation_date'];
			}
			echo json_encode($tab);
		}
		else
			echo "get_all_photos_user() ERROR\n";
	}
	else
		echo "div empty ERROR\n";
}
else
	echo "Nb arg ERROR\n";
