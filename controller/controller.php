<?php

require('./model/model.php');

function start()
{
	session_start();
	require_once('./config/setup.php');
	require("./view/indexView.php");
}
