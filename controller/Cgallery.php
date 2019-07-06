<?php

require_once('../require.php');

if (isset($_POST["div"]))
{
	$db = new MontageManager();
	$pdo = $db->db_connect();

	if ($res = $db->get_all_photos($pdo))
	{
		$tab = array();
		$tab['id'] = $res[0]['id_user'];
		foreach ($res as $elem)
		{
			$tab['photo'][] = $elem['path_save'];
			$tab['creation'][] = $elem['creation_date'];
			$tab['likes'][] = $elem['likes'];
			$tab['comments'][] = $elem['comments'];
		}
		echo json_encode($tab);
	}
	else
		echo "get_all_photos() ERROR\n";
}
else
	echo "Nb arg ERROR\n";
