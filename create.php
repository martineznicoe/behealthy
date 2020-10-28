<?php
require_once 'clases/ControladorSesion.php';
if (isset($_POST['usuario']) && isset($_POST['clave'])) {
    $cs = new ControladorSesion();
    $result = $cs->create($_POST['usuario'], $_POST['clave'], 
                          $_POST['nombre'], $_POST['apellido'],
                          $_POST['genero'], $_POST['nacimiento'],
                          $_POST['estatura'], $_POST['pesodeseado']);
    if( $result[0] === true ) {
        $redirigir = 'home.php?mensaje='.$result[1];
    }
    else {
        $redirigir = 'create.php?mensaje='.$result[1];
    }
    header('Location: ' . $redirigir);
}
?>
<!DOCTYPE html> 
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>BeHealthy</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="icon" href="ima/logo1.png" type="image/png"/>
    </head>
    <body class="container text-center" style="margin-top: 20px;">
        <div class="row text-center">
            <div class="col-12">
                <img src="ima/logo1.svg" style="width: 200px;">
            </div>
            <div class="col-12">
                <h2>Crear nuevo usuario</h2>
                <br>
            </div>
            <div class="col-12">
                <?php
                    if (isset($_GET['mensaje'])) {
                        echo '<div id="mensaje" class="alert alert-primary text-center">
                            <p>'.$_GET['mensaje'].'</p></div>';
                    }
                ?>
            </div>

            <!-- Formulario de Registro -->
            <div class="col-12">
                <form action="create.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input name="usuario" type="text" class="form-control" placeholder="Usuario" required>
                        </div>
                        <div class="form-group col-md-6">
                            <input name="clave" type="password" class="form-control" placeholder="Contraseña" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input name="nombre" type="text" class="form-control" placeholder="Nombre" required>
                        </div>
                        <div class="form-group  col-md-6">
                            <input name="apellido" type="text" class="form-control" placeholder="Apellido" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="font-weight-bold">Género</label>
                            <select name="genero" class="form-control">
                                <option selected>Elegir...</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Masculino">Masculino</option>
                                <option value="None">Prefiero no contestar</option>
                            </select>
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="font-weight-bold">Fecha de Nacimiento</label>
                            <input name="nacimiento" type="date" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="font-weight-bold">Estatura (cm)</label>
                            <input name="estatura" type="number" class="form-control" maxlength="3" placeholder="Ej. 170" required>
                        </div>
                        <div class="form-group  col-md-3">
                            <label class="font-weight-bold">Peso deseado (kg)</label>
                            <input name="pesodeseado" type="number" class="form-control" step="0.01" maxlength="4" placeholder="Ej. 65,5" required>
                        </div>
                    </div>
                    <div class="form-row text-center">
                        <div class="col text-md-right">
                            <a class="btn btn-secondary" href="index.php">Volver a Login</a>
                            <input type="submit" value="Registrarse" class="btn btn-primary">
                        </div>
                    </div>
                </form>

            </div>
            
        </div>
    </body>
</html>
