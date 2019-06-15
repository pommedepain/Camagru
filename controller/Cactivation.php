<?php

require_once('../require.php');

if (isset($_POST['anonym_id']) && isset($_POST['key']))
{
	if (!empty($_POST['anonym_id']) && !empty($_POST['key']))
	{
		$db = new AccountManager();
		$pdo = $db->db_connect();

		if ($db->match_key($pdo, $_POST['anonym_id'], $_POST['key']))
		{
			$res = ($db->conf_mail($pdo, $_POST['anonym_id'], $_POST['key']));
			echo $res;
		}
		else
			echo "ERROR\n";
	}
}
