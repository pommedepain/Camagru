<?php

require_once('../require.php');

if (isset($_POST['pseudo']) && isset($_POST['key']))
{
	if (!empty($_POST['pseudo']) && !empty($_POST['key']))
	{
		$db = new AccountManager();
		$pdo = $db->db_connect();

		if ($db->pseudo_exists($pdo, $_POST['pseudo']))
		{
			echo "pseudo = /" . $_POST['pseudo'] . "/";
			if ($db->match_key($pdo, $_POST['pseudo'], $_POST['key']))
				echo "It's a match !\n";
		}
		else
			echo "ERROR\n";
	}
}
