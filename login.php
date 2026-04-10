<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/servicios/conexion.php';



// Determine if request is AJAX
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$usuario = isset($_POST['usuario']) ? limpiar_cadena($_POST['usuario']) : '';
$password = isset($_POST['password']) ? limpiar_cadena($_POST['password']) : '';

if ($usuario === '' || $password === '') {
    if ($isAjax) {
        echo json_encode(['success' => false, 'message' => 'Debe completar usuario y contraseña.']);
        exit;
    }
    header('Location: index.php?error=1');
    exit;
}

$datos = buscar_datos("SELECT * FROM usuarios u 
JOIN rol r ON u.idRol = r.idRol
WHERE u.usuario = '" . $usuario . "'");

if ($datos !== false && count($datos) > 0) {
    $user = $datos[0];
    $passwordStored = $user['password'];
    if (password_verify($password, $passwordStored) || $passwordStored === $password) {
        // Generar token único de sesión
        $token = bin2hex(random_bytes(32));
        
        $_SESSION['active'] = true;
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['rol'] = $user['rol'];
        $_SESSION['usuario_id'] = $user['idUsuario'] ?? $user['usuario'];
        $_SESSION['token'] = $token;
        $_SESSION['login_time'] = time(); 
        
        if ($isAjax) {
            echo json_encode(['success' => true, 'redirect' => 'menu.php']);
            exit;
        }
        header('Location: menu.php');
        exit;
    }
}

if ($isAjax) {
    echo json_encode(['success' => false, 'message' => '!Credenciales incorrectas!']);
    exit;
}

header('Location: index.php?error=1');
exit;

?>
