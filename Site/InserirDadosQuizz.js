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
    $(document).on('submit','#MostrarImgPergunta',function(e){

        e.preventDefault();
        var Id_utilizador = getIdCookie();
        var formData = new FormData(this);
        formData.append('accao', "MostrarImgPergunta");
        formData.append('Id_utilizador', Id_utilizador);

        $.ajax({
            method:"POST",
            url: "../API/MostrarImgPerguntaApi.php",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            beforeSend:function(){
            },
            success: function(resposta){
                carregarImagemQuizz(resposta);
            }
        });

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

    function carregarImagemQuizz(imagem){

        document.getElementById("imagemQuestao").style.display= "inline";
        document.getElementById("selecionarImagemQuizz").style.display= "none";
        
        document.getElementById("imagemQuestao").src = imagem;
    
        document.getElementById("digitarQuestao").style.left= "35%";
    }
});

//Funções referentes à visualização do form de atualização da imagem de perfil

function limparImagemQuestao(){
    document.getElementById("imagemQuestao").style.display= "none";
    document.getElementById("selecionarImagemQuizz").style.display= "inline";
    
    document.getElementById("escolherImagem").value = "";

    document.getElementById("digitarQuestao").style.left= "55px";
    
}

function fecharContainerResposta(numeroContainer){
    
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

    document.getElementById("questao"+numeroContainer).style.display = "none";
    document.getElementById("checkBox"+numeroContainer).checked = false;
    document.getElementById("digitarResposta"+numeroContainer).innerHTML = "";

    document.getElementById("adicionarResposta").style.display = "inline";
}

function adicionarCampoResposta(){
    
    var numRespostasInexistentes = 0;
    for (let i = 1; i <= 4; i++) {
        if(document.getElementById("questao"+i).style.display == "none"){
            document.getElementById("questao"+i).style.display = "inline";
            break;
        }
    }

    for (let i = 1; i <= 4; i++) {
        document.getElementById("fecharResposta"+i).style.visibility = 'visible';
        
        if(document.getElementById("questao"+i).style.display == "none"){
            numRespostasInexistentes += 1;
        }
    }
    
    if(numRespostasInexistentes == 0){
        document.getElementById("adicionarResposta").style.display = "none";
    }
}