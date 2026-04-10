<?php
session_start();

// Configuración
define('SESSION_TIMEOUT', 15); // 15 minutos en segundos (ajusta según necesites)
define('TOKEN_LENGTH', 32);

// Generar token seguro
function generarToken() {
    return bin2hex(random_bytes(TOKEN_LENGTH));
}

// Verificar si la sesión es válida
function verificarSesion() {
    // Verificar si existe sesión activa
    if (!isset($_SESSION['usuario_id'])) {
        return false;
    }

    // Verificar si el token existe
    if (!isset($_SESSION['token'])) {
        return false;
    }

    // Verificar si ha expirado por inactividad
    if (isset($_SESSION['ultimo_acceso'])) {
        $tiempoInactivo = time() - $_SESSION['ultimo_acceso'];
        
        if ($tiempoInactivo > SESSION_TIMEOUT) {
            // Session expiró por inactividad
            destruirSesion();
            return false;
        }
    }

    // Actualizar último acceso
    $_SESSION['ultimo_acceso'] = time();
    
    return true;
}

// Destruir la sesión completamente
function destruirSesion() {
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
}

// Crear sesión de usuario (llamar al hacer login)
function crearSesion($usuario_id, $usuario, $rol) {
    $_SESSION['usuario_id'] = $usuario_id;
    $_SESSION['usuario'] = $usuario;
    $_SESSION['rol'] = $rol;
    $_SESSION['token'] = generarToken();
    $_SESSION['ultimo_acceso'] = time();
    $_SESSION['hora_inicio'] = time();
    $_SESSION['active'] = true;
}

// Para verificar en cada página (excepto login, index y salir)
if (basename($_SERVER['PHP_SELF']) !== 'login.php' && basename($_SERVER['PHP_SELF']) !== 'index.php' && basename($_SERVER['PHP_SELF']) !== 'salir.php') {
    if (!verificarSesion()) {
        destruirSesion();
        header("Location: index.php?error=sesion_expirada");
        exit();
    }
}

$ruta = "./";
?>
