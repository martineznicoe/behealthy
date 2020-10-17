<?php
    require_once 'clases/Usuario.php';
    session_start();
    if (isset($_SESSION['usuario'])) {
        header('Location: home.php');
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>BeHealthy</title>
        <link rel="stylesheet" href="bootstrap.min.css">
    </head>
    <body class="container text-center" style="width: 25rem; margin-top: 20px;">

        <div class="row text-center">
        
            <div class="col-12">
                <img src="ima/logo1.svg" style="width: 200px;">
            </div>
            <div class="col-12">
                <h2>Login de usuario</h2>
                <br>
            </div>
            <div class="col-12">
                <?php
                    if (isset($_GET['mensaje'])) {
                        echo '<div id="mensaje" class="alert alert-primary">
                            <p>'.$_GET['mensaje'].'</p></div>';
                    }
                ?>
            </div>

            <!-- Formulario de login -->
            <div class="col-12 form-group">
                <form action="login.php" method="post">
                    <input name="usuario" class="form-control form-control-lg" placeholder="Usuario" required><br>
                    <input name="clave" type="password" class="form-control form-control-lg" placeholder="Contraseña" required><br>
                    <input type="submit" value="Ingresar" class="btn btn-primary">
                </form><br>
                <p><a href="create.php">Crear nuevo usuario</a></p>
            </div>

        </div>
     
    </body>
</html>
