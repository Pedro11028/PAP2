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
echo "<br>";
echo "<hr>";


Alterar_AlterarPasswordAtualInvalida();
echo "<br>";
Alterar_AlterarPasswordConfirmarInvalida();
echo "<br>";
Alterar_AlterarPasswordNovaInvalida();
echo "<br>";
Alterar_AlterarPasswordValido();
echo "<br>";
echo "<hr>";


Carregar_CarregarDadosInvalidos();
echo "<br>";
Carregar_CarregarDadosValidos();
echo "<br>";

// ----------------------------------------------------------------------------------------------------------------



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

// ----------------------------------------------------------------------------------------------------------------



function Guardar_InserirUtilizadorInvalido(){
    $utilizador = new Utilizador();
    $result = $utilizador->Guardar("Pedro Oliveira", "Pedr0siris", "pedro@gmail.com", "qaws1234");
    echo "Guardar_InserirUtilizadorInvalido - expected:"." false "." VS real:".json_encode($result);
}

function Guardar_InserirUtilizadorValido(){
    $utilizador = new Utilizador();
    $result = $utilizador->Guardar("bbb bbb", "bbb", "bbb@bbb.com", "bbbbbbbb");
    echo "Guardar_InserirUtilizadorValido - expected:"."true"." VS real:".json_encode($result);
    echo "<br>";
    echo "<br>";
    $result = $utilizador->EValido("bbb@bbb.com", "bbbbbbbb");
    echo "Guardar_InserirUtilizadorValido - expected:"."aaa@aaa.com"."aaaaaaaa"." VS real:".json_encode($result);
}

// ----------------------------------------------------------------------------------------------------------------



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

// ----------------------------------------------------------------------------------------------------------------


function Alterar_AlterarPasswordAtualInvalida(){
    $utilizador = new Utilizador();
    $result = $utilizador->Alterar("asasasas", "sdasdasdas","asdfsdfsdf","351");
    echo "Alterar_AlterarPasswordAtualInvalida - expected:"." PassworAtualErrada "." VS real:".json_encode($result);
}

function Alterar_AlterarPasswordConfirmarInvalida(){
    $utilizador = new Utilizador();
    $result = $utilizador->Alterar("aaaaaaaa", "sdasdasdas","asdfsdfsdf","351");
    echo "Alterar_AlterarPasswordConfirmarInvalida - expected:"." PasswordConfirmarDiferente "." VS real:".json_encode($result);
}

function Alterar_AlterarPasswordNovaInvalida(){
    $utilizador = new Utilizador();
    $result = $utilizador->Alterar("aaaaaaaa", "aaaaaaaa","aaaaaaaa","351");
    echo "Alterar_AlterarPasswordNovaInvalida - expected:"." PasswordIgualAnterior "." VS real:".json_encode($result);
}

function Alterar_AlterarPasswordValido(){
    $utilizador = new Utilizador();
    $result = $utilizador->Alterar("asasasas","aaaaaaaa","aaaaaaaa","351");
    echo "Alterar_AlterarPasswordValida - expected:"." true "." VS real:".json_encode($result);
}

// ----------------------------------------------------------------------------------------------------------------


function Carregar_CarregarDadosInvalidos(){
    $utilizador = new Utilizador();
    $result = $utilizador->Carregar("350");
    echo "Carregar_CarregarDadosInvalidos - expected:"." false "." VS real:".json_encode($result);
}

function Carregar_CarregarDadosValidos(){
    $utilizador = new Utilizador();
    $result = $utilizador->Carregar("351");
    echo "Carregar_CarregarDadosValidos - expected:"." Dados do Utilizador "." VS real:".json_encode($result);
}