<?php
    include_once __DIR__ . '/../../templates/barra.php'
?>

<h1 class="nombre-pagina">Crear nueva cita</h1>

<div id="app">

    <a class="link" href="cita/citas">Ver Tus Proximas Citas </a>
    <a>|</a>
    <a class="link" href="cita/tcitas">Ver Todas tus Citas </a>

    <nav class="tabs">
        <button type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div id="paso-2" class="seccion">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Ingresa tus datos y fecha de tu cita</p>
        <form class="formulario">
            <div class="campo"> 
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" placeholder="Tu nombre"  value="<?php echo $name; ?>" disabled>
            </div>
            <div class="campo">
                <label for="empleado">Empleado</label>
                <select name="empleado" id="empleado">
                    <option value="" disabled selected>Con quien quieres agendar tu cita</option>
                </select>
            </div>
            <div class="campo"> 
                <label for="fecha">Fecha</label>
                <input 
                    type="date" 
                    name="fecha" 
                    id="fecha"
                    min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" 
                >
            </div>
            <div class="campo"> 
                <label for="hora">Hora</label>
                <input 
                    type="time" 
                    name="hora" 
                    id="hora"
                    min="09:00"
                    max="17:00"
                >
            </div>
            <input type="hidden" id="id" value="<?php echo $id ?>" />
        </form>
    </div>

    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">verifica que la informacion sea correcta</p>
        <div id ="resumen" class="resumen"></div>
        <div id="servicios-resumen" class="listado-servicios"></div>
    </div>

    <div class="paginacion">
        <button 
            id="anterior"
            class="boton"    
        > &laquo; Anterior</button>
        <button 
            id="siguiente"
            class="boton"    
        > Siguiente &raquo;</button>

    </div>

</div>

<?php 
    $script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='/build/js/app.js'></script>
    "
?>