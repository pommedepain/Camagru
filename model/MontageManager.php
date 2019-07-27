<?php

Class MontageManager
{
	public function db_connect()
	{
		$PARAM_host='mysql:127.0.0.1';
		$PARAM_db_name='db_camagru';
		$db_dsn = "$PARAM_host;dbname=$PARAM_db_name";
		$PARAM_user='root';
		$PARAM_passwd='philou1696';

		try
		{
			$pdo = new PDO($db_dsn, $PARAM_user, $PARAM_passwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    	    return ($pdo);
		}
		catch(Exception $e)
		{
			die ("Failed to connect to host ($db_host)\n" . $err->getMessage() . "N° : " . $err->getCode());
		}
	}

	public function get_id($pdo)
	{
		$req = $pdo->query("SELECT `pseudo`,`id` FROM db_camagru.account");
		if (!($ids = $req->fetchAll()))
			return false;
		else
			return ($ids);
	}

	public function id_exists($pdo, $pseudo)
	{
		if (($ids = $this->get_id($pdo)) == false)
			return "Pb with the get_id function\n";
		foreach ($ids as $elem)
		{
			if ($elem['pseudo'] == $pseudo)
			{	
				$id = $elem['id'];
				return ($id);
			}
		}
		return "Didn't found a match for $pseudo in id_exists\n";
	}

	public function save_photo($pdo, $pseudo, $path_save)
	{
		if (!is_numeric($id = $this->id_exists($pdo, $pseudo)))
			return "Pb with id_exists:\n$id";
		
		$req = $pdo->prepare("INSERT INTO db_camagru.photos(id_user, path_save) 
							VALUES(:id_user, :path_save)");
		if ($req->execute(array(
			'id_user' => $id,
			'path_save' => $path_save
		)))
			return true;
		else
			return false;
	}
	
	public function get_all_photos_user($pdo, $pseudo)
	{
		if (!is_numeric($id = $this->id_exists($pdo, $pseudo)))
			return "Pb with id_exists:\n$id";
		$req = $pdo->query("SELECT `id_user`,`path_save`,`creation_date`
						FROM db_camagru.photos
						WHERE `id_user` = $id
						ORDER BY `creation_date` DESC");
		if (!$res = $req->fetchAll())
			return false;
		else
			return ($res);
	}

	public function get_all_photos($pdo)
	{
		$db = "db_camagru";
		$db_photo = "photos";
		$db_account = "account";
		$req = $pdo->query("SELECT `$db_photo`.id_user, `$db_account`.pseudo, `$db_photo`.path_save, `$db_photo`.creation_date, 
						`$db_photo`.likes, `$db_photo`.comments
						FROM $db.`$db_photo`
						INNER JOIN $db.`$db_account` ON $db.`$db_photo`.id_user = $db.`$db_account`.id
						ORDER BY `creation_date` DESC");
		if (!$res = $req->fetchAll())
			return false;
		else
			return ($res);
	}

	public function get_all_activity($pdo)
	{
		$db = "db_camagru";
		$db_photo = "photos";
		$db_account = "account";
		$db_activity = "gallery_activity";
		$comments = "comments";
		$req = $pdo->query("SELECT `$db_photo`.id_user, `$db_account`.pseudo, `$db_photo`.path_save, `$db_photo`.creation_date, 
						`$db_activity`.id_user AS 'From', `$db_activity`.liked, `$comments`.comment
						FROM $db.`$db_photo`
						INNER JOIN $db.`$db_account` ON $db.`$db_photo`.id_user = $db.`$db_account`.id
						INNER JOIN $db.`$db_activity` ON $db.`$db_photo`.path_save = $db.`$db_activity`.photo
						LEFT JOIN $db.`$comments` ON $db.`$db_activity`.photo = $db.`$comments`.photo
						ORDER BY `creation_date` DESC");
		if (!$res = $req->fetchAll())
			return false;
		else
			return ($res);
	}

	public function del_photo_usr($pdo, $pseudo, $photo)
	{
		if (!$photos = $this->get_all_photos_user($pdo, $pseudo))
			return "Pb with get_all_photos_user";

		foreach ($photos as $elem)
		{
			if ($elem['path_save'] == $photo)
				$to_del = $photo;
		}
		if (!$to_del)
			return "No match found for this $photo";

		$req = $pdo->prepare("DELETE FROM db_camagru.photos
						WHERE `path_save`=:photo");
		if ($req->execute(array(
			'photo' => $photo
		)))
			return true;
		else
			return false;
	}

	public function alter_like($pdo, $photo, $like)
	{
		$db = "db_camagru";
		$db_photo = "photos";
		if ($like === "liked")
			$req = $pdo->prepare("UPDATE $db.`$db_photo` SET `likes`= `likes`+ 1
								WHERE `path_save`=:photo");
		else if ($like === "unliked")
			$req = $pdo->prepare("UPDATE $db.`$db_photo` SET `likes`= `likes`- 1
								WHERE `path_save`=:photo");
		$req->bindParam('photo', $photo, PDO::PARAM_STR);
		if ($req->execute())
			return true;
		else
			return false;
	}

	public function alter_comments($pdo, $photo)
	{
		$db = "db_camagru";
		$db_photo = "photos";
		$req = $pdo->prepare("UPDATE $db.`$db_photo` SET `comments`= `comments`+ 1
							WHERE `path_save`=:photo");
		$req->bindParam('photo', $photo, PDO::PARAM_STR);
		if ($req->execute())
			return true;
		else
			return false;
	}

	public function check_like($pdo)
	{
		$req = $pdo->query("SELECT `id_user`,`photo`,`liked` FROM db_camagru.gallery_activity");
		if (($ret = $req->fetchAll()) === false)
			return false;
		else
			return ($ret);
	} 

	public function user_activity_like($pdo, $photo, $like, $user)
	{
		if (!is_numeric($id = $this->id_exists($pdo, $user)))
			return "Pb with is_numeric()";
	
		if (($ret = $this->check_like($pdo)) === false)
			return false;

		if ($like === "liked")
			$liked = 1;
		else if ($like === "unliked")
			$liked = 0;
		
		foreach ($ret as $elem)
		{
			//$ret2 = $elem['id_user'] . " = " . $id . "; " . $elem['photo'] . " = " . $photo . "; "  . $elem['liked'] . " = " . $liked;
			if ($elem['id_user'] === $id && $elem['photo'] === $photo && $elem['liked'] == $liked)
				return "Photo already $like by $user";
		}
		$req = $pdo->prepare("INSERT INTO db_camagru.gallery_activity(id_user, photo, liked)
							VALUES(:id, :photo, :liked)");
		if ($req->execute(array(
			'id' => $id,
			'photo' => $photo,
			'liked' => $liked
		)))
			return true;
		else
			return false;
	}

	public function user_activity_comments($pdo, $photo, $user)
	{
		if (!is_numeric($id = $this->id_exists($pdo, $user)))
			return false;
		$req = $pdo->prepare("INSERT INTO db_camagru.gallery_activity(id_user, photo, comments)
							VALUES(:id, :photo, :comments)");
		if ($req->execute(array(
			'id' => $id,
			'photo' => $photo,
			'comments' => `comments` + 1
		)))
			return true;
		else
			return false;
	}

	public function register_comment($pdo, $user, $photo, $comment)
	{
		if (!is_numeric($id = $this->id_exists($pdo, $user)))
			return false;
		$db = "db_camagru";
		$db_comments = "comments";
		$req = $pdo->prepare("INSERT INTO $db.`$db_comments`(id_user, photo, comment)
							VALUES(:id_user, :photo, :comment)");
		if ($req->execute(array(
			'id_user' => $id,
			'photo' => $photo,
			'comment' => $comment
		)))
			return true;
		else
			return false;
	}
}
