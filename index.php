<?php

require('controller/controller.php');

if (isset($_GET['action']))
{
	if ($_GET['action'] == 'start')
		start();
	else if (isset($_GET['action']) == 'create_account')
		create_account();
}
else
	start();
