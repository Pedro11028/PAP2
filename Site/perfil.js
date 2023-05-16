$(document).ready(function(){

      var Id_utilizador = getIdCookie();
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
              document.getElementById('nomeUnico').value = resposta['nomeUnico'];
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

      $("#alterarNome").click(function() {

        var verificarNome = /^[a-zA-Z]+ [a-zA-Z]+$/;
        var nomeCompleto = document.getElementById('nomeCompleto').value;
        if(!verificarNome.test(nomeCompleto)){
            alert('Por favor digite um nome válido (primeiro & último nome).');
            document.getElementById('nomeCompleto').focus();
        }else{
            $.ajax({
                type:"POST",
                url: "../API/alterarNomeApi.php",
                data:{
                    accao:"alterarNome",
                    Id_utilizador:Id_utilizador,
                    nomeCompleto:nomeCompleto
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                  if(resposta == 'true'){
                    location.reload();
                  }
                  if(resposta == 'erroBaseDados'){
                    alert('Woops! Parece estar a ocorrer um erro com a ligação á base de dados!');
                  }
                }
            });
        }
        return false;
      });

      $("#alterarNomeUnico").click(function() {

        var verificarNome = /^[A-Za-z0-9]*$/;
        var nomeUnico = document.getElementById('nomeUnico').value;
        if(!verificarNome.test(nomeUnico)){
            alert('Por favor digite um nome de utilizador válido (sem espaços & mais de 8 caracteres)');
            document.getElementById('nomeUnico').focus();
        }else{
            $.ajax({
                type:"POST",
                url: "../API/alterarNomeUnicoApi.php",
                data:{
                    accao:"alterarNomeUnico",
                    Id_utilizador:Id_utilizador,
                    nomeUnico:nomeUnico
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                  if(resposta == 'true'){
                    location.reload();
                  }
                  if(resposta == 'erroBaseDados'){
                    alert('Woops! Parece estar a ocorrer um erro com a ligação á base de dados!');
                  }
                  if(resposta == "nomeUnicoJaExiste"){
                    alert('Esse nome de utilizador já existe!');
                  }
                  console.log(resposta);
                }
            });
        }
        return false;
      });

      // Função para guardar a imagem no ficheiro do utilizador e guardar o caminho na base de dados
      $("#saveCheckedAvatar").click(function() {

        var Id_utilizador = getIdCookie();
        var imagemPerfil= '';

        for (let i = 1; i <= 6; i++) {
          if(document.getElementById('radio'+i).checked){
            imagemPerfil= document.getElementById('selectImage'+i).src
          }
        }
        if(imagemPerfil==''){
        }else{
            imagemPerfil.replace('data-','');
            $.ajax({
                type:"POST",
                url: "../API/guardarImgApi.php",
                data:{
                    accao:"guardarImg",
                    Id_utilizador:Id_utilizador,
                    imagemPerfil:imagemPerfil
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                  if(resposta == 'true'){
                    location.reload();
                  }
                  if(resposta == 'erroBaseDados'){
                    alert('Woops! Parece estar a ocorrer um erro com a ligação á base de dados!');
                  }
                }
            });
        }
        return false;

    });

      $(document).on('submit','#guardarImgForm',function(e){

           e.preventDefault();
           var Id_utilizador = getIdCookie();
           var formData = new FormData(this);
           formData.append('accao', "uploadImg");
           formData.append('Id_utilizador', Id_utilizador);

           $.ajax({
           method:"POST",
           url: "../API/uploadImgApi.php",
           data:formData,
           cache:false,
           contentType: false,
           processData: false,
           beforeSend:function(){
           },
           success: function(resposta){
            location.reload();
           }
          
           });
      });

      function getIdCookie() {
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
              document.getElementById('radio'+i).style.opacity = "0";
              document.getElementById('radio'+i).disabled = "true";
            }
          }
       }

});

//----------------------------------------------------------------------------------

//Funções referentes à visualização do form de atualização da imagem de perfil
function openForm() {
  document.getElementById("showForm").style.display = "block";
  document.getElementById("showBackground").style.display = "block";  
}

function displayClick() {
  document.getElementById("mostrarFicheiro").value= document.getElementById("escolherImagem").value;
  if(document.getElementById("escolherImagem").value== ""){
    document.getElementById("guardarImg").style.display= "none";
  }else{
    document.getElementById("guardarImg").style.display= "block";
  }
}

function closeForm() {
  document.getElementById("showForm").style.display = "none";
  document.getElementById("showBackground").style.display = "none";

  document.getElementById("guardarImg").style.display= "none";
  document.getElementById("mostrarFicheiro").value="";

  var radios = document.getElementsByName('groupOfimages');
  for (var i = 0; i < radios.length; i++) {
     radios[i].checked = false;
  }
}
