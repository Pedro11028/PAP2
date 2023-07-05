$(document).ready(function(){

    if(document.getElementById("menuCriarQuestao").style.display == "inline"){
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
                    document.getElementById("linkCriarQuestao").innerHTML = "Continuar edição do quizz";
                    document.getElementById('linkCriarQuestao').href = "editarDadosQuizz.php";
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
            }
        });
    }
    
});