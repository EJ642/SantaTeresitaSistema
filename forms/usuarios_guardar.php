<?php
     require_once "../servicios/conexion.php";

     $response = array('status' => false, 'msg' => '');

     if (!empty($_POST)) {

          $usuario = limpiar_cadena($_POST['usuario']);
          $correo  = limpiar_cadena($_POST['correo']);
          $idRol   = limpiar_cadena($_POST['idRol']);
          $clave   = $_POST['clave'];

          if (empty($usuario) || empty($correo) || empty($clave) || empty($idRol)) {
               $response['msg'] = 'Todos los campos son obligatorios.';
               echo json_encode($response);
               exit;
          }

          // Verificar si el correo ya existe
          $sql_verificar = "SELECT * FROM usuarios WHERE correo = '$correo'";
          $existe_usuario = buscar_datos($sql_verificar);

          if ($existe_usuario) {
               $response['msg'] = 'El correo electrónico ya existe.';
          } else {
               $clave_hash = password_hash($clave, PASSWORD_BCRYPT);

               $sql_insert = "INSERT INTO usuarios (usuario, password, estado, correo, idRol) 
                              VALUES ('$usuario', '$clave_hash', 'Activo', '$correo', $idRol)";

               $resultado = insertar_datos($sql_insert);

               if ($resultado) {
                    $response['status'] = true;
                    $response['msg'] = 'Usuario creado correctamente.';
               } else {
                    $response['msg'] = 'Error al guardar en la base de datos.';
               }
          }

     } else {
          $response['msg'] = 'No se recibieron datos.';
     }

     echo json_encode($response);
?>
