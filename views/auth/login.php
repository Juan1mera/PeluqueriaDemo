<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesion con tus datos</p>

<?php
//  debuguear($user); 
// debuguear($alertas);

include_once __DIR__ . "/../../templates/alertas.php"
 ?>
<form class="formulario" method="POST" action="/">

    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email" 
            name="email" 
            id="email" 
            placeholder="Tu email" 
        >
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Tu contraseña" >
    </div>
    <input type="submit" class="boton" value="Iniciar Sesion" />

</form>

<div class="acciones">
    <p>
        Aun no tienes una cuenta?
        <a href="/crear-cuenta">Crear Cuenta</a>
    </p>
    <p style="color: red; font-size: 1.2rem">Asegurate de que tu correo y numero de telefono sean correctos para poder contactarte</p>

    <!-- <p>
        ¿Olvidaste tu contraseña?
        <a href="/olvide">Olvide mi contraseña</a>
    </p> -->
</div>