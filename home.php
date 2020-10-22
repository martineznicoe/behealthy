<?php
    require_once 'clases/Usuario.php';
    require_once 'clases/Registro.php';
    require_once 'clases/ControladorSesion.php';
    session_start();
    if (isset($_SESSION['usuario'])) {
        $usuario = unserialize($_SESSION['usuario']);
        $nomApe = $usuario->getNombreApellido();
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $fecha = date("Y-m-d");
        $nombre_usuario = $usuario->getUsuario();
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $nacimiento = $usuario->getNacimiento();
        $estatura = $usuario->getEstatura();
        $pesoDeseado = $usuario->getPesoDeseado();
        $genero = $usuario->getGenero();
        
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
                    </div>';
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
        
    
         if (isset($_POST['fecha']) && isset($_POST['peso'])) {
        
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
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>BeHealthy</title>
        <link rel="stylesheet" href="bootstrap.min.css">
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
                      Hola! <b><?=$nomApe?></b>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modificarperfil">Modificar perfil</a>
                        <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                      </div>
                </div>
            </div>
        </div>

        <!-- Tarjetas de info -->
        <div class="row text-center" style="margin-top: 15px;">
            <div class="col">
                <div class="card text-white bg-info " style="max-width: 100%;">
                    <div class="card-header"><h4>PESO ACTUAL</h4></div>
                    <div class="card-body bg-light">
                        <h1 class="text-success card-title">69,5kg</h1>
                        <h6 class="text-secondary card-subtitle">Fecha: 12/10/2020</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-info" style="max-width: 100%;">
                    <div class="card-header"><h4>PESO DESEADO</h4></div>
                    <div class="card-body bg-light">
                        <h1 class="text-success card-title"><?=$pesoDeseado?>kg</h1>
                        <h6 class="text-danger card-subtitle">Te faltan: 4,5kg</h6>
                    </div>
                </div>       
            </div>
        </div>

        <div class="row text-center" style="margin-top: 15px;">
            <div class="col-md-12">
                <div class="card text-white bg-info " style="max-width: 100%;">
                    <div class="card-header"><h4>IMC</h4></div>
                    <div class="card-body bg-light">
                        <h1 class="text-success card-title">23,9</h1>
                        <h6 class="text-secondary card-subtitle">170cm 69,5kg</h6>
                        <h3 class="text-success card-title">Peso Normal</h3>
                    </div>
                </div>
            </div>
        </div>

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
              <tr>
                <td scope="row">15/04/2020</td>
                <td>73kg</td>
                <td class="text-success">-0,5kg</td>
                <td>
                
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminarregistro">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg></button>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editarregistro"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg></button>

                </td>
              </tr>
              <tr>
                <td scope="row">15/04/2020</td>
                <td>73,5kg</td>
                <td class="text-danger">1kg</td>
                <td>

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminarregistro">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg></button>

                <button type="button" class="btn btn-primary"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg></button>

                </td>
              </tr>
              <tr>
                <td scope="row">07/04/2020</td>
                <td>72,5kg</td>
                <td class="text-success">-0,5kg</td>
                <td>

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminarregistro">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg></button>

                <button type="button" class="btn btn-primary"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg></button>

                </td>
              </tr>
              <tr>
                <td scope="row">22/03/2020</td>
                <td>73kg</td>
                <td class="text-success">-2kg</td>
                <td>

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminarregistro">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg></button>

                <button type="button" class="btn btn-primary"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg></button>

                </td>
              </tr>
              <tr>
                <td scope="row">12/03/2020</td>
                <td>75kg</td>
                <td></td>
                <td>

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminarregistro">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg></button>

                <button type="button" class="btn btn-primary"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg></button>

                </td>

              </tr>
            </tbody>
          </table>
        </div>



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
                            <input name="fecha" type="date" class="form-control" value="<?=$fecha?>" readonly>
                          </div>
                          <div class="form-group  col-md-6">
                            <label class="font-weight-bold">Peso Nuevo (kg)</label>
                            <input name="peso" type="number" class="form-control" maxlength="4" placeholder="Ej. 65,5" step="0.01" required>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input type="submit" value="Registrar" class="btn btn-primary">
                      </div>
                  </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Ventana emergente 'Modificar Registro' -->
        <div class="modal fade" id="editarregistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modificar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <div class="modal-body">
                  <form action="home.php" method="post">
                      <div class="form-row">
                          <div class="form-group  col-md-6">
                            <label class="font-weight-bold">Fecha de Registro</label>
                            <input name="nacimiento" type="date" class="form-control" value="<?=$fecha?>" disabled = true>
                          </div>
                          <div class="form-group  col-md-6">
                            <label class="font-weight-bold">Peso Nuevo (kg)</label>
                            <input name="pesodeseado" type="number" class="form-control" maxlength="4" placeholder="Ej. 65,5" step="0.01" required>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <input type="submit" value="Modificar" class="btn btn-primary">
                      </div>
                  </form>
                </div>
            </div>
          </div>
        </div>


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
                                <input name="usuario" type="text" class="form-control" placeholder="Usuario" required value="<?=$nombre_usuario?>">
                            </div>
                            <div class="form-group col-md-6">
                                <input name="clave" type="password" class="form-control" placeholder="Contraseña" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input name="nombre" type="text" class="form-control" placeholder="Nombre" required value="<?=$nombre?>">
                            </div>
                            <div class="form-group  col-md-6">
                                <input name="apellido" type="text" class="form-control" placeholder="Apellido" required value="<?=$apellido?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="font-weight-bold">Género</label>
                                <select name="genero" class="form-control">
                                    <?php 
                                    $opciones_genero=array('Femenino', 'Masculino', 'Prefiero no contestar');
                                    foreach($opciones_genero as $valor){
                                        if ($valor != $genero){
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
                                <input name="nacimiento" type="date" class="form-control" value="<?=$nacimiento?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-bold">Estatura (cm)</label>
                                <input name="estatura" type="number" class="form-control" maxlength="3" placeholder="Ej. 170" required value="<?=$estatura?>">
                            </div>
                            <div class="form-group  col-md-3">
                                <label class="font-weight-bold">Peso deseado (kg)</label>
                                <input name="pesodeseado" type="number" class="form-control" step="0.01" maxlength="4" placeholder="Ej. 65,5" required value="<?=$pesoDeseado?>">
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

        <!-- Ventana emergente 'Eliminar registro' -->
        <div class="modal fade" id="eliminarregistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <h5>¿Esta segúro que desea eliminar el registro?</h5>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Cancelar</button>
                <button type="button" class="btn btn-success" data-dismiss="modal">Confirmar</button>
              </div>
            </div>
          </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
</html>
