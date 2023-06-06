$(document).ready(function(){

    const Id_utilizador = localStorage.getItem("Id_utilizador");
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
                document.getElementById('botaoVoltarCancelar').innerHTML = "Voltar";
                document.getElementById('linkVoltarCancelar').href = "editarDadosQuizz.php";
            }
            if(resposta == 'naoExiste'){
                document.getElementById('botaoVoltarCancelar').innerHTML = "Cancelar";
                document.getElementById('linkVoltarCancelar').href = "index.php";
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
        }
    });
});

function criarCookie(valorCookie) {
    var hoje = new Date();
    var tempo = hoje.getTime();
    var expirarCookie = tempo + 9000*1000; // 9000*1000= duas horas e meia
    hoje.setTime(expirarCookie);
  
    document.cookie = "escolherTipoQuestao= "+valorCookie+';expires='+hoje.toUTCString()+"; secure=true"+';path=/';
}

if (document.cookie.indexOf('escolherTipoQuestao') > -1 ) {
    location.href="InserirDadosQuizz.php";
}