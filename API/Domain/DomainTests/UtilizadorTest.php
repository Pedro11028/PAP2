<?php

require '../utilizador.php';

EValido_TestVazio(); 
echo "<br>";
EValido_TestUtilizadorNaoExiste();
echo "<br>";
EValido_TestUtilizadorExiste();
echo "<br>";
echo "<hr>";
Guardar_InserirUtilizadorInvalido();
echo "<br>";
Guardar_InserirUtilizadorValido();
echo "<br>";
echo "<hr>";
Eliminar_EliminarUtilizadorPasswordInvalida();
echo "<br>";
Eliminar_EliminarUtilizadorPasswordNaoCorresponde();
echo "<br>";
Eliminar_EliminarUtilizadorValido();


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
    echo "<br>";
    $result = $utilizador->EValido("aaa@aaa.com", "aaaaaaaa");
    echo "Guardar_InserirUtilizadorValido - expected:"."aaa@aaa.com"."aaaaaaaa"." VS real:".json_encode($result);
}

function Eliminar_EliminarUtilizadorPasswordInvalida(){
    $utilizador = new Utilizador();
    $result = $utilizador->Eliminar("sdasdasdas","sdasdasdas","344");
    echo "Eliminar_EliminarUtilizadorPasswordInvalida - expected:"." passwordNaoExiste "." VS real:".json_encode($result);
}

function Eliminar_EliminarUtilizadorPasswordNaoCorresponde(){
    $utilizador = new Utilizador();
    $result = $utilizador->Eliminar("sdasdasdas","asdfsdfsdf","344");
    echo "Eliminar_EliminarUtilizadorPasswordNaoCorresponde - expected:"." passwordsNaoCorrespondem "." VS real:".json_encode($result);
}

function Eliminar_EliminarUtilizadorValido(){
    $utilizador = new Utilizador();
    $result = $utilizador->Eliminar("aaaaaaaa","aaaaaaaa","347");
    echo "Eliminar_EliminarUtilizadorValido - expected:"." true "." VS real:".json_encode($result);
}
