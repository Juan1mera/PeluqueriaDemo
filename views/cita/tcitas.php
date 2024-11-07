<?php
    include_once __DIR__ . '/../../templates/barra.php';
?>
<br><br><br>
<h1>Todas tus citas</h1>
<a class="link" href="/cita">Volver a citas</a>

<?php
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
                    <p>Fecha: <span> <?php echo date("d-m-Y", strtotime($cita->fecha)); ?> </span></p>
                    <p>Hora Inicio: <span> <?php echo $cita->hora; ?> </span></p>
                    <p>Hora Final: <span> <?php echo $cita->hora_fin; ?> </span></p>
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

                <?php } 
        endforeach;
    ?>
        </li> 

    </ul>
</div>

<?php
    $script = "<script src='build/js/buscador.js'></script>";
?>
