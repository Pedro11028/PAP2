 $(document).ready(function() {
  $("#submit").click(function() {

      var email= $('#email').val();
      var password= $('#password').val();
      
      if (email=="" || email.indexOf('@') < 0 || email.indexOf('.') < 0) {

      }else{

      $.ajax({
          type:"POST",
          url: "../API/loginApi.php",
          data:{
              accao:"login",
              email:email,
              password:password
          },
          cache: false,
          dataType: 'json',
          success: function(resposta) {
            if (resposta== false) {
              alert("Email ou password incorretos!");
            }else{
                criarCookie(resposta);
                window.location.href="index.php";
            }
          }
      });
      }
  });
});

function criarCookie(resposta) { 
  var hoje = new Date();
  var tempo = hoje.getTime();
  var expirarCookie = tempo + 1000*36000;       
  hoje.setTime(expirarCookie);

  document.cookie = "idCookie= "+resposta['Id_utilizador']+';expires='+hoje.toUTCString()+"; secure=true"+';path=/';
  document.cookie = "permissaoCookie= "+resposta['permissao']+';expires='+hoje.toUTCString()+"; secure"+';path=/';
  document.cookie = "nomeCookie= "+resposta['nomeUnico']+';expires='+hoje.toUTCString()+"; secure"+';path=/';
}