<?php
require 'Domain/utilizador.php';

switch ($_POST['accao'])
{
    case 'alterarDadosUtilizador':
        alterarDadosUtilizador($_POST['Id_utilizador'],$_POST['nomeCompleto'],$_POST['nomeUnico'],$_POST['email'],$_POST['password'],$_POST['Imagem'],$_POST['pontuacao'],$_POST['permissao']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function alterarDadosUtilizador($Id_utilizador,$nomeCompleto,$nomeUnico,$email,$password,$Imagem,$pontuacao,$permissao){
    try {
        // Do your stuff  
        $utilizador = new Utilizador();
        $obterUtilizador = $utilizador->AlterarDadosUtilizador($Id_utilizador,$nomeCompleto,$nomeUnico,$email,$password,$Imagem,$pontuacao,$permissao);      
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