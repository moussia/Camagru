<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="V/style.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>Webcam</title>
	</head>
	<body>
		<?php include 'V/menu.php'; ?>
		</br>
		<div class="context">
			<canvas id="photo" class="snap" width="480" height="360" style="border: 1px solid black"></canvas>
			<video id="video" class="videos" width="480" height="360" autoplay></video>
			<img id="upl" class="videos" width="480" height="360" style="display:none"/>
		</div>
		<!--*************************FILTRES**********************************-->
		<div class="items" id="fil">
			<img onclick="myFunction('img/f.png')" id="bird" src="img/f.png" width="100" class="item">
			<img onclick="myFunction('img/glc.png')" id="glc" src="img/glc.png"  width="100" class="item">
			<img onclick="myFunction('img/f1.png')" id="hat" src="img/f1.png" width="100" class="item">
			<img onclick="myFunction('img/dog.png')" id="dog" src="img/dog.png"  width="100" class="item">
			<img onclick="myFunction('img/ang.png')" id="angel" src="img/ang.png" width="100" class="item">
		</div>
		<!--*************************WEBCAM**********************************-->
		<div>
			<form method="post" action="index.php?controle=uploder&action=uploder_snapshot" enctype="multipart/form-data">
				<input type="hidden" id="filtre" name="filtre" value="img/f.png"/>
				<input type="hidden" id="px" name="px"/>
				<input type="hidden" id="py" name="py"/>
				<button type="submit" id="boutonsnap" style="display:block" class="inscriptionbtn">Prendre une photo</button></br></br>
				<input type="hidden" id="img_id" name="img"/>
			</form>
			<canvas id="canvas" width="480" height="360"></canvas>
		<!--********************UPLODER DES PHOTOS**************************-->
			<form method="post" action="index.php?controle=uploder&action=uploder_img" enctype="multipart/form-data">
				<input type="hidden" id="filtre_src" name="filtre" value="img/f.png"/>
				<input type="hidden" id="src_px" name="src_px"/>
				<input type="hidden" id="src_py" name="src_py"/>
				<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
				<input type="hidden" id="img_src" name="img_src" value=""/>
				<input id="up" onchange="uplode();" type="file" name="img" />
				<input type="submit" class="inscriptionbtn" id="upload" name="upload" style="display:none" value="Envoyer" />
			</form>
		</div>
		<h4>Vos publications</h4>
		<?php
			require_once 'M/image_bd.php';
			img_perso();
		?>
		</br></br></br></br></br></br></br></br>
	</body>
	<?php include 'V/footer.html'; ?>
</html>

<script>

function uplode()
{
	var up = document.getElementById('up').files[0];
	if (up)
	{
		if (up['type'] == 'image/jpeg')
		{
			document.getElementById('video').style.display = "none";
			document.getElementById('upl').style.display = "block";
			document.getElementById('boutonsnap').style.display = "none";
			document.getElementById('upload').style.display = "block";
			var reader = new FileReader();
			 reader.onload = function(event) {
				document.getElementById('upl').src = event.target.result;
				document.getElementById('img_src').value = event.target.result;
			};
			reader.readAsDataURL(up);
		}
		else
			alert('Format de l\'image non valide !');
	}
}

// récupérer des éléments, créer des paramètres, etc.
var video = document.getElementById('video');
// Demander l'acces a la camera!
if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia){
	navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
		video.srcObject = stream;
//			window.URL.createObjectURL(stream);
		video.play();
	});
}
// Elements pour prendre une photo
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');

// declanche la photo***********************************************/
document.getElementById("boutonsnap").addEventListener("click", function() {
	var snapshot = context.drawImage(video, 0, 0, 480, 360);
	var dataURL = canvas.toDataURL('image/jpg', 1);
	document.getElementById('img_id').value = dataURL;
});
</script>

<script>
var photo, context_photo;
var img = new Image();
var isDraggable = false;

var currentX = 0;
var currentY = 0;

window.onload = function() {
	photo = document.getElementById("photo");
	context_photo = photo.getContext("2d");
//decider de lendroit ou va se placer le filtre en 1er
	currentX = photo.width/2;
	currentY = photo.height/2;

	img.onload = function() {
		_Go();
	};
	//filtre par defaut
	img.src='img/f.png';
	//pour que limage puisse bien se deplacer
	document.getElementById("px").value = currentX - (img.width/2);
	document.getElementById("py").value = currentY - (img.height/2);
	document.getElementById("src_px").value = currentX - (img.width/2);
	document.getElementById("src_py").value = currentY - (img.height/2);
};

function _Go() {
	_MouseEvents();

	setInterval(function() {
		_ResetCanvas();
		_DrawImage();
	}, 1000/30);
}
function _ResetCanvas() {
	context_photo.clearRect(0, 0, photo.width, photo.height);
}
function _MouseEvents() {
	photo.onmousedown = function(e) {

		var mouseX = e.pageX - this.offsetLeft;
		var mouseY = e.pageY - this.offsetTop;

		if (mouseX >= (currentX - img.width/2) &&
			mouseX <= (currentX + img.width/2) &&
			mouseY >= (currentY - img.height/2) &&
			mouseY <= (currentY + img.height/2)) {
			isDraggable = true;
		}
	};
	photo.onmousemove = function(e) {
		if (isDraggable) {
			currentX = e.pageX - this.offsetLeft;
			currentY = e.pageY - this.offsetTop;
			document.getElementById('px').value = currentX - (img.width/2);
			document.getElementById('py').value = currentY - (img.height/2);
			document.getElementById('src_px').value = currentX - (img.width/2);
			document.getElementById('src_py').value = currentY - (img.height/2);
		}
	};
	photo.onmouseup = function(e) {
		isDraggable = false;
	};
	photo.onmouseout = function(e) {
		isDraggable = false;
	};
}
function _DrawImage() {
	context_photo.drawImage(img, currentX-(img.width/2), currentY-(img.height/2));
}

function myFunction(src)
{
	img.src= src;
	document.getElementById('filtre').value = src;
	document.getElementById('filtre_src').value = src;
}

</script>
