<?php

require_once('../require.php');

if (isset($_POST["pseudo"]) && isset($_POST["photo"]) && isset($_POST['comment']))
{
	if (isset($_SESSION['user']))
	{
		if (!empty($_POST["photo"]) && !empty($_POST["pseudo"]) && !empty($_POST['comment']) && !empty($_SESSION['user']))
		{
			if (preg_match_all(" #^[a-zA-Z0-9_\-@\"'()!?,;. :\/\$€*\#=%^àæéèêçàùûîïÀÆÉÈÊÇÀÛÙÜÎÏ]{1,1000}$# ", $_POST['comment']))
			{
				$db = new MontageManager();
				$pdo = $db->db_connect();
				$photo = str_replace("http://localhost:8080/", "../", $_POST['photo']);
				$pseudo = str_replace("@", "", $_POST['pseudo']);

				if (!$db->alter_comments($pdo, $photo))
					echo "alter_comments() ERROR|\n";
				else
					echo "alter_comments() SUCCESS\n";

				if (!$db->user_activity_comments($pdo, $photo, $_SESSION['user']))
					echo "user_activity_comments() ERROR|\n";
				else
					echo "user_activity_comments() SUCCESS\n" .  $_SESSION['user'];

				if (!$db->register_comment($pdo, $_SESSION['user'], $photo, $_POST['comment']))
					echo "register_comment() ERROR\n";
				else
					echo "register_comment() SUCCESS\n";
			}
			else
				echo "comment regex ERROR\n";
		}
	}
	else
		echo "User not loggued in !\n";
}
else
	echo "Nb arg ERROR\n";
