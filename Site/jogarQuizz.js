$(document).ready(function(){

        
    if(localStorage.getItem("numeroQuestoesRespondidas") == localStorage.getItem("numeroQuestoes")){
        window.location.href= "resultadosJogo.php";
    }


    document.getElementById("menuBarraPesquisa").remove();
    document.getElementById("dropdownUtilizador").remove();
    document.getElementById("menuCriarQuestao").remove();
    document.getElementById("mostrarConteudosMenu").remove();
    document.getElementById("menuPrincipal").className = 'navbar navbar-expand-lg navbar-dark bg-dark';
    document.getElementById("navbarColor02").className = '';
    
    document.getElementById("menuCancelarQuestao").style.display="inline";
 
    //Embora o botão tenha o id "menuAdicionarQuestao" nesta página ele servirá para eliminar a mesma
    document.getElementById("logotipoSite").innerHTML="";

    const questoesDoQuizz= JSON.parse(localStorage.getItem('dadosQuestoesDoQuizz'));
    const numeroQuestoesRespondidas= localStorage.getItem("numeroQuestoesRespondidas");

    // obter o Tipo de questão e com isso determinar o formato da página
    const Id_questao = questoesDoQuizz[numeroQuestoesRespondidas]['Id_questao'];
    const Id_utilizador = localStorage.getItem("Id_utilizador");

    if(document.getElementById("digitarQuestao").matches(':hover')){
        document.getElementById("digitarQuestao").style.backgroundColor= "black";
    }

    //Obter dados da questao a ser editada
    $.ajax({
        type:"POST",
        url: "../API/obterDadosQuestaoApi.php",
        data:{
            accao:"obterDados",
            Id_questao:Id_questao,
            Id_utilizador:Id_utilizador
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            tipoQuestaoENome(resposta);
            carregarImagemQuizz(resposta['imagemQuestao']);
            criarTipoCookie(resposta['dadosQuestao']['tipoQuestao']);
            localStorage.setItem('respostasCorretasEIncorretas', JSON.stringify(resposta['dadosRespostas']))
        }
    });

    $(document).on('click','#menuCancelarQuestao',function(e){
        localStorage.removeItem('dadosQuestoesDoQuizz');
        localStorage.getItem("numeroQuestoesRespondidas");
        localStorage.getItem("respostasCorretasEIncorretas");
        window.location.href= "informacoesQuizz.php";
    });

    function tipoQuestaoENome(dadosQuestao){
        if(dadosQuestao['dadosQuestao']['tipoQuestao'] == 'textoLivre'){
            document.getElementById("selecionarResposta").remove();
            inserirDadosDoTipoEscreverResposta(dadosQuestao);
        }else{
            if(dadosQuestao['dadosQuestao']['tipoQuestao']  == null){
                location.href="escolherTipoQuestao.html";
            }else{
                document.getElementById("escreverResposta").remove();
                inserirDadosDoTipoSelecionarResposta(dadosQuestao);
            }
        }

        
        if(dadosQuestao['dadosQuestao']['nomeQuestao'] != ""){
            document.getElementById("nomeQuestao").innerHTML= dadosQuestao['dadosQuestao']['nomeQuestao'];
        }else{
            document.getElementById("nomeQuestao").remove();
        }
    }

    function inserirDadosDoTipoSelecionarResposta(dadosQuestao){
        tamanhoArray= dadosQuestao['dadosRespostas'].length;
        document.getElementById("digitarQuestao").innerHTML = dadosQuestao['dadosQuestao']['textoQuestao'];

        for (let i = 0; i < tamanhoArray; i++) {
            iplus1= i+1;
            document.getElementById("digitarResposta"+iplus1).innerHTML=  dadosQuestao['dadosRespostas'][i]['respostaQuizz'];
        }

        for (let i = tamanhoArray; i < 4; i++) {
            iplus1= i+1;
            document.getElementById("questao"+iplus1).style.display = 'none';
        }
    }

    function inserirDadosDoTipoEscreverResposta(dadosQuestao){
        document.getElementById("digitarQuestao").innerHTML = dadosQuestao['dadosQuestao']['textoQuestao'];
    
    }

    function criarTipoCookie(nomeCookie) { 
        var hoje = new Date();
        var tempo = hoje.getTime();
        var expirarCookie = tempo + 3600000*24;       
        hoje.setTime(expirarCookie);
      
        document.cookie = "tipoQuestaoCookie= "+nomeCookie+';expires='+hoje.toUTCString()+"; secure=true"+';path=/';
    }
    
    // função para mostrar o aspeto da imagem obtendo o caminho da mesma que neste caso fica num diretório temporário
    function carregarImagemQuizz(imagem){
        if(imagem == "" || imagem == " "){
            document.getElementById("selecionarImagemQuizz").remove();
        }else{
            document.getElementById("imagemQuestao").style.display= "inline";
            document.getElementById("selecionarImagemQuizz").style.display= "none";
            
            document.getElementById("imagemQuestao").src = imagem;
        
            document.getElementById("digitarQuestao").style.left= "35%";
        }
    }

});

