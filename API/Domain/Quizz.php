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


    function VerificarExistenciaQuizz($Id_utilizador, $tipoTemporario){
        $conexao = new Conexao();
        
        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND dificuldade = :dificuldade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':dificuldade' => $tipoTemporario));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        if($dataQuizzes == true){
            return 'existe';
        }else{
            return 'naoExiste';
        }
    }

    function VerificarExistenciaQuizzAdmin( $tipoTemporario){
        $conexao = new Conexao();
        
        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE dificuldade = :dificuldade');
        $stmt->execute(array(':dificuldade' => $tipoTemporario));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        if($dataQuizzes == true){
            return 'existe';
        }else{
            return 'naoExiste';
        }
    }

    function InserirDados($Id_utilizador,$questao,$imagem,$caminhoDiretorio,$tipoQuestao,$dadosRespostas,$respostasCorretas, $mostrarRespostaCorreta, $mostrarPercentagemEscolhas, $tipoTemporario){
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


        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND dificuldade = :dificuldade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':dificuldade' => $tipoTemporario));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        if($dataQuizzes != true){

            $stmt = $conexao->runQuery('INSERT INTO quizzes (Id_utilizador) VALUES (:Id_utilizador)');
            $stmt->execute(array(':Id_utilizador' => $Id_utilizador));

            $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND dificuldade = :dificuldade');
            $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':dificuldade' => $tipoTemporario));
            $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

            mkdir('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/', 0755, true);
            mkdir('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/ImagemQuizz/', 0755, true);
            mkdir('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/ImagemQuizzTemporaria/', 0755, true);
        }

        
        //Verifica o número de questões existentes no quizz
        //Caso já tenha 10 então retorna a dizer que já está cheio
        //Antes de fazer o que está escrito anteriormente verifica-se se a imagem é válida
        if(empty($imagem) || str_contains($imagem, 'InserirDadosQuizz.php') || str_contains($imagem, 'InserirDadosQuizzAdmin.php')){
            $nomeficheiro= "";
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
        
        $nomeQuestao = substr($questao, 0, 30);;

        $stmt = $conexao->runQuery('INSERT INTO questoes (Id_quizz, textoQuestao, nomeQuestao, imagem, tipoQuestao, mostrarRespostaCorreta, mostrarPercentagemEscolhas) VALUES (:Id_quizz, :textoQuestao, :nomeQuestao, :imagem, :tipoQuestao, :mostrarRespostaCorreta, :mostrarPercentagemEscolhas)');
        $stmt->execute(array(':Id_quizz' => $dataQuizzes['Id_quizz'], ':textoQuestao' => $questao, ':nomeQuestao' => $nomeQuestao, ':imagem' => $nomeficheiro, ':tipoQuestao' => $tipoQuestao, ':mostrarRespostaCorreta' => $mostrarRespostaCorreta, ':mostrarPercentagemEscolhas' => $mostrarPercentagemEscolhas));
        
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

        if(!str_contains($caminhoDiretorio, '/QuestaoComImagem') && !str_contains($caminhoImagem, '/editarDadosQuestao') && !str_contains($caminhoImagem, '/InserirDadosQuizz.php') && !str_contains($caminhoImagem, '/InserirDadosQuizzAdmin') && !str_contains($caminhoImagem, '/InserirDadosQuizzAdmin.php')){
            if (file_exists('..'.$caminhoDiretorio)) {
                unlink('..'.$caminhoDiretorio.$caminhoImagem);
                rmdir('..'.$caminhoDiretorio);
            }
        }

        return 'sucesso';
    }



    function ObterDadosQuestoes_Quizzes($Id_utilizador){
        $conexao = new Conexao();
        $quizzNaoExiste= array(  0 => 'true');

        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND dificuldade = :dificuldade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':dificuldade' => "temporario"));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$dataQuizzes){

            return $quizzNaoExiste;
        }

        $stmt = $conexao->runQuery('SELECT Id_questao, nomeQuestao, imagem, tipoQuestao FROM questoes WHERE Id_quizz = :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $dataQuizzes['Id_quizz']));
        $dataQuestoes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Guarda um array dentro de um array por exemplo:  0 => Id_questao => 9

        $i=0;

        foreach ($dataQuestoes as $dadosDataQuestoes) {

            //Aqui são usados algumas funções, a função COUNT conta todos os campos dependendo dos filtros aplicados, caso o campo é o "Id_avaliação" da tabela "avaliacao"
            $stmt = $conexao->runQuery('SELECT COUNT(Id_resposta) as numRespostas FROM respostas WHERE Id_questao = :Id_questao');
            $stmt->execute(array(':Id_questao' => $dadosDataQuestoes['Id_questao']));
            $dataRespostas[$i] = $stmt->fetch(PDO::FETCH_ASSOC);

            switch ($dadosDataQuestoes['tipoQuestao']) {
                case 'selecionarResposta':
                    $dataQuestoes[$i]['tipoQuestao']= 'Selecionar Resposta';
                    break;

                case 'textoLivre':
                    $dataQuestoes[$i]['tipoQuestao']= 'Texto Livre';
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

    function ObterDadosQuestoes_QuizzesAdmin($Id_utilizador){
        $conexao = new Conexao();
        $quizzNaoExiste= array(  0 => 'true');

        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND dificuldade = :dificuldade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':dificuldade' => "temporarioAdmin"));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$dataQuizzes){

            return $quizzNaoExiste;
        }

        $stmt = $conexao->runQuery('SELECT Id_questao, nomeQuestao, imagem, tipoQuestao FROM questoes WHERE Id_quizz = :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $dataQuizzes['Id_quizz']));
        $dataQuestoes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Guarda um array dentro de um array por exemplo:  0 => Id_questao => 9

        $i=0;

        foreach ($dataQuestoes as $dadosDataQuestoes) {

            //Aqui são usados algumas funções, a função COUNT conta todos os campos dependendo dos filtros aplicados, caso o campo é o "Id_avaliação" da tabela "avaliacao"
            $stmt = $conexao->runQuery('SELECT COUNT(Id_resposta) as numRespostas FROM respostas WHERE Id_questao = :Id_questao');
            $stmt->execute(array(':Id_questao' => $dadosDataQuestoes['Id_questao']));
            $dataRespostas[$i] = $stmt->fetch(PDO::FETCH_ASSOC);

            switch ($dadosDataQuestoes['tipoQuestao']) {
                case 'selecionarResposta':
                    $dataQuestoes[$i]['tipoQuestao']= 'Selecionar Resposta';
                    break;

                case 'textoLivre':
                    $dataQuestoes[$i]['tipoQuestao']= 'Texto Livre';
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

        $stmt = $conexao->runQuery('SELECT Id_quizz, nomeQuestao, textoQuestao, tipoQuestao, mostrarRespostaCorreta, mostrarPercentagemEscolhas	 FROM questoes WHERE Id_questao = :Id_questao');
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

        $stmt = $conexao->runQuery('SELECT Id_resposta, respostaQuizz, valorResposta, vezesSelecionada FROM respostas WHERE Id_questao = :Id_questao');
        $stmt->execute(array(':Id_questao' => $Id_questao));
        $dataRespostas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $filtrarDados = array(  'dadosQuestao'=> $dataQuestao,
                                'dadosRespostas' => $dataRespostas,
                                'imagemQuestao'=> $imagemQuestao
                             );
        
        return $filtrarDados;
    }


    function atualizarDadosQuestao($Id_utilizador,$Id_questao,$textoQuestao,$imagem,$caminhoDiretorio,$tipoQuestao,$dadosRespostas,$respostasCorretas, $tipoTemporario){
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


        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND dificuldade = :dificuldade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':dificuldade' => $tipoTemporario));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$dataQuizzes){
            $caminhoImagem= strrchr($imagem,'/');
            $caminhoDiretorio= strstr($caminhoDiretorio, '/BaseDados');
    
            if(!str_contains($caminhoDiretorio, '/QuestaoComImagem') && !str_contains($caminhoImagem, '/editarDadosQuestao') && !str_contains($caminhoImagem, '/InserirDadosQuizz') && !str_contains($caminhoImagem, '/editarDadosQuestaoAdmin') && !str_contains($caminhoImagem, '/InserirDadosQuizzAdmin')){
                if (file_exists('..'.$caminhoDiretorio)) {
                    unlink('..'.$caminhoDiretorio.$caminhoImagem);
                    rmdir('..'.$caminhoDiretorio);
                }
            }

            return 'quizzNaoExiste';
        }

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
        if(empty($imagem) || str_contains($imagem, '/editarDadosQuestao.php') || str_contains($imagem, '/editarDadosQuestaoAdmin.php')){
            $nomeficheiro= "";

             //Verifica se o campo imagem da questão está vazio ou não na base de dados
             if(!empty($dadosImagemQuestoes_temporario['imagem'])){
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
                    rmdir('..'.$caminhoDiretorio);
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

    function GuardarNumeroRespostasDadas($Id_resposta, $vezesQueARespostaFoiSelecionada){
        $conexao = new Conexao();
        
        $vezesQueARespostaFoiSelecionada = $vezesQueARespostaFoiSelecionada + 1;
        
        $sql = 'UPDATE respostas SET vezesSelecionada = :vezesSelecionada WHERE Id_resposta = :Id_resposta';
        $stmt = $conexao->runQuery($sql);    
        $stmt->bindParam(':Id_resposta', $Id_resposta, PDO::PARAM_INT);
        $stmt->bindParam(':vezesSelecionada', $vezesQueARespostaFoiSelecionada);
        $execute = $stmt->execute();
        
        return $dataRespostas;
    }

    function EliminarQuestao($Id_utilizador, $Id_questao, $imagem, $caminhoDiretorio, $tipoTemporario){
        $conexao = new Conexao();
        
        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND dificuldade = :dificuldade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':dificuldade' => $tipoTemporario));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$dataQuizzes){
            $caminhoImagem= strrchr($imagem,'/');
            $caminhoDiretorio= strstr($caminhoDiretorio, '/BaseDados');
    
            if(!str_contains($caminhoDiretorio, '/QuestaoComImagem') && !str_contains($caminhoImagem, '/editarDadosQuestao') && !str_contains($caminhoImagem, '/InserirDadosQuizz') && !str_contains($caminhoImagem, '/editarDadosQuestaoAdmin') && !str_contains($caminhoImagem, '/editarDadosQuestaoAdmin')){
                if (file_exists('..'.$caminhoDiretorio)) {
                    unlink('..'.$caminhoDiretorio.$caminhoImagem);
                    rmdir('..'.$caminhoDiretorio);
                }
            }

            return 'quizzNaoExiste';
        }

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

        if(!empty($dadosImagemQuestoes_temporario['imagem'])){
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
        }

        //Caso haja uma imagem seja uma temporária elimina-a
        if(str_contains($imagem, '/ImagemTemporaria')){
            $caminhoDiretorio= strstr($caminhoDiretorio, '/BaseDados');
            $imagem= strrchr($imagem,'/');
    
            unlink('..'.$caminhoDiretorio.$imagem);
            rmdir('..'.$caminhoDiretorio);
        }
        

        $sql = 'DELETE FROM respostas WHERE Id_questao = :Id_questao';
        $stmt= $conexao->runQuery($sql);
        $stmt->bindParam(':Id_questao', $Id_questao);
        $stmt->execute();

        $sql = 'DELETE FROM questoes WHERE Id_questao = :Id_questao';
        $stmt= $conexao->runQuery($sql);
        $stmt->bindParam(':Id_questao', $Id_questao);
        $stmt->execute();

        return "dadosEliminadosComSucesso";
    }


    function EliminarQuizz($Id_utilizador, $tipoTemporario){
        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador AND dificuldade = :dificuldade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':dificuldade' => $tipoTemporario));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conexao->runQuery('SELECT Id_questao, nomeQuestao, imagem, tipoQuestao FROM questoes WHERE Id_quizz = :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $dataQuizzes['Id_quizz']));
        $dataQuestoes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Guarda um array dentro de um array por exemplo:  0 => Id_questao => 9

        $caminhoImagensQuestoes= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'];
        $existeFicheiros= true;
        $i= 1;

        foreach ($dataQuestoes as $dadosDataQuestoes) {
            if (!empty($dadosDataQuestoes['imagem'])) {
                unlink($caminhoImagensQuestoes.'/QuestaoComImagem'.$i.'/'.$dadosDataQuestoes['imagem']);
                rmdir($caminhoImagensQuestoes.'/QuestaoComImagem'.$i);
                $i+=1;
            }else{
                $existeFicheiros= false;
            }
            
            $sql = 'DELETE FROM respostas WHERE Id_questao = :Id_questao';
            $stmt= $conexao->runQuery($sql);
            $stmt->bindParam(':Id_questao', $dadosDataQuestoes['Id_questao']);
            $stmt->execute();
        }
        

        $limparImagensQuizz= glob('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/ImagemQuizz/*');
        $limparImagensQuizzTemporarias= glob('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/ImagemQuizzTemporaria/*');

        foreach ($limparImagensQuizz as $localAtual) {
            unlink($localAtual);
        }
        foreach ($limparImagensQuizzTemporarias as $localAtual) {
            unlink($localAtual);
        }

        $limparImagensQuizz= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/ImagemQuizz';
        $limparImagensQuizzTemporarias= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/ImagemQuizzTemporaria';

        if (file_exists($limparImagensQuizz)) {
            rmdir($limparImagensQuizz);
        }
        if (file_exists($limparImagensQuizzTemporarias)) {
            rmdir($limparImagensQuizzTemporarias);
        }
        if (file_exists($caminhoImagensQuestoes)) {
            rmdir($caminhoImagensQuestoes);
        }
        
        $sql = 'DELETE FROM questoes WHERE Id_quizz = :Id_quizz';
        $stmt= $conexao->runQuery($sql);
        $stmt->bindParam(':Id_quizz', $dataQuizzes['Id_quizz']);
        $stmt->execute();

        $sql = 'DELETE FROM avaliacao WHERE Id_quizz = :Id_quizz';
        $stmt= $conexao->runQuery($sql);
        $stmt->bindParam(':Id_quizz', $dataQuizzes['Id_quizz']);
        $stmt->execute();

        $sql = 'DELETE FROM quizzes_respondidos WHERE Id_quizz = :Id_quizz';
        $stmt= $conexao->runQuery($sql);
        $stmt->bindParam(':Id_quizz', $dataQuizzes['Id_quizz']);
        $stmt->execute();

        $sql = 'DELETE FROM quizzes WHERE Id_quizz = :Id_quizz';
        $stmt= $conexao->runQuery($sql);
        $stmt->bindParam(':Id_quizz', $dataQuizzes['Id_quizz']);
        $stmt->execute();

        return "dadosEliminadosComSucesso";
    }


    function MostrarImagemQuizz($Id_utilizador, $ficheiro, $tipoTemporario){
        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT Id_quizz, imagem FROM quizzes WHERE Id_utilizador = :Id_utilizador AND dificuldade = :dificuldade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':dificuldade' => $tipoTemporario));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        $caminhoAGuardar= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/ImagemQuizzTemporaria';

        $nomeImagem = $ficheiro['file']['name'];
        $caminhoTemporario= $ficheiro["file"]["tmp_name"];
        
        
        if(empty($nomeImagem)){
            return "imagemVazia";
        }

        //php basename for files
        $basename = basename($nomeImagem);
        $caminhoOriginal = $caminhoAGuardar.'/'.$basename;

        if(empty($dataQuizzes['imagem'])){
            move_uploaded_file($caminhoTemporario,$caminhoOriginal);

            $nomeImagem= '/'.$nomeImagem;

            $sql = 'UPDATE quizzes SET imagem = :imagem WHERE Id_quizz = :Id_quizz';
            $stmt = $conexao->runQuery($sql);
            $stmt->bindParam(':Id_quizz', $dataQuizzes['Id_quizz'], PDO::PARAM_INT);
            $stmt->bindParam(':imagem', $nomeImagem);
            $execute = $stmt->execute();

            return $caminhoOriginal;

        }else{
            if (file_exists($caminhoAGuardar.$dataQuizzes['imagem'])) {
                unlink($caminhoAGuardar.$dataQuizzes['imagem']);
            }
            move_uploaded_file($caminhoTemporario,$caminhoOriginal);

            $nomeImagem= '/'.$nomeImagem;

            $sql = 'UPDATE quizzes SET imagem = :imagem WHERE Id_quizz = :Id_quizz';
            $stmt = $conexao->runQuery($sql);
            $stmt->bindParam(':Id_quizz', $dataQuizzes['Id_quizz'], PDO::PARAM_INT);
            $stmt->bindParam(':imagem', $nomeImagem);
            $execute = $stmt->execute();

            return $caminhoOriginal;
        }
    }
    

    function GuardarImagemQuizz($Id_utilizador, $imagem, $tipoTemporario){
        $conexao = new Conexao();
        $caminhoImagem= 'vazio';

        $stmt = $conexao->runQuery('SELECT Id_quizz, imagem FROM quizzes WHERE Id_utilizador = :Id_utilizador AND dificuldade = :dificuldade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':dificuldade' => $tipoTemporario));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $tipoImagem= strrchr($imagem,'.');
        
        $caminhoACopiar= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/ImagemQuizz/imagem'.$tipoImagem;

        $limparImagensAnteriores= glob('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/ImagemQuizz/*');

        foreach ($limparImagensAnteriores as $localAtual) {
            unlink($localAtual);
        }

        if(!empty($imagem)){
            if (file_exists($caminhoImagem.$dataQuizzes['imagem'])) {
                unlink($caminhoImagem.$dataQuizzes['imagem']);
            }

            $caminhoImagem= strstr($imagem, '/BaseDados');
            $caminhoImagem= '..'.$caminhoImagem;
            
            rename($caminhoImagem,$caminhoACopiar);
        }

        return $caminhoACopiar;
    }

    function ObterDadosQuizz($Id_utilizador, $tipoTemporario){
        $conexao = new Conexao();
        
        $stmt = $conexao->runQuery('SELECT nomeQuizz, tema FROM quizzes WHERE Id_utilizador = :Id_utilizador AND dificuldade = :dificuldade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':dificuldade' => $tipoTemporario));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dataQuizzes;
    }

    function GuardarDadosQuizz($Id_utilizador,$nomeQuizz,$TemaQuizz,$escolariedade,$imagem,$tipoTemporario){
        $conexao = new Conexao();

        if(empty($nomeQuizz) || empty($TemaQuizz)){
            return 'camposVazios';
        }

        if(empty($escolariedade)){
            return 'escolariedadeVazia';
        }

        $stmt = $conexao->runQuery('SELECT Id_quizz, imagem FROM quizzes WHERE Id_utilizador = :Id_utilizador AND dificuldade = :dificuldade');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':dificuldade' => $tipoTemporario));
        $dataQuizzes = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($imagem)){
            $caminhoImagem= glob('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/ImagemQuizz/*');

            foreach ($caminhoImagem as $localAtual) {
                unlink($localAtual);
            }
        }

        $caminhoImagem= glob('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dataQuizzes['Id_quizz'].'/ImagemQuizzTemporaria/*');

        foreach ($caminhoImagem as $localAtual) {
            unlink($localAtual);
        }
        
        $data = date('y-m-d h:i:s');
        
        $sql = 'UPDATE quizzes SET nomeQuizz = :nomeQuizz, DataCriacao = :DataCriacao, dificuldade= :escolariedade, tema= :TemaQuizz, imagem= :imagem WHERE Id_utilizador = :Id_utilizador AND dificuldade = :escolaridadeTemporaria';
        $stmt = $conexao->runQuery($sql);    
        $stmt->bindParam(':Id_utilizador', $Id_utilizador, PDO::PARAM_INT);
        $stmt->bindParam(':escolaridadeTemporaria', $tipoTemporario);
        $stmt->bindParam(':nomeQuizz', $nomeQuizz);
        $stmt->bindParam(':DataCriacao', $data);
        $stmt->bindParam(':escolariedade', $escolariedade);
        $stmt->bindParam(':TemaQuizz', $TemaQuizz);
        $stmt->bindParam(':imagem', $imagem);
        $execute = $stmt->execute();

        return 'dadosGuardadosComSucesso';
    }


    function ObterQuizzes(){
        $conexao = new Conexao();
        

        $stmt = $conexao->runQuery("SELECT  quizzes.Id_quizz, nomeQuizz, imagem, dificuldade, COUNT(avaliacao.Id_avaliacao) as numAvaliacoes, ROUND(AVG(avaliacao.nota),2) as mediaAvaliacoes FROM quizzes INNER JOIN avaliacao ON (quizzes.Id_quizz= avaliacao.Id_quizz) WHERE dificuldade != :dificuldade AND  dificuldade != :temporarioAdmin GROUP BY  quizzes.Id_quizz
        ORDER BY COUNT(avaliacao.Id_avaliacao) DESC LIMIT 5");
        $stmt->execute(array(':dificuldade' => "temporario", ':temporarioAdmin' => "temporarioAdmin"));
        $dataAvaliacoesQuizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);    //Exemplo de output : {"numAvaliacoes":"2","mediaAvaliacoes":"4.50"}

        
        $stmt = $conexao->runQuery("SELECT  quizzes.Id_quizz, nomeQuizz, imagem, dificuldade, COUNT(avaliacao.Id_avaliacao) as numAvaliacoes, ROUND(AVG(avaliacao.nota),2) as mediaAvaliacoes FROM quizzes INNER JOIN avaliacao ON (quizzes.Id_quizz= avaliacao.Id_quizz) WHERE dificuldade != :dificuldade AND  dificuldade != :temporarioAdmin GROUP BY  quizzes.Id_quizz
        ORDER BY ROUND(AVG(avaliacao.nota),2) DESC LIMIT 5");
        $stmt->execute(array(':dificuldade' => "temporario", ':temporarioAdmin' => "temporarioAdmin"));
        $dataMediaAvaliacoesQuizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);


        //Obter dados através da data de criação do maior para o menor
        $stmt = $conexao->runQuery("SELECT Id_quizz, Id_utilizador, DataCriacao, dificuldade, nomeQuizz, imagem  FROM quizzes WHERE dificuldade != :dificuldade AND  dificuldade != :temporarioAdmin ORDER BY DataCriacao DESC LIMIT 5");
        $stmt->execute(array(':dificuldade' => "temporario", ':temporarioAdmin' => "temporarioAdmin"));
        $dataQuizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dataCriacaoQuizzDescendente = array();
        $i=0;

        foreach ($dataQuizzes as $dataQuizzesTamanho) {

            $caminhoImagem= '../BaseDados/Utilizadores/Utilizador_'.$dataQuizzesTamanho['Id_utilizador'].'/Quizzes/Quizz'.$dataQuizzesTamanho['Id_quizz'].'/ImagemQuizzTemporaria';

            //Aqui são usados algumas funções, a função COUNT conta todos os campos dependendo dos filtros aplicados, caso o campo é o "Id_avaliação" da tabela "avaliacao"
            //A função Round arredonda as cazas decimais á nossa escolha, neste caso a coluna "nota" da tabea "avaliacao" está limitado a 2 casas decimais
            //A função AVG cálcula a média de a coluna selecionada que neste caso é a mesma da função ROUND
            $stmt = $conexao->runQuery("SELECT  COUNT(avaliacao.Id_avaliacao) as numAvaliacoes, ROUND(AVG(avaliacao.nota),2) as mediaAvaliacoes FROM quizzes INNER JOIN avaliacao ON (quizzes.Id_quizz= avaliacao.Id_quizz) WHERE avaliacao.Id_quizz= :Id_quizz");
            $stmt->execute(array(':Id_quizz' => $dataQuizzesTamanho['Id_quizz']));
            $dataCriacaoQuizzDescendente[$i] = $stmt->fetch(PDO::FETCH_ASSOC);      //Exemplo de output : {"numAvaliacoes":"2","mediaAvaliacoes":"4.50"}
            $dataCriacaoQuizzDescendente[$i]['nomeQuizz']= $dataQuizzesTamanho['nomeQuizz'];    //Exemplo de output : {"numAvaliacoes":"2","mediaAvaliacoes":"4.50","nomeQuizz":"Nascimento de Jesus"}
            $dataCriacaoQuizzDescendente[$i]['imagem']= $dataQuizzesTamanho['imagem'];      //Exemplo de output : {"numAvaliacoes":"2","mediaAvaliacoes":"4.50","nomeQuizz":"Nascimento de Jesus","imagem":"/imagem.png"}
            $dataCriacaoQuizzDescendente[$i]['dificuldade']= $dataQuizzesTamanho['dificuldade'];      //Exemplo de output : {"numAvaliacoes":"2","mediaAvaliacoes":"4.50","nomeQuizz":"Nascimento de Jesus","imagem":"/imagem.png","escolaridade":"1ºano"}
            $dataCriacaoQuizzDescendente[$i]['Id_quizz']= $dataQuizzesTamanho['Id_quizz'];      //Exemplo de output : {"numAvaliacoes":"2","mediaAvaliacoes":"4.50","nomeQuizz":"Nascimento de Jesus","imagem":"/imagem.png","escolaridade":"1ºano","Id_quizz":"24"}

            if(empty($dataCriacaoQuizzDescendente[$i]['numAvaliacoes'])){
                $dataCriacaoQuizzDescendente[$i]['numAvaliacoes']= 0;
            }

            if(empty($dataCriacaoQuizzDescendente[$i]['mediaAvaliacoes'])){
                $dataCriacaoQuizzDescendente[$i]['mediaAvaliacoes']= 0;
            }

            $i +=1;
        }

        $filtrarDados = array(  'QuizzesOrdenadosPorNumeroAvaliacoes'=> $dataAvaliacoesQuizzes, 
                                'QuizzesOrdenadosPorMediaAvaliacoes' => $dataMediaAvaliacoesQuizzes,
                                'QuizzesOrdenadosPorDataCriacao' => $dataCriacaoQuizzDescendente
                             );

        return $filtrarDados;
    }


    function ObterDadosQuizzEAvaliacoes($Id_utilizador,$Id_quizz){
        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT quizzes.nomeQuizz, quizzes.DataCriacao, quizzes.dificuldade, quizzes.tema, COUNT(questoes.Id_questao) as numPerguntas FROM quizzes INNER JOIN questoes ON (quizzes.Id_quizz= questoes.Id_quizz) WHERE quizzes.Id_quizz= :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $Id_quizz));
        $dadosQuizz = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conexao->runQuery('SELECT COUNT(avaliacao.Id_avaliacao) as numAvaliacoes, ROUND(AVG(avaliacao.nota),2) as mediaAvaliacoes FROM quizzes INNER JOIN avaliacao ON (quizzes.Id_quizz= avaliacao.Id_quizz) WHERE quizzes.Id_quizz= :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $Id_quizz));
        $dadosNumMediaAvaliacoes = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conexao->runQuery('SELECT avaliacao.Id_avaliacao, avaliacao.Id_utilizador, avaliacao.textoAvaliacao, avaliacao.textoAvaliacao, avaliacao.nota, avaliacao.gosto, avaliacao.naoGosto, utilizadores.Id_utilizador, utilizadores.nomeUnico FROM avaliacao INNER JOIN utilizadores ON (avaliacao.Id_utilizador= utilizadores.Id_utilizador) WHERE avaliacao.Id_quizz= :Id_quizz AND avaliacao.Id_utilizador != :Id_utilizador');
        $stmt->execute(array(':Id_quizz' => $Id_quizz, ':Id_utilizador' => $Id_utilizador));
        $dadosAvaliacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $conexao->runQuery('SELECT avaliacao.Id_avaliacao, avaliacao.Id_utilizador, avaliacao.textoAvaliacao, avaliacao.textoAvaliacao, avaliacao.nota, avaliacao.gosto, avaliacao.naoGosto, utilizadores.Id_utilizador, utilizadores.nomeUnico FROM avaliacao INNER JOIN utilizadores ON (avaliacao.Id_utilizador= utilizadores.Id_utilizador) WHERE avaliacao.Id_quizz= :Id_quizz AND avaliacao.Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_quizz' => $Id_quizz, ':Id_utilizador' => $Id_utilizador));
        $dadosAvaliacaoUtilizador = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $conexao->runQuery('SELECT utilizadores.nomeUnico, utilizadores.imagemPerfil, utilizadores.Id_utilizador, permissao FROM quizzes INNER JOIN utilizadores ON (quizzes.Id_utilizador= utilizadores.Id_utilizador) WHERE quizzes.Id_quizz= :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $Id_quizz));
        $dadosCriadorQuizz = $stmt->fetch(PDO::FETCH_ASSOC);

        $filtrarDados = array(  'dadosCriadorQuizz'=> $dadosCriadorQuizz, 
                                'dadosQuizz'=> $dadosQuizz, 
                                'dadosNumMediaAvaliacoes' => $dadosNumMediaAvaliacoes, 
                                'dadosAvaliacoes' => $dadosAvaliacoes,
                                'dadosAvaliacaoUtilizador' => $dadosAvaliacaoUtilizador
                            );

        return $filtrarDados;
    }

    function EliminarAvaliacao($Id_avaliacao){
        $conexao = new Conexao();

        $sql = 'DELETE FROM avaliacao WHERE Id_avaliacao = :Id_avaliacao';
        $stmt= $conexao->runQuery($sql);
        $stmt->bindParam(':Id_avaliacao', $Id_avaliacao);
        $stmt->execute();
        
        return "avaliacaoEliminada";
    }

    function PrepararEdicaoQuizz($Id_quizz){
        $conexao = new Conexao();
        $temporario = 'temporario';

        $sql = 'UPDATE quizzes SET dificuldade = :dificuldade WHERE Id_quizz = :Id_quizz';
        $stmt = $conexao->runQuery($sql);
        $stmt->bindParam(':Id_quizz', $Id_quizz, PDO::PARAM_INT);
        $stmt->bindParam(':dificuldade', $temporario);
        $execute = $stmt->execute();
        
        return 'editadoComSucesso';
    }

    function PrepararEdicaoQuizzAdmin($Id_quizz){
        $conexao = new Conexao();
        $temporarioAdmin = 'temporarioAdmin';

        $sql = 'UPDATE quizzes SET dificuldade = :dificuldade WHERE Id_quizz = :Id_quizz';
        $stmt = $conexao->runQuery($sql);
        $stmt->bindParam(':Id_quizz', $Id_quizz, PDO::PARAM_INT);
        $stmt->bindParam(':dificuldade', $temporarioAdmin);
        $execute = $stmt->execute();
        
        return 'editadoComSucesso';
    }


    function ObterDadosJogoQuizz($Id_quizz){
        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT Id_questao FROM questoes WHERE Id_quizz = :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $Id_quizz));
        $dadosQuestoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt = $conexao->runQuery('SELECT Id_questao FROM questoes WHERE Id_quizz = :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $Id_quizz));
        $dadosQuestoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $numeroQuestoes= count($dadosQuestoes);

        $filtrarDados = array(  'dadosQuestoes'=> $dadosQuestoes, 
                                'numeroQuestoes' => $numeroQuestoes
                            );

        return $filtrarDados;
    }
    
    function ObterEGuardarDadosJogo($Id_quizz, $Id_utilizador){
        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT nomeQuizz FROM quizzes WHERE Id_quizz = :Id_quizz');
        $stmt->execute(array(':Id_quizz' => $Id_quizz));
        $nomeQuizz = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conexao->runQuery('SELECT textoAvaliacao, nota FROM avaliacao WHERE Id_utilizador = :Id_utilizador AND Id_quizz = :Id_quizz');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador, ':Id_quizz' => $Id_quizz));
        $dadosAvaliacao = $stmt->fetch(PDO::FETCH_ASSOC);

        $filtrarDados = array(  'nomeQuizz'=> $nomeQuizz, 
                                'dadosAvaliacao' => $dadosAvaliacao
                            );

        return $filtrarDados;
    }

    function GuardarPontuacaoUtilizador($Id_quizz, $Id_utilizador, $totalPontosAcumulados){
        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT valorAdquirido FROM quizzes_respondidos WHERE Id_quizz = :Id_quizz AND 	Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_quizz' => $Id_quizz, ':Id_utilizador' => $Id_utilizador));
        $verificarQuizzResolvido = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conexao->runQuery('SELECT pontuacao FROM utilizadores WHERE Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
        $pontuacaoUtilizadorAtual = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($verificarQuizzResolvido)){
            $stmt = $conexao->runQuery('INSERT INTO quizzes_respondidos (Id_utilizador, Id_quizz, valorAdquirido) VALUES (:Id_utilizador, :Id_quizz, :valorAdquirido)');
            $stmt-> execute(array(':Id_utilizador' => $Id_utilizador, ':Id_quizz' => $Id_quizz, ':valorAdquirido' => $totalPontosAcumulados));

            $sql = 'UPDATE utilizadores SET pontuacao = :pontuacao WHERE Id_utilizador = :Id_utilizador';
            $stmt = $conexao->runQuery($sql);
            $stmt->bindParam(':Id_utilizador', $Id_utilizador, PDO::PARAM_INT);
            $stmt->bindParam(':pontuacao', $totalPontosAcumulados);
            $execute = $stmt->execute();
        }else{
            $valorAGuardar = $verificarQuizzResolvido['valorAdquirido'] + $totalPontosAcumulados;
            
            // verificar valor a adicionar tendo em conta que o máximo é 100
            if($valorAGuardar >= 100){
                $valorAGuardar = 100 - $verificarQuizzResolvido['valorAdquirido'];
                $novaPontuacaoUtilizador = $pontuacaoUtilizadorAtual['pontuacao'] + $valorAGuardar;
                $valorAGuardar = 100;
            }else{
                $novaPontuacaoUtilizador = $pontuacaoUtilizadorAtual['pontuacao'] + $totalPontosAcumulados;
            }


            if($pontuacaoUtilizadorAtual['pontuacao'] >= 700){
                $novaPontuacaoUtilizador = 700;
            }

            $sql = 'UPDATE utilizadores SET pontuacao = :pontuacao WHERE Id_utilizador = :Id_utilizador';
            $stmt = $conexao->runQuery($sql);
            $stmt->bindParam(':Id_utilizador', $Id_utilizador, PDO::PARAM_INT);
            $stmt->bindParam(':pontuacao', $novaPontuacaoUtilizador);
            $execute = $stmt->execute();

            $sql = 'UPDATE quizzes_respondidos SET valorAdquirido = :valorAdquirido WHERE Id_utilizador = :Id_utilizador AND Id_quizz = :Id_quizz';
            $stmt = $conexao->runQuery($sql);
            $stmt->bindParam(':Id_utilizador', $Id_utilizador, PDO::PARAM_INT);
            $stmt->bindParam(':Id_quizz', $Id_quizz, PDO::PARAM_INT);
            $stmt->bindParam(':valorAdquirido', $valorAGuardar);
            $execute = $stmt->execute();

        }
        return $totalPontosAcumulados;
    }

    function PesquisarQuizzes($Id_utilizador, $textoAPesquisar, $tipoPesquisa){
        $conexao = new Conexao();
        $adicionarDadosExtra= 0;

        switch ($tipoPesquisa) {
            case 'TodosOsQuizzes':
                $stmt = $conexao->runQuery("SELECT Id_quizz, Id_utilizador, dificuldade, nomeQuizz, imagem  FROM quizzes WHERE dificuldade != :dificuldade AND  dificuldade != :temporarioAdmin AND nomeQuizz LIKE :nomeQuizz");
                $stmt->execute(array(':dificuldade' => "temporario", ':temporarioAdmin' => "temporarioAdmin", ':nomeQuizz' => "%".$textoAPesquisar."%"));
                $dataQuizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $adicionarDadosExtra= 1;
            break;

            case 'quizzesCriados':
                $stmt = $conexao->runQuery("SELECT Id_quizz, Id_utilizador, dificuldade, nomeQuizz, imagem  FROM quizzes WHERE dificuldade != :dificuldade AND  dificuldade != :temporarioAdmin AND  Id_utilizador = :Id_utilizador");
                $stmt->execute(array(':dificuldade' => "temporario", ':temporarioAdmin' => "temporarioAdmin", ':Id_utilizador' => $Id_utilizador));
                $dataQuizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $adicionarDadosExtra= 1;
            break;

            case 'quizzesRealizados':
                $stmt = $conexao->runQuery("SELECT  quizzes.Id_quizz, quizzes.Id_utilizador, dificuldade, nomeQuizz, imagem, quizzes_respondidos.valorAdquirido FROM quizzes INNER JOIN quizzes_respondidos ON (quizzes.Id_quizz= quizzes_respondidos.Id_quizz) WHERE dificuldade != :dificuldade AND  dificuldade != :temporarioAdmin AND  quizzes_respondidos.Id_utilizador = :Id_utilizador");
                $stmt->execute(array(':dificuldade' => "temporario", ':temporarioAdmin' => "temporarioAdmin", ':Id_utilizador' => $Id_utilizador));
                $dataQuizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $adicionarDadosExtra= 1;
            break;

            case 'quizzesAvaliados':
                $stmt = $conexao->runQuery("SELECT  quizzes.Id_quizz, nomeQuizz, imagem, dificuldade, COUNT(avaliacao.Id_avaliacao) as numAvaliacoes, ROUND(AVG(avaliacao.nota),2) as mediaAvaliacoes FROM quizzes INNER JOIN avaliacao ON (quizzes.Id_quizz= avaliacao.Id_quizz) WHERE dificuldade != :dificuldade AND  dificuldade != :temporarioAdmin AND  avaliacao.Id_utilizador = :Id_utilizador GROUP BY  quizzes.Id_quizz
                ORDER BY COUNT(avaliacao.Id_avaliacao) DESC");
                $stmt->execute(array(':dificuldade' => "temporario", ':temporarioAdmin' => "temporarioAdmin", ':Id_utilizador' => $Id_utilizador));
                $dataQuizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;
            
            default:
                # code...
                break;
        }

        if($adicionarDadosExtra == 1){

            $dataCriacaoQuizzDescendente = array();
            $i=0;

            foreach ($dataQuizzes as $dataQuizzesTamanho) {

                $caminhoImagem= '../BaseDados/Utilizadores/Utilizador_'.$dataQuizzesTamanho['Id_utilizador'].'/Quizzes/Quizz'.$dataQuizzesTamanho['Id_quizz'].'/ImagemQuizzTemporaria';

                $stmt = $conexao->runQuery("SELECT  COUNT(avaliacao.Id_avaliacao) as numAvaliacoes, ROUND(AVG(avaliacao.nota),2) as mediaAvaliacoes FROM quizzes INNER JOIN avaliacao ON (quizzes.Id_quizz= avaliacao.Id_quizz) WHERE avaliacao.Id_quizz= :Id_quizz");
                $stmt->execute(array(':Id_quizz' => $dataQuizzesTamanho['Id_quizz']));
                $dataCriacaoQuizzDescendente[$i] = $stmt->fetch(PDO::FETCH_ASSOC);      //Exemplo de output : {"numAvaliacoes":"2","mediaAvaliacoes":"4.50"}
                $dataCriacaoQuizzDescendente[$i]['nomeQuizz']= $dataQuizzesTamanho['nomeQuizz'];    //Exemplo de output : {"numAvaliacoes":"2","mediaAvaliacoes":"4.50","nomeQuizz":"Nascimento de Jesus"}
                $dataCriacaoQuizzDescendente[$i]['imagem']= $dataQuizzesTamanho['imagem'];      //Exemplo de output : {"numAvaliacoes":"2","mediaAvaliacoes":"4.50","nomeQuizz":"Nascimento de Jesus","imagem":"/imagem.png"}
                $dataCriacaoQuizzDescendente[$i]['dificuldade']= $dataQuizzesTamanho['dificuldade'];      //Exemplo de output : {"numAvaliacoes":"2","mediaAvaliacoes":"4.50","nomeQuizz":"Nascimento de Jesus","imagem":"/imagem.png","escolaridade":"1ºano"}
                $dataCriacaoQuizzDescendente[$i]['Id_quizz']= $dataQuizzesTamanho['Id_quizz'];      //Exemplo de output : {"numAvaliacoes":"2","mediaAvaliacoes":"4.50","nomeQuizz":"Nascimento de Jesus","imagem":"/imagem.png","escolaridade":"1ºano","Id_quizz":"24"}
                if ($tipoPesquisa == "quizzesRealizados") {
                    $dataCriacaoQuizzDescendente[$i]['valorAdquirido']= $dataQuizzesTamanho['valorAdquirido'];
                }

                if(empty($dataCriacaoQuizzDescendente[$i]['numAvaliacoes'])){
                    $dataCriacaoQuizzDescendente[$i]['numAvaliacoes']= 0;
                }

                if(empty($dataCriacaoQuizzDescendente[$i]['mediaAvaliacoes'])){
                    $dataCriacaoQuizzDescendente[$i]['mediaAvaliacoes']= 0;
                }

                $i +=1;
            }
            return  $dataCriacaoQuizzDescendente;

        }else{
            return  $dataQuizzes;
        }
    }

    function GuardarDadosAvaliacao($Id_utilizador, $Id_quizz, $textoAvaliacao, $notaAvaliacao){
        $conexao = new Conexao();
        
        if (empty($textoAvaliacao) ) {
            return "textoVazio";
        }
        if (empty($notaAvaliacao) ) {
            return "notaVazia";
        }

        $stmt = $conexao->runQuery('SELECT `Id_avaliacao` FROM avaliacao WHERE Id_utilizador = :Id_utilizador AND Id_quizz = :Id_quizz');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador,':Id_quizz' => $Id_quizz));
        $dadosAvaliacao = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(empty($dadosAvaliacao)){
            $stmt = $conexao->runQuery('INSERT INTO avaliacao (Id_utilizador, Id_quizz, textoAvaliacao, nota) VALUES (:Id_utilizador, :Id_quizz, :textoAvaliacao, :notaAvaliacao)');
            $stmt-> execute(array(':Id_utilizador' => $Id_utilizador, ':Id_quizz' => $Id_quizz, ':textoAvaliacao' => $textoAvaliacao, ':notaAvaliacao' => $notaAvaliacao));
        }else{
            $sql = 'UPDATE avaliacao SET textoAvaliacao = :textoAvaliacao, nota = :notaAvaliacao WHERE Id_utilizador = :Id_utilizador AND Id_quizz = :Id_quizz';
            $stmt = $conexao->runQuery($sql);
            $stmt->bindParam(':Id_utilizador', $Id_utilizador, PDO::PARAM_INT);
            $stmt->bindParam(':Id_quizz', $Id_quizz, PDO::PARAM_INT);
            $stmt->bindParam(':textoAvaliacao', $textoAvaliacao);
            $stmt->bindParam(':notaAvaliacao', $notaAvaliacao);
            $execute = $stmt->execute();
        }

        return "dadosGuardadosComSucesso";
    }

}