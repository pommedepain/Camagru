<?php

function is_loggued_on()
{
	if (!empty($_SESSION['loggued_on_user'])) 
	{
		echo "Welcome " . $_SESSION['loggued_on_user'];
	}
}

function db_connect()
{
	$PARAM_host='mysql:127.0.0.1';
	$PARAM_db_name='db_camagru';
	$db_dsn = "$PARAM_host;dbname=$PARAM_db_name";
	$PARAM_user='root';
	$PARAM_passwd='philou1696';

	try
	{
		$db = new PDO($db_dsn, $PARAM_user, $PARAM_passwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return ($db);
	}
	catch(Exception $e)
	{
		die ("Failed to connect to host ($db_host)\n" . $err->getMessage() . "N° : " . $err->getCode());
	}
}

Class AccountManager
{
	public function get_pseudo($pdo)
	{
		$req = $pdo->query("SELECT `pseudo` FROM db_camagru.account");
		$pseudos = $req->fetchAll();
		return ($pseudos);
	}
	public function pseudo_exists($pdo, $pseudo)
	{
		$pseudos = get_pseudo($pdo);
		foreach ($pseudos as $elem)
		{
			if ($elem['pseudo'] == $pseudo)
				return true;
		}
		return false;
	} 
}
