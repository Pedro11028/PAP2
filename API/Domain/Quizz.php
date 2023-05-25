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
            $imagem= strrchr($imagem,'/');
            $nomeficheiro= strrchr($imagem,'/'); 

            for ($i=1; $i <= 10; $i++) { 
                if (!file_exists('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$i.'/')) {
                    mkdir('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$i.'/', 0755, true);
                    rename('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/ImagemTemporaria'.$imagem, 
                           '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$i.$nomeficheiro);
                    break;
                }
            }
        }
        
        $stmt = $conexao->runQuery('INSERT INTO questoes (Id_quizz, textoQuestao, imagem, tipoQuestao) VALUES (:Id_quizz, :textoQuestao, :imagem, :tipoQuestao)');
        $stmt->execute(array(':Id_quizz' => $dataQuizzes['Id_quizz'], ':textoQuestao' => $questao, ':imagem' => $imagem, ':tipoQuestao' => $tipoQuestao));
        
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


    function ObterDadosQuestoes_Quizzes($Id_utilizador){
        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND escolaridade = :escolaridade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':escolaridade' => "temporario"));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conexao->runQuery('SELECT Id_questao, nomeQuestao, imagem, tipoQuestao FROM questoes WHERE Id_quizz = :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $dataQuizzes['Id_quizz']));
        $dataQuestoes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Guarda um array dentro de um array por exemplo:  0 => Id_questao => 9

        $i=0;

        foreach ($dataQuestoes as $dadosDataQuestoes) {
            $stmt = $conexao->runQuery('SELECT COUNT(Id_resposta) as numRespostas FROM respostas WHERE Id_questao = :Id_questao');
            $stmt->execute(array(':Id_questao' => $dadosDataQuestoes['Id_questao']));
            $dataRespostas[$i] = $stmt->fetch(PDO::FETCH_ASSOC);

            switch ($dadosDataQuestoes['tipoQuestao']) {

                case 'mostrarAcerto':
                    $dataQuestoes[$i]['tipoQuestao']= 'Mostrar resposta';
                    break;
                
                case 'naoMostrarAcerto':
                    $dataQuestoes[$i]['tipoQuestao']= 'Não mostrar acerto';
                    break;

                case 'escreverResposta':
                    $dataQuestoes[$i]['tipoQuestao']= 'Escrever resposta';
                    break;

                case 'enquete':
                    $dataQuestoes[$i]['tipoQuestao']= 'Enquete';
                    break;
            }

            if(empty($dadosDataQuestoes['imagem'])){
                $dataQuestoes[$i]['imagem']= 'não';
            }else{
                $dataQuestoes[$i]['imagem']= 'sim';
            }

            $i +=1;
        }

        $filtrarDados = array(  'dadosQuestoes'=> $dataQuestoes, 
                                'numeroRespostas' => $dataRespostas
                            );

        return $filtrarDados;
    }
    

    function guardarNomeQuestao($nomeQuestao,$Id_questao){
        $conexao = new Conexao();

            $sql = 'UPDATE questoes SET nomeQuestao = :nomeQuestao WHERE Id_questao = :Id_questao';
            $stmt = $conexao->runQuery($sql);
            $stmt->bindParam(':Id_questao', $Id_questao, PDO::PARAM_INT);
            $stmt->bindParam(':nomeQuestao', $nomeQuestao);
            $execute = $stmt->execute();

            return "alteradoComSucesso";
    }
}