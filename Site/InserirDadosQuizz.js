$(document).ready(function(){
    document.getElementById('linkInicio').innerHTML = "Cancelar";
    document.getElementById('linkInicio').href = "CancelarInserirDados.php";
    document.getElementById("menuBarraPesquisa").remove();
    document.getElementById("menuSearch").remove();
    document.getElementById("linkCriarQuizz").innerHTML = "Guardar";
    document.getElementById("menuCriarQuizz").style.float= "right";
    document.getElementById("menuCriarQuizz").style.left= "0px";
    document.getElementById("dropUtilizador").remove();



});

//Funções referentes à visualização do form de atualização da imagem de perfil
function carregarImagemQuizz(){
    document.getElementById("imagemQuestao").style.display= "inline";
    document.getElementById("selecionarImagemQuizz").style.display= "none";
    
    document.getElementById("imagemQuestao").src = document.getElementById("escolherImagem").value;
    alert(document.getElementById("escolherImagem").value);
}