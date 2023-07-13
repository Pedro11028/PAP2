<!DOCTYPE html>
<html>
<head>
    <title>Language Quizz- Painel Admin Ver Utilizador</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="dadosUtilizadorPainelAdmin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
   
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
  

</style>

</head>
<body>

<?php
include "menuFooter/menu.php";
?>

<div id="containerTabela" class="container">

<form>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">Id Utilizador</label>
    <div class="col-sm-8">
      <input id="Id_utilizador" type="text" class="form-control" disabled>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">Nome Completo:</label>
    <div class="col-sm-8">
      <input id="nomeCompleto" type="text" class="form-control" placeholder="Nome Completo..." required>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">Nome Unico:</label>
    <div class="col-sm-8">
      <input id="nomeUnico" type="text" class="form-control" placeholder="Nome Unico..." required>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">Email:</label>
    <div class="col-sm-8">
      <input id="email" type="email" class="form-control" placeholder="Email..." required>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">Password:</label>
    <div class="col-sm-8">
      <input id="password" type="text" class="form-control" placeholder="Password..." required>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">Caminho Imagem:</label>
    <div class="col-sm-8">
      <input id="Imagem" type="text" class="form-control" placeholder="Caminho Imagem ex:(img/avatar5.gif)">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">Pontuação:</label>
    <div class="col-sm-8">
      <input id="pontuacao" type="text" class="form-control" id="inputPassword" placeholder="Pontuação...">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-4 col-form-label">Permissão:</label>
    <div class="col-sm-8">
      <input id="permissao" type="text" class="form-control" id="inputPassword" placeholder="Permissão..." required>
    </div>
  </div>
</form>

</div>

<script  src="dadosUtilizadorPainelAdmin.js"></script>

</body>
</html>