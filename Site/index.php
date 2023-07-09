<!DOCTYPE html>
<html>
<head>
	<title>Language Quizz- Página Inicial</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="index.css">

	<script src="https://kit.fontawesome.com/410e89720f.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>


</head>
<body>

<?php 
include "menuFooter/menu.php";
?>

<script>
    if (document.cookie.indexOf('sessaoCookie') < -1 ) {
        location.href="index.php";
    }
</script>

<div class="posicionarDiv overflow-auto">
	<h2>Quizzes com maior média de avaliação</h2>
	<div id="melhoresAvaliados" class="testimonial-group overflow-auto">
		<div id="rowMelhoresAvaliados" class="row flex-nowrap">
		</div>
	</div>
</div>


<div class="posicionarDiv overflow-auto">
	<h2>Quizzes com mais avaliações</h2>
	<div id="maisRespondidos" class="testimonial-group overflow-auto">
		<div id="rowMaisRespondidos" class="row flex-nowrap">
		</div>
	</div>
</div>

<div class="posicionarDiv overflow-auto">
	<h2>Quizzes mais recentes</h2>
	<div id="maisRecentes" class="testimonial-group overflow-auto">
		<div id="rowMaisRecentes" class="row flex-nowrap">
		</div>
	</div>
</div>


<div class="d-flex justify-content-center container mt-5">
        <div class="row">
            <div class="col-md-10">
                <div class="d-flex flex-row justify-content-between align-items-center card cookie p-3">
                    <div class="d-flex flex-row align-items-center"><img src="https://i.imgur.com/Tl8ZBUe.png" width="40">
                        <div class="ml-2 mr-2"><span>We use third party cookies to personalize content, ads and&nbsp; analyze site traffic.<br></span><a class="learn-more" href="#">Learn more<i class="fa fa-angle-right ml-2"></i></a></div>
                    </div>
                    <div><button class="btn btn-dark" type="button">Okay</button></div>
                </div>
            </div>
        </div>
    </div>

<script  src="index.js"></script>
<script  src="verificarCriacaoQuizz.js"></script>

<?php 
include "menuFooter/footer.php";
?>

</body>
</html>