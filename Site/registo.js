$(document).ready(function() {
    $("#submit").click(function() {
            console.log("scsudc");
            var primeiroNome= $('#primeiroNome').val();
            var sobrenome= $('#sobrenome').val();
            var nomeUnico= $('#nomeUnico').val();
            var email= $('#email').val();
            var password= $('#password').val();

            var nomeCompleto = primeiroNome + " " + sobrenome;

            $.ajax({
                    url: "../API/registoApi.php",
                    type:"POST",
                    method: "POST",
                    data:{
                        nomeCompleto:nomeCompleto,
                        nomeUnico:nomeUnico,
                        email:email,
                        password:password,
                        accao:'registo'
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(resposta) {
                        console.log("../API/registoApi.php resposta=",resposta);
                        if (resposta== 1) {
                            criarCookie(nomeUnico);
                            location.href="index.php";
                        }else{
                            alert("Email ou password incorretos!");
                        }
                    }
            });
     });
 });


 function criarCookie(nomeUnico) { 
    var hoje = new Date();
    var tempo = hoje.getTime()+ 1000*36000;
    hoje.setTime(tempo);

    document.cookie = "nomeCookie= "+nomeUnico+';expires='+hoje.toUTCString()+"; secure"+';path=/';

  }