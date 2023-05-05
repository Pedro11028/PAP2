  $(document).ready(function() {
     $("#submit").click(function() {

            var email= $('#email').val();
            var password= $('#password').val();

            $.ajax({
                type:"POST",
                url: "testeInserirDados.php",
                data:{
                    email:email,
                    password:password
                },
                 cache: false,
                 success: function(data) {
                 alert(data);
                 },
                 error: function(xhr, status, error) {
                 console.error(xhr);
                 }
            });
     
     });
 });