<?php

require_once('require.php');

function start()
{
	require_once("./view/Vindex.php");
}

function create_account()
{
	require_once('./view/Vcreate_account.php');
}

function sign_in()
{
	require_once('./view/Vsign_in.php');
}

function reset_passwd()
{
	require_once('./view/Vreset_passwd.php');
}

function confirm_mail()
{
	require_once('./view/Vactivation.php');
}
