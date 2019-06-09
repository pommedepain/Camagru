#!/usr/bin/php
<?php
session_start();
$conn = mysqli_connect('localhost', 'root', 'philou1696') or die('Connexion failed : ' . mysql_error());
if (!mysqli_select_db($conn, "camagru")); 
{
    mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS camagru")
    $set_data = array();
    $set_data[] = "USE camagru";
    $set_data[] = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"';
    $set_data[] = "SET AUTOCOMMIT = 0";
    $set_data[] = "START TRANSACTION";
	$set_data[] = 'SET time_zone = "+00:00"';
}
mysqli_close($conn);
?>
