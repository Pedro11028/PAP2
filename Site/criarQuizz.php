<!DOCTYPE html>
<html>
<head>
	<title>Language Quizz- Criar Quizz</title>
	<meta charset="utf-8">
	
<style type="text/css">

* {
    margin: 0 auto;
    box-sizing: border-box;
    font-family: 'Open Sans', sans-serif;
  }

nav {
	margin: 0 auto;
	background: black;
	box-shadow:0 3px 15px rgba(0,0,0,.15);
}

nav::after {
	display: block;
	content: '';
	clear: both;
}

nav ul {
	padding: 0;
	margin: 0;
	list-style: none;
}

nav ul li {
	float: left;
	position: relative;
}

nav ul li a {
	display: block;
	color: blue;
	text-decoration: none;
	padding: 1rem 2rem;
    color:white;
}

nav li:hover ul, .menu li.over ul{
    display:block;
}

nav ul li a:hover {
    background-color: rgb(24, 139, 233);
}

nav li ul li{
    border:1px solid #c0c0c0;
    display:block;
    width:123px;
}

nav ul li ul li a {
	background: transparent;
	border-bottom: 1px solid #DDE0E7;
}

nav ul li ul li a:hover {
    background-color: #1111;
}


.dropar {
	display: none;
	position: absolute;
	background: #fff;
	text-align: center;
}
.colorBlack{
    color: black;
}

.direita{
    float: right;
    margin-right: 0px;
    width:123px;
}


.imgPerfil{
    border: #CCF solid 4px;
    padding: 1px;
    border-radius: 70%;
    border-top-color: #0000FF;
    border-left-color: #0000FF;
    width: 100px;
    height: 100px;
}

.divPosition{
    border-style: solid;
    border-color: coral;
    position: left;
    width: 30%;
    height: 110px;
}

.Informações{
    width: 560px;
    padding: 1rem;
    background-color: white;
    border-radius: 5%;
}

.borderFront{
    position:relative;
}

.changeImg{
    position:absolute;
    left: 130px;
    top: 50px;
    width: 110px;
    height: 30px;
    padding: 5px;
    margin-top: 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.5s;
    border: 1px solid #435688;
    outline: none;
    background: white;
}

.changeImg:hover{
    background:#138ABE;
    color: white;
}

.textInsertImg{
    text-indent: 130px;
    font-size: 13px;
}

.input-info {
    margin-top: 20px;
    margin-bottom: 5px;
}

input[type="text"],input[type="email"],input[type="password"],input[type="confirmarpass"]  {
    border: 1px solid #828999;
    padding: 6px;
    border-radius: 5px;
    width: 65%;
    background: none;
    margin: 0px 5px 5px 10px;
    outline: none;
    transition: 0.5s;
    text-indent: 10px;
    overflow: hidden;
}

th{
    text-align: left;
}

.button{
    padding: 5px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.5s;
    border: 1px solid #435688;
    outline: none;
    background: white;
}

.button:hover{
    background: #dcdcdc;
}

.alterarFuncoes{
    color:red;
    text-decoration:none;
    transition: 0.5s;
}

.alterarFuncoes:hover{
    color:purple;
}

body{
    background-color: gray;
}

</style>

