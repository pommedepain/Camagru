<?php

require_once('../require.php');

if (isset($_POST["submit"]) && isset($_POST["pseudo"]) && isset($_POST["passwd1"]) && isset($_POST["passwd2"]) && isset($_POST["email"]))
{
	if ($_POST["submit"] == "submit" && !empty($_POST["pseudo"]) && !empty($_POST["passwd1"]) && !empty($_POST["passwd2"]) 
		&& !empty($_POST["email"]) && ($_POST["passwd1"] == $_POST["passwd2"]))
	{
		$db = new AccountManager();
		$pdo = $db->db_connect();

		/* Check that the pseudo is at least 3 characters long and up to 16, and that it contains only lower cases, upper 
		cases or numbers. Everything else (like whitespaces) are forbidden */
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
			if (preg_match_all(" #^[a-zA-Z-àæéèêçàùûîïÀÆÉÈÊÇÀÛÙÜÎÏ]{2,18}$# ", $_POST["first_name"]))
			{
				echo "First name OK\n";
				$first_name = $_POST["first_name"];
			}
			else
			{
				$first_name = NULL;
				echo "First name ERROR\n";
			}
		}
		else
		{
			echo "First name is NULL\n";
			$first_name = "";
		}

		if (isset($_POST["last_name"]) && !empty($_POST["last_name"]))
		{
			if (preg_match_all(" #^[a-zA-Z-àæéèêçàùûîïÀÆÉÈÊÇÀÛÙÜÎÏ]{2,18}$# ", $_POST["last_name"]))
			{
				echo "Last name OK\n";
				$last_name =  $_POST["last_name"];
			}
			else
			{
				echo "Last name ERROR\n";
				$last_name = NULL;
			}
		}
		else
		{
			echo "Last name is NULL\n";
			$last_name = "";
		}

		/* Check that the password is at least 6 characters long (without any upper limit), and that it contains at least
		1 lower case, 1 upper case and 1 number. Everything else (like whitespaces) are forbidden */
		if (preg_match_all(" #^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]){6,}# ", $_POST["passwd1"]))
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

		/* If everything is valid, creates a unique key (that'll be later used to confirm the email while being sure of 
		the identity of the user), and send the confirmation email 
		[WARNING] Don't change the order of the function that sends the datas to db and the one that sends email, otherwise it won't work ! */
		if ($pseudo && $passwd && $email && isset($first_name) && isset($last_name))
		{
			$key = md5(rand(0, 100000));
			$db->send_register($pdo, $pseudo, $first_name, $last_name, $email, $passwd, $key);
			$subject = "[Camagru] Confirm your email";
			$header = "From: psentilh@student.42.fr";
			$message = "Welcome to Camagru !
			

To activate your account, please click on the link below or copy/paste it in your browser :
			
http://localhost:8080/index.php?action=confirm_mail&log=" . urlencode($pseudo) . "&key=" . urlencode($key) . "
			
			
---------------
This is an automatic message, please do not reply.";

			$success = mail($email, $subject, $message, $header);
			if (!$success)
				echo error_get_last()['message'];

		}
	}
}
