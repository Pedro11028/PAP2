<?php

require 'conexao.php';

class Quizz {

    function MostrarImgPergunta($Id_utilizador,$ficheiro){
        $conexao = new Conexao();
        $i=0;
        //Aqui vão ser criados vários diretórios temporários assim permitindo que o utilizador possa criar vários quizzes com imagens diferentes ao mesmo tempo
        while($i >= 0){
            $i +=1;
            if (!file_exists('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/ImagemTemporaria'.$i)) {
                mkdir('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/ImagemTemporaria'.$i);
                $caminhoAGuardar= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/ImagemTemporaria'.$i.'/';
                break;
            }
        }
        
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


    function VerificarExistenciaQuizz($Id_utilizador){
        $conexao = new Conexao();
        
        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND escolaridade = :escolaridade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':escolaridade' => "temporario"));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        if($dataQuizzes == true){
            return 'existe';
        }else{
            return 'naoExiste';
        }
    }

    function InserirDados($Id_utilizador,$questao,$imagem,$caminhoDiretorio,$tipoQuestao,$dadosRespostas,$respostasCorretas){
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

        $verificarExistenciaDeRespostasCorretas= 0;

        for ($i=0; $i< $limiteRespostas; $i++) {
            if($respostasCorretas[$i] == "true"){
                $verificarExistenciaDeRespostasCorretas = 1;
            }
        }

        if($verificarExistenciaDeRespostasCorretas == 0){
            return 'nenhumaRespostaCorreta';
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
            //strrchr() serve para obter o último caractere com o mesmo nome e o texto que está á frente deles
            $caminhoImagem= strstr($imagem, '/BaseDados');
            $caminhoDiretorio= strstr($caminhoDiretorio, '/BaseDados');
            $nomeficheiro= strrchr($imagem,'/'); 

            for ($i=1; $i <= 10; $i++) { 
                if (!file_exists('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$i.'/')) {
                    mkdir('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$i.'/', 0755, true);
                    rename('..'.$caminhoImagem, 
                           '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$i.$nomeficheiro);
                    //Elimina o diretorio vazio
                    rmdir('..'.$caminhoDiretorio);
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



    function eliminarDiretorioTemporario($caminhoImagem, $caminhoDiretorio){
        $caminhoImagem= strrchr($caminhoImagem,'/');
        $caminhoDiretorio= strstr($caminhoDiretorio, '/BaseDados');

        if(!strpos($caminhoDiretorio, '/QuestaoComImagem') && !strpos($caminhoImagem, '/editarDadosQuestao')){
            unlink('..'.$caminhoDiretorio.$caminhoImagem);
            rmdir('..'.$caminhoDiretorio);
        }

        return 'sucesso';
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




    function ObterDadosQuestao($Id_questao, $Id_utilizador){
        $conexao = new Conexao();
        $i=0; //guardar ordem da questao

        $stmt = $conexao->runQuery('SELECT Id_quizz, textoQuestao, tipoQuestao FROM questoes WHERE Id_questao = :Id_questao');
        $stmt->execute(array(':Id_questao' => $Id_questao));
        $dataQuestao = $stmt->fetch(PDO::FETCH_ASSOC);

        //Aqui será feita uma contagem para obter o número da ordem dessa questao
        //Ou seja se ela for a menor será a nº1 se for a segunda menor será a nº2 e por assim adiante
        $stmt = $conexao->runQuery('SELECT Id_questao, imagem FROM questoes WHERE Id_quizz = :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $dataQuestao['Id_quizz']));
        $dataImagemQuestoes = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // "$posicaoQuestoesComImagem" serve para verificar a posição em que se encontra dentre as questões que têm uma imagem
        $posicaoQuestoesComImagem = 0;
        // "$contemImagem" serve para verificar se a questão atual contém uma imagem na base de dados 
        $contemImagem = 'false';
        $tamanhoArray = count($dataImagemQuestoes);

        foreach ($dataImagemQuestoes as $dadosImagemQuestoes_temporario) {
            if(!empty($dadosImagemQuestoes_temporario['imagem'])){
                $posicaoQuestoesComImagem +=1;
                $contemImagem= 'true';
            }else{
                $contemImagem= 'false';
            }
            if($dadosImagemQuestoes_temporario['Id_questao'] == $Id_questao){
                break;
            }
        }
        
        if($contemImagem != 'true'){
            $imagemQuestao= "";
        }else{
            $imagemQuestao= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuestao['Id_quizz'].'/QuestaoComImagem'.$posicaoQuestoesComImagem.$dadosImagemQuestoes_temporario['imagem'];
        }

        $stmt = $conexao->runQuery('SELECT respostaQuizz, valorResposta FROM respostas WHERE Id_questao = :Id_questao');
        $stmt->execute(array(':Id_questao' => $Id_questao));
        $dataRespostas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $filtrarDados = array(  'dadosQuestao'=> $dataQuestao,
                                'dadosRespostas' => $dataRespostas,
                                'imagemQuestao'=> $imagemQuestao
                             );
        
        return $filtrarDados;
    }

    function atualizarDadosQuestao($Id_utilizador,$Id_questao,$textoQuestao,$imagem,$caminhoDiretorio,$tipoQuestao,$dadosRespostas,$respostasCorretas){
        $conexao = new Conexao();

        $limiteRespostas=0;

        if(empty($textoQuestao)){
            return 'questaoVazia';
        }
        foreach ($dadosRespostas as $dadosRespostaTamanho) {
            if(empty($dadosRespostaTamanho)){
                return 'respostaVazia';
            }
            $limiteRespostas+=1;
        }

        $verificarExistenciaDeRespostasCorretas= 0;

        for ($i=0; $i< $limiteRespostas; $i++) {
            if($respostasCorretas[$i] == "true"){
                $verificarExistenciaDeRespostasCorretas = 1;
            }
        }

        if($verificarExistenciaDeRespostasCorretas == 0){
            return 'nenhumaRespostaCorreta';
        }


        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND escolaridade = :escolaridade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':escolaridade' => "temporario"));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        $caminhoImagem= strstr($imagem, '/BaseDados');
        $caminhoDiretorio= strstr($caminhoDiretorio, '/BaseDados');
        $nomeficheiro= strrchr($imagem,'/');

        $stmt = $conexao->runQuery('SELECT Id_questao, imagem FROM questoes WHERE Id_quizz = :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $dataQuizzes['Id_quizz']));
        $dataImagemQuestoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        // "$posicaoQuestoesComImagem" serve para verificar a posição em que se encontra dentre as questões que têm uma imagem
        $posicaoQuestoesComImagem = 0;
        // "$contemImagem" serve para verificar se a questão atual contém uma imagem na base de dados 
        $contemImagem = 'false';
        $tamanhoArray = count($dataImagemQuestoes);

        foreach ($dataImagemQuestoes as $dadosImagemQuestoes_temporario) {
            if(!empty($dadosImagemQuestoes_temporario['imagem'])){
                $posicaoQuestoesComImagem +=1;
                $contemImagem= 'true';
            }else{
                $contemImagem= 'false';
            }
            if($dadosImagemQuestoes_temporario['Id_questao'] == $Id_questao){
                break;
            }
        }

        //Primeiro verifica se retornou vazio ou o nome da página, se sim então vai eliminar a imagem ou seja a pasta que a armazena também é eliminada cazo ela já existisse antes
        if(empty($imagem) || str_contains($imagem, '/editarDadosQuestao.php')){
            $nomeficheiro= "";
           
             if(file_exists('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$posicaoQuestoesComImagem.$dadosImagemQuestoes_temporario['imagem'])){
                 unlink('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$posicaoQuestoesComImagem.$dadosImagemQuestoes_temporario['imagem']);
                 rmdir('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$posicaoQuestoesComImagem);
                

                 $iMinus1= $posicaoQuestoesComImagem;

                 for ($i= $posicaoQuestoesComImagem; $i <= 10; $i++) {
                    if (file_exists('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$i.'/')) {
                        $caminhoImagem = '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'];
                        rename($caminhoImagem.'/QuestaoComImagem'.$i.'/', $caminhoImagem.'/QuestaoComImagem'.$iMinus1.'/');
                        $iMinus1 += 1;
                        
                    }
                 }
             }

        }else{

            //Verifica se a imagem foi alterada
            if(!strpos($caminhoDiretorio, '/QuestaoComImagem')){

                if($contemImagem == 'true'){
                        unlink('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$posicaoQuestoesComImagem.$dadosImagemQuestoes_temporario['imagem']);
                        rename('..'.$caminhoDiretorio.$nomeficheiro, 
                                '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$posicaoQuestoesComImagem.$nomeficheiro);

                        rmdir('..'.$caminhoDiretorio);
                }else{
                    //Como as questões com imagens que foram contadas não contam com esta questão é adicionado um para defenir a posição da questão atual entre as questões que têm iamgem
                    $posicaoQuestoesComImagem += 1;
                    $iplus1 = $posicaoQuestoesComImagem;

                    for ($i= $posicaoQuestoesComImagem; $i <= 10; $i++) { 
                        $iplus1 += 1;
                        if (file_exists('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$i.'/')) {
                            $caminhoImagem = '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'];
                            rename($caminhoImagem.'/QuestaoComImagem'.$i.'/', $caminhoImagem.'/QuestaoComImagem'.$iplus1.'a/');
                        }
                    }

                    $iplus1 = $posicaoQuestoesComImagem;

                    for ($i= $posicaoQuestoesComImagem; $i <= 10; $i++) {
                        if (file_exists('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$i.'a/')) {
                            $caminhoImagem = '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'];
                            rename($caminhoImagem.'/QuestaoComImagem'.$i.'a/', $caminhoImagem.'/QuestaoComImagem'.$i.'/');
                        }
                    }

                    mkdir('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$posicaoQuestoesComImagem.'/', 0755, true);
                    rename('..'.$caminhoDiretorio.$nomeficheiro, 
                           '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/QuestaoComImagem'.$posicaoQuestoesComImagem.$nomeficheiro);
                }
            }
        }

        $sql = 'UPDATE questoes SET textoQuestao = :textoQuestao, imagem= :imagem WHERE Id_questao = :Id_questao';
        $stmt = $conexao->runQuery($sql);    
        $stmt->bindParam(':Id_questao', $Id_questao, PDO::PARAM_INT);
        $stmt->bindParam(':textoQuestao', $textoQuestao);
        $stmt->bindParam(':imagem', $nomeficheiro);
        $execute = $stmt->execute();


         $sql = 'DELETE FROM respostas WHERE Id_questao = :Id_questao';
         $stmt= $conexao->runQuery($sql);
         $stmt->bindParam(':Id_questao', $Id_questao);
         $stmt->execute();

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
             $stmt-> execute(array(':Id_questao' => $Id_questao, ':respostaQuizz' => $dadosRespostas[$i], ':valorResposta' => $verdadeiroOuFalso));
         }

        return "dadosGuardadosComSucesso";
    }
}