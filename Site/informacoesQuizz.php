<!DOCTYPE html>
<html>
<head>
	<title>Language Quizz- Informações do Quizz</title>
	<meta charset="utf-8">
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="informacoesQuizz.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>

	<script src="https://kit.fontawesome.com/410e89720f.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>


</head>
<body>

<?php 
include "menuFooter/menu.php";
?>


<div id="wrap">
    <div id="left">
			<div id="dadosQuizz">
				<button style="float:right;" class="btn button border" onclick="iniciarJogoQuizz()"><b>Iniciar</b></button>
				<button id="editarQuizz" style="float:right; margin-right:10px;" class="btn button border" onclick="verificarEdicaoQuizz()"></button>
				<button id="editarComoAdmin" style="float:left; margin-right:10px;" class="btn button border" onclick="verificarEdicaoQuizzAdmin()"></button>
				<div id="alinharImgENomeCriador">
					<img id="imgPerfil" src="">
					<br>
					<center>
						<b id="nomeCriador">Pedro Oliveira</b>
					</center>
				</div>
				
				<div id="InformacoesQuizz">
				
					<p id="nomeQuizz">
						<!-- <b>Nome:</b> Verbo To Be -->
					</p>

					<p id="temaQuizz">
						<!-- <b>Tema:</b> dia a dia -->
					</p>

					<p id="dataCriacaoQuizz">
						<!-- <b>Data de criação:</b> 2023/05/12 15:00:24 -->
					</p>

					<p id="escolaridadeQuizz">
						<!-- <b>Escolaridade:</b> 7ºano -->
					</p>

					<p id="numeroPerguntasQuizz">
						<!-- <b>Número de Perguntas:</b> 3 -->
					</p>

					<div id="InformacoesAvaliacoesQuizz">
						<p id="numeroAvaliacoesFeitas">
							<b>Número de avaliações:</b> 3
						</p>
						<p id="mediaAvaliacoesFeitas">
							<b>Média de avaliações:</b> 3
						</p>
					</div>
				</div>
			</div>

	</div>

    <div id="right">
		<h2>Avaliações</h2>
		<div id="containerAvaliacoes">


		</div>
	</div>
</div>

<?php 
include "menuFooter/footer.php";
?>

<script  src="informacoesQuizz.js"></script>
<script  src="verificarCriacaoQuizz.js"></script>

</body>
</html>