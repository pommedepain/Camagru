<?php

require_once('../require.php');

if (isset($_POST["submit"]) && isset($_POST["pseudo"]) && isset($_POST["passwd1"]))
{
	if ($_POST["submit"] == "submit" && !empty($_POST["pseudo"]) && !empty($_POST["passwd1"]))
	{
		$db = new AccountManager();
		$pdo = $db->db_connect();

		if (preg_match_all(" #^[a-zA-Z0-9_]{3,16}$# ", $_POST["pseudo"]))
		{
			if ($db->pseudo_exists($pdo, $_POST["pseudo"]))
			{
				echo "Pseudo OK\n";
				$pseudo = $_POST["pseudo"];
			}
			else
				echo "Pseudo NOT IN DB\n";
		}
		else
			echo "Pseudo ERROR";

		if (preg_match_all(" #^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])# ", $_POST["passwd1"]))
	   	{
			$passwd = hash("whirlpool", $_POST["passwd1"]);
			if ($db->check_passwd($pdo, $pseudo, $passwd))
			{
				echo "Password OK\n";
				$success = "OK";
			}
			else
				echo "Wrong password\n";
		}
		else
			echo "Password ERROR\n";

		if ($pseudo && $success)
			$_SESSION['loggued_on_user'] = $_POST['pseudo'];
	}
}
