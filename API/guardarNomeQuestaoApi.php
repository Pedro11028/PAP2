<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'guardar':
        guardarNomeQuestao($_POST['nomeQuestao'],$_POST['Id_questao']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function guardarNomeQuestao($nomeQuestao,$Id_questao){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $obterNomeQuestao = $Quizz->guardarNomeQuestao($nomeQuestao,$Id_questao);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterNomeQuestao);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>