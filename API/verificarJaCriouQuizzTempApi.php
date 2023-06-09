<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'verificarExistenciaQuizz':
        verificarExistenciaQuizz($_POST['Id_utilizador'], $_POST['tipoTemporario']);
    break;
    case 'verificarExistenciaQuizzAdmin':
        verificarExistenciaQuizzAdmin($_POST['tipoTemporario']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function verificarExistenciaQuizz($Id_utilizador, $tipoTemporario){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $obterResposta = $Quizz->VerificarExistenciaQuizz($Id_utilizador, $tipoTemporario);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterResposta);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

function verificarExistenciaQuizzAdmin($tipoTemporario){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $obterResposta = $Quizz->VerificarExistenciaQuizzAdmin($tipoTemporario);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterResposta);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>