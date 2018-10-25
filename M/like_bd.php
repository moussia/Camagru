<?php

function display_like($img_id)
{

	require 'config/database.php'; // On réclame le fichier
//	$creator_id = $_SESSION['profil']['id'];
	$req = $bdd->prepare('SELECT likes_id FROM likes WHERE img_id = :img_id');//and creator_id = :creator_id ');
	$req->execute(array(
				'img_id' => $img_id/*,
				'creator_id' => $creator_id*/
				));
	$num_rows = $req->rowCount();
	echo $num_rows;
	return 1;
}

function save_like2($img_id)
{
	require 'config/database.php'; // On réclame le fichier
	$creator_id = $_SESSION['profil']['id'];
	$req = $bdd->prepare('select likes_id from likes where img_id = :img_id and creator_id = :creator_id ');
	$req->execute(array(
				'img_id' => $img_id,
				'creator_id' => $creator_id
				));
	$num_rows = $req->rowCount();
	if ($num_rows == 0)
	{
		$req = $bdd->prepare('insert into likes(creator_id, img_id) values (:creator_id, :img_id)');
		$req->execute(array(
					'img_id' => $img_id,
					'creator_id' => $creator_id
					));
		?>
			<script type="text/javascript">
			alert('Add !');
		</script>
			<?php
	}
	else
	{
		$req = $bdd->prepare('delete from likes WHERE img_id = :img_id  and creator_id = :creator_id');
		$req->execute(array(
					'img_id' => $img_id,
					'creator_id' => $creator_id
					));
		?>
			<script type="text/javascript">
			alert('Remove !');
		</script>
			<?php
	}
	$req->closeCursor();
	return 1;
}

?>
