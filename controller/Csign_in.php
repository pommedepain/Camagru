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
				if ($res = $db->get_user_infos($pdo, $pseudo))
				{
					//print_r($res);
					$_SESSION['user'] = $res['pseudo'];
					$_SESSION['email'] = $res['email'];
					$_SESSION['first_name'] = $res['firstname'];
					$_SESSION['last_name'] = $res['lastname'];
					$_SESSION['group'] = $res['group'];
					echo $_SESSION['user'] . "\n";
					echo $_SESSION['email'] . "\n";
					echo $_SESSION['first_name'] . "\n";
					echo $_SESSION['last_name'] . "\n";
					echo $_SESSION['group'] . "\n";
				}
				else
					echo "ERROR with get_info_user\n";				
			}
			else
				echo "Password wrong ERROR\n";
		}
		else
			echo "Password ERROR\n";
	}
}
else
	echo "Combination ERROR\n";
