<link href="testeMenu.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<section>
			<div class="form-box-login">
				<div class="form-value">
					<form action="" method="POST" enctype="multipart/form-data">
						<h2>Entrar na conta</h2>
						<h4>
							<?php 
								if(!empty($erro)){
									echo($erro);
								}  
							?>
						</h4>
						<div class="inputbox">                    
							<input type="email" name= "email" required>
							<label for="">Email</label>
						</div>
						<div class="inputbox">                
							<input type="password" name= "password" required>
							<label for="">Palavra-Passe</label>
						</div>
						<button>Entrar</button>
						<div class="register">
							<p>Se não tiver conta criada. <a href="register.php">Registrar</a></p>
						</div>
					</form>
				</div>
			</div>
		</section>