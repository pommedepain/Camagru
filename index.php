<?php

require_once('require.php');
require_once('controller/controller.php');

if (isset($_GET['action']))
{
	if ($_GET['action'] == 'start')
		gallery();
	else if ($_GET['action'] == 'register')
		register();
	else if ($_GET['action'] == 'sign_in')
		sign_in();
	else if ($_GET['action'] == 'logout')
		logout();
	else if ($_GET['action'] == 'confirm_mail')
		confirm_mail();
	else if ($_GET['action'] == 'reset_passwd')
		reset_passwd();
	else if ($_GET['action'] == 'reset_now')
		reset_now();
	else if ($_GET['action'] == 'manage_account')
		manage_account();
	else if ($_GET['action'] == 'montage')
		montage();
	else if ($_GET['action'] == 'gallery')
		gallery();
}
else
	gallery();
