<?php // include_once __DIR__ . '/../../templates/barra.php'; ?>
<h1>Crear Compañero</h1>
<a class="link" href="/personas">Volver</a>

<br>
<br>
<br>

<form class="formulario" action="/personas/crear" method="POST">
    <?php
        include_once __DIR__ . '/formulario.php';
    ?>
    <input type="submit" class="boton" value="Crear Compañero" />
</form>