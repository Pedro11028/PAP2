$(document).ready(function() {


    $("#submit").click(function() {

            var primeiroNome= $('#primeiroNome').val();
            var sobrenome= $('#sobrenome').val();
            var nomeUnico= $('#nomeUnico').val();
            var email= $('#email').val();
            var password= $('#password').val();

            var nomeCompleto = primeiroNome + " " + sobrenome;

            if((email=="" || email.indexOf('@') < 0 || email.indexOf('.') < 0) || !primeiroNome || !sobrenome || !nomeUnico || !password){
                toastr.warning('Por favor preencha todos os campos corretamente!', 'Woops!!!');
            }else{
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
                            if (resposta['confirmarExiste']== "true") {
                                criarCookie(resposta);
                                location.href="index.php";
                            }else{
                                alert("Email ou password incorretos!");
                            }
                            
                        }
                });
                return false;
            }
     });
 });


 function criarCookie(resposta) { 
    var hoje = new Date();
    var tempo = hoje.getTime();
    var expirarCookie = tempo + 3600000*24*15;       
    hoje.setTime(expirarCookie);
  
    document.cookie = "idCookie= "+resposta['Id_utilizador']+';expires='+hoje.toUTCString()+"; secure=true"+';path=/';
    document.cookie = "permissaoCookie= "+resposta['permissao']+';expires='+hoje.toUTCString()+"; secure"+';path=/';
    document.cookie = "nomeCookie= "+resposta['nomeUnico']+';expires='+hoje.toUTCString()+"; secure"+';path=/';
  }