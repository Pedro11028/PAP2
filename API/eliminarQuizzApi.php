<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'eliminarQuizz':
        eliminarQuizz($_POST['Id_utilizador'], $_POST['tipoTemporario']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function eliminarQuizz($Id_utilizador, $tipoTemporario){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $confirmarEliminacao = $Quizz-> EliminarQuizz($Id_utilizador, $tipoTemporario);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($confirmarEliminacao);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>