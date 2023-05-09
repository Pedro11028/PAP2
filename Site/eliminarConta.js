$(document).ready(function() {
    $("#submit").click(function() {

        var Id_utilizador = getCookie(document.cookie.indexOf('idCookie'));
        var password= $('#password').val();
        var confirmarPass= $('#confirmarPass').val();
        

            $.ajax({
                type:"POST",
                url: "../API/eliminarContaApi.php",
                data:{
                    accao:"eliminar",
                    Id_utilizador:Id_utilizador,
                    password:password,
                    confirmarPass:confirmarPass
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                if (resposta == "passwordsNaoCorrespondem") {
                    alert("Passwords não correspondem.");
                }
                if (resposta == "passwordNaoExiste") {
                    alert("Password errada.");
                }
                if (resposta == "erroSemResposta") {
                    alert("Woops! parece estar a ocorrer um erro com a ligação á base de dados");
                }

                if (resposta == "true") {
                    location.href="Logout.html";
                }

                }
            });

            return false;
    });
    


    function getCookie(idCookie) {
        let cookie = {};
        document.cookie.split(';').forEach(function(separar) {
            let [key,value] = separar.split('=');
            cookie[key.trim()] = value;
        })
        return cookie['idCookie'];
    }
  });
  