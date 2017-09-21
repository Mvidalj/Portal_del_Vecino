<?php
    require_once 'validaciones/conexion_bd.php';

    SESSION_START();

    if($user->is_loggedin()!="")
    {
        $user->redirect('home.html');
    }
    
    if(isset($_POST['login-submit']))
    {
        $umail = $_POST['login-user'];
        $upass = $_POST['login-pswd'];
  
        if($user->login($umail,$upass))
        {
            $user->redirect('home.html');
        }
        else
        {
            $error = "Datos equivocados!";
        } 
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Portal del Vecino</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<div class="container">
	<div class="jumbotron">
		<div class="row">
			<div class="col-sm-2">
	    		<img class="img-responsive" src="imagenes/home.jpg" width="130" height="130">
	    	</div>
                <form method="POST">
	    	<br><div class="row">
			    	<div class="col-sm-3 col-sm-push-2">
			    		<label for="login-user"><span class="fa fa-user-circle-o"></span> Usuario:</label>
			    		<input type="text" id="login-user" class="form-control" name="login-user" placeholder="Correo" autofocus>
			    	</div>
			    	<div class="col-sm-3 col-sm-push-2">
			    		<label for="login-pswd"><span class="fa fa-lock"></span> Contraseña:</label>
			    		<input type="password" id="login-pswd" class="form-control" name="login-pswd" placeholder="Contraseña">
			    	</div>
			    	<div class="col-sm-3 col-sm-push-2">
                                    <br><button type="submit" id="login-submit" class="btn btn-primary ingreso" name="login-submit">Ingresar <span class="fa fa-sign-in"></span></button>
			    	</div>
			    	<div class="col-sm-3 col-sm-push-7">
			    		<br><a href="#">¿Olvido su Contraseña <span class="fa fa-unlock-alt"></span> ?</a>
			    	</div>
			    </div>
	    	</form>
	    </div>
	</div>

	<div class="page-header">
  		<h1>Registro de Usuario</h1>
	</div>

	<form>
		<div class="row">
			<div class="col-sm-3 col-sm-push-3">
	    		<label for="usrr">Nombre:</label>
	    		<input type="text" class="form-control" id="usrr" placeholder="Nombre">
	    	</div>
	    	<div class="col-sm-3 col-sm-push-3">
	    		<label for="pass">Contraseña:</label>
	    		<input type="password" class="form-control" id="pass" placeholder="Contraseña">
	    	</div>
		</div><br><br>
		<div class="row">
			<div class="col-sm-3 col-sm-push-3">
	    		<label for="com">Comuna:</label>
	    		<input type="text" class="form-control" id="com" placeholder="Comuna">
	    	</div>
	    	<div class="col-sm-3 col-sm-push-3">
	    		<label for="dir">Dirección:</label>
	    		<input type="text" class="form-control" id="dir" placeholder="Dirección">
	    	</div>
		</div><br><br>
		<div class="row">
			<div class="col-sm-3 col-sm-push-3">
	    		<label for="cor">Correo:</label>
	    		<input type="email" class="form-control" id="cor" placeholder="Correo">
	    	</div>
	    	<div class="col-sm-3 col-sm-push-3">
	    		<label for="tel">Teléfono:</label>
	    		<input type="text" class="form-control" id="tel" placeholder="Teléfono">
	    	</div>
		</div><br>
		<div class="row">
			<div class="col-sm-2 col-sm-push-5">
				<div class="row">
					<div class="col-sm-2 col-sm-push-2">
		    			<br><a type="button" class="btn btn-success" href="home.html" rel>Registrarse <span class="fa fa-check"></span></a><br><br>
		    		</div>
		    	</div>
	    	</div>
		</div>
	</form>

	<footer>
		    <div class="footer jumbotron">
		        <div class="container-fluid">
		            <div class="row">
		                <div class="col-sm-4">
		                    <h3> Horarios  <i class="fa fa-clock-o"></i></h3>
		                    <ul>
		                        <li> Lunes a Viernes: 14:00 - 00:00</li>
		                        <li> Sábado y Domingo: 16:00 - 22:00 </li>
		                    </ul>
		                </div>
		                <div class="col-sm-4">
		                    <h3> Contacto </h3>
		                    <ul>
		                        <li> <i class="fa fa-map-marker"></i> Dirección: Rudecindo Ortega 2950, Temuco</li>
		                        <li> <i class="fa fa-phone"></i> Telefono: +56 45 255 3978</li>
		                        <li> <i class="fa fa-envelope"></i> e-mail: uct@uct.cl</li>
		                    </ul>
		                </div>
		                <div class="col-sm-4">
		                    <h3> Redes sociales </h3>
		                    <ul class="social">
		                        <li> <a href="https://www.facebook.com/canaluctemuco/"> <i class=" fa fa-facebook"></i> </a> </li>
		                        <li> <a href="https://twitter.com/uc_temuco?"> <i class="fa fa-twitter">   </i> </a> </li>
		                    </ul>
		                </div>
		            </div>
		        </div>
		    </div>
		</footer>

</div>
</body>
</html>