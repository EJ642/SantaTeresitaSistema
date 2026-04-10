<?php
     // Configuración de la base de datos
     define("DB_HOST", "localhost");
     define("DB_USER", "root");
     define("DB_PASS", "");
     define("DB_NAME", "escuela");
     define("DB_CHARSET", "utf8");

     // 1. Función de CONEXIÓN
     function conectar_bd() {
     $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

     if ($conexion->connect_error) {
          die("Error de conexión: " . $conexion->connect_error);
     }

     $conexion->set_charset(DB_CHARSET);
          return $conexion;
     }

     // 2. Función para LIMPIAR DATOS (Seguridad Anti-Inyección SQL básica)
     function limpiar_cadena($str) {
          $conexion = conectar_bd();
          $str = trim($str);
          $str = stripslashes($str);
          $str = mysqli_real_escape_string($conexion, $str);
          $conexion->close();
          return $str;
     }

     // 3. Función para BÚSQUEDAS (SELECT)
     // Retorna un array con los datos o false si no hay resultados
     function buscar_datos($sql) {
          $conexion = conectar_bd();
          $resultado = $conexion->query($sql);
          $datos = array();

          if ($resultado && $resultado->num_rows > 0) {
               // Si esperamos una sola fila o varias, esto siempre devuelve un array
               while ($row = $resultado->fetch_assoc()) {
                    $datos[] = $row;
               }
               $conexion->close();
               return $datos;
          } else {
               $conexion->close();
               return false;
          }
     }

     // 4. Función para INSERTAR (INSERT)
     // Retorna el ID del último registro insertado o false si falla
     function insertar_datos($sql) {
          $conexion = conectar_bd();
          if ($conexion->query($sql)) {
               $last_id = $conexion->insert_id;
               $conexion->close();
               return $last_id;
          } else {
               $conexion->close();
               return false;
          }
     }

     // 5. Función para ACTUALIZAR (UPDATE)
     // Retorna true si fue exitoso
     function actualizar_datos($sql) {
          $conexion = conectar_bd();
          if ($conexion->query($sql)) {
               $conexion->close();
               return true;
          } else {
               $conexion->close();
               return false;
          }
     }

     // 6. Función para ELIMINAR (DELETE)
     // Retorna true si fue exitoso
     function eliminar_datos($sql) {
     $conexion = conectar_bd();
          if ($conexion->query($sql)) {
               $conexion->close();
               return true;
          } else {
               $conexion->close();
               return false;
          }
     }

?>