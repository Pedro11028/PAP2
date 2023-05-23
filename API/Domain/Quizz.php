<?php

require 'conexao.php';

class Quizz {

    function MostrarImgPergunta($Id_utilizador,$ficheiro){
        $conexao = new Conexao();

        $caminhoAGuardar= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/ImagemTemporaria/';
        $nomeImagem = $ficheiro['file']['name'];
        $caminhoTemporario= $ficheiro["file"]["tmp_name"];

        //php basename for files
        $basename = basename($nomeImagem);
        $caminhoOriginal = $caminhoAGuardar.$basename;
        
        //Aqui se existir uma imagem anterior a mesma é eliminada, isto é feito para prevenir erros de validação do caminho da nova imagem
        $Imagem = glob($caminhoAGuardar . '*');
            
        foreach ($Imagem as $imagens) {
            if (is_file($imagens)) {
                unlink($imagens);
            }
        }
        move_uploaded_file($caminhoTemporario,$caminhoOriginal);

        return $caminhoOriginal;


    }

    function InserirDados($Id_utilizador,$questao,$imagem,$tipoQuestao,$dadosRespostas,$respostasCorretas){
        $conexao = new Conexao();
        $limiteRespostas=0;

        if(empty($questao)){
            return 'questaoVazia';
        }
        foreach ($dadosRespostas as $dadosRespostaTamanho) {
            if(empty($dadosRespostaTamanho)){
                return 'respostaVazia';
            }
            $limiteRespostas+=1;
        }


        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND escolaridade = :escolaridade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':escolaridade' => "temporario"));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        if($dataQuizzes != true){

            $stmt = $conexao->runQuery('INSERT INTO quizzes (Id_utilizador) VALUES (:Id_utilizador)');
            $stmt->execute(array(':Id_utilizador' => $Id_utilizador));

            $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND escolaridade = :escolaridade');
            $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':escolaridade' => "temporario"));
            $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

            mkdir('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/', 0777, true);
        }

        
        //Verifica o número de questões existentes no quizz
        //Caso já tenha 10 então retorna a dizer que já está cheio
        //Antes de fazer o que está escrito anteriormente verifica-se se a imagem é válida
        if(empty($imagem) || str_contains($imagem, 'InserirDadosQuizz.php')){
            $imagem= "";
        }else{
            //strrchr() serve para obter o último caracter com o mesmo nome e o texto que está á frente deles
            $imagem= strrchr($imagem,'BaseDados/');
            $imagem= '../'.$imagem;
            $nomeficheiro= strrchr($imagem,'/');

            for ($i=1; $i <= 10; $i++) { 
                if (!file_exists('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/Questao'.$i.'/')) {
                    mkdir('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/Questao'.$i.'/', 0755, true);
                    rename($imagem,'../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/Questao'.$i.$nomeficheiro);
                    break;
                }
            }
        }
        
        $stmt = $conexao->runQuery('INSERT INTO questoes (Id_quizz, textoQuestao, imagem) VALUES (:Id_quizz, :textoQuestao, :imagem)');
        $stmt->execute(array(':Id_quizz' => $dataQuizzes['Id_quizz'], ':textoQuestao' => $questao, ':imagem' => $imagem));
        
        $stmt = $conexao->runQuery('SELECT MAX(`Id_questao`) as Id_questao FROM questoes WHERE Id_quizz = :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $dataQuizzes['Id_quizz']));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        
        for ($i=0; $i< $limiteRespostas; $i++) {
            if($respostasCorretas[$i] == "true"){
                $verdadeiroOuFalso= 'true';
            }else{
                $verdadeiroOuFalso= 'false';
            }

            $stmt = $conexao->runQuery('INSERT INTO respostas (Id_questao, respostaQuizz, valorResposta) VALUES (:Id_questao, :respostaQuizz, :valorResposta)');
            $stmt-> execute(array(':Id_questao' => $dataQuizzes['Id_questao'], ':respostaQuizz' => $dadosRespostas[$i], ':valorResposta' => $verdadeiroOuFalso));
        }

        return "dadosGuardadosComSucesso";
        

    }
    
}