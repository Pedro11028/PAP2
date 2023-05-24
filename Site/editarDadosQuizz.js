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

    document.getElementById("menuAdicionarQuestao").style.display="inline";
    document.getElementById("menuAdicionarQuestao").style.float= "right";
    document.getElementById("menuAdicionarQuestao").style.left= "0px";

    document.getElementById("dropUtilizador").remove();

    // Eliminar o cookie que indica o tipo de questao a ser criada
    var hoje = new Date();
    hoje.setMonth( hoje.getMonth() - 1 );

    document.cookie = "escolherTipoQuestao= "+document.cookie.indexOf('escolherTipoQuestao')
                     +';expires='+hoje.toUTCString()
                     +"; secure=true"
                     +';path=/';


    // Obter dados do quizz como; nome, tipo, imagem e número de respostas do mesmo
    var Id_utilizador= getIdCookie();

    $.ajax({
        type:"POST",
        url: "../API/carregarDadosQuizzApi.php",
        data:{
            accao:"carregar",
            Id_utilizador:Id_utilizador
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            console.log(resposta);
            filtrarEMostrarDadosQuestoes(resposta);
        }
    });

    function getIdCookie() {
        let cookie = {};
        document.cookie.split(';').forEach(function(separar) {
            let [key,value] = separar.split('=');
            cookie[key.trim()] = value;
        })

        return cookie['idCookie'];
    }

    // filtrar dados e escrever na página as questões exixtentes do quizz
    function filtrarEMostrarDadosQuestoes(dadosQuestoesENumeroRespostas){
        const dadosQuestoes= dadosQuestoesENumeroRespostas['dadosQuestoes'];
        const numeroRespostas= dadosQuestoesENumeroRespostas['numeroRespostas'];


        for (let i= 0; i < dadosQuestoes.length; i++) {

            const iplus1=i+1;

            var container = document.getElementById("carregarDadosNaPagina");

            const divNumeroQuestao = document.createElement("div");
            divNumeroQuestao.innerHTML = 'Questao nº'+iplus1+' - '+dadosQuestoes[i]['tipoQuestao'];
            divNumeroQuestao.classList.add('numeroDaQuestao','container');
            container.appendChild(divNumeroQuestao);

            const divOrganizarDadosQuestao = document.createElement("div");
            divOrganizarDadosQuestao.id = "organizarDadosQuestao"+iplus1;
            divOrganizarDadosQuestao.style.border= "3px outset black";
            divOrganizarDadosQuestao.classList.add('organizarDadosQuestao','container');
            container.appendChild(divOrganizarDadosQuestao);

            container = document.getElementById("organizarDadosQuestao"+iplus1);

            const divRow = document.createElement("div");
            divRow.id="row"+iplus1;
            divRow.classList.add('row','h-100');
            container.appendChild(divRow);

            container = document.getElementById("row"+iplus1);

            //função organizar e inserir a informação da questão
            const divOrganizarNomeQuestao = document.createElement("div");
            divOrganizarNomeQuestao.id="organizarNomeQuestao"+iplus1;
            divOrganizarNomeQuestao.innerHTML = '<input id="nomeQuestao'+iplus1+'" type="text" class="nomeQuestao" placeholder="Nome: (Opcional)">';
            divOrganizarNomeQuestao.classList.add('col-sm-3','dadosQuizz');
            container.appendChild(divOrganizarNomeQuestao);

            const divOrganizarNumeroRespostas = document.createElement("div");
            divOrganizarNumeroRespostas.id="organizarNumeroRespostas"+iplus1;
            divOrganizarNumeroRespostas.innerHTML = '<label type="text" class="numeroRespostas">Número de respostas:</label>'
                                                   +'<label id="numeroRespostas'+iplus1+'" type="text" class="numeroRespostas">&nbsp '+numeroRespostas[i]['numRespostas']+'</label>';
            divOrganizarNumeroRespostas.classList.add('col-sm-3','dadosQuizz');
            container.appendChild(divOrganizarNumeroRespostas);

            const divOrganizarInformacoesImagem = document.createElement("div");
            divOrganizarInformacoesImagem.id="organizarInformacoesImagem"+iplus1;
            divOrganizarInformacoesImagem.innerHTML = '<label type="text" class="contemImagem" >Contém Imagem?</label>'
                                                     +'<label id="contemImagem'+iplus1+'" type="text" class="contemImagem">&nbsp '+dadosQuestoes[i]['imagem']+'</label>';
            divOrganizarInformacoesImagem.classList.add('col-sm-3','dadosQuizz');
            container.appendChild(divOrganizarInformacoesImagem);

            const divOrganizarBotaoEditar = document.createElement("div");
            divOrganizarBotaoEditar.id="organizarBotaoEditar"+iplus1;
            divOrganizarBotaoEditar.innerHTML = '<button id="botaoEditar'+iplus1+'" type="text" class="btn button border">Editar</button>';
            divOrganizarBotaoEditar.classList.add('col-sm-2','dadosQuizz');
            container.appendChild(divOrganizarBotaoEditar);
        }
    }
    
});

