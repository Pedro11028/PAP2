$(document).ready(function() {
    $("#submit").click(function() {

        var Id_utilizador = getCookie(document.cookie.indexOf('idCookie'));

        var passwordAtual= $('#passwordAtual').val();
        var passwordNova= $('#passwordNova').val();
        var confirmarPass= $('#confirmarPass').val();
        

            $.ajax({
                type:"POST",
                url: "../API/alterarPasswordApi.php",
                data:{
                    accao:"Alterar",
                    Id_utilizador:Id_utilizador,
                    passwordAtual:passwordAtual,
                    passwordNova:passwordNova,
                    confirmarPass:confirmarPass
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                if (resposta == "PassworAtualErrada") {
                    alert("Password atual incorreta.");
                }
                if (resposta == "PasswordConfirmarDiferente") {
                    alert("Passwords não correspondem.");
                }
                if (resposta == "PasswordIgualAnterior") {
                    alert("Password nova igual á anterior.");
                }
                if (resposta == "erroSemResposta") {
                    alert("Woops! parece estar a ocorrer um erro com a ligação á base de dados");
                }

                if (resposta == "true") {
                    location.href="Perfil.php";
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
  