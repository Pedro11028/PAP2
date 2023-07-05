<?php
require 'Domain/Quizz.php';

switch ($_POST['accao'])
{
    case 'inserirDados':
        inserirDados($_POST['Id_utilizador'],$_POST['questao'],$_POST['imagem'],$_POST['caminhoDiretorio'],$_POST['tipoQuestao'],$_POST['dadosRespostas'],$_POST['respostasCorretas'], $_POST['mostrarRespostaCorreta'], $_POST['mostrarPercentagemEscolhas']);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function inserirDados($Id_utilizador,$questao,$imagem,$caminhoDiretorio,$tipoQuestao,$dadosRespostas,$respostasCorretas, $mostrarRespostaCorreta, $mostrarPercentagemEscolhas){
    try {
        // Do your stuff  
        $Quizz = new Quizz();
        $inserirDados = $Quizz-> InserirDados($Id_utilizador,$questao,$imagem,$caminhoDiretorio,$tipoQuestao,$dadosRespostas,$respostasCorretas, $mostrarRespostaCorreta, $mostrarPercentagemEscolhas);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo json_encode($inserirDados);
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>