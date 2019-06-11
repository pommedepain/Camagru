<?php
require_once('../config/setup.php');
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<link href="https://fonts.googleapis.com/css?family=Ruslan+Display&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=VT323&display=swap" rel="stylesheet">
		<title>Camagru</title>
		<link rel="shortcut icon" href="myfavicon.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="index.css">
	</head>

	<body>
	<header>
		<div id="head">
			<div id="title">
				<a href="index.php"><h1>Camagru <span class="emoji">📺</span></h1></a>
				<h3>Turn yourself into your favorite TV character</h3>
			</div>
			<nav class="account">
				<ul>
					<li><a href="#">Sign-in</a></li>
					<li><a href="create_account.php">Create account</a></li>
					<li><a href="#">Logout</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<nav class="bar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#">Gallery</a></li>
            <li><a href="#">Montage</a></li>
       	</ul>
	</nav>
	<div id="page">
		<div id="big_block">
		</div>
	</div>
	</body>
</html>
