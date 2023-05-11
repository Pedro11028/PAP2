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
              document.getElementById('changeImgPerfil').src = resposta['imagemPerfil'];
              document.getElementById('quizzesCriados').innerHTML = resposta['numQuizzesCriados'];
              document.getElementById('quizzesRealizados').innerHTML = resposta['numQuizzesFeitos'];
              document.getElementById('avaliacoesFeitas').innerHTML = resposta['numAvaliacoes'];

              obterNivel(resposta['pontuacao']);
              desbloquearImagens(resposta['pontuacao']);
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

      function obterNivel(pontuacao) {
        pontuacao=parseInt(pontuacao);
        nivel=[ 
                0,
                100,  
                200, 
                300, 
                400, 
                500, 
                600, 
                700
              ];

              
        // Aqui as comparações são feitas com if pois o Java Script não consegue fazer switch cases para comparar se o número é maior ou menor https://stackoverflow.com/questions/6665997/switch-statement-for-greater-than-less-than
        
        if(pontuacao<nivel[1]){
          if(pontuacao<10){
            document.getElementById('pontuacao').innerHTML = "00"+pontuacao+" / 700";
          }else{
            document.getElementById('pontuacao').innerHTML = "0"+pontuacao+" / 700";
          }
          document.getElementById('nivel').src = 'img/0.png';
        }

        for (let i = 1; i <= 6; i++) {
          if(pontuacao>=nivel[i] && pontuacao<nivel[i+1]){
            document.getElementById('pontuacao').innerHTML = pontuacao+" / 700";
            document.getElementById('nivel').src = 'img/'+i+'.png';
          }
        }

        if(pontuacao>=nivel[7]){
          document.getElementById('pontuacao').innerHTML = pontuacao+" / 700";
          document.getElementById('nivel').src = 'img/7.png';
        }
      }


      function desbloquearImagens(pontuacao) {
        pontuacao=parseInt(pontuacao);

          // Verificar nível do utilizador para desbloquear avatares disponíveis
          for (let i = 1; i <= 6; i++) {
            if((pontuacao/100)>=i){
              document.getElementById('selectImage'+i).src = "img/avatar"+i+".gif";
            }else{
              document.getElementById('selectImage'+i).src = "img/cadeado.png";
            }
          }
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
