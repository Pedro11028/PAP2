<!DOCTYPE html>
<html>
<head>
    <title>Language Quizz- Painel Admin Utilizadores</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="painelAdminUtilizadores.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
   
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
  

</style>

</head>
<body>

<script>

const permissao= localStorage.getItem("permissaoUtilizador");
    
    if(permissao != "admin"){
        window.location.href="painelAdminUtilizadores.pph";
    } 
</script>

<?php
include "menuFooter/menu.php";
?>

<div id="containerTabela" class="container">
    <form onsubmit="event.preventDefault()" id="PesquisarUtilizadores" class="form-inline my-2 my-lg-0"> <input id="utilizadorAPesquisar" class="form-control mr-sm-2" type="text" placeholder="Pesquisar Nome Único..."> <button id="pesquisarUtilizador" class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> </form>
    <br>
    <table id="tabela" class="table table-dark">
        <thead>
            <tr>
            <th scope="col">Id_utilizador</th>
            <th scope="col">Nome Único</th>
            <th scope="col">Email</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <!-- Local onde os utilzadores vão ser carregados -->
        </tbody>
    </table>
</div>

<script  src="painelAdminUtilizadores.js"></script>

</body>
</html>