$(document).ready(function(){

    const Id_utilizador = localStorage.getItem("Id_utilizadorAEditarQuizzAdmin");
    const tipoTemporario = "temporarioAdmin";
    
    localStorage.removeItem("TipoQuestaoAdmin");
    localStorage.removeItem("mostrarRespostaCorretaAdmin");
    localStorage.removeItem("mostrarPercentagemEscolhasAdmin");

    document.getElementById('mostrarRespostasCorretas').disabled = true;
    document.getElementById('mostrarPercentagemEscolhas').disabled = true;

    $.ajax({
        type:"POST",
        url: "../API/verificarJaCriouQuizzTempApi.php",
        data:{
            accao:"verificarExistenciaQuizz",
            Id_utilizador:Id_utilizador,
            tipoTemporario:tipoTemporario
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
        }
    });

    $(document).on('click','#submit',function(e){
        verificarSelecao= 0;

        if(localStorage.getItem("TipoQuestaoAdmin")){
            verificarSelecao= 1;
        }

        console.log(verificarSelecao);

         if(verificarSelecao == 1){
             
            // criar localStorage para guardar sub-escolhas da questão
            if(document.getElementById('mostrarRespostasCorretas').checked){
                localStorage.setItem("mostrarRespostaCorretaAdmin", "sim");
            }
            
            if(document.getElementById('mostrarPercentagemEscolhas').checked){
                localStorage.setItem("mostrarPercentagemEscolhasAdmin", "sim");
            }

            // Criar cookie de acordo com o tipo de questão
            criarCookie(localStorage.getItem("TipoQuestaoAdmin"));
            location.href="InserirDadosQuizzAdmin.php";
         }else{
             toastr.warning('Por favor selecione pelo menos uma das opções entre "Selecionar Resposta" e "escrever texto livre"', 'Woops!!!');
         }
        
        return false;
    });
});

function criarCookie(valorCookie) {
    var hoje = new Date();
    var tempo = hoje.getTime();
    var expirarCookie = tempo + 9000*1000; // 9000*1000= duas horas e meia
    hoje.setTime(expirarCookie);
  
    document.cookie = "escolherTipoQuestaoAdmin= "+valorCookie+';expires='+hoje.toUTCString()+"; secure=true"+';path=/';
}

if (document.cookie.indexOf('escolherTipoQuestaoAdmin') > -1 ) {
    location.href="InserirDadosQuizzAdmin.php";
}

function selecionarTipoQuestao(tipoQuestao) {

    // verifica se a opção já estava selecionada

    if(tipoQuestao == "selecionarResposta"){
        document.getElementById('mostrarRespostasCorretas').disabled = false;
        document.getElementById('mostrarPercentagemEscolhas').disabled = false;
    }else{
        document.getElementById('mostrarRespostasCorretas').disabled = true;
        document.getElementById('mostrarPercentagemEscolhas').disabled = true;
    }

    if(localStorage.getItem("TipoQuestaoAdmin") == tipoQuestao){
        document.getElementById('icon_'+tipoQuestao).style.display= "none";
        localStorage.removeItem("TipoQuestaoAdmin");

        document.getElementById('mostrarRespostasCorretas').disabled = true;
        document.getElementById('mostrarPercentagemEscolhas').disabled = true;
    }else{
        document.getElementById('icon_'+tipoQuestao).style.display= "inline";
        
        localStorage.setItem("TipoQuestaoAdmin", tipoQuestao);
    
        if(tipoQuestao == "selecionarResposta"){
            document.getElementById('icon_textoLivre').style.display= "none";
        }else{
            document.getElementById('icon_selecionarResposta').style.display= "none";
        }
    }
}