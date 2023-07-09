<!DOCTYPE html>
<html>
<head>
	<title>Language Quizz- Resultados Jogo</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="resultadosJogo.css">

	<script src="https://kit.fontawesome.com/410e89720f.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>


</head>
<body>

<div class="posicionarDiv container">
    
    <br>
    <br>
    <center><h3 id="nomeQuizz">(Nome quizz)</h3></center>
    <br>
    <center>
        <div class="w3-light-grey">
           <div class="progress" style="height: 25px; width: 70%;">
           <div class="progress-bar progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><b id="resultadoProgresso">25%</b></div>
        </div>
    </center>
    <br>
    <h5><div>Questões acertadas: <span id="numeroQuestoesAcertadas" ></span> </div><h5>
    <br>
    <button class="btn button border" onclick="JogarNovamente()"><b>Jogar novamente</b></button>
    <button style="float:right;" class="btn button border" onclick="JogarNovamente()"><b>Sair do quizz</b></button>
    <br>
    <hr>
    <center>
        <div id="organizarAvaliacao">
            Avaliar Quizz:
                <textarea id="textoAvaliacao" cols="50" rows="5" placeholder="Escrever avaliação..."></textarea>
            <button style="float:left; font-size: 12px;" class="btn button border" onclick=""><b>1</b></button>
            <button style="float:left; font-size: 12px;" class="btn button border" onclick=""><b>2</b></button>
            <button style="float:left; font-size: 12px;" class="btn button border" onclick=""><b>3</b></button>
            <button style="float:left; font-size: 12px;" class="btn button border" onclick=""><b>4</b></button>
            <button style="float:left; font-size: 12px;" class="btn button border" onclick=""><b>5</b></button>
            <button  style="float:right; font-size: 15px;" class="btn button border" onclick="Submeter()"><b>Submeter</b></button>
        </div>
    </center>
</div>


<script  src="resultadosJogo.js"></script>

<script>
  
  // Set the width to animate the progress bar
  // Along with time duration in milliseconds
  $(".progress-bar").animate({
          width: "70%",
  },3000);
</script>
</body>
</html>