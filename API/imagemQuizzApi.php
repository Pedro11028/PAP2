<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'mostrarImg':
        mostrarImg($_POST['Id_utilizador'],$_FILES);
    break;
    case 'guardarImg':
        guardarImg($_POST['Id_utilizador'],$_POST['imagem']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function mostrarImg($Id_utilizador,$ficheiro){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $obterImagem = $Quizz-> MostrarImagemQuizz($Id_utilizador, $ficheiro);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo $obterImagem;
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

function guardarImg($Id_utilizador, $imagem){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $obterImagem = $Quizz-> GuardarImagemQuizz($Id_utilizador, $imagem);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo $obterImagem;
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>