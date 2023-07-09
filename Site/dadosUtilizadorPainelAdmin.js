$(document).ready(function(){

    document.getElementById("menuBarraPesquisa").remove();
    document.getElementById("dropdownUtilizador").remove();
    document.getElementById("menuCriarQuestao").remove();
    document.getElementById("mostrarConteudosMenu").remove();
    document.getElementById("navbarColor02").className = '';
    

    document.getElementById("menuGuardarQuestao").style.display="inline";
    document.getElementById("menuCancelarQuestao").style.display="inline";
    
    document.getElementById("logotipoSite").innerHTML="";
    document.getElementById("eliminarResposta1").style.display = "none";

    document.getElementById('menuCancelarQuestao').innerHTML = "<i class='fa-solid fa-outdent'></i> Cancelar";
   
    localStorage.removeItem('Id_utilizadorAVerificarPeloAdmin');

    $.ajax({
        type:"POST",
        url: "../API/obterDadosUtilizadoresApi.php",
        data:{
            accao:"obterDadosUtilizador"
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            criarLinhasUtilizadores(resposta);
        }
    });

});

function criarLinhasUtilizadores(dadosUtilizadores){
    const minhaAvaliacao= 0;

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

function editarUtilizador(Id_utilizador){
    localStorage.setItem('Id_utilizadorAVerificarPeloAdmin', Id_utilizador);
    window.location.href="dadosUtilizadorPainelAdmin.php";
}