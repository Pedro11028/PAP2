<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'carregar':
        obterQuizzes();
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

?>