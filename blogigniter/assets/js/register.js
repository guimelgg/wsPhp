//#region JQuery
$(function (){
    $(document).ready(function(){
      $('#logForm').submit(function(e){
        e.preventDefault();
        $('#logText').html('Verificando...');
        var user = $('#logForm').serialize();
        var login = function(){
          $.ajax({
            type: 'POST',
            url: url + 'login',
            dataType: 'json',
            data: user,
            success:function(response){
              $('#message').html(response.message);
              $('#logText').html('Login');
              if (response.status == 0) {                
                $('#responseDiv').removeClass('alert-success').addClass('alert-danger').show();
              }
              else{
                $('#responseDiv').removeClass('alert-danger').addClass('alert-success').show();
                $('#logForm')[0].reset();
                setTimeout(function(){
                  location.reload();
                }, 3000);
              }
            }
          });
        };
        setTimeout(login, 3000);                
      })
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
