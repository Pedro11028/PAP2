
<script src="https://kit.fontawesome.com/410e89720f.js" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="menuFooter/menu.css">

<div class="estiloMenu">
<nav>
	<ul>
		<li>
			<a id="linkInicio" href="index.php">Início</a>
		</li> 

        <form>
          <li>
            <input id="menuBarraPesquisa" type="text" class="barraPesquisa">
          </li>
          <li>
            <button id="menuSearch" class="search"><i class="fa-solid fa-magnifying-glass"></i></button>
          </li>
        </form>

        <li id="menuCriarQuizz" class="criarQuizz"><a id="linkCriarQuizz" href="escolherTipoQuizz.html">Criar um Quizz</a></li>

		<li id="menuGuardarInfoQuizz" class="criarQuizz"><button id="botaoGuardar"></button></li>
		<li id="menuAdicionarQuestao" class="criarQuizz">
		<button id="botaoadicionarQuizz" class="bi bi-plus-circle">
			<!-- Icon adicionar +,do bootstrap link:  -->
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
				<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
				<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
			</svg>
			Adicionar Quizz
		</button></li>

		<li id="dropUtilizador" class="direita"><a id="nomeUtilizador"></a>
			<ul  class="dropar">
				<li><a  class="dropContent" href="perfil.php"> <i class="fa-solid fa-user"></i> Perfil</a></li>
				<li><a  class="dropContent" href="Logout.html"> <i class="fa-solid fa-arrow-right-from-bracket"></i> Sair </a></li>
			</ul>
		</li>
    	
    	<li id="login" class="direita"><a href="login.html">Login</a></li>
    	<li id="register" class="direita"><a href="registo.html">registar</a></li>
    </ul>
</nav>
<div>

<script src="menuFooter/menu.js"></script>