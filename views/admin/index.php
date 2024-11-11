
<?php
    include_once __DIR__ . '/../../templates/barra.php'
?>

<h2>Buscar citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input 
                type="date"
                id="fecha"
                name="fecha"
                value="<?php echo $fecha; ?>"
            />
        </div>
    </form>
</div>

<?php 

    if (count($citas) === 0) {
        echo "<h3>No hay citas para hoy</h3>"; 
    }

?>

<div id="citas_admin">
    <ul class="citas">
    <?php 
        $idCita = 0;
        $totalCitas = count($citas);
        
        foreach($citas as $key => $cita):
            if($idCita !== $cita->id){
                $total = 0;
    ?>
                <li>
                    <p>Hora: <span> <?php echo $cita->hora; ?> </span></p>
                    <p>Hora Final Aprox: <span> <?php echo $cita->hora_fin; ?> </span></p>
                    <p>Cliente: <span> <?php echo $cita->cliente; ?> </span></p>
                    <p>Email: <span> <?php echo $cita->email; ?> </span></p>
                    <p>Telefono: <span> <?php echo $cita->telefono; ?> </span></p>
                    <p>Con: <span> <?php echo $cita->empleado; ?> </span></p>
                    <h3>Servicios</h3>
                <?php 
                $idCita = $cita->id;
            }   
            ?>
        <p class="servicio"><?php echo $cita->servicio . ' - ' . number_format($cita->precio, 0, ',', '.'); ?></p>  
            <?php 
                $total += $cita->precio;
                $proximo = $key + 1 < $totalCitas ? $citas[$key+1]->id : null;
                if($proximo !== $cita->id){ ?>
                    <p class="total">Total: <span><?php echo number_format($total, 0, ',', '.'); ?></span></p>
                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                        <input type="submit" class="boton-eliminar" value="Eliminar" />
                    </form>
                <?php } 
        endforeach;
    ?>
        </li> 

    </ul>
</div>


<?php

    $script = "<script src='/build/js/buscador.js'></script>";

?>