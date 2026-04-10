<?php include "includes/header.php"; ?>

    <h1 class="mx-auto mt-4">Bienvenido al Sistema</h1>
    <p>Hola, <strong><?php echo $_SESSION['usuario']; ?></strong>. Has ingresado como <strong><?php echo $_SESSION['rol']; ?>   </strong>.</p>
    

<?php include "includes/footer.php"; ?>