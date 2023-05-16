$(document).ready(function(){
    document.getElementById('linkInicio').innerHTML = "Cancelar";
    document.getElementById('linkInicio').href = "CancelarInserirDados.php";
    document.getElementById("menuBarraPesquisa").remove();
    document.getElementById("menuSearch").remove();
    document.getElementById("linkCriarQuizz").innerHTML = "Guardar";
    document.getElementById("menuCriarQuizz").style.float= "right";
    document.getElementById("menuCriarQuizz").style.left="0px";
    document.getElementById("dropUtilizador").remove();

    if(document.getElementById("imagemQuestao").display === "none"){

    }else{
        document.getElementById("digitarQuestao").style.left="35%";
    }
});

