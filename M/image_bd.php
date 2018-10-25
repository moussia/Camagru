<?php

function save_snap($snap)
{
	require_once ('config/database.php');
	$snap = str_replace(' ','+',$snap);
	$snap = substr($snap, 21);
	$snap = base64_decode($snap);
	$creator_id = $_SESSION['profil']['id'];
	$titre = "snap_" . $creator_id;
	$req = $bdd->prepare('insert into images (data, titre, creator_id, date_creation) values (:data, :titre, :creator_id, NOW())');
	$req->execute(array(
				'data' => $snap,
				'titre' => $titre,
				'creator_id' => $creator_id
				));
	$req->closeCursor();
	return 1;
}

function get_pseudo($id)
{
	require('config/database.php');
	$req_pseudo = $bdd->prepare('Select pseudo from utilisateur where id = ?');
	$req_pseudo->execute(array($id));
	$resultat = $req_pseudo->fetch();
	$pseudo = $resultat['pseudo'];
	return $pseudo;
}

function display_img()
{
	require('config/database.php');
	$req = $bdd->prepare('select * from images order by date_creation desc');
	$req->execute(array());
	$num_rows = $req->rowCount($req);
	while ($row = $req->fetch())
	{
		$image = imagecreatefromstring($row['data']);
		$img_id = $row['img_id'];
		$creator_id = $row['creator_id'];
		ob_start();
		imagejpeg($image, null, 80);
		$data = ob_get_contents();
		ob_end_clean();
		echo '<div class="responsive">';
		echo '<div class="gallery">';
		echo '<a target="_blank">';
		//*************************IMAGES**********************************
		echo '<img id="' . $img_id .'"  class="galery_img" src="data:image/jpg;base64,' .  base64_encode($data)  . '" width="480" height="360" style="cursor:pointer"/>';
?>		<div id="myModal" class="modal">
		<span class="close">&times;</span>
		<img class="modal-content" id="img01">
		<div id="caption">
		</div>
		</div>
		<script>

		var modal = document.getElementById('myModal');
		var img = document.getElementById("<?php echo $img_id ?>");
		var modalImg = document.getElementById("img01");
		var captionText = document.getElementById("caption");
		img.onclick = function(){
			var original = document.getElementById("a_<?php echo $img_id ?>");
			var clone = original.cloneNode(true);
			clone.id = "duplicater";
			clone.style.display = "block";
			captionText.replaceChild(clone, captionText.firstChild);
			modal.style.display = "block";
			modalImg.src = this.src;
		}
		var span = document.getElementsByClassName("close")[0];
		span.onclick = function() {
			modal.style.display = "none";
		}
		</script>
<?php
		echo '<div id="a_'.$img_id.'"  class="af" style="display:none" >';
		echo '<div class="pseudo_img">';
		echo get_pseudo($creator_id);
		echo '</div>';
		//*************************LIKES**********************************
		echo '<form method="post" action="index.php?controle=like&action=like">';
		echo '<input type="hidden" name="img_id" value=' .$img_id . '>';
		if (isset($_SESSION['profil']))
		{
			echo '<div class="like_img">';
			echo '<input type="image" src="img/like.png" name="img_id" value=' . $img_id .' alt="like" width="25" height="25">';
			require_once 'M/like_bd.php';
			display_like($img_id);
			echo '</div>';
		}
		echo '</form>';
		//*************************COMMENTAIRES****************************
		require_once 'M/comments_bd.php';
		display_com($img_id);
		 	//*************************COMMENTAIRES****************************
		if (isset($_SESSION['profil']))
		{
			echo '</br>';
			echo '<form method="POST" action="index.php?controle=comments&action=comments">';
			echo '<input type="hidden" name="img_id" value="' . $img_id . '">';
			echo '<textarea id="test" maxlength="150" name="com" placeholder="Votre commentaire..."></textarea></br>';
			echo '<input type="submit" class="register" value="Submit"/>';
			echo '</form>';
		}
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
	$req->closeCursor();
	return (1);
}

function img_perso()
{
	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}
	require('config/database.php');
	$req = $bdd->prepare('select * from images where creator_id = ? order by date_creation desc');
	$req->execute(array($_SESSION['profil']['id']));
	while($el = $req->fetch())
	{
		$image = imagecreatefromstring($el['data']);
		$img_id = $el['img_id'];
		ob_start();
		imagejpeg($image, null, 80);
		$data = ob_get_contents();
		ob_end_clean();
		echo '<div class="responsive">';
		echo '<div class="gallery">';
		echo '<a target="_blank">';
		//*************************AFFICHAGE PHOTO PERSO***********************
		echo '<img id="myImg" src="data:image/jpg;base64,' .  base64_encode($data)  . '" width="480" height="360"/>';
		echo '<div class="author_img">';
		echo $_SESSION['profil']['pseudo'];
		echo '</div>';
		//*************************SUPPRIMER PHOTO PERSO*********************
		echo '<form method="post" action="index.php?controle=uploder&action=img">';
		echo '<input type="hidden" name="img_id" value="' . $img_id .'"/>';
		echo '<button type="submit" class="delimage">Suprimer</button>';
		echo '</form>';
		echo '<form method="post" action="index.php?controle=like&action=like">';
		echo '<input type="hidden" name="img_id" value=' .$img_id . '>';
		echo '</br>';
		if (isset($_SESSION['profil']))
		{
			echo '<input type="image" src="img/like.png" name="img_id" value=' . $img_id .' alt="like" width="25" height="25">';
			require_once 'M/like_bd.php';
			display_like($img_id);
		}
		echo '</form>';
		//*************************SUPPRIMER COMMENTAIRES*********************
			require_once 'M/comments_bd.php';
			sup_comment($img_id);
		//*************************COMMENTAIRES****************************
		if (isset($_SESSION['profil']))
		{
			echo '<form method="POST" action="index.php?controle=comments&action=comments">';
			echo '<input type="hidden" name="img_id" value="' . $img_id . '">';
			echo '<textarea id="test" maxlength="150" name="com" placeholder="Votre commentaire..."></textarea></br>';
			echo '<input type="submit" class="register" value="Submit"/>';
			echo '</form>';
		}
		echo '</div>';
		echo '</div>';
	}
	$req->closeCursor();
	return (1);
}

function delete_img($img_id)
{
	require('config/database.php');
	$req = $bdd->prepare('DELETE from images WHERE img_id = ?');
	$req->execute(array($img_id));
	$req = $bdd->prepare('DELETE FROM likes WHERE img_id = ?');
	$req->execute(array($img_id));
	$req = $bdd->prepare('DELETE FROM commantaire WHERE image = ?');
	$req->execute(array($img_id));
	$req->closeCursor();
	return 1;
}

?>

