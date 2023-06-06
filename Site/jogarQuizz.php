<!DOCTYPE html>
<html>
<head>
	<title>Language Quizz- Informações do Quizz</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="jogarQuizz.css">

	<script src="https://kit.fontawesome.com/410e89720f.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>


</head>
<body>

<?php 
include "menuFooter/menu.php";
?>


<div id="wrap">
    <div id="left">
			<div id="dadosQuizz">
				<button style="float:right;" class="btn button border"><b>Iniciar</b></button>
				<div id="alinharImgENomeCriador">
					<img src="img/avatar3.gif" id="imgPerfil">
					<br>
					<b id="nomeCriador">Pedro Oliveira</b>
				</div>
				
				<div id="InformacoesQuizz">
				<p>
					<b>Nome:</b> Verbo To Be
				</p>

				<p>
					<b>Tema:</b> dia a dia
				</p>

				<p>
					<b>Data de criação:</b> 2023/05/12 15:00:24
				</p>

				<p>
					<b>Escolaridade:</b> 7ºano
				</p>

				<p>
					<b>Número de Perguntas:</b> 3
				</p>

				<div id="InformacoesAvaliacoesQuizz">
					<p>
						<b>Número de avaliações:</b> 3
					</p>
					<p>
						<b>Média de avaliações:</b> 3
					</p>
				</div>
				</div>
			</div>

	</div>

    <div id="right">
		<h2>Avaliações</h2>
		<div id="containerAvaliacoes">
			
			<div class="nomeAvaliacao container">Pedro Oliveira nvl: 3</div>
			<div id="" class="organizarDadosQuestao container " style="border: 3px outset black;">
					<div class="row h-100" >
						<div id="" class="col-sm-8 mostrarTextoAvaliacao">
						aisd auisd ausdasdahs odasdh aosdiohaisdhaoshd aasjdhaksdh asda siod aosid aioshdashd a sda sd.
						aisd auisd ausdasdahs odasdh aosdiohaisdhaoshd aasjdhaksdh asda siod aosid aioshdashd a sda sd.
						</div>
						<div id="" class="col-sm-4 dadosQuizz">
							<button type="text" class="btn button border posicaoBotaoAvaliacao">Reportar</button>
							<div class="posicaoDadosAvaliacao">
									Nota: 3
									<span class="like"><i class="fa-solid fa-thumbs-up"></i> </span>3    
									<span class="Deslike"><i class="fa-solid fa-thumbs-down"></i> </span>3
							</div>
						</div>
					</div>
			</div>

			<div class="nomeAvaliacao container">Pedro Oliveira nvl: 3</div>
			<div id="" class="organizarDadosQuestao container " style="border: 3px outset black;">
					<div class="row h-100" >
						<div id="" class="col-sm-8 mostrarTextoAvaliacao">
						aisd auisd ausdasdahs odasdh aosdiohaisdhaoshd aasjdhaksdh asda siod aosid aioshdashd a sda sd.
						aisd auisd ausdasdahs odasdh aosdiohaisdhaoshd aasjdhaksdh asda siod aosid aioshdashd a sda sd.
						</div>
						<div id="" class="col-sm-4 dadosQuizz">
							<button type="text" class="btn button border posicaoBotaoAvaliacao">Reportar</button>
							<div class="posicaoDadosAvaliacao">
									Nota: 3
									<span class="like"><i class="fa-solid fa-thumbs-up"></i> </span>3    
									<span class="Deslike"><i class="fa-solid fa-thumbs-down"></i> </span>3
							</div>
						</div>
					</div>
			</div>

			<div class="nomeAvaliacao container">Pedro Oliveira nvl: 3</div>
			<div id="" class="organizarDadosQuestao container " style="border: 3px outset black;">
					<div class="row h-100" >
						<div id="" class="col-sm-8 mostrarTextoAvaliacao">
						aisd auisd ausdasdahs odasdh aosdiohaisdhaoshd aasjdhaksdh asda siod aosid aioshdashd a sda sd.
						aisd auisd ausdasdahs odasdh aosdiohaisdhaoshd aasjdhaksdh asda siod aosid aioshdashd a sda sd.
						</div>
						<div id="" class="col-sm-4 dadosQuizz">
							<button type="text" class="btn button border posicaoBotaoAvaliacao">Reportar</button>
							<div class="posicaoDadosAvaliacao">
									Nota: 3
									<span class="like"><i class="fa-solid fa-thumbs-up"></i> </span>3    
									<span class="Deslike"><i class="fa-solid fa-thumbs-down"></i> </span>3
							</div>
						</div>
					</div>
			</div>

		</div>
	</div>
</div>

<script  src="jogarQuizz.js"></script>

</body>
</html>