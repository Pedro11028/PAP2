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
        }else{

            if($password == $confirmarPass){

                if ($data['password'] == $password) {

                    try{

                        $sql = 'DELETE FROM utilizadores WHERE Id_utilizador = :Id_utilizador';
                        $stmt= $conexao->runQuery($sql);
                        $stmt->bindParam(':Id_utilizador', $Id_utilizador);
                        $stmt->execute();

                        return "true";
                    }catch(PDOExtrueception $e){
                        return "erroSemResposta";
                    }


                }else{
                    return "passwordNaoExiste";
                }
            }else{
                return "passwordsNaoCorrespondem";
            }
        }


    }

    function Alterar($passwordAtual,$passwordNova,$confirmarPass,$Id_utilizador){

        $conexao = new Conexao();

        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data == false) {
            return "nulo";
        }else{
            if($passwordAtual== $passwordNova){
                return "PasswordIgualAnterior";
            }else{
                if($data['password'] != $passwordAtual){
                    return "PassworAtualErrada";
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


    function GuardarImagem($Id_utilizador,$imagemPerfil){
        $conexao = new Conexao();
        $imagemPerfil = strstr($imagemPerfil,'img');

        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE Id_utilizador = :Id_utilizador');
        $stmt->execute(array(':Id_utilizador' => $Id_utilizador));
        $dataUtilizador = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataUtilizador == false) {
            return "erroBaseDados";
        }else{
            
            if (file_exists('../BaseDados/Utilizadores/Utilizador_'.$dataUtilizador['Id_utilizador'].'/'.$dataUtilizador['imagemPerfil'])) {
                unlink($dataUtilizador['imagemPerfil']);
            }
            
            $sql = 'UPDATE utilizadores SET imagemPerfil = :imagemPerfil WHERE Id_utilizador = :Id_utilizador';
            $stmt = $conexao->runQuery($sql);
            $stmt->bindParam(':Id_utilizador', $Id_utilizador, PDO::PARAM_INT);
            $stmt->bindParam(':imagemPerfil', $imagemPerfil);
            $execute = $stmt->execute();

            return "true";
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
}