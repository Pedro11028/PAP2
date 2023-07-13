$(document).ready(function() {
    $("#submit").click(function() {

        const Id_utilizador = localStorage.getItem("Id_utilizador");
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
                    toastr.warning('Passwords não correspondem.', 'Woops!!!');
                    document.getElementById('password').value = "";
                    document.getElementById('confirmarPass').value = "";
                }
                if (resposta == "passwordNaoExiste") {
                    toastr.warning('Password incorreta!', 'Woops!!!');
                    document.getElementById('password').value = "";
                    document.getElementById('confirmarPass').value = "";
                }
                if (resposta == "erroSemResposta") {
                    toastr.warning('Parece estar a ocorrer um erro com a ligação á base de dados.', 'Woops!!!');
                    document.getElementById('password').value = "";
                    document.getElementById('confirmarPass').value = "";
                }
                if (resposta == "dadosEliminadosComSucesso") {
                    window.location.href="sair.html";
                }

                }
            });

            return false;
    });
    
  });

    // $('#showhide1').click(function() {
    //     $(this).toggleClass('fa-solid fa-eye hide');
    //     $(this).toggleClass('fa-solid fa-eye-slash show');
    // });
    
    // $('#showhide2').click(function() {
    //     $(this).toggleClass('fa-solid fa-eye hide');
    //     $(this).toggleClass('fa-solid fa-eye-slash show');
    // });

    // const togglePassword1 = document.querySelector('#showhide1');
    // const password1 = document.querySelector('.password1');

    // togglePassword1.addEventListener('click', () => {
    //     // altera o typo da classe ao usar o método getAttribure() 
    //     const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
    //     password1.setAttribute('type', type);
    // });

    // const togglePassword2 = document.querySelector('#showhide2');
    // const password2 = document.querySelector('.password2');

    // togglePassword2.addEventListener('click', () => {
    //     // altera o typo da classe ao usar o método getAttribure() 
    //     const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
    //     password2.setAttribute('type', type);
    // });