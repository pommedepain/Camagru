<?php

require_once('../require.php');

if (isset($_POST['send']) && !empty($_POST['send']) && $_POST['send'] === "send" 
	&& isset($_SESSION['user_to_be']) && !empty($_SESSION['user_to_be']) && isset($_SESSION['email']) && !empty($_SESSION['email']))
{
	if (preg_match_all(" #^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$# ", $_SESSION['email']))
	{
		$db = new AccountManager();
		$pdo = $db->db_connect();

		$res = $db->get_user_infos($pdo, $_SESSION['user_to_be']);
		if ($res['email'] === $_SESSION['email'])
		{
			echo "function email_send triggered\n";
			$email = $_SESSION['email'];
			$group = "not_confirmed";
			$anonym_id = md5(rand(0, 100000));
			$key = md5(rand(0, 100000));
			if ($db->update_email_table($pdo, $_SESSION['user_to_be'], $anonym_id, $key) !== "update_email_table() worked")
				echo "ERROR update_email_table\n";
			else
			{
				$subject = "[Camagru] Confirm your email";
				$header = "From: psentilh@student.42.fr";
				$message = "Hello,
			

To activate your account, please click on the link below or copy/paste it in your browser :
			
http://localhost:8080/index.php?action=confirm_mail&log=" . urlencode($anonym_id) . "&key=" . urlencode($key) . "
			
			
---------------
This is an automatic message, please do not reply.";

				$success = mail($email, $subject, $message, $header);
				if (!$success)
					echo error_get_last()['message'];
				else
					echo "Csend_again.php done and successful\n";
			}
		}
		else
			echo "Email not in db ERROR\n";
	}
	else
		echo "Mail syntax ERROR\n";
}
else if (isset($_POST['submit']) && !empty($_POST['submit']) && $_POST['submit'] === "submit")
{
	echo "check notif triggered\n";

	$db = new AccountManager();
	$pdo = $db->db_connect();

	if (!($res = $db->get_user_infos($pdo, $_SESSION['user'])))
		echo "Pb with get_user_infos() ERROR\n";
	else if ($res['notifications'] == 1)
		echo "Notifications = true\n";
	else if ($res['notifications'] == 0)
		echo "Notifications = false\n";
}
else
	echo "Pb with nb of argv ERROR\n";
