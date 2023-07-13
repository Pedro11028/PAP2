<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'guardarDados':
        guardarDados($_POST['Id_utilizador'], $_POST['Id_quizz'], $_POST['textoAvaliacao'], $_POST['notaAvaliacao']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function guardarDados($Id_utilizador, $Id_quizz, $textoAvaliacao, $notaAvaliacao){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $obterDadosQuestao = $Quizz-> GuardarDadosAvaliacao($Id_utilizador, $Id_quizz, $textoAvaliacao, $notaAvaliacao);      
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