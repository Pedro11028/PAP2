<!DOCTYPE html>
<html>
<head>
    <title>Language Quizz- Perfil</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">  
    <link rel="stylesheet" type="text/css" href="Perfil.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="https://kit.fontawesome.com/410e89720f.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
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




<div class="wrapper bg-white mt-sm-5">
    <div class="container-fluid">
        <div id="separarAvatarENivel" class="d-flex border-bottom">
            <img src="" id="imgPerfil">   
            <div class="col-xs-3 pl-2" id="img-section">
                <b>Avatar</b>
                <p>Permitido Jpg e Png</p>
                <button class="btn button border" onclick="openForm()"><b>Alterar imagem</b></button>
            </div>
            <div class="col-xs-3 col-md-3">    
                <img src="" id="nivel">
                <label Id="pontuacao" class="pontuacao" ></label>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="row py-2">
            <div class="container">
            <label class="informacoesUtilizador">Nome de Utilizador</label>
                <div class="d-flex">
                    <input class="form-control mr-2 inputDados" id="nomeUnico">
                        <button id="alterarNomeUnico" class="btn btn-primary" >Alterar</button>
                </div>
            </div>
        </div>
        <div class="row py-2">
            <div class="container">
                <label class="informacoesUtilizador">Nome</label>
                    <div class="d-flex">
                        <input class="form-control mr-2 inputDados" id="nomeCompleto">
                        <button id="alterarNome" class="btn btn-primary">Alterar</button>
                    </div>
            </div>
        </div>
        <div class="row py-2">
            <div class="container">
                <label class="informacoesUtilizador">Email</label>
                <div class="d-flex">
                    <input class="form-control mr-2 inputDados" id="email" readonly>
                </div>
            </div>
        </div>
        <div class="row py-2">
            <div class="container">
                <span class="label label-info">Quizzes Criados</span>
                <br>
                <label id="quizzesCriados"></label>
            </div>
        </div> 
        <div class="row py-2">
            <div class="container">
                <span class="label label-info">Quizzes Realizados</span>
                <br>
                <label id="quizzesRealizados"></label>
            </div>
        </div>
        <div id="separarInformacoesUtilizadorDeLinks" class="row py-2 border-bottom">
            <div class="container">
                <span class="label label-info">Número de avaliações realizadas</span>
                <br>
                <label id="avaliacoesFeitas"></label>
            </div>
        </div>
            <div class="py-1">
                <a class="outUtilizador" href="alterarPassword.html"> <i class="fa-solid fa-shield-halved"></i> Alterar password </a>
            </div>
            <div class="py-1">
                <a class="outUtilizador" href="eliminarConta.html"> <i class="fa-solid fa-trash"></i> Excluir conta </a>
            </div>
            <div class="py-1">
                <a class="outUtilizador" href="Logout.html"> <i class="fa-solid fa-arrow-right-from-bracket"></i> Sair </a>
            </div>

            
    </div>

    
  <div class="outCloseForm" id="showBackground">
      <div class='imagensPopUp wrapper bg-white mt-sm-5' id="showForm">
        <div>
        <form  method="post" enctype="multipart/form-data" id="guardarImgForm">
            <img src="" id="changeImgPerfil" >
            <input id="escolherImagem" type="file" name="file" class="custom newButton selecionarImg" accept="image/png, image/jpeg" onchange="displayClick()">
            <input id="mostrarFicheiro" type="text"  class="mostrarFicheiro selecionarImg" readonly>
            <button id="guardarImg" type="submit" style="float: right;" class='btn button border selecionarImgBtn'>Guardar</button>
        </form>
        
        </div>
          <hr class="separarImagens">
          <br>

            <label id="labelImg1" class="labelImage">
                <input class="radio" type="radio" id="radio1" name="groupOfimages"> 
                <img src="" id="selectImage1" class="selectImage" alt="">
                <p>nível 1</p>
            </label>       

            <label id="labelImg2" class="labelImage">
                <input class="radio" type="radio" id="radio2" name="groupOfimages"> 
                <img src="" id="selectImage2" class="selectImage" alt="">
                <p>nível 2</p>
            </label>

            <label id="labelImg3" class="labelImage">
                <input class="radio" type="radio" id="radio3" name="groupOfimages"> 
                <img src="" id="selectImage3" class="selectImage" alt="">
                <p>nível 3</p>
            </label>

            <label id="labelImg4" class="labelImage">
                <input class="radio" type="radio" id="radio4" name="groupOfimages"> 
                <img src="" id="selectImage4" class="selectImage" alt="">
                <p>nível 4</p>
            </label>

            <label id="labelImg5" class="labelImage">
                <input class="radio" type="radio" id="radio5" name="groupOfimages"> 
                <img src="" id="selectImage5" class="selectImage" alt="">
                <p>nível 5</p>
            </label>

            <label id="labelImg6" class="labelImage">
                <input class="radio" type="radio" id="radio6" name="groupOfimages"> 
                <img src="" id="selectImage6" class="selectImage" alt="">
                <p>nível 6</p>
            </label>

            <button style="float: right;" class="btn button border" id="saveCheckedAvatar"><b>Alterar</b></button>
            <button style="float: right;" class='btn button border' onclick="closeForm()">Cancelar</button>
      
      </div>
  </div>
    
  <script  src="perfil.js"></script>

</body>
</html>