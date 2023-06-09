<!DOCTYPE html>
<html>
<head>
    <title>Teste Language Quizz- Perfil</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="Perfil.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">  


</style>

</head>
<body>

<?php
include "../Site/menuFooter/menu.php";
?>


  <script src="https://kit.fontawesome.com/410e89720f.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="jsPerfil.js" crossorigin="anonymous"></script>

  <div class="wrapper bg-white mt-sm-5">
    <div class="d-flex align-items-start py-3 border-bottom">
        <img src="https://images.pexels.com/photos/1037995/pexels-photo-1037995.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
            class="img" alt="">
        <div class="pl-sm-4 pl-2" id="img-section">
            <b>Profile Photo</b>
            <p>Accepted file type .png. Less than 1MB</p>
            <button class="btn button border"><b>Upload</b></button>
        </div>
    </div>
    <div class="py-2">
        <div class="row py-2">
            <div class="col-md-9">
                <label for="firstname">First Name</label>
                <input type="text" class="bg-light form-control" placeholder="Steve">
            </div>
        </div>
        <div class="row py-2">
            <div class="col-md-6">
                <label for="email">Email Address</label>
                <input type="text" class="bg-light form-control" placeholder="steve_@email.com">
            </div>
            <div class="py-4">
            <button class="btn btn-primary">Save Changes</button>
        </div>
        </div>
        <div class="row py-2">
            <div class="col-md-6">
                <label for="country">Country</label>
                <select name="country" id="country" class="bg-light">
                    <option value="india" selected>India</option>
                    <option value="usa">USA</option>
                    <option value="uk">UK</option>
                    <option value="uae">UAE</option>
                </select>
            </div>
            <div class="col-md-6 pt-md-0 pt-3" id="lang">
                <label for="language">Language</label>
                <div class="arrow">
                    <select name="language" id="language" class="bg-light">
                        <option value="english" selected>English</option>
                        <option value="english_us">English (United States)</option>
                        <option value="enguk">English UK</option>
                        <option value="arab">Arabic</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="py-3 pb-4 border-bottom">
            <button class="btn btn-primary mr-3">Save Changes</button>
            <button class="btn border button">Cancel</button>
        </div>
        <div class="d-sm-flex align-items-center pt-3" id="deactivate">
            <div>
                <b>Deactivate your account</b>
                <p>Details about your company account and password</p>
            </div>
            <div class="ml-auto">
                <button class="btn danger">Deactivate</button>
            </div>
        </div>
    </div>
</div>
  
  <div class="outCloseForm" id="showBackground">
      <div class='imagensPopUp' id="showForm">
          <div class="borderFront">
              <img id='imgPerfil'>
              &nbsp&nbsp&nbsp
              <span  style="vertical-align: top;">Imagem Atual</span>
          </div>
  
          <br>
          <hr class="separarImagens">
          <br>
  
          <form action="" method="POST">
          
      
          </form>
          <div class="borderFront">
              <button class='changeImg' onclick="closeForm()">Cancelar</button>
          </div>
      </div>
  </div>
    
</body>
</html>