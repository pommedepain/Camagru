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

	public function send_register($pdo, $pseudo, $first_name, $last_name, $email, $passwd, $key_mail)
	{
		$req = $pdo->prepare("INSERT INTO db_camagru.account(pseudo, firstname, lastname, email, passwd, key_mail) 
							VALUES(:pseudo, :firstname, :lastname, :email, :passwd, :key_mail)");
			$req->execute(array(
				'pseudo' => $pseudo,
				'firstname' => $first_name,
				'lastname' => $last_name,
				'email' => $email,
				'passwd' => $passwd,
				'key_mail' => $key_mail
			));
	}

	public function check_passwd($pdo, $pseudo, $passwd)
	{
		$req = $pdo->query("SELECT `pseudo`,`passwd` FROM db_camagru.account WHERE `pseudo` = $pseudo");
		$res= $req->fetchAll();
		foreach ($res as $elem)
		{
			if ($elem['pseudo'] == $pseudo && $elem["passwd"] == $passwd)
				return true;
		}
		return false;
	}

	public function match_key($pdo, $pseudo, $key_mail)
	{
		$req = $pdo->query("SELECT `pseudo`,`key_mail` FROM db_camagru.account WHERE `pseudo` = $pseudo");
		$res= $req->fetchAll();
		foreach ($res as $elem)
		{
			if ($elem['pseudo'] == $pseudo && $elem["key_mail"] == $key_mail)
				return true;
		}
		return false;
	}
}
