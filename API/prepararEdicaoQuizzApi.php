<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'prepararQuizz':
        prepararQuizz($_POST['Id_quizz']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function prepararQuizz($Id_quizz){
    try {
        // Do your stuff
        $Quizz = new Quizz();
        $obterResposta = $Quizz-> PrepararEdicaoQuizz($Id_quizz);
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