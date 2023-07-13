<!DOCTYPE html>
<html>
<head>
    <title>Language Quizz- Jogar Quizz</title>
    <meta charset="utf-8" http-equiv="pt-pt" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="jogarQuizz.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
   
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
  

</style>

</head>
<body>

<?php
include "menuFooter/menu.php";
?>
    <div>
        <br>
        <div class="containerQuestao alinharQuestao">
                <div id="nomeQuestao"></div>
                <button id="selecionarImagemQuizz">
                </button>
                <form  method="post" enctype="multipart/form-data" id="MostrarImgPergunta">
                    <input id="escolherImagem" type="file" name="file" accept="image/png, image/jpeg" onchange="document.getElementById('guardarTempImg').click();">
                    <button id="guardarTempImg" type="submit" class="btn button border"><i class="fa-solid fa-floppy-disk"></i></button>
                </form>

            <img id="imagemQuestao" src="" class="imagemQuestao" title="Clicar para eliminar imagem" >
            <div id="digitarQuestao" class="digitarQuestao"></div>
        </div>
    </div>

    <!-- O que aparece quando o Tipo da questão é; selecionar resposta -->
    
    <center>
        <div id="progressbarNumeroRespostas" class="w3-light-grey">
           <div class="progress" style="height: 25px; width: 70%;">
           <div id="valorprogressBar" class="progress-bar progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><b id="resultadoProgresso"></b></div>
        </div>
    </center>

      <div id="selecionarResposta" class="selecionarResposta container">
            <div class="row h-100">
                <div id="questao1" class="col-sm containerOpcoesResposta text-right">
                    <div id="containerResposta0" class="col-sm containerResposta" title="clicar para confirmar escolha" onclick="confirmarEscolhaSelecionada(0)">
                        <div id="digitarResposta1" class="digitarResposta"></div>
                    </div>
                </div>
                
                <div id="questao2" class="col-sm containerOpcoesResposta text-right">
                    <div id="containerResposta1" class="col-sm containerResposta" title="clicar para confirmar escolha" onclick="confirmarEscolhaSelecionada(1)">
                        <div id="digitarResposta2" class="digitarResposta"></div>
                    </div>
                </div>

                <div id="questao3" class="col-sm containerOpcoesResposta text-right">
                    <div id="containerResposta2" class="col-sm containerResposta" title="clicar para confirmar escolha" onclick="confirmarEscolhaSelecionada(2)">
                        <div id="digitarResposta3" class="digitarResposta"></div>
                    </div>
                </div>

                <div id="questao4" class="col-sm containerOpcoesResposta text-right">
                    <div id="containerResposta3" class="col-sm containerResposta" title="clicar para confirmar escolha" onclick="confirmarEscolhaSelecionada(3)">
                        <div id="digitarResposta4" class="digitarResposta"></div>
                    </div>
                </div>
            </div>
    </div>

    <!-- O que aparece quando o Tipo da questão é;  texto livre -->

    <div id="escreverResposta">
        <div id="containerEscreverResposta" class="containerEscreverResposta container">
                <div id="escreverResposta1" class="row">
                    <input id="digitarResposta1" class="digitarEscreverResposta" placeholder="Resposta..." data-max-length="50" contentEditable="plaintext-only"></input>
                    <button id="submeterResposta" class="btn button border" onclick="confirmarEscolhaEscrita()">Confirmar</i></button>
                </div>
        </div>
    <div>



<script  src="jogarQuizz.js"></script>

</body>
</html>