<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'guardar':
        guardarQuizz($_POST['Id_utilizador'],$_POST['nomeQuizz'],$_POST['TemaQuizz'],$_POST['escolariedade'],$_POST['imagem']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function guardarQuizz($Id_utilizador,$nomeQuizz,$TemaQuizz,$escolariedade,$imagem){
    try {
        // Do your stuff
        $Quizz = new Quizz();
        $guardarDados = $Quizz-> GuardarDadosQuizz($Id_utilizador,$nomeQuizz,$TemaQuizz,$escolariedade,$imagem);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($guardarDados);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>