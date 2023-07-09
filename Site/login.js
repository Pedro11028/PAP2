 $(document).ready(function() {
  $("#submit").click(function() {

      var email= $('#email').val();
      var password= $('#password').val();
      
      if (email=="" || email.indexOf('@') < 0 || email.indexOf('.') < 0) {
        toastr.warning('Por favor digite os dados corretamente!', 'Woops!!!');
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
            if (resposta[0]== "false") {
              toastr.warning('Email ou password incorretos!', 'Woops!!!');
            }else{
                criarCookie(resposta);
                criarlocalStorage(resposta);
                location.href="index.php";
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
              toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
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

  document.cookie = "sessaoCookie= true"+';expires='+hoje.toUTCString()+"; secure=true"+';path=/';
  document.cookie = "nomeCookie= "+resposta['nomeUnico']+';expires='+hoje.toUTCString()+"; secure"+';path=/';
}

function criarlocalStorage(resposta) { 
  localStorage.setItem("Id_utilizador", resposta['Id_utilizador']);
  localStorage.setItem("permissaoUtilizador", resposta['permissao']);
}

$('#showhide1').click(function() {
  $(this).toggleClass('fa-solid fa-eye hide');
  $(this).toggleClass('fa-solid fa-eye-slash show');
});

const togglePassword1 = document.querySelector('#showhide1');
const password1 = document.querySelector('.password1');

togglePassword1.addEventListener('click', () => {
    // altera o tipo da classe ao usar o método getAttribure() 
    const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
    password1.setAttribute('type', type);
});