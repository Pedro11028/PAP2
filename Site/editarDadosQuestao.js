$(document).ready(function(){
    
    document.getElementById('linkInicio').innerHTML = "Cancelar";
    document.getElementById('linkInicio').href = "CancelarInserirDados.php";

    document.getElementById("menuBarraPesquisa").remove();
    document.getElementById("menuSearch").remove();
    document.getElementById("menuCriarQuizz").remove();
    document.getElementById("dropUtilizador").remove();

    document.getElementById('botaoGuardar').innerHTML= "Guardar";
    document.getElementById("menuGuardarInfoQuizz").style.display="inline";
    document.getElementById("menuGuardarInfoQuizz").style.float= "right";
    document.getElementById("menuGuardarInfoQuizz").style.left= "0px";

    
    // obter o Tipo de questão e com isso determinar o formato da página
    const Id_questao = getIdquestaoCookie();
    var Id_utilizador = getIdCookie();

    function getIdquestaoCookie() {
        let cookie = {};
        document.cookie.split(';').forEach(function(separar) {
           let [key,value] = separar.split('=');
           cookie[key.trim()] = value;
        })
        return cookie['idQuestaoAEditar'];
    }


    //Obter dados da questao a ser editada
    $.ajax({
        type:"POST",
        url: "../API/obterDadosQuestaoApi.php",
        data:{
            accao:"obterDados",
            Id_questao:Id_questao,
            Id_utilizador:Id_utilizador
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            console.log(resposta);
            carregarImagemQuizz(resposta['imagemQuestao']);
            descobrirTipoquestao(resposta);
        }
    });

    function descobrirTipoquestao(dadosQuestao){
        if(dadosQuestao['dadosQuestao']['tipoQuestao'] == 'escreverResposta'){
            document.getElementById("selecionarResposta").remove();

            inserirDadosDoTipoSelecionarResposta_e_Enquete(dadosQuestao);
        }else{
            if(dadosQuestao['dadosQuestao']['tipoQuestao']  == null){
                location.href="escolherTipoQuestao.html";
            }else{
                document.getElementById("escreverResposta").remove();
            }
        }
    }


    //Guardar a imagem num diretório temporariamente
    var Id_utilizador = getIdCookie();
    $(document).on('submit','#MostrarImgPergunta',function(e){

        e.preventDefault();
        var formData = new FormData(this);
        formData.append('accao', "MostrarImgPergunta");
        formData.append('Id_utilizador', Id_utilizador);

        $.ajax({
            method:"POST",
            url: "../API/MostrarImgPerguntaApi.php",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            beforeSend:function(){
            },
            success: function(resposta){
                //Chamar função para mostrar o aspeto da imagem ao mandar o caminho da mesma
                carregarImagemQuizz(resposta);
            }
        });

        return false;
    });

    // Obter valor do id
    function getIdCookie() {
        let cookie = {};
        document.cookie.split(';').forEach(function(separar) {
            let [key,value] = separar.split('=');
            cookie[key.trim()] = value;
        })
        return cookie['idCookie'];
    }
    
    // função para mostrar o aspeto da imagem obtendo o caminho da mesma que neste caso fica num diretório temporário
    function carregarImagemQuizz(imagem){

        document.getElementById("imagemQuestao").style.display= "inline";
        document.getElementById("selecionarImagemQuizz").style.display= "none";
        
        document.getElementById("imagemQuestao").src = imagem;
    
        document.getElementById("digitarQuestao").style.left= "35%";
    }



    // Guardar dados quizz ao clicar em guardar 
    $("#botaoGuardar").click(function() {

        dadosRespostas = [];
        ordemGuardarDados = 0;
        respostasCorretas = [];
        
        guardarDadosValido = true;

        if(tipoQuestao == 'escreverResposta'){
            for (let i = 1; i <= 15; i++) {
                if(document.getElementById("digitarResposta"+i)){
                    respostasCorretas[ordemGuardarDados]= 'true';
                    dadosRespostas[ordemGuardarDados]= document.getElementById("digitarResposta"+i).value;
                    ordemGuardarDados +=1;
                }
            }
        }else{
            for (let i = 1; i <= 4; i++) {
                if(document.getElementById("questao"+i).style.display != 'none'){
                        if(document.getElementById("checkBox"+i).checked){
                            respostasCorretas[ordemGuardarDados]= 'true';
                        }else{
                            respostasCorretas[ordemGuardarDados]= 'false';
                        }
                        dadosRespostas[ordemGuardarDados]= document.getElementById("digitarResposta"+i).innerHTML;
                        ordemGuardarDados +=1;
                }
            }
        }
        
        var imagem= document.getElementById("imagemQuestao").src;
        var questao= document.getElementById("digitarQuestao").innerHTML;
         
        if(guardarDadosValido == true){
            $.ajax({
                type:"POST",
                url: "../API/inserirDadosQuizzApi.php",
                data:{
                    accao:"inserirDados",
                    Id_utilizador:Id_utilizador,
                    questao:questao,
                    imagem:imagem,
                    tipoQuestao:tipoQuestao,
                    dadosRespostas:dadosRespostas,
                    respostasCorretas:respostasCorretas
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                    if(resposta== 'questaoVazia'){
                        toastr.warning('Por favor digite uma questão antes de prosseguir!', 'Woops!!!');
                    }
                    if(resposta== 'respostaVazia'){
                        toastr.warning('Por favor preencha todos os campos de resposta ou elimine os não desejáveis', 'Woops!!!');
                    }
                    if(resposta== 'dadosGuardadosComSucesso'){
                        location.href="editarDadosQuizz.php";
                    }
                }
            });
        }
        return false;
    });

});





