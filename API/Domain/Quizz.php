<?php

require 'conexao.php';

class Quizz {

    function MostrarImgPergunta($Id_utilizador,$ficheiro){
        $conexao = new Conexao();

        $caminhoAGuardar= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/ImagemTemporaria/';
        $nomeImagem = $ficheiro['file']['name'];
        $caminhoTemporario=$ficheiro["file"]["tmp_name"];

        //php basename for files
        $basename = basename($nomeImagem);
        $caminhoOriginal = $caminhoAGuardar.$basename;
        
        //Aqui como se sabe se existe uma imagem anterior ou o nome dela elimina-se todos os ficheiros dentro que neste caso só pode ser uma imagem 
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

        if(empty($questao)){
            return 'questaoVazia';
        }
        foreach ($dadosRespostas as $dadosRespostas) {
            if(empty($dadosRespostas)){
                return 'respostaVazia';
            }
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

        if($imagem != "http://localhost/PAP/Site/InserirDadosQuizz.php?"){
            //strrchr() serve para obter o último caracter com o mesmo nome e o texto que está á frente deles
            $imagem= strrchr($imagem,'BaseDados/');
            $imagem= '../'.$imagem;
            $nomeficheiro= strrchr($imagem,'/');

            for ($i=1; $i <= 10; $i++) { 
                if (!file_exists('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/Questao'.$i.'/')) {
                    mkdir('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/Questao'.$i.'/', 0777, true);
                    rename($imagem,'../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/Questao'.$i.$nomeficheiro);
                    break;
                }
            }
        }
        
        $stmt = $conexao->runQuery('INSERT INTO questoes (Id_quizz, textoQuestao) VALUES (:Id_quizz, :textoQuestao)');
        $stmt->execute(array(':Id_quizz' => $dataQuizzes['Id_quizz'], ':textoQuestao' => $questao));
        

        return "sadad";

    }
    
}