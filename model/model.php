<?php

Class AccountManager
{
	public function db_connect()
	{
		$PARAM_host='mysql:127.0.0.1';
		$PARAM_db_name='db_camagru';
		$db_dsn = "$PARAM_host;dbname=$PARAM_db_name";
		$PARAM_user='root';
		$PARAM_passwd='philou1696';

		try
		{
			$pdo = new PDO($db_dsn, $PARAM_user, $PARAM_passwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    	    return ($pdo);
		}
		catch(Exception $e)
		{
			die ("Failed to connect to host ($db_host)\n" . $err->getMessage() . "N° : " . $err->getCode());
		}
	}

	public function get_pseudo($pdo)
	{
		$req = $pdo->query("SELECT `pseudo` FROM db_camagru.account");
		$pseudos = $req->fetchAll();
		return ($pseudos);
	}

	public function get_keys($pdo)
	{
		$req = $pdo->query("SELECT `anonym_id`,`key_mail` FROM db_camagru.email");
		$keys = $req->fetchAll();
		return ($keys);
	}

	public function get_id($pdo)
	{
		$req = $pdo->query("SELECT `pseudo`,`id` FROM db_camagru.account");
		if (!($ids = $req->fetchAll()))
			return false;
		else
			return ($ids);
	}

	public function get_passwd($pdo)
	{
		$req = $pdo->query("SELECT `pseudo`,`passwd` FROM db_camagru.account");
		if (!$res = $req->fetchAll())
			return false;
		else
			return ($res);
	}

	public function get_all_infos($pdo)
	{
		$req = $pdo->query("SELECT `pseudo`,`email`,`firstname`,`lastname`,`group`,`notifications` FROM db_camagru.account");
		if (!$res = $req->fetchAll())
			return false;
		else
			return ($res);
	}

	public function get_user_infos($pdo, $pseudo)
	{
		$infos = $this->get_all_infos($pdo);
		foreach ($infos as $elem)
		{
			if ($elem['pseudo'] == $pseudo)
				return ($elem);
		}
		return false;
	}

	public function pseudo_exists($pdo, $pseudo)
	{
		$pseudos = $this->get_pseudo($pdo);
		foreach ($pseudos as $elem)
		{
			if ($elem['pseudo'] == $pseudo)
				return true;
		}
		return false;
	}

	public function id_exists($pdo, $pseudo)
	{
		if (($ids = $this->get_id($pdo)) == false)
			return "Pb with the get_id function\n";
		foreach ($ids as $elem)
		{
			if ($elem['pseudo'] == $pseudo)
			{	
				$id = $elem['id'];
				return ($id);
			}
		}
		return "Didn't found a match for $pseudo in id_exists\n";
	}

	public function send_register($pdo, $pseudo, $first_name, $last_name, $email, $passwd)
	{
		$req = $pdo->prepare("INSERT INTO db_camagru.account(pseudo, firstname, lastname, email, passwd) 
							VALUES(:pseudo, :firstname, :lastname, :email, :passwd)");
		if ($req->execute(array(
				'pseudo' => $pseudo,
				'firstname' => $first_name,
				'lastname' => $last_name,
				'email' => $email,
				'passwd' => $passwd
			)))
			return true;
		else
			return false;
	}

	public function change_user_infos($pdo, $pseudo, $first_name, $last_name, $email, $passwd, $group, $id)
	{
		$db = "db_camagru";
		$db_account = "account";
		if (isset($passwd) && !empty($passwd))
		{
			$sql = "UPDATE $db.`$db_account` SET `group`=:group, `pseudo`=:pseudo, `firstname`=:first_name, `lastname`=:last_name, `email`=:email, `passwd`=:passwd
					WHERE `id`=:id";
			$req = $pdo->prepare($sql);
			$req->bindParam('passwd', $passwd, PDO::PARAM_STR);
		}
		else
		{
			$sql = "UPDATE $db.`$db_account` SET `group`=:group, `pseudo`=:pseudo, `firstname`=:first_name, `lastname`=:last_name, `email`=:email
					WHERE `id`=:id";
			$req = $pdo->prepare($sql);
		}
		$req->bindParam('group', $group, PDO::PARAM_STR);
		$req->bindParam('pseudo', $pseudo, PDO::PARAM_STR);
		$req->bindParam('first_name', $first_name, PDO::PARAM_STR);
		$req->bindParam('last_name', $last_name, PDO::PARAM_STR);
		$req->bindParam('email', $email, PDO::PARAM_STR);
		$req->bindParam('id', $id, PDO::PARAM_INT);
		if ($req->execute())
			return true;
		else
			return false;
	}

	public function send_email_table($pdo, $pseudo, $anonym_id, $key_mail)
	{
		if (!is_numeric($id = $this->id_exists($pdo, $pseudo)))
			return "$id\n";
		$req = $pdo->prepare("INSERT INTO db_camagru.email(id_user, anonym_id, key_mail) 
							VALUES(:id, :anonym_id, :key_mail)");
		if ($req->execute(array(
				'id' => $id,
				'anonym_id' => $anonym_id,
				'key_mail' => $key_mail
			)))
			return "send_email_table worked";
		else
			return "send_email table ERROR";
	}

	public function update_email_table($pdo, $pseudo, $anonym_id, $key_mail)
	{
		$db = "db_camagru";
		$db_email = "email";
		if (!is_numeric($id = $this->id_exists($pdo, $pseudo)))
			return "$id\n";
		$req = $pdo->prepare("UPDATE $db.`$db_email` SET `anonym_id`=:anonym_id, `key_mail`=:key_mail 
							WHERE `id_user`=:id");
		$req->bindParam('anonym_id', $anonym_id, PDO::PARAM_STR);
		$req->bindParam('key_mail', $key_mail, PDO::PARAM_STR);
		$req->bindParam('id', $id, PDO::PARAM_INT);
		if (!($req->execute()))
			return "update_email_table ERROR";
		else
			return "update_email_table worked";
	}

	public function update_reset_passwd($pdo, $pseudo, $rand_str)
	{
		$db = "db_camagru";
		$db_email = "email";
		if (!is_numeric($id = $this->id_exists($pdo, $pseudo)))
			return "$id\n";
		$req = $pdo->prepare("UPDATE $db.`$db_email` SET `rand_str`=:rand_str 
							WHERE `id_user`=:id");
		$req->bindParam('rand_str', $rand_str, PDO::PARAM_STR);
		$req->bindParam('id', $id, PDO::PARAM_INT);
		if ($req->execute())
			return "update_reset_passwd() worked";
		else
			return false;
	}

	public function get_rand_str($pdo, $rand_str)
	{
		$db = "db_camagru";
		$db_email = "email";
		$db_account = "account";
		$sql = "SELECT $db.`$db_email`.id_user AS 'id', $db.`$db_email`.rand_str
				FROM $db.`$db_email`
				INNER JOIN $db.`$db_account` ON $db.`$db_email`.id_user = $db.`$db_account`.id";
		$req = $pdo->query($sql);
		if ($ids = $req->fetchAll())
			return ($ids);
		else
			return false;
	}

	public function erase_rand_str($pdo, $id)
	{
		$db = "db_camagru";
		$db_email = "email";
		$erase = NULL;
		$sql = "UPDATE $db.`$db_email` SET `rand_str`=:erase
				WHERE `id_user`=:id";
		$req = $pdo->prepare($sql);
		$req->bindParam('erase', $erase, PDO::PARAM_STR);
		$req->bindParam('id', $id, PDO::PARAM_INT);
		if ($req->execute())
			return "Erase email infos OK\n";
		else
			return false;
	}

	public function change_passwd_user($pdo, $passwd, $rand_str)
	{
		if (!$tab = $this->get_rand_str($pdo, $rand_str))
			return "get_rand_str() ERROR";
		foreach ($tab as $elem)
		{
			if ($elem['rand_str'] == $rand_str)
				$id = $elem['id'];
		}
		if (!$id)
			return "rand_str didn't match\n";
		
		$db = "db_camagru";
		$db_account = "account";
		$sql = "UPDATE $db.`$db_account` SET `passwd`=:passwd
				WHERE `id`=:id";
		$req = $pdo->prepare($sql);
		$req->bindParam('passwd', $passwd, PDO::PARAM_STR);
		$req->bindParam('id', $id, PDO::PARAM_INT);
		$req->execute();
		if ($req->rowcount() === 0)
			return ("change_passwd_user() ERROR" );

		if ($this->erase_rand_str($pdo, $id))
			return "change_passwd_user() OK";
		else
			return "erase_rand_str() ERROR";
	}

	public function check_passwd($pdo, $pseudo, $passwd)
	{
		if (($passwds = $this->get_passwd($pdo, $pseudo)) == false)
			return "Couldn't get passwd in get_passwd\n";
		foreach ($passwds as $elem)
		{
			if ($elem['pseudo'] == $pseudo && $elem["passwd"] == $passwd)
				return true;
		}
		return false;
	}

	public function match_key($pdo, $anonym_id, $key_mail)
	{
		$keys = $this->get_keys($pdo);
		foreach ($keys as $elem)
		{
			if ($elem['anonym_id'] == $anonym_id && $elem["key_mail"] == $key_mail)
				return true;
		}
		return false;
	}

	public function match_id_user_between_tables($pdo)
	{
		$db = "db_camagru";
		$db_email = "email";
		$db_account = "account";
		$sql = "SELECT $db.`$db_email`.id_user AS 'id', $db.`$db_email`.anonym_id, $db.`$db_email`.key_mail
				FROM $db.`$db_email`
				INNER JOIN $db.`$db_account` ON $db.`$db_email`.id_user = $db.`$db_account`.id";
		$req = $pdo->query($sql);
		$ids = $req->fetchAll();
		return ($ids);
	}

	public function change_status($pdo, $id)
	{
		$db = "db_camagru";
		$db_account = "account";
		$group = "member";
		$sql = "UPDATE $db.`$db_account` SET `group`=:group
				WHERE `id`=:id";
		$req = $pdo->prepare($sql);
		$req->bindParam('group', $group, PDO::PARAM_STR);
		$req->bindParam('id', $id, PDO::PARAM_INT);
		if ($req->execute())
			return true;
		else
			return false;
	}

	public function conf_mail($pdo, $anonym_id, $key_mail)
	{
		$match = $this->match_id_user_between_tables($pdo);
		foreach ($match as $elem)
		{
			if ($elem['anonym_id'] == $anonym_id && $elem['key_mail' == $key_mail])
				$id = $elem['id'];
		}
		if (!$id)
			return "id didn't match\n";
		
		if (!($status = $this->change_status($pdo, $id)))
			return "Change status account didn't work\n";
		
		$db = "db_camagru";
		$db_email = "email";
		$erase = NULL;
		$sql2 = "UPDATE $db.`$db_email` SET `anonym_id`=:erase, `key_mail`=:erase
				WHERE `id_user`=:id";
		$req2 = $pdo->prepare($sql2);
		$req2->bindParam('erase', $erase, PDO::PARAM_STR);
		$req2->bindParam('id', $id, PDO::PARAM_INT);
		if ($req2->execute())
			return "Erase email infos OK\n";
		else
			return "Erase email infos didn't work\n";
	}

	public function notif_email($pdo, $state, $pseudo)
	{
		if (!is_numeric($id = $this->id_exists($pdo, $pseudo)))
			return false;
		if ($state === 'true')
			$value = 1;
		else if ($state === 'false')
			$value = 0;

		$db = "db_camagru";
		$db_account = "account";
		$req = $pdo->prepare("UPDATE $db.`$db_account` SET `notifications`=:notifications
							WHERE `id`=:id");
		if ($req->execute(array(':notifications' => $value, ':id' => $id)))
			return true;
		else
			return false;
	}
}
