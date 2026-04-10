<?php
session_start();

// Verificar que sea una petición POST y que tenga token válido
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

$input = json_decode(file_get_contents('php://input'), true);
$token_recibido = $input['token'] ?? '';

if (empty($token_recibido) || !isset($_SESSION['token']) || $_SESSION['token'] !== $token_recibido) {
    http_response_code(401);
    exit('Token inválido');
}

// Regenerar token
$nuevo_token = bin2hex(random_bytes(32));
$_SESSION['token'] = $nuevo_token;

// Responder con el nuevo token
header('Content-Type: application/json');
echo json_encode(['success' => true, 'new_token' => $nuevo_token]);
?>