<!DOCTYPE html>
<html>
<head>
    <title>Language Quizz- Inserir Dados</title>
    <meta charset="utf-8" http-equiv="pt-pt" >
    
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="InserirDadosQuizz.css">
   
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    

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

                <!-- Direitos autorais da imagem (img/imageIcon_Freepick.png) pertencem a Freepick -->
                <!-- Link:  https://www.flaticon.com/free-icon/insert-picture-icon_16410?term=image&page=1&position=5&origin=tag&related_id=16410 -->
                <button id="selecionarImagemQuizz" class="btn button border" onclick="document.getElementById('escolherImagem').click();"><i class="fa-solid fa-image" ></i></button>
                
                <form  method="post" enctype="multipart/form-data" id="MostrarImgPergunta">
                    <input id="escolherImagem" type="file" name="file" accept="image/png, image/jpeg" onchange="document.getElementById('guardarTempImg').click();">
                    <button id="guardarTempImg" type="submit" class="btn button border"><i class="fa-solid fa-floppy-disk"></i></button>
                
                </form>

            <img id="imagemQuestao" src="" class="imagemQuestao" onclick="limparImagemQuestao()">
            <div id="digitarQuestao" class="digitarQuestao" placeholder="Digitar Questão..." contentEditable="plaintext-only"></div>
        </div>
    </div>
    <div id="footer" class="footer container">
            <div class="row h-100">
                <div id="questao1" class="col-sm containerOpcoesResposta text-right">
                    <input id="checkBox1" class="form-check-input" type="checkBox" id="radio1"> 
                    <i id="fecharResposta1" class="fa-solid fa-trash fecharResposta" onclick="fecharContainerResposta('1')"></i>   
                    <div class="col-sm containerResposta">
                        <div id="digitarResposta1" class="digitarResposta" placeholder="Resposta..." data-max-length="50" contentEditable="plaintext-only" onchange="Display(1)"></div>
                    </div>
                </div>
                
                <div id="questao2" class="col-sm containerOpcoesResposta text-right">
                    <input id="checkBox2" class="form-check-input" type="checkBox" id="radio1"> 
                    <i id="fecharResposta2" class="fa-solid fa-trash fecharResposta" onclick="fecharContainerResposta('2')"></i>    
                    <div class="col-sm containerResposta">
                        <div id="digitarResposta2" class="digitarResposta" placeholder="Resposta..." data-max-length="50" contentEditable="plaintext-only" onfocusout="Display(2)"></div>
                    </div>
                </div>

                <div id="questao3" class="col-sm containerOpcoesResposta text-right">
                    <input id="checkBox3" class="form-check-input" type="checkBox" id="radio1"> 
                    <i id="fecharResposta3" class="fa-solid fa-trash fecharResposta" onclick="fecharContainerResposta('3')"></i>    
                    <div class="col-sm containerResposta">
                        <div id="digitarResposta3" class="digitarResposta" placeholder="Resposta..." data-max-length="50" contentEditable="plaintext-only" onfocusout="Display(3)"></div>
                    </div>
                </div>

                <div id="questao4" class="col-sm containerOpcoesResposta text-right">
                    <input id="checkBox4" class="form-check-input" type="checkBox" id="radio1"> 
                    <i id="fecharResposta4" class="fa-solid fa-trash fecharResposta" onclick="fecharContainerResposta('4')"></i>    
                    <div class="col-sm containerResposta">
                        <div id="digitarResposta4" class="digitarResposta" placeholder="Resposta..." data-max-length="50" contentEditable="plaintext-only" onfocusout="Display(4)"></div>
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