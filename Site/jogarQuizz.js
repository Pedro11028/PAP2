$(document).ready(function(){

    document.getElementById("menuBarraPesquisa").remove();
    document.getElementById("dropdownUtilizador").remove();
    document.getElementById("menuCriarQuestao").remove();
    document.getElementById("mostrarConteudosMenu").remove();
    document.getElementById("menuPrincipal").className = 'navbar navbar-expand-lg navbar-dark bg-dark';
    document.getElementById("navbarColor02").className = '';
    
    document.getElementById("menuCancelarQuestao").style.display="inline";
 
    //Embora o botão tenha o id "menuAdicionarQuestao" nesta página ele servirá para eliminar a mesma
    document.getElementById("logotipoSite").innerHTML="";

    if(localStorage.getItem("numeroQuestoesRespondidas") == localStorage.getItem("numeroQuestoes")){
        window.location.href= "informacoesQuizz.php";
    }

    function tamanhoDaJanela(media) {
        if (media.matches) {
            document.getElementById("menuCancelarQuestao").className = 'btn btn-secondary my-2 my-sm-0';
            document.getElementById("menuCancelarQuestao").style.position= "relative";
            document.getElementById("menuCancelarQuestao").style.left= "-230px";
        } else {
            document.getElementById("menuCancelarQuestao").className = 'btn btn-secondary my-2 my-sm-0 esquerda';

        }
    }

    const media = window.matchMedia("(max-width: 700px)");
    tamanhoDaJanela(media);
    media.addListener(tamanhoDaJanela);

    const questoesDoQuizz= JSON.parse(localStorage.getItem('dadosQuestoesDoQuizz'));
    const numeroQuestoesRespondidas= localStorage.getItem("numeroQuestoesRespondidas");

    // obter o Tipo de questão e com isso determinar o formato da página
    const Id_questao = questoesDoQuizz[numeroQuestoesRespondidas]['Id_questao'];
    const Id_utilizador = localStorage.getItem("Id_criadorQuizz");

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
            
            localStorage.setItem('dadosRespostas', JSON.stringify(resposta['dadosRespostas']));
            localStorage.setItem('mostrarPercentagemEscolhas', resposta['dadosQuestao']['mostrarPercentagemEscolhas']);
            localStorage.setItem('mostrarRespostaCorreta', resposta['dadosQuestao']['mostrarRespostaCorreta']);

            console.log(resposta);
        }
    });

    $(document).on('click','#menuCancelarQuestao',function(e){
        localStorage.removeItem('dadosQuestoesDoQuizz');
        localStorage.getItem("numeroQuestoesRespondidas");
        localStorage.getItem("dadosRespostas");
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

        totalDeVezesRespondidas = 0;
        for (let i = 0; i < dadosQuestao['dadosRespostas'].length; i++) {
            totalDeVezesRespondidas += parseInt(dadosQuestao['dadosRespostas'][i]['vezesSelecionada']);
            
        }
        console.log(totalDeVezesRespondidas);
        localStorage.setItem('totalDeVezesRespondidas', totalDeVezesRespondidas);

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
    const dadosRespostas = JSON.parse(localStorage.getItem('dadosRespostas'));
    const Id_resposta = dadosRespostas[numeroQuestao]['Id_resposta'];
    
    const mostrarPercentagemEscolhas = localStorage.getItem('mostrarPercentagemEscolhas');
    const mostrarRespostaCorreta = localStorage.getItem('mostrarRespostaCorreta');

    localStorage.setItem('vezesQueARespostaFoiSelecionada', dadosRespostas[numeroQuestao]['vezesSelecionada']);
    
        $.ajax({
            type:"POST",
            url: "../API/atualizarDadosQuestaoApi.php",
            data:{
                accao:"guardarNumeroRespostasDadas",
                Id_resposta:Id_resposta,
                vezesQueARespostaFoiSelecionada:localStorage.getItem('vezesQueARespostaFoiSelecionada')
            },
            cache: false,
            dataType: 'json',
            success: function(resposta) {
            }
        });

    if(mostrarPercentagemEscolhas == "sim"){
        document.getElementById("progressbarNumeroRespostas").style.display = "inline";
        
        const totalDeVezesRespondidas = parseInt(localStorage.getItem('totalDeVezesRespondidas')) + 1;
        const vezesQueARespostaFoiSelecionada = parseInt(localStorage.getItem('vezesQueARespostaFoiSelecionada')) + 1;
        const percentagemNumeroRespostas= ((parseInt(vezesQueARespostaFoiSelecionada)) / parseInt(totalDeVezesRespondidas)) * 100;
        console.log(totalDeVezesRespondidas);
        console.log(vezesQueARespostaFoiSelecionada);
        console.log(percentagemNumeroRespostas);

        if(localStorage.getItem("totalDeVezesRespondidas") == '0') {
            document.getElementById("resultadoProgresso").innerHTML = "100%";
            $(".progress-bar").animate({
                width: "100%",
            },500);
        }else{
            if(localStorage.getItem("totalDeVezesRespondidas") != '0' && percentagemNumeroRespostas == 0) {
                document.getElementById("resultadoProgresso").innerHTML = "0%";
                $(".progress-bar").animate({
                    width: "5%",
                },500);
            }else{
                document.getElementById("resultadoProgresso").innerHTML = percentagemNumeroRespostas.toFixed(0)+'%';
                $(".progress-bar").animate({
                    width: percentagemNumeroRespostas.toFixed(0)+'%',
                },1000);
            }
        }
       
    }

    if(dadosRespostas[numeroQuestao]['valorResposta'] == 'true'){
        if(mostrarRespostaCorreta == 'sim'){
            document.getElementById("containerResposta"+numeroQuestao).style.transition= "background 1s";
            document.getElementById("containerResposta"+numeroQuestao).style.backgroundColor= "green"; 
        }

        const pontosAtuais= parseInt(localStorage.getItem("totalPontosAcumulados")) + parseInt(localStorage.getItem("pontosPorQuestao"));
        localStorage.setItem("totalPontosAcumulados", pontosAtuais);

        const respostasAcertadas= parseInt(localStorage.getItem("numeroQuestoesAcertadas")) + 1;
        localStorage.setItem("numeroQuestoesAcertadas", respostasAcertadas);

        for (let i = 1; i <= 4; i++) {
            iMenos1= i-1;
            if(iMenos1 != numeroQuestao){
                document.getElementById("questao"+i).style.transition = "0.5s";  
                document.getElementById("questao"+i).style.opacity = "0";  
            };
        }

        setTimeout(() => {
            confirmarProximasQuestoes();
        }, 2500);
    
    }else{
        if(mostrarRespostaCorreta == 'sim'){
            document.getElementById("containerResposta"+numeroQuestao).style.transition= "background 1s";  
            document.getElementById("containerResposta"+numeroQuestao).style.backgroundColor= "red";  
        }
        
        for (let i = 1; i <= 4; i++) {
            iMenos1= i-1;
            if(iMenos1 != numeroQuestao){
                document.getElementById("questao"+i).style.transition = "0.5s";  
                document.getElementById("questao"+i).style.opacity = "0";  
            };
        }

        setTimeout(() => {
            confirmarProximasQuestoes();
        }, 2500);
    }
}

function confirmarEscolhaEscrita(){
    const dadosRespostas= JSON.parse(localStorage.getItem('dadosRespostas'));
    verificarResposta=0;

    if(document.getElementById("digitarResposta1").value){
        for (let i = 0; i < dadosRespostas.length; i++) {
            if(dadosRespostas[i]['respostaQuizz'] == document.getElementById("digitarResposta1").value){
                verificarResposta = 1;
            }
        }
    
        if(verificarResposta == 1){
            document.getElementById('digitarResposta1').style.transition= "background 1s";  
            document.getElementById('digitarResposta1').style.backgroundColor= "green"; 

            const pontosAtuais= parseInt(localStorage.getItem("totalPontosAcumulados")) + parseInt(localStorage.getItem("pontosPorQuestao"));
            localStorage.setItem("totalPontosAcumulados", pontosAtuais);

            const respostasAcertadas= parseInt(localStorage.getItem("numeroQuestoesAcertadas")) + 1;
            localStorage.setItem("numeroQuestoesAcertadas", respostasAcertadas);

            setTimeout(() => {
                confirmarProximasQuestoes();
            }, 2500);
        }else{
            document.getElementById('digitarResposta1').style.transition= "background 1s";  
            document.getElementById('digitarResposta1').style.backgroundColor= "red";

            setTimeout(() => {
                confirmarProximasQuestoes();
            }, 2500);
        }

    }else{
        toastr.warning('Por favor escreva algo no campo resposta!', 'Woops!!!');
    }
}

function confirmarProximasQuestoes(){
    const questaoAtual= localStorage.getItem("numeroQuestoesRespondidas");
    const novaQuestao = parseInt(questaoAtual)+1;

    const Id_quizz= localStorage.getItem("Id_quizzAJogar");
    const Id_utilizador= localStorage.getItem("Id_utilizador");
    const totalPontosAcumulados = localStorage.getItem("totalPontosAcumulados");

    console.log('sdfsdf: '+totalPontosAcumulados);
    console.log('sdfsdf: '+localStorage.getItem("pontosPorQuestao"));
    
        $.ajax({
            type:"POST",
            url: "../API/obterDadosJogoQuizzApi.php",
            data:{
                accao:"guardarPontuacaoUtilizador",
                Id_quizz:Id_quizz,
                Id_utilizador:Id_utilizador,
                totalPontosAcumulados:totalPontosAcumulados
            },
            cache: false,
            dataType: 'json',
            success: function(resposta) {
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
            }
        });

    localStorage.setItem("numeroQuestoesRespondidas", novaQuestao);
    if(localStorage.getItem("numeroQuestoesRespondidas") == localStorage.getItem("numeroQuestoes")){
        window.location.href= "resultadosJogo.php";
    }else{
        window.location.reload();
    }
}