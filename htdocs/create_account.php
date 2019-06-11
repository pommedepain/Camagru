<?php
require_once('../config/setup.php');

if (isset($_POST["submit"]) && isset($_POST["pseudo"]) && isset($_POST["passwd1"]) && isset($_POST["passwd2"]) && isset($_POST["email"]))
{
	if ($_POST["submit"] == "Create" && !empty($_POST["pseudo"]) && !empty($_POST["passwd1"]) && !empty($_POST["passwd2"]) && !empty($_POST["email"]) && ($_POST["passwd1"] == $_POST["passwd2"]))
	{
		$answer = $connect->query("SELECT * FROM db_camagru.account");
		while ($datas = $answer->fetch())
		{
			if ($_POST["pseudo"] == $datas["pseudo"])
				
		}
		$pseudo = $_POST["pseudo"];
		if (isset($_POST["firstname"]) && !empty($_POST["firstname"]))
			$first_name = $_POST["firstname"];
		if (isset($_POST["lastname"]) && !empty($_POST["lastname"]))
			$last_name = $_POST["lastname"];
	    $passwd = hash("whirlpool", $_POST["passwd1"]);
		$email = $_POST["email"];
	}
	
	if ($first_name && !$last_name)
	{
		$req = $connect->prepare("INSERT INTO db_camagru.account(pseudo, firstname, email, passwd) 
							VALUES(:pseudo, :firstname, :email, :passwd)");
		$req->execute(array(
			'pseudo' => $pseudo,
			'firstname' => $first_name,
			'email' => $email,
			'passwd' => $passwd
		));
	}
	else if (!$first_name && $last_name)
	{
		$req = $connect->prepare("INSERT INTO db_camagru.account(pseudo, lastname, email, passwd) 
							VALUES(:pseudo, :lastname, :email, :passwd)");
		$req->execute(array(
			'pseudo' => $pseudo,
			'lastname' => $last_name,
			'email' => $email,
			'passwd' => $passwd
		));
	}
	else if ($first_name && $last_name)
	{
		$req = $connect->prepare("INSERT INTO db_camagru.account(pseudo, firstname, lastname, email, passwd) 
							VALUES(:pseudo, :firstname, :lastname, :email, :passwd)");
		$req->execute(array(
			'pseudo' => $pseudo,
			'firstname' => $first_name,
			'lastname' => $last_name,
			'email' => $email,
			'passwd' => $passwd
		));
	}
	else
	{
		$req = $connect->prepare("INSERT INTO db_camagru.account(pseudo, email, passwd) 
							VALUES(:pseudo, :email, :passwd)");
		$req->execute(array(
			'pseudo' => $pseudo,
			'email' => $email,
			'passwd' => $passwd
		));
	}
}

?>
<!DOCTYPE html>
<html>
	<?php include("head.php"); ?>
	<body>
		<?php include("header.php"); ?>
		<div class="formu">
            <div class="create">
                <h2>Create an account:</h2><br/>
            </div>
            <form action="create_account.php" method="post">
				Pseudo: <input type="text" name="pseudo" id="pseudo" required class="input"/>
				<div id="pseudo_d"></div><br /><br />
				First name: <input type="text" name="firstname" id="firstname" class="input"/><br /><br />
				Last name: <input type="text" name="lastname" id="lastname" class="input"/><br /><br />
				Email: <input type="text" name="email" id="email" required class="input"/>
				<div id="email_d"></div><br /><br />
				Password: <input type="password" name="passwd1" id="passwd1" required class="input"/>
				<div id="passwd1_d"></div><br /><br />
				Confirm password: <input type="password" name="passwd2" id="passwd2" required class="input"/>
				<div id="passwd2_d"></div><br /><br />
				<input type="submit" name="submit" value="Create" class="myButton" onclick="is_empty()" /><br />
				<div id="success"></div>
            </form>
		</div>
		<script src='form.js'></script>
	</body>
</html>
