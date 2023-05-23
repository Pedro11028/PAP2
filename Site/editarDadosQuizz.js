$(document).ready(function(){
    
    document.getElementById('linkInicio').innerHTML = "Cancelar";
    document.getElementById('linkInicio').href = "CancelarInserirDados.php";

    document.getElementById("menuBarraPesquisa").remove();
    document.getElementById("menuSearch").remove();
    
    document.getElementById("menuCriarQuizz").remove();
    
    document.getElementById('botaoGuardar').innerHTML= "Guardar";
    document.getElementById("menuGuardarInfoQuizz").style.display="inline";
    document.getElementById("menuGuardarInfoQuizz").style.float= "right";
    document.getElementById("menuGuardarInfoQuizz").style.left= "0px";

    document.getElementById("dropUtilizador").remove();
});