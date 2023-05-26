<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'obterDados':
        obterDadosQuestao($_POST['Id_questao'],$_POST['Id_utilizador']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function obterDadosQuestao($Id_questao, $Id_utilizador){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $obterDadosQuestao = $Quizz-> ObterDadosQuestao($Id_questao, $Id_utilizador);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterDadosQuestao);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>