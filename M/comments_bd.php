<?php

function save_comments($comment, $img_id)
{
	require ('config/database.php');
	$comment = utf8_encode($comment);
	$req = $bdd->prepare('insert into commantaire (creator, creation, image, comment) values (:creator, NOW(), :image, :comment)');
	$req->execute(array(
		'creator' => $_SESSION['profil']['id'],
		'image' => $img_id,
		'comment' => $comment
	));
	notif_comment($img_id);
	return 1;
}
function display_com($img_id)
{
	require ('config/database.php');
	$req = $bdd->prepare('SELECT * FROM commantaire WHERE image = ?');
	$req->execute(array($img_id));
	$row_count = $req->rowCount($req);
	while ($row = $req->fetch())
	{
		require_once 'M/image_bd.php';
?>
			<p><strong><?php echo htmlspecialchars(get_pseudo($row['creator'])); ?></strong> Le <?php echo $row['creation']; ?></p>
			<p class="commentaire"><?php echo htmlspecialchars($row['comment']); ?></p>
<?php
		echo '<hr/>';
		echo '</form>';
	}
	$req->closeCursor();
	return 1;
}

function sup_comment($img_id)
{
	require ('config/database.php');
	$req = $bdd->prepare('SELECT * FROM commantaire WHERE image = :img_id');
	$req->execute(array(
		'img_id' => $img_id));
	$row_count = $req->rowCount();
	while ($row = $req->fetch())
	{
		require_once 'M/image_bd.php';
		$id_com = $row['id'];
?>
			<p><strong><?php echo htmlspecialchars(get_pseudo($row['creator'])); ?></strong> Le <?php echo $row['creation']; ?></p>
			<p class="commentaire"><?php echo htmlspecialchars($row['comment']); ?></p>
<?php
		echo '<form method="POST" action="index.php?controle=comments&action=delete_com">';
		echo '<input type="hidden" name="id" value="' . $id_com . '">';
		echo '<button type=submit" class="delcom">Supprimer</button>';
		echo '<hr/>';
		echo '</form>';
	}
	$req->closeCursor();
	return 1;
}

function notif_comment($img_id)
{
	require ('config/database.php');


	$req = $bdd->prepare('SELECT creator_id FROM images WHERE img_id = ?');
	$req->execute(array($img_id));

	$id = $req->fetch();

	$select = $bdd->prepare('SELECT * FROM utilisateur WHERE id = ?');
	$select->execute(array($id['creator_id']));
	$creator = $select->fetch();

	if ($creator['notification'] == '1')
	{
		mail_notif($creator);
	}
}

function mail_notif($creator)
{
	require 'config/database.php';
	$subject = 'Nouveau commentaire -Camagru-!';
	$message = '
		Bonjour, ' . $creator['pseudo']  . '
		Vous avez recu un nouveau commentaire sur votre photo !
		';
	mail($creator['mail'], $subject, $message);

}

function delete_comment($id_com)
{
	require('config/database.php');
	$req = $bdd->prepare('DELETE from commantaire  WHERE id = ?');
	$req->execute(array($id_com));
	$req->closeCursor();
	return 1;
}

?>
