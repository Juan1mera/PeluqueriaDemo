<div class="barra">
    <p><?php echo $_SESSION['name'] ?></p>
    <a href="/logout">Cerrar Sesion</a>
</div>

<?php if(isset($_SESSION['admin'])){ ?>

    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Citas</a>
        <a class="boton" href="/servicios">Ver Servicios</a>
        <a class="boton" href="/servicios/crear">Crear Servicio</a>
    </div>

<?php } ?>