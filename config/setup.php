<?php

if (!($connect = new PDO($db_dsn, $PARAM_user, $PARAM_passwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION))))
        die ("Failed to connect to host ($db_host)" . $err->getMessage() . "N° : " . $err->getCode());

$connect->exec("CREATE DATABASE IF NOT EXISTS db_camagru");

$connect->exec("CREATE TABLE IF NOT EXISTS db_camagru.account (
        `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL, 
	`pseudo` VARCHAR(25) NOT NULL,
        `firstname` VARCHAR(255) DEFAULT NULL,
        `lastname` VARCHAR(255) DEFAULT NULL,
        `email` VARCHAR(255) NOT NULL,
        `passwd` VARCHAR(255) NOT NULL,
	`group` ENUM('admin', 'member', 'not_confirmed') DEFAULT 'not_confirmed' NOT NULL,
        `notifications` BOOLEAN DEFAULT true,
        `creation_date` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)");
        
$connect->exec("CREATE TABLE IF NOT EXISTS db_camagru.email (
        `id_user` INT UNSIGNED PRIMARY KEY,
        `anonym_id` VARCHAR(32),
        `key_mail` VARCHAR(32),
        `rand_str` VARCHAR(32) DEFAULT NULL)");

$connect->exec("CREATE TABLE IF NOT EXISTS db_camagru.photos (
        `id_user` INT UNSIGNED NOT NULL,
        `path_save` VARCHAR(255) NOT NULL,
        `creation_date` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        `likes` INT NOT NULL DEFAULT 0,
        `comments` INT NOT NULL DEFAULT 0)");

$connect->exec("CREATE TABLE IF NOT EXISTS db_camagru.gallery_activity (
        `id_user` INT UNSIGNED NOT NULL,
        `photo` VARCHAR(255) NOT NULL,
        `liked` BOOLEAN DEFAULT false,
        `comments` INT NOT NULL DEFAULT 0)");

$connect->exec("CREATE TABLE IF NOT EXISTS db_camagru.comments (
        `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
        `id_user` INT UNSIGNED NOT NULL,
        `photo` VARCHAR(255) NOT NULL,
        `comment` TEXT(1000) NOT NULL,
        `creation_date` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)");
