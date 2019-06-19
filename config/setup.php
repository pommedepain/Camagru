<?php

$PARAM_host='mysql:127.0.0.1';
$PARAM_db_name='db_camagru';
$db_dsn = "$PARAM_host;dbname=$PARAM_db_name";
$PARAM_user='root';
$PARAM_passwd='philou1696';

if (!($connect = new PDO($db_dsn, $PARAM_user, $PARAM_passwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION))))
        die ("Failed to connect to host ($db_host)" . $err->getMessage() . "N° : " . $err->getCode());

$connect->exec("CREATE DATABASE IF NOT EXISTS db_camagru");

$connect->exec("CREATE TABLE IF NOT EXISTS db_camagru.account (
        `id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL, 
	`pseudo` VARCHAR(25) NOT NULL,
        `firstname` VARCHAR(255) DEFAULT NULL,
        `lastname` VARCHAR(255) DEFAULT NULL,
        `email` VARCHAR(255) NOT NULL,
        `passwd` VARCHAR(255) NOT NULL,
	`group` ENUM('admin', 'member', 'not_confirmed') DEFAULT 'not_confirmed' NOT NULL,
        `creation_date` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)");
        
$connect->exec("CREATE TABLE IF NOT EXISTS db_camagru.email (
        `id_user` INT PRIMARY KEY,
        `anonym_id` VARCHAR(32),
        `key_mail` VARCHAR(32),
        `rand_str` VARCHAR(32) DEFAULT NULL)");
?>
