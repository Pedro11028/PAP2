<link rel="stylesheet" type="text/css" href="menuFooter/menu.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>

<script src="https://kit.fontawesome.com/410e89720f.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>


<nav id="menuPrincipal" class="navbar navbar-expand-lg navbar-dark bg-dark"> <a id="logotipoSite" class="navbar-brand" href="index.php" data-abc="true">LANGUAGEQUIZZ</a> <button id="mostrarConteudosMenu" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div id="navbarColor02" class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <form onsubmit="event.preventDefault()" id="menuBarraPesquisa" class="form-inline my-2 my-lg-0"> <input id="textoAPesquisar" class="form-control mr-sm-2" type="text" placeholder="Search"> <button id="pesquisar" class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> </form>
			<li id="menuCriarQuestao" class="nav-item"> <a id="linkCriarQuestao" class="nav-link" href="escolherTipoQuestao.html" data-abc="true">Criar Questão</a> </li>
			<li id="painelAdmin" class="nav-item"> <a id="linkPermissao" class="nav-link" href="" data-abc="true"></a> </li>
			<div id="dropdownUtilizador" class="dropdown show direita">
				<a class="btn btn-secondary dropdown-toggle tamanhoDropDown" href="" role="button" id="nomeUtilizador" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Pedr0siris
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item tamanhoDropDown linksDropDown" href="Perfil.php"><i class="fa-solid fa-user"></i> Perfil</a>
					<a class="dropdown-item tamanhoDropDown linksDropDown" href="sair.html"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair </a>
				</div>
			</div>

				<li id="registar" class="nav-item active"> <a class="nav-link" href="registo.html" data-abc="true">Registar</a> </li>
				<li id="login" class="nav-item active"> <a class="nav-link" href="login.html" data-abc="true">Entrar</a> </li>

				<li  class="nav-item">
					<button id="menuCancelarQuestao" class="btn btn-secondary my-2 my-sm-0 esquerda" type="submit"><i class="fa-solid fa-outdent"></i> Cancelar</button>
					<button id="menuEliminarQuizz" class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fa-solid fa-trash"></i> Eliminar Quizz</button>
					
					
					<button id="menuAdicionarQuestao" class="btn btn-secondary my-2 my-sm-0" type="submit">Adicionar Questão <i class="fa-solid fa-plus"></i></button>
					<button id="menuGuardarQuestao" class="btn btn-secondary my-2 my-sm-0 direita" type="submit">Guardar <i class="fa-solid fa-floppy-disk"></i></button>
				</li>
		</li>
		</ul>			
    </div>
</nav>
		
<script src="menuFooter/menu.js"></script>