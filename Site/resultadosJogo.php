<!DOCTYPE html>
<html>
<head>
	<title>Language Quizz- Resultados Jogo</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="resultadosJogo.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>

	<script src="https://kit.fontawesome.com/410e89720f.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>


</head>
<body>

<div class="posicionarDiv container">
    
    <br>
    <br>
    <center><h3 id="nomeQuizz"></h3></center>
    <br>
    <center>
        <div class="w3-light-grey">
           <div class="progress" style="height: 25px; width: 70%;">
           <div class="progress-bar progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><b id="resultadoProgresso"></b></div>
        </div>
    </center>
    <br>
    <h5><div>Questões acertadas: <span id="numeroQuestoesAcertadas" ></span> </div><h5>
    <br>
    <button class="btn button border" onclick="jogarNovamente()"><b>Jogar novamente</b></button>
    <button style="float:right;" class="btn button border" onclick="sairDoQuizz()"><b>Sair do quizz</b></button>
    <br>
    <hr>
    <center>
        <div id="organizarAvaliacao">
            Avaliar Quizz:
                <textarea id="textoAvaliacao" cols="50" rows="5" placeholder="Escrever avaliação, máx: 250 caracteres..." maxlength="250"></textarea>
            <button id="notaAvaliacao1" style="float:left; font-size: 12px;" class="btn button border" onclick="escolherNota(1)"><b>1</b></button>
            <button id="notaAvaliacao2" style="float:left; font-size: 12px;" class="btn button border" onclick="escolherNota(2)"><b>2</b></button>
            <button id="notaAvaliacao3" style="float:left; font-size: 12px;" class="btn button border" onclick="escolherNota(3)"><b>3</b></button>
            <button id="notaAvaliacao4" style="float:left; font-size: 12px;" class="btn button border" onclick="escolherNota(4)"><b>4</b></button>
            <button id="notaAvaliacao5" style="float:left; font-size: 12px;" class="btn button border" onclick="escolherNota(5)"><b>5</b></button>
            <button id="guardarAvaliacao" style="float:right; font-size: 15px;" class="btn button border"><b>Submeter</b></button>
        </div>
    </center>
</div>


<script  src="resultadosJogo.js"></script>
</body>
</html>