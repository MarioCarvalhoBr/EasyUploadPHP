<?php
	require_once("EasyUploadPHP.class.php");

	define('TAMANHO_MAXIMO', (2 * 1024 * 1024));
	$caminho = "_uploads/default.png";

	if(isset ($_POST['Salvar'])){

	if (!empty($_FILES['imagem'])){
		//Passar o $_FILES, altura, largura e pasta para onde a imagem será salva.
		$upload = new Upload($_FILES['imagem'], 1265, 700, "_uploads/");
		$result =  $upload->salvar();
		
		if($result == UploadErrors::E_NAO_MOVEU){
			echo('<script>window.alert("'.UploadErrors::getErrorMensagem(UploadErrors::E_NAO_MOVEU).'");</script>');
		} else if($result == UploadErrors::E_NAO_IMAGEM){
			echo('<script>window.alert("'.UploadErrors::getErrorMensagem(UploadErrors::E_NAO_IMAGEM).'");</script>');
		} else{
			$caminho = $result;
		}
	} else{
		echo('<script>window.alert("Esse arquivo não é uma imagem!");</script>');
	}
}
?>
<!DOCTYPE html>
<html lang="utf-8">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="/_uploads/default.pnghttps://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">

<h2>EasyUpload PHP</h2>

	<form class="form-horizontal" method="post" enctype="multipart/form-data">

		<div class="form-group">
			<label for="imagem">Imagem:</label>
			<input type="file" class="form-control" required="required" name="imagem" value="imagem">
		</div>
		<button type="submit" value="Salvar" name="Salvar" class="btn btn-primary">Salvar</button>
	</form>

	<br>
	<h2>Imagem</h2>
	<p>Caminho da imagem que você carregou: <?echo ($caminho);?></p>  
	<br>
	<img src="<?echo ($caminho);?>" class="img-responsive" alt="Cinque Terre"> 
	<hr>
</div>

</body>
</html>
