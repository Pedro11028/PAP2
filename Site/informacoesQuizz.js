$(document).ready(function(){
    
    const Id_utilizador= localStorage.getItem("Id_utilizador");
    const Id_quizz= localStorage.getItem("Id_quizzAJogar");

    localStorage.removeItem("numeroQuestoesRespondidas")

    $.ajax({
        type:"POST",
        url: "../API/obterQuizzesApi.php",
        data:{
            accao:"obterDadosQuizzEAvaliacoes",
            Id_utilizador:Id_utilizador,
            Id_quizz:Id_quizz
        },
        cache: false,
        dataType: 'json',
        success: function(resposta){
            console.log(resposta);
            filtrarEMostrarDadosQuizz(resposta);
            filtrarEMostrarDadosAvaliacoes(resposta['dadosAvaliacoes']);
        }
    });

    function filtrarEMostrarDadosQuizz(dadosQuizzEAvaliacoes){
        const dadosCriadorQuizz= dadosQuizzEAvaliacoes['dadosCriadorQuizz'];
        const dadosQuizz= dadosQuizzEAvaliacoes['dadosQuizz'];
        const dadosNumMediaAvaliacoes= dadosQuizzEAvaliacoes['dadosNumMediaAvaliacoes'];
        localStorage.setItem("Id_criadorQuizz", dadosCriadorQuizz['Id_utilizador'] );      
        
        if (Id_utilizador != parseInt(dadosCriadorQuizz['Id_utilizador'])) {
            document.getElementById('editarQuizz').remove();
        }else{
            document.getElementById('editarQuizz').innerHTML= "<b>Editar</b>";
        }


        if(localStorage.getItem("permissaoUtilizador") != "admin"){
            document.getElementById('editarComoAdmin').remove();
        }else{
            document.getElementById('editarComoAdmin').innerHTML= "<b>Editar como Administrador</b>";
           
        }

        if (dadosNumMediaAvaliacoes['mediaAvaliacoes'] == null) {
            dadosNumMediaAvaliacoes['mediaAvaliacoes'] = 0;
        }

        document.getElementById('imgPerfil').src = dadosCriadorQuizz['imagemPerfil'];
        document.getElementById('nomeCriador').innerHTML = dadosCriadorQuizz['nomeUnico'];
        document.getElementById('nomeQuizz').innerHTML = '<b>Nome:</b> '+dadosQuizz['nomeQuizz'];
        document.getElementById('temaQuizz').innerHTML = '<b>Tema:</b> '+dadosQuizz['tema'];
        document.getElementById('dataCriacaoQuizz').innerHTML = '<b>Data de criação:</b> '+dadosQuizz['DataCriacao'];
        document.getElementById('escolaridadeQuizz').innerHTML = '<b>Dificuldade:</b> '+dadosQuizz['dificuldade'];
        document.getElementById('numeroPerguntasQuizz').innerHTML = '<b>Número de Perguntas:</b> '+dadosQuizz['numPerguntas'];
        document.getElementById('numeroAvaliacoesFeitas').innerHTML = '<b>Número de avaliações:</b> '+dadosNumMediaAvaliacoes['mediaAvaliacoes'];
        document.getElementById('mediaAvaliacoesFeitas').innerHTML = '<b>Média de avaliações:</b> '+dadosNumMediaAvaliacoes['numAvaliacoes'];
  
    }

    function filtrarEMostrarDadosAvaliacoes(dadosAvaliacoes){
        const minhaAvaliacao= 0;

        for (let i= 0; i < dadosAvaliacoes.length; i++) {

            const iplus1=i+1;

            var container = document.getElementById("containerAvaliacoes");

            const divNomeUtilizadorAvaliacao = document.createElement("div");
            divNomeUtilizadorAvaliacao.id= "nomeUtilizadorAvaliacao"+iplus1;
            divNomeUtilizadorAvaliacao.innerHTML = dadosAvaliacoes[i]['nomeUnico'];
            divNomeUtilizadorAvaliacao.classList.add('nomeAvaliacao','container');                        
            container.appendChild(divNomeUtilizadorAvaliacao);

            const divOrganizarDadosQuestao = document.createElement("div");
            divOrganizarDadosQuestao.id= "organizarDadosQuestao"+iplus1;
            divOrganizarDadosQuestao.classList.add('organizarDadosQuestao','container');                        
            container.appendChild(divOrganizarDadosQuestao);

            var container = document.getElementById("organizarDadosQuestao"+iplus1);

            const divRowAvaliacoes = document.createElement("div");
            divRowAvaliacoes.id= "rowAvaliacoes"+iplus1;
            divRowAvaliacoes.style.border="3px outset black";                       
            divRowAvaliacoes.classList.add('row','h-100');
            container.appendChild(divRowAvaliacoes);

            var container = document.getElementById("rowAvaliacoes"+iplus1);

            const divMostrarTextoAvaliacao = document.createElement("div");
            divMostrarTextoAvaliacao.innerHTML = dadosAvaliacoes[i]['textoAvaliacao'];
            divMostrarTextoAvaliacao.classList.add('col-sm-7','mostrarTextoAvaliacao');                        
            container.appendChild(divMostrarTextoAvaliacao);
            
            const divDadosAvaliacao = document.createElement("div");
            divDadosAvaliacao.id= "dadosAvaliacao"+iplus1;
            divDadosAvaliacao.innerHTML = '<button type="text" class="btn button border posicaoBotaoAvaliacao">Reportar</button>';
            divDadosAvaliacao.classList.add('col-sm-5');                        
            container.appendChild(divDadosAvaliacao);

            var container = document.getElementById("dadosAvaliacao"+iplus1);

            const divPosicaoDadosAvaliacao = document.createElement("div");
            divPosicaoDadosAvaliacao.id= "posicaoDadosAvaliacao"+iplus1;
            divPosicaoDadosAvaliacao.innerHTML = 'Nota: '+dadosAvaliacoes[i]['nota']+' <span class="like"><i class="fa-solid fa-thumbs-up"></i> </span>'+dadosAvaliacoes[i]['gosto']+' <span class="Deslike"><i class="fa-solid fa-thumbs-down"></i> </span>'+dadosAvaliacoes[i]['naoGosto']+' ';
            divPosicaoDadosAvaliacao.classList.add('posicaoDadosAvaliacao');                        
            container.appendChild(divPosicaoDadosAvaliacao);
            
        }
    }
    
});

