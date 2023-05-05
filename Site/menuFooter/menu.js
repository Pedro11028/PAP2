
    if (document.cookie.indexOf('nomeCookie') > -1 ) {
        document.getElementById('nomeUtilizador').innerHTML = getCookie(document.cookie.indexOf('nomeCookie'));
        document.getElementById("login").remove();
        document.getElementById("register").remove();
    }else{
        document.getElementById("dropUtilizador").remove();
    }

    function getCookie(nomeCookie) {
        let cookie = {};
        document.cookie.split(';').forEach(function(separar) {
            let [key,value] = separar.split('=');
            cookie[key.trim()] = value;
        })
        return cookie['nomeCookie'];
    }