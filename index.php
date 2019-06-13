<?php

require_once('require.php');
require_once('controller/controller.php');

if (isset($_GET['action']))
{
	if ($_GET['action'] == 'start')
		start();
	else if ($_GET['action'] == 'create_account')
		create_account();
	else if ($_GET['action'] == 'sign_in')
		sign_in();
}
else
	start();
