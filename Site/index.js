$(document).ready(function(){

    $.ajax({
        type:"POST",
        url: "../API/obterQuizzesApi.php",
        data:{
            accao:"carregar"
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            console.log(resposta);
             criarCardsQuizzesMelhoresAvaliados(resposta['QuizzesOrdenadosPorMediaAvaliacoes'], "rowMelhoresAvaliados", "melhorMedia");
             criarCardsQuizzesMelhoresAvaliados(resposta['QuizzesOrdenadosPorNumeroAvaliacoes'], "rowMaisRespondidos", "maisRespondidos");
             criarCardsQuizzesMelhoresAvaliados(resposta['QuizzesOrdenadosPorDataCriacao'], "rowMaisRecentes", "maisRecentes");
        }
    });

     function criarCardsQuizzesMelhoresAvaliados(dadosQuizzes, row, tipoDeOrganizacao) {

         for (let i= 0; i < dadosQuizzes.length; i++) {
             const iplus1=i+1;
             if(dadosQuizzes[i]["imagem"] != ""){
                imagem = dadosQuizzes[i]["imagem"];
             }else{
                imagem= "img/escolariedade/default.png"
             }

             var container = document.getElementById(row);

             const divOrganizarNomeQuestao = document.createElement("div");
             divOrganizarNomeQuestao.id= tipoDeOrganizacao+"organizarContainerQuizz"+iplus1;
             divOrganizarNomeQuestao.classList.add('col-md-auto');                        
             container.appendChild(divOrganizarNomeQuestao);

             var container = document.getElementById(tipoDeOrganizacao+"organizarContainerQuizz"+iplus1);

             const divContainerInformacoesQuizz = document.createElement("div");
             divContainerInformacoesQuizz.id=tipoDeOrganizacao+"containerInformacoesQuizz"+iplus1;
             divContainerInformacoesQuizz.innerHTML = '<div id="'+tipoDeOrganizacao+'informacoesQuizz'+iplus1+'" class="informacoesQuizz" title="Abrir Quizz" onclick="abrirQuizz('+dadosQuizzes[i]["Id_quizz"]+')"></div>';
             divContainerInformacoesQuizz.classList.add('containerInformacoesQuizz');                        
             container.appendChild(divContainerInformacoesQuizz);

             var container = document.getElementById(tipoDeOrganizacao+"informacoesQuizz"+iplus1);
             
            //  link da imagem de origem: https://pt.vecteezy.com/arte-vetorial/5044651-hello-calligraphy-lettering-with-colorful-confetti-hand-drawn-typography-poster-word-hello-write-with-brush-vector-template-for-greeting-cards-welcome-banners-panfletos-sinais-etc
             const divGuardarImagem = document.createElement("div");
             divGuardarImagem.id=tipoDeOrganizacao+"guardarImagem"+iplus1;
             divGuardarImagem.innerHTML = '<img src="'+imagem+'">';
             divGuardarImagem.classList.add('imagem');                        
             container.appendChild(divGuardarImagem);

             const divDadosQuizz = document.createElement("div");
             divDadosQuizz.id=tipoDeOrganizacao+"dadosQuizz"+iplus1;
             divDadosQuizz.innerHTML = ' <p class="nomeQuizz">'+dadosQuizzes[i]["nomeQuizz"]+'</p>'
                                     + ' <p>Dificuldade: '+dadosQuizzes[i]["dificuldade"]+'</p>'
                                     + ' <p>Quantidade de avaliações: '+dadosQuizzes[i]["numAvaliacoes"]+'</p>'
                                     + ' <p>Nota média: '+dadosQuizzes[i]["mediaAvaliacoes"]+'</p>';
             divDadosQuizz.classList.add('dadosQuizz');                        
             container.appendChild(divDadosQuizz);
             
         }
     }

});

function abrirQuizz(Id_quizz){

    localStorage.setItem("Id_quizzAJogar", Id_quizz);

    location.href= "informacoesQuizz.php";
}