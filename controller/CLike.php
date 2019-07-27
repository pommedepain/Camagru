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
			echo "\nuser_activity_like() ERROR|\n" . $_SESSION['user'];
		else if ($ret === "Photo already " . $_POST['like'] . " by " . $_SESSION['user'])
			echo "$ret\n";
		else if ($ret === true)
		{
			echo "\nuser_activity_like() SUCCESS\n" .  $_SESSION['user'];
			if (!$db->alter_like($pdo, $photo, $_POST['like']))
				echo "alter_like() ERROR|\n";
			else
				echo "alter_like() SUCCESS: $photo == " . $_POST['like'];
		}
		// echo "\n$ret\n";
		//print_r($ret);
	}
	else if (!isset($_SESSION['user']) || empty($_SESSION['user']))
		echo "User not loggued in !\n";
	else
		echo "like definition ERROR\n";
}
else
	echo "Nb arg ERROR\n";
