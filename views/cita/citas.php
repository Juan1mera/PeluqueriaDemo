<?php
    include_once __DIR__ . '/../../templates/barra.php';
?>
<br><br><br>
<h1>Tus proximas citas</h1>
<a class="link" href="/cita">Volver a citas</a>

<?php
    // Obtener la fecha actual
    $fechaActual = date("Y-m-d");

    // Filtrar las citas que tienen una fecha posterior a la actual
    $citasFuturas = array_filter($citas, function($cita) use ($fechaActual) {
        return $cita->fecha > $fechaActual;
    });

    if (count($citasFuturas) === 0) {
        echo "<h3>No hay citas futuras para mostrar</h3>"; 
    }
?>

<div id="citas_admin">
    <ul class="citas">
    <?php 
        foreach ($citasFuturas as $cita): ?>
            <li style="margin-bottom: -6rem;">
                <p>Fecha: <span><?php echo date("d-m-Y", strtotime($cita->fecha)); ?></span></p>
                <p>Hora de Inicio: <span><?php echo date("H:i", strtotime($cita->hora)); ?></span></p>
                <p>Hora de Fin: <span><?php echo date("H:i", strtotime($cita->hora_fin)); ?></span></p>
            </li>
            <form action="/api/eliminar" method="POST">
                <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                <input type="submit" class="boton-eliminar" value="Eliminar" />

            </form>
    <?php endforeach; ?>
    </ul>
</div>

<?php
    $script = "<script src='build/js/buscador.js'></script>";
?>