function verificarEdicaoQuizz(permissao){
    
        const Id_utilizador = localStorage.getItem("Id_utilizador");

        //Verificar se é a primeira questão
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
                if(resposta == 'existe'){
                    toastr.warning('Já existe um quizz a ser editado, por favor acabe de o editar ou elimine-o!', 'Woops!!!');
                }
                if(resposta == 'naoExiste'){
                    prepararQuizzParaEdicao(permissao);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
            }
        });

}

function prepararQuizzParaEdicao(permissao){
    const Id_quizz= localStorage.getItem("Id_quizzAJogar");

    if(permissao == "admin"){

        $.ajax({
            type:"POST",
            url: "../API/prepararEdicaoQuizzApi.php",
            data:{
                accao:"prepararQuizzAdmin",
                Id_quizz:Id_quizz
            },
            cache: false,
            dataType: 'json',
            success: function(resposta){
                    window.location.href= "editarDadosQuizz.php";
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
            }
        });

        localStorage.setItem("Id_utilizadorAEditarQuizzAdmin", localStorage.getItem("Id_criadorQuizz"));
        window.location.href="";
    }else{
        $.ajax({
            type:"POST",
            url: "../API/prepararEdicaoQuizzApi.php",
            data:{
                accao:"prepararQuizz",
                Id_quizz:Id_quizz
            },
            cache: false,
            dataType: 'json',
            success: function(resposta){
                    window.location.href= "editarDadosQuizz.php";
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
            }
        });
    }
    return false;
}

function iniciarJogoQuizz(){
    const Id_quizz= localStorage.getItem("Id_quizzAJogar");

    $.ajax({
        type:"POST",
        url: "../API/obterDadosJogoQuizzApi.php",
        data:{
            accao:"obterDados",
            Id_quizz:Id_quizz
        },
        cache: false,
        dataType: 'json',
        success: function(resposta){
            const pontosPorQuestao = 100/parseInt(resposta['numeroQuestoes']);

            localStorage.setItem("dadosQuestoesDoQuizz", JSON.stringify(resposta['dadosQuestoes']));
            localStorage.setItem("numeroQuestoes", resposta['numeroQuestoes']);
            localStorage.setItem("numeroQuestoesRespondidas", 0);
            localStorage.setItem("totalPontosAcumulados", 0);
            localStorage.setItem("pontosPorQuestao", pontosPorQuestao);

            window.location.href="jogarQuizz.php";
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
        }
    });
    return false;
}