</head>
<body>
<?php
    require 'conexao.php';

    if($_SESSION["loggedIn"] == false){
        header("Location: index.php");
    }

    if($_SESSION['utilizador']==true){
       $nome= $_SESSION['utilizador'] [0];
       $email= $_SESSION['utilizador'] [1];
       $password= $_SESSION['utilizador'] [2];
       $id_utilizador= $_SESSION['utilizador'] [3];
    }

    if(!empty($_SESSION['mensagem'])) {
        $mensagem = $_SESSION['mensagem'];
        echo "<script> alert('$mensagem')</script>";
        unset($_SESSION['mensagem']);
    }   

        $sql = $connect->prepare('SELECT * FROM utilizadores WHERE Id_utilizador = :id_utilizador');
        $sql-> execute(array(':id_utilizador' => $id_utilizador));
        $data = $sql->fetch(PDO::FETCH_ASSOC);

        $guardarNome= "$data[nome]";

        $pontuacao= "";
        $pontuacao = "$data[pontuacao]";
        $nivel= "0";

        intval($pontuacao);

        switch (true) {

            case ($pontuacao >=100 && $pontuacao <200):
                $nivel="1";
                break;

            case ($pontuacao >=200 && $pontuacao <300):
                $nivel="2";
                break;

            case ($pontuacao >=300 && $pontuacao <400):
                $nivel="3";
                break;

            case ($pontuacao >=400 && $pontuacao <500):
                $nivel="4";
                break;
            case $pontuacao >=500:
                $nivel="5";
                break;
        }

    if (isset($_POST['alterarNome'])) {
        $errMsg = '';
        // Obter nome do FROM
        $nome = $_POST['nome'];

        try {
            //Verificar se o nome é diferete do atual
            if ($guardarNome != $nome) {
                
                $sql = 'UPDATE utilizadores SET nome = :nome WHERE Id_utilizador = :Id_utilizador';

                // preparar declaração
                $stmt = $connect->prepare($sql);

                // atribuir valores aos parametros
                $stmt->bindParam(':Id_utilizador', $id_utilizador, PDO::PARAM_INT);
                $stmt->bindParam(':nome', $nome);

                // exexutar a atualização
                if ($stmt->execute()) {
                    echo "<script>alert('O seu nome foi atualizado com sucesso!')</script>";
                }

                $guardarNome="$nome";
                
            } else {
            echo "<script>alert('Woops! O nome não pode ser o mesmo.')</script>";
            
            }

    }catch(PDOException $error) {
        echo $error->getMessage();
    }
}
    
?>
<nav class="nav">
	<ul>
		<li>
			<a href="index.php">Início</a>
		</li> 
    <li><a href="">Pesquisa</a></li>

    <?php if($permissao=='1'):?>
    <li ><a href="PainelAdmin.php">Painel_ADM</a></li>
    <?php endif; ?>

    <?php if($_SESSION['loggedIn']==true):?>
		
	<?php else: ?>  
	
		<li class="direita"><a href="login.php">Login</a></li>
		<li class="direita"><a href="registo.php">Register</a></li>
	<?php endif; ?>
    </ul>
</nav>


<br>

<div class='Informações'>
    <div>
        <p class="textInsertImg">Allowed JPG, GIF or PNG. Max size of 800K</p>
    </div>
    <div class="showLines">
        <form action="" method="POST">
            <div class="input-info">
                <label class="form-label">Nome Utilizador</label> <p>
                <input type="text" required="required" name="nome" <?php echo("value='$guardarNome'") ?>>
                <button class="button" name="alterarNome">Mudar Nome</button>
            </div>
        </form>
    </div>
    <div>
            <div class="input-info">
                <label class="form-label">Password Utilizador</label><p>
                <input type="password" name="email" <?php echo("value='$data[password]'") ?> readonly>&nbsp
                <a href="renamePass.php" > <button class="button">Mudar password</button> </a>
            </div>
    </div>
    <div>
        <div class="input-info">
            <table style="width:100%">
                <tr>
                  <th>
                     <label class="form-label" align="left">Quizzes Criados</label>
                  </th>
                </tr>
                <tr>
                  <td>
                     <label> <?php echo("$data[quizzCriados]") ?>&nbsp </label>
                  </td>
                </tr>
            </table>
        </div>
    </div>
    <div>
        <div class="input-info">
            <table style="width:100%">
                <tr>
                  <th>
                     <label class="form-label" align="left">Quizzes Realizados</label>
                  </th>
                </tr>
                <tr>
                  <td>
                     <label> <?php echo("$data[quizzesRealizados]") ?>&nbsp </label>
                  </td>
                </tr>
            </table>
        </div>
    </div>
    <div>
        <div class="input-info">
            <table style="width:100%">
                <tr>
                  <th>
                     <label class="form-label" align="left">Número de avaliações feitas</label>
                  </th>
                </tr>
                <tr>
                  <td>
                     <label> <?php echo("$data[num_avaliações]") ?>&nbsp </label>
                  </td>
                </tr>
            </table>
        </div>
    </div>
    <div>
        <form action="" method="POST">
            <div class="input-info">
                <a class="alterarFuncoes" href="elimin_conta.php">Excluir Conta</button>
            </div>
        </form>
    </div>
    <div>
        <form action="" method="POST">
            <div class="input-info">
                <a class="alterarFuncoes" href="logout.php">Sair</button>
            </div>
        </form>
    </div>
</div>
<br>
        


</body>
</html>