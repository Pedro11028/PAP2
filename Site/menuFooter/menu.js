$(document).ready(function(){

    if (document.cookie.indexOf('nomeCookie') > -1 ) {
        document.getElementById('nomeUtilizador').innerHTML = getNomeCookie();
        document.getElementById("login").remove();
        document.getElementById("registar").remove();
        document.getElementById("menuCriarQuestao").style.display= "inline";

    }else{
        document.getElementById("dropdownUtilizador").remove();
        document.getElementById("menuCriarQuestao").style.display= "none";
    }

    // document.getElementById("menuEliminarQuizz").style.display= "none";
    // document.getElementById("menuGuardarInfoQuizz").style.display= "none";
    // document.getElementById("menuAdicionarQuestao").style.display= "none";
    
    function getNomeCookie() {
        let cookie = {};
        document.cookie.split(';').forEach(function(separar) {
            let [key,value] = separar.split('=');
            cookie[key.trim()] = value;
        })
        return cookie['nomeCookie'];
    }

    $(document).on('click','#pesquisar',function(e){
        if(document.getElementById("textoAPesquisar").value){
            localStorage.setItem('textoAPesquisar',document.getElementById("textoAPesquisar").value);
            localStorage.setItem('tipoPesquisa', 'TodosOsQuizzes');

            window.location.href="Pesquisas.php";
        }else{
            toastr.warning('Por favor não deixe espaços em branco!', 'Woops!!!');
        }

        return false;   
    });

});