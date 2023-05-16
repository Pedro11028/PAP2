<!DOCTYPE html>
<html>
<head>
    <title>Language Quizz- Inserir Dados</title>
    <meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="https://kit.fontawesome.com/410e89720f.js" crossorigin="anonymous"></script>

</style>

</head>
<body>
<script>
    if (document.cookie.indexOf('idCookie') > -1 ) {
    }else{
      location.href="login.html";
    }
</script>

<?php
include "menuFooter/menu.php";
?>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">  
    <link rel="stylesheet" type="text/css" href="InserirDadosQuizz.css">

       

    <div class="containerQuestao alinharQuestao">
        <img id="imagemQuestao" src="img/1.png" class="imagemQuestao">
        <div id="digitarQuestao" class="digitarQuestao" placeholder="Digitar Questão..." contentEditable></div>
    </div>


    <div id="footer">
            <div class=" .col-md-offset-* containerResposta">
                <div class="digitarResposta" placeholder="Resposta..." contentEditable></div>
            </div>

            <div class=" .col-md-offset-*  containerResposta">
                <div class="digitarResposta" placeholder="Resposta..." contentEditable></div>
            </div>

            <div class=".col-md-offset-* containerResposta">
                <div class="digitarResposta" placeholder="Resposta..." contentEditable></div>
            </div>

            <div class=".col-md-offset-* containerResposta">
                <div class="digitarResposta" placeholder="Resposta..." contentEditable></div>
            </div>
    </div>


<script  src="InserirDadosQuizz.js"></script>

</body>
</html>