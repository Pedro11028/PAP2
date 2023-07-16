$(document).ready(function(){

    document.getElementById("menuBarraPesquisa").remove();
    document.getElementById("dropdownUtilizador").remove();
    document.getElementById("menuCriarQuestao").remove();
    document.getElementById("mostrarConteudosMenu").remove();
    document.getElementById("menuPrincipal").className = 'navbar navbar-expand-lg navbar-dark bg-dark';
    document.getElementById("navbarColor02").className = '';
    
    
    document.getElementById("menuGuardarQuestao").style.display="inline";
    document.getElementById("menuCancelarQuestao").style.display="inline";
 
    document.getElementById("menuAdicionarQuestao").style.display="inline";
    document.getElementById("menuAdicionarQuestao").innerHTML="Remover Utilizador <i class='fa-solid fa-right-from-bracket'></i>";
    document.getElementById("menuAdicionarQuestao").style.position= "absolute";
    document.getElementById("menuAdicionarQuestao").style.right= "190px";
    
    document.getElementById("logotipoSite").innerHTML="";
    
    document.getElementById("email").disabled = true;
    document.getElementById("password").disabled = true;


    const Id_utilizador= localStorage.getItem('Id_utilizadorAVerificarPeloAdmin');
    
    $.ajax({
        type:"POST",
        url: "../API/perfilApi.php",
        data:{
            accao:"carregarTodosOsDados",
            Id_utilizador:Id_utilizador
        },
        cache: false,
        dataType: 'json',
        success: function(resposta) {
            document.getElementById('Id_utilizador').value = resposta['Id_utilizador'];
            document.getElementById('nomeCompleto').value = resposta['nomeCompleto'];
            document.getElementById('nomeUnico').value = resposta['nomeUnico'];
            document.getElementById('email').value = resposta['email'];
            document.getElementById('password').value = resposta['password'];
            document.getElementById('Imagem').value = resposta['imagemPerfil'];
            document.getElementById('pontuacao').value = resposta['pontuacao'];
            document.getElementById('permissao').value = resposta['permissao'];
            localStorage.setItem('passwordUtilizador', resposta['password'])
        }
    });

    $(document).on('click','#menuAdicionarQuestao',function(e){
        
        const passwordUtilizador = localStorage.getItem('passwordUtilizador');
        if (window.confirm("Tens a certesa que queres eliminar a questão atual?")) {
            $.ajax({
                type:"POST",
                url: "../API/eliminarContaApi.php",
                data:{
                    accao:"eliminar",
                    Id_utilizador:Id_utilizador,
                    password:passwordUtilizador,
                    confirmarPass:passwordUtilizador
                    
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                    if(resposta == "dadosEliminadosComSucesso"){
                        window.location.href = "painelAdminUtilizadores.php";
                    }
                }
            });
        }
        return false;
    });

    $(document).on('click','#menuGuardarQuestao',function(e){
        
        const Id_utilizador = document.getElementById('Id_utilizador').value;
        const nomeCompleto = document.getElementById('nomeCompleto').value;
        const nomeUnico = document.getElementById('nomeUnico').value;
        const Imagem = document.getElementById('Imagem').value;
        const pontuacao = document.getElementById('pontuacao').value;
        const permissao = document.getElementById('permissao').value;
        
            $.ajax({
                type:"POST",
                url: "../API/alterarDadosUtilizadorApi.php",
                data:{
                    accao:"alterarDadosUtilizador",
                    Id_utilizador:Id_utilizador,
                    nomeCompleto:nomeCompleto,
                    nomeUnico:nomeUnico,
                    email:email,
                    password:password,
                    Imagem:Imagem,
                    pontuacao:pontuacao,
                    permissao:permissao
                    
                },
                cache: false,
                dataType: 'json',
                success: function(resposta) {
                    if(resposta == "dadosGuardadosComSucesso"){
                        toastr.success('Dados guardados com sucesso!', 'Sucesso!!!');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                  toastr.warning('Parece ter ocorrido um erro com a ligação á base de dados!', 'Woops!!!');
                }
            });
        return false;
    });

    $(document).on('click','#menuCancelarQuestao',function(e){
        window.location.href = "painelAdminUtilizadores.php";
    });
});

function editarUtilizador(Id_utilizador){
    localStorage.setItem('Id_utilizadorAVerificarPeloAdmin', Id_utilizador);
    window.location.href="dadosUtilizadorPainelAdmin.php";
}