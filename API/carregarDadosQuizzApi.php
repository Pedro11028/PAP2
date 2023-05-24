<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'carregar':
        carregarDados($_POST['Id_utilizador']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function carregarDados($Id_utilizador){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $obterDados = $Quizz->ObterDadosQuestoes_Quizzes($Id_utilizador);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterDados);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>