<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar persona</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form role="form" id="formactualiza" action="<?php echo constant('URL'); ?>Main/agregarPersona" method="POST" onsubmit="return confirm('¿Está seguro de agregar a esta persona a la base de datos?');">
                    <div class="row g-3">
                        <input type="hidden" name="id" id="idpersona">
                        <div class="col-md-6">
                            <label for="nombre">Ingrese el nombre de la persona:</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Ingresa el nombre"
                                oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');"
                                title="Solo se permiten letras" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edad">Ingrese la edad de la persona:</label>
                            <input type="number" class="form-control" name="edad" placeholder="Ingresa la edad"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                min="18" max="99" title="Debe tener entre 18 y 99 años" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono">Ingrese el teléfono de la persona:</label>
                            <input type="tel" class="form-control" name="telefono" placeholder="Ej: 7123-4567"
                                oninput="this.value = this.value.replace(/[^0-9\-]/g, '');"
                                pattern="[267][0-9]{3}-[0-9]{4}"
                                title="Formato: 0000-0000 iniciando con 2, 6 o 7" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sexo">Ingrese el sexo de la persona:</label>
                            <select name="sexo" class="form-control" required>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ocupacion">Ingrese la ocupación de la persona:</label>
                            <select name="ocupacion" class="form-control" required>
                                <?php foreach ($this->listaOcupaciones2 as $lista): ?>
                                    <option value="<?php echo $lista->getIdOcupacion(); ?>"><?php echo $lista->getOcupacion(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha">Ingrese la fecha de nacimiento:</label>
                            <input type="date" class="form-control" name="fecha"
                                max="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <input type="submit" name="submit" class="btn btn-success" form="formactualiza" value="Enviar">
            </div>
        </div>
    </div>
</div>