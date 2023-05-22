
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
		<li id="menuGuardarInfoQuizz" class="criarQuizz"><button id="botaoGuardar" >Criar um Quizz</button></li>

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