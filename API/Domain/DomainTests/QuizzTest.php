<?php

require '../Quizz.php';

InserirDados_semImagem(); 
echo "<br>";
echo "<br>";

// InserirDados_comImagem(); 

// ----------------------------------------------------------------------------------------------------------------



function InserirDados_semImagem(){
    $dadosRespostas = array("bem.", "nada bem.", "mais ao menos.", "prefiro não comentar.");
    $respostasCorretas = array("true", "0", "true", "true");

    $Quizz = new Quizz();
    $result = $Quizz->InserirDados("351","Como está o teu dia?","", "mostrarAcerto",$dadosRespostas, $respostasCorretas);
    echo "EValido_TestVazio - expected:"."false"." VS real:".json_encode($result);
}

function InserirDados_comImagem(){
    $dadosRespostas = array("bem.", "nada bem.", "mais ao menos.", "prefiro não comentar.");
    $respostasCorretas = array("true", "0", "true", "true");

    $Quizz = new Quizz();
    $result = $Quizz->InserirDados("356","Como está o teu dia?","../../../BaseDados/Utilizadores/Utilizador_351/ImagemTemporaria/6.png", "mostrarAcerto",$dadosRespostas, $respostasCorretas);
    echo "EValido_TestVazio - expected:"."false"." VS real:".json_encode($result);
}
