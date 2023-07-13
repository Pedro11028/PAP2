$(document).ready(function(){

    const Id_quizz= localStorage.getItem("Id_quizzAJogar");
    const Id_utilizador= localStorage.getItem("Id_utilizador");
    localStorage.removeItem("notaAvaliacao");

        $.ajax({
            type:"POST",
            url: "../API/obterDadosJogoQuizzApi.php",
            data:{
                accao:"obterEGuardarDadosJogo",
                Id_quizz:Id_quizz,
                Id_utilizador:Id_utilizador
            },
            cache: false,
            dataType: 'json',
            success: function(resposta) {
                console.log(resposta);
                document.getElementById("nomeQuizz").innerText = resposta['nomeQuizz']['nomeQuizz'];
                document.getElementById("numeroQuestoesAcertadas").innerText = localStorage.getItem("numeroQuestoesAcertadas")+" / "+localStorage.getItem("numeroQuestoes");
                if(resposta['dadosAvaliacao'] != false){
                    document.getElementById("textoAvaliacao").value = resposta['dadosAvaliacao']['textoAvaliacao'];
                    escolherNota(resposta['dadosAvaliacao']['nota']);
                }
            }
        });

    switch (localStorage.getItem("totalPontosAcumulados")) {
        case '99':
            document.getElementById("resultadoProgresso").innerHTML = "100%";
        
            $(".progress-bar").animate({
                width: "100%",
            },3000);
        break;
        
        case '0':
            document.getElementById("resultadoProgresso").innerHTML = "0%";
        
            $(".progress-bar").animate({
                width: "5%",
            },500);
        break;
        
        default:
            document.getElementById("resultadoProgresso").innerHTML = localStorage.getItem("totalPontosAcumulados")+"%";
            $(".progress-bar").animate({
                width: localStorage.getItem("totalPontosAcumulados")+"%",
            },1500);
        break;
    }

    $(document).on('click','#guardarAvaliacao',function(e){
        
        const textoAvaliacao = document.getElementById("textoAvaliacao").value;
        const notaAvaliacao = localStorage.getItem("notaAvaliacao");
        $.ajax({
            type:"POST",
            url: "../API/guardarDadosAvaliacoesApi.php",
            data:{
                accao:"guardarDados",
                Id_utilizador:Id_utilizador,
                Id_quizz:Id_quizz,
                textoAvaliacao:textoAvaliacao,
                notaAvaliacao:notaAvaliacao
            },
            cache: false,
            dataType: 'json',
            success: function(resposta) {
                switch (resposta) {
                    case "textoVazio":
                        toastr.warning('Por favor escreva algo para poder avaliar o Quizz!', 'Atenção!!!');
                    break;
                    
                    case "notaVazia":
                        toastr.warning('Por favor selecione uma nota para poder avaliar o Quizz!', 'Atenção!!!');
                    break;

                    case "dadosGuardadosComSucesso":
                        window.location.href= "informacoesQuizz.php";
                    break;

                    default:
                    break;
                }
            }
        });

    });

});

function jogarNovamente(){
    localStorage.removeItem("numeroQuestoesRespondidas");
    localStorage.removeItem("numeroQuestoesAcertadas");
    localStorage.removeItem("totalPontosAcumulados");

    window.location.href= 'informacoesQuizz.php';
}

function sairDoQuizz(){
    localStorage.removeItem("dadosQuestoesDoQuizz");
    localStorage.removeItem("numeroQuestoes");
    localStorage.removeItem("Id_criadorQuizz");
    localStorage.removeItem("numeroQuestoesRespondidas");
    localStorage.removeItem("numeroQuestoesAcertadas");
    localStorage.removeItem("totalPontosAcumulados");
    localStorage.removeItem("pontosPorQuestao");

    window.location.href= 'index.php';
    
}

function escolherNota(nota){
    console.log(nota);

    for (let i = 1; i <= 5; i++) {
        if(i == nota){
            document.getElementById("notaAvaliacao"+i).style.background = "#0779e4";
            document.getElementById("notaAvaliacao"+i).style.color = "white";
            document.getElementById("notaAvaliacao"+i).style.cursor = "default";

        }else{
            document.getElementById("notaAvaliacao"+i).style.background = "white";
            document.getElementById("notaAvaliacao"+i).style.color = "#0779e4";
            document.getElementById("notaAvaliacao"+i).style.cursor = "pointer";

        }
    }

    localStorage.setItem("notaAvaliacao", nota);
    return false;
}