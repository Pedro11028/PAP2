<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'eliminar':
        eliminarAvaliacao($_POST['Id_avaliacao']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function eliminarAvaliacao($Id_avaliacao){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $eliminarAvaliacao = $Quizz-> EliminarAvaliacao($Id_avaliacao);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($eliminarAvaliacao);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>