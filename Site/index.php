<!DOCTYPE html>
<html>
<head>
	<title>Language Quizz- Página Inicial</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="index.css">

	<script src="https://kit.fontawesome.com/410e89720f.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>


</head>
<body>

<?php 
include "menuFooter/menu.php";
?>

<div id="melhoresAvaliados" class="testimonial-group overflow-auto">
	<h2>Quizzes com maior média de avaliação</h2>
    <div id="rowMelhoresAvaliados" class="row flex-nowrap">



	</div>
</div>

<div id="maisRespondidos" class="testimonial-group overflow-auto">
	<h2>Quizzes com mais avaliações</h2>
	<div id="rowMaisRespondidos" class="row flex-nowrap">



	</div>
</div>

<div id="maisRecentes" class="testimonial-group overflow-auto">
	<h2>Quizzes mais recentes</h2>
	<div id="rowMaisRecentes" class="row flex-nowrap">



	</div>
</div>




<script  src="index.js"></script>

<?php 
include "menuFooter/footer.php";
?>

</body>
</html>