$(document).ready(function(){

    document.getElementById("menuBarraPesquisa").remove();
    document.getElementById("dropdownUtilizador").remove();
    document.getElementById("mostrarConteudosMenu").remove();

    document.getElementById("linkCriarQuestao").remove();
    
    localStorage.removeItem('Id_utilizadorAVerificarPeloAdmin');
    localStorage.removeItem('passwordUtilizador');
    var nomeUnicoAPesquisar = "";

    $.ajax({
        type:"POST",
        url: "../API/obterDadosUtilizadoresApi.php",
        data:{
            accao:"obterUtilizadores",
            nomeUnicoAPesquisar:nomeUnicoAPesquisar
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            criarLinhasUtilizadores(resposta);
        }
    });

    const tipoTemporario= "temporarioAdmin";

    $.ajax({
        type:"POST",
        url: "../API/verificarJaCriouQuizzTempApi.php",
        data:{
            accao:"verificarExistenciaQuizzAdmin",
            tipoTemporario:tipoTemporario
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            if(resposta == 'existe'){
                document.getElementById("linkPermissao").href= "editarDadosQuizzAdmin.php";
                document.getElementById("linkPermissao").innerHTML= "Continuar a editar Quizz como Admin";
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
        }
    });

    $(document).on('click','#pesquisarUtilizador',function(e){
        nomeUnicoAPesquisar = document.getElementById("utilizadorAPesquisar").value;

        $.ajax({
            type:"POST",
            url: "../API/obterDadosUtilizadoresApi.php",
            data:{
                accao:"obterUtilizadores",
                nomeUnicoAPesquisar:nomeUnicoAPesquisar
            },
            cache: false,
            dataType: 'json',
            success: function(resposta) {
                eliminarLinhasUtilizadores();
                criarLinhasUtilizadores(resposta);
            }
        });

    });

});

function criarLinhasUtilizadores(dadosUtilizadores){
    const minhaAvaliacao= 0;
    localStorage.setItem('numeroTotalDeUtilizadores', dadosUtilizadores.length);

    for (let i= 0; i < dadosUtilizadores.length; i++) {

        const iplus1=i+1;

        var container = document.getElementById("tabela");

        const tr = document.createElement("tr");
        tr.id= "tr"+i;
        container.appendChild(tr);

        var container = document.getElementById("tr"+i);

        const thId_utilizador = document.createElement("th");
        thId_utilizador.scope="row";                 
        thId_utilizador.innerHTML = dadosUtilizadores[i]['Id_utilizador'];
        container.appendChild(thId_utilizador);

        const trNomeUnico = document.createElement("td");
        trNomeUnico.innerHTML = dadosUtilizadores[i]['nomeUnico'];
        container.appendChild(trNomeUnico);

        const trEmail = document.createElement("td");
        trEmail.innerHTML = dadosUtilizadores[i]['email'];
        container.appendChild(trEmail);

        const trbotao = document.createElement("td");
        trbotao.innerHTML = '<button class="btn button border" onclick="editarUtilizador('+dadosUtilizadores[i]['Id_utilizador']+')"><b>Editar</b></button>';
        container.appendChild(trbotao);
        
    }
}

function eliminarLinhasUtilizadores(){
    
    for (let i= 0; i < localStorage.getItem('numeroTotalDeUtilizadores'); i++) {
        document.getElementById("tr"+i).remove();
    }
}

function editarUtilizador(Id_utilizador){
    localStorage.setItem('Id_utilizadorAVerificarPeloAdmin', Id_utilizador);
    window.location.href="dadosUtilizadorPainelAdmin.php";
}