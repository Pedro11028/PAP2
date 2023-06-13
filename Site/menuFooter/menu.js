
    if (document.cookie.indexOf('nomeCookie') > -1 ) {
        document.getElementById('nomeUtilizador').innerHTML = getCookie();
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
    
    function getCookie() {
        let cookie = {};
        document.cookie.split(';').forEach(function(separar) {
            let [key,value] = separar.split('=');
            cookie[key.trim()] = value;
        })
        return cookie['nomeCookie'];
    }