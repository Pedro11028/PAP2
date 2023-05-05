<?php

require '../utilizador.php';

EValido_TestVazio(); 
echo "<br>";
EValido_TestUtilizadorNaoExiste();
echo "<br>";
EValido_TestUtilizadorExiste();
echo "<br>";
Guardar_InserirUtilizadorInvalido();
echo "<br>";
Guardar_InserirUtilizadorValido();


function EValido_TestVazio(){
    $utilizador = new Utilizador();
    $result = $utilizador->EValido("","");
    echo "EValido_TestVazio - expected:"."false"." VS real:".json_encode($result);
}

function EValido_TestUtilizadorNaoExiste(){
    $utilizador = new Utilizador();
    $result = $utilizador->EValido("dsgd@asg.com","fsdfasd");
    echo "EValido_TestUtilizadorNaoExists - expected:"."false"." VS real:".json_encode($result);
}

function EValido_TestUtilizadorExiste(){
    $utilizador = new Utilizador();
    $result = $utilizador->EValido("pedro@gmail.com","qaws1234");
    echo "EValido_TestUtilizadorExiste - expected:"."pedro@gmail.com"." qaws1234"." VS real:".json_encode($result);
}

function Guardar_InserirUtilizadorInvalido(){
    $utilizador = new Utilizador();
    $result = $utilizador->Guardar("Pedro Oliveira", "Pedr0siris", "pedro@gmail.com", "qaws1234");
    echo "Guardar_InserirUtilizadorInvalido - expected:"." false "." VS real:".json_encode($result);
}

function Guardar_InserirUtilizadorValido(){
    $utilizador = new Utilizador();
    $result = $utilizador->Guardar("aaa aaa", "aaa", "aaa@aaa.com", "aaaaaaaa");
    echo "Guardar_InserirUtilizadorValido - expected:"."true"." VS real:".json_encode($result);
    echo "<br>";
    $result = $utilizador->EValido("aaa@aaa.com", "aaaaaaaa");
    echo "Guardar_InserirUtilizadorValido - expected:"."aaa@aaa.com"."aaaaaaaa"." VS real:".json_encode($result);
}
