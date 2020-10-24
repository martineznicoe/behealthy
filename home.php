<?php
    require_once 'clases/Usuario.php';
    require_once 'clases/Registro.php';
    require_once 'clases/ControladorSesion.php';
    session_start();
    /*Se verifica que la sesion de usuario este iniciado*/
    if (isset($_SESSION['usuario'])) {
        $usuario = unserialize($_SESSION['usuario']);
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $cs = new ControladorSesion();
                
        /* Verifica que los campos usuario y clave del formulario "Modificar Perfil" esten completados
           y llama a la función actualizar del ControladorSesion para guardar los datos que llegan por POST*/
        if (isset($_POST['usuario']) && isset($_POST['clave'])) {
          $cs = new ControladorSesion();
          $result = $cs->actualizar($_POST['usuario'], $_POST['clave'], 
                                $_POST['nombre'], $_POST['apellido'],
                                $_POST['genero'], $_POST['nacimiento'],
                                $_POST['estatura'], $_POST['pesodeseado'], $usuario->getId());

          if($result[0] === true ) {
              echo '<div id="mensaje" class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>'.$result[1].'</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    </div>;';
          }
          else{
              echo '<div id="mensaje" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p>'.$result[1].'</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
          }
        }
        
        /* Verifica que los campos fecha y peso del formulario Registrar Peso esten completados
           y llama a la función registrar del ControladorSesion para guardar los datos que llegan por POST*/
        if (isset($_POST['fecha']) && isset($_POST['peso'])) {
          $tabla = $cs->getRegistros($usuario->getId());

          if (isset($tabla[0][1])){
         
              if ($fecha = date("d-m-Y") != $fechaNueva = date_format(date_create($tabla[0][1]),'d-m-Y')){

                  $cs2 = new ControladorSesion();
                  $result2 = $cs2->registrar($_POST['fecha'], $_POST['peso'], $usuario->getId());

                  if($result2[0] === true ) {
                    echo '<div id="mensaje" class="alert alert-success alert-dismissible fade show" role="alert">
                          <p>'.$result2[1].'</p>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          </div>';
                  }
                  else{
                      echo '<div id="mensaje" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <p>'.$result2[1].'</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                  }
              } else{
                    echo '<div id="mensaje" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p>Ya existe un peso registrado hoy</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
              }
          }else{
              $cs2 = new ControladorSesion();
                    $result2 = $cs2->registrar($_POST['fecha'], $_POST['peso'], $usuario->getId());

                    if($result2[0] === true ) {
                      echo '<div id="mensaje" class="alert alert-success alert-dismissible fade show" role="alert">
                            <p>'.$result2[1].'</p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                    }
                    else{
                        echo '<div id="mensaje" class="alert alert-danger alert-dismissible fade show" role="alert">
                              <p>'.$result2[1].'</p>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                              </div>';
                    }
          }
        }
        $tabla = $cs->getRegistros($usuario->getId());
      }
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>BeHealthy</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" rel="stylesheet">
    </head>

    <body class="container text-center ">
        <!-- Barra de navegación -->
        <div class="row navbar bg-light">
            <div class="col-md-4 ">
                <img class="" src="ima/logo2.svg">
            </div>
            <div class="col-md-8 text-right">
                <button typy="button" class="btn btn-primary" data-toggle="modal" data-target="#registrarpeso">Registrar Peso </button>
                <div class="btn-group" role="group">
                      <button id="btnGroupDrop1" type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Hola! <b><?=$usuario->getNombreApellido()?></b>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modificarperfil">Modificar perfil</a>
                        <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                      </div>
                </div>
            </div>
        </div>
        <!-- FIN Barra de navegación -->

        <!-- Tarjetas de info -->
        <div class="row text-center" style="margin-top: 15px;">
            <div class="col">
                <div class="card text-white bg-info " style="max-width: 100%;">
                    <div class="card-header"><h4>PESO ACTUAL</h4></div>
                    <div class="card-body bg-light">
                        <h1 class="text-success card-title"><?php 
                        if (isset($tabla[0][2])){
                          echo $tabla[0][2].' kg'; 
                        } else {
                          echo "Sin Definir";
                        }
                          
                        ?></h1>
                        <h6 class="text-secondary card-subtitle">Fecha: <?php
                        if (isset($tabla[0][1])){
                          echo $fechaNueva = date_format(date_create($tabla[0][1]),'d-m-Y');
                        } else {
                          echo "Sin Definir";
                        }
                        ?></h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-info" style="max-width: 100%;">
                    <div class="card-header"><h4>PESO DESEADO</h4></div>
                    <div class="card-body bg-light">
                        <h1 class="text-success card-title"><?=$usuario->getPesoDeseado()?>kg</h1>
                        <h6 class="text-danger card-subtitle">Te faltan: <?php
                        if(isset($tabla[0][2])){
                          echo ($tabla[0][2]-$usuario->getPesoDeseado()). ' kg';
                        } else {
                          echo "Sin Definir";
                        }?></h6>
                    </div>
                </div>       
            </div>
        </div>

        <div class="row text-center" style="margin-top: 15px;">
            <div class="col-md-12">
                <div class="card text-white bg-info " style="max-width: 100%;">
                    <div class="card-header"><h4>IMC</h4></div>
                    <div class="card-body bg-light">
                        <h1 class="text-success card-title"><?php
                        if (isset($tabla[0][2])){
                          echo $imc=round((($tabla[0][2]/($usuario->getEstatura()*$usuario->getEstatura()))*10000),1);
                        } else{
                          echo "Sin Definir";
                        }
                        ?></h1>
                        <h6 class="text-secondary card-subtitle"><?php
                        if (isset($tabla[0][2])){
                          echo $usuario->getEstatura()."cm";
                        }
                        ?> 
                        <?php
                        if (isset($tabla[0][2])){
                          echo $tabla[0][2].' kg';
                        }else{
                          echo "Sin definir";
                        }
                        ?></h6>
                        <h3 class="text-success card-title"><?php
                        if (isset($imc)){
                          if ($imc<16) { $escala="DELGADES SEVERA";}
                          if (($imc>=16)&&($imc<17) ){ $escala="DELGADEZ MODERADA";}
                          if (($imc>=17)&&($imc<18.5) ){ $escala="DELGADEZ ACEPTABLE";}                        
                          if (($imc>=18.5)&&($imc<25) ){ $escala="NORMAL";}                        
                          if (($imc>=25)&&($imc<30) ){ $escala="PRE-OBESO";}            
                          if (($imc>=30)&&($imc<35) ){ $escala="OBESO TIPO 1";}
                          if (($imc>=35)&&($imc<40) ){ $escala="OBESO TIPO 2";}
                          if ($imc>=40){ $escala="OBESO TIPO 3";}
                          echo $escala;
                        }else{
                          echo "Sin Definir";
                        }
                        ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN Tarjetas de info -->

        <!-- Tabla -->
        <div class="row text-center font-weight-bold" style="margin: 15px 0px;">
          <table class="table table-sm text-center">
            <thead>
              <tr class="bg-info text-light">
                <th scope="col">FECHA</th>
                <th scope="col">PESO</th>
                <th scope="col">DIFERENCIA</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
                  <?php 
                  $diferencia = [];
                  for($i=1;$i<count($tabla);$i++){
                    array_push($diferencia, $tabla[$i-1][2]-$tabla[$i][2]);
                  }
                  array_push($diferencia, 0);

                  for($i=0; $i<count($tabla); $i++){
                      echo '<tr>';
                      echo '<td>'.date_format(date_create($tabla[$i][1]), 'd-m-Y').'</td>';
                      echo '<td>'.$tabla[$i][2].' kg</td>';
                      echo '<td>'.$diferencia[$i].' kg</td>';
                      echo '</tr>';
                  }
                ?>
            </tbody>
          </table>
        </div>
        <!-- FIN Tabla -->



        <!-- Ventana emergente 'Registrar Peso' -->
        <div class="modal fade" id="registrarpeso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Peso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <form action="home.php" method="post">
                      <div class="form-row">
                          <div class="form-group  col-md-6">
                            <label class="font-weight-bold">Fecha Actual</label>
                            <input name="fecha" type="date" class="form-control" value="<?=$fecha=date("Y-m-d")?>" readonly>
                          </div>
                          <div class="form-group  col-md-6">
                            <label class="font-weight-bold">Peso Nuevo (kg)</label>
                            <input name="peso" type="number" class="form-control" maxlength="4" placeholder="Ej. 65,5" step="0.01" required>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input type="submit" value="Registrar" class="btn btn-primary" >
                      </div>
                  </form>  
              </div>
            </div>
          </div>
        </div>
        <!-- FIN Ventana emergente 'Registrar Peso' -->

        <!-- Ventana emergente 'Modificar Perfil' -->
        <div class="modal fade" id="modificarperfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modificar Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <form action="home.php" method="post">
                      <div class="form-row">
                            <div class="form-group col-md-6">
                                <input name="usuario" type="text" class="form-control" placeholder="Usuario" required value="<?=$usuario->getUsuario()?>">
                            </div>
                            <div class="form-group col-md-6">
                                <input name="clave" type="password" class="form-control" placeholder="Contraseña" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input name="nombre" type="text" class="form-control" placeholder="Nombre" required value="<?=$usuario->getNombre()?>">
                            </div>
                            <div class="form-group  col-md-6">
                                <input name="apellido" type="text" class="form-control" placeholder="Apellido" required value="<?=$usuario->getApellido()?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="font-weight-bold">Género</label>
                                <select name="genero" class="form-control">
                                    <?php 
                                    $opciones_genero=array('Femenino', 'Masculino', 'Prefiero no contestar');
                                    foreach($opciones_genero as $valor){
                                        if ($valor != $usuario->getGenero()){
                                          echo "<option value=".$valor.">".$valor."</option>";
                                        }
                                        else{
                                          echo "<option selected value=".$valor.">".$valor."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group  col-md-3">
                                <label class="font-weight-bold">Fecha de Nacimiento</label>
                                <input name="nacimiento" type="date" class="form-control" value="<?=$usuario->getNacimiento()?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-bold">Estatura (cm)</label>
                                <input name="estatura" type="number" class="form-control" maxlength="3" placeholder="Ej. 170" required value="<?=$usuario->getEstatura()?>">
                            </div>
                            <div class="form-group  col-md-3">
                                <label class="font-weight-bold">Peso deseado (kg)</label>
                                <input name="pesodeseado" type="number" class="form-control" step="0.01" maxlength="4" placeholder="Ej. 65,5" required value="<?=$usuario->getPesoDeseado()?>">
                            </div>
                        </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <input type="submit" value="Guardar cambios" class="btn btn-primary">
                    </div>
                  </form>
              </div>
            </div>
          </div>
        </div>
        <!-- FIN Ventana emergente 'Modificar Perfil' -->                              
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
</html>
