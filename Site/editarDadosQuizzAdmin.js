$(document).ready(function(){

    document.getElementById("menuGuardarQuestao").style.display="inline";
    document.getElementById("menuCancelarQuestao").style.display="inline";
        

    document.getElementById("menuCancelarQuestao").remove();
    document.getElementById("menuBarraPesquisa").remove();
    document.getElementById("dropdownUtilizador").remove();
    document.getElementById("menuCriarQuestao").remove();
    

    document.getElementById("menuAdicionarQuestao").style.display="inline";
    
    document.getElementById("menuEliminarQuizz").style.display="inline";
    
    function tamanhoDaJanela(media) {
        if (media.matches) {
            document.getElementById("menuAdicionarQuestao").style.position= "relative";
            document.getElementById("menuAdicionarQuestao").style.right= "0px";

        } else {
            document.getElementById("menuAdicionarQuestao").style.position= "absolute";
            document.getElementById("menuAdicionarQuestao").style.right= "190px";
        }
    }

    const media = window.matchMedia("(max-width: 700px)");
    tamanhoDaJanela(media);
    media.addListener(tamanhoDaJanela);

    $("#menuGuardarQuestao").click(function(){
        location.href="guardarQuizzAdmin.html";
    });

    $("#menuAdicionarQuestao").click(function(){
        location.href="escolherTipoQuestaoAdmin.html";
    });

    $("#menuEliminarQuizz").click(function(){
        if (window.confirm("Tens a certesa que queres eliminar o quizz atual?")) {
             var Id_utilizador= localStorage.getItem("Id_utilizadorAEditarQuizzAdmin");
             const tipoTemporario= "temporarioAdmin";

             $.ajax({
                 type:"POST",
                 url: "../API/eliminarQuizzApi.php",
                 data:{
                     accao:"eliminarQuizz",
                     Id_utilizador:Id_utilizador,
                     tipoTemporario:tipoTemporario
                 },
                 cache: false,
                 dataType: 'json',
                 success: function(resposta) {
                     if(resposta == 'dadosEliminadosComSucesso'){
                        eliminarCookies();
                        location.href='index.php';
                     }
                 }
             });
        }
    });

    function eliminarCookies(){
        var hoje = new Date();
        hoje.setMonth( hoje.getMonth() - 1 );
        
        document.cookie = "tipoQuestaoCookieAdmin= "+document.cookie.indexOf('tipoQuestaoCookie')
                         +';expires='+hoje.toUTCString()
                         +"; secure=true"
                         +';path=/';
      
        document.cookie = "idQuestaoAEditarAdmin= "+document.cookie.indexOf('idQuestaoAEditar')
                         +';expires='+hoje.toUTCString()
                         +"; secure=true"
                         +';path=/';
        
        return true;
    }
    // Eliminar o cookie que indica o tipo de questao a ser criada
    var hoje = new Date();
    hoje.setMonth( hoje.getMonth() - 1 );

    document.cookie = "escolherTipoQuestao= "+document.cookie.indexOf('escolherTipoQuestao')
                     +';expires='+hoje.toUTCString()
                     +"; secure=true"
                     +';path=/';


    // Obter dados do quizz como:
        // nome, tipo, imagem e número de respostas da questão

    var Id_utilizador= localStorage.getItem("Id_utilizadorAEditarQuizzAdmin");

    $.ajax({
        type:"POST",
        url: "../API/carregarDadosQuizzApi.php",
        data:{
            accao:"carregarDadosQuizzAdmin",
            Id_utilizador:Id_utilizador
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            if(resposta[0] == 'true'){
                console.log(Id_utilizador);
            }else{
                console.log(resposta);
                filtrarEMostrarDadosQuestoes(resposta);
            }
        }
    });


    // filtrar dados e escrever na página as questões exixtentes do quizz
    function filtrarEMostrarDadosQuestoes(dadosQuestoesENumeroRespostas){
        const dadosQuestoes= dadosQuestoesENumeroRespostas['dadosQuestoes'];
        const numeroRespostas= dadosQuestoesENumeroRespostas['numeroRespostas'];

        for (let i= 0; i < dadosQuestoes.length; i++) {
            const iplus1=i+1;

            //Função para criar um identificador da questao e um container principal que servirá para organizar a informação da mesma
            var container = document.getElementById("carregarDadosNaPagina");
            criarIdentificadorDaQuestaoEOrganizadorQuestao(container, i, iplus1, dadosQuestoes);

            // Criar row para organizar conteúdo da Questao
            container = document.getElementById("organizarDadosQuestao"+iplus1);
            criarRow(container, iplus1);

            //função organizar e inserir a informação da questão
            container = document.getElementById("row"+iplus1);
            criarConteudoDentroDoRow(container, i, iplus1, dadosQuestoes, numeroRespostas);

            //Atualizar nome Questao
            document.getElementById("nomeQuestao"+iplus1).value= dadosQuestoes[i]['nomeQuestao'];
        }
    }

});

