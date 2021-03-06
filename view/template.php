<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<link href="https://fonts.googleapis.com/css?family=Ruslan+Display&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=VT323&display=swap" rel="stylesheet">
		<title><?= $title ?></title>
		<link rel="shortcut icon" href="./public/img/myfavicon.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="./public/css/index.css">
		<?= $stylesheet ?>
		<link rel="stylesheet" type="text/css" href="./public/css/create.css">
		<link rel="stylesheet" type="text/css" href="./public/css/activation.css">
		<link rel="stylesheet" type="text/css" href="./public/css/manage_account.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<body id="special">
		<header>
		<div id="head">
			<div id="title">
				<a href="../index.php"><h1>Camagru <span class="emoji">📺</span></h1></a>
				<h3>Turn yourself into your favorite TV character</h3>
			</div>
			<?= $account ?>
		</div>
		</header>
		
		<nav class="bar">
    		<ul>
	        	<li><a href="index.php?action=gallery">Gallery</a></li>
    	    	<li><a href="index.php?action=montage">Montage</a></li>
    		</ul>
		</nav>
	
		<?= $content ?>
	</body>

	<footer>
		<h3 id="symbol">©</h3><h3 id="copyright"> Philippine Sentilhes (psentilh), 42 Paris, 2019</h3>
	</footer>
</html>
