<?php
require 'Domain/utilizador.php';

switch ($_POST['accao'])
{
    case 'Alterar':
        alterarPass($_POST['passwordAtual'],$_POST['passwordNova'],$_POST['confirmarPass'],$_POST['Id_utilizador']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function alterarPass($passwordAtual,$passwordNova,$confirmarPass,$Id_utilizador){
    try {
        // Do your stuff  
        $utilizador = new Utilizador();
        $eliminarUtilizador = $utilizador->Alterar($passwordAtual,$passwordNova,$confirmarPass,$Id_utilizador);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($eliminarUtilizador);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>