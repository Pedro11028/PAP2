<?php

require 'conexao.php';

class Utilizador {

    function UtilizadorEValido($email,$password){
        $conexao = new Conexao();
        $stmt = $conexao->runQuery('INSERT INTO utilizadores (password, email) VALUES (:pass_utiliz, :email_utiliz)');
        $stmt-> execute(array(':pass_utiliz' => $password, ':email_utiliz' => $email));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);            
        return $email;

    }
}