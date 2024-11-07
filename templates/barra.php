<div class="barra">
    <p><?php echo $_SESSION['name'] ?></p>
    <a href="/logout">Cerrar Sesion</a>
</div>

<?php if(isset($_SESSION['admin'])){ ?>

    <div class="barra-servicios">
        <a class="barra_option" href="/admin">Citas</a>
        <a class="barra_option" href="/servicios">Servicios</a>
        <a class="barra_option" href="personas">Personas</a>
    </div>

<?php } ?>