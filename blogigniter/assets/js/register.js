//#region JQuery
$(function (){

    $(document).ready(function(){
      $(document).on('submit', 'form', function (e) {
        $('#logText').html('Verificando...');
        var user = $('#logForm').serialize();
        $.ajax({
          type: 'POST',
          url: 'register',
          dataType: 'json',
          cache: false,
          data: user,
          success:function(response){
            $('#message').html(response.message);
            $('#logText').html('Login');
            $('#responseDiv').removeClass('alert-danger').addClass('alert-success').show();
            $('#logForm')[0].reset();
           /* setTimeout(function(){
              login;
            }, 3000);*/
          },
          error:function(response){
            $('#message').html(response.message);
            $('#logText').html('Login');
            $('#responseDiv').removeClass('alert-success').addClass('alert-danger').show();              
          }
        });
        //setTimeout(function(){ alert("Hello"); }, 3000);      
      });

      $("input[type='password']" ).change(function() {       
        ValEqualPassword();
        // Check input( $( this ).val() ) for validity here
      });

    });

    function ValEqualPassword(){
      console.log('Entra pass');
      var password = document.getElementById("password");
      var confirm_password = document.getElementById("repeatpassword");    
      console.log(password.value);
      console.log(confirm_password.value);
      if(password.value != confirm_password.value){
        confirm_password.setCustomValidity("Los passwords no coinciden");
      } else {
        confirm_password.setCustomValidity('');
      }
    }
});
//#endregion
