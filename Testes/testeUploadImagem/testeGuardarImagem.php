<!DOCTYPE HTML>
<!DOCTYPE html>
<html>
<head>
  <title>AJAX File Upload</title>
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

</head>
<body>
<form  method="post" enctype="multipart/form-data" id="guardarImgForm">
          
          <img src="" id="changeImgPerfil" >
          <input id="escolherImagem" type="file" name="file" class="custom newButton selecionarImg" accept="image/png, image/jpeg">
          <input id="mostrarFicheiro" type="text"  class="mostrarFicheiro selecionarImg" readonly>
          <button id="guardarImg" type="submit" style="float: right;" class='btn button border selecionarImgBtn'>Guardar</button>
        
      </form>
<div id="alerBox"></div>
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('submit','#guardarImgForm',function(e){
           var formData = new FormData(this);

           var formData = new FormData(this);
           $.ajax({
           method:"POST",
           url: "upload.php",
           data:formData,
           cache:false,
           contentType: false,
           processData: false,
           beforeSend:function(){
           },
           success: function(resposta){
               alert(resposta);
           }
          
           });
    });
});
</script>
</body>
</html>