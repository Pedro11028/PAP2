<?php
require 'Domain/utilizador.php';

switch ($_POST['accao'])
{
    case 'uploadImg':
        uploadImg($_POST['Id_utilizador'],$_FILES);
    break;
    default:
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $_POST['accao'] . " is not valid"));
        break;
}

function uploadImg($Id_utilizador,$ficheiro){
    try {
        // Do your stuff  
        $utilizador = new Utilizador();
        $uploadImg = $utilizador-> UploadImage($Id_utilizador,$ficheiro);      
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok', true, 200);
        echo $uploadImg;
        return;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        return;
    }

}

?>