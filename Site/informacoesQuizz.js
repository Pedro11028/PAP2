$(document).ready(function(){
    
    const Id_utilizador= localStorage.getItem("Id_utilizador");
<<<<<<< HEAD
    const Id_quizz= localStorage.getItem("Id_quizzAJogar");
=======
>>>>>>> 1bc400c5250891d2f526cb902a39df8ecd2aec98

    $.ajax({
        type:"POST",
        url: "../API/obterQuizzesApi.php",
        data:{
<<<<<<< HEAD
            accao:"obterDadosQuizzEAvaliacoes",
            Id_utilizador:Id_utilizador,
            Id_quizz:Id_quizz
=======
            accao:"carregar"
>>>>>>> 1bc400c5250891d2f526cb902a39df8ecd2aec98
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            console.log(resposta);
<<<<<<< HEAD
             
=======
             criarCardsQuizzesMelhoresAvaliados(resposta['QuizzesOrdenadosPorMediaAvaliacoes'], "rowMelhoresAvaliados", "melhorMedia");
             criarCardsQuizzesMelhoresAvaliados(resposta['QuizzesOrdenadosPorNumeroAvaliacoes'], "rowMaisRespondidos", "maisRespondidos");
             criarCardsQuizzesMelhoresAvaliados(resposta['QuizzesOrdenadosPorDataCriacao'], "rowMaisRecentes", "maisRecentes");
>>>>>>> 1bc400c5250891d2f526cb902a39df8ecd2aec98
        }
    });

});