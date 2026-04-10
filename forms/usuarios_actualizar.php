<?php
     require_once "../servicios/conexion.php";

     $response = array('status' => false, 'msg' => '');

     if (!empty($_POST)) {

          $id      = limpiar_cadena($_POST['id_usuario']);
          $usuario = limpiar_cadena($_POST['usuario']);
          $correo  = limpiar_cadena($_POST['correo']);
          $idRol   = limpiar_cadena($_POST['idRol']);
          $estado  = limpiar_cadena($_POST['estado']);
          $clave   = $_POST['clave'];

          if (empty($id) || empty($usuario) || empty($correo) || empty($idRol) || empty($estado)) {
               $response['msg'] = 'Faltan datos obligatorios.';
               echo json_encode($response);
               exit;
          }

          // Verificar que el correo no lo use otro usuario
          $sql_check = "SELECT * FROM usuarios WHERE correo = '$correo' AND idUsuario != $id";
          $existe = buscar_datos($sql_check);

          if ($existe) {
               $response['msg'] = 'El correo ya pertenece a otro usuario.';
          } else {

               if (empty($clave)) {
                    // Sin cambiar contraseña
                    $sql_update = "UPDATE usuarios 
                                   SET usuario = '$usuario', correo = '$correo', idRol = $idRol, estado = '$estado',
                                       modificado = NOW()
                                   WHERE idUsuario = $id";
               } else {
                    // Cambiando contraseña
                    $clave_hash = password_hash($clave, PASSWORD_BCRYPT);
                    $sql_update = "UPDATE usuarios 
                                   SET usuario = '$usuario', correo = '$correo', idRol = $idRol, 
                                       password = '$clave_hash', estado = '$estado', modificado = NOW()
                                   WHERE idUsuario = $id";
               }

               $resultado = actualizar_datos($sql_update);

               if ($resultado) {
                    $response['status'] = true;
                    $response['msg'] = 'Usuario actualizado correctamente.';
               } else {
                    $response['msg'] = 'Error al actualizar en la base de datos.';
               }
          }

     } else {
          $response['msg'] = 'No se recibieron datos.';
     }

     echo json_encode($response);
?>
