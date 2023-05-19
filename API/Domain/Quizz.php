<?php

require 'conexao.php';

class Quizz {

    function MostrarImgPergunta($Id_utilizador,$ficheiro){
        $conexao = new Conexao();

        $caminhoAGuardar= '../BaseDados/Utilizadores/Utilizador_'.$Id_utilizador.'/ImagemTemporaria/';
        $nomeImagem = $ficheiro['file']['name'];
        $caminhoTemporario=$ficheiro["file"]["tmp_name"];

        //php basename for files
        $basename = basename($nomeImagem);
        $caminhoOriginal = $caminhoAGuardar.$basename;
        
        //Aqui como se sabe se existe uma imagem anterior ou o nome dela elimina-se todos os ficheiros dentro que neste caso só pode ser uma imagem 
        $Imagem = glob($caminhoAGuardar . '*');
            
        foreach ($Imagem as $imagens) {
            if (is_file($imagens)) {
                unlink($imagens);
            }
        }
        move_uploaded_file($caminhoTemporario,$caminhoOriginal);

        return $caminhoOriginal;


    }
    
}