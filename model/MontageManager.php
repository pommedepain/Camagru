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
		$req = $pdo->query("SELECT `id_user`,`path_save`,`creation_date`, `likes`, `comments`
						FROM db_camagru.photos
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
}
