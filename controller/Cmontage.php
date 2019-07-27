<?php

require_once('../require.php');

if (isset($_POST['photo']) && isset($_POST['stickers']) && isset($_POST['size']))
{
	if (!empty($_POST['photo']) && !empty($_POST['stickers']) && !empty($_POST['size']))
	{
		$db = new MontageManager();
		$pdo = $db->db_connect();

		$data = str_replace("data:image/png;base64,", "", $_POST['photo']);
		$data = str_replace(" ", "+", $data);
		$data_skrs = str_replace("data:image/png;base64,", "", $_POST['stickers']);
		$data_skrs = str_replace(" ", "+", $data_skrs);
		$photo = base64_decode($data);
		$stickers = base64_decode($data_skrs);
		$photo = imagecreatefromstring($photo);
		$stickers = imagecreatefromstring($stickers);
		if ($photo !== false && $stickers !== false)
		{
			if (imagecopy($photo, $stickers, 0, 0, 0, 0, $_POST['size'], $_POST['size']) === true)
			{
				$name = rand(0, 1000000);
				$path_save = '../public/img/photos_user/' . $name . '.png';
				header('Content-Type: img/png');
				if (!imagepng($photo, $path_save))
				 	echo "imagepng() 2 ERROR\n";
				else
				{
					echo "imagepng() success ! Name = $name\n";
					if (!$db->save_photo($pdo, $_SESSION['user'], $path_save))
						echo "save_photo() ERROR\n";
				}
			}
			else
				echo "copymerge() ERROR\n";
		}
		else
			echo "Decode or createfromstring ERROR\n";
	}
}
else
	echo "Creation photo ERROR\n";
