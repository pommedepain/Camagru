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
		$ids = $req->fetchAll();
		return ($ids);
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
		$ids = $this->get_id($pdo);
		foreach ($ids as $elem)
		{
			if ($elem['pseudo'] == $pseudo)
			{	
				$id = $elem['id'];
				return ($id);
			}
			else
				return false;
		}
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

	public function send_email_table($pdo, $pseudo, $anonym_id, $key_mail)
	{
		if (!($id = $this->id_exists($pdo, $pseudo)))
			return "No match for id in send_email_table\n";
		$req = $pdo->prepare("INSERT INTO db_camagru.email(id_user, anonym_id, key_mail) 
							VALUES(:id, :anonym_id, :key_mail)");
		if ($req->execute(array(
				'id' => $id,
				'anonym_id' => $anonym_id,
				'key_mail' => $key_mail
			)))
			return "send_email_table worked\n";
		else
			return "send_email table ERROR\n";
	}

	// public function check_passwd($pdo, $pseudo, $passwd)
	// {
	// 	$req = $pdo->query("SELECT `pseudo`,`passwd` FROM db_camagru.account WHERE `pseudo` = $pseudo");
	// 	$res= $req->fetchAll();
	// 	foreach ($res as $elem)
	// 	{
	// 		if ($elem['pseudo'] == $pseudo && $elem["passwd"] == $passwd)
	// 			return true;
	// 	}
	// 	return false;
	// }

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
			else
				$id = 0;
		}
		if ($id == 0)
			return "id didn't match\n";
		
		if (!($status = $this->change_status($pdo, $id)))
			return "Change status account didn't work\n";
		// $db = "db_camagru";
		// $db_account = "account";
		// $group = "member";
		// $sql = "UPDATE $db.`$db_account` SET `group`=:group
		// 		WHERE `id`=:id";
		// $req = $pdo->prepare($sql);
		// $req->bindParam('group', $group, PDO::PARAM_STR);
		// $req->bindParam('id', $id, PDO::PARAM_INT);
		// $req->execute();
		// if ($req->execute())
		// 	return "Change status OK\n";
		// else
		// 	return "Change status account didn't work\n";

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
}
