<?php


if (!isset($_SESSION['user']) || empty($_SESSION['user']))
{
	$button1 = "Register";
	$action1 = "register";
	$button2 = "Sign In";
	$action2 = "sign_in";
}
else
{
	$button1 = "Account";
	$action1 = "manage_account";
	$button2 = "Logout";
	$action2 = "logout";
}

ob_start();

?>

<nav class="account">
	<div id="loggued_on"><h3 id ="welcome"> <?php
		if (!empty($_SESSION['user']) && isset($_SESSION['user']))
		{
        	echo "Welcome ". $_SESSION['user'];
        }?>
	</h3></div>
	<ul>
		<li><a href="index.php?action=<?= $action1?>"><?= $button1?></a></li>
		<li><a href="index.php?action=<?= $action2?>"><?= $button2?></a></li>
	</ul>
</nav>

<?php

$account = ob_get_clean();

?>
