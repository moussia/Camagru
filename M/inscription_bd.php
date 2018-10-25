<?php

function inscription($pseudo, $mail ,$password1)
{
	require ('config/database.php');
	if ((pseudo_exist($pseudo) == 1) || (mail_exist($mail) == 1))
		return 0;
	else
	{
		$pass_hache = password_hash($_POST['psw'], PASSWORD_DEFAULT);
		$validation = 0;
		$inserer = $bdd->prepare('insert into utilisateur (pseudo, mail, password, validation, notification)
				values (:pseudo, :mail, :password, 0, 1)');
		$inserer->execute(array(
					'pseudo' => $pseudo,
					'mail' => $mail,
					'password' => $pass_hache
					));
	}
	return 1;
}

function pseudo_exist($pseudo)
{
	require ('config/database.php');
	$req = $bdd->prepare('select * from utilisateur where pseudo= ?');
	$req->execute(array($pseudo));
	$data = $req->fetch();
	if ($data == 0)
		return 0;
	else
		return 1;
}

function mail_exist($mail)
{
	require ('config/database.php');
	$req = $bdd->prepare('select * from utilisateur where mail = ?');
	$req->execute(array($mail));
	$data = $req->fetch();
	if ($data == 0)
		return 0;
	else
		return 1;
}

?>
