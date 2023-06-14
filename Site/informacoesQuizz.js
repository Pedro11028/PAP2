$(document).ready(function(){
    
    const Id_utilizador= localStorage.getItem("Id_utilizador");
    const Id_quizz= localStorage.getItem("Id_quizzAJogar");

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
        success: function(resposta) {
            console.log(resposta);
        }
    });

});