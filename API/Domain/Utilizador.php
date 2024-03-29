<?php

require 'conexao.php';

class Utilizador {

    function EValido($email,$password){
        $false = array(0 => "false");

        //faz a conexão
        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE email = :email');
        $stmt-> execute(array(':email' => $email));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data == false) {
            return $false;
        } else {
            if ($password == $data['password']) {
               $filtrarDados = array( 'Id_utilizador'=> $data["Id_utilizador"], 
                                     'nomeUnico' => $data["nomeUnico"],
                                     'permissao' => $data["permissao"],
                                     'confirmarExiste' => "true"
                                    );

                if (!file_exists('../BaseDados/Utilizadores/Utilizador_'.$data['Id_utilizador'])) {
                    mkdir('../BaseDados/Utilizadores/Utilizador_'.$data['Id_utilizador'], 0777, true);
                    mkdir('../BaseDados/Utilizadores/Utilizador_'.$data['Id_utilizador'].'/Quizzes', 0777, true);
                    mkdir('../BaseDados/Utilizadores/Utilizador_'.$data['Id_utilizador'].'/ImagemTemporaria', 0777, true);
                }

                return $filtrarDados;
            } else{
            return $false;
            }
        }
    }

    function AlterarDadosUtilizador($Id_utilizador,$nomeCompleto,$nomeUnico,$imagem,$pontuacao,$permissao){
        $conexao = new Conexao();
        
        $sql = 'UPDATE utilizadores SET nomeCompleto = :nomeCompleto, nomeUnico = :nomeUnico, pontuacao = :pontuacao, permissao = :permissao WHERE Id_utilizador = :Id_utilizador';
        $stmt = $conexao->runQuery($sql);    
        $stmt->bindParam(':Id_utilizador', $Id_utilizador, PDO::PARAM_INT);
        $stmt->bindParam(':nomeCompleto', $nomeCompleto);
        $stmt->bindParam(':nomeUnico', $nomeUnico);
        $stmt->bindParam(':pontuacao', $pontuacao);
        $stmt->bindParam(':permissao', $permissao);
        $execute = $stmt->execute();
        
        return "dadosGuardadosComSucesso";
    }

    function Guardar($nomeCompleto, $nomeUnico, $email, $password){
        $false = array(0 => "false");
        $erroConexao = array(0 => "erro na conexao com a base de dados");
        $true = array(0 => "true");

        $conexao = new Conexao();

        $imagemPerfil = "img/perfilPadrao.png";
        
        // Verificar se já existe algum utilizador com o mesmo email ou nomeUnico
        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE email = :email OR nomeUnico = :nomeUnico');
        $stmt->execute(array(':email' => $email,':nomeUnico' => $nomeUnico));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        //Se não existir então verifica-se o nome único
        if ($data == false) {
            try{
                $stmt = $conexao->runQuery('INSERT INTO utilizadores (nomeCompleto, nomeUnico, password, email, imagemPerfil, permissao) VALUES (:nomeCompleto, :nomeUnico,:pass_utiliz, :email_utiliz, :imagemPerfil, :permissao)');
                $stmt->execute(array(':nomeCompleto' => $nomeCompleto, ':nomeUnico' => $nomeUnico,':pass_utiliz' => $password, ':email_utiliz' => $email, ':imagemPerfil' => $imagemPerfil, ':permissao' => "utilizador"));

                return $true;
            }catch(PDOExtrueception $e){
                echo $erroConexao;
            }

            
        }else{
            return $false;
        }
    }

    function Eliminar($password,$confirmarPass,$Id_utilizador){
        $conexao = new Conexao();
        
        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data == false) {
            return "nulo";
        }
        if($password != $confirmarPass){
            return "passwordsNaoCorrespondem";
        }
        if ($data['password'] != $password) {
            return "passwordNaoExiste";
        }

        $stmt = $conexao->runQuery('SELECT `Id_quizz` FROM quizzes WHERE Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
        $dataQuizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($dataQuizzes as $dadosDataQuizzes){

        
            $stmt = $conexao->runQuery('SELECT Id_questao, nomeQuestao, imagem, tipoQuestao FROM questoes WHERE Id_quizz = :Id_quizz');
            $stmt->execute(array(':Id_quizz' => $dadosDataQuizzes['Id_quizz']));
            $dataQuestoes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Guarda um array dentro de um array por exemplo:  0 => Id_questao => 9

            $caminhoImagensQuestoes= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dadosDataQuizzes['Id_quizz'];
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
            

            $limparImagensQuizz= glob('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dadosDataQuizzes['Id_quizz'].'/ImagemQuizz/*');
            $limparImagensQuizzTemporarias= glob('../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dadosDataQuizzes['Id_quizz'].'/ImagemQuizzTemporaria/*');

            foreach ($limparImagensQuizz as $localAtual) {
                unlink($localAtual);
            }
            foreach ($limparImagensQuizzTemporarias as $localAtual) {
                unlink($localAtual);
            }

            $limparImagensQuizz= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dadosDataQuizzes['Id_quizz'].'/ImagemQuizz';
            $limparImagensQuizzTemporarias= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes/Quizz'.$dadosDataQuizzes['Id_quizz'].'/ImagemQuizzTemporaria';

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
            $stmt->bindParam(':Id_quizz', $dadosDataQuizzes['Id_quizz']);
            $stmt->execute();

            $sql = 'DELETE FROM avaliacao WHERE Id_quizz = :Id_quizz';
            $stmt= $conexao->runQuery($sql);
            $stmt->bindParam(':Id_quizz', $dadosDataQuizzes['Id_quizz']);
            $stmt->execute();

            $sql = 'DELETE FROM quizzes WHERE Id_quizz = :Id_quizz';
            $stmt= $conexao->runQuery($sql);
            $stmt->bindParam(':Id_quizz', $dadosDataQuizzes['Id_quizz']);
            $stmt->execute();
        }

            $liminarPastaQuizzes= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/Quizzes';
            $liminarPastaImagemTemporaria= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/ImagemTemporaria';
            $liminarPastaUtilizadores= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador;

            if (file_exists($liminarPastaQuizzes)) {
                rmdir($liminarPastaQuizzes);
            }
            if (file_exists($liminarPastaImagemTemporaria)) {
                rmdir($liminarPastaImagemTemporaria);
            }
            if (file_exists($liminarPastaUtilizadores)) {
                rmdir($liminarPastaUtilizadores);
            }
            
            $sql = 'DELETE FROM quizzes_respondidos WHERE Id_utilizador = :Id_utilizador';
            $stmt= $conexao->runQuery($sql);
            $stmt->bindParam(':Id_utilizador', $Id_utilizador);
            $stmt->execute();

            $sql = 'DELETE FROM utilizadores WHERE Id_utilizador = :Id_utilizador';
            $stmt= $conexao->runQuery($sql);
            $stmt->bindParam(':Id_utilizador', $Id_utilizador);
            $stmt->execute();

        return "dadosEliminadosComSucesso";


    }

    function Alterar($passwordAtual,$passwordNova,$confirmarPass,$Id_utilizador){

        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data == false) {
            return "nulo";
        }else{
            if(empty($passwordAtual) || empty($passwordNova)){
                return("passwordsVazias");
            }else{
                if($data['password'] != $passwordAtual){
                    return "PassworAtualErrada";
                }else{
                    if($passwordAtual== $passwordNova){
                        return "PasswordIgualAnterior";
                    }else{
                            if($passwordNova != $confirmarPass){
                                return "PasswordConfirmarDiferente";
                            }else{
                                try{
                                    $sql = 'UPDATE utilizadores SET password = :passwordNova WHERE Id_utilizador = :Id_utilizador';
                                    $stmt = $conexao->runQuery($sql);
                                    $stmt->bindParam(':Id_utilizador', $Id_utilizador, PDO::PARAM_INT);
                                    $stmt->bindParam(':passwordNova', $passwordNova);
                                    $execute = $stmt->execute();

                                    return "true";
                                }catch(PDOExtrueception $e){
                                    return "erroSemResposta";
                                }
                            }
                    }
                }
            }
        }
    }

    function Carregar($Id_utilizador){
        $false = array(0 => "false");

        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
        $dataUtilizador = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataUtilizador == false) {
            return $false;
        }else{

            $stmt = $conexao->runQuery('SELECT COUNT(Id_utilizador) as numAvaliacoes FROM avaliacao WHERE Id_utilizador = :Id_utilizador');
            $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
            $dataAvaliacao = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $conexao->runQuery('SELECT COUNT(Id_utilizador) as numQuizzesCriados FROM quizzes WHERE Id_utilizador = :Id_utilizador');
            $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
            $dataQuizzesCriados = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $conexao->runQuery('SELECT COUNT(Id_utilizador) as numQuizzesFeitos FROM quizzes_respondidos WHERE Id_utilizador = :Id_utilizador');
            $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
            $dataQuizzesFeitos = $stmt->fetch(PDO::FETCH_ASSOC);

            $filtrarDados = array(   'nomeCompleto'=> $dataUtilizador["nomeCompleto"],
                                     'nomeUnico'=> $dataUtilizador["nomeUnico"], 
                                     'email' => $dataUtilizador["email"],
                                     'imagemPerfil' => $dataUtilizador["imagemPerfil"],
                                     'pontuacao' => $dataUtilizador["pontuacao"],
                                     'numAvaliacoes' => $dataAvaliacao["numAvaliacoes"],
                                     'numQuizzesCriados' => $dataQuizzesCriados["numQuizzesCriados"],
                                     'numQuizzesFeitos' => $dataQuizzesFeitos["numQuizzesFeitos"]
                                 );

            return $filtrarDados;
        }
    }

    function CarregarTodosOsDados($Id_utilizador){
        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
        $dataUtilizador = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dataUtilizador;
    }

    function GuardarImagem($Id_utilizador,$imagemPerfil){
        $conexao = new Conexao();
        $imagemPerfil = strstr($imagemPerfil,'img');

        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
        $dataUtilizador = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataUtilizador == false) {
            return "erroBaseDados";
        }else{
            
            if (file_exists($dataUtilizador['imagemPerfil'])) {
                unlink($dataUtilizador['imagemPerfil']);
            }
            
            $sql = 'UPDATE utilizadores SET imagemPerfil = :imagemPerfil WHERE Id_utilizador = :Id_utilizador';
            $stmt = $conexao->runQuery($sql);
            $stmt->bindParam(':Id_utilizador', $Id_utilizador, PDO::PARAM_INT);
            $stmt->bindParam(':imagemPerfil', $imagemPerfil);
            $execute = $stmt->execute();

            return 'true';
        }
    }


    function UploadImage($Id_utilizador,$ficheiro){
        $conexao = new Conexao();

        $caminhoAGuardar= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/';
        $nomeImagem = $ficheiro['file']['name'];
        $caminhoTemporario=$ficheiro["file"]["tmp_name"];

        //php basename for files
        $basename = basename($nomeImagem);
        $caminhoOriginal = $caminhoAGuardar.$basename;

        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
        $dataUtilizador = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataUtilizador == false) {
            return "erroBaseDados";
        }else{
            
            if (!file_exists($caminhoOriginal)) {
                unlink($dataUtilizador['imagemPerfil']);
                move_uploaded_file($caminhoTemporario,$caminhoOriginal);

                $sql = 'UPDATE utilizadores SET imagemPerfil = :caminhoOriginal WHERE Id_utilizador = :Id_utilizador';
                $stmt = $conexao->runQuery($sql);
                $stmt->bindParam(':Id_utilizador', $Id_utilizador, PDO::PARAM_INT);
                $stmt->bindParam(':caminhoOriginal', $caminhoOriginal);
                $execute = $stmt->execute();
    
                return $ficheiro['file']['name'];
            }else{
                return "imagemJaExiste";
            }

        }
    }


    function AlterarNome($Id_utilizador,$nomeCompleto){
        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
        $dataUtilizador = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataUtilizador == false) {
            return "erroBaseDados";
        }else{

            $sql = 'UPDATE utilizadores SET nomeCompleto = :nomeCompleto WHERE Id_utilizador = :Id_utilizador';
            $stmt = $conexao->runQuery($sql);
            $stmt->bindParam(':Id_utilizador', $Id_utilizador, PDO::PARAM_INT);
            $stmt->bindParam(':nomeCompleto', $nomeCompleto);
            $execute = $stmt->execute();

            
            return "true";
        }
    }


    function AlterarNomeUnico($Id_utilizador,$nomeUnico){
        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
        $dataUtilizador = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataUtilizador == false) {
            return "erroBaseDados";
        }else{
            $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE nomeUnico = :nomeUnico');
            $stmt->execute(array(':nomeUnico' => $nomeUnico));
            $dataUtilizador = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($dataUtilizador == true) {
                return "nomeUnicoJaExiste";
            }else{

                $sql = 'UPDATE utilizadores SET nomeUnico = :nomeUnico WHERE Id_utilizador = :Id_utilizador';
                $stmt = $conexao->runQuery($sql);
                $stmt->bindParam(':Id_utilizador', $Id_utilizador, PDO::PARAM_INT);
                $stmt->bindParam(':nomeUnico', $nomeUnico);
                $execute = $stmt->execute();

                return $nomeUnico;
            }
        }
    }

    function ObterUtilizadores($nomeUnicoAPesquisar){
        $conexao = new Conexao();
        
        $stmt = $conexao->runQuery('SELECT Id_utilizador, nomeUnico, email FROM utilizadores WHERE permissao != :permissao AND nomeUnico LIKE :nomeUnico');
        $stmt->execute(array(':permissao' => "admin", ':nomeUnico' => "%".$nomeUnicoAPesquisar."%"));
        $dadosUtilizador = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $dadosUtilizador;    
    }
}