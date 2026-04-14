<footer id="sticky-footer" class="flex-shrink-0 py-4 bg-secondary text-white-50">
    <div class="container text-center">
        <small style="color: white;">Copyright &copy; MVC</small>
    </div>
</footer>

<script src="<?php echo constant('URL'); ?>public/js/funcionesform.js"></script>

<script>
    function alerta(id) {
        var opcion = confirm("¿Estás seguro de que deseas eliminar esta persona?");
        if (opcion == true) {
            // Redirección al método eliminar del controlador
            location.href = '<?php echo constant('URL'); ?>Main/eliminarPersona/' + id;
        }
    }

    // Seteo de valores por defecto en los select/inputs (basado en el objeto persona)
    <?php if (isset($this->persona)): ?>
        document.getElementById('sexo').value = '<?php echo $this->persona->getSexo(); ?>';
        document.getElementById('ocupacion').value = '<?php echo $this->persona->getOcupacion()->getIdOcupacion(); ?>';
    <?php endif; ?>

    // Ocultar automáticamente el mensaje de éxito después de 5 segundos
    setTimeout(function() {
        var alert = document.querySelector('.alert-success');
        if (alert) {
            alert.classList.remove('show');
            setTimeout(function() { alert.style.display = 'none'; }, 150);
        }
    }, 5000);
</script>

