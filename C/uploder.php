<?php

function transforme_img($snap, $filtre, $px, $py)
{
	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}
	$snap = str_replace(' ','+',$snap);
	$snap = substr($snap, 22);
	$img_blob = base64_decode($snap);

	$image = imagecreatefromstring($img_blob);
	$filtre = imagecreatefrompng($filtre);
	$image_new = imagecreatetruecolor(480, 360);
	imagecopyresampled($image_new, $image, 0, 0, 0, 0, 480, 360, imagesx($image), imagesy($image));
	//$img_redimen = imagecopyresampled($image, $filtre, $px, $py, 0, 0, 480, 360, imagesx($filtre), imagesy($filtre));
	$reture = imagecopy($image_new, $filtre, $px, $py, 0, 0, imagesx($filtre), imagesy($filtre));
	ob_start(); 
	imagepng($image_new); //This will normally output the image, but because of ob_start(), it won't.
	$contents = ob_get_contents(); //Instead, output above is saved to $contents
	ob_end_clean(); //End the output buffer.
	$dataUri = "data:image/png;base64," . base64_encode($contents);
	return $dataUri;
}

function uploder_snapshot()
{
	$snap = isset($_POST['img'])?$_POST['img']:'';
	$filtre = isset($_POST['filtre'])?$_POST['filtre']:'';
	$px = isset($_POST['px'])?$_POST['px']:'';
	$py = isset($_POST['py'])?$_POST['py']:'';

	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}
	require_once 'M/image_bd.php';
	$img = transforme_img($snap, $filtre, $px, $py);
	save_snap($img);
	require_once 'C/accueil.php';
	home();
}

function uploder_img()
{
	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}
	$extensions = array('.jpg', '.jpeg');
	$taille_maxi = 10000000;
	$taille = filesize($_FILES['img']['tmp_name']);
	$extension = strrchr($_FILES['img']['name'], '.'); 
	if((!in_array($extension, $extensions)) || ($taille>$taille_maxi))
	{
?>
		<script type="text/javascript">
		alert("Impossible de télécharger cette photo !");
		</script>
<?php
		require 'V/webcam.php';
	}
	//var_dump($_POST); exit();
	$src = isset($_POST['img_src'])?$_POST['img_src']:'';
	$filtre = isset($_POST['filtre'])?$_POST['filtre']:'';
	$px = isset($_POST['src_px'])?$_POST['src_px']:'';
	$py = isset($_POST['src_py'])?$_POST['src_py']:'';
	//	var_dump($px, $py); exit();
	$img = transforme_img($src, $filtre, $px, $py);
	require_once 'M/image_bd.php';

	if (save_snap($img) == 1)
	{
		if (isset($_POST['upload']))
		{
?>
			<script type="text/javascript">
			alert("Upload effectué avec succès !");
			</script>
<?php
		}
		else{
?>
			<script type="text/javascript">
			alert("Echec de l'upload !");
			</script>
<?php
		}
	}
	require_once 'C/accueil.php';
	home();
}

function img()
{
	$img_id = isset($_POST['img_id'])?$_POST['img_id']:'';
	if (isset($_POST['img_id']) && $_POST['img_id'] != "")
	{
		require 'M/image_bd.php';
		delete_img($img_id);
	}
	require_once 'C/accueil.php';
	home();
	return 0;
}

?>
