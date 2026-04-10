<?php
     require_once "../servicios/conexion.php";

     $response = array('status' => false, 'msg' => '');

     if (!empty($_POST)) {

          $id = limpiar_cadena($_POST['id_usuario']);

          if (empty($id)) {
               $response['msg'] = 'Error: Identificador no válido.';
               echo json_encode($response);
               exit;
          }

          $sql_delete = "DELETE FROM usuarios WHERE idUsuario = $id";
          $resultado = eliminar_datos($sql_delete);

          if ($resultado) {
               $response['status'] = true;
               $response['msg'] = 'Usuario eliminado correctamente.';
          } else {
               $response['msg'] = 'Error al eliminar el registro.';
          }

     } else {
          $response['msg'] = 'No se recibieron datos.';
     }

     echo json_encode($response);
?>
