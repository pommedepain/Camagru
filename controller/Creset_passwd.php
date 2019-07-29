<?php

require_once('../require.php');

if (isset($_POST["submit"]) && isset($_POST["pseudo"]) && isset($_POST["email"]))
{
	if ($_POST["submit"] == "submit" && !empty($_POST["pseudo"]) && !empty($_POST["email"]))
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
				echo "Pseudo NOT IN DB ERROR\n";
		}
		else
			echo "Pseudo ERROR";

			if (isset($_POST['email']) && !empty($_POST['email']))
			{
				if (preg_match_all(" #^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$# ", $_POST['email']))
				{
					if ($res = $db->get_user_infos($pdo, $pseudo))
					{
						if ($res['pseudo'] == $pseudo && $res['email'] == $_POST['email'])
						{
							$email = $_POST['email'];
							$rand_str = md5(rand(0, 100000));
							if ($res = $db->update_reset_passwd($pdo, $pseudo, $rand_str))
							{
								$subject = "[Camagru] Reset your password";
								$header = "From: psentilh@student.42.fr";
								$message = "Hello,
				
	
To reset your password, please click on the link below or copy/paste it in your browser :
				
http://localhost:8080/index.php?action=reset_now&log=" . urlencode($rand_str) . "
				

---------------
This is an automatic message, please do not reply.";
	
								$success = mail($email, $subject, $message, $header);
								if (!$success)
									echo error_get_last()['message'];
							}
							else
								echo "update_reset_passwd ERROR\n";
						}
					}
					else
						"get_user_infos() ERROR\n";
				}
				else
					echo "Mail syntax ERROR\n";
			}
	}
	else
		echo "Combination ERROR\n";
}
