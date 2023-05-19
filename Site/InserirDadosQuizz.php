<!DOCTYPE html>
<html>
<head>
    <title>Language Quizz- Inserir Dados</title>
    <meta charset="utf-8" http-equiv="pt-pt" >
    
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="InserirDadosQuizz.css">
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="https://kit.fontawesome.com/410e89720f.js" crossorigin="anonymous"></script>
    

</style>

</head>
<body>
<script>


</script>

<?php
include "menuFooter/menu.php";
?>


       

    <div>
        <br>
        <div class="containerQuestao alinharQuestao">
            <label for="escolherImagem" >
                <!-- Direitos autorais da imagem (img/imageIcon_Freepick.png) pertencem a Freepick -->
                <!-- Link:  https://www.flaticon.com/free-icon/insert-picture-icon_16410?term=image&page=1&position=5&origin=tag&related_id=16410 -->
                <button id="selecionarImagemQuizz" class="btn button border" onclick="document.getElementById('escolherImagem').click();"><i class="fa-solid fa-image" ></i></button>
                <input id="escolherImagem" type="file" accept="image/png, image/jpeg" onchange="carregarImagemQuizz()">
                <button id="limparImagem" class="btn button border" onclick="limparImagemQuestao()"><i class="fa-solid fa-broom"></i></button>
            </label>
            <img id="imagemQuestao" src="" class="imagemQuestao">
            <div id="digitarQuestao" class="digitarQuestao" placeholder="Digitar Questão..." contentEditable></div>
        </div>
    </div>
    <div id="footer" class="footer container">
            <div class="row h-100">
                <div id="questao1" class="col-sm containerOpcoesResposta text-right">
                    <input class="form-check-input" type="checkBox" id="radio1"> 
                    <i id="fecharResposta1" class="fa-solid fa-trash fecharResposta" onclick="fecharContainerResposta('questao1')"></i>   
                    <div class="col-sm containerResposta">
                        <div id="digitarResposta1" class="digitarResposta" placeholder="Resposta..." data-max-length="50" contentEditable onchange="Display(1)"></div>
                    </div>
                </div>
                
                <div id="questao2" class="col-sm containerOpcoesResposta text-right">
                    <input class="form-check-input" type="checkBox" id="radio1"> 
                    <i id="fecharResposta2" class="fa-solid fa-trash fecharResposta" onclick="fecharContainerResposta('questao2')"></i>    
                    <div class="col-sm containerResposta">
                        <div id="digitarResposta2" class="digitarResposta" placeholder="Resposta..." data-max-length="50" contentEditable onfocusout="Display(2)"></div>
                    </div>
                </div>

                <div id="questao3" class="col-sm containerOpcoesResposta text-right">
                    <input class="form-check-input" type="checkBox" id="radio1"> 
                    <i id="fecharResposta3" class="fa-solid fa-trash fecharResposta" onclick="fecharContainerResposta('questao3')"></i>    
                    <div class="col-sm containerResposta">
                        <div id="digitarResposta3" class="digitarResposta" placeholder="Resposta..." data-max-length="50" contentEditable onfocusout="Display(3)"></div>
                    </div>
                </div>

                <div id="questao4" class="col-sm containerOpcoesResposta text-right">
                    <input class="form-check-input" type="checkBox" id="radio1"> 
                    <i id="fecharResposta4" class="fa-solid fa-trash fecharResposta" onclick="fecharContainerResposta('questao4')"></i>    
                    <div class="col-sm containerResposta">
                        <div id="digitarResposta4" class="digitarResposta" placeholder="Resposta..." data-max-length="50" contentEditable onfocusout="Display(4)"></div>
                    </div>
                </div>
                <div id="containerAdicionarResposta">
                    <button id="adicionarResposta" class="btn button border" onclick="adicionarCampoResposta()"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
    </div>


<script  src="InserirDadosQuizz.js"></script>

</body>
</html>