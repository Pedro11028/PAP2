<?php
require 'Domain/utilizador.php';

switch ($_POST['accao'])
{
    case 'obterUtilizadores':
        obterUtilizadores($_POST['nomeUnicoAPesquisar']);
    break;
    case 'obterDadosUtilizador':
        obterDadosUtilizador($_POST['Id_Utilizador']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function obterUtilizadores($nomeUnicoAPesquisar){
    try {
        // Do your stuff  
        $utilizador = new Utilizador();
        $obterUtilizadores = $utilizador->ObterUtilizadores($nomeUnicoAPesquisar);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($obterUtilizadores);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

function obterDadosUtilizador($Id_Utilizador){
    try {
        // Do your stuff  
        $utilizador = new Utilizador();
        $obterDadosUtilizador = $utilizador->ObterDadosUtilizador($Id_Utilizador);      
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