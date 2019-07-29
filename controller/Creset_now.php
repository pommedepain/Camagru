<?php

require_once('../require.php');

if (isset($_POST["submit"]) && isset($_POST["passwd1"]) && isset($_POST["passwd2"]) && isset($_POST['rand_str']))
{
	if ($_POST["submit"] == "submit" && !empty($_POST['rand_str']) && !empty($_POST["passwd1"]) && !empty($_POST["passwd2"]) && $_POST["passwd1"] == $_POST["passwd2"])
	{
		$db = new AccountManager();
		$pdo = $db->db_connect();

		if (preg_match_all(" #^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]){6,}# ", $_POST["passwd1"])
			&& preg_match_all(" #^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]){6,}# ", $_POST["passwd2"]))
		{
			echo "passwd1 & passwd2 OK\n";
			$passwd = hash("whirlpool", $_POST["passwd1"]);
			echo $passwd . "\n";
		}
		else
			echo "passwd1 or passwd2 syntax ERROR";

		if ($passwd)
		{
			if (($res = $db->change_passwd_user($pdo, $passwd, $_POST['rand_str'])) === "change_passwd_user() OK")
			{
				echo "change_passwd_user() OK\n";
			}
			else
				echo "change_passwd_user() ERROR\n" . "res = " . $res;
		}
	}
	else
		echo "Combination ERROR\n";
}
