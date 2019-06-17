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
	else if ($_GET['action'] == 'logout')
		logout();
	else if ($_GET['action'] == 'confirm_mail')
		confirm_mail();
	else if ($_GET['action'] == 'reset_passwd')
		reset_passwd();
	else if ($_GET['action'] == 'access_account')
		access_account();
}
else
	start();
