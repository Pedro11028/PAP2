<?php

require 'conexao.php';

class Utilizador {

    function UtilizadorEValido($email,$password){
        $conexao = new Conexao();
        $stmt = $conexao->runQuery('SELECT * FROM utilizadores WHERE email = :email');
        $stmt-> execute(array(':email' => $email));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data == false) {
            return false;
        } else {
            if ($password == $data['password']) {
               $filtrarDados = array( 'Id_utilizador'=> $data["Id_utilizador"], 
                                     'nomeUnico' => $data["nomeUnico"],
                                     'permissao' => $data["permissao"]
                                   );

                return $filtrarDados;
            } else{
            return false;
            }
        }
    }
  }