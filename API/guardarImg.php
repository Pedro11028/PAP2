<?php
require 'Domain/utilizador.php';

switch ($_POST['accao'])
{
    case 'guardarImg':
        guardarImg($_POST['Id_utilizador'],$_POST['imagemPerfil']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function guardarImg($Id_utilizador,$imagemPerfil){
    try {
        // Do your stuff  
        $utilizador = new Utilizador();
        $obterUtilizador = $utilizador->GuardarImagem($Id_utilizador,$imagemPerfil);      
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