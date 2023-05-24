
    if (document.cookie.indexOf('nomeCookie') > -1 ) {
        document.getElementById('nomeUtilizador').innerHTML = getCookie();
        document.getElementById("login").remove();
        document.getElementById("register").remove();
    }else{
        document.getElementById("dropUtilizador").remove();
    }
    
    document.getElementById("menuGuardarInfoQuizz").style.display= "none";
    document.getElementById("menuAdicionarQuestao").style.display= "none";
    
    function getCookie() {
        let cookie = {};
        document.cookie.split(';').forEach(function(separar) {
            let [key,value] = separar.split('=');
            cookie[key.trim()] = value;
        })
        return cookie['nomeCookie'];
    }