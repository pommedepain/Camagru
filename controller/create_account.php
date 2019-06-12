<?php

if (isset($_POST["submit"]) && isset($_POST["pseudo"]) && isset($_POST["passwd1"]) && isset($_POST["passwd2"]) && isset($_POST["email"]))
{
	if ($_POST["submit"] == "Create" && !empty($_POST["pseudo"]) && !empty($_POST["passwd1"]) && !empty($_POST["passwd2"]) && !empty($_POST["email"]) && ($_POST["passwd1"] == $_POST["passwd2"]))
	{
		$pseudo = $_POST["pseudo"];
		if (isset($_POST["firstname"]) && !empty($_POST["firstname"]))
			$first_name = $_POST["firstname"];
		else
			$first_name = NULL;
		if (isset($_POST["lastname"]) && !empty($_POST["lastname"]))
			$last_name = $_POST["lastname"];
		else
			$last_name = NULL;
	   	$passwd = hash("whirlpool", $_POST["passwd1"]);
		$email = $_POST["email"];
	}
		
	$db = db_connect();
	$req = $db->prepare("INSERT INTO db_camagru.account(pseudo, firstname, lastname, email, passwd) 
						VALUES(:pseudo, :firstname, :lastname, :email, :passwd)");
		$req->execute(array(
			'pseudo' => $pseudo,
			'firstname' => $first_name,
			'lastname' => $last_name,
			'email' => $email,
			'passwd' => $passwd
		));
}
