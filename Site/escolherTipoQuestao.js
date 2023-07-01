$(document).ready(function(){

    const Id_utilizador = localStorage.getItem("Id_utilizador");
    
    localStorage.removeItem("TipoQuestao");
    localStorage.removeItem("mostrarRespostaCorreta");
    localStorage.removeItem("mostrarPercentagemEscolhas");

    document.getElementById('mostrarRespostasCorretas').disabled = true;
    document.getElementById('mostrarPercentagemEscolhas').disabled = true;

    $.ajax({
        type:"POST",
        url: "../API/verificarJaCriouQuizzTempApi.php",
        data:{
            accao:"verificarExistenciaQuizz",
            Id_utilizador:Id_utilizador
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

        if(localStorage.getItem("TipoQuestao")){
            verificarSelecao= 1;
        }

        console.log(verificarSelecao);

         if(verificarSelecao == 1){
             
            // criar localStorage para guardar sub-escolhas da questão
            if(document.getElementById('mostrarRespostasCorretas').checked){
                localStorage.setItem("mostrarRespostaCorreta", "sim");
            }
            
            if(document.getElementById('mostrarPercentagemEscolhas').checked){
                localStorage.setItem("mostrarPercentagemEscolhas", "sim");
            }

            // Criar cookie de acordo com o tipo de questão
            criarCookie(localStorage.getItem("TipoQuestao"));
            location.href="InserirDadosQuizz.php";
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
  
    document.cookie = "escolherTipoQuestao= "+valorCookie+';expires='+hoje.toUTCString()+"; secure=true"+';path=/';
}

if (document.cookie.indexOf('escolherTipoQuestao') > -1 ) {
    location.href="InserirDadosQuizz.php";
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

    if(localStorage.getItem("TipoQuestao") == tipoQuestao){
        document.getElementById('icon_'+tipoQuestao).style.display= "none";
        localStorage.removeItem("TipoQuestao");

        document.getElementById('mostrarRespostasCorretas').disabled = true;
        document.getElementById('mostrarPercentagemEscolhas').disabled = true;
    }else{
        document.getElementById('icon_'+tipoQuestao).style.display= "inline";
        
        localStorage.setItem("TipoQuestao", tipoQuestao);
    
        if(tipoQuestao == "selecionarResposta"){
            document.getElementById('icon_textoLivre').style.display= "none";
        }else{
            document.getElementById('icon_selecionarResposta').style.display= "none";
        }
    }
}