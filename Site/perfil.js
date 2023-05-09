$(document).ready(function(){

      var Id_utilizador = getCookie(document.cookie.indexOf('idCookie'));
  

      $.ajax({
          type:"POST",
          url: "../API/perfilApi.php",
          data:{
              accao:"carregar",
              Id_utilizador:Id_utilizador
          },
          cache: false,
          dataType: 'json',
          success: function(resposta) {
            if(resposta[0]== false){
              alert("Woops! parece estar a acontecer um erro de conexão com a base de dados!")
            }else{
              document.getElementById('nomeCompleto').value = resposta['nomeCompleto'];
              document.getElementById('email').value = resposta['email'];
              document.getElementById('imgPerfil').src = resposta['imagemPerfil'];
              document.getElementById('quizzesCriados').innerHTML = resposta['numQuizzesCriados'];
              document.getElementById('quizzesRealizados').innerHTML = resposta['numQuizzesFeitos'];
              document.getElementById('avaliacoesFeitas').innerHTML = resposta['numAvaliacoes'];
            }
          }
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

function openForm() {
  document.getElementById("showForm").style.display = "block";
  document.getElementById("showBackground").style.display = "block";
}

function closeForm() {
  document.getElementById("showForm").style.display = "none";
  document.getElementById("showBackground").style.display = "none";

  var radios = document.getElementsByName('groupOfimages');
  for (var i = 0; i < radios.length; i++) {
     radios[i].checked = false;
  }

}
