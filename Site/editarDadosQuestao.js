$(document).ready(function(){
    
    document.getElementById("menuBarraPesquisa").remove();
    document.getElementById("dropdownUtilizador").remove();
    document.getElementById("menuCriarQuestao").remove();
    document.getElementById("mostrarConteudosMenu").remove();
    document.getElementById("menuPrincipal").className = 'navbar navbar-expand-lg navbar-dark bg-dark';
    document.getElementById("navbarColor02").className = '';
    
    
    document.getElementById("menuGuardarQuestao").style.display="inline";
    document.getElementById("menuCancelarQuestao").style.display="inline";
 
    //Embora o botão tenha o id "menuAdicionarQuestao" nesta página ele servirá para eliminar a mesma
    document.getElementById("menuAdicionarQuestao").style.display="inline";
    document.getElementById("menuAdicionarQuestao").innerHTML="Remover Questão <i class='fa-solid fa-right-from-bracket'></i>";

    
    document.getElementById("logotipoSite").innerHTML="";
    document.getElementById("eliminarResposta1").style.display = "none";
    
    function tamanhoDaJanela(media) {
        if (media.matches) {
            document.getElementById("menuAdicionarQuestao").style.position= "relative";
            document.getElementById("menuAdicionarQuestao").style.right= "0px";
            document.getElementById("menuCancelarQuestao").className = 'btn btn-secondary my-2 my-sm-0 ';

        } else {
            document.getElementById("menuAdicionarQuestao").style.position= "absolute";
            document.getElementById("menuAdicionarQuestao").style.right= "190px";
        }
    }
      
    const media = window.matchMedia("(max-width: 700px)");
    tamanhoDaJanela(media);
    media.addListener(tamanhoDaJanela);

    // obter o Tipo de questão e com isso determinar o formato da página
    const Id_questao = getIdquestaoCookie();
    const Id_utilizador = localStorage.getItem("Id_utilizador");

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
            descobrirTipoquestao(resposta);
            carregarImagemQuizz(resposta['imagemQuestao']);
            criarTipoCookie(resposta['dadosQuestao']['tipoQuestao']);
        }
    });

    function descobrirTipoquestao(dadosQuestao){
        if(dadosQuestao['dadosQuestao']['tipoQuestao'] == 'textoLivre'){
            document.getElementById("selecionarResposta").remove();
            inserirDadosDoTipoEscreverResposta(dadosQuestao);
        }else{
            if(dadosQuestao['dadosQuestao']['tipoQuestao']  == null){
                location.href="escolherTipoQuestao.html";
            }else{
                document.getElementById("escreverResposta").remove();
                inserirDadosDoTipoSelecionarResposta_e_Enquete(dadosQuestao);
            }
        }
    }

    function inserirDadosDoTipoEscreverResposta(dadosQuestao){
        tamanhoArray= dadosQuestao['dadosRespostas'].length;

        document.getElementById("digitarQuestao").innerHTML = dadosQuestao['dadosQuestao']['textoQuestao'];

        for (let i = 0; i < tamanhoArray; i++) {
            if(document.getElementById("digitarResposta1").value== "" || document.getElementById("digitarResposta1").value== " "){
                document.getElementById("digitarResposta1").value=  dadosQuestao['dadosRespostas'][0]['respostaQuizz'];
            }else{
                criarCampoEscreverResposta();
                iplus1= i+1;
                document.getElementById("digitarResposta"+iplus1).value=  dadosQuestao['dadosRespostas'][i]['respostaQuizz'];      
            }
        }
    }

    function inserirDadosDoTipoSelecionarResposta_e_Enquete(dadosQuestao){
        tamanhoArray= dadosQuestao['dadosRespostas'].length;

        document.getElementById("digitarQuestao").innerHTML = dadosQuestao['dadosQuestao']['textoQuestao'];

        for (let i = 0; i < tamanhoArray; i++) {
            iplus1= i+1;
            document.getElementById("digitarResposta"+iplus1).innerHTML=  dadosQuestao['dadosRespostas'][i]['respostaQuizz'];
            
            if(dadosQuestao['dadosRespostas'][i]['valorResposta'] == 'true'){
                document.getElementById("checkBox"+iplus1).checked= "true";
            }
        }

        for (let i = tamanhoArray; i < 4; i++) {
            iplus1= i+1;
            document.getElementById("questao"+iplus1).style.display = 'none';
        }

        //Verificar quantidade de campos existentes, se forem dois então esconde o botão eliminar resposta e mostra o botão para as adicionar
        var NumeroQuestoesExistentes = 0;

        for (let i = 1; i <= 4; i++) {
          if (document.getElementById("questao"+ i).style.display == "none") {
            NumeroQuestoesExistentes += 1;
          }
        }
      
        if (NumeroQuestoesExistentes >= 1) {
          for (let i = 1; i <= 4; i++) {
            document.getElementById("fecharResposta" + i).style.visibility = "hidden";
          }
          
          document.getElementById("adicionarResposta").style.display = "inline";
        }else{
                document.getElementById("adicionarResposta").style.display = "none";
        }

        
    }

    function criarTipoCookie(nomeCookie) { 
        var hoje = new Date();
        var tempo = hoje.getTime();
        var expirarCookie = tempo + 3600000*24;       
        hoje.setTime(expirarCookie);
      
        document.cookie = "tipoQuestaoCookie= "+nomeCookie+';expires='+hoje.toUTCString()+"; secure=true"+';path=/';
    }

    //Voltar ao editar Quizz mas elimininando a imagem temporária caso exista
    $(document).on('click','#menuCancelarQuestao',function(e){
            var caminhoImagem = document.getElementById("imagemQuestao").src;
            caminhoDiretorio= caminhoImagem.substr(0, caminhoImagem.lastIndexOf("/"));
            
            $.ajax({
                type:"POST",
                url: "../API/eliminardiretorioTemporarioApi.php",
                data:{
                    accao:"eliminarDiretorio",
                    caminhoImagem:caminhoImagem,
                    caminhoDiretorio:caminhoDiretorio
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                    if(resposta == 'sucesso'){
                        location.href = "editarDadosQuizz.php";
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
            }
            });
        return false;
    });

    //Guardar a imagem num diretório temporariamente
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
    
    // função para mostrar o aspeto da imagem obtendo o caminho da mesma que neste caso fica num diretório temporário
    function carregarImagemQuizz(imagem){
        if(imagem == "" || imagem == " "){
            limparImagemQuestao();
        }else{
            document.getElementById("imagemQuestao").style.display= "inline";
            document.getElementById("selecionarImagemQuizz").style.display= "none";
            
            document.getElementById("imagemQuestao").src = imagem;
        
            document.getElementById("digitarQuestao").style.left= "35%";
        }
    }

    
    $("#menuAdicionarQuestao").click(function() {
        if (window.confirm("Tens a certesa que queres eliminar a questão atual?")) {
            var imagem= document.getElementById("imagemQuestao").src;
            caminhoDiretorio= imagem.substr(0, imagem.lastIndexOf("/"));
            const tipoTemporario= "temporario";

            $.ajax({
                type:"POST",
                url: "../API/eliminarQuestaoApi.php",
                data:{
                    accao:"eliminarQuestao",
                    Id_utilizador:Id_utilizador,
                    Id_questao:Id_questao,
                    imagem:imagem,
                    caminhoDiretorio:caminhoDiretorio,
                    tipoTemporario:tipoTemporario
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                    if(resposta == 'dadosEliminadosComSucesso'){
                        location.href="editarDadosQuizz.php";
                    }
                    if(resposta == 'quizzNaoExiste'){
                        location.href="index.php";
                    }
                }
            });
        }
        return false;
    });


    // Guardar dados quizz ao clicar em guardar
    $("#menuGuardarQuestao").click(function() {
        var tipoQuestao = getTipoQuestaoCookie();

        if(!tipoQuestao){
            tipoQuestao= "";
        }

        dadosRespostas = [];
        ordemGuardarDados = 0;
        respostasCorretas = [];

        if(tipoQuestao === "textoLivre"){
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
        caminhoDiretorio= imagem.substr(0, imagem.lastIndexOf("/"));
        var questao= document.getElementById("digitarQuestao").innerHTML;
        const tipoTemporario= "temporario";

            $.ajax({
                type:"POST",
                url: "../API/atualizarDadosQuestaoApi.php",
                data:{
                    accao:"atualizarDados",
                    Id_utilizador:Id_utilizador,
                    Id_questao:Id_questao,
                    questao:questao,
                    imagem:imagem,
                    caminhoDiretorio:caminhoDiretorio,
                    tipoQuestao:tipoQuestao,
                    dadosRespostas:dadosRespostas,
                    respostasCorretas:respostasCorretas,
                    tipoTemporario:tipoTemporario
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                    if(resposta == 'nenhumaRespostaCorreta'){
                        toastr.warning('Por favor selecione uma resposta correta!', 'Woops!!!');
                    }
                    if(resposta == 'questaoVazia'){
                        toastr.warning('Por favor digite uma questão antes de prosseguir!', 'Woops!!!');
                    }
                    if(resposta == 'respostaVazia'){
                        toastr.warning('Por favor preencha todos os campos de resposta ou elimine os não desejáveis', 'Woops!!!');
                    }
                    if(resposta == 'dadosGuardadosComSucesso'){
                        location.href="editarDadosQuizz.php";
                    }
                    
                    if(resposta == 'dadosGuardadosComSucesso'){
                        location.href="editarDadosQuizz.php";
                    }
                    if(resposta == 'quizzNaoExiste'){
                        location.href="index.php";
                    }
                }
            });
        return false;
    });

    function getTipoQuestaoCookie(){
        let cookie = {};
            document.cookie.split(';').forEach(function(separar) {
               let [key,value] = separar.split('=');
               cookie[key.trim()] = value;
            })
            return cookie['tipoQuestaoCookie'];
    }
    
});



//Funções referentes à visualização do form de atualização da imagem de perfil

function eliminarImagemQuestao(){
    var caminhoImagem = document.getElementById("imagemQuestao").src;
    caminhoDiretorio= caminhoImagem.substr(0, caminhoImagem.lastIndexOf("/"));
    
    $.ajax({
        type:"POST",
        url: "../API/eliminardiretorioTemporarioApi.php",
        data:{
            accao:"eliminarDiretorio",
            caminhoImagem:caminhoImagem,
            caminhoDiretorio:caminhoDiretorio
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            if(resposta == 'sucesso'){
                 limparImagemQuestao();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
        }
    });
}

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

    if(document.getElementById("eliminarResposta1").style.display == "none"){
        document.getElementById("eliminarResposta1").style.display = "inline";
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