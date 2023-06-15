$(document).ready(function() {
    $("#submit").click(function() {

        var Id_utilizador = localStorage.getItem("Id_utilizador");

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
                if (resposta == "passwordsVazias") {
                    toastr.warning('Passwords não devem estar vazias.', 'Woops!!!');
                }
                if (resposta == "PassworAtualErrada") {
                    toastr.warning('Password atual incorreta.', 'Woops!!!');
                }
                if (resposta == "PasswordConfirmarDiferente") {
                    toastr.warning('Password nova não confirmada corretamente.', 'Woops!!!');
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
  });
  