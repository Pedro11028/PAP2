<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'eliminarDiretorio':
        eliminarDiretorio($_POST['caminhoImagem'], $_POST['caminhoDiretorio']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function eliminarDiretorio($caminhoImagem, $caminhoDiretorio){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $confirmarEliminacao = $Quizz->eliminarDiretorioTemporario($caminhoImagem, $caminhoDiretorio);      
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