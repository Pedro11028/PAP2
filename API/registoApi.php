<?php
require 'Domain/utilizadorRegisto.php';

switch ($_POST['accao'])
{
    case 'registo':
        registo($_POST['nomeCompleto'],$_POST['nomeUnico'],$_POST['email'],$_POST['password']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("sucesso" => false, "mensagem " => "erro coma conexão com o request"));
        break;
}

function registo($nomeCompleto,$nomeUnico,$email,$password){
    try {
        // Do your stuff  
        $utilizador = new Utilizador();
        $obterUtilizador = $utilizador->UtilizadorGuardarConfirmar($nomeCompleto, $nomeUnico, $email, $password);     
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo $obterUtilizador;
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => "erro de conexão com a base de dados"));
        return;
    }

}

?>