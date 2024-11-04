
<?php 
    // include_once __DIR__ . '/../../templates/barra.php';
    include_once __DIR__ . '/../../templates/alertas.php';
?>

<h1 class="nombre-pagina">Crear Servicio</h1>
<p class="descripcion-pagina">Rellena los campos</p>

<form class="formulario" action="/servicios/crear" method="POST">
    <?php
        include_once __DIR__ . '/formulario.php';
    ?>
    <input type="submit" class="boton" value="Crear Servicio" />
</form>