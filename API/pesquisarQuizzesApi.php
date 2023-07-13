<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'pesquisar':
        pesquisar($_POST['Id_utilizador'], $_POST['textoAPesquisar'], $_POST['tipoPesquisa']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function pesquisar($Id_utilizador, $textoAPesquisar, $tipoPesquisa){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $obterDados = $Quizz->PesquisarQuizzes($Id_utilizador, $textoAPesquisar, $tipoPesquisa);      
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