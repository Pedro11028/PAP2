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
                    toastr.warning('Password atual incorreta.', 'Woops!!!');
                }
                if (resposta == "PasswordConfirmarDiferente") {
                    toastr.warning('Passwords não correspondem.', 'Woops!!!');
                }
                if (resposta == "PasswordIgualAnterior") {
                    toastr.warning('Password nova igual á anterior.', 'Woops!!!');
                }
                if (resposta == "erroSemResposta") {
                    toastr.warning('Parece estar a ocorrer um erro com a ligação á base de dados.', 'Woops!!!');
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
  