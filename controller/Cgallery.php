<?php

require_once('../require.php');

if (isset($_POST["div"]))
{
	$db = new MontageManager();
	$pdo = $db->db_connect();

	if ($res = $db->get_all_photos($pdo))
	{
		$tab = array();
		foreach ($res as $elem)
		{
			$tab['id'][] = $elem['id_user'];
			$tab['pseudo'][] = $elem['pseudo'];
			$tab['photo'][] = $elem['path_save'];
			$tab['creation'][] = $elem['creation_date'];
			$tab['likes'][] = $elem['likes'];
			$tab['comments'][] = $elem['comments'];
		}
		echo json_encode($tab);
		//print_r($res);
	}
	else
		echo "get_all_photos() ERROR\n";
}
else if (isset($_POST['activity']))
{
	if (!empty($_POST['activity']) && $_POST['activity'] === "get")
	{
		$db = new MontageManager();
		$pdo = $db->db_connect();

		if (!empty($ret = $db->get_all_activity($pdo)))
		{
			$tab2 = array();
			foreach ($ret as $element)
			{
				$tab2['id'][] = $element['id_user'];
				$tab2['pseudo'][] = $element['pseudo'];
				$tab2['photo'][] = $element['path_save'];
				$tab2['from'][] = $element['From'];
				$tab2['liked'][] = $element['liked'];
				$tab2['comment'][] = $element['comment'];
			}
			echo json_encode($tab2);
		}
		else if (empty($ret))
			echo "No activity to display\n";
		else
			echo "get_all_activity() went wrong ERROR\n";
	}
}
else
	echo "Nb arg ERROR\n";
