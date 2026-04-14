<?php require "views/templates/header.php"; ?>
<?php require "views/templates/nav.php"; ?>

<style>
    /* Estilo exclusivo para exportar a PDF (oculta lo innecesario) */
    @media print {
        body {
            margin: 0;
            padding: 0;
            background-color: white;
        }

        #conten,
        .navbar,
        .btn,
        footer,
        hr,
        .ocultar-impresion {
            display: none !important;
        }

        .table {
            width: 100% !important;
            color: black !important;
        }

        .table-dark {
            background-color: transparent !important;
        }

        .table-dark th,
        .table-dark td {
            color: black !important;
            border: 1px solid #ccc !important;
        }

        h1 {
            color: black !important;
        }
    }

    /* Animación creativa para el mensaje de éxito */
    .alerta-animada {
        animation: deslizarYBrillar 0.8s ease-out forwards;
        border-left: 6px solid #198754;
        box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
    }

    @keyframes deslizarYBrillar {
        0% {
            transform: translateY(-30px);
            opacity: 0;
        }

        50% {
            transform: translateY(5px);
            opacity: 1;
        }

        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Animación para el check */
    @keyframes checkPulse {
        0% {
            transform: scale(0.8);
            opacity: 0;
        }
        50% {
            transform: scale(1.2);
            opacity: 1;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Fondo y estilo del área de listado de personas */
    .personas-listado {
        background-color: #f2f9f2;
        padding: 18px;
        border-radius: 14px;
        border: 1px solid #d4e8d4;
    }

    .personas-listado .table {
        background-color: white;
    }

    .personas-listado .table th,
    .personas-listado .table td {
        border-color: #dfe7e2;
    }

    .personas-listado .table-striped>tbody>tr:nth-of-type(odd) {
        background-color: #eef7ed;
    }

    .boton-imprimir-pdf {
        margin-bottom: 16px;
    }

    /* Diseño mejorado para el formulario de persona */
    #conten .card-body {
        background: linear-gradient(180deg, #ffffff 0%, #f8fcf8 100%);
    }

    .form-label {
        font-weight: 600;
        color: #2d3f50;
    }

    .form-control {
        border-radius: 14px;
        border: 1px solid #d6e3d8;
        padding: 1rem .9rem;
        background: #fbfdfb;
        width: 100%;
        min-height: 52px;
        box-sizing: border-box;
    }

    select.form-control {
        min-height: 52px;
        padding-right: 2.5rem;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%236a6f77' d='M2 0L0 2h4z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 10px 10px;
    }

    .form-control:focus {
        border-color: #3f9666;
        box-shadow: 0 0 0 0.2rem rgba(63, 150, 102, 0.12);
    }

    .form-card .badge {
        font-size: 0.85rem;
    }

    .btn-submit {
        min-height: 48px;
        border-radius: 999px;
        font-weight: 600;
        letter-spacing: 0.03em;
    }
</style>

<body>
    <br><br><br>
    <div class="container">

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success alert-dismissible fade show alerta-animada ocultar-impresion mt-3" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa fa-check-circle fa-3x me-3" style="color: #198754; animation: checkPulse 1s ease-in-out;"></i>
                    <div>
                        <h4 class="mb-1">¡Confirmación exitosa!</h4>
                        <p class="mb-0"><?php echo $_SESSION['mensaje']; ?></p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <h1 class="text-center mt-4">Gestion personas</h1>

        <div class="card shadow-sm rounded-4 mb-5" id="conten" style="border:0;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h4 mb-1">Modificar persona</h2>
                        <p class="text-muted mb-0">Utiliza este formulario para editar los datos de la persona seleccionada.</p>
                    </div>
                    <span class="badge bg-warning text-dark py-2 px-3">Edición</span>
                </div>

                <form role="form" action="<?php echo constant('URL'); ?>Main/modificarPersona" method="POST" onsubmit="return confirm('¿Está seguro de realizar esta acción en la base de datos?');">
                    <input type="hidden" name="id" id="idpersona">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre"
                                value="<?php echo isset($this->persona) ? $this->persona->getNombre() : ''; ?>"
                                oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');"
                                title="Solo se permiten letras" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edad" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="edad" name="edad"
                                value="<?php echo isset($this->persona) ? $this->persona->getEdad() : ''; ?>"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                min="18" max="99" title="Debe tener entre 18 y 99 años" required>
                        </div>

                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono"
                                value="<?php echo isset($this->persona) ? $this->persona->getTelefono() : ''; ?>"
                                oninput="this.value = this.value.replace(/[^0-9\-]/g, '');"
                                pattern="[267][0-9]{3}-[0-9]{4}"
                                title="Ingrese un teléfono válido iniciando con 2, 6 o 7 (formato: 0000-0000)" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sexo" class="form-label">Sexo</label>
                            <select name="sexo" id="sexo" class="form-control" required>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="ocupacion" class="form-label">Ocupación</label>
                            <select name="ocupacion" id="ocupacion" class="form-control" required>
                                <?php foreach ($this->listaOcupaciones as $lista): ?>
                                    <option value="<?php echo $lista->getIdOcupacion(); ?>">
                                        <?php echo $lista->getOcupacion(); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="fecha" name="fecha"
                                value="<?php echo isset($this->persona) ? $this->persona->getFecha() : ''; ?>"
                                max="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success btn-submit px-4">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>

        <br>

        <div class="personas-listado">
            <div class="d-flex justify-content-between align-items-center boton-imprimir-pdf ocultar-impresion">
                <span class="fw-bold">Listado de personas</span>
                <button class="btn btn-secondary" onclick="window.print()">
                    Imprimir en formato PDF
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark table-striped">
                        <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Telefono</th>
                        <th>Sexo</th>
                        <th>Ocupacion</th>
                        <th>Fecha nacimiento</th>
                        <th colspan="2" class="text-center ocultar-impresion">Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->listaPersonas as $lista): ?>
                        <tr>
                            <td><?php echo $lista->getIdPersona(); ?></td>
                            <td><?php echo $lista->getNombre(); ?></td>
                            <td><?php echo $lista->getEdad(); ?></td>
                            <td><?php echo $lista->getTelefono(); ?></td>
                            <td><?php echo $lista->getSexo(); ?></td>
                            <td><?php echo $lista->getOcupacion()->getOcupacion(); ?></td>
                            <td><?php echo $lista->getFecha(); ?></td>

                            <td class="text-center ocultar-impresion">
                                <button onclick="alerta('<?php echo $lista->getIdPersona(); ?>')"
                                    class="btn btn-danger">Eliminar</button>
                            </td>

                            <td class="text-center ocultar-impresion">
                                <button onclick="modificar(
                                    '<?php echo $lista->getIdPersona(); ?>',
                                    '<?php echo $lista->getNombre(); ?>',
                                    '<?php echo $lista->getEdad(); ?>',
                                    '<?php echo $lista->getTelefono(); ?>',
                                    '<?php echo $lista->getSexo(); ?>',
                                    '<?php echo $lista->getOcupacion()->getIdOcupacion(); ?>',
                                    '<?php echo $lista->getFecha(); ?>'
                                )" class="btn btn-info">Modificar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <?php require "views/templates/modal.php"; ?>
    <?php require "views/templates/footer.php"; ?>
</body>

</html>