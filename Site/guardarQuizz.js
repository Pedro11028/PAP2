$(document).ready(function(){

    const Id_utilizador= getIdCookie();

    //Caso não retorne nada vai direto para o Login
    if(Id_utilizador == undefined){
        location.href= "login.html"
    }

    $(document).on('click','#guardarDados',function(e){
        
        //Neste código escolariedade vai obter por exemplo o seguinte valor: Universidade &nbsp <span class="caret"></span>
        //Depois o mesmo será filtrado, sendo que escolariedade vai ficar com todo o conteúdo antes de &, exemplo: Universidade
        escolariedade= document.getElementById('dropEscolariedade').innerHTML;
        escolariedade= escolariedade.substr(0, escolariedade.lastIndexOf("&"));

        var nomeQuizz= $('#nomeQuizz').val();
        var TemaQuizz= $('#TemaQuizz').val();
        
            $.ajax({
                type:"POST",
                url: "../API/guardarQuizzApi.php",
                data:{
                    accao:"guardar",
                    Id_utilizador:Id_utilizador,
                    nomeQuizz:nomeQuizz,
                    TemaQuizz:TemaQuizz,
                    escolariedade:escolariedade
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                    if(resposta == 'camposVazios'){
                        toastr.warning('Por favor preencha todos os capmpos!', 'Woops!!!');
                    }
                    if(resposta == 'escolariedadeVazia'){
                        toastr.warning('Por favor selecione a escolariedade sugerida para fazer o quizz!', 'Woops!!!');
                    }
                    if(resposta == 'dadosGuardadosComSucesso'){
                        eliminarCookiesCriacaoQuizz();
                        location.href="index.php";
                    }
                }
            });
            return false;
    });

    function getIdCookie() {
        let cookie = {};
        document.cookie.split(';').forEach(function(separar) {
            let [key,value] = separar.split('=');
            cookie[key.trim()] = value;
        })
        return cookie['idCookie'];
    }

    function eliminarCookiesCriacaoQuizz(){
        var hoje = new Date();
        hoje.setMonth( hoje.getMonth() - 1 );
        
        document.cookie = "idQuestaoAEditar= "+document.cookie.indexOf('idQuestaoAEditar')
                         +';expires='+hoje.toUTCString()
                         +"; secure=true"
                         +';path=/';
      
        document.cookie = "tipoQuestaoCookie= "+document.cookie.indexOf('tipoQuestaoCookie')
                         +';expires='+hoje.toUTCString()
                         +"; secure"
                         +';path=/';
      
    }
});

function alterarEscolariedade(escolariedade){
    document.getElementById('dropEscolariedade').innerHTML= escolariedade+'&nbsp <span class="caret"></span>';
}