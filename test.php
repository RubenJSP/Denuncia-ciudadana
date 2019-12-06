<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
     
     <?php
     	include('consultas.php');
     	saveUser("Pedro","Lopez","Perez","pedro@hotmail.com","1234","1669-04-05",1);
     	getUsers();

     ?>
    </body>
</html>