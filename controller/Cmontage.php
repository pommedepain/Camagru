<?php

require_once('../require.php');

if (isset($_POST["photo"]) && isset($_POST["stickers"]) && isset($_POST['size']))
{
	if (!empty($_POST["photo"]) && !empty($_POST["stickers"]) && !empty($_POST['size']))
	{
		$db = new AccountManager();
		$pdo = $db->db_connect();

		$data = str_replace("data:image/png;base64,", "", $_POST['photo']);
		$data = str_replace(" ", "+", $data);
		$data_skrs = str_replace("data:image/png;base64,", "", $_POST['stickers']);
		$data_skrs = str_replace(" ", "+", $data_skrs);
		echo $data_skrs;
		$photo = base64_decode($data);
		$stickers = base64_decode($data_skrs);
		$photo = imagecreatefromstring($photo);
		$stickers = imagecreatefromstring($stickers);

		if ($photo !== false && $stickers !== false)
		{
			if (!imagepng($stickers) || !imagepng($photo))
				echo "imagepng() 1 ERROR\n";
			if (!imagealphablending($stickers, false))
				echo "alphablending() ERROR\n";
			if (!imagealphasave($stickers, true))
				echo "alphasave() ERROR\n";
			if (imagecopymerge($photo, $stickers, 0, 0, 0, 0, $_POST['size'], $_POST['size'], 100) === true)
			{
				//header('Content-Type: img/png');
				if (!imagepng($photo))
					echo "imagepng() 2 ERROR\n";
				//else
					//echo $photo;
			}
		}
		else
			echo "Decode or createfromstring ERROR\n";
	}
}
else
	echo "Creation photo ERROR\n";
