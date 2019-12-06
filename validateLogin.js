const formLogin = document.querySelector('#loginFrm');
formLogin.addEventListener('submit', function (e) {
  e.preventDefault();
  login();
});
function login(){
  datos = document.getElementById("mail").value;
  pass = document.getElementById("pass").value;
     $.ajax({
      url: "getUsers.php",
      method: "POST",
      data: {'mail': datos, 'login': 'login'},
      dataType: "json",
      beforeSend: function (){
        document.querySelector('#go').disabled = true
      }
    }).done(function(data) {
      if(datos == data.eMail && pass == data.pass){
        if(data.tipo==1)
        window.location = 'mapa.php';
      else
        window.location = 'admin.php';
      }
      else
        alert("Datos incorrectos");
    }).fail(function( jqXHR, textStatus ) {
      debugger
      alert( "Hubo un error: " + textStatus );
    }).always(function() {
        document.querySelector('#go').disabled = false
    });
}



function enter(){

 /*$.ajax({                        
           type: "POST",                 
           url: 'userTest.php',                     
           data: {'info': datos}, 
       }).done(function(data){
          console.log(data);
          window.location = 'userTest.php';
       });*/
}

