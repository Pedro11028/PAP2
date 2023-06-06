$(document).ready(function(){
    
    const Id_utilizador= localStorage.getItem("Id_utilizador");

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

});