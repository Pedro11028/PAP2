<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'atualizarDados':
        atualizarDados($_POST['Id_utilizador'],$_POST['Id_questao'],$_POST['questao'],$_POST['imagem'],$_POST['caminhoDiretorio'],$_POST['tipoQuestao'],$_POST['dadosRespostas'],$_POST['respostasCorretas'],$_POST['tipoTemporario']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function atualizarDados($Id_utilizador,$Id_questao,$questao,$imagem,$caminhoDiretorio,$tipoQuestao,$dadosRespostas,$respostasCorretas, $tipoTemporario){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $atualizarDados = $Quizz-> AtualizarDadosQuestao($Id_utilizador,$Id_questao,$questao,$imagem,$caminhoDiretorio,$tipoQuestao,$dadosRespostas,$respostasCorretas, $tipoTemporario);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($atualizarDados);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>