//Funções referentes à visualização do form de atualização da imagem de perfil

function limparImagemQuestao(){
    document.getElementById("imagemQuestao").style.display= "none";
    document.getElementById("imagemQuestao").src= "";

    document.getElementById("selecionarImagemQuizz").style.display= "inline";
    
    document.getElementById("escolherImagem").value = "";

    document.getElementById("digitarQuestao").style.left= "55px";
    
}

function fecharContainerResposta(numeroContainer){
  var NumeroQuestoesExistentes = 0;

  for (let i = 1; i <= 4; i++) {
    if (document.getElementById("questao" + i).style.display == "none") {
      NumeroQuestoesExistentes += 1;
    }
  }

  if (NumeroQuestoesExistentes >= 1) {
    for (let i = 1; i <= 4; i++) {
      document.getElementById("fecharResposta" + i).style.visibility = "hidden";
    }
  }

  document.getElementById("questao" + numeroContainer).style.display = "none";
  document.getElementById("checkBox" + numeroContainer).checked = false;
  document.getElementById("digitarResposta" + numeroContainer).innerHTML = "";
  document.getElementById("adicionarResposta").style.display = "inline";
}

function adicionarCampoResposta(){
    
    var numRespostasInexistentes = 0;
    for (let i = 1; i <= 4; i++) {
        if(document.getElementById("questao"+i).style.display == "none"){
            document.getElementById("questao"+i).style.display = "inline";
            break;
        }
    }

    for (let i = 1; i <= 4; i++) {
        document.getElementById("fecharResposta"+i).style.visibility = 'visible';
        
        if(document.getElementById("questao"+i).style.display == "none"){
            numRespostasInexistentes += 1;
        }
    }
    if(numRespostasInexistentes == 0){
        document.getElementById("adicionarResposta").style.display = "none";
    }
}

function criarCampoEscreverResposta(){

    var numeroCamposResposta=0;

    for (let i = 1; i <= 15; i++) {
        if(document.getElementById("digitarResposta"+i)){
            numeroCamposResposta += 1;
        }
    }

    if(numeroCamposResposta<15){
        numeroCamposResposta+=1;
        const container = document.getElementById("containerEscreverResposta");

        const div = document.createElement("div");
        div.id = "escreverResposta"+numeroCamposResposta;
        div.innerHTML = '<input id="digitarResposta'+numeroCamposResposta+'" class="digitarEscreverResposta" placeholder="Resposta..." data-max-length="50" contentEditable="plaintext-only"></input> <button class="eliminarEscreverResposta" onclick="EliminarCampoEscreverResposta('+numeroCamposResposta+')"> <i class="fa-solid fa-trash iconDelete"></i> </button>';
        div.classList.add('row');
        container.appendChild(div);
    }

    if(numeroCamposResposta == 15){
        document.getElementById("containerAdicionarResposta").style.display= 'none';
    }
}

function EliminarCampoEscreverResposta(numero){

    var limite=0;
    var iPlus1=0;

    document.getElementById("containerAdicionarResposta").style.display= 'inline';

    for (let i = 1; i <= 15; i++) {
        if(document.getElementById("digitarResposta"+i)){
            limite+=1;
        }
    }
    

    if(limite==2){
        document.getElementById("eliminarResposta1").style.display = "none";
    }

    for (let i = numero; i <limite; i++) {
        iPlus1=i+1;
        if(document.getElementById("digitarResposta"+i).value != ""){
            document.getElementById("digitarResposta"+i).value = document.getElementById("digitarResposta"+i).value = document.getElementById("digitarResposta"+iPlus1).value;
        }
    }
    document.getElementById("escreverResposta"+limite).remove();
}