//------------------------------------------------

//Funções referidas em cima
function criarIdentificadorDaQuestaoEOrganizadorQuestao(container, i, iplus1, dadosQuestoes){
    const divNumeroQuestao = document.createElement("div");
    divNumeroQuestao.innerHTML = 'Questao nº'+iplus1+' - '+dadosQuestoes[i]['tipoQuestao'];
    divNumeroQuestao.classList.add('numeroDaQuestao','container');
    container.appendChild(divNumeroQuestao);

    const divOrganizarDadosQuestao = document.createElement("div");
    divOrganizarDadosQuestao.id = "organizarDadosQuestao"+iplus1;
    divOrganizarDadosQuestao.style.border= "3px outset black";
    divOrganizarDadosQuestao.classList.add('organizarDadosQuestao','container');
    container.appendChild(divOrganizarDadosQuestao);
}


function criarRow(container, iplus1){
    const divRow = document.createElement("div");
    divRow.id="row"+iplus1;
    divRow.classList.add('row','h-100');
    container.appendChild(divRow);
}


function criarConteudoDentroDoRow(container, i, iplus1, dadosQuestoes, numeroRespostas){
        
        const divOrganizarNomeQuestao = document.createElement("div");
        divOrganizarNomeQuestao.id="organizarNomeQuestao"+iplus1;
        divOrganizarNomeQuestao.innerHTML = '<input id="nomeQuestao'+iplus1+'" type="text" class="nomeQuestao" maxlength="30" placeholder="Nome: (Opcional) max: 30 letras">'
                                            +'<button type="text" class="btn button border botaoGuardarNome" onclick="guardarNomeQuestao('+dadosQuestoes[i]['Id_questao']+', '+iplus1+')"> Guardar</button>';
        divOrganizarNomeQuestao.classList.add('col-sm-6','dadosQuizz');                        
        container.appendChild(divOrganizarNomeQuestao);

        const divOrganizarNumeroRespostas = document.createElement("div");
        divOrganizarNumeroRespostas.id="organizarNumeroRespostas"+iplus1;
        divOrganizarNumeroRespostas.innerHTML = '<label type="text" class="numeroRespostas">Respostas:</label>'
                                                +'<label id="numeroRespostas'+iplus1+'" type="text" class="numeroRespostas">&nbsp '+numeroRespostas[i]['numRespostas']+'</label>';
        divOrganizarNumeroRespostas.classList.add('col-sm-2','dadosQuizz');
        container.appendChild(divOrganizarNumeroRespostas);

        const divOrganizarInformacoesImagem = document.createElement("div");
        divOrganizarInformacoesImagem.id="organizarInformacoesImagem"+iplus1;
        divOrganizarInformacoesImagem.innerHTML = '<label type="text" class="contemImagem" >Imagem?</label>'
                                                 +'<label id="contemImagem'+iplus1+'" type="text" class="contemImagem">&nbsp '+dadosQuestoes[i]['imagem']+'</label>';
        divOrganizarInformacoesImagem.classList.add('col-sm-2','dadosQuizz');
        container.appendChild(divOrganizarInformacoesImagem);

        const divOrganizarBotaoEditar = document.createElement("div");
        divOrganizarBotaoEditar.id="organizarBotaoEditar"+iplus1;
        divOrganizarBotaoEditar.innerHTML = '<button type="text" class="btn button border botaoEditar" onclick="guardarId_questaoParaAEditar('+dadosQuestoes[i]['Id_questao']+')">Editar</button>';
        divOrganizarBotaoEditar.classList.add('col-sm-2','dadosQuizz');
        container.appendChild(divOrganizarBotaoEditar);
}

//------------------------------------------------------------

    
function guardarNomeQuestao(Id_questao, numeroDaOrdemQuestao){
    nomeQuestao= document.getElementById("nomeQuestao"+numeroDaOrdemQuestao).value;
    
    $.ajax({
        type:"POST",
        url: "../API/guardarNomeQuestaoApi.php",
        data:{
            accao:"guardar",
            nomeQuestao:nomeQuestao,
            Id_questao:Id_questao
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            if(resposta == 'alteradoComSucesso'){
                toastr.success('Nome da questão alterado com sucesso', 'Sucesso');
            }
        }
    });
}


function guardarId_questaoParaAEditar(Id_questao){
    var hoje = new Date();
    var tempo = hoje.getTime();
    var expirarCookie = tempo + 3600000;       
    hoje.setTime(expirarCookie);
  
    document.cookie = "idQuestaoAEditar= "+Id_questao+';expires='+hoje.toUTCString()+"; secure=true"+';path=/';

    location.href="editarDadosQuestaoAdmin.php";
}