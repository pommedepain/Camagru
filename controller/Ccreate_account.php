<?php

require_once('../require.php');

if (isset($_POST["submit"]) && isset($_POST["pseudo"]) && isset($_POST["passwd1"]) && isset($_POST["passwd2"]) && isset($_POST["email"]))
{
	if ($_POST["submit"] == "submit" && !empty($_POST["pseudo"]) && !empty($_POST["passwd1"]) && !empty($_POST["passwd2"]) && !empty($_POST["email"]) && ($_POST["passwd1"] == $_POST["passwd2"]))
	{
		$db = new AccountManager();
		$pdo = $db->db_connect();

		if (preg_match_all(" #^[a-zA-Z0-9_]{3,16}$# ", $_POST["pseudo"]))
		{
			if ($db->pseudo_exists($pdo, $_POST["pseudo"]))
				echo "Pseudo already taken, please choose another.\n";
			else
			{
				echo "Pseudo OK\n";
				$pseudo = $_POST["pseudo"];
			}
		}
		else
			echo "Pseudo ERROR";
			
		if (isset($_POST["first_name"]) && !empty($_POST["first_name"]))
		{
			$first_name = $_POST["first_name"];
			echo "$first_name\n";
			if (preg_match_all(" #^[a-zA-Z-]{2,18}$# ", $_POST["first_name"]))
			{
				echo "First name OK\n";
				$first_name = $_POST["first_name"];
			}
			else
				echo "First name ERROR\n";
		}
		else
		{
			echo "First name is NULL\n";
			$first_name = NULL;
		}

		if (isset($_POST["last_name"]) && !empty($_POST["last_name"]))
		{
			if (preg_match_all(" #^[a-zA-Z-]{2,18}$# ", $_POST["last_name"]))
			{
				echo "Last name OK\n";
				$last_name =  $_POST["last_name"];
			}
			else
				echo "Last name ERROR\n";
		}
		else
		{
			echo "Last name is NULL\n";
			$last_name = NULL;
		}

		if (preg_match_all(" #^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])# ", $_POST["passwd1"]))
	   	{
			$passwd = hash("whirlpool", $_POST["passwd1"]);
			echo "Password OK\n";
		}
		else
			echo "Password ERROR\n";

		if (preg_match_all(" #^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$# ", $_POST["email"]))
		{
			echo "Mail OK\n";
			$email = $_POST["email"];
		}
		else
			echo "Mail ERROR\n";

		if ($pseudo && $passwd && $email)
			$db->send_register($pdo, $pseudo, $first_name, $last_name, $email, $passwd);
	}
}
