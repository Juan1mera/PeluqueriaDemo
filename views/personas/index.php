
<?php include_once __DIR__ . '/../../templates/barra.php'; ?>
<h1 class="nombre-pagina">Compañeros</h1>
<a class="link" href="/personas/crear">Crear Compañero</a>
<ul class="servicios">
    <?php foreach($personas as $servicio){ ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
            <div class="acciones">
                <form action="/personas/borrar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                    <input type="submit" class="boton-eliminar" value="Eliminar">
                </form>
            </div>
        </li>
    <?php } ?>
</ul>