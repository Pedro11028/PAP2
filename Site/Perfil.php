<!DOCTYPE html>
<html>
<head>
    <title>Language Quizz- Perfil</title>
    <meta charset="utf-8">
</style>

</head>
<body>
<?php


//     require 'conexao.php';

//     if($_SESSION["loggedIn"] == false){
//         header("Location: index.php");
//     }

//     if($_SESSION['utilizador']==true){        
//         $id_utilizador= $_SESSION['utilizador'] [0];
//         $nome= $_SESSION['utilizador'] [1];
//         $nomeUnico=$_SESSION['utilizador'] [2];
//         $email= $_SESSION['utilizador'] [3];
//         $password= $_SESSION['utilizador'] [4];
//         $permissao= $_SESSION['utilizador'] [7];
//     }

//     if(!empty($_SESSION['mensagem'])) {
//         $mensagem = $_SESSION['mensagem'];
//         echo "<script> alert('$mensagem')</script>";
//         unset($_SESSION['mensagem']);
//     }   

//         $sql = $connect->prepare('SELECT * FROM utilizadores WHERE Id_utilizador = :id_utilizador');
//         $sql-> execute(array(':id_utilizador' => $id_utilizador));
//         $data = $sql->fetch(PDO::FETCH_ASSOC);

//         $guardarNome= "$data[nomeCompleto]";

//         $pontuacao= "";
//         $pontuacao = "$data[pontuacao]";
//         $nivel= "0";

//         intval($pontuacao);

//         switch (true) {

//             case ($pontuacao >=100 && $pontuacao <200):
//                 $nivel="1";
//                 break;

//             case ($pontuacao >=200 && $pontuacao <300):
//                 $nivel="2";
//                 break;

//             case ($pontuacao >=300 && $pontuacao <400):
//                 $nivel="3";
//                 break;

//             case ($pontuacao >=400 && $pontuacao <500):
//                 $nivel="4";
//                 break;
//             case $pontuacao >=500:
//                 $nivel="5";
//                 break;
//         }

//     if (isset($_POST['alterarNome'])) {
//         $errMsg = '';
//         // Obter nome do FROM
//         $nome = $_POST['nome'];

//         try {
//             //Verificar se o nome é diferete do atual
//             if ($guardarNome != $nome) {
                
//                 $sql = 'UPDATE utilizadores SET nomeCompleto = :nome WHERE Id_utilizador = :Id_utilizador';

//                 // preparar declaração
//                 $stmt = $connect->prepare($sql);

//                 // atribuir valores aos parametros
//                 $stmt->bindParam(':Id_utilizador', $id_utilizador, PDO::PARAM_INT);
//                 $stmt->bindParam(':nome', $nome);

//                 // exexutar a atualização
//                 if ($stmt->execute()) {
//                     $_SESSION['utilizador'] [1]= $nome;
                
//                     header("Location: refresh.php");
//                 }

                
//             } else {
//             echo "<script>alert('Woops! O nome não pode ser o mesmo.')</script>";
            
//             }

//     }catch(PDOException $error) {
//         echo $error->getMessage();
//     }
// }



include "menuFooter/menu.php";
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">  
    <link rel="stylesheet" type="text/css" href="Perfil.css">
    <script src="http://netdna.bootstrapcdn.com/font-awesome/6.0.0/css/font-awesome.min.css" crossorigin="anonymous"></script>
    <script type="text/javascript" src="jsPerfil.js" crossorigin="anonymous"></script>

  <div class="wrapper bg-white mt-sm-5">
    <div class="d-flex align-items-start py-3 border-bottom">
        <img src="" id="imgPerfil" alt="">
        <div class="pl-sm-4 pl-2" id="img-section">
            <b>Foto de perfil</b>
            <p>Ficheiros .png ou jpg</p>
            <button class="btn button border"><b>Alterar</b></button>
        </div>
    </div>
    <div class="py-2">
        <div class="row py-2">
            <div class="container">
                <label>Nome Completo</label>
                <div class="d-flex">
                    <input class="form-control mr-2 inputDados">
                    <button class="btn btn-primary">Mudar Nome</button>
                </div>
            </div>
        </div>
        <div class="row py-2">
            <div class="container">
                <label>Email</label>
                <div class="d-flex">
                    <input class="form-control mr-2 inputDados">
                    <button class="btn btn-primary">Mudar Password</button>
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
        <div class="row py-2 border-bottom">
            <div class="container">
                <span class="label label-info">Número de avaliações realizadas</span>
                <br>
                <label id="avaliacoesFeitas"></label>
            </div>
        </div> 
        <p></p>
            <div class="py-1">
                <a class="outUtilizador" href="Logout.html"> <i class="fa-solid fa-arrow-right-from-bracket"></i> Sair </a>
            </div>
            <div class="py-1">
                <a class="outUtilizador" href="eliminarConta.html"> <i class="fa-solid fa-trash"></i> Excluir conta </a>
            </div>
  
  <div class="outCloseForm" id="showBackground">
      <div class='imagensPopUp' id="showForm">
          <div class="borderFront">
              <img id='imgPerfil'>
              &nbsp&nbsp&nbsp
              <span  style="vertical-align: top;">Imagem Atual</span>
          </div>
  
          <br>
          <hr class="separarImagens">
          <br>
  
          <form action="" method="POST">
          
      
          </form>
          <div class="borderFront">
              <button class='changeImg' onclick="closeForm()">Cancelar</button>
          </div>
      </div>
  </div>
    
</body>
</html>