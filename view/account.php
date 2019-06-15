<?php

// session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user']))
{
	$button1 = "Register";
	$action1 = "create_account";
	$button2 = "Sign In";
	$action2 = "sign_in";
}
else
{
	$button1 = "Account";
	$button2 = "Logout";
}

ob_start();

?>

<nav class="account">
	<div id="loggued_on"> <?php
		if (!empty($_SESSION['user']) && isset($_SESSION['user']))
		{
        	echo "Welcome " . $_SESSION['user'];
        }?>
	</div>
	<ul>
		<li><a href="index.php?action=<?= $action1?>"><?= $button1?></a></li>
		<li><a href="index.php?action=<?= $action2?>"><?= $button2?></a></li>
	</ul>
</nav>

<?php

$account = ob_get_clean();

?>
