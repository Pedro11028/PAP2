<?php

// defenir base de dados
define('host', 'localhost');
define('user', 'root');
define('pass', '');
define('nomebd', 'papbd');

class Conexao {
    // Properties
    public $connect;

    function __construct() {
        // Conectar á base de dados
        try {
            $this->connect = new PDO("mysql:host=" . host . "; dbname=" . nomebd, user, pass);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $error) {
            echo $error->getMessage();
        }
    }

    function runQuery($query)
    {
        return $this->connect->prepare($query);
    }
}
?>