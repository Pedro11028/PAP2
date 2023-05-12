<?php
require 'Domain/utilizador.php';

switch ($_POST['accao'])
{
    case 'alterarNome':
        alterarNome($_POST['Id_utilizador'],$_POST['nomeCompleto']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function alterarNome($Id_utilizador,$nomeCompleto){
    try {
        // Do your stuff  
        $utilizador = new Utilizador();
        $obterUtilizador = $utilizador->AlterarNome($Id_utilizador,$nomeCompleto);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterUtilizador);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>