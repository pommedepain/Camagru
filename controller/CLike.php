<?php

require_once('../require.php');

if (isset($_POST["pseudo"]) && isset($_POST["photo"]) && isset($_POST['like']) 
	&& !empty($_POST["photo"]) && !empty($_POST["pseudo"]) && !empty($_POST['like']))
{
	$db = new MontageManager();
	$pdo = $db->db_connect();
	$photo = str_replace("http://localhost:8080/", "../", $_POST['photo']);
	$pseudo = str_replace("@", "", $_POST['pseudo']);

	if (($_POST['like'] === "liked" || $_POST['like'] === "unliked") && isset($_SESSION['user']))
	{	
		if (!($ret = $db->user_activity_like($pdo, $photo, $_POST['like'], $_SESSION['user'])))
			echo "\nuser_activity_like() ERROR|\n" . $_SESSION['user'] . "\n";
		else if ($ret === "Photo already " . $_POST['like'] . " by " . $_SESSION['user'])
			echo "$ret\n";
		else if ($ret === true)
		{
			echo "\nuser_activity_like() SUCCESS\n" .  $_SESSION['user'] . "\n";
			if (!$db->alter_like($pdo, $photo, $_POST['like']))
				echo "alter_like() ERROR|\n";
			else
				echo "alter_like() SUCCESS: $photo == " . $_POST['like'];
		}

		$db2 = new AccountManager();
		$pdo2 = $db2->db_connect();
		if (!($return = $db2->get_user_infos($pdo2, $pseudo)))
			echo "get_user_infos() ERROR\n";
		else if ($return['notifications'] === 1)
		{
			$email = $return['email'];
			$subject = "[Camagru] Like notfication";
			$header = "From: psentilh@student.42.fr";
			$message = "Hello,
			
" . $_SESSION['user'] . " " . $_POST['like'] . " your photo. 
			
			
---------------
This is an automatic message, please do not reply.";

			$success = mail($email, $subject, $message, $header);
			if (!$success)
				echo error_get_last()['message'];
			else
				echo "\nemail notif like done and successfull\n";
		}
	}
	else if (!isset($_SESSION['user']) || empty($_SESSION['user']))
		echo "User not loggued in !\n";
	else
		echo "like definition ERROR\n";
}
else
	echo "Nb arg ERROR\n";
