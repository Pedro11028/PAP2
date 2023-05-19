$(document).ready(function(){
    document.getElementById('linkInicio').innerHTML = "Cancelar";
    document.getElementById('linkInicio').href = "CancelarInserirDados.php";
    document.getElementById("menuBarraPesquisa").remove();
    document.getElementById("menuSearch").remove();
    document.getElementById("linkCriarQuizz").innerHTML = "Guardar";
    document.getElementById("menuCriarQuizz").style.float= "right";
    document.getElementById("menuCriarQuizz").style.left= "0px";
    document.getElementById("dropUtilizador").remove();

    var Id_utilizador = getIdCookie();

    $("#escolherImagem").on('change', function() {
        var verificarNome = /^[a-zA-Z]+ [a-zA-Z]+$/;
        var nomeCompleto = document.getElementById('nomeCompleto').value;

        if(!verificarNome.test(nomeCompleto)){
            alert('Por favor digite um nome válido (primeiro & último nome).');
            document.getElementById('nomeCompleto').focus();
        }else{
            $.ajax({
                type:"POST",
                url: "../API/alterarNomeApi.php",
                data:{
                    accao:"alterarNome",
                    Id_utilizador:Id_utilizador,
                    nomeCompleto:nomeCompleto
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                  if(resposta == 'true'){
                    location.reload();
                  }
                  if(resposta == 'erroBaseDados'){
                    alert('Woops! Parece estar a ocorrer um erro com a ligação á base de dados!');
                  }
                }
            });
        }
        return false;
    });


    function getIdCookie() {
        let cookie = {};
        document.cookie.split(';').forEach(function(separar) {
            let [key,value] = separar.split('=');
            cookie[key.trim()] = value;
        })
        return cookie['idCookie'];
    }
});

//Funções referentes à visualização do form de atualização da imagem de perfil
function carregarImagemQuizz(){
    document.getElementById("imagemQuestao").style.display= "inline";
    document.getElementById("selecionarImagemQuizz").style.display= "none";
    
    document.getElementById("imagemQuestao").src = document.getElementById("escolherImagem").value;


    document.getElementById("digitarQuestao").style.left= "35%";
    document.getElementById("limparImagem").style.visibility = 'visible';
}

function limparImagemQuestao(){
    document.getElementById("imagemQuestao").style.display= "none";
    document.getElementById("selecionarImagemQuizz").style.display= "inline";
    

    document.getElementById("digitarQuestao").style.left= "55px";
    document.getElementById("limparImagem").style.visibility = 'hidden';
    
}

function fecharContainerResposta(questao){
    
    var NumeroQuestoesExistentes= 0;

    for (let i = 1; i <= 4; i++) {
        if(document.getElementById("questao"+i).style.display == "none"){
            NumeroQuestoesExistentes += 1;
        }
    }

    if(NumeroQuestoesExistentes >= 1){
        for (let i = 1; i <= 4; i++) {
            document.getElementById("fecharResposta"+i).style.visibility = 'hidden';
        }
    }

    console.log(NumeroQuestoesExistentes);
    document.getElementById(questao).style.display= "none";

    document.getElementById("adicionarResposta").style.display = "inline";
}

function adicionarCampoResposta(){

    for (let i = 1; i <= 4; i++) {
        if(document.getElementById("questao"+i).style.display == "none"){
            document.getElementById("questao"+i).style.display = "inline";
            break;
        }
    }

    for (let i = 1; i <= 4; i++) {
        document.getElementById("fecharResposta"+i).style.visibility = 'visible';
    }
    
}