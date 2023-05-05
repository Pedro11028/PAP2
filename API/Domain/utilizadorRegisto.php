<?php
require 'conexao.php';

class Utilizador {
    
    function UtilizadorGuardarConfirmar($nomeCompleto, $nomeUnico, $email, $password){
        $conexao = new Conexao();

        $imagemPerfil = "img/perfilPadrao.png";
        
        // Verificar se já existe algum utilizador com o mesmo email ou nomeUnico
        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE email = :email OR nomeUnico = :nomeUnico');
        $stmt->execute(array(':email' => $email,':nomeUnico' => $nomeUnico));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        //Se não existir então verifica-se o nome único
        if ($data === false) {
            try{
                $stmt = $conexao->runQuery('INSERT INTO utilizadores (nomeCompleto, nomeUnico, password, email, imagemPerfil, permissao) VALUES (:nomeCompleto, :nomeUnico,:pass_utiliz, :email_utiliz, :imagemPerfil, :permissao)');
                $stmt->execute(array(':nomeCompleto' => $nomeCompleto, ':nomeUnico' => $nomeUnico,':pass_utiliz' => $password, ':email_utiliz' => $email, ':imagemPerfil' => $imagemPerfil, ':permissao' => "utilizador"));

                return true;
            }catch(PDOException $e){
                echo "Error";
            }

            
        }else{
            return false;
        }
    }
}
