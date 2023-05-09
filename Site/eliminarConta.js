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
                    document.getElementById('password').value = "";
                    document.getElementById('confirmarPass').value = "";
                }
                if (resposta == "passwordNaoExiste") {
                    alert("Password incorreta.");
                    document.getElementById('password').value = "";
                    document.getElementById('confirmarPass').value = "";
                }
                if (resposta == "erroSemResposta") {
                    alert("Woops! parece estar a ocorrer um erro com a ligação á base de dados");
                    document.getElementById('password').value = "";
                    document.getElementById('confirmarPass').value = "";
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