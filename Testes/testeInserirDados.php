<?php
require 'conexao.php';

if (!empty($_SESSION['loggedIn'])) {
    header('Location: index.php');
}
    // Obter variáveis do from
    $email = $_POST['email'];
    $password = $_POST['password'];
    
        try {

            $stmt = $connect->prepare('SELECT * FROM utilizadores WHERE email = :email');
            $stmt-> execute(array(':email' => $email));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($data == false) {
                echo "<script>alert('Utilizador não existe.')</script>";
            } else {
                if ($password == $data['password']) {
                    $_SESSION['utilizador'] = array($data['Id_utilizador'], $data['nomeCompleto'], $data['nomeUnico'],$data['email'], $data['password'], $data['imagemPerfil'], $data['pontuacao'],$data['permissao']);
                    $_SESSION["loggedIn"] = true;
                    
                    header("Location: index.php");
                    exit;
                } else {
                    echo "<script>alert('$password')</script>";
                }
            }
        }
        catch(PDOException $e) {
            $errMsg = $e->getMessage();
        }
?>