function confirmarEscolhaSelecionada(numeroQuestao){
    const respostasCorretasEIncorretas= JSON.parse(localStorage.getItem('respostasCorretasEIncorretas'));

    if(respostasCorretasEIncorretas[numeroQuestao]['valorResposta'] == 'true'){
        document.getElementById("containerResposta"+numeroQuestao).style.transition= "background 1s";  
        document.getElementById("containerResposta"+numeroQuestao).style.backgroundColor= "green"; 
        
        const pontosAtuais= parseInt(localStorage.getItem("totalPontosAcumulados")) + parseInt(localStorage.getItem("pontosPorQuestao"));
        localStorage.setItem("totalPontosAcumulados", pontosAtuais);

        for (let i = 1; i <= 3; i++) {
            iMenos1= i-1;
            if(iMenos1 != numeroQuestao){
                document.getElementById("questao"+i).style.transition = "0.5s";  
                document.getElementById("questao"+i).style.opacity = "0";  
            };
        }

        setTimeout(() => {
            const questaoAtual= localStorage.getItem("numeroQuestoesRespondidas");
            const novaQuestao = parseInt(questaoAtual)+1;
            localStorage.setItem("numeroQuestoesRespondidas", novaQuestao);
            window.location.reload()
        }, 1100);
    
    }else{
        document.getElementById("containerResposta"+numeroQuestao).style.transition= "background 1s";  
        document.getElementById("containerResposta"+numeroQuestao).style.backgroundColor= "red";  
        
        for (let i = 1; i <= 3; i++) {
            iMenos1= i-1;
            if(iMenos1 != numeroQuestao){
                document.getElementById("questao"+i).style.transition = "0.5s";  
                document.getElementById("questao"+i).style.opacity = "0";  
            };
        }

        setTimeout(() => {
            const questaoAtual= localStorage.getItem("numeroQuestoesRespondidas");
            const novaQuestao = parseInt(questaoAtual)+1;
            localStorage.setItem("numeroQuestoesRespondidas", novaQuestao);
            window.location.reload()
        }, 1100);
    }
}

function confirmarEscolhaEscrita(){
    const respostasCorretasEIncorretas= JSON.parse(localStorage.getItem('respostasCorretasEIncorretas'));
    verificarResposta=0;

    if(document.getElementById("digitarResposta1").value){
        for (let i = 0; i < respostasCorretasEIncorretas.length; i++) {
            if(respostasCorretasEIncorretas[i]['respostaQuizz'] == document.getElementById("digitarResposta1").value){
                verificarResposta = 1;
            }
        }
    
        if(verificarResposta == 1){
            document.getElementById('digitarResposta1').style.transition= "background 1s";  
            document.getElementById('digitarResposta1').style.backgroundColor= "green"; 

            const pontosAtuais= parseInt(localStorage.getItem("totalPontosAcumulados")) + parseInt(localStorage.getItem("pontosPorQuestao"));
            localStorage.setItem("totalPontosAcumulados", pontosAtuais);

            setTimeout(() => {
                const questaoAtual= localStorage.getItem("numeroQuestoesRespondidas");
                const novaQuestao = parseInt(questaoAtual)+1;
                localStorage.setItem("numeroQuestoesRespondidas", novaQuestao);
                window.location.reload()
            }, 1100);
        }else{
            document.getElementById('digitarResposta1').style.transition= "background 1s";  
            document.getElementById('digitarResposta1').style.backgroundColor= "red";

            setTimeout(() => {
                const questaoAtual= localStorage.getItem("numeroQuestoesRespondidas");
                const novaQuestao = parseInt(questaoAtual)+1;
                localStorage.setItem("numeroQuestoesRespondidas", novaQuestao);
                window.location.reload()
            }, 1100);
        }

    }else{
        toastr.warning('Por favor escreva algo no campo resposta!', 'Woops!!!');
    }
}