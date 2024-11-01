
<?php
    include_once __DIR__ . '/../../templates/barra.php'
?>
<br>
<br>
<br>
<h1>Admin</h1>

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
                    <p>ID: <span> <?php echo $cita->id; ?> </span></p>
                    <p>Fecha: <span> <?php echo $cita->hora; ?> </span></p>
                    <p>Cliente: <span> <?php echo $cita->cliente; ?> </span></p>
                    <p>Email: <span> <?php echo $cita->email; ?> </span></p>
                    <p>Telefono: <span> <?php echo $cita->telefono; ?> </span></p>
                    <h3>Servicios</h3>
                <?php 
                $idCita = $cita->id;
            }   
            ?>
        <p class="servicio"><?php echo $cita->servicio . ' - ' . $cita->precio; ?></p>
            
            <?php 
                $total += $cita->precio;
                $proximo = $key + 1 < $totalCitas ? $citas[$key+1]->id : null;
                if($proximo !== $cita->id){ ?>
                    <p class="total">Total: <span><?php echo $total; ?></span></p>
                <?php } 
        endforeach;
    ?>
        </li> 

    </ul>
</div>


