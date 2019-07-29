<?php

require_once('../require.php');

if (isset($_POST["submit"]))
{
	if ($_POST["submit"] == "submit")
	{
		echo "Cmanage_account triggered\n";
		$db = new AccountManager();
		$pdo = $db->db_connect();

		/* Check that the pseudo is at least 3 characters long and up to 16, and that it contains only lower cases, upper 
		cases or numbers. Everything else (like whitespaces) are forbidden */
		if (isset($_POST["pseudo"]) && !empty($_POST["pseudo"]))
		{	
			if (preg_match_all(" #^[a-zA-Z0-9_]{3,16}$# ", $_POST["pseudo"]))
			{
				if ($_POST["pseudo"] == $_SESSION['user'])
					$pseudo = $_SESSION['user'];
				else if ($db->pseudo_exists($pdo, $_POST["pseudo"]))
					echo "Pseudo already taken, please choose another.\n";
				else
				{
					echo "New Pseudo available\n";
					$pseudo = $_POST["pseudo"];
				}
				if (is_numeric($id = $db->id_exists($pdo, $_SESSION['user'])))
					echo "ID found\n";
				else
					echo "ID ERROR\n";
			}
			else
				echo "Pseudo ERROR";
		}
			
		if (isset($_POST["first_name"]) && !empty($_POST["first_name"]))
		{
			if (preg_match_all(" #^[a-zA-Z-àæéèêçàùûîïÀÆÉÈÊÇÀÛÙÜÎÏ]{2,18}$# ", $_POST["first_name"]))
			{
				echo "First name OK\n";
				$first_name = $_POST["first_name"];
			}
			else
			{
				$first_name = "";
				echo "First name not defined\n";
			}
		}

		if (isset($_POST["last_name"]) && !empty($_POST["last_name"]))
		{
			if (preg_match_all(" #^[a-zA-Z-àæéèêçàùûîïÀÆÉÈÊÇÀÛÙÜÎÏ ]{2,18}$# ", $_POST["last_name"]))
			{
				echo "Last name OK\n";
				$last_name =  $_POST["last_name"];
			}
			else
			{
				echo "Last name not defined\n";
				$last_name = "";
			}
		}

		/* Check that the password is at least 6 characters long (without any upper limit), and that it contains at least
		1 lower case, 1 upper case and 1 number. Everything else (like whitespaces) are forbidden */
		if (isset($_POST["o_passwd"]) && isset($_POST["passwd1"]) && isset($_POST["passwd2"]))
		{
			if (!empty($_POST["o_passwd"]) && !empty($_POST["passwd1"]) && !empty($_POST["passwd2"]) && $_POST["passwd1"] === $_POST["passwd2"])
			{
				if ($_POST["o_passwd"] !== $_POST["passwd1"])
				{
					if (preg_match_all(" #^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]){6,}# ", $_POST["o_passwd"])
						&& preg_match_all(" #^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]){6,}# ", $_POST["passwd1"])
						&& preg_match_all(" #^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]){6,}# ", $_POST["passwd2"]))
	   				{
						$o_passwd = hash("whirlpool", $_POST["o_passwd"]);
						if ($db->check_passwd($pdo, $_SESSION['user'], $o_passwd))
						{
							$passwd = hash("whirlpool", $_POST["passwd1"]);
							echo "New Password OK\n";
						}
						else
							echo "New Password ERROR\n";
					}
					else
						echo "Password syntax ERROR\n";
				}
				else
					echo "Same old and new password ERROR\n";
			}
			else if (!empty($_POST["o_passwd"]) && !empty($_POST["passwd1"]) && !empty($_POST["passwd2"]) && $_POST["passwd1"] !== $_POST["passwd2"])
				echo "New passwords don't match ERROR\n";
		}

		if (isset($_POST['email']) && !empty($_POST['email']))
		{
			if (preg_match_all(" #^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$# ", $_POST['email']))
			{
				if ($_SESSION['email'] != $_POST['email'])
				{
					echo "New Mail OK\n";
					$email = $_POST['email'];
					$group = "not_confirmed";
					echo "group = " . $group . "\n";
					$anonym_id = md5(rand(0, 100000));
					$key = md5(rand(0, 100000));
					if ($db->update_email_table($pdo, $_SESSION['user'], $anonym_id, $key) != "update_email_table worked")
						echo "ERROR update_email_table\n";
					$subject = "[Camagru] Confirm your email";
					$header = "From: psentilh@student.42.fr";
					$message = "Hello,
			

To activate your new email and account, please click on the link below or copy/paste it in your browser :
			
http://localhost:8080/index.php?action=confirm_mail&log=" . urlencode($anonym_id) . "&key=" . urlencode($key) . "
			
			
---------------
This is an automatic message, please do not reply.";

					$success = mail($email, $subject, $message, $header);
					if (!$success)
						echo error_get_last()['message'];
				}
				else
					$email = $_SESSION['email'];
			}
			else
				echo "Mail syntax ERROR\n";
		}

		if (isset($_POST['state']) && !empty($_POST['state']))
		{
			if (!($return = $db->notif_email($pdo, $_POST['state'], $_SESSION['user'])))
				echo "notif_email() ERROR\n";
			else
				echo "notif_email() SUCCESS\n";
		}

		/* If everything is valid, creates a unique key (that'll be later used to confirm the email while being sure of 
		the identity of the user), and send the confirmation email 
		[WARNING] Don't change the order of the function that sends the datas to db and the one that sends email, otherwise it won't work ! */
		if ($pseudo && $email)
		{
			if ($group)
				$group = $group;
			else
				$group = $_POST['group'];
			if (!($db->change_user_infos($pdo, $pseudo, $first_name, $last_name, $email, $passwd, $group, $id)))
				echo "ERROR with change_user_infos\n";
			else
			{
				$_SESSION['user'] = $pseudo;
				$_SESSION['email'] = $email;
				$_SESSION['first_name'] = $first_name;
				$_SESSION['last_name'] = $last_name;
				if ($group)
					$_SESSION['group'] = $group;
				echo "change_user_infos OK\n";
			}
		}
	}
}
else
	echo "ERROR number of datas\n";
