<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'obterDados':
        obterDadosQuizz($_POST['Id_quizz']);
    break;
    case 'obterEGuardarDadosJogo':
        obterEGuardarDadosJogo($_POST['Id_quizz'], $_POST['Id_utilizador']);
    break;
    case 'guardarPontuacaoUtilizador':
        guardarPontuacaoUtilizador($_POST['Id_quizz'], $_POST['Id_utilizador'], $_POST['totalPontosAcumulados']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function obterDadosQuizz($Id_quizz){
    try {
        // Do your stuff
        $Quizz = new Quizz();
        $obterResposta = $Quizz-> ObterDadosJogoQuizz($Id_quizz);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterResposta);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

function obterEGuardarDadosJogo($Id_quizz, $Id_utilizador){
    try {
        // Do your stuff
        $Quizz = new Quizz();
        $obterResposta = $Quizz-> ObterEGuardarDadosJogo($Id_quizz, $Id_utilizador);
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterResposta);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

function guardarPontuacaoUtilizador($Id_quizz, $Id_utilizador, $totalPontosAcumulados){
    try {
        // Do your stuff
        $Quizz = new Quizz();
        $obterResposta = $Quizz-> GuardarPontuacaoUtilizador($Id_quizz, $Id_utilizador, $totalPontosAcumulados);
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