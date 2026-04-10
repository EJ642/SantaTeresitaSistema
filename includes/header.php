<?php
    // Ruta base del proyecto
    $base_url = "/IGS_2/";

    session_start();
    if (!isset($ruta)) { $ruta = ""; }

    // Seguridad
    if (empty($_SESSION['active'])) {
        header('location: '.$ruta.'index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Administración</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- CSS PROPIO -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/styles.css">

    <!-- Alertify -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>alertify/alertify.min.css"/>
    <link rel="stylesheet" href="<?php echo $base_url; ?>alertify/themes/default.min.css"/>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="sidebar" id="sidebar">

        <?php include "nav.php"; ?>

        <div class="footer">
            <ul class="menu">
                <li class="menu-item"><a href="#" class="menu-link"><i class='bx bx-cog'></i> Configuración</a></li>
            </ul>
            <div class="user">
                <div class="user-img">
                    <img src="img/fondo-exmpl.jpg" alt="">
                </div>
                <div class="user-data">
                    <span class="name"><?php echo $_SESSION['usuario']; ?></span>
                    <span class="rol">Admin</span>
                </div>
                <div class="user-icon exit-btn" id="exit-btn">
                    <i class="bx bx-exit"></i>
                </div>
            </div>
        </div>
    </div>
        