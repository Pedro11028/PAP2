<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    // Obtém vários quizzes de acordo com a sua data, número de avalçiações e respostas
    case 'carregar':
        obterQuizzes();
    break;
    // Obtém dados de um quizz assim como as suas avaliações
    case 'obterDadosQuizzEAvaliacoes':
        obterDadosQuizzEAvaliacoes($_POST['Id_utilizador'],$_POST['Id_quizz']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function obterQuizzes(){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $obterQuizzes = $Quizz->ObterQuizzes();      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterQuizzes);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

function obterDadosQuizzEAvaliacoes($Id_utilizador,$Id_quizz){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $obterDadosQuizzEAvaliacoes = $Quizz->ObterDadosQuizzEAvaliacoes($Id_utilizador,$Id_quizz);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterDadosQuizzEAvaliacoes);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>