<?php
require 'Domain/utilizador.php';

switch ($_POST['accao'])
{
    case 'carregar':
        Carregar($_POST['Id_utilizador']);
    break;
    case 'carregarTodosOsDados':
        carregarTodosOsDados($_POST['Id_utilizador']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function Carregar($Id_utilizador){
    try {
        // Do your stuff  
        $utilizador = new Utilizador();
        $obterDadosUtilizador = $utilizador->Carregar($Id_utilizador);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterDadosUtilizador);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

function carregarTodosOsDados($Id_utilizador){
    try {
        // Do your stuff  
        $utilizador = new Utilizador();
        $obterDadosUtilizador = $utilizador->CarregarTodosOsDados($Id_utilizador);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterDadosUtilizador);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}
?>