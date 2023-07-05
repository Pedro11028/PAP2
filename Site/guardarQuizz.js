$(document).ready(function(){

    const Id_utilizador= localStorage.getItem("Id_utilizador");
    
    //localStorage que vai servir para guardar o caminho da imagem
    //O mesmo é declarado aqui para resetar quando a página recarrega
    localStorage.setItem("caminhoImagemQuizz", "");

    //Caso não retorne nada vai direto para o Login
    if(Id_utilizador == undefined){
        location.href= "login.html"
    }

    $.ajax({
        type:"POST",
        url: "../API/carregarDadosQuizzApi.php",
        data:{
            accao:"obterDadosQuizz",
            Id_utilizador:Id_utilizador
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            console.log(resposta);
            document.getElementById('nomeQuizz').value= resposta['nomeQuizz'];
            document.getElementById('TemaQuizz').value= resposta['tema'];
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
        }
    });

    $(document).on('click','#guardarDados',function(e){
        
        //Neste código escolariedade vai obter por exemplo o seguinte valor: Universidade &nbsp <span class="caret"></span>
        //Depois o mesmo será filtrado, sendo que escolariedade vai ficar com todo o conteúdo antes de &, exemplo: Universidade
        escolariedade= document.getElementById('dropEscolariedade').innerHTML;
        escolariedade= escolariedade.substr(0, escolariedade.lastIndexOf("&"));

        imagem = localStorage.getItem("caminhoImagemQuizz");

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
                    escolariedade:escolariedade,
                    imagem:imagem
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                    if(resposta == 'camposVazios'){
                        toastr.warning('Por favor preencha todos os campos!', 'Woops!!!');
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

    $(document).on('submit','#guardarImgForm',function(e){

        e.preventDefault();
        var Id_utilizador = localStorage.getItem("Id_utilizador");
        var formData = new FormData(this);
        formData.append('accao', "mostrarImg");
        formData.append('Id_utilizador', Id_utilizador);

        $.ajax({
            method:"POST",
            url: "../API/imagemQuizzApi.php",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            beforeSend:function(){
            },
            success: function(resposta){
                if(resposta != "imagemVazia"){
                    document.getElementById("mostrarFicheiro").src= resposta;
                    document.getElementById("guardarImg").style.display= "inline";
                }
            }
        });

        return false
   });


    $(document).on('click','#guardarImg',function(e){

        var Id_utilizador = localStorage.getItem("Id_utilizador");
        imagem= document.getElementById("mostrarFicheiro").src;

        $.ajax({
            type:"POST",
            url: "../API/imagemQuizzApi.php",
            data:{
                accao:"guardarImg",
                Id_utilizador:Id_utilizador,
                imagem:imagem
            },
            cache: false,
            success: function(resposta) {
                if(resposta == 'vazio'){
                    localStorage.setItem("caminhoImagemQuizz", "");
                    toastr.warning('Por favor preencha todos os campos!', 'Woops!!!');
                    closeForm();
                }else{
                    document.getElementById("abrirDivEscolherImagem").innerHTML= "Alterar Imagem"
                    localStorage.setItem("caminhoImagemQuizz", resposta);
                    closeForm();
                }
            }
        });
        return false;

    });

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

function openForm() {
    document.getElementById("showForm").style.display = "block";
    document.getElementById("showBackground").style.display = "block";  
    document.getElementById("mostrarFicheiro").src= localStorage.getItem("caminhoImagemQuizz");
  }
  
  
function closeForm() {
    document.getElementById("showForm").style.display = "none";
    document.getElementById("showBackground").style.display = "none";
    
    document.getElementById("mostrarFicheiro").src="";
    document.getElementById("escolherImagem").value="";
    document.getElementById("guardarImg").style.display= "none";

    var radios = document.getElementsByName('groupOfimages');
    for (var i = 0; i < radios.length; i++) {
        radios[i].checked = false;
}
}