<?php

require_once('require.php');

function start()
{
	require_once("./view/Vindex.php");
}

function register()
{
	require_once('./view/Vregister.php');
}

function sign_in()
{
	require_once('./view/Vsign_in.php');
}

function reset_passwd()
{
	require_once('./view/Vreset_passwd.php');
}

function reset_now()
{
	require_once('./view/Vreset_now.php');
}

function confirm_mail()
{
	require_once('./view/Vactivation.php');
}

function logout()
{
	require_once('./controller/Clogout.php');
}

function manage_account()
{
	require_once('./view/Vmanage_account.php');
}

