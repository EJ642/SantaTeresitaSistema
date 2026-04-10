<?php 
    // DEFINIMOS LA RUTA RELATIVA (Importante: antes de los includes)
    $ruta = "../";

    // 1. Incluimos el header
    include "../includes/header.php"; 
    
    // 2. Incluimos la conexión
    require_once "../servicios/conexion.php";

    // 3. Consulta SQL — JOIN con tabla rol para obtener el nombre del rol
    $sql = "SELECT u.idUsuario, u.usuario, u.correo, u.idRol, r.rol, u.estado 
            FROM usuarios u 
            INNER JOIN rol r ON u.idRol = r.idRol";
    $lista_usuarios = buscar_datos($sql);

    // 4. Traemos los roles para los selects
    $sql_roles = "SELECT idRol, rol FROM rol";
    $lista_roles = buscar_datos($sql_roles);
?>

<link rel="stylesheet" href="<?php echo $ruta; ?>dt/dataTables.bootstrap5.min.css"/>

<div class="main-content">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro">
            <i class="bi bi-person-plus-fill"></i> Nuevo Usuario
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="tblUsuarios" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($lista_usuarios){
                            foreach ($lista_usuarios as $dato) {
                                $estadoColor = ($dato['estado'] == 'Activo') ? 'success' : 'danger';
                        ?>
                            <tr>
                                <td><?php echo $dato['idUsuario']; ?></td>
                                <td><?php echo $dato['usuario']; ?></td>
                                <td><?php echo $dato['correo']; ?></td>
                                <td><?php echo $dato['rol']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $estadoColor; ?>">
                                        <?php echo $dato['estado']; ?>
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm btnEditar" 
                                        data-id="<?php echo $dato['idUsuario']; ?>"
                                        data-usuario="<?php echo htmlspecialchars($dato['usuario'], ENT_QUOTES); ?>"
                                        data-correo="<?php echo htmlspecialchars($dato['correo'], ENT_QUOTES); ?>"
                                        data-idrol="<?php echo $dato['idRol']; ?>"
                                        data-rol="<?php echo htmlspecialchars($dato['rol'], ENT_QUOTES); ?>"
                                        data-estado="<?php echo $dato['estado']; ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btnEliminar" 
                                        data-id="<?php echo $dato['idUsuario']; ?>"
                                        data-usuario="<?php echo htmlspecialchars($dato['usuario'], ENT_QUOTES); ?>"
                                        data-correo="<?php echo htmlspecialchars($dato['correo'], ENT_QUOTES); ?>"
                                        data-rol="<?php echo htmlspecialchars($dato['rol'], ENT_QUOTES); ?>"
                                        data-estado="<?php echo $dato['estado']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php 
                            }
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- MODAL NUEVO USUARIO -->
<div class="modal fade" id="modalRegistro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Nuevo Usuario</h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        
        <form action="usuarios_guardar.php" method="POST" id="formUsuario">
            
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Ej: juan.perez" required>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="correo" id="correo" placeholder="ejemplo@correo.com" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="clave" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="clave" id="clave" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="confirmar_clave" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" name="confirmar_clave" id="confirmar_clave" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="idRol" class="form-label">Rol de Usuario</label>
                <select class="form-select" name="idRol" id="idRol" required>
                    <option value="" selected disabled>Seleccione una opción...</option>
                    <?php if($lista_roles): foreach($lista_roles as $rol): ?>
                    <option value="<?php echo $rol['idRol']; ?>"><?php echo $rol['rol']; ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle-fill"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Guardar
                </button>
            </div>

        </form>
      </div>

    </div>
  </div>
</div>
<!-- FIN NUEVO USUARIO -->


<!-- MODAL MODIFICAR USUARIO -->
<div class="modal fade" id="modalEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header bg-warning text-dark">
        <h1 class="modal-title fs-5">Editar Usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <form id="formEditarUsuario">
            
            <input type="hidden" name="id_usuario" id="id_edit">

            <div class="mb-3">
                <label for="usuario_edit" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" name="usuario" id="usuario_edit" required>
            </div>

            <div class="mb-3">
                <label for="correo_edit" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="correo" id="correo_edit" required>
            </div>

            <div class="mb-3">
                <label for="clave_edit" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="clave" id="clave_edit" placeholder="Dejar vacío si no desea cambiarla">
                <div class="form-text text-muted">Solo escribe aquí si quieres cambiar la contraseña actual.</div>
            </div>

            <div class="mb-3">
                <label for="idRol_edit" class="form-label">Rol de Usuario</label>
                <select class="form-select" name="idRol" id="idRol_edit" required>
                    <?php if($lista_roles): foreach($lista_roles as $rol): ?>
                    <option value="<?php echo $rol['idRol']; ?>"><?php echo $rol['rol']; ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="estado_edit" class="form-label">Estado</label>
                <select class="form-select" name="estado" id="estado_edit" required>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Actualizar</button>
            </div>

        </form>
      </div>

    </div>
  </div>
</div>
<!-- FIN MODIFICAR USUARIO -->


<!-- MODAL ELIMINAR USUARIO -->
<div class="modal fade" id="modalEliminar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
        <div class="modal-header bg-danger text-white">
            <h1 class="modal-title fs-5">Eliminar Usuario</h1>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
            <p class="text-danger fw-bold">¿Estás seguro de que deseas eliminar este registro?</p>
            
            <form id="formEliminarUsuario">
                
                <input type="hidden" name="id_usuario" id="id_delete">

                <div class="mb-3">
                    <label class="form-label">Nombre de Usuario</label>
                    <input type="text" class="form-control bg-light" id="usuario_delete" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control bg-light" id="correo_delete" readonly>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Rol</label>
                        <input type="text" class="form-control bg-light" id="rol_delete" readonly>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Estado</label>
                        <input type="text" class="form-control bg-light" id="estado_delete" readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i> Eliminar</button>
                </div>

            </form>
        </div>

        </div>
    </div>
</div>
<!-- FIN ELIMINAR USUARIO -->

<?php include "../includes/footer.php"; ?>

<script src="<?php echo $ruta; ?>/dt/jquery-3.7.0.js"></script>
<script src="<?php echo $ruta; ?>/dt/jquery.dataTables.min.js"></script>
<script src="<?php echo $ruta; ?>/dt/dataTables.bootstrap5.min.js"></script>

<script src="<?php echo $ruta; ?>/dt/botones/jszip.min.js"></script>
<script src="<?php echo $ruta; ?>/dt/botones/pdfmake.min.js"></script>
<script src="<?php echo $ruta; ?>/dt/botones/vfs_fonts.js"></script>

<script src="<?php echo $ruta; ?>/dt/botones/dataTables.buttons.min.js"></script>
<script src="<?php echo $ruta; ?>/dt/botones/buttons.bootstrap5.min.js"></script>
<script src="<?php echo $ruta; ?>/dt/botones/buttons.html5.min.js"></script>
<script src="<?php echo $ruta; ?>/dt/botones/buttons.print.min.js"></script>

<script>
    // 1. Configuración de DataTables
    $(document).ready(function() {
        $('#tblUsuarios').DataTable({
            "language": {
                "url": "<?php echo $ruta; ?>dt/es-ES.json"
            },
            responsive: "true",
            dom: 'Bfrtip',
            "pageLength": 5,
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-earmark-excel"></i> ',
                    titleAttr: 'Exportar a Excel',
                    className: 'btn btn-success',
                    title: 'Lista de Usuarios',
                    filename: 'Reporte_Usuarios',
                    exportOptions: { columns: [ 0, 1, 2, 3, 4 ] }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bi bi-file-earmark-pdf"></i> ',
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger',
                    title: 'Lista de Usuarios',
                    filename: 'Reporte_Usuarios',
                    exportOptions: { columns: [ 0, 1, 2, 3, 4 ] },
                    orientation: 'portrait',
                    pageSize: 'A4',
                    customize: function (doc) {
                        // Calcular el ancho máximo de cada columna según su contenido
                        var body = doc.content[1].table.body;
                        var columnCount = body[0].length;
                        var columnWidths = [];

                        // Definir anchos relativos por columna (ajusta estos valores según tus datos)
                        var widthMap = {
                            0: 'auto',  // Columna 0 (ej: ID) → ancho mínimo
                            1: '*',     // Columna 1 (ej: Nombre) → flexible
                            2: '*',     // Columna 2 (ej: Email) → flexible
                            3: 'auto',  // Columna 3 (ej: Rol) → ancho mínimo
                            4: 'auto'   // Columna 4 (ej: Estado) → ancho mínimo
                        };

                        for (var i = 0; i < columnCount; i++) {
                            columnWidths.push(widthMap[i] !== undefined ? widthMap[i] : 'auto');
                        }

                        doc.content[1].table.widths = columnWidths;

                        // Estilos opcionales para mejorar la legibilidad
                        doc.styles.tableHeader.fontSize = 10;
                        doc.defaultStyle.fontSize = 9;
                        doc.defaultStyle.alignment = 'left';
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="bi bi-printer"></i> ',
                    titleAttr: 'Imprimir',
                    className: 'btn btn-info',
                    title: 'Lista de Usuarios',
                    exportOptions: { columns: [ 0, 1, 2, 3, 4 ] }
                }
            ],
            "columnDefs": [
                { "orderable": false, "targets": 5 }
            ]
        });
    });

    // 2. LÓGICA DE GUARDADO CON AJAX
    document.getElementById('formUsuario').addEventListener('submit', function(e) {
        e.preventDefault(); 

        var usuario = document.getElementById('usuario').value;
        var correo = document.getElementById('correo').value;
        var clave = document.getElementById('clave').value;
        var confirmacion = document.getElementById('confirmar_clave').value;
        var idRol = document.getElementById('idRol').value;

        if (usuario == '' || correo == '' || clave == '' || idRol == '') {
            alertify.error("Todos los campos son obligatorios.");
            return;
        }

        if (clave != confirmacion) {
            alertify.error("Las contraseñas no coinciden.");
            document.getElementById('confirmar_clave').value = '';
            document.getElementById('confirmar_clave').focus();
            return;
        }

        var formData = new FormData(document.getElementById('formUsuario'));

        fetch('usuarios_guardar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === true) {
                alertify.success(data.msg);
                setTimeout(function(){ window.location.reload(); }, 500);
            } else {
                alertify.error(data.msg);
                if(data.msg.toLowerCase().includes("correo")) {
                    var inputCorreo = document.getElementById('correo');
                    inputCorreo.focus();
                    inputCorreo.select();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alertify.error("Error en la comunicación con el servidor.");
        });
    });

    // 3. EVENTOS DEL MODAL NUEVO (limpiar y enfocar al abrir)
    var myModalEl = document.getElementById('modalRegistro');
    
    myModalEl.addEventListener('show.bs.modal', function (event) {
        document.getElementById('formUsuario').reset();
    });

    myModalEl.addEventListener('shown.bs.modal', function (event) {
        document.getElementById('usuario').focus();
    });

    // --- PARTE A: LLENAR EL MODAL DE EDICIÓN Y ABRIRLO ---
    const tabla = document.getElementById('tblUsuarios');
    
    tabla.addEventListener('click', function(e) {
        const boton = e.target.closest('.btnEditar');

        if (boton) {
            const id = boton.getAttribute('data-id');
            const usuario = boton.getAttribute('data-usuario');
            const correo = boton.getAttribute('data-correo');
            const idRol = boton.getAttribute('data-idrol');
            const estado = boton.getAttribute('data-estado');

            // 1. Llenamos los campos PRIMERO
            document.getElementById('id_edit').value = id;
            document.getElementById('usuario_edit').value = usuario;
            document.getElementById('correo_edit').value = correo;
            document.getElementById('idRol_edit').value = idRol;
            document.getElementById('estado_edit').value = estado;
            document.getElementById('clave_edit').value = '';

        }
    });

    // --- PARTE B: GUARDAR LOS CAMBIOS ---
    document.getElementById('formEditarUsuario').addEventListener('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(document.getElementById('formEditarUsuario'));

        fetch('usuarios_actualizar.php', { 
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === true) {
                alertify.success(data.msg);
                setTimeout(function(){ window.location.reload(); }, 800);
            } else {
                alertify.error(data.msg);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alertify.error("Error en la comunicación con el servidor.");
        });
    });

    // --- ELIMINAR USUARIO ---
    // 1. LLENAR EL MODAL DE ELIMINACIÓN Y ABRIRLO
    tabla.addEventListener('click', function(e) {
        const boton = e.target.closest('.btnEliminar');

        if (boton) {
            const id = boton.getAttribute('data-id');
            const usuario = boton.getAttribute('data-usuario');
            const correo = boton.getAttribute('data-correo');
            const rol = boton.getAttribute('data-rol');
            const estado = boton.getAttribute('data-estado');

            // 1. Llenamos los campos PRIMERO
            document.getElementById('id_delete').value = id;
            document.getElementById('usuario_delete').value = usuario;
            document.getElementById('correo_delete').value = correo;
            document.getElementById('rol_delete').value = rol;
            document.getElementById('estado_delete').value = estado;

            // 2. Abrimos el modal DESPUÉS
            var modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
            modal.show();
        }
    });

    // 2. CONFIRMAR Y ENVIAR ELIMINACIÓN
    document.getElementById('formEliminarUsuario').addEventListener('submit', function(e) {
        e.preventDefault();

        alertify.confirm("Eliminar Usuario", "¿Está seguro que desea eliminar este registro permanentemente?",
            function() {
                var formData = new FormData(document.getElementById('formEliminarUsuario'));
                fetch('usuarios_eliminar.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === true) {
                        alertify.success(data.msg);
                        setTimeout(function(){ window.location.reload(); }, 500);
                    } else {
                        alertify.error(data.msg);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alertify.error("Error en el servidor.");
                });
            },
            function() {
                alertify.error('Cancelado');
            }
        ).set('labels', {ok:'Sí, Eliminar', cancel:'Cancelar'});
    });
</script>
